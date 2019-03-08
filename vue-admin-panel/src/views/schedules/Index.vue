<template>
  <div class="schedule_index">
    <page-header :title="$tc('schedule.name', 2)"></page-header>
    <page-content>
      <ntm-block>
        <template slot="options">
          <!--<input type="text" class="form-control" :placeholder="$t('search')" style="display: inline-block; width: auto; margin-right: 15px;" v-model="search">-->
          <button @click="createPage()" type="button" class="btn btn-sm btn-success">{{$t('action.addNew')}}</button>
        </template>
        <div class="table-responsive">
          <ntm-table :show-columns="showColumns" :items="items" url="api/schedules" index="schedules" :actions="true">
            <template slot="actions" slot-scope="{row}">
              <router-link :to="{ name: 'schedules.show', params: {uuid: row.uuid }}" class="btn btn-sm btn-primary">
                <i class="fa fa-fw fa-eye"></i>
              </router-link>
            </template>
          </ntm-table>
        </div>
      </ntm-block>
      <ntm-modal size="lg" :title="$tc('schedule.create')" ref="newSchedule">
        <template slot="content">
            <formly-form :form="form" :model="model" :fields="fields"></formly-form>
        </template>
        <template slot="footer">
          <button class="btn btn-success push-15" @click="onAddSchedule()">{{$t('save')}}</button>
        </template>
      </ntm-modal>
      <!-- END Full Table -->
    </page-content>
  </div>
</template>
<script>
import ScheduleService from '@/services/schedule.service'
import _ from 'lodash'
import fields from './formDefinitions/createScheduleFormDefinition'
import seasonIndexMixin from '@/mixins/season.index.mixin'

export default {
  mixins: [seasonIndexMixin],
  data () {
    return {
      items: [],
      search: '',
      showColumns: [
        {
          name: 'name',
          prop: 'name'
        }
      ],
      form: {},
      model: {},
      fields: fields
    }
  },
  beforeRouteEnter (to, from, next) {
    ScheduleService.index('').then((response) => {
      next(vm => vm.setData(response.data))
    })
  },
  methods: {
    fetchData: _.debounce(function () {
      ScheduleService.index(this.search).then((response) => {
        this.setData(response.data)
      })
    }, 200),
    createPage () {
      this.$refs.newSchedule.open()
    },
    onAddSchedule () {
      ScheduleService.store(this.model).then((response) => {
        this.$refs.newSchedule.close()
        this.fetchData()
        this.$store.commit('loaded')
      }).catch((err) => {
        this.form.$errors = err.response.data.errors
      })
    }
  }
}
</script>
