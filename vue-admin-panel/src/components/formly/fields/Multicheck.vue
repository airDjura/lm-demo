<template>
  <div class="form-group" :class="[ to.inputType, {'formly-has-value': model[field.key], 'formly-has-focus': form[field.key].$active, 'has-error': hasError}]">
    <label v-if="to.label" v-text="$t('formly.fields.'+to.label)"></label>
    <span class="help-block form-text text-danger"
          v-if="form.$errors[field.key].length > 0"
          v-text="$t('validation.' + field.key + '.' + form.$errors[field.key][0])" />
    <div class="row">
      <div class="col-sm-6" v-for="(option, n) in to.options" :key="_uid + '-' + n">
        <div class="custom-control custom-checkbox custom-control-lg mb-1">
          <input type="checkbox" class="custom-control-input" :id="_uid + '-' + option.uuid" @click="checkItem" :value="option.uuid">
          <label class="custom-control-label" :for="_uid + '-' + option.uuid" v-text="option.name"></label>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import _ from 'lodash'
import baseField from 'vue-formly-bootstrap/src/fields/baseField'
export default {
  mixins: [baseField],
  data () {
    return {
      selectedItems: []
    }
  },
  updated () {
    const vm = this
    if (vm.model[this.field.key].length > 0) {
      vm.to.options.forEach(function (i) {
        if (_.find(vm.model[vm.field.key], (o) => { return _.isMatch(o, i) })) {
          var queryId = '#' + vm._uid + '-' + i.uuid
          jQuery(queryId).attr('checked', true)
        }
      })
    }
  },
  methods: {
    checkItem (item) {
      var forBuilder = '[for=' + item.target.id + ']'
      var clickedItem = {
        uuid: item.target.value,
        name: jQuery(forBuilder).text()
      }
      if (_.find(this.model[this.field.key], (o) => { return _.isMatch(o, clickedItem) })) {
        _.remove(this.model[this.field.key], {
          uuid: clickedItem.uuid
        })
      } else {
        this.model[this.field.key].push(clickedItem)
      }
    }
  }
}
</script>
