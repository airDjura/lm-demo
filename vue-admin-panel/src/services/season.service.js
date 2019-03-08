import ApiService from './api.service'

const SeasonService = {
  index (search = '') {
    return ApiService.get('api/seasons?search=' + search)
  },

  show (uuid) {
    return ApiService.get('api/seasons/' + uuid)
  },

  update (uuid, data) {
    return ApiService.put('api/seasons/' + uuid, data)
  },

  store (data) {
    return ApiService.post('api/seasons', data)
  }
}

export default SeasonService
