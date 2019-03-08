import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import 'vue-multiselect/dist/vue-multiselect.min.css'
import 'flag-icon-css/css/flag-icon.css'
import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'
import RegisterPlugin from './components/register'
import ApiService from './services/api.service'
import { TokenService } from './services/storage.service'
import i18n from './i18n'
require('./oneui/app.js')
require('./assets/sass/main.scss')

Vue.config.productionTip = false
Vue.use(RegisterPlugin)

// Set the base URL of the API
ApiService.init(process.env.VUE_APP_BASE_URL)

Vue.prototype.$store = store

// If token exists set header
if (TokenService.getToken()) {
  ApiService.setHeader()
  ApiService.mountInterceptors()
}
if (localStorage.getItem('locale')) {
  i18n.locale = localStorage.getItem('locale')
} else {
  i18n.locale = 'gb'
}

new Vue({
  router,
  store,
  i18n,
  render: h => h(App)
}).$mount('#app')
