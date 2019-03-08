<template>
   <div class="form-group formly-datepicker" :class="[ to.inputType, {'formly-has-value': model[field.key], 'formly-has-focus': form[field.key].$active, 'has-error': hasError}]">
      <label v-if="to.label" v-text="to.label"></label>
      <div class="custom-file">
          <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
          <input @change="pushFiles" type="file" class="custom-file-input" :multiple="field.multiple ? field.multiple : false" data-toggle="custom-file-input" id="example-file-input-custom" name="example-file-input-custom">
          <label class="custom-file-label" for="example-file-input-custom">{{fileName}}</label>
      </div>
      <span class="help-block form-text text-danger" v-if="form.$errors[field.key]" v-text="form.$errors[field.key][0]" />
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
      fileName: 'Choose file'
    }
  },
  methods: {
    pushFiles (e) {
      this.fileName = (e.target.files.length > 1) ? e.target.files.length + ' ' + 'Files' : e.target.files[0].name
      var files = e.target.files || e.dataTransfer.files
      if (!files.length) {
        return
      }

      this.$set(this.model, this.field.key, this.$el.querySelector('input').files)
    }
  }
  // components: {
  //   datepicker
  // }
}
</script>
