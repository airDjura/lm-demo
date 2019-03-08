import ApiService from './api.service'

const GameService = {
  show (scheduleUuid, gameUuid) {
    return ApiService.get('api/schedules/' + scheduleUuid + '/games/' + gameUuid)
  },

  update (scheduleUuid, gameUuid, data) {
    return ApiService.put('api/schedules/' + scheduleUuid + '/games/' + gameUuid, data)
  },

  store (scheduleUuid, data) {
    return ApiService.post('api/schedules/' + scheduleUuid + '/games', data)
  },

  destroy (scheduleUuid, gameUuid) {
    return ApiService.delete('api/schedules/' + scheduleUuid + '/games/' + gameUuid)
  }
}

export default GameService
