<template>
<div>

  <div id="login">

    <div class="content__block">
      <label for="email">E-mail</label>
      <input
        v-on:keyup.enter="verify()"
        class="is--site"
        type="email"
        name="email"
        v-model="email "
        required
        autofocus>
    </div>

    <div class="content__block">
      <label for="password">Password</label>
      <input
        v-on:keyup.enter="verify()"
        class="is--site"
        type="password"
        name="password"
        v-model="password "
        required>
    </div>

    <div class="content__block">
      <button
        class="--cta"
        v-on:click="verify()"
      >Login</button>
    </div>

  </div>

</div>
</template>

<script>
export default {
  data() {
    return {
      email: 'think@web.de',
      password: '123456',
      apiToken: window.Laravel.api_token,
      csrf: window.Laravel.csrfToken
    }
  },
  methods: {
    verify() {
      axios
        .post('/verify', {
          email: this.email,
          password: this.password
        })
        .then((response) => {
          console.log(response),
          window.location.href = '/cms/dashboard'
        })
    }
  }
}
</script>
