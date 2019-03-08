import ApiService from './api.service'

const VenueService = {
  index (search = '') {
    return ApiService.get('api/venues?search=' + search)
  },

  show (uuid) {
    return ApiService.get('api/venues/' + uuid)
  },

  update (uuid, data) {
    return ApiService.put('api/venues/' + uuid, data)
  },

  store (data) {
    return ApiService.post('api/venues', data)
  }
}

export default VenueService
