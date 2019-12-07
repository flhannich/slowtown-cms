<template>
  <footer>
    <div class="footer__wrapper">



    <nav>

      <!-- <section class="footer__contact">
        <button class="button--cta"><a class="button--cta" href="/page/contact">Contact</a></button>
      </section> -->







        <section class="footer__social">
          <h6>Folge uns</h6>
          <div
            v-for="(social, index) in settings.social"
            class="ic social"
            :class="social.provider"
          >
            <a :href="`${ social.url}`"></a>
          </div>
        </section>
        <section class="footer__navigation">
          <ul>
            <li
            v-for="item in menu"
            v-if="item.slug != 'home' && item.slug != 'disclaimer' && item.slug != 'impress' && item.cta != 1 && item.menu != 0"
            >
              <a :href="`/page/${ item.slug }`">{{ item.title }}</a>
            </li>
          </ul>
        </section>

        <section class="footer__legals">
          <span class="privacy"><a href="/page/disclaimer">Datenschutz</a></span>
          <span class="privacy"><a href="/page/impress">Impressum</a></span>
          <span> &copy; {{ new Date().getFullYear() }} {{ settings.title }}</span>
        </section>

    </nav>



        <!-- <a
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
        </a> -->

    </div>
  </footer>
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
      type: Object,
    },
    settings: {
      type: Object,
      required: true,
    },
  },
}
</script>
