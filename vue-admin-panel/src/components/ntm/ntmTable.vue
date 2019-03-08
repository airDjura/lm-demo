<template>
<div class="table-responsive">
  <table class="table table-bordered table-striped table-vcenter">
      <thead>
        <tr>
          <th v-for="column in showColumns" :key="column.id" :class="columnClass(column)">
            {{ column.name ? $t('table.column.' + column.name) : ''}}
          </th>
          <th v-if="$scopedSlots.actions" class="text-center"
            style="width: 100px;">{{$t('table.column.actions')}}</th>
        </tr>
      </thead>
      <tbody>
        <tr :key="item.id" v-for="item in items">
          <td v-for="column in showColumns" :key="column.id" :class="columnClass(column)">
            <span v-if="!['bool', 'img', 'link'].includes(column.type)" v-html="showInTable(item, column.prop, column.def)"></span>
            <a v-if="column.type === 'link'" :href="'http://' + showInTable(item, column.prop, column.def)" target="_blank">{{showInTable(item, column.prop, column.def)}}</a>
            <img v-if="column.type === 'img' && showInTable(item, column.prop, column.def)" :src="showInTable(item, column.prop, column.def)" class="img-avatar img-avatar32" alt="">
            <bool-label v-if="column.type === 'bool'" :value="showInTable(item, column.prop, column.def)" :yes="column.yes" :no="column.no"></bool-label>
          </td>
          <td v-if="$scopedSlots.actions" class="text-center">
            <div class="btn-group">
              <slot :row="item" name="actions"></slot>
            </div>
          </td>
        </tr>
      </tbody>
  </table>
</div>
</template>

<script>
// import ApiService from '@/services/api.service'

export default {
  props: {
    entityName: {
      type: String,
      default: 'Table'
    },
    items: Array,
    showColumns: Array,
    index: {
      type: String,
      required: true
    },
    url: {
      type: String,
      required: true
    }
  },
  data () {
    return {
      search: ''
    }
  },
  name: 'ntmTable',
  mounted () {
    // this.fetchData()
  },
  watch: {
    search: function () {
      this.fetchData()
    }
  },
  methods: {
    columnClass (column) {
      return {
        'text-center': this.centerColumn(column) || column.align === 'center',
        'text-right': column.align === 'right',
        'text-left': column.align === 'left',
        'column-img': column.type === 'img'
      }
    },
    centerColumn (column) {
      return column.type === 'bool'
    },
    showInTable (item, prop, def) {
      if (item === undefined || item === null) {
        return def || ''
      }
      const index = prop.indexOf('.')
      if (index > -1) {
        return this.showInTable(item[prop.substring(0, index)], prop.substr(index + 1), def)
      }

      return item[prop]
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss">
li.disabled a {
  pointer-events: none;
}
</style>
