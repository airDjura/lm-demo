<template>
  <div class="form-group formly-datepicker"
       :class="[ to.inputType, {'formly-has-value': model[field.key], 'formly-has-focus': form[field.key].$active, 'has-error': hasError}]">
    <label v-if="to.label" v-text="$t('formly.fields.' + to.label)"></label>
    <multiselect track-by="uuid"
                 @change="changed"
                 @search-change="getOptions"
                 :multiple="field.multiple ? field.multiple : false"
                 :custom-label="to.customLabel ? to.customLabel : customLabel"
                 :placeholder="$tc('select.option', field.multiple ? 2 : 1)"
                 v-model="model[field.key]"
                 :options="options"></multiselect>
    <!-- <error-display :form="form" :field="field.key"></error-display> -->
    <span class="help-block form-text text-danger"
          v-if="form.$errors[field.key].length > 0"
          v-text="$t('validation.' + field.key + '.' + form.$errors[field.key][0])" />
  </div>
</template>

<script>
import ApiService from '@/services/api.service'
import baseField from 'vue-formly-bootstrap/src/fields/baseField'
import Multiselect from 'vue-multiselect'

export default {
  mixins: [baseField],
  data () {
    return {
      options: []
    }
  },
  props: {
    customLabel: {
      type: Function,
      default: function (o) {
        return `${o.name ? o.name : ''}`
      }
    }
  },
  // watch: {
  //   'selectedItem': function (value) {
  //     console.log(value)
  //     this.$emit('selectedItem', value)
  //   }
  // },
  components: {
    Multiselect
  },
  mounted () {
    if (this.field.options) {
      this.options = this.field.options
    } else {
      this.getOptions()
    }
  },
  watch: {
    'field.options': 'updateOptions'
  },
  methods: {
    updateOptions() {
      this.options = this.field.options
    },
    changed () {
      console.log(200)
    },
    getOptions (q) {
      var search = q || ''
      if (this.field.optionsApi && !this.field.options) {
        ApiService.get(`api/search/${this.field.optionsApi}?search=${search}`)
          .then((response) => {
            this.options = response.data
          })
      }
    }
  }
  // computed: {
  //   selectedItem () {
  //     return this.model[this.field.key]
  //   }
  // }
}
</script>
