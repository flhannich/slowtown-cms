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

  <div class="flex__filler"></div>

  <!-- <div class="ic__editor image-large" @click="viewport()"></div> -->

  <div
    id="page__save"
    class="ic save ic--inline"
    v-bind:class="{'is--saved': save }"
    v-on:click="updatePage()"
    v-if="auth && page.status == 0 "
  ></div>



  <div id="search__project">
    <div
      class="ic add"
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
        placeholder="Add ..."
      >
    </div>
  </div>

  <button
    class="button--small button--cta"
    v-on:click="updatePage()"
    v-if="auth && page.status == 2 "
  >Update</button>

  <div
    id="page__settings__trigger"
    class="ic more"
    v-on:click="toggle('pageSettings')"
    v-if="page.title != 'Home' && auth "
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
  <span
    class="tag tag--small"
    v-for="(item, index) in search.result.tags"
    v-on:click="pickNewTag(item.id)"
  >{{ item.name }}</span>
</div>

<div
  class="result__projects"
  v-if="search.result.projects != ''"
>  <span
    v-for="(item, index) in search.result.projects"
    v-on:click="pickNewProject(item.id)"
  >{{ item.title }}</span>
</div>



</div>

<div
  id="page__settings"
  v-if="page.slug != 'home'"
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
  id="page__settings__status"
  v-if="page.status == 2"
>
  <label for="Status">Status</label>
  <select
    class="is--app"
    name="Status"
    v-model="page.status"
    v-on:change="save = false"
    v-if="page.slug != 'disclaimer'"
    >
    <option disabled>Select a Status</option>
    <option value="0" >Draft</option>
    <option value="2" >Published</option>
  </select>
</div>
<div
  id="page__settings__title"
  v-if="page.slug != 'disclaimer'"
>
  <label for="title">Title</label>
  <input type="text" name="title" v-model="page.title" v-on:change="save = false">
</div>



<div id="page__settings__subtitle">
  <label for="subtitle">Title (SEO)</label>
  <input type="text" name="subtitle" v-model="page.subtitle" v-on:change="save = false">
  <span v-if="page.subtitle != null" class="is-small counter">{{ (page.subtitle).length }} / 170 chars</span>
</div>

<div id="page__settings__title">
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

<div id="page__settings__menu">
  <label for="title">Menu</label>
  <select name="Status"
    class="is--app"
    v-model="page.menu"
    @change="save = false"
  >
    <option disabled>Select a Menu</option>
    <option value="0" >Main</option>
    <option value="1" >Footer</option>
  </select>
</div>

  <div
    id="page__settings__footer"
  >

    <button
      class="button--small button--cta"
      v-if="page.status != 2"
      v-on:click="toggle('publish')"
    >Publish your Page</button>

    <button
      class="button--small"
      v-on:click="toggle('delete')"
      v-if="page.slug != 'disclaimer'"
    >Delete Page</button>

  </div>
  <div class="triangle"></div>

</div>


<div
  id="page" class="site"
>

<div class="page__content">

  <!-- <div
    v-if="page.content == ''"
    class="item__droparea-empty"
    :class="{'is-hidden': isHidden.itemDroparea }"
    v-on:click="dropItemHead()"
  ></div> -->

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
          v-for="project in projects"
          v-if="project.id === item.id"
          v-on:mousedown="showPageItemControls(index)"
          v-bind:class="getTypeObj(item.type_id).class"
          :key="project.id"
          class="item"
        >
        <div class="wrapper">
          <exchange-page-project :project="project" :type="getTypeObj(item.type_id)"></exchange-page-project>

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

            <button class="ic__editor drag" v-on:click="pickItem(item.id, item.type_id, item.tag_id, index)"></button>
            <button class="ic__editor edit" ><a :href="`/cms/project/${ project.slug }`"></a></button>
            <button class="ic__editor trash" v-on:click="removeItem(index), itemControlIndex = '999'"></button>
            <div class="triangle"></div>
          </div>

            <!-- <div class="controls__trigger ic settings ic-inline" v-on:click="showPageItemControls($event)"></div> -->

        </div>
          <div
            class="item__droparea"
            :class="{'is-hidden': isHidden.itemDroparea }"
            v-on:click="dropItem(index)"
          >
            <div class="ic__editor drop"></div>
          </div>
      </div>

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
        search: true,
      },
      itemId: '',
      itemType: '',
      tagId: '',
      elemIndex: '',
      // itemDashboard: false,
      auth: false,
      message: '',
      types: {},
      projects: {},
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
      .then(response => (this.projects = response.data.projects))
    },
    // getTypes() {
    //   axios
    //     .get('/api/types')
    //     .then(response => (this.types = response.data.data))
    // },
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
        if(!event.target.classList.contains('item__droparea')) {
          this.itemId = '',
          this.itemType = '',
          this.tagId = '',
          this.elemIndex = '',
          this.isHidden.itemDroparea = true,
          this.itemControlIndex = index
        }
      },
      pickNewProject: function (value) {
        this.itemId = value,
        this.isHidden.itemDroparea = false,
        this.isHidden.search = true
      },
      pickNewTag: function (value) {
        this.tagId = value,
        this.isHidden.itemDroparea = false,
        this.isHidden.search = true
      },
      pickItem(id, type, tagid, index) {
          this.itemId = id,
          this.itemType = type,
          this.tagId = tagid,
          this.elemIndex = index,
          this.isHidden.itemDroparea = false,
          console.log('itemId: ' + this.itemId + ' - itemType: ' + this.itemType + ' - tagId: ' + this.tagId + ' - elemIndex: ' + this.elemIndex)
      },
      dropItem(index) {
        console.log('itemId: ' + this.itemId + ' - itemType: ' + this.itemType + ' - tagId: ' + this.tagId + ' - elemIndex: ' + this.elemIndex)
        if(this.itemId != '') {
          let arr = this.page.content;
          if(this.elemIndex == '') {
            arr.splice(index + 1, 0, {'id': this.itemId, 'type_id': 6}),
            this.getProjects(),
            this.cancelDrop()
          } else {
            if(index < this.elemIndex) {
              arr.splice(index + 1, 0, arr.splice(this.elemIndex, 1)[0]),
              this.cancelDrop()
            }
            if(index > this.elemIndex) {
              arr.splice(index, 0, arr.splice(this.elemIndex, 1)[0]),
              this.cancelDrop()

            }
            this.elemIndex = index
          }
        }
      },
      dropItemHead() {
        console.log('itemId: ' + this.itemId + ' - itemType: ' + this.itemType + ' - tagId: ' + this.tagId + ' - elemIndex: ' + this.elemIndex)
        let arr = this.page.content;
        if(this.elemIndex == '') {
          arr.splice(0, 0, {'id': this.itemId, 'type_id': 6}),
          this.cancelDrop(),
          this.getProjects()
        } else {
          arr.splice(0, 0, arr.splice(this.elemIndex, 1)[0])
          this.elemIndex = 0,
          this.cancelDrop()

        }
      },
        //   if(this.itemId != '') {
        //   }
        //
        // },
        // }
        // if(index > this.elemIndex) {
        //   console.log('move DOWN')
        //       let arr = this.page.content;
        //       arr.splice(newIndex, 0, arr.splice(this.elemIndex, 1)[0])
        //   }
        //       this.elemIndex = newIndex
        //       this.cancelDrop();
        // },
        // }

      cancelDrop() {
        this.itemId = '',
        this.itemType = '',
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
       }
  },
  created () {
    // this.getTypes()
    this.getPage()

  }
}

</script>
