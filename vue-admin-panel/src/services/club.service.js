import ApiService from './api.service'

const ClubService = {
  index (search = '') {
    return ApiService.get('api/clubs?search=' + search)
  },

  show (uuid) {
    return ApiService.get('api/clubs/' + uuid)
  },

  update (uuid, data) {
    return ApiService.put('api/clubs/' + uuid, data)
  },

  store (data) {
    return ApiService.post('api/clubs', data)
  }
}

export default ClubService
