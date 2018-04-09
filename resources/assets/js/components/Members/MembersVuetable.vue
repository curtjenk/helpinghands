<template>
  <div>
    <!-- <vuetable-pagination ref="paginationTop" style="padding-top:20px"
      :css="css.pagination"
      :icons="css.icons"
      @vuetable-pagination:change-page="onChangePage"
    ></vuetable-pagination> -->
    <!-- <filter-bar></filter-bar> -->
    <filter-bar filterPlaceholder="name, nickname, email"
      :userid="userid"
      :filterByMemberships="true"
    ></filter-bar>
    <vuetable ref="vuetable"
      api-url="/api/member"
      :fields="fields"
      pagination-path=""
      :css="css.table"
      :sort-order="sortOrder"
      :multi-sort="true"
      :per-page="15"
      detail-row-component="member-detail-row"
      :append-params="moreParams"
      @vuetable:cell-clicked="onCellClicked"
      @vuetable:pagination-data="onPaginationData"
      @vuetable:load-success="onLoadSuccess"
    >
        <template slot="actions" scope="props">
          <div class="">
            <span data-toggle="tooltip" title="View profile" data-placement="left" class="">
                <a href="#" type="link" class=""
                  @click="showMember(props.rowData, props.rowIndex)">
                  <i class="fa fa-address-card-o fa-lg fa-fw"></i>
                </a>
            </span>
            <!--     // data-toggle="modal" data-target="#proxySignup"
             :data-id="props.rowData.id" :data-name="props.rowData.name" :name="'signup'+props.rowData.id" -->
            <span data-toggle="tooltip" title="Proxy Signup/Decline" data-placement="left" class="">
                <a v-show="isAdmin" href="#" type="link" class=""
                    @click="getEvents(props.rowData, props.rowIndex)"
                     :data-id="props.rowData.id" :data-name="props.rowData.name" :name="'signup'+props.rowData.id">
                    <i class="fa fa-user-plus fa-lg fa-fw"></i>
                </a>
            </span>
            <!-- <span data-toggle="tooltip" title="Pay for an event" data-placement="right" class="">
             <a v-show="isAdmin" href="#" type="button" class="">
                 <i class="fa fa-shopping-cart fa-lg fa-fw"></i>
             </a>
            </span> -->
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
import CustomActions from './MembersCustomActions'
import DetailRow from './MembersDetailRow'
import FilterBar from './../FilterBar'

Vue.use(VueEvents)
Vue.component('member-custom-actions', CustomActions)
Vue.component('member-detail-row', DetailRow)
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
          title: 'Active',
          name: 'active',
          sortField: 'active',
          dataClass: 'text-primary',
          callback: 'setActiveIcon'
        },
        {
          name: 'name',
          sortField: 'name',
          dataClass: 'text-primary'
        },
        {
          name: 'email',
          sortField: 'email'
        },
        {
          name: 'nickname',
          sortField: 'nickname'
        //   callback: 'allcap'
        },
        {
          title: '<i class="fa fa-thumbs-o-up fa-w"> Events</i>',
          name: 'yes_responses',
          sortField: 'yes_responses',
          dataClass: 'text-center',
          titleClass: 'text-center',
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
          ascendingIcon: 'fa fa-chevron-up',
          descendingIcon: 'fa fa-chevron-down'
        },
        pagination: {
          wrapperClass: 'pagination',
          activeClass: 'active',
          disabledClass: 'disabled',
          pageClass: 'page',
          linkClass: 'link',
          icons: {
            first: 'fa fa-step-backward',
            prev: 'fa fa-chevron-left',
            next: 'fa fa-chevron-right',
            last: 'fa fa-step-forward'
          }
        }
      },
      sortOrder: [
        { field: 'email', sortField: 'email', direction: 'asc'}
      ],
      moreParams: {}
    }
  },
  methods: {
    showMember (data, index) {
          window.location.href = '/member/'+data.id+'/edit';
    },
    getEvents (data, index) {
      // console.log(data);
      $("#proxySignup select").empty();
      axios.get('/api/event?paginate=0')
      .then(response => {
        // console.log(response.data)
        for(var i=0; i< response.data.length; i++)
        {
          if (response.data[i].status=='Open') {
            $("#proxySignup select").append(
               $('<option>').text(response.data[i].subject).val(response.data[i].id)
            );
          }
        }
        $('#proxySignup h4').text('Signup/Decline for ' + data.name);
        $('#proxySignup form').attr('action', 'api/member/' + data.id + '/proxySignup');
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
            ? '<span class="label label-success"><i class="fa fa-check"></i> Yes</span>'
            : '<span class="label label-danger"><i class="fa fa-minus"></i> No</span>'
    },
    allcap (value) {
      return value==null ? '' : value.toUpperCase()
    },
    // genderLabel (value) {
    //   return value === 'M'
    //     ? '<span class="label label-success"><i class="glyphicon glyphicon-star"></i> Male</span>'
    //     : '<span class="label label-danger"><i class="glyphicon glyphicon-heart"></i> Female</span>'
    // },
    formatNumber (value) {
      return accounting.formatNumber(value, 2)
    },
    formatDate (value, fmt = 'D MMM YYYY') {
      return (value == null)
        ? ''
        : moment(value, 'YYYY-MM-DD').format(fmt)
    },
    onPaginationData (paginationData) {
      // this.$refs.paginationTop.setPaginationData(paginationData)      // <----
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

      if ($('#'+data.id).length == 0) {
        axios.get('/api/member/' + data.id + '/yes' )
        .then(  (response) => {
          data.events = response.data;
          this.$refs.vuetable.toggleDetailRow(data.id)
        }).catch((error) => {
            console.log(error)
        });
      } else {
         this.$refs.vuetable.toggleDetailRow(data.id)
      }

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