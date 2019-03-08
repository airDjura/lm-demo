<template>
  <div class="about">
    <page-header :title="$t('player.edit')" :desc="getName">
      <li class="breadcrumb-item"><router-link :to="{name:'players.index'}">{{ $tc('player.name', 2) }}</router-link></li>
      <li class="breadcrumb-item">{{getName}}</li>
    </page-header>
    <page-content>
      <form @submit.prevent="onSubmit()">
        <ntm-block :title="$tc('profile', 1)">
          <dropzone v-if="$route.params.uuid" type="profile" asset-type="player" :asset-uuid="$route.params.uuid"></dropzone>
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
import PlayerService from '@/services/player.service'
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
        url: 'http://lm.test/api/players/' + this.$route.params.uuid + '/upload',
        thumbnailWidth: 150,
        headers: { 'Authorization': `Bearer ${TokenService.getToken()}`, 'Accept': '*', 'Content-type': '*' }
      }
    }
  },
  beforeRouteEnter (to, from, next) {
    PlayerService.show(to.params.uuid).then((response) => {
      next(vm => vm.setData(response.data))
    })
  },
  methods: {
    setData (data) {
      this.model = data
    },
    onSubmit () {
      PlayerService.update(this.model.uuid, this.model).then((response) => {
        router.push({ name: 'players.index' })
      }).catch((err) => {
        this.form.$errors = err.response.data.errors
      })
    }
  },
  computed: {
    getName () {
      if (this.model.middleName) {
        return this.model.lastName + ' ' + this.model.middleName + ' ' + this.model.firstName
      }
      return this.model.lastName + ' ' + this.model.firstName
    }
  }
}
</script>
