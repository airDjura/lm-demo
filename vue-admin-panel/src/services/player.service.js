import ApiService from './api.service'

const PlayerService = {
  index (search = '') {
    return ApiService.get('api/players?search=' + search)
  },

  show (uuid) {
    return ApiService.get('api/players/' + uuid)
  },

  update (uuid, data) {
    return ApiService.put('api/players/' + uuid, data)
  },

  store (data) {
    return ApiService.post('api/players', data)
  }
}

export default PlayerService
