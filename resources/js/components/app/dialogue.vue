<template>
  <div class="dialogue">
    <div class="dialogue__header">
      <h3>{{ dialogueTitle }}</h3>
    </div>
    <div class="dialogue__body">
      <span>{{ dialogueContent }}</span>
    </div>
    <div class="dialogue__footer">
      <button
        class="button--small"
        v-bind:class="dialogueCancelClass"
        v-on:click="cancel"
      >{{ dialogueCancelText }}</button>
      <button
        class="button--small"
        v-bind:class="dialogueConfirmClass"
        v-on:click="confirm"
      >{{ dialogueConfirmText }}</button>
    </div>
  </div>
</template>

<script>
  export default {
    props: {
        dialogueTitle: {
          type: String,
          required: true,
        },
        dialogueContent: {
          type: String,
          required: true,
        },
        dialogueConfirmText: {
          type: String,
          required: true,
        },
        dialogueConfirmClass: {
          type: String,
          required: true,
        },
        dialogueCancelText: {
          type: String,
          required: true,
        },
        dialogueCancelClass: {
          type: String,
          required: true,
        },
    },
    methods: {
      confirm() {
          this.$emit('dialogue-confirm')
      },
      cancel() {
          this.$emit('dialogue-cancel')
      }
    },
  }
</script>
