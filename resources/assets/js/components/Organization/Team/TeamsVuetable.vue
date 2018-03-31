<template>
  <div>
    <filter-bar filterPlaceholder="name"
        :userid="userid"
        :filterByMemberships="true"
        :filterByTeam="false"
    ></filter-bar>
    <vuetable ref="vuetable"
      api-url="/api/team"
      :fields="fields"
      pagination-path=""
      :css="css.table"
      :per-page="10"
      :sort-order="sortOrder"
      :multi-sort="true"
      detail-row-component=""
      :append-params="moreParams"
      @vuetable:cell-clicked="onCellClicked"
      @vuetable:pagination-data="onPaginationData"
      @vuetable:load-success="onLoadSuccess"
    >
      <template slot="actions" scope="props">
        <div class="">
          <span data-toggle="tooltip" title="Edit" data-placement="left" class="">
              <a href="#"  type="link"
                @click="editTeam(props.rowData, props.rowIndex)">
                <i class="fa fa-pencil"></i>
              </a>
          </span>
          <span data-toggle="tooltip" title="View" data-placement="left" class="">
              <a href="#" type="link"
                @click="showTeam(props.rowData, props.rowIndex)">
                <i class="fa fa-eye"></i>
              </a>
          </span>
        </div>
      </template>
    </vuetable>
    <div class="vuetable-pagination">
      <vuetable-pagination-info ref="paginationInfo"
        info-class="pagination-info"
      ></vuetable-pagination-info>
      <vuetable-pagination ref="pagination"
        :css="css.pagination"
        :icons="css.icons"
        @vuetable-pagination:change-page="onChangePage"
      ></vuetable-pagination>
    </div>
  </div>
</template>

<script>
import accounting from 'accounting'
import moment from 'moment'
import Vuetable from 'vuetable-2/src/components/Vuetable'
import VuetablePagination from 'vuetable-2/src/components/VuetablePagination'
import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo'
import Vue from 'vue'
import VueEvents from 'vue-events'
import FilterBar from './../../FilterBar'

Vue.use(VueEvents)
Vue.component('filter-bar', FilterBar)

export default {
  components: {
    Vuetable,
    VuetablePagination,
    VuetablePaginationInfo,
  },
  props: {
    userid: {
      type: Number,
      required: true
    },
    isAdmin: {
    }
  },
  data () {
    return {
      events: [],
      fields: [
        {
          title: 'Organization',
          name: 'organization_name',
          sortField: 'organization_name',
          dataClass: 'text-primary'
        },
        {
          title: 'Team',
          name: 'team_name',
          sortField: 'team_name',
          dataClass: 'text-primary'
        },
        {
          name: '__slot:actions',   // <----
          title: 'Actions',
          titleClass: 'text-center',
          dataClass: 'text-center'
        }
      ],
      css: {
        table: {
          tableClass: 'table table-bordered table-striped table-hover table-condensed',
          ascendingIcon: 'glyphicon glyphicon-chevron-up',
          descendingIcon: 'glyphicon glyphicon-chevron-down'
        },
        pagination: {
          wrapperClass: 'pagination',
          activeClass: 'active',
          disabledClass: 'disabled',
          pageClass: 'page',
          linkClass: 'link',
          icons: {
            first: 'glyphicon glyphicon-step-backward',
            prev: 'glyphicon glyphicon-chevron-left',
            next: 'glyphicon glyphicon-chevron-right',
            last: 'glyphicon glyphicon-step-forward'
          }
        }
      },
      sortOrder: [
        { field: 'organization_name', sortField: 'organization_name', direction: 'asc'}
      ],
      moreParams: {}
    }
  },
  methods: {
    showTeam: function (data, index) {
      window.location.href = '/team/'+data.id;
    },
    editTeam: function (data, index) {
      // console.log(data)
      window.location.href = '/team/'+data.id+'/edit'
    },
    // combine_address: function(value) {
    //
    // },
    onPaginationData (paginationData) {
      this.$refs.pagination.setPaginationData(paginationData)
      this.$refs.paginationInfo.setPaginationData(paginationData)
    },
    onChangePage (page) {
      this.$refs.vuetable.changePage(page)
    },
    onLoadSuccess (response) {
    },
    onCellClicked (data, field, event) {
    //   console.log('cellClicked: ', field.name)
    // this.$refs.vuetable.toggleDetailRow(data.id)

      // if ($('#'+data.id).length == 0) {
      //   axios.get('/member/' + data.id + '/yes' )
      //   .then(  (response) => {
      //     data.events = response.data;
      //     this.$refs.vuetable.toggleDetailRow(data.id)
      //   }).catch((error) => {
      //       console.log(error)
      //   });
      // } else {
      //    this.$refs.vuetable.toggleDetailRow(data.id)
      // }

    },
  },
  events: {
    'filter-set' (filterText, orgid, teamid) {
      this.moreParams = {
        filter: filterText,
        orgid: orgid,
        teamid: teamid
      }
      Vue.nextTick( () => this.$refs.vuetable.refresh() )
    },
    'filter-reset' () {
      this.moreParams = {}
      // this.collapseAllDetailRows();
      Vue.nextTick( () => this.$refs.vuetable.refresh() )
    }
  }
}
</script>
<style>
.pagination {
  margin: 0;
  float: right;
}
.pagination a.page {
  border: 1px solid lightgray;
  border-radius: 3px;
  padding: 5px 10px;
  margin-right: 2px;
}
.pagination a.page.active {
  color: white;
  background-color: #337ab7;
  border: 1px solid lightgray;
  border-radius: 3px;
  padding: 5px 10px;
  margin-right: 2px;
}
.pagination a.btn-nav {
  border: 1px solid lightgray;
  border-radius: 3px;
  padding: 5px 7px;
  margin-right: 2px;
}
.pagination a.btn-nav.disabled {
  color: lightgray;
  border: 1px solid lightgray;
  border-radius: 3px;
  padding: 5px 7px;
  margin-right: 2px;
  cursor: not-allowed;
}
.pagination-info {
  float: left;
}
</style>