
import ApiService from './api.service'
import { TokenService } from './storage.service'
import router from '@/router'

class AuthenticationError extends Error {
  constructor (errorCode, message) {
    super(message)
    this.name = this.constructor.name
    this.message = message
    this.errorCode = errorCode
  }
}

const UserService = {
  /**
     * Login the user and store the access token to TokenService.
     *
     * @returns access_token
     * @throws AuthenticationError
    **/
  login: async function (email, password) {
    const requestData = {
      method: 'post',
      url: '/oauth/token',
      data: {
        grant_type: 'password',
        username: email,
        password: password,
        client_id: process.env.VUE_APP_CLIENT_ID,
        client_secret: process.env.VUE_APP_CLIENT_SECRET
      }
    }

    try {
      const response = await ApiService.customRequest(requestData)
      TokenService.saveToken(response.data.access_token)
      TokenService.saveRefreshToken(response.data.refresh_token)
      ApiService.setHeader()

      // NOTE: We haven't covered this yet in our ApiService
      //       but don't worry about this just yet - I'll come back to it later
      ApiService.mountInterceptors()

      return response.data.access_token
    } catch (error) {
      throw new AuthenticationError(error.response.status, error.response.data.detail)
    }
  },

  /**
     * Refresh the access token.
    **/
  refreshToken: async function () {
    const refreshToken = TokenService.getRefreshToken()
    const requestData = {
      method: 'post',
      url: '/oauth/token',
      data: {
        grant_type: 'refresh_token',
        refresh_token: refreshToken,
        client_id: process.env.VUE_APP_CLIENT_ID,
        client_secret: process.env.VUE_APP_CLIENT_SECRET
      }
    }

    try {
      const response = await ApiService.customRequest(requestData)

      TokenService.saveToken(response.data.access_token)
      TokenService.saveRefreshToken(response.data.refresh_token)
      // Update the header in ApiService
      ApiService.setHeader()

      return response.data.access_token
    } catch (error) {
      throw new AuthenticationError(error.response.status, error.response.data.detail)
    }
  },

  getUser () {
    return ApiService.get('api/user')
  },

  setCurrentSeason (data) {
    return ApiService.post('api/user/editSeason', data)
  },
  /**
     * Logout the current user by removing the token from storage.
     *
     * Will also remove `Authorization Bearer <token>` header from future requests.
    **/
  logout () {
    // Remove the token and remove Authorization header from Api Service as well
    TokenService.removeToken()
    TokenService.removeRefreshToken()
    ApiService.removeHeader()

    ApiService.unmountInterceptors()
    router.push({ name: 'login' })
  }
}

export default UserService

export { UserService, AuthenticationError }
