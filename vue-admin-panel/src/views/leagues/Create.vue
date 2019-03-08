<template>
  <div class="about">
    <page-header :title="$t('league.create')" :desc="model.name">
      <li class="breadcrumb-item"><router-link :to="{name:'leagues.index'}">{{$tc('league.name', 2)}}</router-link></li>
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
import LeagueService from '@/services/league.service'
import router from '@/router'

export default {
  // required properties, field, form, model
  data () {
    return {
      form: {},
      model: {},
      fields: fields
    }
  },
  methods: {
    onSubmit () {
      LeagueService.store(this.model).then((response) => {
        router.push({ name: 'leagues.index' })
      }).catch((err) => {
        this.form.$errors = err.response.data.errors
      })
    }
  }
}
</script>
