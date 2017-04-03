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
    <filter-bar filterPlaceholder="subject, description"></filter-bar>

    <vuetable ref="vuetable"
      api-url="/event"
      :fields="fields"
      pagination-path=""
      :css="css.table"
      :sort-order="sortOrder"
      :multi-sort="true"
      detail-row-component="events-detail-row"
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
import CustomActions from './EventsCustomActions'
import DetailRow from './EventsDetailRow'
import FilterBar from './../FilterBar'

Vue.use(VueEvents)
Vue.component('custom-actions', CustomActions)
Vue.component('events-detail-row', DetailRow)
Vue.component('filter-bar', FilterBar)

export default {
  components: {
    Vuetable,
    VuetablePagination,
    VuetablePaginationInfo,
  },
  data () {
    return {
      fields: [
        {
          name: '__sequence',
          title: '#',
          titleClass: 'text-right',
          dataClass: 'text-right'
        },
        // {
        //   name: '__checkbox',
        //   titleClass: 'text-center',
        //   dataClass: 'text-center',
        // },
        {
          name: 'subject',
          sortField: 'subject',
          dataClass: 'text-primary'
        },
        {
          name: 'description'
        //   sortField: 'email'
        },
        {
          name: 'evite_sent',
          title: 'Evite?',
          titleClass: 'text-center',
          dataClass: 'text-center',
          sortField: 'evite_sent',
          callback: 'eviteLabel'
        },
        {
          name: 'date_start',
          title: 'Begin',
          sortField: 'date_start',
          titleClass: 'text-center',
          dataClass: 'text-center',
          callback: 'formatDate|DD-MM-YYYY'
        },
        {
          name: 'date_end',
          title: 'End',
          sortField: 'date_end',
          titleClass: 'text-center',
          dataClass: 'text-center',
          callback: 'formatDate|DD-MM-YYYY'
        },
        // {
        //   name: 'salary',
        //   sortField: 'salary',
        //   titleClass: 'text-center',
        //   dataClass: 'text-right',
        //   callback: 'formatNumber'
        // },
        {
          name: '__component:custom-actions',
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
        },
        icons: {
          first: 'glyphicon glyphicon-step-backward',
          prev: 'glyphicon glyphicon-chevron-left',
          next: 'glyphicon glyphicon-chevron-right',
          last: 'glyphicon glyphicon-step-forward',
        },
      },
      sortOrder: [
        { field: 'date_start', sortField: 'date_start', direction: 'desc'}
      ],
      moreParams: {}
    }
  },
  methods: {
    allcap (value) {
      return value==null ? '' : value.toUpperCase()
    },
    eviteLabel (value) {
        return (value == null)
          ? '<i class="fa fa-frown-o" style="color: red;"></i>'
          : '<i class="fa fa-check-square" style="color: green;"></i>'

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
        console.log('onloadsuccess')
        // response.data.data.forEach(function(el){
        //     console.log(el.opt_show_email)
        //     if (el.opt_show_email==false) {
        //         el.email=''
        //     }
        //     if (el.opt_show_homephone==false){
        //         el.homephone=''
        //     }
        //     if (el.opt_show_mobilephone==false){
        //         el.mobilephone=''
        //     }
        // })
    },
    onCellClicked (data, field, event) {
    //   console.log('cellClicked: ', field.name)

      if ($('#'+data.id).length == 0) {
        axios.get('/event/' + data.id + '/members')
        .then(  (response) => {
         // console.log(response.data);
          data.members = response.data;
          this.$refs.vuetable.toggleDetailRow(data.id)
        }).catch((error) => {

        });
      } else {
        this.$refs.vuetable.toggleDetailRow(data.id)
      }
    },
  },
  events: {
    'filter-set' (filterText) {
      this.moreParams = {
        filter: filterText
      }
      Vue.nextTick( () =>
            this.$refs.vuetable.refresh()
      )
    },
    'filter-reset' () {
      this.moreParams = {}
      if (this.$refs.vuetable) {
        Vue.nextTick( () => this.$refs.vuetable.refresh() )
      }
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