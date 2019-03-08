<template>
  <div>
    <page-header :title="$t('game.edit')">
      <li class="breadcrumb-item"><router-link :to="{name:'schedules.index'}">{{$tc('schedule.name', 2)}}</router-link></li>
      <li class="breadcrumb-item"><router-link :to="{name:'schedules.show', params: { uuid: model.schedule.uuid }}">{{model.schedule.name}}</router-link></li>
      <li class="breadcrumb-item">{{$tc('game.name', 2)}}</li>
      <li class="breadcrumb-item">{{$tc('round', 1)}} {{model.round}}</li>
      <li class="breadcrumb-item">{{model.homeTeam + ' : ' + model.awayTeam}}</li>
    </page-header>
    <page-content>
      <ntm-block :title="$tc('information', 2)">
        <table class="table text-center">
          <thead>
            <tr>
              <th style="width: 50%;">{{$t('home')}}</th>
              <th style="width: 50%;">{{$t('away')}}</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><h3 class="font-w400">{{model.homeTeam}}</h3></td>
              <td><h3 class="font-w400">{{model.awayTeam}}</h3></td>
            </tr>
          </tbody>
        </table>
        <h3 class="text-center"></h3>
      </ntm-block>
    </page-content>
  </div>
</template>

<script>
import seasonShowMixin from '../../../mixins/season.show.mixin'
import GameService from '../../../services/game.service'

export default {
  mixins: [seasonShowMixin],
  data () {
    return {
      form: {},
      model: {
        schedule: {}
      },
      // fields: fields,
      clubSelected: false
    }
  },
  beforeRouteEnter (to, from, next) {
    GameService.show(to.params.uuid, to.params.game).then((response) => {
      next(vm => vm.setData(response.data))
    })
  },
  methods: {
    //
  }
}
</script>
