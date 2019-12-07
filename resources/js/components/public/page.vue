<template>
<div id="page">

<site-header :menu="menu" :logo="settings.image" :settings="settings" ></site-header>

<article class="page__content">

  <section
    class="page__items"
    v-for="item in page.page"
  >
    <exchange-page-project
      v-for="project in page.projects"
      v-if="item.id == project.id && item.title === 'project'"
      :type="getTypeObj(item.type_id)"
      :class="getTypeObj(item.type_id).class"
      :project="project"
      :menu="menu"
      :key="project.id"
    ></exchange-page-project>

    <div
      v-if="group.id === item.id && item.title === 'tag'"
      v-for="group in page.tags"
      :key="group.id"
      class="item group"
    >

      <div class="wrapper">

        <exchange-page-project
          v-for="(elem, index) in group.project"
          :project="elem"
          :menu="menu"
          :type="getTypeObj(item.type_id)"
          :key="elem.id"
          :class="getTypeObj(item.type_id).class"
          class="elem"
        ></exchange-page-project>

    </div>
  </div>


  </section>


</article>

<site-footer :menu="menu" :logo="settings.image" :settings="settings"></site-footer>

</div>
</template>

<script>
export default {
  props: ['slug'],
  data() {
    return {
      settings: {},
      logo: {},
      page: {},
      menu: {},
      types: {},
      csrf: window.Laravel.csrfToken
    }
  },
  props: {
    slug: {
      type: String,
      required: true,
    },
  },
  methods: {
    getPage() {
      axios
        .get('/public/api/page/' + this.slug)
        .then((response) => {
          this.page = response.data
        })
    },
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
    returnJson(elem) {
        return JSON.parse(elem);
    },
    getTypeObj(id) {
       for(let i in this.page.types) {
         if(this.page.types[i].id == id) {
           return this.page.types[i]
         }
       }
    }
  },
  created () {
    this.getPage()
    this.getMenu()
    this.getSettings()
  }
}
</script>
