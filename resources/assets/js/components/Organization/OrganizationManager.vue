<template>
<div class="container">
  <div class="row">
    <b-col sm="8">
      <template v-if="modeShow">
          <b-row class="no-gutters">
            <b-col sm="3">Name</b-col>
            <b-col sm="6" class="font-weight-bold">{{ org_name }}</b-col>
          </b-row>
          <b-row class="no-gutters mt-2">
            <b-col sm="3">Phone</b-col>
            <b-col sm="6" class="font-weight-bold">{{ formatPhoneNumber(org_phone,'(XXX) XXX-XXXX') }}</b-col>
          </b-row>
          <b-row class="no-gutters mt-2">
            <b-col sm="3">Address 1</b-col>
            <b-col sm="6" class="font-weight-bold">{{ org_address1 }}</b-col>
          </b-row>
          <b-row class="no-gutters mt-2">
            <b-col sm="3">Address 2</b-col>
            <b-col sm="6" class="font-weight-bold">{{ org_address2 }}</b-col>
          </b-row>
          <b-row class="no-gutters mt-2">
            <b-col sm="3">City</b-col>
            <b-col sm="6" class="font-weight-bold">{{ org_city }}</b-col>
          </b-row>
          <b-row class="no-gutters mt-2">
            <b-col sm="3">State</b-col>
            <b-col sm="6" class="font-weight-bold">{{ org_state }}</b-col>
          </b-row>
          <b-row class="no-gutters mt-2">
            <b-col sm="3">Zip Code</b-col>
            <b-col sm="6" class="font-weight-bold">{{ org_zip }}</b-col>
          </b-row>
      </template>
      <template v-else>
          <div class="offset-md-2 col-md-8 text-center">
            <div class="alert alert-success" v-if="statusSuccess" transition="expand">Organization information was saved/updated.</div>
            <div class="alert alert-danger" v-if="statusFailed" transition="expand">
                <span>Sorry, unable to save your change(s)</span>
            </div>
          </div>
          <b-row class="no-gutters">
            <b-col sm="3">Name</b-col>
            <b-col sm="6" md="6">
              <b-form-input  required id="name" v-model="org_name" type="text" name="name" autofocus>
              </b-form-input>
            </b-col>
          </b-row>
          <b-row class="no-gutters">
            <b-col sm="3">Phone</b-col>
            <b-col sm="6" md="6">
              <masked-input id="phone" name="phone" type="tel" class="form-control"
                  v-model="org_phone"
                  :mask="['(', /[1-9]/, /\d/, /\d/, ')', ' ', /\d/, /\d/, /\d/, '-', /\d/, /\d/, /\d/, /\d/]">
              </masked-input>
            </b-col>
          </b-row>
          <b-row class="no-gutters">
            <b-col sm="3">Address 1</b-col>
            <b-col sm="6" md="6">
              <b-form-input id="address1" v-model="org_address1" type="text" name="address1" :state="addr1Error">
                <b-form-invalid-feedback>
                  <div v-for="msg in errors.address1">
                      {{ msg }}
                  </div>
                </b-form-invalid-feedback>
              </b-form-input>
            </b-col>
          </b-row>
          <b-row class="no-gutters">
            <b-col sm="3">Address 2</b-col>
            <b-col sm="6" md="6">
              <b-form-input id="address2" v-model="org_address2" type="text" name="address2">
              </b-form-input>
            </b-col>
          </b-row>
          <b-row class="no-gutters">
            <b-col sm="3">City</b-col>
            <b-col sm="6" md="6">
              <b-form-input id="city" v-model="org_city" type="text" name="city">
              </b-form-input>
            </b-col>
          </b-row>
          <b-row class="no-gutters">
            <b-col sm="3">State</b-col>
            <b-col sm="6" md="6">
              <b-form-input id="state" v-model="org_state" type="text" name="state">
              </b-form-input>
            </b-col>
          </b-row>
          <b-row class="no-gutters">
            <b-col sm="3">Zip</b-col>
            <b-col sm="6" md="6">
              <b-form-input id="zip" v-model="org_zip" type="text" name="zip" :state="zipError">
                <b-form-invalid-feedback>
                  <div v-for="msg in errors.zipcode">
                      {{ msg }}
                  </div>
                </b-form-invalid-feedback>
              </b-form-input>
            </b-col>
          </b-row>
      </template>
    </b-col>
    <b-col sm="4">
      <div class="caption">
        <span>Administrator(s)</span>&nbsp;&nbsp;&nbsp;
        <template v-if="!isAddingAdmin  && modeEdit">
          <span v-if="members && members.length>0" v-tooltip.right="'Add Administrator'">
            <a  href="#" class="text-success"
              @click="toggleIsAddingAdmin()">
              <i class="fa fa-users fa-lg fa-fw text-success"></i>
            </a>
          </span>
          <span v-else v-tooltip.right="'No Members To Make Administrators'">
            <i class="fa fa-users fa-lg fa-fw text-danger"></i>
          </span>
        </template>
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
                  <a href="#" class="text-primary"
                    @click="saveNewAdmin()">
                    <i class="fa fa-floppy-o fa-lg fa-fw"></i>
                  </a>
              </span>
              <span v-tooltip.top="'Cancel'">
                  <a href="#" class="text-danger"
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
    </b-col>
  </div>
  <b-row>
    <div class="mx-auto mt-4">
      <button v-if="modeCreate" type="submit" class="btn btn-primary" name="submit" @click="saveOrganization">
          <i class="fa fa-btn fa-check"></i> Save Organization
      </button>
      <button v-if="modeEdit" type="submit" class="btn btn-primary" name="submit" @click="saveOrganization">
          <i class="fa fa-btn fa-check"></i> Update Organization
      </button>
    </div>
  </b-row>
  <hr/>
  <b-row>
    <div class="caption">Team(s)&nbsp;&nbsp;&nbsp;
      <span v-if="!isAddingTeam && modeEdit" v-tooltip.right="'Add Team'">
          <a href="#" class="text-success" @click="toggleIsAddingTeam()">
            <i class="fa fa-sitemap fa-lg fa-fw text-success"></i>
          </a>
      </span>
    </div>
    <template v-if="isAddingTeam">
      <b-card no-body style="min-width: 100%;">
        <b-card-body>
          <b-row class="no-gutters">
            <b-col sm="6" md="6">
              <float-label>
                <b-form-input id="ntn" required v-model="new_team_name" :state="teamNameError" type="text" placeholder="Name">
                  <b-form-invalid-feedback>
                    {{ errors.new_team_name }}
                  </b-form-invalid-feedback>
                </b-form-input>
              </float-label>
            </b-col>
            <b-col class="ml-1">
              <a id="saveNew" href="#" class="text-primary" @click="saveNewTeam()">
                <i class="fa fa-floppy-o fa-lg fa-fw"></i>
              </a>
              <a id="cancelNew" href="#" class="text-danger" @click="toggleIsAddingTeam()">
                <i class="fa fa-ban fa-lg fa-fw"></i>
              </a>
              <b-tooltip target="saveNew" title="Save" placement="top"></b-tooltip>
              <b-tooltip target="cancelNew" title="Cancel" placement="top"></b-tooltip>
            </b-col>
          </b-row>
          <b-row class="no-gutters mt-2">
            <b-col sm="12" md="12">
              <float-label>
                <b-form-input id="ntn" required v-model="new_team_description" :state="teamDescriptionError" type="text" placeholder="Description">
                  <b-form-invalid-feedback>
                    {{ errors.new_team_description }}
                  </b-form-invalid-feedback>
                </b-form-input>
              </float-label>
            </b-col>
          </b-row>
        </b-card-body>
      </b-card>
    </template>
    <b-table striped small bordered hover :items="teams" :fields="team_table_fields">
      <template v-if="modeEdit" slot="action" slot-scope="row">
        <a :id="'tbledit_' + row.item.id" href="#" class="" @click.stop="editTeam(row.item)">
          <i class="fa fa-pencil-square-o fa-fw"></i>
        </a>
        <a :id="'tbldel_' + row.item.id" href="#" class="text-danger" @click.stop="removeTeam(row.item)">
          <i class="fa fa-trash-o fa-fw"></i>
        </a>
        <b-tooltip :target="'tbledit_' + row.item.id" title="Edit" placement="left"></b-tooltip>
        <b-tooltip :target="'tbldel_' + row.item.id" title="Remove" placement="right"></b-tooltip>
      </template>
    </b-table>
  </b-row>
</div>
</template>

<script>
import MaskedInput from 'vue-text-mask';
import {commonMixins} from '../../mixins/common';
import {MESSAGE_DURATION} from '../../mixins/constants';
import FormError from '../FormError';

export default {
  mixins: [commonMixins],
  components: {
    MaskedInput, FormError
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
      team_table_fields: {
        name: {thClass: [], sortable:true},
        description: {thClass: []},
        action: {thClass: []}
      },
      teams: []
    }
  },
  mounted: function () {
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
    teamNameError () {
      return this.new_team_name.length > 3 ? true : false;
    },
    teamDescriptionError () {
      return this.new_team_description.length > 3 ? true : false;
    },
    addr1Error () {
      if (!this.isObjectEmpty(this.errors)) {
        return this.errors.address1 ? false : true;
      } else {
        return null;
      }
    },
    zipError () {
      if (!this.isObjectEmpty(this.errors)) {
        return this.errors.zipcode ? false : true;
      } else {
        return null;
      }
    },
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
      this.$dialog.confirm(message, {})
      .then( (dialog)=> {
        axios({
          method: 'delete',
          url: '/api/organization/admin',
          data: {
            auth_user_id: this.user0.id,
            user_id: admin.user_id,
            organization_id: this.org_id,
          }
        })
        .then( (response) => {
          this.members.push(admin)
          this.administrators = this.remove_by_name(this.administrators, admin.name);
          console.log('Delete action completed ');
          dialog.close();
        })
        .catch( (error)=>{
          console.log('Delete action failed ');
          dialog.close();
        });
      })
      .catch( ()=> {
          //console.log('Clicked on cancel')
      });
    },
    saveNewAdmin: function() {
      if (this.new_admin == null) {
        return;
      }
      this.isAddingAdmin = false;
      axios({
        method: 'post',
        url: '/api/organization/admin',
        data: {
          auth_user_id: this.user0.id,
          user_id: this.new_admin.user_id,
          organization_id: this.org_id
        }
      }).then( (response) => {
        this.administrators.push(this.new_admin)
        this.members = this.remove_by_name(this.members, this.new_admin.name);
        this.new_admin = null;
      }).catch( (error) => {
        this.errors = error.response.data.errors;
      });
    },
    editTeam: function (team) {
          window.location.href = '/team/'+team.id+'/edit'
    },
    removeTeam (team) {
      let message = '<i>Team <span class="text-danger"><b>' + team.name
                  + '</b></span> will be permanently deleted!</i>';
      this.$dialog.confirm(message, {})
      .then( (dialog)=> {
        axios({
          method: 'delete',
          url: '/api/organization/team',
          data: {
            auth_user_id: this.user0.id,
            organization_id: this.org_id,
            team_id: team.id
          }
        }).then( (response) => {
          this.errors = {}
          this.teams = this.remove_by_name(this.teams, team.name);
          // console.log('Delete action completed ');
          dialog.close();
        }).catch( (error) => {
          console.log(error.response)
          dialog.close();
          this.setStatusFailed();
          let self = this;
          setTimeout(function(){
              self.setStatusInitial();
          }, MESSAGE_DURATION + 2000);
        });
      })
      .catch( ()=> {
          console.log('Clicked on cancel')
      });
    },
    saveNewTeam: function() {
      this.new_team_name = this.new_team_name.trim();
      this.new_team_description = this.new_team_description.trim();
      let error = false;
      if (this.new_team_name == '') {
        this.errors.new_team_name = "Team name is required"
        error=true
      }
      if (this.new_team_description == '') {
        this.errors.new_team_descriptiont = "Description is required"
        error=true
      }
      if (error) { return; }
      this.isAddingTeam = false;
      axios({
        method: 'post',
        url: '/api/organization/team',
        data: {
          auth_user_id: this.user0.id,
          organization_id: this.org_id,
          name: this.new_team_name,
          description: this.new_team_description
        }
      }).then( (response) => {
        this.errors = {}
        let team =  {
          id: response.data.id,
          organization_id: this.org_id,
          name: this.new_team_name,
          description: this.new_team_description
        };
        this.teams.push(team)
      }).catch( (error) => {
        console.log(error.response)
        if (error.response.data.errors != undefined) {
          this.errors = error.response.data.errors
        }
        this.setStatusFailed();
        let self = this;
        setTimeout(function(){
            self.setStatusInitial();
        }, MESSAGE_DURATION + 2000);
      });
    },
    saveOrganization() {
      console.log('save-org');
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
