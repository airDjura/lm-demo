<template>
  <div class="about">
    <page-header :title="$t('team.create')" :desc="teamName">
      <li class="breadcrumb-item"><router-link :to="{name:'schedules.index'}">{{$tc('schedule.name', 2)}}</router-link></li>
      <li class="breadcrumb-item"><router-link :to="{name:'schedules.show', params: { uuid: model.schedule.uuid }}">{{model.schedule.name}}</router-link></li>
      <li class="breadcrumb-item">{{$tc('team.name', 2)}}</li>
      <li class="breadcrumb-item">{{$t('action.addNew')}}</li>
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
import fields from '../formDefinitions/createTeamFormDefinition'
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
        club: {},
        schedule: {},
        out_of_competition: false
      },
      fields: fields
    }
  },
  mounted () {
    this.fields[4].templateOptions.options = []
  },
  beforeRouteEnter (to, from, next) {
    TeamService.create(to.params.uuid).then((response) => {
      next(vm => vm.setData(response.data))
    })
  },
  watch: {
    'club': 'fetchPlayers'
  },
  methods: {
    fetchPlayers () {
      this.fields[4].templateOptions.options = []
      this.model.players = []
      if (this.model.club.uuid && this.model.club.uuid !== '') {
        ScheduleService.getPlayers(this.$route.params.uuid, this.model.club.uuid).then((response) => {
          this.fields[4].templateOptions.options = response.data
        })
      }
    },
    setData (data) {
      this.fields[2].options = data.groups
      this.model.schedule = {
        uuid: data.uuid,
        name: data.name
      }
    },
    onSubmit () {
      TeamService.store(this.$route.params.uuid, this.model).then((response) => {
        this.$router.push({ name: 'schedules.show', params: { uuid: this.$route.params.uuid } })
      }).catch((err) => {
        this.form.$errors = err.response.data.errors
      })
    }
  },
  computed: {
    club () {
      return this.model.club
    },
    teamName () {
      if (this.model.club.name) {
        return this.model.suffix ? this.model.club.name + ' - ' + this.model.suffix : this.model.club.name
      }
      return ''
    }
  }
}
</script>
