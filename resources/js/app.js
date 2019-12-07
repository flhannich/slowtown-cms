

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap'); //Axios sleeps here

window.Vue = require('vue');

Vue.mixin({
  methods: {
    formatDate(str, type) {
      let offset = new Date().getTimezoneOffset();
      let today = new Date();
      let itemDate = new Date(str);

      if(type == 'date') {
        let a = today.getFullYear();
        let b = itemDate.getFullYear();
        if(a === b) {
          var options = { month: 'long', day: 'numeric', timeZone: 'Europe/Berlin'};
        } else {
          var options = { year: 'numeric', month: 'long', day: 'numeric', timeZone: 'Europe/Berlin'};
        }
        return itemDate.toLocaleDateString("de-DE", options);
      }
      if(type == 'elapsed') {
        let seconds = Math.floor((today - itemDate) / 1000);

        let interval = Math.floor(seconds / 31536000);
        if (interval > 1) {
          return interval + " years ago";
        }
        interval = Math.floor(seconds / 2592000);
        if (interval > 1) {
          return interval + " months ago";
        }
        interval = Math.floor(seconds / 86400);
        if (interval > 1) {
          return interval + " days ago";
        }
        interval = Math.floor(seconds / 3600);
        if (interval > 1) {
          return interval + " hours ago";
        }
        interval = Math.floor(seconds / 60);
        if (interval > 1) {
          return interval + " min ago";
        }
        // return Math.floor(seconds) + " seconds ago";
        return "Less than a minute";
      }
    },
    // capitalizeFirstLetter: str => str.charAt(0).toUpperCase() + str.slice(1)
  }
})

Vue.directive('autosize', {
  update: function (el) {
    el.setAttribute('style', 'height:' + (el.scrollHeight) + 'px;');
    el.addEventListener("input", OnInput, false);
    function OnInput() {
      this.style.height = 'auto';
      this.style.height = (this.scrollHeight) + 'px';
    }
  }
})


Vue.component('tabs', {
  template: `
  <div>
    <div class="tabs">
      <ul>
        <li v-for="tab in tabs"><a>{{ tab }}</a></li>
      </ul>
    </div>

    <div class="tabs__content">
      <slot></slot>
    </div>

  </div>
  `,
  data() {
    return {
      tabs: []
    };
  },
  created() {
    this.tabs = this.$children;
    console.log(this.tabs)
  }
});


Vue.component('tab', {
  template: `
    <div><slot></slot></div>
  `,
  probs: {
    name: { required: true }
  }
});



// Vue.use(require('vue-autosize'))

// if(document.querySelectorAll('.item__controls')) {
//
  // let target = event.path[1].querySelector('.item__controls');
  // if (event.path[0].tagName === 'IMG') {
  //   target.classList.add('is-active')
  // }
// }
// Vue.use(require('vue-autosize'))
// Vue.use(VueTextareaAutosize)

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key)))



 //
 // import draggable from 'vuedraggable'
 // Vue.use(draggable)


// PUBLIC

Vue.component(
  'site-header',
  require('./components/public/header.vue').default
);
Vue.component(
  'site-footer',
  require('./components/public/footer.vue').default
);
Vue.component(
  'home',
  require('./components/public/home.vue').default
);
Vue.component(
  'project',
  require('./components/public/project.vue').default
);
Vue.component(
  'page',
  require('./components/public/page.vue').default
);
Vue.component(
  'contact',
  require('./components/public/contact.vue').default
);
Vue.component(
  'login',
  require('./components/public/login.vue').default
);
Vue.component(
  'comments',
  require('./components/public/comments.vue').default
);


// EXCHANGE

Vue.component(
  'exchange-page-project',
  require('./components/exchange/page-project.vue').default
);
Vue.component(
  'exchange-project',
  require('./components/exchange/project.vue').default
);

//EXCHANGE TEMPLATES
Vue.component(
  'header-a',
  require('./components/exchange/templates/header-a.vue').default
);
Vue.component(
  'section-a',
  require('./components/exchange/templates/section-a.vue').default
);
Vue.component(
  'section-b',
  require('./components/exchange/templates/section-b.vue').default
);
Vue.component(
  'section-c',
  require('./components/exchange/templates/section-c.vue').default
);
// INTERN

Vue.component(
  'intpage',
  require('./components/app/page.vue').default
);
Vue.component(
  'intdialogue',
  require('./components/app/dialogue.vue').default
);
Vue.component(
  'inttasks',
  require('./components/app/tasks.vue').default
);
Vue.component(
  'inteditor',
  require('./components/app/editor/editor.vue').default
);
Vue.component(
  'intdashboard',
  require('./components/app/dashboard.vue').default
);
Vue.component(
  'intproject',
  require('./components/app/project.vue').default
);
Vue.component(
  'intsettings',
  require('./components/app/settings.vue').default
);
Vue.component(
  'intprofile',
  require('./components/app/profile.vue').default
);




// Vue.directive('click-outside', {
//   bind: function (el, binding, vnode) {
//     this.event = function (event) {
//       if (!(el == event.target || el.contains(event.target))) {
//         vnode.context[binding.expression](event);
//       }
//     };
//     document.body.addEventListener('click', this.event)
//   },
//   unbind: function (el) {
//     document.body.removeEventListener('click', this.event)
//   },
// });

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app'
});
