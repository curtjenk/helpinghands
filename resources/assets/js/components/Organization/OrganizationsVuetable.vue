<template>
  <div>
    <filter-bar filterPlaceholder="name"
        :userid="userid"
        :filterByMemberships="false"

    ></filter-bar>
    <vuetable ref="vuetable"
      api-url="/api/organization"
      :fields="fields"
      pagination-path=""
      :css="css.table"
      :per-page="10"
      :sort-order="sortOrder"
      :multi-sort="true"
      detail-row-component="member-detail-row"
      :append-params="moreParams"
      @vuetable:cell-clicked="onCellClicked"
      @vuetable:pagination-data="onPaginationData"
      @vuetable:load-success="onLoadSuccess"
    >
        <template slot="actions" scope="props">
          <div class="">
            <span data-toggle="tooltip" title="View organization" data-placement="left" class="">
                <a href="#" type="button" class=""
                  @click="showOrganization(props.rowData, props.rowIndex)">
                  <i class="fa fa-address-card-o fa-lg fa-fw"></i>
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
import CustomActions from './OrganizationsCustomActions'
import DetailRow from './OrganizationsDetailRow'
import FilterBar from './../FilterBar'

Vue.use(VueEvents)
Vue.component('organization-custom-actions', CustomActions)
Vue.component('organization-detail-row', DetailRow)
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
          name: 'name',
          sortField: 'name',
          dataClass: 'text-primary'
        },
        {
          title: 'Address',
          name: 'address1',
          sortField: 'address1',
          callback: 'combine_address'
        },
        {
          name: 'city',
          sortField: 'city'
        //   callback: 'allcap'
        },
        {
          name: 'state',
          sortField: 'state'
        //   callback: 'allcap'
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
          tableClass: 'table table-bordered table-striped table-hover',
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
        { field: 'name', sortField: 'name', direction: 'asc'}
      ],
      moreParams: {}
    }
  },
  // mounted: function() {
  //   axios.get('/member')
  //   .then( response => {
  //     console.log(response.data)
  //     this.rows = response.data;
  //   })
  //   .catch( error => {
  //     console.log(error);
  //   });
  // },
  methods: {
    showOrganization (data, index) {
          window.location.href = '/organization/'+data.id+'/edit';
    },
    getEvents (data, index) {
      console.log(data);
      $("#proxySignup select").empty();
      axios('/event?paginate=0')
      .then(response => {
        for(var i=0; i< response.data.length; i++)
        {
          if (response.data[i].status=='Open') {
            $("#proxySignup select").append(
               $('<option>').text(response.data[i].subject).val(response.data[i].id)
            );
          }
        }
        $('#proxySignup h4').text('Signup/Decline for ' + data.name);
        $('#proxySignup form').attr('action', 'member/' + data.id + '/proxySignup');
        $("#proxySignup").modal('show');
      })
      .catch(e => {
        console.log(e);
      })
    },
    expandAllDetailRows: function() {
      this.$refs.vuetable.visibleDetailRows = this.$refs.vuetable.tableData.map(function(item) {
          return item.id
      })
    },
    collapseAllDetailRows: function() {
     this.$refs.vuetable.visibleDetailRows = []
    },
    setActiveIcon (value) {
          return value == true
            ? '<span class="label label-success"><i class="glyphicon glyphicon-ok"></i> Yes</span>'
            : '<span class="label label-danger"><i class="glyphicon glyphicon-remove"></i> No</span>'
    },
    allcap (value) {
      return value==null ? '' : value.toUpperCase()
    },
    combine_address: function(value) {

    },
    // formatNumber (value) {
    //   return accounting.formatNumber(value, 2)
    // },
    // formatDate (value, fmt = 'D MMM YYYY') {
    //   return (value == null)
    //     ? ''
    //     : moment(value, 'YYYY-MM-DD').format(fmt)
    // },
    onPaginationData (paginationData) {
    //  this.$refs.paginationTop.setPaginationData(paginationData)      // <----
     // this.$refs.paginationInfoTop.setPaginationData(paginationData)  // <----

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
     // console.log("<",filterText,">")
      this.moreParams = {
        filter: filterText,
        orgid: orgid,
        teamid: teamid
      }
      Vue.nextTick( () => this.$refs.vuetable.refresh() )
    },
    'filter-reset' () {
      this.moreParams = {}
      this.collapseAllDetailRows();
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