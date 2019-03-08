var seasonShowMixin = {
  watch: {
    'currentSeason': 'backToPage'
  },
  computed: {
    currentSeason () {
      return this.$store.state.currentSeason
    }
  },
  methods: {
    setData (data) {
      this.model = data
    },
    backToPage () {
      const routerIndexLink = this.$route.name.split('.')[0] + '.index'
      this.$router.push({ name: routerIndexLink })
    }
  }
}

export default seasonShowMixin
