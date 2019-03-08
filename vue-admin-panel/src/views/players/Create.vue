<template>
  <div class="about">
    <page-header :title="$t('player.create')" :desc="getName">
      <li class="breadcrumb-item"><router-link :to="{name:'players.index'}">{{ $tc('player.name', 2) }}</router-link></li>
      <li class="breadcrumb-item">{{$t('action.createNew')}}</li>
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
import PlayerService from '@/services/player.service'
import router from '@/router'

export default {
  // required properties, field, form, model
  data () {
    return {
      form: {},
      model: {
        firstName: '',
        lastName: '',
        middleName: '',
        email: '',
        birthDate: '',
        club: {}
      },
      fields: fields
    }
  },
  methods: {
    onSubmit () {
      PlayerService.store(this.model).then((response) => {
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
