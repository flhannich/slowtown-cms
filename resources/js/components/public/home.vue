<template>
<div>

<page class="site" slug="home"></page>

</div>
</template>

<script>
export default {
  data() {
    return {
      csrf: window.Laravel.csrfToken
    }
  },
}
</script>
