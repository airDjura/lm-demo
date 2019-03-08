import VueI18n from '../../../../i18n'

export default {
  render (h) {
    if (this.message) {
      return h('span', {
        'class': 'help-block form-text text-danger'
      }, this.message)
    }
  },
  props: ['field', 'form'],
  computed: {
    message () {
      let message = false
      if (!(this.field in this.form.$errors) || !(this.field in this.form)) return message
      let errors = this.form.$errors[ this.field ]
      Object.keys(errors).some(errorKey => {
        if (typeof errors[ errorKey ] !== 'boolean') {
          const arrErrorTypes = errors[ errorKey ].split('.')
          const errorType = arrErrorTypes[arrErrorTypes.length - 1]
          message = VueI18n.t('validation.' + this.field + '.' + errorType)
          return true
        }
      })
      return message
    }
  }
}
