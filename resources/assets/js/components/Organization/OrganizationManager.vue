<template>
  <div class="">
    <div class="row">
      <span v-if="modeShow">
        <div class="form-horizontal col-md-8 col-sm-8">
          <div class="form-group">
              <label for="name" class="col-md-3 col-sm-3 control-label">Name</label>
              <div class="col-md-6 col-sm-6">
                <p id="name" class="form-control-static">{{ org_name }}</p>
              </div>
          </div>
          <div class="form-group">
              <label for="phone" class="col-md-3 col-sm-3 control-label">Phone</label>
              <div class="col-md-6 col-sm-6">
                <p id="phone" class="form-control-static">{{ formatPhoneNumber(org_phone,'(XXX) XXX-XXXX') }}</p>
              </div>
          </div>
          <div class="form-group">
              <label for="address1" class="col-md-3 col-sm-3 control-label">Address 1</label>
              <div class="col-md-6 col-sm-6">
                <p id="address1" class="form-control-static">{{ org_address1 }}</p>
              </div>
          </div>
          <div class="form-group">
              <label for="address2" class="col-md-3 col-sm-3 control-label">Address 2</label>
              <div class="col-md-6 col-sm-6">
                    <p id="address2" class="form-control-static">{{ org_address2 }}</p>
              </div>
          </div>
          <div class="form-group">
              <label for="city" class="col-md-3 col-sm-3 control-label">City</label>
              <div class="col-md-6 col-sm-6">
                  <p id="city" class="form-control-static">{{ org_city }}</p>
              </div>
          </div>
          <div class="form-group">
            <label for="state" class="col-md-3 col-sm-3 control-label">State Code</label>
            <div class="col-md-2 col-sm-2">
              <p id="state" class="form-control-static">{{ org_state }}</p>
            </div>
          </div>
          <div class="form-group">
            <label for="zip" class="col-md-3 col-sm-3 control-label">Zip Code</label>
            <div class="col-md-2 col-sm-2">
              <p id="zip" class="form-control-static">{{ org_zip }}</p>
            </div>
          </div>
        </div>
      </span>
      <span v-else>
        <div class="form-horizontal col-md-8 col-sm-8">
          <div class="col-md-offset-2 col-md-8 text-center">
            <div class="alert alert-success" v-if="statusSuccess" transition="expand">Organization information was saved/updated.</div>
            <div class="alert alert-danger" v-if="statusFailed" transition="expand">
                <span>Sorry, unable to save/update changes</span>
            </div>
          </div>
          <div class="form-group">
              <label for="name" class="col-md-3 col-sm-3 control-label">Name</label>
              <div class="col-md-6 col-sm-6">
                  <input required id="name" v-model="org_name" type="text"
                      name="name" autofocus class="editInfo" maxlength="255">
              </div>
          </div>
          <div class="form-group">
              <label for="phone" class="col-md-3 col-sm-3 control-label">Phone</label>
              <div class="col-md-6 col-sm-6">
                <input id="phone" v-model="org_phone" type="tel" v-mask="'(###) ###-####'"
                  name="phone" class="editInfo">
              </div>
          </div>
          <div class="form-group" :class="{ 'has-error' : errors.address1 } ">
              <label for="address1" class="col-md-3 col-sm-3 control-label">Address 1</label>
              <div class="col-md-6 col-sm-6">
                  <input id="address1" v-model="org_address1" type="text"
                      name="address1" class="editInfo" maxlength="255">
                  <form-error v-if="errors.address1" >
                      <div v-for="msg in errors.address1">
                          {{ msg }}
                      </div>
                  </form-error>
              </div>
          </div>
          <div class="form-group">
              <label for="address2" class="col-md-3 col-sm-3 control-label">Address 2</label>
              <div class="col-md-6 col-sm-6">
                  <input id="address2" v-model="org_address2" type="text"
                      name="address2" class="editInfo" maxlength="255">
              </div>
          </div>
          <div class="form-group">
              <label for="city" class="col-md-3 col-sm-3 control-label">City</label>
              <div class="col-md-6 col-sm-6">
                  <input id="city" v-model="org_city" type="text"
                      name="city" class="editInfo" maxlength="255">
              </div>
          </div>
          <div class="form-group">
            <label for="state" class="col-md-3 col-sm-3 control-label">State Code</label>
            <div class="col-md-2 col-sm-2">
              <input id="state" v-model="org_state" type="text"
                    name="state" class="" maxlength="255">
            </div>
          </div>
          <div class="form-group" :class="{ 'has-error' : errors.zipcode } ">
            <label for="zip" class="col-md-3 col-sm-3 control-label">Zip Code</label>
            <div class="col-md-6 col-sm-6">
                <input id="zip" v-model="org_zip" type="text"
                    name="zip" class="" maxlength="10" size="10">
              <form-error v-if="errors.zipcode" :errors="errors">
                  <div v-for="msg in errors.zipcode">
                      {{ msg }}
                  </div>
              </form-error>
            </div>
          </div>
          <div class="text-center">
            <button v-if="modeCreate" type="submit" class="btn btn-primary" name="submit" @click="saveOrganization">
                <i class="fa fa-btn fa-check"></i> Save Organization
            </button>
            <button v-if="modeEdit" type="submit" class="btn btn-primary" name="submit" @click="saveOrganization">
                <i class="fa fa-btn fa-check"></i> Update Organization
            </button>
          </div>
        </div>
      </span>
      <div class="form-horizontal col-md-4 col-sm-4">
        <div class="caption">
          <span>Administrator(s)</span>&nbsp;&nbsp;&nbsp;
          <span v-if="members && members.length>0 && !isAddingAdmin && modeEdit"
              v-tooltip.right="'Add Administrator'">
            <a  href="#" type="button" class="text-success"
              @click="toggleIsAddingAdmin()">
              <i class="fa fa-plus fa-lg fa-fw text-success"></i>
            </a>
          </span>
        </div>
        <div v-if="isAddingAdmin" class="panel panel-default">
          <div class="form-group row panel-body">
              <div class="col-md-7 col-sm-7">
                <select v-model="new_admin">
                  <option disabled value="">Please select one</option>
                  <option v-for="member in members" v-bind:value="member">
                    {{ member.name }}
                 </option>
                </select>
              </div>
              <div class="col-md-4 col-sm-4">
                <span v-tooltip.top="'Save'">
                    <a href="#" type="button" class="text-primary"
                      @click="saveNewAdmin()">
                      <i class="fa fa-floppy-o fa-lg fa-fw"></i>
                    </a>
                </span>
                <span v-tooltip.top="'Cancel'">
                    <a href="#" type="button" class="text-danger"
                      @click="toggleIsAddingAdmin()">
                      <i class="fa fa-ban fa-lg fa-fw"></i>
                    </a>
                </span>
              </div>
          </div>
        </div>
        <table  class="table table-responsive table-striped table-condensed">
        <tbody is="transition-group" v-bind:name="ready ? 'list' : null">
          <tr v-for="admin in administrators" v-bind:key="admin.user_id" class="list-item">
            <td>
              {{ admin.name }}
            </td>
            <td v-if="modeEdit">
              <span v-tooltip.right="'Remove'" class="">
                  <a href="#" type="button" class="text-danger"
                        @click="removeAdmin(admin)">
                    <i class="fa fa-trash-o fa-fw"></i>
                  </a>
              </span>
            </td>
          </tr>
        </tbody>
      </table>
      </div>
    </div>
    <hr/>
    <div class="row">
      <div class="form-horizontal col-md-offset-1 col-sm-offset-1 col-md-10 col-sm-10">
        <div class="caption">
          <span>Team(s)</span>&nbsp;&nbsp;&nbsp;
          <span v-if="!isAddingTeam && modeEdit" v-tooltip.right="'Add Team'">
              <a href="#" type="button" class="text-success"
                @click="toggleIsAddingTeam()">
                <i class="fa fa-plus fa-lg fa-fw text-success"></i>
              </a>
          </span>
        </div>
        <div v-if="isAddingTeam" class="panel panel-default">
          <div class="form-group row panel-body">
            <div class="">
              <div class="col-md-4 col-sm-4">
                <float-label>
                  <input id="ntn" v-model="new_team_name" type="text" required
                    class="editInfo" size="100" maxlength="255" placeholder="Name"/>
                </float-label>
              </div>
              <div class="col-md-6 col-sm-6">
                <float-label>
                  <input id="ntd" v-model="new_team_description" type="text" required
                    class="editInfo" maxlength="255" placeholder="Description"/>
                </float-label>
              </div>
              <div class="col-md-1 col-sm-2" style="padding: 0px;">
                <span v-tooltip.top="'Save'"class="">
                    <a href="#" type="button" class="text-primary"
                      @click="saveNewTeam()">
                      <i class="fa fa-floppy-o fa-lg fa-fw"></i>
                    </a>
                </span>
                <span v-tooltip.top="'Cancel'">
                    <a href="#" type="button" class="text-danger"
                      @click="toggleIsAddingTeam()">
                      <i class="fa fa-ban fa-lg fa-fw"></i>
                    </a>
                </span>
              </div>
            </div>
          </div>
        </div>
        <table class="table table-responsive table-striped table-condensed">
          <thead>
            <tr>
              <th>Name</th>
              <th>Description</th>
              <th v-if="modeEdit" >Action</th>
            </tr>
          </thead>
          <tbody  is="transition-group" v-bind:name="ready ? 'list' : null">
            <tr v-for="team in teams" v-bind:key="team.id" class="list-item">
              <td>{{ team.name }}</td>
              <td>{{ team.description }}</td>
              <td>
                <span v-tooltip.right="'Remove'" v-if="modeEdit" >
                    <a href="#" type="button" class="text-danger"
                      @click="removeTeam(team)">
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
import {TheMask} from 'vue-the-mask';
import {commonMixins} from '../../mixins/common';
import {MESSAGE_DURATION} from '../../mixins/constants';
import FormError from '../FormError';

export default {
  mixins: [commonMixins],
  components: {
    TheMask, FormError
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
    orgteams0: {
      type: Object,
      required: false,
      default: null
    },
    members0: {
      type: Array,
      required: false,
      default: null
    }
  },
  data () {
    return {
      ready: false,
      errors: {},
      // tip_admin: "Add Administrator",
      isAddingAdmin: false,
      isAddingTeam: false,
      new_admin: null,
      new_team_name: '',
      new_team_description: '',
      org_id: '',
      org_name: '',
      org_address1: '',
      org_address2: '',
      org_phone: '',
      org_city: '',
      org_state: '',
      org_zip: '',
      administrators: [],
      members: [],
      teams: []
    }
  },
  mounted: function () {
    // console.log(MODES)
    //console.log(this.mode0)
    // console.log(MODES[this.mode0])
    this.setMode(this.mode0);
    if (this.orgteams0 != null) {
      this.org_id = this.orgteams0.id
      this.org_name = this.orgteams0.name
      this.org_phone = this.orgteams0.phone
      this.org_address1 = this.orgteams0.address1
      this.org_address2 = this.orgteams0.address2
      this.org_city = this.orgteams0.city
      this.org_state = this.orgteams0.state
      this.org_zip = this.orgteams0.zipcode
      if (this.orgteams0.teams.length > 0) {
        this.teams = this.orgteams0.teams.map(function(k) {
          return {
            id: k.id,
            organization_id: k.organization_id,
            name: k.name,
            description: k.description
          };
        })
      }
    }
    if (this.members0 != null) {
      this.administrators = this.members0.filter( function(k) {
        return k.role_name == 'Admin';
      })
      this.members = this.members0.filter( function(k) {
        return k.role_name != 'Admin';
      })
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
    remove_by_name(array, name) {
      return array.filter(e=> e.name != name);
    },
    toggleIsAddingAdmin () {
      this.isAddingAdmin = !this.isAddingAdmin
      this.new_admin = null
    },
    toggleIsAddingTeam () {
      this.isAddingTeam = !this.isAddingTeam
      this.new_team_name = ''
      this.new_team_description = ''
    },
    removeAdmin (admin) {
      let message = '<i>Remove <span class="text-danger"><b>' + admin.name
                  + '\'s </b></span> administrator privileges?</i>';
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
            this.members.push(admin)
            //3 remove from this.administrators
            this.administrators = this.remove_by_name(this.administrators, admin.name);
            console.log('Delete action completed ');
            dialog.close();
          }, 2000);
      })
      .catch( ()=> {
          //console.log('Clicked on cancel')
      });

    },
    saveNewAdmin: function() {
      if (this.new_admin == null) {
        return;
      }
      console.log("new_admin",this.new_admin)
      this.isAddingAdmin = false;
      //1 post to backend controller.  If successful
      //TODO controller method and axios call

      //2 add to this.administrators
      this.administrators.push(this.new_admin)
      //3 remove from this.members

      this.members = this.remove_by_name(this.members, this.new_admin.name);
    },
    removeTeam (team) {
      //1 post to backend controller.  If successful
      //TODO controller method and axios call
      let message = '<i>Team <span class="text-danger"><b>' + team.name
                  + '</b></span> will be permanently deleted!</i>';
      this.$dialog.confirm(message, {})
      .then( (dialog)=> {
          console.log('Clicked on proceed')
          //1 post to backend controller.  If successful
          //TODO controller method and axios call
          // close dialog: setTimeout is temporary
          setTimeout(() => {
            //2 remove team from list
            this.teams = this.remove_by_name(this.teams, team.name);
            console.log('Delete action completed ');
            dialog.close();
          }, 2000);
      })
      .catch( ()=> {
          console.log('Clicked on cancel')
      });
    },
    saveNewTeam: function() {
      this.new_team_name = this.new_team_name.trim();
      this.new_team_description = this.new_team_description.trim();
      if (this.new_team_name == '' || this.new_team_description == '') {
        return;
      }

      this.isAddingTeam = false;
      //1 post to backend controller.  If successful
      //TODO controller method and axios call

      //2 add to this.teams
      let team =  {
        id: 0,   //need id from axios response
        organization_id: this.org_id,
        name: this.new_team_name,
        description: this.new_team_description
      };

      this.teams.push(team)

    },
    saveOrganization() {
      let url = '/api/organization';
      let method = 'post';
      if (this.modeEdit) {
        method = 'put';
        url += '/'+this.org_id;
      }
      axios({
        method: method,
        url: url,
        data: {
          user_id: this.user0.id,
          name: this.org_name,
          phone: this.org_phone,
          address1: this.org_address1,
          address2: this.org_address2,
          city: this.org_city,
          state: this.org_state,
          zipcode: this.org_zip
        }
      }).then( (response) => {
        // console.log(response)
        // clear previous form errors
        this.errors = {}
        this.setStatusSuccess();
        this.setModeEdit;
        this.org_id = response.data.id;
        let self = this;
        setTimeout(function(){
            self.setStatusInitial();

        }, MESSAGE_DURATION);

      }).catch( (error) => {
        this.errors = error.response.data.errors

        this.setStatusFailed();
        let self = this;
        setTimeout(function(){
            self.setStatusInitial();
        }, MESSAGE_DURATION + 2000);
      });
    },
    // updateEmail() {
    //   this.credential = 'Email';
    //   var url = '/api/member/' + this.user.id + '/email';
    //   axios.put(url, {newEmail: this.newEmail})
    //   .then(  (response) => {
    //     // console.log(response)
    //     this.user.email = this.newEmail;
    //     this.newEmail = '';
    //     this.updateStatus = STATUS_SUCCESS;
    //     var self = this;
    //     setTimeout(function(){
    //         self.updateStatus = STATUS_INITIAL;
    //     }, MESSAGE_DURATION);
    //   }).catch((error) => {
    //     // console.log(error.response)
    //     if (error.response.data == 'unavailable') {
    //       this.credentialMessage = 'email already in use.  Try another email';
    //     } else {
    //       this.credentialMessage = 'unable to change your email. Try later';
    //     }
    //     this.updateStatus = STATUS_FAILED;
    //
    //     var self = this;
    //     setTimeout(function(){
    //         self.updateStatus = STATUS_INITIAL;
    //     }, MESSAGE_DURATION + 1000);
    //   });
    // },
    // updatePassword() {
    //   this.credential = 'Password';
    //   var url = '/api/member/' + this.user.id + '/password';
    //   axios.put(url, {
    //     oldPassword: this.oldPassword,
    //     newPassword: this.newPassword,
    //     newPasswordConfirm: this.newPasswordConfirm,
    //     })
    //   .then(  (response) => {
    //     console.log(response)
    //     this.updateStatus = STATUS_SUCCESS;
    //     var self = this;
    //     setTimeout(function(){
    //         self.updateStatus = STATUS_INITIAL;
    //     }, MESSAGE_DURATION);
    //   }).catch((error) => {
    //     console.log(error.response)
    //     if (error.response.data == 'verify') {
    //       this.credentialMessage = 'please verify your input';
    //     } else {
    //       this.credentialMessage = 'unable to change your password. Try later';
    //     }
    //     this.updateStatus = STATUS_FAILED;
    //     var self = this;
    //     setTimeout(function(){
    //         self.updateStatus = STATUS_INITIAL;
    //     }, MESSAGE_DURATION + 1000);
    //   });
    // },


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
