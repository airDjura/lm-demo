<template>
  <div class="home">
    <img alt="Vue logo" src="@/assets/logo.png">
  </div>
</template>

<script>
// @ is an alias to /src

export default {
  name: 'home',
  mounted () {
    this.$router.push({
      name: 'dashboard'
    })
  }
}
</script>
