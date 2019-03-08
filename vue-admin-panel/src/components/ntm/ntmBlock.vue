<template>
  <div class="block">
      <div class="block-header" v-if="title || subtitle || $slots.options">
          <h3 class="block-title">{{title}} <small v-if="subtitle">{{subtitle}}</small></h3>
          <div class="block-options">
              <slot name="options"/>
          </div>
      </div>
      <div v-if="$slots.default || showContent" class="block-content">
          <slot/>
      </div>
  </div>
</template>

<script>
export default {
  props: {
    title: {
      type: String,
      default: ''
    },
    subtitle: {
      type: String
    },
    showContent: {
      default: false,
      type: Boolean
    }
  }
}
</script>
