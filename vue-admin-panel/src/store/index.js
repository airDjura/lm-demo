import Vue from 'vue'
import Vuex from 'vuex'
import { auth } from './auth.module'
import ApiService from '../services/api.service'

Vue.use(Vuex)

export default new Vuex.Store({
  modules: {
    auth
  },
  state: {
    loading: true,
    currentSeason: null,
    user: {
      name: '',
      currentSeason: {}
    },
    seasonOptions: []
  },
  mutations: {
    loading (state) {
      state.loading = true
    },
    loaded (state) {
      state.loading = false
    },
    currentSeason (state, seasonUuid) {
      state.currentSeason = seasonUuid
    },
    currentUser (state, user) {
      state.user = user
    },
    setSeasonOptions (state, data) {
      state.seasonOptions = data
    }
  },
  getters: {
    loading: state => state.loading
  },
  actions: {
    getSeasonOptions ({ commit }, q = '') {
      var search = q || ''
      ApiService.get(`api/search/seasons?search=${search}`).then(response => commit('setSeasonOptions', response.data))
    }
  }
})
