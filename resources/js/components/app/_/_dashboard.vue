<template>
<div>


<div id="dashboard__header">

  <!-- <div class="logo"><a href="/dashboard"></a></div> -->

  <ul>
    <li>
      <a
        class="menu"
        v-on:click="isHidden.dashboardPages = true, isHidden.dashboardProjects = false"
        v-bind:class="{'is-active': isHidden.dashboardPages }"
      >Stories</a>
    </li>
    <li>
      <a
        class="menu"
        v-on:click="isHidden.dashboardPages = false, isHidden.dashboardProjects = true"
        v-bind:class="{'is-active': isHidden.dashboardProjects  }"
      >Pages</a>
    </li>

  </ul>



  <div
    id="search__project"
    v-if="isHidden.dashboardProjects == false"

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



  <button
    class="button--small button--cta"
    v-if="isHidden.dashboardPages == false"
    v-on:click="createPage()">
  New Page</button>

  <button
    class="button--small button--cta"
    v-if="isHidden.dashboardProjects == false"
    v-on:click="createProject()"
  >New Story</button>


  <!-- <div
    id="dashboard__trigger"
    class="ic close"
    v-on:click="dashboardHide()"
  ></div> -->

</div>


<div id="dashboard__items">

<div
  id="dashboard__projects"
  v-bind:class="{'is-hidden': isHidden.dashboardProjects }"
>

<div class="dashboard__title">
  <h1>Stories</h1>
  <div class="flex__filler"></div>
  <!-- <button
    class="button--small button--cta"
    v-on:click="createProject()"
  >New Story</button> -->
  <div id="search__project">
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
    class="ic add"
    v-on:click="createProject()"
  ></div>

</div>



<div
  class="dashboard__projects__reviews"
  v-if="projects.reviews != ''"
>
<div class="dashboard__inner__wrapper">

  <div
    class="dashboard__status">
    <h5>Reviews</h5>
  </div>

    <div
      class="dashboard__item"
      v-bind:class="[{'is-active':(reviews.id === projectId)}]"
      v-for="(reviews, index) in projects.reviews"
      :key="index"
    >
        <!-- <div class="dashboard__item__image">
          <a :href="`/cms/project/${ reviews.slug }`">
            <img
              v-if="reviews.image != null"
              :src="parseJson(reviews.image).medium.file"
            >
          </a>
        </div> -->
        <div
          v-if="reviews.image != null"
          class="dashboard__item__image"
          v-bind:style="{ backgroundImage: 'url(' + parseJson(reviews.image).small.file + ')'}"
        ></div>

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
            <!-- <span
              v-if="reviews.tasks_count != 0"
              class="tag tag--small tag--color"
            >{{ reviews.tasks_count}} Comments
            </span> -->
            <span
              v-for="(tag, index) in reviews.tags"
              class="tag tag--small"
            >{{ tag.name }}</span>
            <span class="date">{{ reviews.created_at | moment("from", "now") }}</span>
            <div class="dashboard__item__user">
              <span
                v-for="(peer, index) in reviews.users"
              >{{ peer.name }}</span>
            </div>
          </div>

      </div>
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
    <h5>Your Drafts</h5>
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
        <div class="dashboard__item__user">
          <span
            v-for="(peer, index) in drafts.users"

          >{{ peer.name }}</span>
        </div>
        <div class="dashboard__item__details">
          <div class="dashboard__item__date">
            <span>{{ drafts.created_at | moment("from", "now") }}</span>
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
    <h5>Published Posts</h5>
  </div>

    <div
      class="dashboard__item"
      v-for="(published, index) in projects.published"
      v-bind:class="[{'is-active':(published.id === projectId)}]"
    >

      <div class="dashboard__item__content">
        <div class="dashboard__item__title" >
          <h3><a :href="`/cms/project/${ published.slug }`">{{ published.title }}</a></h3>
        </div>
        <span>{{ published }}</span>
        <div
          class="dashboard__item__description"
          v-if="published.description !== null"
        >
        </div>
        <div class="dashboard__item__footer">
          <div class="dashboard__item__user">
            <span
              v-for="(peer, index) in published.users"

            >{{ peer.name }}</span>
            <!-- v-if="(peer.id != user.id || published.users.length > 1)" -->
          </div>
          <div class="dashboard__item__details">
            <div class="dashboard__item__date">
              <span>{{ published.created_at | moment("from", "now") }}</span>
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
    v-bind:class="{'is-hidden': isHidden.dashboardProjectsMore == true }"
  >
    <button class="button--small" v-on:click="getMoreProjects()">Show more</button>
  </div>

</div>
</div>

</div>

<div
  id="dashboard__pages"
  v-bind:class="{'is-hidden': isHidden.dashboardPages }"
>

<div class="dashboard__title">
  <h1>Pages</h1>

  <!-- <button
    class="button--small button--cta"
    v-if="isHidden.dashboardPages == false"
    v-on:click="createPage()">
  New Page</button> -->
  <div class="flex__filler"></div>
  <div
    class="ic add"
    v-on:click="createPage()"
  ></div>
</div>



<div
  class="dashboard__pages__drafts"
  v-if="pages.drafts != ''"
>

  <div class="dashboard__inner__wrapper">

    <div class="dashboard__status">
      <h5>Your Drafts</h5>
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
          <span class="date">{{ draft.updated_at | moment("from", "now") }}</span>
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
      </div>

      <div class="dashboard__item__footer">
        <span class="date">{{ published.updated_at | moment("from", "now") }}</span>
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
        dashboardProjects: false,
        dashboardPages: true,
        dashboardProjectsMore: false,
      },
      limit: {
        published: 5
      },
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
            self.isHidden.dashboardProjectsMore = true
          })
        }
        if(query == '') {
          self.getProjects(self.limit.published),
          self.isHidden.dashboardProjectsMore = false
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
    // dashboardHide() {
    //     this.$emit('dashboardHide')
    // },
  },
  created () {
    this.getPages()
    this.getProjects(this.limit.published)
  }
}


</script>
