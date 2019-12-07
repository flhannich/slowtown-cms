<template>
  <header class="--main">
    <a
      class="logo"
      v-if="logo.small"
      :href="settings.url"
      :title="settings.title"
    >
      <img
        :srcset="`
          ${ logo.small.file } ${ logo.small.size }w,
          ${ logo.medium.file } ${ logo.medium.size }w,
          ${ logo.large.file } ${ logo.large.size }w,
          ${ logo.full.file } ${ logo.full.size }w
        `"
        :src="logo.medium.file"
        :alt="settings.title"
      >
    </a>


    <div class="flex__filler"></div>
    <nav class="top">
      <ul>
        <li
          v-for="item in menu"
          v-if="item.slug != 'home' && item.menu != 'disclaimer' && item.slug != 'impress' && item.cta != 1 && item.menu != 1"
        >
          <a :href="`/page/${ item.slug }`">{{ item.title }}</a>
        </li>
      </ul>
    </nav>
    <div
      v-for="item in menu"
      v-if="item.cta == 1"
    >
      <button class="--cta"><a :href="`/page/${ item.slug }`">{{ item.title }}</a></button>
    </div>
  </header>

</template>

<script>

export default {
  data() {
    return {
      csrf: window.Laravel.csrfToken
    }
  },
  props: {
    menu: {
      // type: Array,
      // required: true,
    },
    logo: {
      type: Object
    },
    settings: {
      type: Object,
      required: true,
    },
  },
}
</script>
