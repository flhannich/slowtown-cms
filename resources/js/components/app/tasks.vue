<template>

  <div>

    <div id="project__tasks__header">
      <span class="title">Comments</span>
      <div class="flex__filler"></div>
      <div
        class="ic close"
        @click="tasksHide()"
      ></div>
    </div>

    <div class="task__create">
          <textarea
            type="text"
            rows="1"
            v-autosize
            v-model="newTaskDescription"
            placeholder="Write a comment...  "
            required
          >
          {{ newTaskDescription }}</textarea>
          <button class="ic arrow-right" v-on:click="createTask(projectId)"></button>
        <!-- <div class="task__footer">
          <button class="button--small" v-on:click="createTask(projectId)">Post</button>
          <div class="ic reply" v-on:click="isHidden.createTaskReply = !isHidden.createTaskReply"></div>
          <div class="ic save ic--inline" v-on:click="createTask(projectId)"></div>
        </div> -->
    </div>

        <div class="task__group" v-if="task.parent_id == null" v-for="(task, taskIndex) in tasks" :key="task.id">

          <div class="task">
            <div class="task__avatar">
              <img
                class="task__avatar"
                v-if="task.user.image != null"
                :src="parseJson(task.user.image).small.file"
              >
            </div>
            <div class="task__content">
              <div class="task__header">
                <div class="task__user">
                  <h6>{{ task.user.name }} </h6>
                </div>
                <div class="task__date">
                  <span>&nbsp;&middot;&nbsp;{{ formatDate(task.created_at, 'elapsed') }}</span>
                </div>
                <div class="flex__filler"></div>
                <div
                  v-if="task.user.id == user.id"
                  class="ic trash ic--inline" v-on:click="deleteTask(task.id)"
                ></div>

                <!-- <input type="checkbox" :true-value="'1'" :false-value="'0'" v-model="task.completed"> -->
                <!-- <span>{{ task.user.name }} &middot; {{ task.created_at | moment("from", "now") }}</span> -->
              </div>

              <div class="task__body">
                <span class="is-paragraph" v-model="task.description">{{ task.description }}</span>
              </div>
              <!-- <div class="task__footer">
                <button v-if="task.reply.length == 0 " class="button--small" v-on:click="updateTask(task.id, taskIndex)">Save</button>
                <div class="ic delete ic--inline" v-on:click="deleteTask(task.id)"></div>
                <div class="ic reply ic--inline" v-on:click="isHidden.createTaskReply = !isHidden.createTaskReply"></div>
              </div> -->
            </div>
          </div>


            <div v-if="task.reply" v-for="(reply, replyIndex) in task.reply" :key="task.reply.id">
              <div class="task task__reply">

                <div class="task__avatar">
                  <img
                    v-if="reply.user.image != null"
                    :src="parseJson(reply.user.image).small.file"
                  >
                </div>
                <div class="task__content">
                  <div class="task__header">
                    <div class="task__user" >
                      <h6>{{ reply.user.name }}</h6>
                    </div>

                    <div class="task__date">
                      <span>&nbsp;&middot;&nbsp;{{ formatDate(reply.created_at, 'elapsed') }}</span>
                    </div>
                  </div>

                  <div class="task__body">
                    <span class="is-paragraph" v-model="reply.description">{{ reply.description }}</span>
                  </div>
                </div>
                 <!-- <div class="task__footer">
                  <button class="button__small" v-on:click="updateTaskReply(reply.id, taskIndex, replyIndex)">Save</button>
                  <div class="ic delete is-inline" v-on:click="deleteTask(task.id)"></div>
                </div> -->
              </div>
            </div>

            <div class="task task__reply">
              <div class="task__avatar">
                <img
                  class="task__avatar"
                  v-if="user.image != null"
                  :src="parseJson(user.image).small.file"
                >
              </div>
              <div class="task__content">
                <div class="task__body">
                  <textarea
                    type="text"
                    rows="1"
                    v-autosize
                    v-model="task.newReplyDescription"
                    placeholder="Write a reply"
                    required
                  >
                  {{ task.newReplyDescription }}</textarea>
                  <button class="ic arrow-right" v-on:click="createTaskReply(projectId, task.id, taskIndex)"></button>
                </div>
                <!-- <div class="task__footer">
                </div> -->
              </div>
            </div>

            <!-- <div class="task__create taskl__reply" v-bind:class="{'is-hidden': isHidden.createTaskReply }">
              <div class="task__body">
                <textarea
                  type="text"
                  rows="1"
                  v-autosize
                  v-model="task.newReplyDescription"
                  placeholder="Write a reply"
                  required
                >{{ task.newReplyDescription }}</textarea>
              </div>
              <div class="task__footer">
                <button class="button--small" v-on:click="createTaskReply(projectId, task.id, taskIndex)">Post</button>
              </div>
            </div> -->

        </div><!--tasks group-->
        <div class="triangle"></div>
        <div class="modal__close" v-on:click="tasksHide()"></div>
</div>
</template>

<script>
export default {
  props: {
    projectId: '',
    users: '',
    slug: '',
  },
  data: function() {
    return {
      tasks: {},
      newTaskDescription: '',
      isHidden: {
        createTaskReply: false,
      },
      apiToken: window.Laravel.api_token,
      user: window.Laravel.user,
      csrf: window.Laravel.csrfToken
    }
  },
  methods: {
    parseJson(str) {
        return JSON.parse(str);
    },
    getTasks() {
      axios
        .get('/api/tasks/' + this.slug)
        .then(
          response => (this.tasks = response.data.data),
        )
    },
    createTask($projectId) {
      axios
      .post('/api/tasks/' + $projectId, {
        description: this.newTaskDescription
      })
      .then(
        this.newTaskDescription = '',
        this.getTasks()
      )
    },
    createTaskReply($projectId, $taskId, index) {
      axios
      .post('/api/tasks/ ' + $projectId + '/' + $taskId, {
        description: this.tasks[index].newReplyDescription
      })
      .then(
        this.tasks[index].newReplyDescription = '',
        this.getTasks()
      )
    },
    updateTask($taskId, taskIndex) {
      axios
      .patch('/api/tasks/' + $taskId, {
        description: this.tasks[taskIndex].description,
        completed: this.tasks[taskIndex].completed
      })
      .then(
        this.getTasks()
      )
    },
    updateTaskReply(replyId, taskIndex, replyIndex) {
      axios
      .patch('/api/tasks/' + replyId, {
        description: this.tasks[taskIndex].reply[replyIndex].description,
        completed: this.tasks[taskIndex].reply[replyIndex].completed
      })
      .then(
        this.getTasks()
      )
    },
    deleteTask($taskId) {
      axios
      .delete('/api/tasks/' + $taskId)
      .then(
        this.getTasks()
      )
    },
    getAuthors() {
      // if(this.project.users.some(( {id} ) => id === this.user.id) || this.user.role_id == 1 || this.user.role_id == 2) {
      //   this.auth = true
      // }
    },
    tasksHide() {
        this.$emit('tasksHide')
    },
  },
  created () {
    this.getTasks();
  },
}

</script>
