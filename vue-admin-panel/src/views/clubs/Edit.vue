<template>
  <div class="about">
    <page-header :title="$t('club.edit')" :desc="model.name">
      <li class="breadcrumb-item"><router-link :to="{name:'clubs.index'}">{{$tc('club.name', 2)}}</router-link></li>
      <li class="breadcrumb-item">{{model.name}}</li>
    </page-header>
    <page-content>
      <form @submit.prevent="onSubmit()">
        <ntm-block :title="$t('logo')">
            <dropzone v-if="$route.params.uuid" type="logo" asset-type="club" :asset-uuid="$route.params.uuid"></dropzone>
        </ntm-block>
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
import ClubService from '@/services/club.service'
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
        url: 'http://lm.test/api/clubs/' + this.$route.params.uuid + '/upload',
        thumbnailWidth: 150,
        headers: { 'Authorization': `Bearer ${TokenService.getToken()}`, 'Accept': '*', 'Content-type': '*' }
      }
    }
  },
  beforeRouteEnter (to, from, next) {
    ClubService.show(to.params.uuid).then((response) => {
      next(vm => vm.setData(response.data))
    })
  },
  methods: {
    setData (data) {
      this.model = data
    },
    onSubmit () {
      ClubService.update(this.model.uuid, this.model).then((response) => {
        router.push({ name: 'clubs.index' })
      }).catch((err) => {
        this.form.$errors = err.response.data.errors
      })
    }
  }
}
</script>
