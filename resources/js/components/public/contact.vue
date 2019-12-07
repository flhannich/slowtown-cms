<template>
  <div>

  <div id="contact">
    <label for="Name">Name</label>
    <input class="is--site" name="title" type="text" v-model="contact.sender" placeholder="Your name">

    <label for="Name">Your Message</label>
    <input class="is--site" type="text" v-model="contact.content" placeholder="Your message">

    <label for="Name">Your Contact</label>
    <input class="is--site" type="text" v-model="contact.email" placeholder="E-mail">

    <button class="--cta" @click="sendMail">Send</button>
  </div>

</div>
</template>

<script>
export default {
  data() {
    return {
      message: {},
      contact: {
        sender: 'Max Mustermann',
        content: 'My little message',
        email: 'maxm@email.de'
      },
      apiToken: window.Laravel.api_token,
      user: window.Laravel.user,
      csrf: window.Laravel.csrfToken
    }
  },
  methods: {
    // getSettings() {
    //   axios
    //     .get('/api/settings')
    //     .then(response => (this.settings = response.data.data[0]))
    // },
    sendMail() {
      axios
        .post('/api/contact/', {
          sender: this.contact.sender,
          content: this.contact.content,
          email: this.contact.email
        })
    },
  },
  created () {
  }
}
</script>
