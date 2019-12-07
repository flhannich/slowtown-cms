<template>
  <div>


  <div id="settings">
    <div id="settings__controls">

      <button
        class="button--small button--cta"
        v-on:click="updateSettings()">
      Save</button>

      <div class="flex__filler"></div>
  </div>
    <!-- <tabs>
      <tab name="About us" :selected="true">
        <p>Some example text for our about us tab</p>
      </tab>
      <tab name="About them">
        <p>Some example text for our about them tab</p>
      </tab>
      <tab name="About you">
        <p>Some example text for our about you tab</p>
      </tab>
    </tabs> -->

    <div
      id="settings__image"
      class="upload__droparea"
      v-on:dragover.prevent
      v-on:drop="onDrop"
    >

    <label>Website Logo</label>

    <img
      v-if="settings.image != null"
      @click="isHidden.editSettingsImage = false"
      :src="settings.image.medium.file"
    >

    <div
      class="ic loading"
      v-if="isLoading.image == true"
    ></div>

    <div
      v-if="settings.image == null && isLoading.image == false"
      class="ic upload file__upload"
    >
      <input type="file" name="file" accept="image/*" ref="imageUpload" v-on:change="uploadImage('create')"/>
      <input type="hidden" v-model="settings.image" >
    </div>

    <div
      class="upload__droparea__controls"
      v-if="settings.image !== null"
      v-bind:class="{'is-hidden': isHidden.editSettingsImage }"
    >
      <div
        class="ic__editor upload file__upload"
      >
        <input type="file" name="file" accept="image/*" ref="imageChange" v-on:change="uploadImage('reset')"/>
        <input type="hidden" v-model="settings.image" >
      </div>
      <div class="ic__editor delete" @click="toggle('deleteSettingsImage')"></div>
      <div class="triangle"></div>
      <div class="modal__close" v-on:click="isHidden.editSettingsImage = true"></div>
    </div>

  </div>


  <div
    id="settings__favicon"
    class="upload__droparea"
    v-on:dragover.prevent
    v-on:drop="onDrop"
  >

  <label>Favicon</label>

  <img
    v-if="settings.favicon != null"
    @click="isHidden.editSettingsFavicon = false"
    :src="settings.favicon"
  >

  <div
    class="ic loading"
    v-if="isLoading.favicon == true"
  ></div>

  <div
    v-if="settings.favicon == null && isLoading.favicon == false"
    class="ic upload file__upload"
  >
    <input type="file" name="file" accept="image/*" ref="faviconUpload" v-on:change="uploadFavicon('create')"/>
    <input type="hidden" v-model="settings.favicon" >
  </div>

  <div
    class="upload__droparea__controls"
    v-if="settings.favicon !== null"
    v-bind:class="{'is-hidden': isHidden.editSettingsFavicon }"
  >
    <div
      class="ic__editor upload file__upload"
    >
      <input type="file" name="file" accept="image/*" ref="faviconChange" v-on:change="uploadFavicon('reset')"/>
      <input type="hidden" v-model="settings.favicon" >
    </div>
    <div class="ic__editor delete" @click="toggle('deleteSettingsFavicon')"></div>
    <div class="triangle"></div>
    <div class="modal__close" v-on:click="isHidden.editSettingsFavicon = true"></div>
  </div>

</div>



    <div id="settings__website" class="block">

      <div class="settings__description">
        <h4>Site</h4>
      </div>

      <div class="form__group">
        <div class="form__item">
          <label for="title">Site Name</label>
          <input
            type="text"
            v-model="settings.title"
            @input="save = false"
          >
        </div>
      </div>

      <div class="form__group">
        <div class="form__item">
          <label for="url">Your Domain</label>
          <input name="url" type="text" v-model="settings.url" placeholder="https://yourdomain.com">
        </div>
      </div>

  </div>

    <!-- <div id="settings__seo" class="block">

      <div class="settings__description">
        <h4>SEO</h4>
      </div>

      <div class="form__group">
        <div class="form__item">
          <label for="title">Title</label>
          <div
            class="textarea"
            contenteditable="true"
            ref="settingsSubtitle"
            @input="save = false"
          >{{ settings.subtitle }}</div>
          <span v-if="settings.subtitle != ''" class="is-small counter">{{ (settings.subtitle).length }} / 70 chars</span>
        </div>
      </div>
      <div class="form__group">
        <div class="form__item">
          <label for="description">Description</label>
          <div
            class="textarea"
            contenteditable="true"
            ref="settingsDescription"
            @input="save = false"
          >{{ settings.description }}</div>
          <span v-if="settings.description != null" class="is-small counter">{{ (settings.description).length }} / 170 chars</span>
        </div>
      </div>

  </div> -->

    <div id="settings__contact" class="block">

      <div class="settings__description">
        <h4>Contact</h4>
      </div>

      <div class="form__group">
        <div class="form__item">
          <label for="owner">Owner Name</label>
          <input name="owner" type="text" v-model="settings.owner" placeholder="First and Last Name">
        </div>
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
    </div>

    <div id="settings__contact" class="block">

      <div class="settings__description">
        <h4>Adress</h4>
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

        <div class="settings__description">
          <h4>Social Media</h4>
        </div>

        <div
          v-for="(item, index) in settings.social"
          class="form__group"
        >
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

    <div id="settings__users"  class="block">

      <div class="settings__description">
        <h4>User Settings</h4>
      </div>

      <div class="form__group" v-for="(activeUser, index) in users">
        <div class="form__item --maxwidth144">
          <label>{{ activeUser.name }}</label>
          <select v-model="activeUser.role_id" @change="updateUser(activeUser.id, index)">
            <option disabled>Select a Role</option>
            <option v-for="(role, index) in roles" :value="role.id">{{ role.name }}</option>
          </select>
        </div>
        <div class="form__item --maxwith34">
          <label>&nbsp;</label>
            <div v-if="activeUser.role_id != 1" @click="deleteUserDialogue(activeUser.id)" class="ic delete"></div>
        </div>
      </div>

      <div class="form__group --top-margin-mid">
        <div class="form__item">
          <button class="button--small" @click="toggle('userRegister')">Register a new User</button>
        </div>
      </div>

    </div>

        <div
        id="settings__register"
        class="dialogue"
        v-bind:class="{'is-hidden': isHidden.userRegister }"
        >
          <div class="dialogue__header">
            <h4>Register a new User</h4>
            <span>Here you can register a new user. You can give him a Role as 'Author' for example after you have added her or him</span>
          </div>

          <div class="dialogue__body">
            <div class="form__group">
              <div class="form__item">
                <label for="name">Name</label>
                <input type="text" name="name" v-model="register.name">
              </div>
            </div>
            <div class="form__group">
              <div class="form__item">
                <label>E-mail</label>
                <input type="email" name="email" v-model="register.email">
              </div>
            </div>
            <div class="form__group">
              <div class="form__item">
                <label>Password</label>
                <input type="password" name="password" ref="newPassword" @input="passwordMatch()" v-model="register.password">
              </div>
            </div>
            <div class="form__group">
              <div class="form__item">
                <label for="password-confirm">Confirm Password</label>
                <input type="password" name="password_confirmation" ref="passwordConfirm" v-model="register.password_confirmation">
              </div>
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

  <intdialogue
    v-bind:class="{'is-hidden': isHidden.deleteSettingsFavicon }"
    dialogue-title="Delete your Favicon"
    dialogue-content="You cannot undo this"
    dialogue-cancel-text="Cancel"
    dialogue-cancel-class="button--cta"
    dialogue-confirm-text="Delete Image"
    dialogue-confirm-class="n"
    @dialogue-cancel="toggle('deleteFavicon')"
    @dialogue-confirm="deleteFavicon(), toggle('deleteFavicon')" />
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
        editSettingsFavicon: true,
        deleteSettingsImage: true,
        deleteSettingsFavicon: true,
        dashboard: true
      },
      isLoading: {
        image: false,
        favicon: false
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
      this.isLoading.image = false;
    },
    'settings.favicon': function(elem) {
      this.isLoading.favicon = false;
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
          // subtitle: this.$refs.settingsSubtitle.innerText,
          // description: this.$refs.settingsDescription.innerText,
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
    updateUser(id, index) {
      axios
        .patch('/api/users/' + id, {
          role_id: this.users[index].role_id
        })
        .then((response) => {
          this.message = response.data.message,
          this.getUsers()
        })
    },
    deleteUser(id) {
      axios
        .delete('/api/users/' + id)
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
        this.isLoading.image = true;
    },
    uploadImage(set) {
      let file = '';
      if(set == 'reset') {
        this.deleteImage();
        file = this.$refs.imageChange.files[0];
      }
      if(set == 'create') {
        file = this.$refs.imageUpload.files[0];
      }
      let data = new FormData();
      data.append('image', file, file.filename);
      axios
        .post('/api/upload/settings/logo/' + this.settings.id, data)
        .then((response) => {
          this.settings.image = JSON.parse(response.data)
          this.message = response.data.message
        })
        this.isLoading.image = true;
    },
    uploadFavicon(set) {
      let file = '';
      if(set == 'reset') {
        this.deleteFavicon();
        file = this.$refs.faviconChange.files[0];
      }
      if(set == 'create') {
        file = this.$refs.faviconUpload.files[0];
      }
      console.log(file);
      let data = new FormData();
      data.append('image', file, file.filename);
      axios
        .post('/api/upload/settings/favicon/' + this.settings.id, data)
        .then((response) => {
          this.settings.favicon = response.data,
          this.message = response.data.message
        })
        this.isLoading.favicon = true;
    },
    // uploadFavicon() {
    //   let data = new FormData();
    //   let file = this.$refs.faviconUpload.files[0];
    //   // console.log(this.$refs.imageUpload);
    //   data.append('image', file, file.filename);
    //   axios
    //     .post('/api/upload/settings/favicon/' + this.settings.id, data)
    //     .then((response) => {
    //       // this.settings.favicon = JSON.parse(response.data)
    //       // this.message = response.data.message
    //     })
    // },
    // changeImage() {
    //   this.deleteImage();
    //   let data = new FormData();
    //   let file = this.$refs.imageChange.files[0];
    //   data.append('image', file, file.filename);
    //   axios
    //     .post('/api/upload/settings/logo/' + this.settings.id, data)
    //     .then((response) => {
    //       this.settings.image = JSON.parse(response.data),
    //       this.message = response.data.message
    //     })
    //     this.isLoading.upload = true;
    // },
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
    deleteFavicon() {
      axios
        .patch('/api/upload/settings/favicon/' + this.settings.id, {
          image: JSON.stringify(this.settings.favicon)
        })
        .then((response) => {
          this.message = response.data.message,
          this.settings.favicon = null
        })
    },
    toggle(elem) {
      if(this.isHidden[elem] == false) {
        this.isHidden[elem] = true
      } else {
        this.isHidden = Object.assign({}, this.isHidden, { deleteSettingsFavicon: true, deleteSettingsImage: true, userDelete: true, userRegister: true, dashboard: true, settings: true }),
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
