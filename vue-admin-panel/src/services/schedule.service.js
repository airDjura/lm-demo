import ApiService from './api.service'

const ScheduleService = {
  index (search = '') {
    return ApiService.get('api/schedules?search=' + search)
  },

  show (uuid) {
    return ApiService.get('api/schedules/' + uuid)
  },

  update (uuid, data) {
    return ApiService.put('api/schedules/' + uuid, data)
  },

  store (data) {
    return ApiService.post('api/schedules', data)
  },

  getPlayers (uuid, clubUuid) {
    return ApiService.get('api/schedules/' + uuid + '/clubs/' + clubUuid + '/getPlayers')
  },

  getGroups (uuid) {
    return ApiService.get('api/schedules/' + uuid + '/getGroups')
  },

  getEditPlayers (uuid, teamUuid) {
    return ApiService.get('api/schedules/' + uuid + '/teams/' + teamUuid + '/getPlayers')
  },

  addGroup (uuid, data) {
    return ApiService.post('api/schedules/' + uuid + '/addGroup', data)
  },

  deleteGroup (uuid, groupUuid) {
    return ApiService.delete('api/schedules/' + uuid + '/deleteGroup/' + groupUuid)
  },

  changeGroup (uuid, teamUuid, data) {
    return ApiService.post('api/schedules/' + uuid + '/teams/' + teamUuid + '/changeGroup', data)
  },

  generate (uuid, data) {
    return ApiService.post('api/schedules/' + uuid + '/generate', data)
  },

  deleteAllGames (uuid) {
    return ApiService.delete('api/schedules/' + uuid + '/deleteAllGames')
  }
}

export default ScheduleService
