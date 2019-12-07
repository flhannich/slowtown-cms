import { Plugin } from 'prosemirror-state'

class Menu {

  constructor({ options, editorView }) {
    this.options = {
      ...{
        element: null,
        onUpdate: () => false,
      },
      ...options,
    }
    this.editorView = editorView
    this.isActive = false
    this.left = 0
    this.bottom = 0

    this.editorView.dom.addEventListener('blur', this.hide.bind(this))
  }

  update(view, lastState) {
    const { state } = view

    // Don't do anything if the document/selection didn't change
    if (lastState && lastState.doc.eq(state.doc) && lastState.selection.eq(state.selection)) {
      return
    }

    // Hide the tooltip if the selection is empty
    if (state.selection.empty) {
      this.hide()
      return
    }

    // Window and MenuBubble width
    const width = window.innerWidth;
    const elementWidth = this.options.element.clientWidth;
    const parent = this.editorView.dom;
    const p = parent.querySelector('p');

    // Otherwise, reposition it and update its content
    const { from, to } = state.selection

    // These are in screen coordinates
    const start = view.coordsAtPos(from)
    const end = view.coordsAtPos(to)

    // The box in which the tooltip is positioned, to use as base
    const box = this.options.element.offsetParent.getBoundingClientRect()

    // Find a center-ish x position from the selection endpoints (when
    // crossing lines, end may be more to the left)
    const left = Math.max((start.left + end.left) / 2, start.left + 3)

    this.isActive = true
    this.left = parseInt(left - box.left, 10)
    this.right = parseInt(Math.abs(left - box.right, 10))
    this.bottom = parseInt(box.bottom - end.bottom, 10)
    this.triangleLeft = parseInt(elementWidth / 2 - 7)

    if(p.clientWidth < width - - elementWidth) {
      if((elementWidth / 2) > this.left) {
        this.left = parseInt(elementWidth / 2 + 16);
        this.triangleLeft = parseInt(left - box.left - 24, 10)
      }
      if((elementWidth / 2) > this.right) {
        this.left = parseInt(width - elementWidth / 2 - 16);
        this.triangleLeft = parseInt(elementWidth - Math.abs(left - box.right, 10) + 10)
      }
    }
    this.sendUpdate()
  }

  sendUpdate() {
    this.options.onUpdate({
      isActive: this.isActive,
      left: this.left,
      triangleLeft: this.triangleLeft,
      bottom: this.bottom,
    })
  }

  hide(event) {
    if (event && event.relatedTarget) {
      return
    }

    this.isActive = false
    this.sendUpdate()
  }

  destroy() {
    this.editorView.dom.removeEventListener('blur', this.hide)
  }

}

export default function (options) {
  return new Plugin({
    view(editorView) {
      return new Menu({ editorView, options })
    },
  })
}
