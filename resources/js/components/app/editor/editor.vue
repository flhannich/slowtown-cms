<template>

         <div
         class="editor"
         v-on:click="handleItemControl()"
         >
           <editor-menu-bubble
             v-if="editable"
             :editor="editor"
           >
           <!-- :bubblewidth="getBubbleWidth()" -->

             <div
              class="menububble"
              slot-scope="{ commands, isActive, focused, menu, getMarkAttrs }"
              :class="{ 'is-active': menu.isActive }"
              :style="`left: ${menu.left}px; bottom: ${menu.bottom}px;`"
             >
             <!-- class="menubar is-hidden"
             :class="{ 'is-focused': focused }" -->


             <!-- <editor-menu-bubble :editor="editor">
               <div
                 slot-scope="{ commands, isActive, getMarkAttrs, menu }"
                 class="menububble"
                 :class="{ 'is-active': menu.isActive }"
                 :style="`left: ${menu.left}px; bottom: ${menu.bottom}px;`"
               > -->

               <!-- <div
                class="prossemirror__icon ic comment"
                 :class="{ 'is-active': isActive.comment() }"
                 @click="setComment(commands.comment)"
               >
              </div> -->

              <div v-bind:class="{'is-hidden': menububbleIconsHidden }">

               <button
                 class="prossemirror__icon ic__editor bold"
                 :class="{ 'is-active': isActive.bold() }"
                 @click="commands.bold"
               >
              </button>

               <button
               class="prossemirror__icon ic__editor italic"
                 :class="{ 'is-active': isActive.italic() }"
                 @click="commands.italic"
               >
              </button>

              <button
              class="prossemirror__icon ic__editor link"
                 @click="showLinkMenu(getMarkAttrs('link'))"
                 :class="{ 'is-active': isActive.link() }"
               >
              </button>

              <button
                class="prossemirror__icon ic__editor headline"
                :class="{ 'is-active': isActive.heading({ level: 2 }) }"
                @click="commands.heading({ level: 2 })"
              >
              </button>

              <button
                class="prossemirror__icon ic__editor list"
                :class="{ 'is-active': isActive.bullet_list() }"
                @click="commands.bullet_list"
              >
              </button>

              <button
                class="prossemirror__icon ic__editor quote"
                :class="{ 'is-active': isActive.blockquote() }"
                @click="commands.blockquote"
              >
              </button>

              <!-- <button
                class="prossemirror__icon ic__editor close"
                @click="$emit('showNavigation')"
              >
              </button> -->



            </div>

              <form class="menububble__form" v-if="linkMenuIsActive" @submit.prevent="setLinkUrl(commands.link, linkUrl)">
                <input class="menububble__input is--app" type="text" v-model="linkUrl" placeholder="https://" ref="linkInput" @keydown.esc="hideLinkMenu"/>
                <button class="menububble__button ic__editor trash" @click="setLinkUrl(commands.link, null)" type="button"></button>
                <button class="menububble__button ic__editor close" @click="hideLinkMenu()" type="button"></button>
              </form>

              <div
                class="menububble__triangle"
                :style="`left: ${menu.triangleLeft}px;`"
              ></div>

             </div>
           </editor-menu-bubble>

           <editor-floating-menu
             v-if="editable"
             :editor="editor"
           >
            <div
              slot-scope="{ commands, isActive, menu }"
              class="editor__floating-menu"
              :class="{ 'is-active': menu.isActive }"
              :style="`top: ${menu.top}px`"
            >
              <div class="editor__floating-menu--content">
                <div v-if="!isLoading.upload" class="floating-menu__upload file__upload ic__editor image">
                  <input type="file" ref="image" accept="image/*|video/*" v-on:change="uploadImage(commands.insImage)"/>
                </div>
                <!-- <div v-if="!isLoading.upload" class="floating-menu__upload file__upload ic__editor video">
                  <input type="file" ref="video" accept="image/*|video/*" v-on:change="uploadVideo(commands.insVideo)"/>
                </div> -->
                <div v-if="isLoading.upload" class="ic loading"></div>
                <!-- <button
                  class="prossemirror__icon ic__editor close"
                  @click="$emit('showNavigation')"
                >
                </button> -->
              </div>
            </div>
          </editor-floating-menu>
          <editor-content class="editor__content" :editor="editor"  />
        </div>

</template>


<script>
// import Comment from './comment.js'
import InsImage from './image.js'
import InsVideo from './video.js'
import EditorMenuBubble from './menu/EditorMenuBubble.js'

import { Editor, EditorContent, EditorFloatingMenu } from 'tiptap'
import {
  Blockquote,
  CodeBlock,
  HardBreak,
  Heading,
  OrderedList,
  BulletList,
  ListItem,
  TodoItem,
  TodoList,
  Bold,
  Code,
  Italic,
  Link,
  Strike,
  Underline,
  History,
  Image,
  Placeholder,
} from 'tiptap-extensions'


export default {
  components: {
    EditorFloatingMenu,
    EditorContent,
    EditorMenuBubble,
  },
  props: ['content', 'id', 'editable'],
  data: function() {
    return {
      editor: new Editor({
        extensions: [
          new Blockquote(),
          new CodeBlock(),
          new HardBreak(),
          new Heading({ levels: [1, 2, 3] }),
          new BulletList(),
          new OrderedList(),
          new ListItem(),
          new TodoItem(),
          new TodoList(),
          new Bold(),
          new Code(),
          new Italic(),
          new Image(),
          new Link(),
          new Strike(),
          new Underline(),
          new History(),
          //costume
          // new Comment(),
          new InsImage(),
          new InsVideo(),
          new Placeholder({
            emptyClass: 'is-empty',
            emptyNodeText: 'Write something …',
            showOnlyWhenEditable: true,
          }),
        ],
        onUpdate: ({ getHTML }) => {
          // const output = getHTML()
          // this.$emit('output', output)
          // const output = getHTML()
          this.$emit('output', getHTML())
        },
      }),
      image: '',
      video: '',
      isLoading: {
        upload: false
      },
      commentId: [],
      linkUrl: null,
      insImageAlt: null,
      insImageTitle: null,
      insImageType: null,
      linkMenuIsActive: false,
      menububbleIconsHidden: false,
      imageMenuIsActive: false,
      apiToken: window.Laravel.api_token,
      user: window.Laravel.user,
      csrf: window.Laravel.csrfToken
    }
  },
  methods: {
    handleItemControl() {
      if(event.target.tagName == 'IMG') {
        let controls = document.querySelectorAll('.item__settings');
        let images = document.getElementsByTagName('IMG');
        for (let i = 0; i < images.length; i++) {
          images[i].classList.remove('is-active')
        }
        for (let i = 0; i < controls.length; i++) {
          controls[i].classList.remove('is-active')
        }
        event.target.classList.add('is-active');
        event.target.nextElementSibling.classList.add('is-active');
      } else {
        let controls = document.querySelectorAll('.item__settings');
        let images = document.getElementsByTagName('IMG');
        for (let i = 0; i < images.length; i++) {
          images[i].classList.remove('is-active')
        }
        for (let i = 0; i < controls.length; i++) {
          controls[i].classList.remove('is-active')
        }
      }

      // let target = event.path[0];
      // let targetControl = event.path[1].querySelector('.item__settings');
      // if (target.tagName === 'IMG') {
      //   targetControl.classList.add('is-active')
      //   target.classList.add('is-active')
      // }
    },
    // setComment(command) {
    //   let id = 'c' + Math.floor(Math.random() * 100000);
    //   console.log(id);
    //   command({ id })
    // },
    uploadImage(command) {
      this.isLoading.upload = true;
      let data = new FormData();
      let file = this.$refs.image.files[0];
      data.append('image', file, file.filename);
      console.log(file.type);
      if(file.type == 'image/jpeg') {
        axios
          .post('/api/upload/editor/image', data)
          .then((response) => {
            this.image = JSON.parse(response.data),
            this.image.raw = JSON.parse(response.data),
            this.image.srcset = this.image.small.file + ' ' + this.image.small.size + 'w, ' +
              this.image.medium.file + ' ' + this.image.medium.size + 'w, ' +
              this.image.large.file + ' ' + this.image.large.size + 'w, ' +
              this.image.full.file + ' ' + this.image.full.size + 'w ',
            this.image.fallback = this.image.large.file,
            // console.log(this.image.srcset),
            // console.log(this.image.fallback)
            this.setImage(command, this.image.srcset, this.image.fallback, this.image.raw)
            document.querySelector('.editor__floating-menu').classList.remove('is-active');
            this.isLoading.upload = false;
          })
      }
    else {
      this.$emit('message', 'File is not supported. Please use jpg or mp4')
      this.isLoading.upload = false;
    }


    },
    uploadVideo(command) {
      this.isLoading.upload = true;
      let data = new FormData();
      let file = this.$refs.video.files[0];
      data.append('video', file, file.filename);
      console.log(file.type);
      if(file.type == 'audio/ogg') {
        axios
          .post('/api/upload/editor/video', data)
          .then((response) => {
            this.video = JSON.parse(response.data),
            console.log(this.video),
            console.log(command),
            this.setVideo(command, this.video)
            // document.querySelector('.editor__floating-menu').classList.remove('is-active');
            // this.isLoading.upload = false;
          })
    }
    else {
      this.$emit('message', 'File is not supported. Please use jpg or mp4')
      this.isLoading.upload = false;
    }


    },

    // uploadImage(command) {
    //   let data = new FormData();
    //   let file = this.$refs.image.files[0];
    //   data.append('image', file, file.filename);
    //   axios
    //     .post('/api/upload/editor', data)
    //       .then((response) => {
    //         console.log(JSON.parse(response.data.file).files);
    //         //this.setImage(command, response.data.data.image)
    //       }
    //     )
    // },
    // deleteImage(path) {
    //   console.log(path);
    //   // axios
    //   //   .patch('/api/upload/project/' + $id + '/delete', {
    //   //     image: this.project.image
    //   // })
    //   //   .then(
    //   //     response => {this.message = response.data.message},
    //   //     this.getProject()
    //   //   )
    // },
    // showImagePrompt(command) {
    //   const src = prompt('Enter the url of your image here');
    //   let alt = this.insImageTitle;
    //   let title = this.insImageAlt;
    //   if (src !== null) {
    //     command({ src, alt, title })
    //   }
    // },
    // showImageMenu() {
    //   // this.insImageSrc = attrs.src
    //   // this.insImageAlt = attrs.alt
    //   this.imageMenuIsActive = true
    // },
    // hideImageMenu() {
    //   this.insImageAlt = null
    //   this.insImageSrc = null
    //   this.imageMenuIsActive = false
    // },
    setImage(command, srcset, src, raw) {
      if (srcset !== '') {
        command({ srcset, src, raw })
      }
    },
    setVideo(command, src) {
      if (src !== '') {
        command({ src })
      }
    },
    // setImage(command, url, text) {
    //   console.log(url, text);
    //   command({ src: url, alt: text })
    //   this.hideImageMenu()
    // },
    showLinkMenu(attrs) {
      this.linkUrl = attrs.href
      this.linkMenuIsActive = true
      this.menububbleIconsHidden = true
      this.$nextTick(() => {
        this.$refs.linkInput.focus()
      })
    },
    hideLinkMenu() {
      this.linkUrl = null
      this.linkMenuIsActive = false
      this.menububbleIconsHidden = false
    },
    setLinkUrl(command, url) {
      command({ href: url })
      this.hideLinkMenu()
      this.editor.focus()
    },
  },
  watch: {
    editable() {
     this.editor.setOptions({
       editable: this.editable,
     })
   },
    content: function(value) {
      // this.editor.setContent(JSON.parse(value), true)
      // console.log(this.$refs.menububble.clientWidth);
      this.editor.setContent(value, true)
    }
  },
  beforeDestroy() {
    this.editor.destroy()
  },
}
</script>
