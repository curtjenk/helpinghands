<template>
  <div class="">
    <div class="form-horizontal">
      <div class="form-group">
          <label for="name" class="col-md-3 col-sm-3 control-label">Name</label>
          <div class="col-md-5">
              <input required id="name" v-model="org_name" type="text"
                  name="name" autofocus class="editInfo" maxlength="255">
          </div>
      </div>
      <div class="form-group">
          <label for="phone" class="col-md-3 col-sm-3 control-label">Phone</label>
          <div class="col-md-5 col-sm-5">
            <input id="phone" v-model="org_phone" type="tel" v-mask="'(###) ###-####'"
              name="phone" class="editInfo">
          </div>
      </div>

      <div class="form-group">
          <label for="address1" class="col-md-3 col-sm-3 control-label">Address 1</label>
          <div class="col-md-5">
              <input id="address1" v-model="org_address1" type="text"
                  name="address1" class="editInfo" maxlength="255">
          </div>
      </div>
      <div class="form-group">
          <label for="address2" class="col-md-3 col-sm-3 control-label">Address 2</label>
          <div class="col-md-5">
              <input id="address2" v-model="org_address2" type="text"
                  name="address2" class="editInfo" maxlength="255">
          </div>
      </div>
      <div class="form-group">
          <label for="city" class="col-md-3 col-sm-3 control-label">City</label>
          <div class="col-md-5">
              <input id="city" v-model="org_city" type="text"
                  name="city" class="editInfo" maxlength="255">
          </div>
      </div>
      <!-- <div class="form-inline"> -->
        <div class="form-group">
          <label for="state" class="col-md-3 col-sm-3 control-label">State Code</label>
          <div class="col-md-2">
            <input id="state" v-model="org_state" type="text"
                  name="state" class="" maxlength="2" size="2">
          </div>
        </div>
        <div class="form-group">
          <label for="zip" class="col-md-3 col-sm-3 control-label">Zip Code</label>
          <div class="col-md-2">
            <input id="zip" v-model="org_zip" type="text"
                name="zip" class="" maxlength="5" size="5">
          </div>
        </div>
      <!-- </div> -->
      <hr />
      <div class="block text-center">
          <button type="submit" class="btn btn-primary" name="submit">
              <i class="fa fa-btn fa-check"></i> Save Changes
          </button>
      </div>
    </div>

  </div>
</template>

<script>
import {TheMask} from 'vue-the-mask';
const MODE_SHOW = 0, MODE_EDIT = 1, MODE_CREATE = 2;

export default {
  components: {
    TheMask
  },
  props: {
    user0: {
      type: Object,
      required: true
    },
    orgteams0: {
      type: Object,
      required: false,
      default: null
    }
  },
  data () {
    return {
      currentMode: MODE_SHOW,
      org_name: '',
      org_address1: '',
      org_address2: '',
      org_phone: ''

    }
  },
  mounted: function () {
    if (this.orgteams0 != null) {
      this.org_name = this.orgteams0.name
      this.org_address1 = this.orgteams0.address1
    }
    this.$nextTick(function () {  // Code that will run only after the entire view has been rendered

    })
  },
  computed: {
    isShowing() {
      return this.currentMode === MODE_SHOW;
    },
    isEditing() {
      return this.currentMode === MODE_EDIT;
    },
    isCreating() {
      return this.currentMode === MODE_CREATE;
    }
  },
  watch: {
    // newPasswordConfirm () {
    //   console.log(this.newPasswordConfirm);
    // }
  },
  methods: {

    update() {
      var url = '/api/member/' + this.user.id;
      axios.put(url, {user: this.user, org: this.orgData})
      .then(  (response) => {
        // console.log(response)
        this.updateStatus = STATUS_SUCCESS;
        var self = this;
        setTimeout(function(){
            self.updateStatus = STATUS_INITIAL;
        }, MESSAGE_DURATION);
      }).catch((error) => {
        // console.log(error)
        this.updateStatus = STATUS_FAILED;
        var self = this;
        setTimeout(function(){
            self.updateStatus = STATUS_INITIAL;
        }, MESSAGE_DURATION + 1000);
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
.alert {
  padding: 0px;
}
.bgInherit {
  background-color: inherit !important;
}
.btn-pref .btn {
    -webkit-border-radius:0 !important;
}

</style>
