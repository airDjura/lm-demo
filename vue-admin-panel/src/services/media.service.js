import ApiService from './api.service'

export default {
  upload (assetUuid, type, formData) {
    return ApiService.post('api/media/' + assetUuid + '/images/' + type, formData)
  },
  delete (uuid) {
    return ApiService.delete('api/media/' + uuid)
  },
  getByType (assetType, assetUuid, type) {
    return ApiService.get('api/media/' + assetType + '/' + assetUuid + '/images/' + type)
  }
}
