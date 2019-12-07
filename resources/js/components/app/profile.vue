<template>
<div>

  <!-- <div id="profile__trigger">
    <button class="button--small button--cta" @click="updateProfile(profile.id)">Save</button>
  </div> -->

  <!-- <div id="navigation"> -->

    <!-- <div
      id="dashboard__trigger"
      class="ic arrow-left"
    ><a href="/cms/dashboard"></a></div>

     <div class="flex__filler"></div>



  </div> -->

  <!-- <keep-alive>
    <intdashboard
      id="dashboard"
      v-bind:class="{'is-hidden': isHidden.dashboard }"
      :profile="true"
      @dashboardHide="toggle('dashboard')"
    ></intdashboard>
  </keep-alive> -->


  <div id="profile">
    <div id="profile__controls">

      <button
        class="button--small button--cta"
        v-on:click="updateProfile()">
      Save</button>

      <div class="flex__filler"></div>
    <div
      id="dashboard__logout"
      v-on:click="logout()"
      class="ic logout"
    ></div>
  </div>
    <div id="profile__settings" class="block">

      <div
        id="profile__image"
        class="upload__droparea"
        v-on:dragover.prevent
        v-on:drop="onDrop"
      >

      <label>Profile Image</label>

      <!-- <div
        v-if="profile.image != null"
        @click="isHidden.editProfileImage = false"
        class="background__image"
        v-bind:style="{ backgroundImage: 'url(' + profile.image.small.file + ')'}"
      ></div> -->

      <img
        v-if="profile.image != null"
        @click="isHidden.editProfileImage = false"
        :srcset="`
          ${ profile.image.small.file } ${ profile.image.small.size }w,
          ${ profile.image.medium.file } ${ profile.image.medium.size }w,
          ${ profile.image.large.file } ${ profile.image.large.size }w,
          ${ profile.image.full.file } ${ profile.image.full.size }w
        `"
        :src="profile.image.medium.file"
      >

      <div
        class="ic loading"
        v-if="isLoading.upload == true"
      ></div>

      <div
        v-if="profile.image == null && isLoading.upload == false"
        class="ic upload file__upload is--large"
      >
        <input type="file" name="file" accept="image/*" ref="imageUpload" v-on:change="uploadImage()"/>
        <input type="hidden" v-model="profile.image" >
      </div>

      <!-- v-if="project.image == null && isLoading.upload == false" -->
      <div
        class="upload__droparea__controls"
        v-if="profile.image !== null"
        v-bind:class="{'is-hidden': isHidden.editProfileImage }"
      >
        <div
          class="ic__editor upload file__upload"
        >
          <input type="file" name="file" accept="image/*" ref="imageChange" v-on:change="changeImage()"/>
          <input type="hidden" v-model="profile.image" >
        </div>
        <div class="ic__editor delete" @click="toggle('deleteProfileImage')"></div>
        <div class="triangle"></div>
        <div class="modal__close" v-on:click="isHidden.editProfileImage = true"></div>
      </div>

    </div>

      <!-- <div id="profile__image" >

        <label
          v-if="profile.image == null"
          for="file"
        >Profile Image</label>

        <div
          class="ic loading"
          v-if="isLoading.upload == true"
        ></div>

          <div
            v-if="profile.image != null"
            class="background__image"
            v-bind:style="{ backgroundImage: 'url(' + profile.image.small.file + ')'}"
          ></div>

        <div
          class="file__delete"
          v-if="profile.image != null"
        >
          <div class="ic trash" @click="deleteImage()"></div>
        </div>

        <div
          class="upload__droparea"
          v-if="profile.image == null && isLoading.upload == false"
          v-on:dragover.prevent
          v-on:drop="onDrop"
        >
          <div class="ic upload file__upload is--large">
            <input type="file" name="file" accept="image/*" ref="image" v-on:change="uploadImage()"/>
          </div>
        </div>
      </div> -->


<!--

      <div id="profile__image">
        <label v-if="profile.image == null" for="file">Your Image</label>

        <div class="ic loading" v-if="isLoading.upload == true" ></div>

        <figure
          v-if="profile.image !== null"
        >
          <img
            :srcset="profile.image.srcset"
            :src="profile.image.fallback"
          >
        </figure>

        <div class="file__delete">
          <div class="ic__editor delete" v-if="profile.image != null" v-on:click="deleteImage()"></div>
        </div>
         <div v-if="profile.image == null && isLoading.upload == false" class="file__upload ic upload">
          <input type="file" name="file" accept="image/*" ref="image" v-on:change="uploadImage()"/>
          <input type="hidden" v-model="profile.image" >
        </div>
      </div> -->



      <div class="form__group">
        <div class="form__item">
          <label for="public_name">Your Name</label>
          <input name="name" type="text" v-model="profile.name" placeholder="Public Name">
        </div>
      </div>
      <div class="form__group">
        <div class="form__item">
          <label for="email">Email (Login)</label>
          <input name="email" type="text" v-model="profile.email" placeholder="email">
        </div>
      </div>
      <div class="form__group">
        <div class="form__item">
          <label for="description">Short Biography</label>
          <div
            class="textarea"
            contenteditable="true"
            ref="profileDescription"
            @input="save = false"
          >{{ profile.description }}</div>
          <span v-if="profile.description != null" class="is-small counter">{{ (profile.description).length }} / 170 chars</span>
        </div>
      </div>

    </div>


    <div id="profile__social" class="block">

      <div class="profile__description">
        <h4>Social Media</h4>
      </div>

      <div v-for="(item, index) in profile.social" class="form__group">
        <div class="form__item">
          <label>{{ item.provider }}</label>
          <input :name="item.provider" type="text" v-model="item.url">
        </div>
        <div class="form__item --maxwith34">
          <label>&nbsp;</label>
          <div class="ic delete" @click="removeSocial(index)"></div>
        </div>
      </div>

      <div class="form__group --top-margin-mid">
        <div class="form__item --maxwidth144">
          <select ref="socialProvider">
            <option disabled>Select a Provider</option>
            <option v-for="(item, index) in social" :value="item">{{ item }}</option>
          </select>
        </div>
        <div class="form__item">
          <button class="button--small" @click="addSocial()">Add Channel</button>
        </div>
      </div>

  </div>

<!--
    <div id="profile__social" class="block">

      <h4>Social</h4>

      <div id="profile__description">
        <span>Add your Social Media Usernames. We'll add the links</span>
      </div>


      <div>
        <label for="facebook">Facebook</label>
        <input name="facebook" type="text" v-model="profile.facebook" placeholder="facebook">
      </div>


      <div>
        <label for="instagram">Instagram</label>
        <input name="instagram" type="text" v-model="profile.instagram" placeholder="instagram">
      </div>
      <div>
        <label for="twitter">Twitter</label>
        <input name="twitter" type="text" v-model="profile.twitter" placeholder="twitter">
      </div>
      <div>
        <label for="youtube">Youtube</label>
        <input name="youtube" type="text" v-model="profile.youtube" placeholder="youtube">
      </div>
      <div>
        <label for="linkedin">LinkedIn</label>
        <input name="linkedin" type="text" v-model="profile.linkedin" placeholder="linkedin">
      </div>
      <div>
        <label for="xing">Xing</label>
        <input name="xing" type="text" v-model="profile.xing" placeholder="xing">
      </div>

    </div>
 -->


    <!-- <div id="profile__login" class="block">

      <h4>Login</h4>

      <div id="profile__description">
        <span>Your login name. You should keep it secret</span>
      </div>

      <div>
        <label for="username">Username</label>
        <input name="username" type="text" v-model="profile.name" placeholder="username">
      </div>

    </div> -->


    <div id="profile__password" class="block">

      <div class="profile__description">
        <h4>Change your Password</h4>
      </div>


    <div class="form__group">
      <div class="form__item">
        <label for="password">Password</label>
        <input type="password" ref="oldPassword" value="123456">
      </div>
    </div>
    <div class="form__group">
      <div class="form__item">
        <label for="password">New Password</label>
        <input type="password" ref="newPassword">
      </div>
    </div>
    <div class="form__group">
      <div class="form__item">
        <label for="password_confirmation">Confirm</label>
        <input @input="passwordMatch()" type="password" ref="passwordConfirm">
      </div>
    </div>

    <div class="password__controls">
      <button class="button--small" @click="updatePassword(profile.id)">Change Password</button>
    </div>


    <div id="message" v-if="message" >
      <span class="message">{{ message }}</span>
      <div @click="message = ''" class="ic close"></div>
    </div>

    </div>

</div>

<intdialogue
  v-bind:class="{'is-hidden': isHidden.deleteProfileImage }"
  dialogue-title="Delete your Image"
  dialogue-content="You cannot undo this"
  dialogue-cancel-text="Cancel"
  dialogue-cancel-class="button--cta"
  dialogue-confirm-text="Delete Image"
  dialogue-confirm-class="n"
  @dialogue-cancel="toggle('deleteImage')"
  @dialogue-confirm="deleteImage(), toggle('deleteImage')" />
</intdialogue>

</div>
</template>

<script>
let initialTimer;

import dashboard from './dashboard.vue'

export default {
  props: ['saveProfile'],
  data() {
    return {
      isHidden: {
        dashboard: true,
        editProfileImage: true,
        deleteProfileImage: true,
      },
      profile: {
        role: {},
      },
      isLoading: {
        upload: false,
      },
      roles: {},
      social: [
        'facebook', 'twitter', 'instagram', 'linkedin', 'xing', 'youtube'
      ],
      message: '',
      apiToken: window.Laravel.api_token,
      user: window.Laravel.user,
      csrf: window.Laravel.csrfToken
    }
  },

  watch: {
    'saveProfile': function(newVal, oldVal) {
      console.log(newVal);
      if(newVal) {
        this.updateProfile();
      }
    },
    'message': function(elem) {
        let self = this;
        if (initialTimer) {
          clearTimeout(initialTimer);
        }
        initialTimer = setTimeout(function () {
          self.message = '';
        }, 4000);
    },
    'profile.image': function(elem) {
      this.isLoading.upload = false;
    },
  },
  methods: {

    getProfile() {
      axios
        .get('/api/profile')
        .then((response) => {
          this.profile = response.data.data[0],
          this.profile.image = JSON.parse(this.profile.image),
          this.profile.social = JSON.parse(this.profile.social)

        })
    },
    updateProfile() {
      axios
        .patch('/api/profile/' + this.profile.id, {
          name: this.profile.name,
          description: this.$refs.profileDescription.innerText,
          email: this.profile.email,
          social: JSON.stringify(this.profile.social),
          facebook: this.profile.facebook,
          instagram: this.profile.instagram,
          twitter: this.profile.twitter,
          youtube: this.profile.youtube,
          linkedin: this.profile.linkedin,
          xing: this.profile.xing
        })
        .then((response) => {
          this.message = response.data.message,
          this.getProfile()
        })
    },
    updatePassword($userId) {
      axios
        .post('/api/profile/' + $userId, {
          password: this.$refs.newPassword.value,
          password_confirmation: this.$refs.passwordConfirm.value,
          old_password: this.$refs.oldPassword.value
        })
        .then((response) => {
          this.message = response.data.message,
          this.getProfile()
        })
    },
    onDrop: function(e) {
      e.stopPropagation();
      e.preventDefault();
      let data = new FormData();
      let file = e.dataTransfer.files[0];
      data.append('image', file, file.filename);
      axios
        .post('/api/upload/profile/' + this.profile.id, data)
        .then((response) => {
          this.profile.image = JSON.parse(response.data)

        })
        this.isLoading.upload = true;
    },
    uploadImage() {
      let data = new FormData();
      let file = this.$refs.imageUpload.files[0];
      data.append('image', file, file.filename);
      axios
        .post('/api/upload/profile/' + this.profile.id, data)
        .then((response) => {
          this.profile.image = JSON.parse(response.data)
          this.message = response.data.message
        })
        this.isLoading.upload = true;
    },
    changeImage() {
      this.deleteImage();
      let data = new FormData();
      let file = this.$refs.imageChange.files[0];
      data.append('image', file, file.filename);
      axios
        .post('/api/upload/profile/' + this.profile.id, data)
        .then((response) => {
          this.profile.image = JSON.parse(response.data),
          this.message = response.data.message
        })
        this.isLoading.upload = true;
    },
    deleteImage() {
      axios
        .patch('/api/upload/profile/' + this.profile.id, {
          image: JSON.stringify(this.profile.image)
        })
        .then((response) => {
          this.message = response.data.message,
          this.profile.image = null
        })
    },
    passwordMatch() {
      let pass = this.$refs.newPassword.value;
      let passConfirm = this.$refs.passwordConfirm.value;
      if(pass == passConfirm) {
        this.message = 'Password Match'
      }
    },
    logout() {
      axios
      .post('/logout')
      .then(window.location.replace("http://localhost:8000"));
    },
    toggle: function (elem) {
      if(this.isHidden[elem] == false) {
        this.isHidden[elem] = true
      } else {
        this.isHidden = Object.assign({}, this.isHidden, { editProfileImage: true, deleteProfileImage: true, dashboard: true }),
        this.isHidden[elem] = false
      }
    },
    addSocial() {
      if(this.profile.social == null) {
        this.profile.social = [];
      }
      let provider = this.$refs.socialProvider;
      this.profile.social.push({'provider': provider.value, 'url': ''});
    },
    removeSocial(index) {
      this.profile.social.splice(index, 1);
    },
  },
  created () {
    this.getProfile()
  }
}
</script>
