<style scoped>
.background-darken {
  background: rgba(0, 0, 0, 0.3);
}

.modal {
  overflow-x: hidden;
  overflow-y: auto;
}

.modal-full {
  margin-left: 16px;
  margin-right: 16px;
  width: auto;
}
</style>

<template>
    <div ref="modal" :id="'modal' + this._uid" class="modal fade" @click.self="close()" @keyup.esc="close()" tabindex="-1" role="dialog" aria-labelledby="modal-block-popout">
      <div class="modal-dialog modal-dialog-popout" :class="'modal-'+ size" role="document">
        <div class="modal-content">
          <div class="block block-themed block-transparent mb-0">
            <div class="block-header bg-primary-dark">
              <h3 class="block-title" v-text="title"></h3>
              <div class="block-options">
                <slot name="options"></slot>
                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                  <i class="fa fa-fw fa-times"></i>
                </button>
              </div>
            </div>
            <div class="block-content font-size-sm">
              <slot name="content"></slot>
            </div>
            <div class="block-content block-content-full text-right border-top">
              <slot name="footer"></slot>
            </div>
          </div>
        </div>
      </div>
    </div>
</template>

<script>
export default {
  props: {
    opened: {
      type: Function,
      default: () => {}
    },
    closed: {
      type: Function,
      default: () => {}
    },
    needHeader: {
      type: Boolean,
      default: true
    },
    needFooter: {
      type: Boolean,
      default: true
    },
    size: {
      type: String,
      default: ''
    },
    title: {
      type: String
    }
  },
  data () {
    return {
      sizeClasses: {
        large: 'modal-lg',
        small: 'modal-sm',
        medium: 'modal-md',
        full: 'modal-full'
      },
      isOpen: false,
      isShow: false,
      lastKnownBodyStyle: {
        overflow: 'auto'
      }
    }
  },
  methods: {
    open () {
      this.$nextTick(() => {
        // this.isOpen = true
        this.$refs.modal.focus()
        jQuery(`#modal${this._uid}`).modal('show')
        // this.lastKnownBodyStyle.overflow = document.body.style.overflow
        // document.body.style.overflow = 'hidden'
        this.opened()
      })
    },
    close () {
      this.$nextTick(() => {
        jQuery(`#modal${this._uid}`).modal('hide')
        this.closed()
      })
    }
  },
  computed: {
    modalSize () {
      return this.sizeClasses[this.size] || ''
    }
  }
}
</script>
