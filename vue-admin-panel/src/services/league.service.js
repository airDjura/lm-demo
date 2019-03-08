import ApiService from './api.service'

const LeagueService = {
  index (search = '') {
    return ApiService.get('api/leagues?search=' + search)
  },

  show (uuid) {
    return ApiService.get('api/leagues/' + uuid)
  },

  update (uuid, data) {
    return ApiService.put('api/leagues/' + uuid, data)
  },

  store (data) {
    return ApiService.post('api/leagues', data)
  }
}

export default LeagueService
