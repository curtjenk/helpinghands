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
              <div class="col-md-5 col-sm-5">
                <select v-model="new_member">
                  <option disabled value="">Please select one</option>
                  <option v-for="oom in other_org_members" v-bind:value="oom">
                    {{ oom.name }} &nbsp;< {{oom.email}} >
                 </option>
                </select>
              </div>
              <div class="col-md-3 col-sm-3">
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
        <table class="table table-responsive table-striped table-condensed">
          <thead>
            <tr>
              <th v-if="modeEdit" >Leader</th>
              <th>Name</th>
              <th>Email</th>
              <th v-if="modeEdit" >Action</th>
            </tr>
          </thead>
          <tbody  is="transition-group" v-bind:name="ready ? 'list' : null">
            <tr v-for="member in members" v-bind:key="member.id" class="list-item">
              <td v-if="modeEdit">
                <span v-if="member.role=='Lead'" v-tooltip.right="'Remove as Leader'">
                      <a href="#" type="button" class="text-primary"
                        @click="removeLeader(member)">
                        <i class="fa fa-check-square-o fa-fw"></i>
                      </a>
                </span>
                <span v-else v-tooltip.right="'Make Leader'">
                  <a href="#" type="button" class=""
                    @click="makeLeader(member)">
                    <i class="fa fa-square-o fa-fw"></i>
                  </a>
                </span>
              </td>
              <td>{{ member.name }}</td>
              <td>{{ member.email }}</td>
              <td>
                <span v-tooltip.right="'Remove'" v-if="modeEdit" >
                    <a href="#" type="button" class="text-danger"
                      @click="removeMember(member)">
                      <i class="fa fa-trash-o fa-fw"></i>
                    </a>
                </span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

    </div>
  </div>
</template>

<script>

import {commonMixins} from '../../../mixins/common';
import {MESSAGE_DURATION} from '../../../mixins/constants';
import FormError from '../../FormError';

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
    // toggleIsAddingAdmin () {
    //   this.isAddingAdmin = !this.isAddingAdmin
    //   this.new_admin = null
    // },
    toggleIsAddingMember () {
      this.isAddingMember = !this.isAddingMember;
      this.new_member = null;
    },
    removeMember (member) {
      let message = '<i>Delete <span class="text-danger"><b>' + member.name
                  + ' </b></span> from the team?</i>';
      this.$dialog.confirm(message, {
        // loader: false,
        // animation: 'zoom'
      })
      .then( (dialog)=> {
          //console.log('Clicked on proceed')
          //1 post to backend controller.  If successful
          //TODO controller method and axios call
          // close dialog: setTimeout is temporary
          setTimeout(() => {
            //2 change role (incase the Lead was deleted) and add to the "all members" list
            member.role = 'Member'
            this.other_org_members.push(member)
            //3 remove member from members list
            this.members = this.remove_by_email(this.members, member.email);
            console.log('Delete action completed ');
            dialog.close();
          }, 1000);
      })
      .catch( ()=> {
          //console.log('Clicked on cancel')
      });
    },
    makeLeader (member) {
      //1 post to backend controller.  If successful
      //TODO controller method and axios call

      //2 set role
      member.role="Lead"

    },
    removeLeader (member) {
      let message = '<i>Remove <span class="text-danger"><b>' + member.name
                  + '\'s </b></span> team leader privileges?</i>';
      this.$dialog.confirm(message, {
        // loader: false,
        // animation: 'zoom'
      })
      .then( (dialog)=> {
          //console.log('Clicked on proceed')
          //1 post to backend controller.  If successful
          //TODO controller method and axios call
          // close dialog: setTimeout is temporary
          setTimeout(() => {
            //2 add to this.members
            member.role="Member"
            //3 remove from this.administrators

            dialog.close();
          }, 1000);
      })
      .catch( ()=> {
          //console.log('Clicked on cancel')
      });

    },
    saveNewMember: function() {
      this.isAddingMember = false;
      //1 post to backend controller.  If successful
      //TODO controller method and axios call

      //2 add to this.members
      this.members.push(this.new_member)
      //3 remove from this.other_org_members

      this.other_org_members =
        this.remove_by_email(this.other_org_members, this.new_member.email);
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
    },
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
