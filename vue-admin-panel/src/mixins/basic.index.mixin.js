var basicIndexMixin = {
  data () {
    return {
      search: '',
      items: []
    }
  },
  watch: {
    'search': 'fetchData'
  },
  methods: {
    setData (data) {
      this.items = data
    }
  }
}

export default basicIndexMixin
