<template>
  <div class="about">
    <page-header :title="$t('venue.edit')" :desc="model.name">
      <li class="breadcrumb-item"><router-link :to="{name:'venues.index'}">{{$tc('venue.name', 2)}}</router-link></li>
      <li class="breadcrumb-item">{{model.name}}</li>
    </page-header>
    <page-content>
      <form @submit.prevent="onSubmit()">
        <ntm-block>
          <formly-form :form="form" :model="model" :fields="fields"></formly-form>
          <button class="btn btn-success push-15">{{$t('save')}}</button>
        </ntm-block>
      </form>
    </page-content>
  </div>
</template>

<script>
import fields from './formDefinition'
import VenueService from '@/services/venue.service'
import router from '@/router'
import { TokenService } from '@/services/storage.service'

export default {
  // required properties, field, form, model
  data () {
    return {
      form: {},
      model: {},
      fields: fields,
      dropzoneOptions: {
        url: 'http://lm.test/api/venues/' + this.$route.params.uuid + '/upload',
        thumbnailWidth: 150,
        headers: { 'Authorization': `Bearer ${TokenService.getToken()}`, 'Accept': '*', 'Content-type': '*' }
      }
    }
  },
  beforeRouteEnter (to, from, next) {
    VenueService.show(to.params.uuid).then((response) => {
      next(vm => vm.setData(response.data))
    })
  },
  methods: {
    setData (data) {
      this.model = data
    },
    onSubmit () {
      VenueService.update(this.model.uuid, this.model).then((response) => {
        router.push({ name: 'venues.index' })
      }).catch((err) => {
        this.form.$errors = err.response.data.errors
      })
    }
  }
}
</script>
