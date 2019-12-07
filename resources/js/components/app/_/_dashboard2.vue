<template>
<div>


<div id="dashboard__header">

  <!-- <div class="logo"><a href="/dashboard"></a></div> -->

  <ul>
    <li>
      <a
        class="menu"
        v-on:click="isHidden.dashboardStories = false, isHidden.dashboardSettings = true"
        v-bind:class="{'is-active': isHidden.dashboardSettings }"
      >Home</a>
    </li>
    <!-- <li>
      <a
        class="menu"
        v-on:click="isHidden.dashboardStories = false, isHidden.dashboardStories = true"
        v-bind:class="{'is-active': isHidden.dashboardStories  }"
      >Pages</a>
    </li> -->
    <li>
      <a
        class="menu"
        v-on:click="isHidden.dashboardSettings = false, isHidden.dashboardStories = true"
        v-bind:class="{'is-active': isHidden.dashboardStories  }"
      >Settings</a>

    </li>

  </ul>

  <!-- <button
    class="button--small button--cta"
    v-if="isHidden.dashboardStories == false"
    v-on:click="createPage()">
  New Page</button>
-->

  <button
    class="button--small button--cta"
    v-if="isHidden.dashboardStories == true"
    v-on:click="save = true">
  Save</button>

  <!-- <button
    class="button--small button--cta"
    v-if="isHidden.dashboardStories == false"
    v-on:click="createProject()"
  >New</button> -->

  <!-- <a v-on:click="logout()">
    <div class="ic add"></div>
  </a> -->

  <div
    id="search__project"
  >
    <div
      class="ic search"
      v-on:click="isHidden.search = !isHidden.search"
    ></div>

    <div
      class="search__input"
      v-bind:class="{'is-hidden': isHidden.search }"
    >
      <!-- <div class="ic search"></div> -->
      <input
        ref="projectTitle"
        v-on:keyup="searchProject()"
        v-model="search.project"
        type="text"
        placeholder="Search ..."
      >
    </div>
    <!-- <div class="ic close" v-on:click="isHidden.search = true, getProjects(limit.published)"></div> -->
  </div>

  <div
    id="site__settings__trigger"
    v-on:click="toggle('profile')"
    class="ic profile"
  ></div>


  <div
    id="site__settings__trigger"
    v-on:click="toggle('settings')"
    class="ic settings"
  ></div>


  <!-- <a v-on:click="logout()">
    <div class="ic settings"></div>
  </a> -->
  <!-- <div
    class="ic add"
    v-on:click="createProject()"
  ></div> -->

  <a v-on:click="logout()">
    <div class="ic logout"></div>
  </a>






  <!-- <div
    id="dashboard__trigger"
    class="ic close"
    v-on:click="dashboardHide()"
  ></div> -->

</div>




<div id="dashboard__items">

<div
  id="dashboard__settings"
  v-bind:class="{'is-hidden': isHidden.dashboardSettings }"
  >
  <intsettings
    v-if="auth"
    :saveSettings="save"
  ></intsettings>
  <intprofile :saveProfile="save" ></intprofile>
</div>


<div
  id="dashboard__projects"
  v-bind:class="{'is-hidden': isHidden.dashboardStories }"
>

<div class="dashboard__title">
  <h2>Stories</h2>
  <div class="flex__filler"></div>
  <div
    class="ic add"
    v-on:click="createProject()"
  ></div>
  <!-- <button
    class="button--small button--cta"
    v-on:click="createProject()"
  >New Story</button> -->
  <!-- <div id="search__project">
    <div
      class="ic search"
      v-on:click="isHidden.search = !isHidden.search"
    ></div>

    <div
      class="search__input"
      v-bind:class="{'is-hidden': isHidden.search }"
    >
      <input
        ref="projectTitle"
        v-on:keyup="searchProject()"
        v-model="search.project"
        type="text"
        placeholder="Search ..."
      >
    </div>
  </div>
-->
  <!-- <div
    class="ic add"
    v-on:click="createProject()"
  ></div> -->

</div>



<div
  class="dashboard__projects__reviews"
  v-if="projects.reviews != ''"
  >
  <div class="dashboard__inner__wrapper">

  <div
    class="dashboard__status">
    <h5>Review</h5>
  </div>

    <div
      class="dashboard__item"
      v-for="(reviews, index) in projects.reviews"
      v-bind:class="[{'is-active':(reviews.id === projectId)}]"
    >

      <div class="dashboard__item__content">

        <div class="dashboard__item__title" >
          <h3><a :href="`/cms/project/${ reviews.slug }`">{{ reviews.title }}</a></h3>
        </div>

        <div
          class="dashboard__item__description"
          v-if="reviews.description !== null"
        >
          <span class="is-paragraph">{{ reviews.description }}</span>
        </div>

        <div class="dashboard__item__footer">

          <div class="dashboard__item__user">
            <span
              v-for="(peer, index) in reviews.users"
            >{{ peer.name }}</span>
          </div>
          <div class="dashboard__item__comments">
            <span
              v-if="reviews.tasks_count != 0"
              class="tag tag--small tag--color"
            >{{ reviews.tasks_count}}
              <span class="--color" v-if="reviews.tasks_count == 1">Comment</span>
              <span class="--color"  v-if="reviews.tasks_count > 1">Comments</span>
            </span>
            <!-- <div class="dashboard__item__date">
              <span>{{ reviews.created_at | moment("from", "now") }}</span>
            </div> -->
            <!-- <div class="dashboard__item__tags">
              <span
                v-for="(tag, index) in reviews.tags"
                class="tag tag--small"
              >{{ tag.name }}</span>
            </div> -->
          </div>
        </div>
      </div>

      <div
        v-if="reviews.image != null"
        class="dashboard__item__image"
        v-bind:style="{ backgroundImage: 'url(' + parseJson(reviews.image).small.file + ')'}"
      ></div>

    </div>

</div>
</div>



<div
  class="dashboard__projects__drafts"
  v-if="projects.drafts != ''"

>
<div class="dashboard__inner__wrapper">



  <div
    class="dashboard__status">
    <h5>Drafts</h5>
    <!-- <button
      class="button--small button--cta"
      v-on:click="createProject()"
    >New Story</button> -->


  </div>

  <div
    class="dashboard__item"
    v-for="(drafts, index) in projects.drafts"
    v-bind:class="[{'is-active':(drafts.id === projectId)}]"
  >

    <div class="dashboard__item__content">
      <div class="dashboard__item__title" >
        <h3><a :href="`/cms/project/${ drafts.slug }`">{{ drafts.title }}</a></h3>
      </div>
      <!-- <div
        class="dashboard__item__description"
        v-if="drafts.description !== null"
      >
        <span class="is-paragraph">{{ drafts.description }}</span>
      </div> -->
      <div class="dashboard__item__footer">
        <!-- <div class="dashboard__item__user">
          <span
            v-for="(peer, index) in drafts.users"

          >{{ peer.name }}</span>
        </div> -->
        <div class="dashboard__item__details">
          <div class="dashboard__item__date">
            <span>{{ formatDate(drafts.updated_at, 'elapsed') }}</span>
          </div>
          <!-- <div class="dashboard__item__tags">
            <span
              v-for="(tag, index) in drafts.tags"
              class="tag tag--small"
            >{{ tag.name }}</span>
          </div> -->
        </div>
      </div>
    </div>

    <div
      v-if="drafts.image != null"
      class="dashboard__item__image"
      v-bind:style="{ backgroundImage: 'url(' + parseJson(drafts.image).small.file + ')'}"
    ></div>

  </div>



</div>
</div>


<div
  class="dashboard__projects__published"
  v-if="projects.published != ''"
  >
  <div class="dashboard__inner__wrapper">

  <div
    class="dashboard__status">
    <h5>Published</h5>
  </div>

    <div
      class="dashboard__item"
      v-for="(published, index) in projects.published"
      v-bind:class="[{'is-active':(published.id === projectId)}]"
    >

      <div class="dashboard__item__content">
        <div
          class="dashboard__item__marker"
          v-if="parseJson(published.booking).isEvent"
        >
          <div class="ic event" ></div>
          <span class="is-paragraph">{{ formatDate(parseJson(published.booking).date, 'date') }}</span>
        </div>
        <div class="dashboard__item__title" >
          <h3><a :href="`/cms/project/${ published.slug }`">{{ published.title }}</a></h3>
        </div>

        <div
          class="dashboard__item__description"
          v-if="published.description !== null"
        >
          <span class="is-paragraph">{{ published.description }}</span>
        </div>
        <!-- <div
          class="marker__event"
          v-if="parseJson(published.booking).isEvent == true"
        > -->

        <!-- <div
          class="ic ic--inline more dashboard__item__more"
          v-on:click="dashboardItemMore = index"
        ></div> -->

        <!-- <span>{{ dashboardItemMore}}</span>
        <span>{{ index}}</span> -->


        <!-- <span class="ic more"></span> -->

        <div
          class="dashboard__item__footer"
        >


          <div class="dashboard__item__details">
            <div class="dashboard__item__date">
              <span>{{ formatDate(published.updated_at, 'date') }}</span>
            </div>
            <div class="dashboard__item__user">
              <span
                v-for="(peer, index) in published.users"
                v-if="peer.id != user.id"
              >{{ peer.name }}</span>
            </div>
            <div class="dashboard__item__tags">
              <span
                v-for="(tag, index) in published.tags"
                class="tag tag--small"
              >{{ tag.name }}</span>

            </div>
          </div>
        </div>
      </div>

      <div
        v-if="published.image != null"
        class="dashboard__item__image"
        v-bind:style="{ backgroundImage: 'url(' + parseJson(published.image).small.file + ')'}"
      ></div>

    </div>

  <div
    class="dashboard__more"
    v-bind:class="{'is-hidden': isHidden.dashboardStoriesMore == true }"
  >
    <button class="button--small" v-on:click="getMoreProjects()">Show more</button>
  </div>

</div>
</div>


</div>

<div
  id="dashboard__pages"
  v-bind:class="{'is-hidden': isHidden.dashboardStories }"
>

<div class="dashboard__title">
  <h2>Pages</h2>
  <div class="flex__filler"></div>
  <div
    class="ic add"
    v-on:click="createPage()"
  ></div>
  <!-- <button
    class="button--small button--cta"
    v-if="isHidden.dashboardStories == false"
    v-on:click="createPage()">
  New Page</button> -->


</div>



<div
  class="dashboard__pages__drafts"
  v-if="pages.drafts != ''"
>

  <div class="dashboard__inner__wrapper">

    <div class="dashboard__status">
      <h5>Drafts</h5>
      <!-- <button
        class="button--small button--cta"
        v-on:click="createPage()"
      >New Page</button> -->

    </div>


      <div
        class="dashboard__item"
        v-for="(draft, index) in pages.drafts"
        :key="index"
      >
        <div class="dashboard__item__title">
          <h4><a :href="`/cms/page/${ draft.slug }`">{{ draft.title }}</a></h4>
          <!-- <span v-if="draft.status == 0" class="tag tag--small">Draft</span> -->
        </div>

        <div class="dashboard__item__footer">
          <span class="date">{{ formatDate(draft.updated_at, 'elapsed') }}</span>
        </div>

      </div>

  </div>
</div>

<div
  class="dashboard__pages__published"
  v-if="pages.published != ''"
>

<div class="dashboard__inner__wrapper">

  <div class="dashboard__status">
    <h5>Published</h5>
  </div>

    <div
      class="dashboard__item"
      v-for="(published, index) in pages.published"
      :key="index"
    >

      <div class="dashboard__item__title">
        <h4><a :href="`/cms/page/${ published.slug }`">{{ published.title }}</a></h4>
        <!-- <span class="count">({{ JSON.parse(published.content).length }})</span> -->
        <div
          v-if="published.slug == 'disclaimer' || published.slug == 'home'"
          class="ic ic--inline lock">
        </div>
        <div
          v-if="published.cta == 1"
          class="ic ic--inline cta">
        </div>
      </div>

      <div class="dashboard__item__footer">
        <span class="date">{{ formatDate(published.updated_at, 'elapsed') }}</span>
      </div>

    </div>
  </div>

</div>
</div>

</div>

<div id="dashboard__footer">
  <ul>
    <li v-if="user.role_id == 1 || user.role_id == 2">
      <a href="/cms/settings">
        <div class="ic settings"></div>
      </a>
    </li>
    <li>
      <a href="/cms/profile">
        <div class="ic profile"></div>
      </a>
    </li>
    <li>
      <a v-on:click="logout()">
        <div class="ic logout"></div>
      </a>
    </li>
  </ul>
</div>

</div>

</template>

<script>
let initialTimer;

export default {
  props: {
    isUpdated: false,
    projectId: '',
    pageId: '',
  },
  data() {
    return {
      search: {
        project: ''
      },
      status: {
        page: {
          draft: {
            id: 0,
            title: 'Your Drafts'
          },
          published: {
            id: 2,
            title: 'Published Pages'
          }
        }
      },
      isHidden: {
        dashboard: false,
        search: true,
        dashboardStories: false,
        dashboardSettings: true,
        dashboardStoriesMore: false,
      },
      limit: {
        published: 3
      },
      dashboardItemMore: '',
      save: false,
      pages: {},
      projects: {},
      auth: false,
      apiToken: window.Laravel.api_token,
      user: window.Laravel.user,
      csrf: window.Laravel.csrfToken
    }
  },

  methods: {
    pickItem(id) {
      this.$emit('dashboardItemId', id)
    },
    getPages() {
      axios
        .get('/api/pages')
        .then(response => (
          this.pages = response.data,
          this.checkAuth()
        )
      )
    },
    getProjects(limit) {
      axios
        .get('/api/projects/limit/' + limit)
        .then((response) => {
          this.projects = response.data
        })
    },
    createProject() {
      axios
        .post('/api/projects')
        .then(response => (window.location.href = '/cms/project/' + response.data.slug))
    },
    createPage() {
      axios
        .post('/api/pages')
        .then(response => (window.location.href = '/cms/page/' + response.data.slug))
    },
    deleteProject(id) {
      axios
        .delete('/api/projects/' + id)
        .then(this.getProjects())
    },
    searchProject() {
      let self = this;
      if (initialTimer) {
        clearTimeout(initialTimer);
      }
      initialTimer = setTimeout(function () {
        let query = self.$refs.projectTitle.value;
        if(query != '') {
          axios
          .get('/api/projects/search/' + query)
          .then((response) => {
            self.projects = response.data,
            self.isHidden.dashboardStoriesMore = true
          })
        }
        if(query == '') {
          self.getProjects(self.limit.published),
          self.isHidden.dashboardStoriesMore = false
        }
      }, 200);
    },
    logout() {
      axios
      .post('/logout')
      .then(window.location.replace("http://localhost:8000"));
    },
    checkAuth() {
      if(this.user.role_id == 1 || this.user.role_id == 2) {
        this.auth = true
      }
    },
    getMoreProjects() {
      this.limit.published = this.limit.published + 10,
      this.getProjects(this.limit.published);
    },
    parseJson(str) {
        return JSON.parse(str);
    },
  },
  created () {
    this.getPages()
    this.getProjects(this.limit.published)
  }
}


</script>
