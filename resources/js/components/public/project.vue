<template>
<div>

<site-header :menu="menu" :logo="settings.image" :settings="settings" ></site-header>

<exchange-project :project="project"></exchange-project>

<comments
  id="project__comments"
  :projectId="project.id"
  :slug="slug"
></comments>

<site-footer :menu="menu" :logo="logo" :settings="settings"></site-footer>

</div>
</template>

<script>

export default {
  props: ['slug'],
  data() {
    return {
      settings: {},
      logo: {},
      menu: {},
      project: {},
      // apiToken: window.Laravel.api_token,
      // user: window.Laravel.user,
      csrf: window.Laravel.csrfToken
    }
  },
  methods: {
    getMenu() {
      axios
        .get('/public/api/menu/')
        .then((response) => {
          this.menu = response.data
      })
    },
    getSettings() {
      axios
        .get('/public/api/settings/')
        .then((response) => {
          this.settings = response.data,
          this.settings.image = JSON.parse(response.data.image)
          this.settings.social = JSON.parse(response.data.social)
        })
    },
    getProject() {
      axios
        .get('/public/api/project/' + this.slug)
        .then((response) => {
          this.project = response.data.data[0]
          // this.project.image = JSON.parse(this.project.image),
        })
    },
  },
  created () {
    this.getProject()
    this.getSettings()
    this.getMenu()
  }
}
</script>
