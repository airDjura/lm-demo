<template>
   <div class="form-group" :class="[ to.inputType, {'formly-has-value': model[field.key], 'formly-has-focus': form[field.key].$active, 'has-error': hasError}]">
     <div class="custom-control custom-checkbox custom-checkbox-rounded-circle custom-control-lg custom-control-danger mb-1">
       <input type="checkbox" v-model="model[field.key]" class="custom-control-input" :id="'example-cb-custom-circle-lg-' + _uid">
       <label class="custom-control-label" :for="'example-cb-custom-circle-lg-' + _uid" v-if="to.label" v-text="$t('formly.fields.' + to.label)"></label>
     </div>
     <span class="help-block form-text text-danger"
           v-if="form.$errors[field.key].length > 0"
           v-text="$t('validation.' + field.key + '.' + form.$errors[field.key][0])" />
   </div>
</template>

<script>
import baseField from 'vue-formly-bootstrap/src/fields/baseField'
export default {
  mixins: [baseField]
}
</script>
