<template>
  <div class="league_index">
    <page-header :title="$tc('league.name', 2)">
    </page-header>
    <page-content>
      <ntm-block>
        <template slot="options">
          <input type="text" class="form-control" :placeholder="$t('search')" style="display: inline-block; width: auto; margin-right: 15px;" v-model="search">
          <button @click="createPage()" type="button" class="btn btn-sm btn-success">{{$t('action.addNew')}}</button>
        </template>
        <div class="table-responsive">
          <ntm-table :show-columns="showColumns" :items="items" url="api/leagues" index="leagues" :actions="true">
            <template slot="actions" slot-scope="{row}">
              <router-link :to="{ name: 'leagues.edit', params: {uuid: row.uuid }}" class="btn btn-sm btn-primary">
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
import LeagueService from '@/services/league.service'
import _ from 'lodash'
import router from '@/router'
import basicIndexMixin from '@/mixins/basic.index.mixin'

export default {
  mixins: [basicIndexMixin],
  data () {
    return {
      showColumns: [
        {
          name: 'name',
          prop: 'name'
        }
      ]
    }
  },
  beforeRouteEnter (to, from, next) {
    LeagueService.index('').then((response) => {
      next(vm => vm.setData(response.data))
    })
  },
  methods: {
    fetchData: _.debounce(function () {
      LeagueService.index(this.search).then((response) => {
        this.setData(response.data)
      })
    }, 200),
    createPage () {
      router.push({ name: 'leagues.create' })
    }
  }
}
</script>
