/* eslint-disable */
// import env from '@/env'
// import * as VueGoogleMaps from 'vue2-google-maps'
import VueFormly from './formly/vue-formly'
import VueFormlyBootstrap from './formly/formly-bootstrap'
import Datetime from './formly/fields/Datepicker'
import Multiselect from './formly/fields/Multiselect'
import Multicheck from './formly/fields/Multicheck'
import Boolean from './formly/fields/Boolean'
import Upload from './formly/fields/Upload'
import NtmTable from './ntm/ntmTable'
import datePicker from 'vue-bootstrap-datetimepicker'
import Notify from './alerts/notification'
import ntmModal from '@/components/ntm/ntmModal'
import ntmBlock from '@/components/ntm/ntmBlock'
import Dropzone from '@/components/ntm/Dropzone'
import VueCarousel from '@/components/ntm/carousel'
import VueDraggable from 'vue-draggable'
import PageHeader from './page/PageHeader'
import PageContent from './page/PageContent'
import VueSweetalert2 from 'vue-sweetalert2';

const RegisterPlugin = {
  install (Vue, options) {
    VueFormly.addType('datepicker', Datetime)
    VueFormly.addType('ntm-select', Multiselect)
    VueFormly.addType('ntm-multicheck', Multicheck)
    VueFormly.addType('upload', Upload)
    VueFormly.addType('boolean', Boolean)
    Vue.use(VueFormly)
    Vue.use(VueFormlyBootstrap)
    Vue.use(VueCarousel)
    Vue.use(VueDraggable)
    Vue.use(VueSweetalert2);
    Vue.component('ntm-table', NtmTable)
    Vue.component('page-header', PageHeader)
    Vue.component('page-content', PageContent)
    Vue.component('date-picker', datePicker)
    Vue.component('ntm-modal', ntmModal)
    Vue.component('ntm-block', ntmBlock)
    Vue.component('dropzone', Dropzone)

    // Use Notify
    Vue.use(Notify)

    // Vue.use(VueGoogleMaps, {
    //   load: {
    //     key: env.googleAPI,
    //     libraries: 'places', // This is required if you use the Autocomplete plugin
    //     // OR: libraries: 'places,drawing'
    //     // OR: libraries: 'places,drawing,visualization'
    //     // (as you require)

    //     //// If you want to set the version, you can do so:
    //     // v: '3.26',
    //   },

    //   //// If you intend to programmatically custom event listener code
    //   //// (e.g. `this.$refs.gmap.$on('zoom_changed', someFunc)`)
    //   //// instead of going through Vue templates (e.g. `<GmapMap @zoom_changed="someFunc">`)
    //   //// you might need to turn this on.
    //   // autobindAllEvents: false,

    //   //// If you want to manually install components, e.g.
    //   //// import {GmapMarker} from 'vue2-google-maps/src/components/marker'
    //   //// Vue.component('GmapMarker', GmapMarker)
    //   //// then disable the following:
    //   // installComponents: true,

    // })
  }
}

export default RegisterPlugin
