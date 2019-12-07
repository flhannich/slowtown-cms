<template>

  <div>

    <div class="comment__create">
      <input
        type="text"
        v-model="newCommentAuthor"
        placeholder="Your Name"
        required
      >
      <textarea
        type="text"
        rows="1"
        v-autosize
        v-model="newCommentContent"
        placeholder="Write a comment...  "
        required
      >
      {{ newCommentContent }}</textarea>
      <button class="ic ic--inline save" v-on:click="createComment(projectId)">Save</button>
    </div>

    <div
    v-for="(comment, index) in comments"
    :key="comment.id"
    style="padding: 16px;"
    >
      <div><span>{{ comment.author }}</span></div>
      <div><span>{{ comment.content }}</span></div>
      <a @click="toggleReplyBox(comment)">Reply</a>
      <a @click="likeComment(comment.id)">like ({{ comment.like }})</a>

      <div
        class="comment__reply"
        v-if="comment.showReply"
      >
        <input
          type="text"
          v-model="comment.newCommentReplyAuthor"
          placeholder="Your Name"
          required
        >
            <textarea
              type="text"
              rows="1"
              v-autosize
              v-model="comment.newCommentReplyContent"
              placeholder="Write a comment...  "
              required
            >
            {{ comment.newCommentReplyContent }}</textarea>
            <button class="ic ic--inline save" v-on:click="createCommentReply(comment.id, index)">Reply</button>
      </div>

    </div>

  </div>
</template>

<script>
export default {
  props: {
    projectId: '',
    newCommentContent: '',
    newCommentAuthor: '',
    slug: '',
  },
  data: function() {
    return {
      comments: {},
      apiToken: window.Laravel.api_token,
      user: window.Laravel.user,
      csrf: window.Laravel.csrfToken
    }
  },
  methods: {
    parseJson(str) {
        return JSON.parse(str);
    },
    getComments() {
      axios
        .get('/public/api/comments/' + this.slug)
        .then(
          response => (
            this.comments = response.data.data
          ),
        )
    },
    createComment() {
      axios
      .post('/public/api/comments/' + this.projectId, {
        content: this.newCommentContent,
        author: this.newCommentAuthor
      })
      .then(
        this.newCommmentContent = '',
        this.newCommmentAuthor = '',
        this.getComments()
      )
    },
    createCommentReply(parentId, index) {
      axios
      .post('/public/api/comments/ ' + this.projectId + '/' + parentId, {
        content: this.comments[index].newCommentReplyContent,
        author: this.comments[index].newCommentReplyAuthor
      })
      .then(
        this.comments[index].newCommentReplyContent = '',
        this.comments[index].newCommentReplyAuthor = '',
        this.getComments()
      )
    },
    // updateComment(commentId, index) {
    //   axios
    //   .patch('/api/comments/' + commentId, {
    //     approved: this.comments[index].approved
    //   })
    //   .then(
    //     this.getComments()
    //   )
    // },
    likeComment(id) {
      axios
      .patch('/public/api/comments/' + id + '/like')
      .then(
        this.getComments()
      )
    },
    deleteComment(id) {
      axios
      .delete('/api/comments/' + id)
      .then(
        this.getComments()
      )
    },
    toggleReplyBox(data) {
    if(data.hasOwnProperty('showReply')){
        data.showReply = !data.showReply;
    } else {
        this.$set(data, 'showReply', true);
    }
    console.log(data);

  },
  },
  created () {
    this.getComments();
  },
}

</script>
