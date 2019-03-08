import basicMixin from './basic.index.mixin'
var seasonIndexMixin = {
  mixins: [basicMixin],
  watch: {
    'currentSeason': function () {
      this.items = []
      this.fetchData()
    }
  },
  computed: {
    currentSeason () {
      return this.$store.state.currentSeason
    }
  }
}

export default seasonIndexMixin
