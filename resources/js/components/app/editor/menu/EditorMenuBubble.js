import MenuBubble from './MenuBubble'

export default {

  props: {
    editor: {
      default: null,
      type: Object,
    },
    bubbleWidth: {
      default: null,
    }
  },

  data() {
    return {
      menu: {
        isActive: false,
        left: 0,
        triangleLeft: 0,
        bottom: 0,
      },
    }
  },

  watch: {
    editor: {
      immediate: true,
      handler(editor) {
        if (editor) {
          this.$nextTick(() => {
            editor.registerPlugin(MenuBubble({
              element: this.$el,
              onUpdate: menu => {
                this.menu = menu
              },
            }))
          })
        }
      },
    },
  },

  render() {
    if (!this.editor) {
      return null
    }

    return this.$scopedSlots.default({
      focused: this.editor.view.focused,
      focus: this.editor.focus,
      commands: this.editor.commands,
      isActive: this.editor.isActive,
      getMarkAttrs: this.editor.getMarkAttrs.bind(this.editor),
      menu: this.menu,
    })
  },

}
