<template>
  <div>

          <!-- <a :href="`/article/${ project.slug }`">Project Link</a> -->

          <!-- <div v-if="returnJson(project.booking).isEvent == true">
            <span>{{ formatDate(returnJson(project.booking).date, 'date') }}</span>
            <span>{{ returnJson(project.booking).starttime }}</span>
            <span>{{ returnJson(project.booking).duration }}</span>
          </div> -->

          <!-- <span v-for="(user, index) in project.users">
            {{ user.name }}
          </span> -->

          <!-- <span>{{ formatDate(project.updated_at, 'date') }}</span> -->


          <!-- <figure class="col-xs-12 col-sm-8 col-md-6 col-lg-4">
            <img
              :srcset="`
                ${ returnJson(project.image).small.file } ${ returnJson(project.image).small.size }w,
                ${ returnJson(project.image).medium.file } ${ returnJson(project.image).medium.size }w,
                ${ returnJson(project.image).large.file } ${ returnJson(project.image).large.size }w,
                ${ returnJson(project.image).full.file } ${ returnJson(project.image).full.size }w
              `"
              :src="returnJson(project.image).medium.file"
            >
          </figure> -->

          <header class="row center-lg">
            <div
              v-if="project.title"
              class="header__title col-xs-12 col-sm-8 col-md-6 col-lg-4"
            >
              <h2>{{ project.title }}</h2>
            </div>

            <div
              v-if="project.description"
              class="header__description col-xs-12 col-sm-8 col-md-6 col-lg-4"
            >
              <h4>{{ project.description }}</h4>
            </div>
          </header>

          <section class="row center-lg">
            <div
              v-if="project.content"
              class="col-xs-12 col-sm-8 col-md-6 col-lg-4"
              v-html="project.content"
            ></div>
          </section>



        </div>
        <!-- <div class="row">
          <section
            class="col-xs-12 col-sm-8 col-md-6 col-lg-4"
            v-html="project.content"
          ></section>
        </div> -->
</template>



<script>
export default {
  props: {
    link: {
      type: String
    },
    type: {
      type: Object
    },
    project: {
      type: Object
    },
  },
  data() {
    return {
      apiToken: window.Laravel.api_token,
      user: window.Laravel.user,
      csrf: window.Laravel.csrfToken
    }
  },
  methods: {
    returnJson(elem) {
        return JSON.parse(elem);
    },
  },
}
</script>
