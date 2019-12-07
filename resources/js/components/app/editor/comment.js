import { Mark } from 'tiptap'
import { toggleMark } from 'tiptap-commands'

export default class Comment extends Mark {

  get name() {
    return 'comment'
  }

  get schema() {
    return {
      attrs: {
        id: {default: null},
      },
      parseDOM: [
        {
          tag: 'span',
          getAttrs: dom => ({
            id: dom.getAttribute('id'),
          }),
        },
      ],
      toDOM: () => ['span', {
        'class': '__comment',
        // 'data-id': 'test'
      },0],
    }
  }

  // keys({ type }) {
  //   return {
  //     'Mod-c': toggleMark(type),
  //   }
  // }

  commands({ type }) {
    return () => toggleMark(type)
  }

}
