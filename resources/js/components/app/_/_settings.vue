<template>
  <div>



    <!-- <div id="navigation">

      <div
        id="dashboard__trigger"
        class="ic arrow-left"
      ><a href="/cms/dashboard"></a></div>

       <div class="flex__filler"></div>



    </div> -->

    <!-- <keep-alive>
      <intdashboard
        id="dashboard"
        v-bind:class="{'is-hidden': isHidden.dashboard }"
        @dashboardHide="toggle('dashboard')"
      ></intdashboard>
    </keep-alive> -->


  <div id="settings">

    <div
      id="settings__image"
      class="upload__droparea"
      v-on:dragover.prevent
      v-on:drop="onDrop"
    >

    <label
      v-if="settings.image == null"
    >Website Logo</label>

    <img
      v-if="settings.image != null"
      @click="isHidden.editSettingsImage = false"
      :src="settings.image.medium.file"
    >

    <div
      class="ic loading"
      v-if="isLoading.upload == true"
    ></div>

    <div
      v-if="settings.image == null && isLoading.upload == false"
      class="ic upload file__upload is--large"
    >
      <input type="file" name="file" accept="image/*" ref="imageUpload" v-on:change="uploadImage()"/>
      <input type="hidden" v-model="settings.image" >
    </div>

    <!-- v-if="project.image == null && isLoading.upload == false" -->
    <div
      class="upload__droparea__controls"
      v-if="settings.image !== null"
      v-bind:class="{'is-hidden': isHidden.editSettingsImage }"
    >
      <div
        class="ic__editor upload file__upload"
      >
        <input type="file" name="file" accept="image/*" ref="imageChange" v-on:change="changeImage()"/>
        <input type="hidden" v-model="settings.image" >
      </div>
      <div class="ic__editor delete" @click="toggle('deleteSettingsImage')"></div>
    </div>

  </div>

    <!-- <div
      id="settings__image"
    >

      <label
        v-if="settings.image == null"
        for="file"
      >Logo</label>

      <div
        class="ic loading"
        v-if="isLoading.upload == true"
      ></div>

      <img
        v-if="settings.image != null"
        :src="settings.image.medium.file"
      >

      <div
        class="file__delete"
        v-if="settings.image != null"
      >
        <div class="ic trash" @click="deleteImage()"></div>
      </div>

      <div
        class="upload__droparea"
        v-if="settings.image == null && isLoading.upload == false"
        v-on:dragover.prevent
        v-on:drop="onDrop"
      >
        <div class="ic upload file__upload is--large">
          <input type="file" name="file" accept="image/*" ref="image" v-on:change="uploadImage()"/>
        </div>
      </div>
    </div> -->

    <!-- <div id="settings__trigger">
      <button class="button--small button--cta" type="submit" v-on:click="updateSettings()">Save</button>
    </div> -->
    <div id="settings__title">
      <!-- <h1>Settings</h1> -->
    </div>

    <div id="settings__website" class="block">
      <h3>Site</h3>

      <div class="settings__description">
        <span>Add a site Title and a description. If you search for your site on google, this is what you will see</span>
      </div>

      <div>
        <label for="title">Site Name</label>
        <input
          type="text"
          v-model="settings.title"
          @input="save = false"
        >
      </div>

    <div>
      <label for="url">Your Domain</label>
      <input name="url" type="text" v-model="settings.url" placeholder="https://yourdomain.com">
    </div>

  </div>

    <div id="settings__seo" class="block">
      <h3>SEO</h3>

      <div class="settings__description">
        <span>Add a site Title and a description. If you search for your site on google, this is what you will see</span>
      </div>

      <div>
        <label for="title">Title</label>
        <div
          class="textarea"
          contenteditable="true"
          ref="settingsSubtitle"
          @input="save = false"
        >{{ settings.subtitle }}</div>
        <!-- <span v-if="settings.subtitle != ''" class="is-small counter">{{ (settings.subtitle).length }} / 70 chars</span> -->
      </div>

      <div>
        <label for="description">Description</label>
        <div
          class="textarea"
          contenteditable="true"
          ref="settingsDescription"
          @input="save = false"
        >{{ settings.description }}</div>
        <!-- <span v-if="settings.description != null" class="is-small counter">{{ (settings.description).length }} / 170 chars</span> -->
    </div>

  </div>

    <div id="settings__contact" class="block">
      <h3>Contact</h3>

      <div class="settings__description">
        <span>Add your contact details. So your costumer can find you</span>
      </div>

      <div>
        <label for="owner">Owner Name</label>
        <input name="owner" type="text" v-model="settings.owner" placeholder="First and Last Name">
      </div>
      <div class="form__group">
        <div class="form__item">
          <label for="phone">Phone</label>
          <input name="phone" type="text" v-model="settings.phone" placeholder="Phone">
        </div>
        <div class="form__item">
          <label for="email">E-mail</label>
          <input name="email" type="text" v-model="settings.email" placeholder="E-mail">
        </div>
      </div>
      <div class="form__group">
        <div class="form__item">
          <label for="street">Street</label>
          <input name="street" type="text" v-model="settings.street" placeholder="Street">
        </div>
      </div>
      <div class="form__group">
        <div class="form__item">
          <label for="post">Post Code</label>
          <input name="post" type="text" v-model="settings.post" placeholder="Post Code">
        </div>
        <div class="form__item">
          <label for="twitter">City</label>
          <input name="city" type="text" v-model="settings.city" placeholder="City">
        </div>
        <div class="form__item">
          <label for="country">Country</label>
          <input name="country" type="text" v-model="settings.country" placeholder="Country">
        </div>
      </div>
    </div>

      <div id="settings__social" class="block">
        <h3>Social Media</h3>

        <div class="settings__description">
          <span>Add your Social Media usernames. We'll add the links</span>
        </div>

        <div class="form__group">
          <div class="form__item">
            <select ref="socialProvider">
              <option disabled>Select a Provider</option>
              <option v-for="(item, index) in social" :value="item">{{ item }}</option>
            </select>
          </div>
          <div class="form__item">
            <button class="button--small" @click="addSocial()">Add</button>
          </div>
        </div>
        <div
          v-for="(item, index) in settings.social"
          class="form__group"
        >
          <div class="form__item">
            <label>{{ item.provider }}</label>
            <input :name="item.provider" type="text" v-model="item.url">
          </div>
          <div class="form__item">
            <label>&nbsp;</label>
            <div class="ic trash" @click="removeSocial(index)"></div>
          </div>
        </div>



    </div>

    <div id="settings__users"  class="block">

      <h3>User Settings</h3>

      <div class="settings__description">
        <span>Here you can manage the Users. You can't delete a user having published Stories.
          <!-- 'Admin' can do just anything</br>
          'Editor' may do the same as the Admin, but he cannot remove users</br>
          'Author' may write and publish articles</br>
          'Contributor' may write Drafts, but he is not allowed to publish. So he needs some help from the Editor or Admin -->
      </span>
      </div>

      <div
        class="user__content"
        v-for="(activeUser, index) in users">

        <div  class="user__name">
          <h6>{{ activeUser.name }}</h6>
        </div>

        <div class="flex__filler"></div>

        <div class="user__role">
          <select v-model="activeUser.role_id" @change="updateUser(activeUser.id, index)">
            <option disabled>Select a Role</option>
            <option v-for="(role, index) in roles" :value="role.id">{{ role.name }}</option>
          </select>
        </div>

        <div class="flex__filler"></div>

        <div
          v-if="activeUser.role_id != 1"
          class="user__controls">
          <div
            @click="deleteUserDialogue(activeUser.id)"
            class="ic trash">
          </div>
        </div>

      </div>

      <div class="user__register">
        <button class="button--small" @click="toggle('userRegister')">Register a new User</button>
      </div>

    </div>


<!--
    <div id="settings__backup"  class="block">

      <h3>Backup</h3>

      <div class="settings__description">
        <span>
          Download your Database from time to time. I case you got hacked, you can upload it to your ftp.
        </span>
      </div>

      <div class="backup__download">
        <button class="button--small" @click="">Download</button>
      </div>

    </div> -->

        <div
        id="settings__register"
        class="dialogue"
        v-bind:class="{'is-hidden': isHidden.userRegister }"
        >
          <div class="dialogue__header">

            <h3>Register a new User</h3>
            <div class="settings__description">
              <span>Here you can register a new user. You can give him a Role as 'Author' for example after you have added her or him</span>
            </div>

          </div>

          <div class="dialogue__body">

                  <div>
                    <label for="name">Name</label>
                    <input type="text" name="name" v-model="register.name" placeholder="Name">
                  </div>

                  <div>
                    <label>E-mail</label>
                    <input type="email" name="email" v-model="register.email" placeholder="New Users Email">
                  </div>

                  <div>
                    <label>Password</label>
                    <input type="password" name="password" ref="newPassword" @input="passwordMatch()" v-model="register.password" value="123456">
                  </div>

                  <div>
                    <label for="password-confirm">Confirm Password</label>
                    <input type="password" name="password_confirmation" ref="passwordConfirm" v-model="register.password_confirmation" value="123456">
                  </div>
                </div>

                <div class="dialogue__footer">
                  <button class="button--small" @click="toggle('userRegister')">Cancel</button>
                  <button class="button--small button--cta" @click="userRegister()">Register</button>
                </div>

      </div>

  </div>

  <div id="message" v-if="message" >
    <span class="message">{{ message }}</span>
    <div @click="message = ''" class="ic close"></div>
  </div>

  <intdialogue
    v-bind:class="{'is-hidden': isHidden.userDelete }"
    dialogue-title="Delete User"
    dialogue-content="You cannot undo this!"
    dialogue-cancel-text="Cancel"
    dialogue-confirm-text="Delete"
    @dialogue-cancel="toggle('userDelete')"
    dialogue-cancel-class="button--cta"
    @dialogue-confirm="deleteUser(dialogue.id)"
    dialogue-confirm-class="n" />
  </intdialogue>

  <intdialogue
    v-bind:class="{'is-hidden': isHidden.deleteSettingsImage }"
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
  props: ['saveSettings'],
  data() {
    return {
      isHidden: {
        userDelete: true,
        userRegister: true,
        editSettingsImage: true,
        deleteSettingsImage: true,
        dashboard: true
      },
      isLoading: {
        upload: false,
      },
      dialogue: {
        id: '',
      },
      message: '',
      register: {},
      social: [
        'facebook', 'twitter', 'instagram', 'linkedin', 'xing', 'youtube'
      ],
      settings: {
        title: '',
        description: ''
      },
      users: {},
      roles: {},
      apiToken: window.Laravel.api_token,
      user: window.Laravel.user,
      csrf: window.Laravel.csrfToken
    }
  },



  watch: {
    'saveSettings': function(newVal, oldVal) {
      if(newVal) {
        this.updateSettings();
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
    'settings.image': function(elem) {
      this.isLoading.upload = false;
    },
  },
  methods: {
    getSettings() {
      axios
        .get('/api/settings')
        .then((response) => {
          this.settings = response.data.data[0],
          this.settings.image = JSON.parse(response.data.data[0].image),
          this.settings.social = JSON.parse(response.data.data[0].social)
        })
    },
    getUsers() {
      axios
        .get('/api/users')
        .then(response => (this.users = response.data.data))
    },
    getRoles() {
      axios
        .get('/api/roles')
        .then(response => (this.roles = response.data.data))
    },
    updateSettings() {
      axios
        .patch('/api/settings/' + this.settings.id, {
          url: this.settings.url,
          title: this.settings.title,
          subtitle: this.$refs.settingsSubtitle.innerText,
          description: this.$refs.settingsDescription.innerText,
          owner: this.settings.owner,
          email: this.settings.email,
          phone: this.settings.phone,
          street: this.settings.street,
          city: this.settings.city,
          post: this.settings.post,
          country: this.settings.country,
          social: JSON.stringify(this.settings.social),
          facebook: this.settings.facebook,
          instagram: this.settings.instagram,
          twitter: this.settings.twitter,
          youtube: this.settings.youtube,
          linkedin: this.settings.linkedin,
          xing: this.settings.xing
        })
        .then((response) => {
          this.message = response.data.message,
          this.getSettings()
        })
    },
    updateUser($userId, index) {
      axios
        .patch('/api/users/' + $userId, {
          role_id: this.users[index].role_id
        })
        .then((response) => {
          this.message = response.data.message,
          this.getUsers()
        })
    },
    deleteUser($userId) {
      axios
        .delete('/api/users/' + $userId)
        .then((response) => {
          this.message = response.data.message,
          this.isHidden.userDelete = true,
          this.getUsers()
        })
    },
    userRegister() {
      axios
        .post('/api/settings/register/', {
          name: this.register.name,
          email: this.register.email,
          password: this.register.password,
          password_confirmation: this.register.password_confirmation,
        })
        .then(
          this.isHidden.userRegister = true,
          this.getUsers()
        )
    },
    passwordMatch() {
      console.log(this.$refs.newPassword.value);
      let pass = this.$refs.newPassword.value;
      let passConfirm = this.$refs.passwordConfirm.value;
      if(pass == passConfirm) {
        this.message = 'Password Match'
      }
    },
    deleteUserDialogue(id) {
      this.dialogue.id = id;
      this.isHidden.userDelete = false;
    },
    onDrop: function(e) {
      e.stopPropagation();
      e.preventDefault();
      let data = new FormData();
      let file = e.dataTransfer.files[0];
      data.append('image', file, file.filename);
      axios
        .post('/api/upload/settings/' + this.settings.id, data)
        .then((response) => {
          this.settings.image = JSON.parse(response.data)
        })
        this.isLoading.upload = true;
    },
    uploadImage() {
      let data = new FormData();
      let file = this.$refs.imageUpload.files[0];
      // console.log(this.$refs.imageUpload);
      data.append('image', file, file.filename);
      axios
        .post('/api/upload/settings/logo/' + this.settings.id, data)
        .then((response) => {
          this.settings.image = JSON.parse(response.data)
          this.message = response.data.message
        })
        this.isLoading.upload = true;
    },
    uploadFavicon() {
      let data = new FormData();
      let file = this.$refs.faviconUpload.files[0];
      // console.log(this.$refs.imageUpload);
      data.append('image', file, file.filename);
      axios
        .post('/api/upload/settings/favicon/' + this.settings.id, data)
        // .then((response) => {
        //   this.settings.image = JSON.parse(response.data)
        //   this.message = response.data.message
        // })
        this.isLoading.upload = true;
    },
    changeImage() {
      this.deleteImage();
      let data = new FormData();
      let file = this.$refs.imageChange.files[0];
      data.append('image', file, file.filename);
      axios
        .post('/api/upload/settings/logo/' + this.settings.id, data)
        .then((response) => {
          this.settings.image = JSON.parse(response.data),
          this.message = response.data.message
        })
        this.isLoading.upload = true;
    },
    deleteImage() {
      axios
        .patch('/api/upload/settings/logo/' + this.settings.id, {
          image: JSON.stringify(this.settings.image)
        })
        .then((response) => {
          this.message = response.data.message,
          this.settings.image = null
        })
    },
    toggle(elem) {
      if(this.isHidden[elem] == false) {
        this.isHidden[elem] = true
      } else {
        this.isHidden = Object.assign({}, this.isHidden, { deleteSettingsImage: true, userDelete: true, userRegister: true, dashboard: true, settings: true }),
        this.isHidden[elem] = false
      }
    },
    addSocial() {
      if(this.settings.social == null) {
        this.settings.social = [];
      }
      // let name = this.$refs.socialName;
      let provider = this.$refs.socialProvider;
      this.settings.social.push({'provider': provider.value, 'url': ''});
      // name.value = '';
      // console.log(this.settings.social);
    },
    removeSocial(index) {
      this.settings.social.splice(index, 1);
    },
  },
  created () {
    this.getUsers()
    this.getRoles()
    this.getSettings()
  },
}
</script>
