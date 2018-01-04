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
                <span>Sorry, unable to save/update changes</span>
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
            <button type="submit" class="btn btn-primary" name="submit" @click="saveOrganization">
                <i class="fa fa-btn fa-check"></i> Save Team
            </button>
          </div>
        </div>
      </span>
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
    orgmembers0: {
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
      team_name: '',
      team_description: '',
      administrators: [],
      members: [],
      teams: []
    }
  },
  mounted: function () {
    this.team_name = this.team0.name;
    this.team_description = this.team0.description;
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
    updateEmail() {
      this.credential = 'Email';
      var url = '/api/member/' + this.user.id + '/email';
      axios.put(url, {newEmail: this.newEmail})
      .then(  (response) => {
        // console.log(response)
        this.user.email = this.newEmail;
        this.newEmail = '';
        this.updateStatus = STATUS_SUCCESS;
        var self = this;
        setTimeout(function(){
            self.updateStatus = STATUS_INITIAL;
        }, MESSAGE_DURATION);
      }).catch((error) => {
        // console.log(error.response)
        if (error.response.data == 'unavailable') {
          this.credentialMessage = 'email already in use.  Try another email';
        } else {
          this.credentialMessage = 'unable to change your email. Try later';
        }
        this.updateStatus = STATUS_FAILED;

        var self = this;
        setTimeout(function(){
            self.updateStatus = STATUS_INITIAL;
        }, MESSAGE_DURATION + 1000);
      });
    },
    updatePassword() {
      this.credential = 'Password';
      var url = '/api/member/' + this.user.id + '/password';
      axios.put(url, {
        oldPassword: this.oldPassword,
        newPassword: this.newPassword,
        newPasswordConfirm: this.newPasswordConfirm,
        })
      .then(  (response) => {
        console.log(response)
        this.updateStatus = STATUS_SUCCESS;
        var self = this;
        setTimeout(function(){
            self.updateStatus = STATUS_INITIAL;
        }, MESSAGE_DURATION);
      }).catch((error) => {
        console.log(error.response)
        if (error.response.data == 'verify') {
          this.credentialMessage = 'please verify your input';
        } else {
          this.credentialMessage = 'unable to change your password. Try later';
        }
        this.updateStatus = STATUS_FAILED;
        var self = this;
        setTimeout(function(){
            self.updateStatus = STATUS_INITIAL;
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
