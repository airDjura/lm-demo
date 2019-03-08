import axios from 'axios'
import store from '@/store'
import Vue from 'vue'
import { TokenService } from '../services/storage.service'
import VueI18n from '../i18n'

const axiosInstance = axios.create({
  headers: {
    common: {
      'Accept': 'application/json'
    },
    post: {
      'Accept': 'application/json'
    }
  }
  /* other custom settings */
})

const ApiService = {

  // Stores the 401 interceptor position so that it can be later ejected when needed
  _401interceptor: null,

  init (baseURL) {
    axiosInstance.defaults.baseURL = baseURL
  },

  setHeader () {
    axiosInstance.defaults.headers.common['Authorization'] = `Bearer ${TokenService.getToken()}`
  },

  removeHeader () {
    axiosInstance.defaults.headers.common = {}
  },

  get (resource) {
    return axiosInstance.get(resource)
  },

  post (resource, data) {
    return axiosInstance.post(resource, data)
  },

  put (resource, data) {
    return axiosInstance.put(resource, data)
  },

  delete (resource) {
    return axiosInstance.delete(resource)
  },

  /**
     * Perform a custom Axios request.
     *
     * data is an object containing the following properties:
     *  - method
     *  - url
     *  - data ... request payload
     *  - auth (optional)
     *    - username
     *    - password
    **/
  customRequest (data) {
    return axiosInstance(data)
  },

  mountInterceptors: function () {
    axiosInstance.interceptors.request.use(async function (config) {
      if (config.method === 'put' || config.method === 'post') {
        if (!config.url.includes('/media/') && !config.url.includes('/user/editSeason') && !config.url.includes(
          '/changeGroup')) {
          store.commit('loading')
        }
      }
      if (config.method === 'delete') {
        await Vue.swal({
          title: VueI18n.t('swal.delete.title'),
          text: VueI18n.t('swal.delete.text'),
          type: 'warning',
          showCancelButton: true,
          confirmButtonText: VueI18n.t('swal.delete.yes'),
          cancelButtonText: VueI18n.t('swal.delete.no'),
          showCloseButton: true,
          showLoaderOnConfirm: true
        }).then((result) => {
          if (!result.value) {
            config = false
          }
        })
      }
      return config
    }, function (error) {
      // Do something with request error
      return Promise.reject(error)
    })

    this._401interceptor = axiosInstance.interceptors.response.use(
      (response) => {
        if (typeof response.data === 'string' && response.config.method !== 'delete') {
          Vue.$notify(VueI18n.t(response.data), 'success')
        }
        if (typeof response.data === 'string' && response.config.method === 'delete') {
          Vue.swal({
            title: VueI18n.t(response.data),
            text: VueI18n.t('swal.delete.success'),
            type: 'success',
            timer: 1200,
            showCancelButton: false,
            showConfirmButton: false
          })
        }
        // store.commit('loaded')
        return response
      },
      async (error) => {
        if (error.request.status === 401) {
          if (error.config.url.includes('/oauth/token')) {
            // Refresh token has failed. Logout the user
            store.dispatch('auth/logout')
            throw error
          } else {
            // Refresh the access token
            try {
              await store.dispatch('auth/refreshToken')
              // Retry the original request
              return this.customRequest({
                method: error.config.method,
                url: error.config.url,
                data: error.config.data
              })
            } catch (e) {
              // Refresh has failed - reject the original request
              throw error
            }
          }
        }

        if (error.request.status === 422) {
          store.commit('loaded')
          Vue.$notify(error.response.data.message, 'error')
          throw error
        }

        if (error.request.status === 400) {
          store.commit('loaded')
          Vue.$notify(VueI18n.t(error.response.data), 'error')
          throw error
        }

        // If error was not 401 just reject as is
        throw error
      }
    )
  },

  unmountInterceptors () {
    // Eject the interceptor
    axiosInstance.interceptors.response.eject(this._401interceptor)
  }
}

export default ApiService
