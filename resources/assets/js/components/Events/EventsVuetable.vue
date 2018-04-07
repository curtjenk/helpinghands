<template>
  <div>
    <modal name="descriptionhtml" height="auto" :scrollable="true">
      <div class="pull-right" >
        <button style="border: none; padding:0; background: none;" class=""
          @click="$modal.hide('descriptionhtml')" >
           ❌
        </button>
      </div>
      <div><b>Subject:</b>&nbsp;{{ modaldata.subject }}</div>
      <hr />
      <span v-html="modaldata.descriptionhtml"></span>
    </modal>
    <filter-bar v-if="!isObjectEmpty(user)" filterPlaceholder=" subject, description"
      :filterByMemberships="true"
    ></filter-bar>

    <vuetable ref="vuetable"
      api-url="/api/event"
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
    >
      <template slot="actions2" scope="props">
        <div class="">
          <span  v-b-tooltip.hover="'Details'" class="">
              <a href="#" type="link" class=""
                @click="showEvent(props.rowData, props.rowIndex)">
                <i class="fa fa-eye  fa-fw"></i>
              </a>
          </span>
          <span v-if="props.rowData.can_create_event" v-b-tooltip.hover="'Notify Sign-ups'" class="">
            <a href="#" type="link" class=""
                data-toggle="modal" data-target="#eventnotify"
                :data-id="props.rowData.id" :data-name="props.rowData.subject.ellipsisText(20)" :name="'notify'+props.rowData.id">
                <i class="fa fa-envelope-o fa-fw"></i>
            </a>
          </span>
          <span v-if="props.rowData.can_create_event" v-b-popover.hover.top.html="evitePopoverMethod(props.rowData)" title="Send E-vites" class="">
            <a href="#" type="link" class="" :id="'evite'+props.rowData.id">
                <i class="fa fa-paper-plane-o fa-fw"></i>
            </a>
          </span>
          <span v-if="props.rowData.can_create_event"  v-b-tooltip.hover="'Pay for an event'" class="">
            <a href="#" type="link" class=""
               @click="getSignupsPay(props.rowData, props.rowIndex)"
               :data-id="props.rowData.id" :data-name="props.rowData.name" :name="'pay'+props.rowData.id">
              <i class="fa fa-shopping-cart fa-fw"></i>
            </a>
          </span>
          <span v-if="props.rowData.can_create_event" v-b-tooltip.hover="'Delete'" class="">
            <a href="#" type="link" class=""
                data-toggle="modal" data-target="#deleteevent"
                :data-id="props.rowData.id" :data-name="props.rowData.subject.ellipsisText(20)" :name="'delete_'+props.rowData.id">
                <i class="fa fa-trash fa-fw"></i>
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
import {commonMixins} from '../../mixins/common';
import accounting from 'accounting'
import Vuetable from 'vuetable-2/src/components/Vuetable'
import VuetablePagination from 'vuetable-2/src/components/VuetablePagination'
import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo'
import Vue from 'vue'
import VueEvents from 'vue-events'
import CustomActions from './EventsCustomActions'
import DetailRow from './EventsDetailRow'
import FilterBar from './../FilterBar'
// quill require styles
import 'quill/dist/quill.core.css'
import 'quill/dist/quill.snow.css'
import 'quill/dist/quill.bubble.css'
import { quillEditor } from 'vue-quill-editor'


Vue.use(VueEvents)
Vue.component('event-custom-actions', CustomActions)
Vue.component('events-detail-row', DetailRow)
Vue.component('filter-bar', FilterBar)

export default {
  mixins: [commonMixins],
  components: {
    Vuetable,
    VuetablePagination,
    VuetablePaginationInfo,
  },
  props: {
  },
  data () {
    return {
      ready: false,
      modaldata: {
        subject: '',
        descriptionhtml: ''
      },
      fields: [
        {
          title: 'Organization',
          name: 'organization_name',
          sortField: 'organizations.name',
          dataClass: 'text-center',
          titleClass: 'text-center',
          dataClass: 'text-primary',
          callback: 'ellipsis|30'
        },
        {
          title: 'Team',
          name: 'team_name',
          sortField: 'teams.name',
          dataClass: 'text-center',
          titleClass: 'text-center',
          dataClass: 'text-primary',
          callback: 'ellipsis|30'
        },
        {
          name: 'subject',
          sortField: 'subject',
          dataClass: 'text-center',
          titleClass: 'text-center',
          dataClass: 'text-primary',
          callback: 'ellipsis|30'
        },
        {
          title: 'Description',
          name: 'description_text',
          titleClass: 'text-center',
          dataClass: 'text-primary',
          callback: 'ellipsis|30'
        },
        {
          name: 'status',
          sortField: 'status',
          titleClass: 'text-center',
          dataClass: 'text-center',
        },
        // {
        //   name: 'signup_limit',
        //   title: 'Signup Limit',
        //   titleClass: 'text-center',
        //   dataClass: 'text-center',
        //   sortField: 'signup_limit',
        //   callback: 'signupLimit'
        // },
        {
          title: '<i class="fa fa-thumbs-o-up fa-w"></i>',
          name: 'yes_responses',
          sortField: 'yes_responses',
          dataClass: 'text-primary',
          titleClass: 'text-center '
        },
        // {
        //   title: '<i class="fa fa-thumbs-o-down fa-w"></i>',
        //   name: 'no_responses',
        //   sortField: 'no_responses',
        //   dataClass: 'text-primary',
        //   titleClass: 'text-center'
        // },
        {
          name: 'date_start',
          title: 'Begin',
          sortField: 'date_start',
          titleClass: 'text-center',
          dataClass: 'text-center',
          callback: 'formatDate|YYYY-MM-DD'
        },
        {
          name: 'date_end',
          title: 'End',
          sortField: 'date_end',
          titleClass: 'text-center',
          dataClass: 'text-center',
          callback: 'formatDate|YYYY-MM-DD'
        },
        {
          name: '__slot:actions2',   // <----
          title: 'Actions',
          titleClass: 'text-center',
          dataClass: 'text-center'
        }
      ],
      css: {
        table: {
          tableClass: 'table table-bordered table-striped table-hover table-condensed',
          ascendingIcon: 'fa fa-chevron-up',
          descendingIcon: 'fa fa-chevron-down',
          thumbsup: 'fa fa-thumbs-o-up'
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
        },
      },
      sortOrder: [
        { field: 'date_start', sortField: 'date_start', direction: 'desc'}
      ],
      moreParams: {}
    }
  },
  computed: {
    evitePopoverConfig () {
      return {
        html: true,
        title: () => { return '<b>Send E-vites</b>' },
        content: () => { return 'Last sent on <em> Feb 14, 2018 </em>' }
      }
    }
  },
  mounted: function() {
    this.$nextTick(function() {
      this.ready = true;
    });
  },
  methods: {
    evitePopoverMethod (data) {
      // console.log(data)
      return `Last sent on ${data.description}`
    },
    showEvent (data, index) {
        // console.log('slot)', data.subject, index)
        window.location.href = '/event/'+data.id;
    },
    onAction2 (action, data, index) {
    //   console.log('slot) action: ' + action, data.subject, index)
    },
    getSignupsPay (data, index) {
    //   console.log(data);
      $("#payups").empty();
      axios.get('/api/member/signups/'+data.id)
      .then(response => {
        for(var i=0; i< response.data.length; i++)
        {
          let resp = response.data[i];
        //   console.log(resp);
          var $div = $("<div>", {"class": "col-md-4"});
          $('#payups').append($div);
          $('<input/>', {
               id: 'pay'+resp.id,
               type: 'checkbox',
               name: 'pay[]',
               checked: resp.paid ? true : false,
               value: resp.id}).appendTo($div);
          $('<label />', {
              'for': 'pay'+resp.id,
              style: 'padding-left:3px;',
              text: resp.name }).appendTo($div);

        }
        $('#eventPay h4').text('Check member(s) paying/paid for "' + data.subject + '"');
        $('#eventPay form').attr('action', 'api/member/eventpay/'+data.id);
        $("#eventPay").modal('show');
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
    allcap (value) {
      return value==null ? '' : value.toUpperCase()
    },
    ellipsis (value, max = 1) {
      if (value) {
        return value.ellipsis(max)
      }
      return value;
    },
    signupLimit (value) {
        if(!value || value==0){
            return 'None'
        } else {
            return value
        }
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
    formatMoney (value) {
        return value;
        // return '$'+value;
    },
    onPaginationData (paginationData) {
      //this.$refs.paginationTop.setPaginationData(paginationData)      // <----
     // this.$refs.paginationInfoTop.setPaginationData(paginationData)  // <----

      this.$refs.pagination.setPaginationData(paginationData)
      this.$refs.paginationInfo.setPaginationData(paginationData)
    },
    onChangePage (page) {
      this.$refs.vuetable.changePage(page)
    },
    onLoadSuccess (response) {
        //console.log('onloadsuccess')
    },
    onCellClicked (data, field, event) {
      // console.log('cellClicked: ', field.name)
      if (field.name=='yes_responses' || field.name=='no_responses') {
        if ($('#'+data.id).length == 0) {
          axios.get('/api/event/' + data.id + '/members')
          .then(  (response) => {
           // console.log(response.data);
            data.members = response.data;
            this.$refs.vuetable.toggleDetailRow(data.id)
          }).catch((error) => {

          });
        } else {
          this.$refs.vuetable.toggleDetailRow(data.id)
        }
      }
      if (field.name=='description_text' || field.name=='subject') {
        this.modaldata.descriptionhtml = data.description;
        this.modaldata.subject = data.subject;
        this.$modal.show('descriptionhtml');
      }
    },
  },
  events: {
    'filter-set' (filterText, orgid, teamid) {
      this.moreParams = {
        filter: filterText,
        orgid: orgid,
        teamid: teamid
      }
      Vue.nextTick( () =>
            this.$refs.vuetable.refresh()
      )
    },
    'filter-reset' () {
      this.moreParams = {}
      this.collapseAllDetailRows()
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