<template>
  <div v-if="title || desc || $slots.default" class="bg-body-light">
    <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
        <h1 v-if="title || desc" class="flex-sm-fill h3 my-2">
          {{title}}
          <small v-if="desc"
                 class="d-block d-sm-inline-block mt-2 mt-sm-0 font-size-base font-w400 text-muted"
                 v-text="desc"></small>
        </h1>
        <nav v-if="$slots.default"
             class="flex-sm-00-auto ml-sm-3"
             aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-alt">
            <slot></slot>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    title: {
      type: String
    },
    desc: {
      type: String
    }
  }
}
</script>
