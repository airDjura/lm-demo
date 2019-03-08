import ApiService from './api.service'

const TeamService = {
  show (scheduleUuid, teamUuid) {
    return ApiService.get('api/schedules/' + scheduleUuid + '/teams/' + teamUuid)
  },

  create (scheduleUuid) {
    return ApiService.get('api/schedules/' + scheduleUuid + '/teams/create')
  },

  update (scheduleUuid, teamUuid, data) {
    return ApiService.put('api/schedules/' + scheduleUuid + '/teams/' + teamUuid, data)
  },

  store (scheduleUuid, data) {
    return ApiService.post('api/schedules/' + scheduleUuid + '/teams', data)
  },

  destroy (scheduleUuid, teamUuid) {
    return ApiService.delete('api/schedules/' + scheduleUuid + '/teams/' + teamUuid)
  }
}

export default TeamService
