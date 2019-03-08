<template>
  <div class="schedule_show">
    <page-header :title="model.name" :desc="$tc('schedule.name', 1)">
      <li class="breadcrumb-item"><router-link :to="{name:'schedules.index'}">{{$tc('schedule.name', 2)}}</router-link></li>
      <li class="breadcrumb-item">{{model.name}}</li>
    </page-header>
    <page-content>
      <ntm-block :title="$tc('action.name', 2)">
        <template slot="options">
          <!--<input type="text" class="form-control" placeholder="Search" style="display: inline-block; width: auto; margin-right: 15px;" v-model="search">-->
          <button type="button"
                  @click="$router.push({name: 'schedules.teams.create'})"
                  class="btn btn-sm btn-success">{{$t('schedule.team.add')}}
          </button>
          <button type="button" class="btn btn-sm btn-success" @click="addGroup()">{{$t('group.add')}}</button>
          <button v-if="model.games.length < 1"
                  type="button"
                  class="btn btn-sm btn-warning"
                  @click="$refs.generateSchedule.open()">{{$t('schedule.games.generate')}}
          </button>
          <!--<button v-if="Object.keys(model.games).length > 0"-->
                  <!--type="button"-->
                  <!--class="btn btn-sm btn-warning"-->
                  <!--@click="regenerate()">{{$t('schedule.games.regenerate')}}-->
          <!--</button>-->
        </template>
      </ntm-block>
      <div class="groups" v-drag-and-drop:options="dragOptions">
        <ntm-block :showContent="true"
                   v-for="(group, n) in model.groups"
                   :key="group.uuid"
                   :title="model.groups.length > 1 ? $tc('group.name', 1) + ' ' + group.name : $tc('team.name', 2)">
          <template slot="options">
            <!--<input type="text" class="form-control" placeholder="Search" style="display: inline-block; width: auto; margin-right: 15px;" v-model="search">-->
            <button type="button"
                    class="btn btn-sm btn-danger"
                    v-if="n !== 0"
                    @click="deleteGroup(group.uuid)"><i class="fa fa-fw fa-trash"></i></button>
          </template>
          <div class="row" :id="group.uuid">
            <div class="team col-sm-12"
                 v-for="team in orderedTeams(group.teams)"
                 :id="team.uuid"
                 :key="team.uuid">
              <div class="team-wrapper">
                <span>{{team.name}}</span>
                <button v-if="model.games.length === 0" class="btn btn-sm btn-danger" @click="deleteTeam(team.uuid)">
                  <i class="fa fa-fw fa-window-close"></i></button>
                <router-link :to="{ name: 'schedules.teams.show', params: {uuid: $route.params.uuid, team: team.uuid }}"
                             class="btn btn-sm btn-primary">
                  <i class="fa fa-fw fa-eye"></i>
                </router-link>
              </div>
            </div>
          </div>
        </ntm-block>
      </div>
      <ntm-block :title="$tc('game.name', 2)">
        <template slot="options">
          <button class="btn btn-sm btn-danger" @click="deleteAllGames()">
            <i class="fa fa-fw fa-trash"></i></button>
        </template>
        <div class="row">
          <div v-for="(round, roundName) in model.games" :key="roundName" class="game-round col-12">
            <h4>{{$tc('round', 1)}} {{roundName}}</h4>
            <div>
              <table class="table table-vcenter table-striped">
                <thead>
                <tr>
                  <th v-if="model.groups.length > 1" class="text-center" style="width: 50px;">{{$tc('group.name', 1)}}</th>
                  <th width="40%">{{$t('home')}}</th>
                  <th width="40%">{{$t('away')}}</th>
                  <th class="text-center" style="width: 100px;">{{$tc('action.name', 2)}}</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="game in round" :key="game.uuid">
                  <th v-if="model.groups.length > 1" class="text-center"  v-text="game.group.name"></th>
                  <td class="font-w600 font-size-sm">
                    <router-link v-if="game.home_team" v-html="teamName(game.home_team)" :to="{ name: 'schedules.teams.show', params: {uuid: $route.params.uuid, team: game.home_team.uuid }}"
                                 class="btn btn-sm btn-primary">
                    </router-link>
                    <span v-else class="badge badge-danger" style="font-size: 14px;" v-html="teamName(game.home_team)"></span>
                  </td>
                  <td class="font-w600 font-size-sm">
                    <router-link v-if="game.away_team" v-html="teamName(game.away_team)" :to="{ name: 'schedules.teams.show', params: {uuid: $route.params.uuid, team: game.away_team.uuid }}"
                                 class="btn btn-sm btn-primary">
                    </router-link>
                    <span v-else class="badge badge-danger" style="font-size: 14px;" v-html="teamName(game.away_team)"></span>
                  </td>
                  <td class="text-center">
                    <div class="btn-group" v-if="game.away_team && game.home_team">
                      <router-link :to="{ name: 'schedules.games.show', params: {uuid: $route.params.uuid, game: game.uuid }}"
                                   class="btn btn-sm btn-primary">
                        <i class="fa fa-fw fa-pen"></i>
                      </router-link>
                      <!--<button @click="deleteGame(game.uuid)" type="button"-->
                              <!--class="btn btn-sm btn-primary">-->
                        <!--<i class="fa fa-fw fa-trash"></i>-->
                      <!--</button>-->
                    </div>
                  </td>
                </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </ntm-block>
      <ntm-modal size="sm" :title="$t('schedule.games.generate')" ref="generateSchedule">
        <template slot="content">
          <formly-form :form="generateForm"
                       :model="generateData"
                       :fields="generateFields"></formly-form>
        </template>
        <template slot="footer">
          <button class="btn btn-success push-15" @click="generate()">{{$t('save')}}</button>
        </template>
      </ntm-modal>
      <!--<ntm-block title="Matches">-->
      <!--<template slot="options">-->
      <!--&lt;!&ndash;<input type="text" class="form-control" placeholder="Search" style="display: inline-block; width: auto; margin-right: 15px;" v-model="search">&ndash;&gt;-->
      <!--<button type="button" class="btn btn-sm btn-success" v-if="model.games.length === 0">Generate games</button>-->
      <!--</template>-->
      <!--<p v-if="model.games.length === 0">No matches found</p>-->
      <!--</ntm-block>-->
    </page-content>
  </div>
</template>
<script>
import seasonShowMixin from '@/mixins/season.show.mixin'
import ScheduleService from '../../services/schedule.service'
import _ from 'lodash'
import TeamService from '../../services/team.service'
import generateScheduleFormDefinition from './formDefinitions/generateScheduleFormDefinition'
import GameService from '../../services/game.service'

export default {
  mixins: [seasonShowMixin],
  data () {
    return {
      dragOptions: {
        dropzoneSelector: '.block .block-content .row',
        draggableSelector: '.team',
        onDrop: (event) => {
          if (event.owner !== event.droptarget) {
            this.dragTeam(event.droptarget.id, event.items[0].id)
          }
        },
        onDragstart: (event) => {
        },
        onDragend: (event) => {
        }
      },
      generateForm: {},
      generateFields: generateScheduleFormDefinition,
      generateData: {
        cycles: 1
      },
      showColumns: [
        {
          name: 'name',
          prop: 'name'
        }
      ],
      model: {
        games: [],
        groups: []
      }
    }
  },
  beforeRouteEnter (to, from, next) {
    ScheduleService.show(to.params.uuid).then((response) => {
      next(vm => vm.setData(response.data))
    })
  },
  methods: {
    setData (data) {
      this.model = data
    },
    fetchData () {
      ScheduleService.show(this.$route.params.uuid).then((response) => {
        this.setData(response.data)
      })
    },
    addGroup () {
      ScheduleService.addGroup(this.$route.params.uuid).then(() => {
        this.fetchData()
        this.$store.commit('loaded')
      })
    },
    deleteGroup (uuid) {
      ScheduleService.deleteGroup(this.$route.params.uuid, uuid).then(() => {
        this.fetchData()
        this.$store.commit('loaded')
      })
    },
    dragTeam (groupUuid, teamUuid) {
      ScheduleService.changeGroup(this.$route.params.uuid,
        teamUuid,
        { group: { uuid: groupUuid } }).then(() => {
        this.fetchData()
        this.$store.commit('loaded')
      })
    },
    deleteTeam (uuid) {
      TeamService.destroy(this.$route.params.uuid, uuid).then(() => {
        this.fetchData()
      })
    },
    orderedTeams: function (teams) {
      return _.orderBy(teams, 'name')
    },
    teamName (team) {
      if (team) {
        if (team.suffix) {
          return team.club.name + ' ' + team.suffix
        } else {
          return team.club.name
        }
      }
      return 'Empty'
    },
    generate () {
      ScheduleService.generate(this.$route.params.uuid, this.generateData).then(() => {
        this.$refs.generateSchedule.close()
        this.fetchData()
        this.$store.commit('loaded')
      }).catch(() => {
        this.$refs.generateSchedule.close()
      })
    },
    regenerate () {
      console.log(200)
    },
    deleteGame (uuid) {
      GameService.destroy(this.$route.params.uuid, uuid).then(() => {
        this.fetchData()
      })
    },
    deleteAllGames () {
      return ScheduleService.deleteAllGames(this.$route.params.uuid).then(() => {
        this.fetchData()
      })
    }
  }
}
</script>

<style type="scss">
  .game-round {
    margin-bottom: 15px;
  }

  .groups .block-content .row {
    min-height: 50px;
    padding-bottom: 30px;
  }

  .groups .team-wrapper {
    display: inline-block;
    width: 100%;
    padding-top: 5px;
    padding-bottom: 5px;
    border-bottom: 1px solid #eeeeee;
  }

  .groups .team span {
    float: left;
  }

  .groups .team .btn {
    float: right;
    margin-left: 5px;
  }
</style>
