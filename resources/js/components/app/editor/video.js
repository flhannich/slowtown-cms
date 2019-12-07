import { Node, Plugin, NodeSelection } from 'tiptap'

export default class InsVideo extends Node {

  get name() {
    return 'insVideo'
  }

  get schema() {
    return {
      attrs: {
        src: {default: null},
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
        tag: "video",
        contentElement: "source",
        getAttrs(dom) {
          let video = dom.querySelector("source")
          return {
            src: video.src
          }
        }
      }],
      toDOM(node) {
        return [
          "video", {
            controls: 'true',
          },[
              "source", {
                type: 'video/mp4',
                mimetype: 'video/mp4',
                src: node.attrs.src
              },
            ],
        ]
      }
    }
  }

  get view() {
    return {
      props: ['node', 'updateAttrs', 'editable'],
      methods: {
        deleteVideo(src) {
          axios
            .patch('/api/upload/editor/video', {
            video: src
          })
          let videoWrapper = event.target.parentNode.parentNode;
          videoWrapper.parentNode.removeChild(videoWrapper);
        },
      },
      computed: {
        src: {
          get() { return this.node.attrs.src },
          set(src) { this.updateAttrs({ src }) },
        },
      },
      template: `
      <video controls >
        <source :src="src" mimeType="audio/ogg" type="audio/ogg">
      </video>
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

// document.querySelector('body').addEventListener("click", hideEditorItemControls)


// function hideEditorItemControls() {
//   if(document.querySelector('.editor') || document.getElementById('#page')) {
//     if(event.path[1].tagName !== 'FIGURE' && event.path[2].tagName !== 'FIGURE') {
//     let parent = document.querySelector('.editor');
//     let controls = parent.querySelectorAll('.item__settings');
//     let images = parent.getElementsByTagName('IMG');
//       for (let i = 0; i < controls.length; i++) {
//         controls[i].classList.remove('is-active')
//       }
//       for (let i = 0; i < images.length; i++) {
//         images[i].classList.remove('is-active')
//       }
//     }
//   }
// }

    // function handleFigureClick(view, pos, node, posBefore) {
    //   if (node.type.name != "figure" && pos != posBefore) return false
    //   view.props.onAction(new NodeSelection(view.state.doc.resolve(pos).action())
    //   return true
    // }
// https://discuss.prosemirror.net/t/figure-and-editable-caption/462/5
