<template>
  <div>
    <b-modal ref="memberStatusModal" size=""
     :title=" `${modal.member_name}`"
      header-bg-variant="secondary"
      header-text-variant="light"
      @ok="doUpdateMemberStatus"
    >
      <b-row>
        <b-col md="6">
          <b-form-group label="Set Member Status">
            <b-form-radio-group v-model="modal.action"
                                :value="modal.action"
                                :options="modal.activeOptions">
            </b-form-radio-group>
          </b-form-group>
        </b-col>
      </b-row>  
    </b-modal>
    <b-modal ref="photoModal" size="lg" :title="photoModal.name" hide-footer
      header-bg-variant="secondary"
      header-text-variant="light"
    >
      <div>
        <b-img v-if="photoModal.avatar_filename" fluid-grow :src="photoModal.avatar_filename" />
      </div>
    </b-modal>

    <b-modal ref="proxySignupModal" size="lg"
      :title=" `Proxy Signup/Decline for: ${modal.member_name}`"
      header-bg-variant="secondary"
      header-text-variant="light"
      @ok="doProxySignupDecline"
    >
      <b-row>
        <b-col md="6">
          <b-form-group label="Choose an option">
            <b-form-radio-group v-model="modal.action"
                                :value="modal.action"
                                :options="modal.options"
                                name="radioInline">
            </b-form-radio-group>
          </b-form-group>
        </b-col>
        <b-col md="6">
          <b-row>
            Number selected {{ num_events_checked }}
          </b-row>
          <b-row>
            <b-form-group horizontal label="Filter" class="mb-0">
              <b-input-group>
                <b-form-input v-model="modal.filter" placeholder="Type to Search" />
                <b-input-group-append>
                  <b-btn :disabled="!modal.filter" @click="modal.filter = ''">Clear</b-btn>
                </b-input-group-append>
              </b-input-group>
            </b-form-group>
          </b-row>
        </b-col>
      </b-row>
      <b-table striped small bordered hover
          :items="modal.events"
          :fields="modal.event_table_fields"
          :current-page="modal.currentPage"
          :per-page="modal.perPage"
          :filter="modal.filter"
          @filtered="onModalFiltered"
          :sort-compare="mysort">
        <template slot="check" slot-scope="row">
          <b-container>
            <b-form-checkbox align-h="center" align-v="center" class="m-0"
              @click.native.stop
              v-model="row.item.checked">
            </b-form-checkbox>
          </b-container>
        </template>
      </b-table>
      <b-container>
        <b-pagination align-v="center" :total-rows="modal.totalRows" size="sm"
          v-model="modal.currentPage"
          :per-page="modal.perPage"
          class="my-0"
          >
        </b-pagination>
      </b-container>
    </b-modal>
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
      <template slot="memberActive" slot-scope="props">
        <span v-if="!props.rowData.canUpdateUser">
            <span v-if="props.rowData.active" class="badge badge-success"><i class="fa fa-check"></i> Yes</span>
            <span v-if="!props.rowData.active" class="badge badge-danger"><i class="fa fa-minus"></i> No</span>
        </span>
        <span v-else v-b-tooltip.right="'Update Status'" class="">
          <a @click="showMemberStatusModal(props.rowData, props.rowIndex)" href="#" >
            <span v-if="props.rowData.active" class="badge badge-success"><i class="fa fa-check"></i> Yes</span>
            <span v-if="!props.rowData.active" class="badge badge-danger"><i class="fa fa-minus"></i> No</span>
          </a>
          </span>
      </template>
      <template slot="colAvatar" slot-scope="props">
<!-- v-b-popover.click.right.html="avatarPopover(props.rowData)" -->
        <a v-if="props.rowData.avatar_filename" href="#" type="link" class=""
            @click="showPhotoModal(props.rowData, props.rowIndex)"
            :name="'photo'+props.rowData.id">
          <b-img-lazy
            :src="props.rowData.avatar_filename"
            v-b-tooltip.hover.title="'click to open/close larger image'"
            width="70" height="auto" blank-color="#bbb"  alt="No Photo" />
        </a>
        <div v-else>
            No Photo
        </div>
      </template>
      <template slot="actions" slot-scope="props">
        <div class="">
          <span v-b-tooltip.right="'View profile'" class="">
              <a v-show="props.rowData.canUpdateUser" href="#" type="link" class=""
                @click="showMember(props.rowData, props.rowIndex)">
                <i class="fa fa-address-card-o fa-lg fa-fw"></i>
              </a>
          </span>
          <span v-b-tooltip.right="'Proxy Signup/Decline'" class="">
              <a v-show="props.rowData.canUpdateEvent" href="#" type="link" class=""
                  @click="showProxyModal(props.rowData, props.rowIndex)"
                   :data-id="props.rowData.id" :data-name="props.rowData.name" :name="'signup'+props.rowData.id">
                  <i class="fa fa-user-plus fa-lg fa-fw"></i>
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
import moment from 'moment'
import Vuetable from 'vuetable-2/src/components/Vuetable'
import VuetablePagination from 'vuetable-2/src/components/VuetablePagination'
import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo'
import Vue from 'vue'
import VueEvents from 'vue-events'
import CustomActions from './MembersCustomActions'
import DetailRow from './MembersDetailRow'
// import FilterBar from './../FilterBar'

Vue.use(VueEvents)
Vue.component('member-custom-actions', CustomActions)
Vue.component('member-detail-row', DetailRow)
// Vue.component('filter-bar', FilterBar)


export default {
  mixins: [commonMixins],
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
      photoModal: {
        name: '',
        avatar_filename: null
      },
      modal: {
        member_id: 0,
        member_name: '',
        currentPage: 1,
        totalRows: 0,
        perPage: 5,
        action: 'signup',
        options: [{text: 'Signup', value: 'signup'}, {text: 'Decline', value: 'decline'}],
        activeOptions: [{text: 'Active', value: true}, {text: 'In-active', value: false}],
        events: [],
        event_table_fields: [
          {key: 'check', sortable: false},
          {key: 'going', sortable: true},
          {key: 'date', sortable: true},
          {key: 'subject', sortable:false},
          {key: 'organization', sortable: true},
          {key: 'team', sortable: false},
        ]
      },
      fields: [
        {
          title: 'Active',
          sortField: 'active',
          name: '__slot:memberActive',
          // dataClass: 'text-primary',
          // callback: 'setActiveIcon'
        },
        {
          title: 'Photo',
          name: '__slot:colAvatar'
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
          title: '<i class="fa fa-thumbs-o-up fa-w"></i>',
          name: 'yes_responses',
          sortField: 'yes_responses',
          dataClass: 'text-primary text-center',
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
  computed: {
    num_events_checked () {
      let tally = 0;
      const eventsLength = this.modal.events.length;
      for(let x=0;x<eventsLength;x++){
        if (this.modal.events[x].checked) {
          tally++;
        }
      }
      return tally;
    }
  },
  methods: {
    // For proxy modal
    onModalFiltered (filteredItems) {
      // Trigger pagination to update the number of buttons/pages due to filtering
      this.modal.totalRows = filteredItems.length
      this.currentPage = 1
    },
    // custom sort for the "Check" column. defer to default
    // sort for any other column.
    mysort(a, b, key) {
      if (key !== 'check') return null;
      return a.checked < b.checked ? -1 : (a.checked > b.checked ? 1 : 0);
    },
    showMember (data, index) {
          window.location.href = '/member/'+data.id+'/edit';
    },
    avatarPopover (data) {
      return `<div style="width:50%; height:50%;">
          <img src="${data.avatar_filename}" max-width="100%" max-height="auto"/>
        </div>`;
    },
    async doProxySignupDecline () {
      try {
        let data = {}
        data.action = this.modal.action;
        data.event_ids = this.modal.events.filter((e)=>e.checked).map((e)=>e.id);
        // console.log(data)
        let resp = await axios({
                      method: 'post',
                      url: '/api/member/'+this.modal.member_id+'/proxySignup',
                      data: data
                    });
         //reset
        this.collapseAllDetailRows();
        this.$refs.vuetable.reload();
        this.modal.action = 'signup';
      } catch (e) {
        console.log(e)
      }
    },
    showMemberStatusModal(member, index) {
      this.modal.member_name = `${member.name} (${member.email})`;
      this.modal.member_id = member.id;
      this.modal.action = member.active;
      this.$refs.memberStatusModal.show()
    },
    doUpdateMemberStatus() {
      try {
        var url = '/api/member/' + this.modal.member_id + '/status';
      axios.put(url, {active: this.modal.action})
      .then(  (response) => {
        console.log('ok')
      }).catch((error) => {
        console.log('error')
      });

        this.$refs.vuetable.reload();
        
      } catch (e) {
        console.log(e)
      }
    },
    showPhotoModal (member, index) {
      console.log(member.avatar_filename)
      this.photoModal.name = member.name;
      this.photoModal.avatar_filename = member.avatar_filename;
      this.$refs.photoModal.show()
    },
    async showProxyModal (member, index) {
      // console.log(member)
      let events = {};
      let yesEvents = {};
      try {
        //Get list of events user is eligible for
        //and list of events already signed-up for
        [events, yesEvents] = await Promise.all([
          axios.get('/api/member/'+member.id+'/proxyEvents'),
          axios.get('/api/member/' + member.id + '/yes')
        ])
        this.modal.events = [];
        this.modal.currentPage = 1;
        this.modal.member_name = member.name;
        this.modal.member_id = member.id;
        for(let x=0; x<events.data.length; x++) {
          let data = events.data[x];
          let event = {}
          event.id = data.id;
          event.date = data.date_start
          event.subject = data.subject
          event.organization = data.organization_name
          event.team = data.team_name
          event.checked = false
          event.going = yesEvents.data
            .filter(yes=>yes.id==data.id)
            .length > 0 ? 'Yes' : 'No';
          this.modal.events.push(event)
        }
        this.modal.totalRows = this.modal.events.length
      } catch (e) {
        console.log(e)
        return;
      }
      // console.log(events.data)
      this.$refs.proxySignupModal.show()
    },
    expandAllDetailRows: function() {
      this.$refs.vuetable.visibleDetailRows = this.$refs.vuetable.tableData.map(function(item) {
          return item.id
      })
    },
    collapseAllDetailRows: function() {
     this.$refs.vuetable.visibleDetailRows = []
    },
    // setActiveIcon (value) {
    //       return value == true
    //         ? '<span class="label label-success"><i class="fa fa-check"></i> Yes</span>'
    //         : '<span class="label label-danger"><i class="fa fa-minus"></i> No</span>'
    // },
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
/* .custom-control-label::before {
    background-color: darkorange;
} */
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