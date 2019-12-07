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
    id="page__save"
    class="ic save ic--inline"
    v-bind:class="{'is--saved': save }"
    v-on:click="updatePage()"
    v-if="auth && page.status == 0 "
  ></div>

  <div class="flex__filler"></div>

  <!-- <div class="ic__editor image-large" @click="viewport()"></div> -->

  <div id="search__project">
    <div
      class="ic search--add"
      v-on:click="isHidden.search = !isHidden.search"
    ></div>

    <div
      v-bind:class="{'is-hidden': isHidden.search }"
      class="search__input"
    >
      <input
        ref="projectTitle"
        v-on:keyup="searchAll()"
        v-model="search.query"
        type="text"
        placeholder="Project or Group..."
      >
      <div class="modal__close" v-on:click="isHidden.search = true"></div>
    </div>
  </div>



  <div
    id="page__settings__trigger"
    class="ic more"
    v-on:click="toggle('pageSettings')"
    v-if="auth"
  ></div>

</div>
<div
  class="search__result"
  v-bind:class="{'is-hidden': isHidden.search }"
>

<div
  class="result__tags"
  v-if="search.result.tags != ''"
>
  <h5>Groups</h5>
  <div class="tags__list">
    <span
      class="tag"
      v-for="(item, index) in search.result.tags"
      v-on:click="pickNewTag(item.id)"
    >{{ item.name }}</span>
  </div>
</div>

<div
  class="result__projects"
  v-if="search.result.projects != ''"
>
  <h5>Stories</h5>
  <div class="projects__list">
    <span
      v-for="(item, index) in search.result.projects"
      v-on:click="pickNewProject(item.id)"
    >{{ item.title }}</span>
  </div>
</div>

</div>

<div
  id="page__settings"
  v-bind:class="{'is-hidden': isHidden.pageSettings }"
>

<div id="page__settings__header">
  <span class="title">Page Settings</span>
  <div class="flex__filler"></div>
  <div
    class="ic close"
    @click="toggle('settings')"
  ></div>
</div>


  <div
    id="page__settings__title"
    v-if="page.slug != 'disclaimer' && page.slug != 'impress' && page.slug != 'home'"
  >
    <label for="title">Page Title</label>
    <input type="text" name="title" v-model="page.title" v-on:change="save = false">
  </div>

  <div
    id="page__settings__subtitle"
    v-if="page.slug != 'home'"
  >
    <label for="subtitle">Page Title (SEO)</label>
    <input type="text" name="subtitle" v-model="page.subtitle" v-on:change="save = false">
    <span v-if="page.subtitle != null" class="is-small counter">{{ (page.subtitle).length }} / 70 chars</span>
  </div>

  <div
    id="page__settings__description"
    v-if="page.slug != 'home'"
  >
    <label for="description">Description (SEO)</label>
    <div
      class="textarea"
      contenteditable="true"
      ref="pageDescription"
      placeholder="Seo Description ..."
      @input="save = false"
    >{{ page.description }}</div>
    <span v-if="page.description != null" class="is-small counter">{{ (page.description).length }} / 170 chars</span>
  </div>


  <div
    id="page__settings__status"
    v-if="page.status == 2 && page.slug != 'disclaimer' && page.slug != 'impress' && page.slug != 'home'"
  >
    <label for="Status">Status</label>
    <select
      class="is--app"
      name="Status"
      v-model="page.status"
      v-on:change="save = false"
      >
      <option disabled>Select a Status</option>
      <option value="0" >Draft</option>
      <option value="2" >Published</option>
    </select>
  </div>

  <div
    id="page__settings__menu"
    v-if="page.slug != 'disclaimer' && page.slug != 'impress' && page.slug != 'home'"
  >
    <label for="title">Menu</label>
    <select name="Status"
      class="is--app"
      v-model="page.menu"
      @change="save = false"
    >
      <option disabled>Select a Menu</option>
      <option value="0" >Top</option>
      <option value="1" >Footer</option>
      <option value="2" >Both</option>
    </select>
  </div>

  <div
    id="page__cta"
    class="has--checkbox"
    v-if="page.slug != 'disclaimer' && page.slug != 'impress' && page.slug != 'home'"
  >
    <label>Call to action</label>
    <input type="checkbox" name="event" v-model="page.cta" true-value="1" false-value="0"><span>Use this page</span>
  </div>

  <div
    id="page__settings__footer"
  >

  <button
    class="button--small button--cta"
    v-on:click="updatePage()"
    v-if="auth && page.status == 2 "
  >Update</button>

    <button
      class="button--small button--cta"
      v-if="page.status != 2"
      v-on:click="toggle('publish')"
    >Publish your Page</button>

    <button
      class="button--small"
      v-on:click="toggle('delete')"
      v-if="page.slug != 'disclaimer' && page.slug != 'impress' && page.slug != 'home'"
    >Delete</button>
  </div>

  <div class="triangle"></div>
  <div class="modal__close" v-on:click="toggle('pageSettings')"></div>
</div>


<div id="page" class="site" >

<div class="page__content">

  <div
    class="item__droparea"
    :class="{'is-hidden': isHidden.itemDroparea }"
    v-on:click="dropItemHead()"
  >
    <div class="ic__editor drop"></div>
  </div>

        <div
          v-for="(item, index) in page.content"
          class="page__items"
          v-bind:class="{'is-active': index === itemControlIndex}"
          :key="index"
        >

      <div
        v-for="group in projects.tags"
        v-if="group.id === item.id && item.title === 'tag'"
        v-on:mousedown="showPageItemControls(index)"
        :key="group.id"
        class="item group"
      >

      <!-- <div class="group__header">
        <h5><div class="group__title" ref="groupTitle" contenteditable="true">{{ group.name }}</div></h5>
        <h4><div class="group__description" ref="groupDescription" contenteditable="true">Description</div></h4>
      </div> -->


          <exchange-page-project
            v-for="(elem, index) in group.project"
            :project="elem"
            :type="getTypeObj(item.type_id)"
            :key="elem.id"
            v-bind:class="getTypeObj(item.type_id).class"
            class="item"
          ></exchange-page-project>

          <div
            class="item__settings"
            v-bind:class="{'is-active': index === itemControlIndex }"
          >
            <select
              class="is--app"
              name="Content Type"
              v-model="item.type_id"
              v-on:change="save = false, itemControlIndex = '999'"
              >
              <option disabled>Select</option>
              <option v-for="(type, index) in types" :value="type.id">{{ type.name }}</option>
            </select>

            <button class="ic__editor drag" v-on:click="pickItem(item.id, item.type_id, item.link, null, index)"></button>
            <!-- <button class="ic__editor edit" ><a :href="`/cms/project/${ group.slug }`"></a></button> -->
            <button class="ic__editor trash" v-on:click="removeItem(index), itemControlIndex = '999'"></button>
            <div class="triangle"></div>
          </div>

        <div
          class="item__droparea"
          :class="{'is-hidden': isHidden.itemDroparea }"
          v-on:click="dropItem(index)"
          >
          <div class="ic__editor drop"></div>
        </div>
      </div><!-- ***************** -->




      <div
        v-if="elem.id === item.id && item.title === 'project'"
        v-for="elem in projects.projects"
        v-on:mousedown="showPageItemControls(index)"
        :key="elem.id"
        class="item"
      >
        <div class="wrapper">
          <exchange-page-project
            :project="elem"
            :link="item.item_link"
            :type="getTypeObj(item.type_id)"
            v-bind:class="getTypeObj(item.type_id).class"
          ></exchange-page-project>
          <div
            class="item__settings"
            v-bind:class="{'is-active': index === itemControlIndex }"
          >
            <select
              class="is--app"
              name="Content Type"
              v-model="item.type_id"
              v-on:change="save = false, itemControlIndex = '999'"
              >
              <option disabled>Select</option>
              <option v-for="(type, index) in types" :value="type.id">{{ type.name }}</option>
            </select>

            <button class="ic__editor drag" v-on:click="pickItem(null, item.type_id, item.link, item.tag_id, index)"></button>
            <button class="ic__editor edit" ><a :href="`/cms/project/${ elem.slug }`"></a></button>
            <button class="ic__editor link" v-on:click="isHidden.itemLink = !isHidden.itemLink"></button>
            <div
              :class="{'is-hidden': isHidden.itemLink }"
              class="item__settings__form"
            >
              <input
                type="text"
                placeholder="https://"
                v-on:keyup.enter="save = false, itemControlIndex = '999'"
                v-model="item.item_link"
                >
              <button class="ic__editor trash" v-on:click="item.item_link = ''"></button>
              <button class="ic__editor close" v-on:click="isHidden.itemLink = !isHidden.itemLink"></button>
            </div>
            <button class="ic__editor trash" v-on:click="removeItem(index), itemControlIndex = '999'"></button>
            <div class="triangle"></div>
            <!-- <div class="modal__close" v-on:click="itemControlIndex = 999"></div> -->
          </div>
        </div>
        <div
          class="item__droparea"
          :class="{'is-hidden': isHidden.itemDroparea }"
          v-on:click="dropItem(index)"
          >
          <div class="ic__editor drop"></div>
        </div>
      </div><!-- ***************** -->







    </div>
</div>
</div>

  <div id="message" v-if="message" >
    <span class="message">{{ message }}</span>
    <div @click="message = ''" class="ic__editor close"></div>
  </div>

<intdialogue
  v-bind:class="{'is-hidden': isHidden.delete }"
  dialogue-title="Delete your page"
  dialogue-content="You cannot undo this"
  dialogue-cancel-text="Cancel"
  dialogue-confirm-text="Delete"
  @dialogue-cancel="toggle('delete')"
  dialogue-cancel-class="button--cta"
  @dialogue-confirm="deletePage"
  dialogue-confirm-class="" />
</intdialogue>

<intdialogue
  v-bind:class="{'is-hidden': isHidden.publish }"
  dialogue-title="Publish your page"
  dialogue-content="When you publish your page, it will show up on your sites menu"
  dialogue-cancel-text="Cancel"
  dialogue-confirm-text="Publish"
  @dialogue-cancel="toggle('publish')"
  dialogue-cancel-class=""
  @dialogue-confirm="publishPage"
  dialogue-confirm-class="button--cta" />
</intdialogue>

</div>

</template>



<script>
let initialTimer;

import dashboard from './dashboard.vue'

export default {
  props: ['slug'],
  data() {
    return {
      search: {
        query: '',
        result: {
          projects: '',
          tags: ''
        },
      },
      isHidden: {
        delete: true,
        publish: true,
        navigation: false,
        pageSettings: true,
        itemControl: true,
        itemDroparea: true,
        itemLink: true,
        search: true,
      },
      itemId: '',
      itemType: '',
      itemLink: '',
      tagId: '',
      elemIndex: '',
      // itemDashboard: false,
      auth: false,
      message: '',
      types: {},
      projects: {},
      tags: {},
      page: {
        content: '',
        title: '',
        subtitle: '',
        description: ''
      },
      save: true,
      view: false,
      itemControlIndex: '999',
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
    'page.content': function(elem) {
      this.save = false;
      this.autoSave();
    },
  },
  methods: {
    autoSave() {
      if(this.page.status == 0) {
        let self = this;
        if (initialTimer) {
          clearTimeout(initialTimer);
        }
        initialTimer = setTimeout(function () {
          self.updatePage();
        }, 2000);
      }
    },
    getPage() {
      axios
        .get('/api/pages/' + this.slug)
        .then(
          response => (
            this.types = response.data.types,
            this.page = response.data.page,
            this.page.content = JSON.parse(this.page.content),
            this.getProjects(),
            this.checkAuth()
          )
        )
    },
    getProjects() {
      axios
      .post('/api/pages/' + this.slug, {
        page: JSON.stringify(this.page.content)
      })
      .then((response) => {
        this.projects = response.data
      })
    },
     updatePage() {
       if (this.$refs.pageDescription !== undefined) {
         this.page.description = this.$refs.pageDescription.innerText
       }
       let slug = this.makeSlug(this.page.title);
       axios
         .patch('/api/pages/' + this.page.id, {
           content: JSON.stringify(this.page.content),
           title: this.page.title,
           subtitle: this.page.subtitle,
           description: this.page.description,
           status: this.page.status,
           menu: this.page.menu,
           cta: this.page.cta
         })
         .then((response) => {
           this.message = response.data.message,
           this.save = true,
           history.replaceState(null, null, slug)
         })
     },
     publishPage() {
       this.page.status = 2,
       this.updatePage(),
       window.location.href = '/cms/page/home'
     },
     deletePage() {
       axios
         .delete('/api/pages/' + this.page.id)
         .then(window.location.href = '/cms/dashboard')
     },
     searchAll() {
       let self = this;
       if (initialTimer) {
         clearTimeout(initialTimer);
       }
       initialTimer = setTimeout(function () {
         let query = self.search.query;
         if(query != '') {
           axios
           .get('/api/projects/search/' + query)
           .then((response) => {
             self.search.result.projects = response.data.published,
             self.isHidden.search = false
           })
           axios
           .get('/api/tags/search/' + query)
           .then((response) => {
             self.search.result.tags = response.data.query,
             self.isHidden.search = false
           })
         }
       }, 200);
     },
     // searchTags() {
     //   let self = this;
     //   if (initialTimer) {
     //     clearTimeout(initialTimer);
     //   }
     //   initialTimer = setTimeout(function () {
     //     let query = self.search.query;
     //     if(query != '') {
     //       axios
     //       .get('/api/tags/search/' + query)
     //       .then((response) => {
     //         self.search.result.tags = response.data.query,
     //         self.isHidden.search = false
     //       })
     //     }
     //   }, 200);
     // },
     getTypeObj(id) {
        for(let i in this.types) {
          if(this.types[i].id == id) {
            return this.types[i]
          }
        }
     },
      showPageItemControls: function(index) {
        // if(!event.targetList.contains('item__droparea')) {
          this.itemId = '',
          this.itemType = '',
          this.itemLink = '',
          this.tagId = '',
          this.elemIndex = '',
          this.isHidden.itemDroparea = true,
          this.itemControlIndex = index
        // }
      },
      pickNewProject: function (value) {
        this.itemId = value,
        this.isHidden.itemDroparea = false,
        this.isHidden.search = true
        // console.log('itemId: ' + this.itemId + ' - itemType: ' + this.itemType + ' - tagId: ' + this.tagId + ' - elemIndex: ' + this.elemIndex)
      },
      pickNewTag: function (value) {
        this.tagId = value,
        this.isHidden.itemDroparea = false,
        this.isHidden.search = true
        // console.log('itemId: ' + this.itemId + ' - itemType: ' + this.itemType + ' - tagId: ' + this.tagId + ' - elemIndex: ' + this.elemIndex)
      },
      pickItem(id, type, link, tagid, index) {
          this.itemId = id,
          this.itemType = type,
          this.itemLink = type,
          this.tagId = tagid,
          this.elemIndex = index,
          this.isHidden.itemDroparea = false
          // console.log('itemId: ' + this.itemId + ' - itemType: ' + this.itemType + ' - tagId: ' + this.tagId + ' - elemIndex: ' + this.elemIndex)
      },
      dropItem(index) {
        // console.log('itemId: ' + this.itemId + ' - itemType: ' + this.itemType + ' - tagId: ' + this.tagId + ' - elemIndex: ' + this.elemIndex)
        // if(this.itemId != '') {
          let arr = this.page.content;
          if(this.elemIndex == '') {
            if(this.itemId != '') {
              arr.splice(index + 1, 0, {'title': 'project', 'id': this.itemId, 'type_id': 1, 'item_link': this.itemLink, })
            }
            if(this.tagId != '') {
              arr.splice(index + 1, 0, {'title': 'tag', 'id': this.tagId, 'type_id': 1, 'item_link': this.itemLink, })
            }
            // arr.splice(index + 1, 0, {project:{'id': this.itemId, 'type_id': 6}}),
            this.getProjects(),
            this.cancelDrop()
          } else {
            if(index < this.elemIndex) {
              arr.splice(index + 1, 0, arr.splice(this.elemIndex, 1)[0]),
              this.cancelDrop()
            }
            console.log(this.elemIndex);
            if(index > this.elemIndex) {
              arr.splice(index, 0, arr.splice(this.elemIndex, 1)[0]),
              this.cancelDrop()

            }
            this.elemIndex = index
          }
        // }
      },
      dropItemHead() {
        // console.log('itemId: ' + this.itemId + ' - itemType: ' + this.itemType + ' - tagId: ' + this.tagId + ' - elemIndex: ' + this.elemIndex)
        let arr = this.page.content;
        if(this.elemIndex == '') {
          if(this.itemId != '') {
            arr.splice(0, 0, {'title': 'project', 'id': this.itemId, 'type_id': 1})
          }
          if(this.tagId != '') {
            arr.splice(0, 0, {'title': 'tag', 'id': this.tagId, 'type_id': 1})
          }
          // arr.splice(0, 0, {project:{'id': this.itemId, 'type_id': 6, 'tag_id': ''}}),
          this.cancelDrop(),
          this.getProjects()
        } else {
          arr.splice(0, 0, arr.splice(this.elemIndex, 1)[0])
          this.elemIndex = 0,
          this.cancelDrop()
        }
      },
      cancelDrop() {
        this.itemId = '',
        this.itemType = '',
        this.itemLink = '',
        this.elemIndex = '',
        this.isHidden.itemDroparea = true,
        this.isHidden.itemControl = true,
        this.itemControlIndex = '999'
      },
      removeItem: function(index){
         this.page.content.splice(index, 1);
      },
      viewport() {
        let meta = document.querySelector("meta[name=viewport]")
        meta.setAttribute('content', 'width=1024')

        let self = this;
        if (initialTimer) {
          clearTimeout(initialTimer)
        };
        initialTimer = setTimeout(function () {
          meta.setAttribute('content', 'width=device-width, initial-scale=1')
        }, 4000);
      },
      // viewport() {
      //   let self = this;
      //   if (initialTimer) {
      //     clearTimeout(initialTimer);
      //   }
      //   initialTimer = setTimeout(function () {
      //     let meta = document.querySelector("meta[name=viewport]");
      //     if(this.view == true) {
      //       meta.setAttribute('content', 'width=device-width, initial-scale=1'),
      //       this.view = false
      //     } else {
      //       meta.setAttribute('content', 'width=1024'),
      //       this.view = true
      //     }
      //   }, 4000);
      // },
      returnJson(elem) {
          return JSON.parse(elem);
      },
      checkAuth() {
        if(this.user.role_id == 1 || this.user.role_id == 2) {
          this.auth = true
        }
      },
      makeSlug(title) {
         return title
           .toLowerCase()
           .replace(/[^\w ]+/g,'')
           .replace(/ +/g,'-');
       },
       toggle: function (elem) {
         if(this.isHidden[elem] == false) {
           this.isHidden[elem] = true
         } else {
           this.isHidden = Object.assign({}, this.isHidden, { delete: true, publish: true, dashboard: true, pageSettings: true }),
           this.isHidden[elem] = false
         }
       },
       parseJson(str) {
           return JSON.parse(str);
       },

  },
  created () {
    this.getPage()
  }
}

</script>
