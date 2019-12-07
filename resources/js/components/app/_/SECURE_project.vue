<template>
<div>

<div
id="navigation"
v-bind:class="{'is-hidden': isHidden.navigation }"
>

   <div
     id="dashboard__trigger"
     class="ic arrow-left"
   ><a href="/cms/dashboard"></a></div>

   <div
     class="ic save ic--inline"
     v-bind:class="{'is--saved': save }"
     v-on:click="updateProject()"
     v-if="auth && project.status == 0"
   ></div>

   <div class="flex__filler"></div>

   <!-- <div
     id="project__tasks__trigger"
     class="ic__editor edit"
     v-if="project.status != 1"
     v-on:click="isHidden.navigation = true"
   ></div> -->



   <!-- <div
     id="project__tasks__trigger"
     class="ic comment"
     v-on:click="toggle('tasks')"
   >
     <span
       class="count"
     >{{ project.tasks.length }}</span>
   </div> -->

   <div
    class="ic__comment"
    v-if="project.status != 2 "
    v-on:click="toggle('tasks')"
    >
    <span
      v-if="project.tasks != null"
    >{{ project.tasks.length }}
    </span>

   </div>
   <div
     id="project__settings__trigger"
     class="ic more"
     v-on:click="toggle('settings')"
     v-if="auth"
   ></div>




</div>

<!-- <transition name="slide-fade">
  <intdashboard
    id="dashboard"
    v-bind:class="{'is-hidden': isHidden.dashboard }"
    :projectId="project.id"
    :isUpdated="save"
    @dashboardHide="toggle('dashboard')"
  ></intdashboard>
</transition> -->

  <inttasks
    id="project__tasks"
    v-bind:class="{'is-hidden': isHidden.tasks }"
    :users="project.users"
    :projectId="project.id"
    :slug="slug"
    @tasksHide="toggle('tasks')"
  ></inttasks>

  <div
    id="project__settings"
    v-bind:class="{'is-hidden': isHidden.settings }"
  >

  <div id="project__settings__header">
    <span class="title">Post Settings</span>
    <div class="flex__filler"></div>
    <div
      class="ic close"
      @click="toggle('settings')"
    ></div>
  </div>

    <!-- <div id="settings__project__counter">
      <span>{{ count }} </span>
      <span v-if="read != ''">&middot; {{ read }}</span>
    </div> -->

    <div id="settings__project__image">
      <label for="file">Title Image</label>

      <!-- <div class="file__delete">
        <div class="ic ic--inline trash" v-if="project.image !== null" @click="toggle('deleteImage')"></div>
      </div> -->


      <div
        id="settings__project__upload"
        class="upload__droparea"
        v-bind:class="{'is-empty': project.image == null }"
        v-on:dragover.prevent
        v-on:drop="onDrop"
      >

      <img
        v-if="project.image != null"
        @click="isHidden.editSettingsImage = false"
        :srcset="`
          ${ project.image.small.file } ${ project.image.small.size }w,
          ${ project.image.medium.file } ${ project.image.medium.size }w,
          ${ project.image.large.file } ${ project.image.large.size }w,
          ${ project.image.full.file } ${ project.image.full.size }w
        `"
        :src="project.image.medium.file"
      >

      <div
        class="ic loading"
        v-if="isLoading.upload == true"
      ></div>

      <div
        v-if="project.image == null && isLoading.upload == false"
        class="ic upload file__upload is--large"
      >
        <input type="file" name="file" accept="image/*" ref="imageUpload" v-on:change="uploadImage()"/>
        <input type="hidden" v-model="project.image" >
      </div>

      <!-- v-if="project.image == null && isLoading.upload == false" -->
      <div
        class="upload__droparea__controls"
        v-if="project.image !== null"
        v-bind:class="{'is-hidden': isHidden.editSettingsImage }"
      >
        <div
          class="ic__editor upload file__upload"
        >
          <input type="file" name="file" accept="image/*" ref="imageChange" v-on:change="changeImage()"/>
          <input type="hidden" v-model="project.image" >
        </div>
        <div class="ic__editor delete" @click="toggle('deleteImage')"></div>
        <div class="triangle"></div>
        <div class="modal__close" v-on:click="isHidden.editSettingsImage = true"></div>

      </div>

      </div>

  </div>

  <div id="project__type">
    <div class="form__group">
      <div class="form__item">
        <label for="Type">Type</label>
        <select
          class="is--app"
          name="Type"
          v-model="project.type"
          v-on:change="save = false"
          >
          <option disabled>Select a Type</option>
          <option v-for="(type, index) in types" :value="type.id">{{ type.name }}</option>
        </select>
        <!-- <label for="Status">Type</label>
        <select class="is--app" name="Status" v-model="project.status" >
          <option disabled>Select a Status</option>
          <option value="0" >Draft</option>
          <option value="1" >Review</option>
          <option v-if="project.status == 2" value="2" >Published</option>
        </select> -->
      </div>
      <div class="form__item">
        <div class="project__weight">
          <label for="weight">Weight</label>
          <div class="weight__add">
            <div class="ic arrow-left" v-on:click="project.weight = Number(project.weight) - 1" ></div>
            <input name="weight" type="text" placeholder="0" v-model="project.weight">
            <div class="ic arrow-right" v-on:click="project.weight = Number(project.weight) + 1"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

    <div id="settings__project__status">
      <label for="Status">Status</label>
      <select class="is--app" name="Status" v-model="project.status" >
        <option disabled>Select a Status</option>
        <option value="0" >Draft</option>
        <option value="1" >Review</option>
        <option v-if="project.status == 2" value="2" >Published</option>
      </select>
    </div>


    <div id="project__tag">
        <label for="tags">Groups</label>
        <span v-for="tag in project.tags" class="tag">{{ tag.name }}<a class="tag__remove" v-on:click="deleteTag(project.id, tag.id)">&times</a></span>
        <div class="tag__add" >
          <input name="tags" class="tag__input" v-on:keyup.enter="createTag(project.id, '')" v-on:keyup="searchTag()" ref="tagName" v-model="search.tag.input" type="text" placeholder="Add ...">
          <div v-if="search.tag.input != '' && search.tag.tags != '' " class="tag__results">
            <span v-for="tag in search.tag.tags" @click="addTag(project.id, tag.name)">{{tag.name}}</span>
          </div>
        </div>
    </div>

    <div id="project__user">
      <label for="Authors">Authors</label>
      <span v-for="signedUser in project.users" class="tag" >
        <span>{{ signedUser.name }}</span><a class="tag__remove" v-on:click="removeUser(project.id, signedUser.id)">&times</a>
      </span>
        <div class="tag__add" >
          <input name="Users" class="tag__input" v-on:keyup="searchUser()" ref="userPublicName" v-model="search.user.input" type="text" placeholder="Add ...">
          <div v-if="search.user.input != '' && search.user.users != '' " class="tag__results">
            <span v-for="user in search.user.users" @click="addUser(project.id, user.id)">{{user.name}}</span>
          </div>
        </div>
    </div>

    <div id="project__booking" class="has--checkbox">
      <label>Type</label>
      <input type="checkbox" name="event" v-model="project.booking.isEvent"><span>Event</span>
    </div>
    <div
      id="project__booking__settings"
      v-bind:class="{'is-hidden': !project.booking.isEvent }"
      >
      <div class="form__group">
        <div class="form__item --minwith144">
          <label>Date</label>
          <input class="is--site" v-model="project.booking.date" type="date">
        </div>
        <div class="form__item">
          <label>Start</label>
          <input class="is--site" v-model="project.booking.starttime" type="text" placeholder="00:00">
        </div>
        <div class="form__item">
          <label>Duration</label>
          <input class="is--site" v-model="project.booking.duration" type="text" placeholder="30 min">
        </div>
      </div>
      <div class="form__group">
        <div class="form__item has--price">
          <label>Price</label>
          <input class="is--site" v-model="project.booking.price" type="text" placeholder="0.01">
          <span>&euro;</span>
        </div>
      </div>
      <div class="form__group">
        <div class="form__item --minwith144">
          <label>Street</label>
          <input class="is--site" v-model="project.booking.street" type="text" placeholder="Street">
        </div>
        <div class="form__item">
          <label>City</label>
          <input class="is--site" v-model="project.booking.city" type="text" placeholder="City">
        </div>
        <div class="form__item">
          <label>Post Code</label>
          <input class="is--site" v-model="project.booking.post" type="text" placeholder="Post Code">
        </div>
      </div>
    </div>


    <div id="project__settings__footer">

      <button
        class="button--small button--cta"
        v-if="project.status != 2"
        v-on:click="toggle('publish')"
      >Publish your Story</button>

      <button
        class="button--small button--cta"
        v-on:click="updateProject()"
        v-if="auth && project.status == 2 "
      >Update</button>

      <!-- <button
        class="button--small button--cta"
        v-if="project.status == 0"
        v-on:click="toggle('review')"
      >Review</button> -->

      <!-- <button
        class="button--small"
        v-if="project.status == 1 || project.status == 2"
        v-on:click="toggle('draft')"
      >Change to Draft</button> -->

      <button
        class="button--small "
        v-on:click="toggle('delete')"
      >Delete</button>

    </div>

    <div class="triangle"></div>
    <div class="modal__close" v-on:click="isHidden.settings = true"></div>
  </div>

    <div id="project" class="site" >

      <div class="article">

        <div
          id="project__title"
          ref="projectTitle"
          contenteditable="true"
          @input="projectTitle()"
        >{{ project.title }}</div>

        <div
          id="project__description"
          ref="projectDescription"
          contenteditable="true"
          @input="projectDescription()"
        >{{ project.description }}</div>

        <div id="project__content">
          <inteditor
            :editable="project.status == 1? false : true"
            @output="getEditorOutput"
            @message="getEditorMessage"
            v-bind:id="project.id"
            v-bind:content="project.content"
          ></inteditor>
        </div>


        <!-- <video  muted="" loop="" autoplay="" playsinline="" poster="img/transparent.png" style="background-color:#f5f5f5">
          <source src="http://localhost:8000/video/2019/04/15/5cb4730ae4428.mp4" type="video/mp4;codecs="avc1.42E01E, mp4a.40.2"">
          Your browser does not support HTML5 video.
        </video> -->

        <!-- <video controls="controls">
          <source src="http://localhost:8000/video/2019/04/15/5cb47f2ccaa96.mp4" mimetype="video/mp4" type="video/mp4">
          Your browser does not support HTML5 video.
        </video> -->

        <!-- <div id="event__booking">
          <label for="Authors">User</label>
          <span v-for="signedUser in booking.users" class="tag">{{ signedUser.public_name }}<a class="tag__remove" v-on:click="removeUser(project.id, signedUser.id)">&times</a></span>
            <div class="tag__add" >
              <input name="Users" class="tag__input" v-on:keyup="searchUser()" ref="userPublicName" v-model="search.user.input" type="text" placeholder="Add ...">
              <div v-if="search.user.input != '' && search.user.users != '' " class="tag__results">
                <span v-for="user in search.user.users" @click="addUser(project.id, user.id)">{{user.public_name}}</span>
              </div>
            </div>
        </div>

      </div> -->



    </div>
  </div>

  <div id="message" v-if="message" >
    <span class="message">{{ message }}</span>
    <div @click="message = ''" class="ic close"></div>
  </div>

  <intdialogue
    v-bind:class="{'is-hidden': isHidden.deleteImage }"
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
    v-bind:class="{'is-hidden': isHidden.review }"
    dialogue-title="Review"
    dialogue-content="Let your peers review and comment your Story"
    dialogue-cancel-text="Cancel"
    dialogue-cancel-class=""
    dialogue-confirm-text="Review"
    dialogue-confirm-class="button--cta"
    @dialogue-cancel="toggle('review')"
    @dialogue-confirm="changeProjectStatus(1)" />
  </intdialogue>

  <intdialogue
    v-bind:class="{'is-hidden': isHidden.draft }"
    dialogue-title="Draft"
    dialogue-content="Change your status to draft"
    dialogue-cancel-text="Cancel"
    dialogue-cancel-class="button--cta"
    dialogue-confirm-text="Change to Draft"
    dialogue-confirm-class=""
    @dialogue-cancel="toggle('draft')"
    @dialogue-confirm="changeProjectStatus(0)" />
  </intdialogue>


  <intdialogue
    v-bind:class="{'is-hidden': isHidden.publish }"
    dialogue-title="Publish your Story"
    dialogue-content="This is a little warning text about responsibility"
    dialogue-cancel-text="Cancel"
    dialogue-cancel-class=""
    dialogue-confirm-text="Publish your Story"
    dialogue-confirm-class="button--cta"
    @dialogue-cancel="toggle('publish')"
    @dialogue-confirm="changeProjectStatus(2)" />
  </intdialogue>

  <intdialogue
    v-bind:class="{'is-hidden': isHidden.delete }"
    dialogue-title="Delete Story"
    dialogue-content="You cannot undo this"
    dialogue-cancel-text="Cancel"
    dialogue-cancel-class="button--cta"
    dialogue-confirm-text="Delete this Story"
    dialogue-confirm-class=""
    @dialogue-cancel="toggle('delete')"
    @dialogue-confirm="deleteProject(project.id), toggle('settings')" />
  </intdialogue>

</div>
</template>

<script>
let initialTimer;

import dashboard from './dashboard.vue'
import tasks from './tasks.vue'

export default {
  props: {
      slug: {
        type: String,
        required: true,
        default: []
      },
  },
  data: function() {
    return {
      isHidden: {
        publish: true,
        review: true,
        draft: true,
        delete: true,
        deleteImage: true,
        editSettingsImage: true,
        tasks: true,
        settings: true,
        navigation: false
      },
      isActive: {
        booking: true
      },
      isLoading: {
        upload: false,
      },
      auth: false,
      count: '',
      read: '',
      output: '',

      project: {
        tasks: null,
        booking: {
          isEvent: false,
          date: '',
          price: '',
          time: '',
          street: '',
          city: '',
          post: '',
        },
      },
      settings: {},
      tasks: null,
      reply: {},
      types: {},
      users: {},
      message: '',
      save: true,
      search: {
        tag: {
          input: '',
          tags: {},
        },
        user: {
          input: '',
          users: {},
        }
      },
      apiToken: window.Laravel.api_token,
      user: window.Laravel.user,
      csrf: window.Laravel.csrfToken
    }
  },
  watch: {
    'message': function(elem) {
        let self = this;
        if (initialTimer) {
          clearTimeout(initialTimer);
        }
        initialTimer = setTimeout(function () {
          self.message = '';
        }, 4000);
    },
    'project.image': function(elem) {
      this.isLoading.upload = false
    },
    'project.booking': function(elem) {
      if(this.project.status == 1) {
        this.updateProject();
      }
      this.save = false;
    },
    'project.status': function(elem) {
      if(this.project.status == 1) {
        this.updateProject();
      }
      this.save = false;
    },
    'project.type': function(elem) {
      if(this.project.status == 1) {
        this.updateProject();
      }
      this.save = false;
    },
    output: function(elem) {
      if(elem && elem.length > 1) {
        let self = this;
        if (initialTimer) {
          clearTimeout(initialTimer);
        }
        initialTimer = setTimeout(function () {
          let count = elem.split(' ').length;
          let result = Math.round(count / 200);
          if(result < 1) {
            self.read = 'less than a minute read';
          }
          if(result >= 1) {
            self.read = result + ' min read';
          }
          self.count = count + ' words';
          self.save = false;
          self.autoSave();
        }, 500);
      }
    },
  },
  methods: {
    projectTitle() {
      let elem = this.$refs.projectTitle.innerText;
      if(elem && elem.length > 1) {
        let result = elem.length;
        this.count = result + ' / 70 chars';
        this.read = '';
        this.save = false;
        this.autoSave();
      }
    },
    projectDescription() {
      let elem = this.$refs.projectDescription.innerText;
      if(elem && elem.length > 1) {
        let result = elem.length
        this.count = result + ' / 170 chars';
        this.read = '';
        this.save = false;
        this.autoSave();
      }
    },
    autoSave() {
      if(this.project.status == 0) {
        let self = this;
        if (initialTimer) {
          clearTimeout(initialTimer);
        }
        initialTimer = setTimeout(function () {
          self.updateProject();
        }, 2000);
      }
    },
    getEditorOutput(value) {
      this.output = JSON.stringify(value);
      this.output = value;
    },
    getEditorMessage(value) {
      this.message = value;
    },
    getProject() {
      axios
        .get('/api/projects/' + this.slug)
        .then((response) => {
          // this.project = response.data.data['0'],
          this.project = response.data.project[0],
          this.types = response.data.types,
          this.project.image = JSON.parse(this.project.image),
          this.project.booking = JSON.parse(this.project.booking)
          this.checkAuth(),
          this.autosize()
        })
    },
    getSettings() {
      axios
        .get('/api/settings')
        .then((response) => {
          this.settings = response.data.data[0],
          this.initialValues()
        })
    },
    getUsers() {
      axios
        .get('/api/project/users')
        .then(response => (this.users = response.data.data))
    },
    updateProject() {
      let headline = this.$refs.projectTitle.innerText;
      let slug = this.createSlug(headline);
      axios
        .patch('/api/projects/' + this.project.id, {
          title: headline,
          slug: slug,
          description: this.$refs.projectDescription.innerText,
          content: this.output,
          status: this.project.status,
          weight: this.project.weight,
          type: this.project.type,
          booking: JSON.stringify(this.project.booking)
          // type_id: this.project.type_id
      })
      .then((response) => {
        history.replaceState(null, null, slug),
        this.save = true
      })
    },
    changeProjectStatus(status) {
      this.project.status = status,
      this.updateProject(),
      window.location.href = '/cms/dashboard'
    },
    deleteProject($projectId) {
      axios
        .delete('/api/projects/' + $projectId)
        .then(window.location.href = '/cms/dashboard')
    },
    onDrop: function(e) {
      e.stopPropagation();
      e.preventDefault();
      let data = new FormData();
      let file = e.dataTransfer.files[0];
      data.append('image', file, file.name);
      data.append('old_image', this.project.image);
      axios
        .post('/api/upload/project/' + this.project.id, data)
        .then((response) => {
          this.project.image = JSON.parse(response.data)
        })
        this.isLoading.upload = true;
    },
    uploadImage() {
      let data = new FormData();
      let file = this.$refs.imageUpload.files[0];
      data.append('image', file, file.filename);
      data.append('old_image', this.project.image);
      axios
        .post('/api/upload/project/' + this.project.id, data)
        .then((response) => {
          this.project.image = JSON.parse(response.data),
          this.message = response.data.message
        })
        this.isLoading.upload = true;
    },
    changeImage() {
      this.deleteImage();
      let data = new FormData();
      let file = this.$refs.imageChange.files[0];
      data.append('image', file, file.filename);
      data.append('old_image', this.project.image);
      axios
        .post('/api/upload/project/' + this.project.id, data)
        .then((response) => {
          this.project.image = JSON.parse(response.data),
          this.message = response.data.message
        })
        this.isLoading.upload = true;
    },
    deleteImage() {
      axios
        .patch('/api/upload/project/' + this.project.id, {
          image: JSON.stringify(this.project.image)
      })
        .then((response) => {
          this.message = (response.data.message),
          this.project.image = null
        })
    },
    addUser($projectId, $searchResult) {
        axios
        .post('/api/project/users/' + $projectId, {
          user_id: $searchResult
        })
        .then((response) => {
          this.search.user.input = '',
          this.search.user.users = {},
          this.getProject()
        })
    },
    removeUser(projectId, userId) {
      axios
        .delete('/api/project/users/' + projectId + '/' + userId)
        .then((response) => {
          this.getProject()
        })
    },
    searchUser() {
      let query = this.$refs.userPublicName.value;
      if(query != '') {
        axios
        .get('/api/project/users/search/' + query)
        .then(response => (this.search.user.users = response.data.query))
      }
    },
    createTag($projectId) {
        axios
        .post('/api/tags/' + $projectId, {
          name: this.$refs.tagName.value
        })
        this.search.tag.input = '';
        this.search.tag.tags = {};
        this.updateProject();
        this.getProject();
    },
    addTag($projectId, $searchResult) {
        axios
        .post('/api/tags/' + $projectId, {
          name: $searchResult
        })
        this.search.tag.input = '';
        this.search.tag.tags = {};
        this.updateProject();
        this.getProject();
    },
    deleteTag($projectId, $tagId) {
      axios
      .delete('/api/tags/' + $projectId + '/' + $tagId);
      this.updateProject();
      this.getProject()
    },
    searchTag() {
      let query = this.$refs.tagName.value;
      if(query != '') {
        axios
        .get('/api/tags/search/' + query)
        .then(response => (this.search.tag.tags = response.data.query))
      }
    },
    checkAuth() {
      if(this.project.users.some(( {id} ) => id === this.user.id) || this.user.role_id == 1 || this.user.role_id == 2) {
        this.auth = true
      }
    },
    createSlug(title) {
      return title
        .toLowerCase()
        .replace(/[^\w ]+/g,'')
        .replace(/ +/g,'-');
    },
    autosize() {
      // let tx = document.getElementsByTagName('textarea');
      // for(let i = 0; i < tx.length; i++) {
      //   console.log('whoop');
      //   console.log(tx[i].length);
      //   tx[i].setAttribute('style', 'height:' + (tx[i].scrollHeight) + 'px; overflow-y:hidden;')
      // }
    },
    toggle(elem) {
      if(this.isHidden[elem] == false) {
        this.isHidden[elem] = true
      } else {
        this.isHidden = Object.assign({}, this.isHidden, { delete: true, deleteImage: true, draft: true, review: true, publish: true, tasks: true, dashboard: true, settings: true }),
        this.isHidden[elem] = false
      }
    },
    initialValues() {
      console.log(this.project.booking.post)
      if(this.project.booking.city == undefined) {
        this.project.booking.city = this.settings.city
      }
      if(this.project.booking.street == undefined) {
        this.project.booking.street = this.settings.street
      }
      if(this.project.booking.post == undefined) {
        this.project.booking.post = this.settings.post
      }
    }
  },
  created () {
    this.getProject()
    this.getSettings()
    this.getUsers()
    this.autosize()
  },
}
</script>
