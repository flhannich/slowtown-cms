<template>
<header-a
  v-if="type.class == 'header-a'"
  :project="project"
  :type="type"
  :class="type.class"
></header-a>


<section-a
  v-else-if="type.class == 'section-a'"
  :project="project"
  :type="type"
  :class="type.class"
></section-a>

<section-b
  v-else-if="type.class == 'section-b'"
  :project="project"
  :type="type"
  :class="type.class"
></section-b>

<section-c
  v-else-if="type.class == 'section-c'"
  :project="project"
  :type="type"
  :class="type.class"
></section-c>

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
