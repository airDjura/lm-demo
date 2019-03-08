<template>
  <div class="player_index">
    <page-header :title="$tc('player.name', 2)">
    </page-header>
    <page-content>
      <ntm-block>
        <template slot="options">
          <input type="text" class="form-control" :placeholder="$t('search')" style="display: inline-block; width: auto; margin-right: 15px;" v-model="search">
          <button @click="createPage()" type="button" class="btn btn-sm btn-success">{{$t('action.addNew')}}</button>
        </template>
        <div class="table-responsive">
          <ntm-table :actions="actions" :show-columns="showColumns" :items="items" url="api/players" index="players">
              <template slot="actions" slot-scope="{row}">
                <router-link :to="{ name: 'players.edit', params: {uuid: row.uuid }}" class="btn btn-sm btn-primary">
                              <i class="fa fa-fw fa-pencil-alt"></i>
                </router-link>
              </template>
          </ntm-table>
        </div>
      </ntm-block>
    </page-content>
  </div>
</template>
<script>
import PlayerService from '@/services/player.service'
import _ from 'lodash'
import router from '@/router'
import basicIndexMixin from '@/mixins/basic.index.mixin'

export default {
  mixins: [basicIndexMixin],
  data () {
    return {
      showColumns: [
        {
          prop: 'profile',
          type: 'img'
        },
        {
          name: 'name',
          prop: 'name'
        },
        {
          name: 'dateOfBirth',
          prop: 'birthDate'
        },
        {
          name: 'club',
          prop: 'club.name',
          def: '<i class="fa fa-globe"></i>'
        }
      ],
      actions: [
        {
          icon: 'fa-pencil-alt',
          route: {
            name: 'players.show',
            params: {
              uuid: 'uuid'
            }
          }
        }
      ]
    }
  },
  beforeRouteEnter (to, from, next) {
    PlayerService.index('').then((response) => {
      next(vm => vm.setData(response.data))
    })
  },
  methods: {
    fetchData: _.debounce(function () {
      PlayerService.index(this.search).then((response) => {
        this.setData(response.data)
      })
    }, 200),
    createPage () {
      router.push({ name: 'players.create' })
    }
  }
}
</script>
