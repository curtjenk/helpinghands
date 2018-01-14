<template>
  <div>
    <div class="row">
      <span v-if="modeShow">
        <div class="form-horizontal col-md-8 col-sm-8">
          <div class="form-group">
              <label for="name" class="col-md-3 col-sm-3 control-label">Name</label>
              <div class="col-md-6 col-sm-6">
                <p id="name" class="form-control-static">{{ team_name }}</p>
              </div>
          </div>
          <div class="form-group">
              <label for="description" class="col-md-3 col-sm-3 control-label">Description</label>
              <div class="col-md-6 col-sm-6">
                <p id="phone" class="form-control-static">{{ team_description }}</p>
              </div>
          </div>
        </div>
      </span>
      <span v-else>
        <div class="form-horizontal col-md-8 col-sm-8">
          <div class="col-md-offset-2 col-md-8 text-center">
            <div class="alert alert-success" v-if="statusSuccess" transition="expand">Team information was saved/updated.</div>
            <div class="alert alert-danger" v-if="statusFailed" transition="expand">
                <span>Sorry, unable to save your change(s)</span>
            </div>
          </div>
          <div class="form-group">
              <label for="name" class="col-md-3 col-sm-3 control-label">Name</label>
              <div class="col-md-6 col-sm-6">
                  <input required id="name" v-model="team_name" type="text"
                      name="name" autofocus class="editInfo" maxlength="255">
              </div>
          </div>
          <div class="form-group">
              <label for="description" class="col-md-3 col-sm-3 control-label">Description</label>
              <div class="col-md-6 col-sm-6">
                <textarea id="description" v-model="team_description" name="description" rows="5" class="editTextArea">
                </textarea>
              </div>
          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-primary" name="submit" @click="saveTeam">
                <i class="fa fa-btn fa-check"></i> Save Team
            </button>
          </div>
        </div>
      </span>
    </div>
    <hr/>
    <div class="row">
      <div class="form-horizontal col-md-offset-1 col-sm-offset-1 col-md-10 col-sm-10">
        <div class="caption">
          <span>Team Members</span>&nbsp;&nbsp;&nbsp;
          <span v-if="other_org_members && other_org_members.length>0 && !isAddingMember && modeEdit"
              v-tooltip.right="'Add Team Member'">
            <a  href="#" type="button" class="text-success"
              @click="toggleIsAddingMember()">
              <i class="fa fa-plus fa-lg fa-fw text-success"></i>
            </a>
          </span>
        </div>
        <div v-if="isAddingMember" class="panel panel-default">
          <div class="form-group row panel-body">
            <div class="col-md-8 col-sm-8">
              <select v-model="new_member">
                <option disabled value="">Please select one</option>
                <option v-for="oom in other_org_members" v-bind:value="oom">
                  {{ oom.name }} &nbsp;< {{oom.email}} >
               </option>
              </select>
              &nbsp;&nbsp;
              <span v-tooltip.top="'Save'">
                  <a href="#" type="button" class="text-primary"
                    @click="saveNewMember()">
                    <i class="fa fa-floppy-o fa-lg fa-fw"></i>
                  </a>
              </span>
              <span v-tooltip.top="'Cancel'">
                  <a href="#" type="button" class="text-danger"
                    @click="toggleIsAddingMember()">
                    <i class="fa fa-ban fa-lg fa-fw"></i>
                  </a>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="form-horizontal col-md-offset-1 col-sm-offset-1 col-md-10 col-sm-10">
        <vue-good-table v-show="ready"
            :columns="gColumns"
            :rows="members"
            :paginate="true"
            :perPage="10"
            :lineNumbers="false"
            styleClass="table condensed table-striped">
          <div slot="emptystate" class="text-center">
            No members on this team
          </div>
          <template slot="table-row-before" slot-scope="props" v-if="modeEdit">
            <td>
              <span v-if="props.row.role=='Lead'" v-tooltip.right="'Remove as Leader'">
                    <a href="#" type="button" class="text-primary"
                      @click="updateLeader('delete', props.index)">
                      <i class="fa fa-check-square-o fa-fw"></i>
                    </a>
              </span>
              <span v-else v-tooltip.right="'Make Leader'">
                <a href="#" type="button" class=""
                  @click="updateLeader('post', props.index)">
                  <i class="fa fa-square-o fa-fw"></i>
                </a>
              </span>
            </td>
          </template>
          <!-- all the regular row items will be populated here-->
          <template slot="table-row-after" slot-scope="props" v-if="modeEdit">
            <td>
              <a href="#" type="button" class="text-danger"
                @click="removeMember2(props.index)">
                <i class="fa fa-trash-o fa-fw"></i>
              </a>
            </td>
            <!-- <td><button @click="doSomething(props.index)">show</button></td> -->
          </template>
        </vue-good-table>
      </div>
    </div>
  </div>
</template>

<script>

import {commonMixins} from '../../../mixins/common';
import {MESSAGE_DURATION} from '../../../mixins/constants';
import FormError from '../../FormError';

import VueGoodTable from 'vue-good-table';

Vue.use(VueGoodTable);

export default {
  mixins: [commonMixins],
  components: {
    FormError
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
      gColumns: [
        {
          label: 'Leader',
          hidden: true
        },
        {
          label: 'Name',
          field: 'name',
          filterable: true,
        },
        {
          label: 'Email',
          field: 'email',
          filterable: true,
        },
        {
          label: 'Actions',
          hidden: true
        }
      ],
      ready: false,
      errors: {},
      isAddingMember: false,
      new_member: null,
      team_id: '',
      team_name: '',
      team_description: '',
      members: [],
      other_org_members: []
    }
  },
  mounted: function () {
    this.team_id = this.team0.id;
    this.team_name = this.team0.name;
    this.team_description = this.team0.description;
    this.members = this.team_members0;
    this.other_org_members = this.other_org_members0;
    this.setMode(this.mode0);
    this.gColumns[0].hidden = this.modeShow;    //Leader column
    this.gColumns[3].hidden = this.modeShow;    //Actions column
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
          console.log('Delete action completed ');
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
