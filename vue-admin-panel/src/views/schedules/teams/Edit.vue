<template>
  <div class="about">
    <page-header :title="$t('team.edit')" :desc="model.name">
      <li class="breadcrumb-item"><router-link :to="{name:'schedules.index'}">{{$tc('schedule.name', 2)}}</router-link></li>
      <li class="breadcrumb-item"><router-link :to="{name:'schedules.show', params: { uuid: model.schedule.uuid }}">{{model.schedule.name}}</router-link></li>
      <li class="breadcrumb-item">{{$tc('team.name', 2)}}</li>
      <li class="breadcrumb-item">{{model.name}}</li>
    </page-header>
    <page-content>
      <form @submit.prevent="onSubmit()">
        <ntm-block :title="model.name">
          <formly-form :form="form" :model="model" :fields="fields"></formly-form>
          <button class="btn btn-success push-15">{{$t('save')}}</button>
        </ntm-block>
      </form>
    </page-content>
  </div>
</template>

<script>
import fields from '../formDefinitions/editTeamFormDefinition'
import TeamService from '../../../services/team.service'
import ScheduleService from '../../../services/schedule.service'
import seasonShowMixin from '../../../mixins/season.show.mixin'

export default {
  mixins: [seasonShowMixin],
  // required properties, field, form, model
  data () {
    return {
      form: {},
      model: {
        schedule: {}
      },
      fields: fields,
      clubSelected: false
    }
  },
  beforeRouteEnter (to, from, next) {
    TeamService.show(to.params.uuid, to.params.team).then((response) => {
      next(vm => vm.setData(response.data))
    })
  },
  methods: {
    setData (data) {
      console.log(data)
      this.model = data
      this.fields[1].options = data.groups
      this.fetchPlayers()
    },
    fetchPlayers () {
      if (this.clubSelected) {
        this.model.players = []
      }
      this.fields[3].templateOptions.options = []
      console.log(this.model)

      if (this.model.club.uuid && this.model.club.uuid !== '') {
        ScheduleService.getEditPlayers(this.$route.params.uuid, this.$route.params.team).then((response) => {
          this.fields[3].templateOptions.options = response.data
          this.clubSelected = true
        })
      }
    },
    onSubmit () {
      TeamService.update(this.$route.params.uuid, this.$route.params.team, this.model).then((response) => {
        this.$router.push({ name: 'schedules.show', params: { uuid: this.$route.params.uuid } })
      }).catch((err) => {
        this.form.$errors = err.response.data.errors
      })
    }
  }
}
</script>
