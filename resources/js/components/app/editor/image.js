import { Node, Plugin, NodeSelection } from 'tiptap'

export default class InsImage extends Node {

  get name() {
    return 'insImage'
  }

  get schema() {
    return {
      attrs: {
        raw: {default: null},
        srcset: {default: null},
        src: {default: null},
        alt: {default: ''},
        css: {default: '--large'},
      },
      content: "inline*",
      marks: "",
      group: "block",
      editable: true,
      inline: false,
      draggable: false,
      selectable: false,
      isolating: true,
      defining: true,
      inlineContent: true,
      // isLeaf: false,
      parseDOM: [{
        tag: "figure",
        contentElement: "figcaption",
        getAttrs(dom) {
          let img = dom.querySelector("img")
          return {
            css: dom.className,
            srcset: img.srcset,
            src: img.src,
            alt: img.alt
          }
        }
      }],
      toDOM(node) {
        return [
          "figure", {class: node.attrs.css},[
              "img", {
                srcset: node.attrs.srcset,
                src: node.attrs.src,
                alt: node.attrs.alt
              }
            ],
          [
            "figcaption", node.attrs.alt
          ]
        ]
      }
    }
  }

  get view() {
    return {
      props: ['node', 'updateAttrs', 'editable'],
      methods: {
        deleteImage(srcset) {
          axios
            .patch('/api/upload/editor/image', {
            image: srcset
          })
          let imgWrapper = event.target.parentNode.parentNode;
          imgWrapper.parentNode.removeChild(imgWrapper);
        },
        setClass(type) {
          if(type == 1) {
            this.css = '--normal'
          }
          if(type == 2) {
            this.css = '--large'
          }
        },
        onChange() {
          this.updateAttrs({
            css: this.node.attrs.css,
            alt: this.node.attrs.alt,
          })
        },
      },
      computed: {
        raw: {
          get() { return this.node.attrs.raw },
          set(raw) { this.updateAttrs({ raw }) },
        },
        srcset: {
          get() { return this.node.attrs.srcset },
          set(srcset) { this.updateAttrs({ srcset }) },
        },
        src: {
          get() { return this.node.attrs.src },
          set(src) { this.updateAttrs({ src }) },
        },
        alt: {
          get() { return this.node.attrs.alt },
          set(alt) { this.updateAttrs({ alt }) },
        },
        css: {
          get() { return this.node.attrs.css },
          set(css) { this.updateAttrs({ css }) },
        },
      },
      template: `
        <figure :class="css">
          <img :srcset="srcset" :src="src" :alt="alt">
          <div class="item__settings">
            <button class="ic__editor image-large" v-on:click="setClass(2)"></button>
            <button class="ic__editor image-normal" v-on:click="setClass(1)"></button>
            <button class="ic__editor delete" v-on:click="deleteImage(srcset), this.isLoading.upload = true"></button>
            <div class="triangle"></div>
          </div>
          <figcaption>
            <textarea
              v-autosize="alt"
              v-model="alt"
              rows="1"
              placeholder="Write a caption"
            ></textarea>
          </figcaption>


        </figure>
      `,
    }
  }

  commands({ type }) {
    return attrs => (state, dispatch) => {
      const { selection } = state;
      const position = selection.$cursor
        ? selection.$cursor.pos
        : selection.$to.pos;
      const node = type.create(attrs);
      const transaction = state.tr.insert(position, node);
      dispatch(transaction);
    };
  }



  get plugins() {
    return [
      new Plugin({
        props: {
          handleClickOn(view, pos, node, nodePos, event) {
            // console.log(event)
            // if(event.path[0].tagName !== 'IMG') {
              // let controls = document.querySelectorAll('.item__settings');
              // for (let i = 0; i < controls.length; i++) {
              //   controls[i].classList.remove('is-active')
              // }
            // }
            // console.log(event.key == 'Enter' && event.path[1].tagName == 'FIGURE')
          },
          handleKeyDown(view, event) {
            // console.log(event)
            // console.log(event.key == 'Enter' && event.path[1].tagName == 'FIGURE')
          },
          handleClick(view, pos, event, nodePos) {
            // console.log(event);
          }
            // if(node.type.name == 'insImage') {
            //   node.attrs.css += ' selected'
            // } else {
            //   document.getElementsByTagName('figure');
            //   let css = node.attrs.css;
            //   // view.props.onAction(new NodeSelection(view.state.doc.resolve(pos).action()))
            //   if(css.includes('selected')) {
            //     css.replace('selected', ' ')
            //   }
            //   }
              //
              // console.log(node.attrs.css.includes('selected'))
              // let css = node.attrs.css;
              // if(css.includes('selected')) {
              //   css += 'selected';
              // }


            // const { schema, doc, tr } = view.state
            // const range = getMarkRange(doc.resolve(pos), schema.marks.link)
            //
            // if (!range) {
            //   return
            // }
            //
            // const $start = doc.resolve(range.from)
            // const $end = doc.resolve(range.to)
            // const transaction = tr.setSelection(new TextSelection($start, $end))
            //
            // view.dispatch(transaction)
          },
      }),
    ]
  }
}

document.querySelector('body').addEventListener("click", hideEditorItemControls)


function hideEditorItemControls() {
  if(document.querySelector('.editor') || document.getElementById('#page')) {
    if(event.path[1].tagName !== 'FIGURE' && event.path[2].tagName !== 'FIGURE') {
    let parent = document.querySelector('.editor');
    let controls = parent.querySelectorAll('.item__settings');
    let images = parent.getElementsByTagName('IMG');
      for (let i = 0; i < controls.length; i++) {
        controls[i].classList.remove('is-active')
      }
      for (let i = 0; i < images.length; i++) {
        images[i].classList.remove('is-active')
      }
    }
  }
}

    // function handleFigureClick(view, pos, node, posBefore) {
    //   if (node.type.name != "figure" && pos != posBefore) return false
    //   view.props.onAction(new NodeSelection(view.state.doc.resolve(pos).action())
    //   return true
    // }
// https://discuss.prosemirror.net/t/figure-and-editable-caption/462/5
