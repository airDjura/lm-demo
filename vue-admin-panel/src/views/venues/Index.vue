<template>
  <div class="venue_index">
    <page-header :title="$tc('venue.name', 2)">
    </page-header>
    <page-content>
      <ntm-block>
        <template slot="options">
          <input type="text" class="form-control" :placeholder="$t('search')" style="display: inline-block; width: auto; margin-right: 15px;" v-model="search">
          <button @click="createPage()" type="button" class="btn btn-sm btn-success">{{$t('action.addNew')}}</button>
        </template>
        <div class="table-responsive">
          <ntm-table :show-columns="showColumns" :items="items" url="api/venues" index="venues" :actions="true">
            <template slot="actions" slot-scope="{row}">
              <router-link :to="{ name: 'venues.edit', params: {uuid: row.uuid }}" class="btn btn-sm btn-primary">
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
import VenueService from '@/services/venue.service'
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
    VenueService.index('').then((response) => {
      next(vm => vm.setData(response.data))
    })
  },
  methods: {
    fetchData: _.debounce(function () {
      VenueService.index(this.search).then((response) => {
        this.setData(response.data)
      })
    }, 200),
    setData (data) {
      this.items = data
    },
    createPage () {
      router.push({ name: 'venues.create' })
    }
  }
}
</script>
