<template>
<div class="container">
  <div class="row">
    <b-col >
      <template v-if="modeShow">
        <b-row class="no-gutters">
          <b-col sm="2">Name</b-col>
          <b-col sm="6" md="6" class="font-weight-bold">{{ team_name }}</b-col>
        </b-row>
        <b-row class="no-gutters">
          <b-col sm="2">Description</b-col>
          <b-col sm="9" md="9" class="font-weight-bold">{{ team_description }}</b-col>
        </b-row>
      </template>
      <template v-else>
        <div class="offset-md-2 col-md-8 text-center">
          <div class="alert alert-success" v-if="statusSuccess" transition="expand">Team information was saved/updated.</div>
          <div class="alert alert-danger" v-if="statusFailed" transition="expand">
              <span>Sorry, unable to save your change(s)</span>
          </div>
        </div>
        <b-row class="no-gutters">
          <b-col sm="2">Name</b-col>
          <b-col sm="6" md="6" lg="6">
            <b-form-input  required id="name" v-model="team_name" type="text" name="name" autofocus>
            </b-form-input>
          </b-col>
        </b-row>
        <b-row class="no-gutters">
          <b-col sm="2">Description</b-col>
          <b-col sm="9" md="9" lg="9">
            <b-form-input  required id="name" v-model="team_description" type="text" name="name" autofocus>
            </b-form-input>
          </b-col>
        </b-row>
        <div class="text-center mt-3">
          <b-button type="submit" variant="primary" name="submit" @click="saveTeam">
              <i class="fa fa-btn fa-check"></i> Save Team
          </b-button>
        </div>
      </template>
    </b-col>
  </div>
  <hr/>
  <b-row>
    <div class="caption">Team Members &nbsp;&nbsp;&nbsp;
      <span v-if="other_org_members && other_org_members.length>0 && !isAddingMember && modeEdit">
        <a id="addmember" v-b-tooltip.hover.right="'Add Team Member'" href="#" class="text-success" @click="toggleIsAddingMember()">
          <i class="fa fa-user fa-lg fa-fw text-success"></i>
        </a>
      </span>
    </div>
    <template v-if="isAddingMember">
      <b-card no-body style="min-width: 100%;">
        <b-card-body>
          <b-row class="no-gutters">
            <select v-model="new_member">
              <option disabled value="">Please select one</option>
              <option v-for="oom in other_org_members" v-bind:value="oom">
                {{ oom.name }} &nbsp;< {{oom.email}} >
             </option>
            </select>
            <a id="saveNew" v-b-tooltip.hover.top="'Save'" href="#" class="text-primary" @click="saveNewMember()">
              <i class="fa fa-floppy-o fa-lg fa-fw"></i>
            </a>
            <a id="cancelNew" v-b-tooltip.hover.top="'Cancel'" href="#" class="text-danger" @click="toggleIsAddingMember()">
              <i class="fa fa-ban fa-lg fa-fw"></i>
            </a>
          </b-row>
        </b-card-body>
      </b-card>
    </template>
  </b-row>
  <div class="row mt-1">
    <b-table striped small bordered hover :items="table_items" :fields="members_table_fields">
      <template  slot="leader" slot-scope="row">
        <span v-if="modeEdit">
          <span v-if="row.item.role=='Lead'">
            <a :id="'remlead_' + row.item.id" v-b-tooltip.hover.right="'Remove as Leader'" href="#" class="text-primary" @click.stop="updateLeader('delete', row.index)">
              <i class="fa fa-check-square-o fa-fw"></i>
            </a>
          </span>
          <span v-else>
            <a :id="'makelead_' + row.item.id" v-b-tooltip.hover.right="'Make Leader'" href="#" class="" @click.stop="updateLeader('post', row.index)">
              <i class="fa fa-square-o fa-fw"></i>
            </a>
          </span>
        </span>
        <span v-else>
          <span v-if="row.item.role=='Lead'">
            <i class="fa fa-check-square-o fa-fw"></i>
          </span>
          <span v-else>
            <i class="fa fa-square-o fa-fw"></i>
          </span>
        </span>
      </template>
      <template v-if="modeEdit" slot="action" slot-scope="row">
        <a :id="'del_' + row.item.id" href="#" v-b-tooltip.hover.right="'Remove'" class="text-danger" @click.stop="removeMember2(row.index)">
          <i class="fa fa-trash-o fa-fw"></i>
        </a>
      </template>
    </b-table>
  </div>
</div>
</template>

<script>

import {commonMixins} from '../../../mixins/common';
import {MESSAGE_DURATION} from '../../../mixins/constants';
import ColumnFilter from '../../../components/Tables/ColumnFilter.vue';

export default {
  mixins: [commonMixins],
  components: {
    ColumnFilter
  },
  props: {
    mode0: {
      type: String,
      required: true
    },
    user0: {
      type: Object,
      required: true
    },
    team0: {
      type: Object,
      required: false,
      default: null
    },
    team_members0: {
      type: Array,
      required: false,
      default: null
    },
    other_org_members0: {
      type: Array,
      required: false,
      default: null
    }
  },
  data () {
    return {
      showFilter: false,
      members_table_fields: {
        leader: {},
        name: {sortable:true},
        email: {},
        action: {class: ''}
      },
      ready: false,
      errors: {},
      isAddingMember: false,
      new_member: null,
      team_id: '',
      team_name: '',
      team_description: '',
      table_items: [],
      members: [],
      other_org_members: []
    }
  },
  mounted: function () {
    this.team_id = this.team0.id;
    this.team_name = this.team0.name;
    this.team_description = this.team0.description;
    this.members = this.team_members0;
    this.table_items = this.team_members0;
    this.other_org_members = this.other_org_members0;
    this.setMode(this.mode0);
    if (!this.modeEdit) {
      this.members_table_fields.action.class = 'd-none'
    }

    this.$nextTick(function () {  // Code that will run only after the entire view has been rendered
      this.ready = true;
    })
  },
  updated: function() {
    // console.log('dom updated')
  },
  computed: {

  },
  watch: {
    // newPasswordConfirm () {
    //   console.log(this.newPasswordConfirm);
    // }
  },
  methods: {
    // filter_column(colname, value) {
    //   console.log('parent', colname, value);
    //   // this.table_items = this.members.filter(x => )
    // },
    remove_by_email(array, email) {
      return array.filter(e=> e.email != email);
    },
    toggleIsAddingMember () {
      this.isAddingMember = !this.isAddingMember;
      this.new_member = null;
    },
    saveNewMember: function() {
      this.isAddingMember = false;
      axios({
        method: 'post',
        url: '/api/organization/team/member',
        data: {
          auth_user_id: this.user0.id,
          team_id: this.team_id,
          user_id: this.new_member.id
        }
      })
      .then(  (response) => {
        this.members.push(this.new_member)
        this.other_org_members =
            this.remove_by_email(this.other_org_members, this.new_member.email);
      }).catch((error) => {
        this.setStatusFailed();
        var self = this;
        setTimeout(function(){
            self.setStatusInitial();
        }, MESSAGE_DURATION + 1000);
      });
    },
    removeMember2 (index) {
      let member = this.members[index];
      let message = '<i>Delete <span class="text-danger"><b>' + member.name
                  + ' </b></span> from the team?</i>';
      this.$dialog.confirm(message, {
        // loader: false,
        // animation: 'zoom'
      })
      .then( (dialog)=> {
        axios({
          method: 'delete',
          url: '/api/organization/team/member',
          data: {
            auth_user_id: this.user0.id,
            team_id: this.team_id,
            user_id: this.members[index].id
          }
        })
        .then(  (response) => {
          this.other_org_members.push(this.members[index])
          this.members = this.remove_by_email(this.members, this.members[index].email);
          // console.log('Delete action completed ');
          dialog.close();
        }).catch((error) => {
          dialog.close();
          this.setStatusFailed();
          var self = this;
          setTimeout(function(){
              self.setStatusInitial();
          }, MESSAGE_DURATION + 1000);
        });
      })
      .catch( ()=> {
          //console.log('Clicked on cancel')
      });
    },
    updateLeader (method, index) {
      //method = post = make user a Leader
      //method = delete = make user a Member
      axios({
        method: method,
        url: '/api/organization/team/lead',
        data: {
          auth_user_id: this.user0.id,
          team_id: this.team_id,
          user_id: this.members[index].id
        }
      })
      .then(  (response) => {
        // console.log(response)
        if (method === 'post') {
          this.members[index].role="Lead"
        } else {
          this.members[index].role="Member"
        }
      }).catch((error) => {
        // console.log(error.response)
        this.setStatusFailed();
        var self = this;
        setTimeout(function(){
            self.setStatusInitial();
        }, MESSAGE_DURATION + 1000);
      });
    },
    saveTeam () {
      axios({
        method: 'put',
        url: '/api/organization/team',
        data: {
          auth_user_id: this.user0.id,
          team_id: this.team_id,
          team_name: this.team_name,
          team_description: this.team_description
        }
      })
      .then(  (response) => {
        // console.log(response)
        this.setStatusSuccess();
        var self = this;
        setTimeout(function(){
            self.setStatusInitial();
        }, MESSAGE_DURATION);
      }).catch((error) => {
        // console.log(error.response)

        this.setStatusFailed();
        var self = this;
        setTimeout(function(){
            self.setStatusInitial();
        }, MESSAGE_DURATION + 1000);
      });
    }
  } //End of methods
} //End of export
</script>

<style lang="css" scoped>
.list-item {
}
.list-enter-active {
  transition: all 5s;
}
.list-enter {
  background: yellow;
}

.alert {
  padding: 0px;
}
.bgInherit {
  background-color: inherit !important;
}
.btn-pref .btn {
    -webkit-border-radius:0 !important;
}
.caption {
  font-style: italic;
  font-size: 16px;
  font-weight: 900;
}
</style>
