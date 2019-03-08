<template>
   <div class="form-group formly-datepicker" :class="[ to.inputType, {'formly-has-value': model[field.key], 'formly-has-focus': form[field.key].$active, 'has-error': hasError}]">
      <label v-if="to.label" v-text="$t('formly.fields.' + to.label)"></label>
      <date-picker v-model="model[field.key]" :placeholder="to.placeholder" class="form-control-alt" :config="options"></date-picker>
      <span class="help-block form-text text-danger"
            v-if="form.$errors[field.key].length > 0"
            v-text="$t('validation.' + field.key + '.' + form.$errors[field.key][0])" />
      <!-- <error-display v-if="form.$errors[field.key].lenght > 0" :form="form" :field="field.key"></error-display> -->
   </div>
</template>

<script>
import baseField from 'vue-formly-bootstrap/src/fields/baseField'
// import datepicker from '@/components/ntm/DateTimePicker/Datetime'
export default {
  mixins: [baseField],
  data () {
    return {
      date: new Date(),
      options: {
        format: 'YYYY-MM-DD',
        useCurrent: false
      }
    }
  }
  // components: {
  //   datepicker
  // }
}
</script>
