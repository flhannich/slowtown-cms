<template>
<div>

        <article class="article">

          <!-- <figure v-if="project.image != null" class="project__image" >
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

          <div id="project__title">
            <h1>{{ project.title }}</h1>
          </div>

          <div id="project__description">
            <h3>{{ project.description }}</h3>
          </div>

          <div id="project__content" v-html="project.content"></div>

        </article>


        <!-- <section>




          <div
            v-if="type.title"
            class="item__title"
          >
            <h1 v-if="type.class == 'header'">{{ project.title }}</h1>
            <h2 v-else>{{ project.title }}</h2>
          </div>


          <div
            v-if="type.description"
            class="item__description"
          >
            <h4>{{ project.description }}</h4>
          </div>


          <div
            class="item__event"
            v-if="type.event"
          >
            <span><b>{{ formatDate(returnJson(project.booking).date, 'date') }}</b>&nbsp;&nbsp;&middot;&nbsp;</span>
            <span>{{ returnJson(project.booking).starttime }}</span>
            <span class="duration"><div class="ic sprite time ic--inline"></div>{{ returnJson(project.booking).duration }}</span>
          </div>


          <div class="item__details"
            v-if="type.date || type.author"
          >
            <div
              v-if="type.author"
              class="item__author"
            >
              <span
                v-for="(user, index) in project.users"
              >
                {{ user.name }}
              </span>
            </div>
            <div
              class="item__date"
              v-if="type.date"
            >
              <span>{{ formatDate(project.updated_at, 'date') }}</span>
            </div>
          </div>


          <div
            class="item__content"
            v-if="type.content"
            v-html="project.content"
          ></div>


          <div
            class="item__contact"
            v-if="type.contactForm"
          >
            <contact></contact>
          </div>


          <div
            v-if="type.cta"
            class="item__button"
          >
          <div
            v-for="item in menu"
            v-if="item.cta == 1"
          >
            <button class="--cta"><a :href="`/page/${ item.slug }`">{{ item.title }}</a></button>
          </div>

          </div>

        </section> -->


</div>
</template>



<script>
export default {
  // props: ['project', 'type'],
  props: {
    project: {
      type: Object,
    }
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
