<template>
  <div>
      <!-- <div class="vuetable-pagination"> -->
        <!-- <vuetable-pagination-info ref="paginationInfoTop"
          info-class="pagination-info"
        ></vuetable-pagination-info> -->
        <vuetable-pagination ref="paginationTop" style="padding-top:20px"
          :css="css.pagination"
          :icons="css.icons"
          @vuetable-pagination:change-page="onChangePage"
        ></vuetable-pagination>
    <!-- </div> -->
    <!-- <filter-bar></filter-bar> -->
    <filter-bar filterPlaceholder="name, nickname, email"></filter-bar>
    <vuetable ref="vuetable"
      api-url="/member"
      :fields="fields"
      pagination-path=""
      :css="css.table"
      :sort-order="sortOrder"
      :multi-sort="true"
      detail-row-component="member-detail-row"
      :append-params="moreParams"
      @vuetable:cell-clicked="onCellClicked"
      @vuetable:pagination-data="onPaginationData"
      @vuetable:load-success="onLoadSuccess"
    ></vuetable>
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
  // props: [
  //     'canUpdate',
  //     'canView',
  //     'canDelete'
  // ],
  // computed: {
  //     computedCanView: function() {
  //         //console.log('canview', this.canView)
  //         return this.canView
  //     },
  //     computedCanUpdate: function() {
  //         return this.canUpdate
  //     },
  //     computedCanDelete: function() {
  //         return this.canDelete
  //     }
  // },
  data () {
    return {
      fields: [
        // {
        //   name: '__sequence',
        //   title: '#',
        //   titleClass: 'text-right',
        //   dataClass: 'text-right'
        // },
        // {
        //   name: '__checkbox',
        //   titleClass: 'text-center',
        //   dataClass: 'text-center',
        // },
        {
          name: 'name',
          sortField: 'name',
          dataClass: 'text-primary'
        },
        {
          name: 'email',
          sortField: 'email'
        },
        // {
        //   name: 'birthdate',
        //   sortField: 'birthdate',
        //   titleClass: 'text-center',
        //   dataClass: 'text-center',
        //   callback: 'formatDate|DD-MM-YYYY'
        // },
        {
          name: 'nickname',
          sortField: 'nickname'
        //   callback: 'allcap'
        },
        {
          title: '<i class="fa fa-thumbs-o-up fa-w"></i>',
          name: 'yes_responses',
          sortField: 'yes_responses',
          dataClass: 'text-center',
          titleClass: 'text-center',
        },
        // {
        //   name: 'salary',
        //   sortField: 'salary',
        //   titleClass: 'text-center',
        //   dataClass: 'text-right',
        //   callback: 'formatNumber'
        // },
        {
          name: '__component:member-custom-actions',
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
        { field: 'email', sortField: 'email', direction: 'asc'}
      ],
      moreParams: {}
    }
  },
  methods: {
    expandAllDetailRows: function() {
      this.$refs.vuetable.visibleDetailRows = this.$refs.vuetable.tableData.map(function(item) {
          return item.id
      })
    },
    collapseAllDetailRows: function() {
     this.$refs.vuetable.visibleDetailRows = []
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
      this.$refs.paginationTop.setPaginationData(paginationData)      // <----
     // this.$refs.paginationInfoTop.setPaginationData(paginationData)  // <----

      this.$refs.pagination.setPaginationData(paginationData)
      this.$refs.paginationInfo.setPaginationData(paginationData)
    },
    onChangePage (page) {
      this.$refs.vuetable.changePage(page)
    },
    onLoadSuccess (response) {
        response.data.data.forEach(function(el){
            //console.log(el.opt_show_email)
            if (el.opt_show_email==false) {
                el.email=''
            }
            if (el.opt_show_homephone==false){
                el.homephone=''
            }
            if (el.opt_show_mobilephone==false){
                el.mobilephone=''
            }
        })
    },
    onCellClicked (data, field, event) {
    //   console.log('cellClicked: ', field.name)

      if ($('#'+data.id).length == 0) {
        axios.get('/member/' + data.id )
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
      'filter-set' (filterText) {
       // console.log("<",filterText,">")
        this.moreParams = {
          filter: filterText
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