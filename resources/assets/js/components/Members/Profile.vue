<template>
<div class="container">
  <div class="row my-2 mt-8">
    <div class="col-lg-9 order-lg-2 card">
      <div class="card-body">
      <ul class="nav nav-tabs nav-fill">
          <li class="nav-item">
              <button data-target="#personal" data-toggle="tab" class="nav-link active selected-tab">
                <span class="fa fa-star" aria-hidden="true"></span>
                <div class="hidden-xs">Personal</div>
              </button>
          </li>
          <li class="nav-item">
              <button data-target="#preferences" data-toggle="tab" class="nav-link btn">
                <span class="fa fa-heart" aria-hidden="true"></span>
                <div class="hidden-xs">Preferences</div>
              </button>
          </li>
          <li class="nav-item">
              <button data-target="#memberships" data-toggle="tab" class="nav-link btn btn-default">
                <span class="fa fa-sitemap" aria-hidden="true"></span>
                <div class="hidden-xs">Membership</div>
              </button>
          </li>
          <li class="nav-item">
              <button data-target="#credentials" data-toggle="tab" class="nav-link btn btn-default">
                <span class="fa fa-key" aria-hidden="true"></span>
                <div class="hidden-xs">Credentials</div>
              </button>
          </li>
      </ul>
      <div class="tab-content py-4">
        <div class="tab-pane active" id="personal">
          <h5 class="mb-3">User Profile</h5>
          <div class="row">
              <div class="col-md-6">
                  <h6>About</h6>
                  <p>
                      Web Designer, UI/UX Engineer
                  </p>
                  <h6>Hobbies</h6>
                  <p>
                      Indie music, skiing and hiking. I love the great outdoors.
                  </p>
              </div>
              <div class="col-md-6">
                  <h6>Recent badges</h6>
                  <a href="#" class="badge badge-dark badge-pill">html5</a>
                  <a href="#" class="badge badge-dark badge-pill">react</a>
                  <a href="#" class="badge badge-dark badge-pill">codeply</a>
                  <a href="#" class="badge badge-dark badge-pill">angularjs</a>
                  <a href="#" class="badge badge-dark badge-pill">css3</a>
                  <a href="#" class="badge badge-dark badge-pill">jquery</a>
                  <a href="#" class="badge badge-dark badge-pill">bootstrap</a>
                  <a href="#" class="badge badge-dark badge-pill">responsive-design</a>
                  <hr>
                  <span class="badge badge-primary"><i class="fa fa-user"></i> 900 Followers</span>
                  <span class="badge badge-success"><i class="fa fa-cog"></i> 43 Forks</span>
                  <span class="badge badge-danger"><i class="fa fa-eye"></i> 245 Views</span>
              </div>
              <div class="col-md-12">
                  <h5 class="mt-2"><span class="fa fa-clock-o ion-clock float-right"></span> Recent Activity</h5>
                  <table class="table table-sm table-hover table-striped">
                      <tbody>
                          <tr>
                              <td>
                                  <strong>Abby</strong> joined ACME Project Team in <strong>`Collaboration`</strong>
                              </td>
                          </tr>
                          <tr>
                              <td>
                                  <strong>Gary</strong> deleted My Board1 in <strong>`Discussions`</strong>
                              </td>
                          </tr>
                          <tr>
                              <td>
                                  <strong>Kensington</strong> deleted MyBoard3 in <strong>`Discussions`</strong>
                              </td>
                          </tr>
                          <tr>
                              <td>
                                  <strong>John</strong> deleted My Board1 in <strong>`Discussions`</strong>
                              </td>
                          </tr>
                          <tr>
                              <td>
                                  <strong>Skell</strong> deleted his post Look at Why this is.. in <strong>`Discussions`</strong>
                              </td>
                          </tr>
                      </tbody>
                  </table>
              </div>
          </div>
            <!--/row-->
        </div>
        <div class="tab-pane" id="preferences">
            <div class="alert alert-info alert-dismissable">
                <a class="panel-close close" data-dismiss="alert">×</a> This is an <strong>.alert</strong>. Use this to show important messages to the user.
            </div>
            <table class="table table-hover table-striped">
                <tbody>
                    <tr>
                        <td>
                           <span class="float-right font-weight-bold">3 hrs ago</span> Here is your a link to the latest summary report from the..
                        </td>
                    </tr>
                    <tr>
                        <td>
                           <span class="float-right font-weight-bold">Yesterday</span> There has been a request on your account since that was..
                        </td>
                    </tr>
                    <tr>
                        <td>
                           <span class="float-right font-weight-bold">9/10</span> Porttitor vitae ultrices quis, dapibus id dolor. Morbi venenatis lacinia rhoncus.
                        </td>
                    </tr>
                    <tr>
                        <td>
                           <span class="float-right font-weight-bold">9/4</span> Vestibulum tincidunt ullamcorper eros eget luctus.
                        </td>
                    </tr>
                    <tr>
                        <td>
                           <span class="float-right font-weight-bold">9/4</span> Maxamillion ais the fix for tibulum tincidunt ullamcorper eros.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="tab-pane" id="memberships">
              <form role="form">
                  <div class="form-group row">
                      <label class="col-lg-3 col-form-label form-control-label">First name</label>
                      <div class="col-lg-9">
                          <input class="form-control" type="text" value="Jane">
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="col-lg-3 col-form-label form-control-label">Last name</label>
                      <div class="col-lg-9">
                          <input class="form-control" type="text" value="Bishop">
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="col-lg-3 col-form-label form-control-label">Email</label>
                      <div class="col-lg-9">
                          <input class="form-control" type="email" value="email@gmail.com">
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="col-lg-3 col-form-label form-control-label">Company</label>
                      <div class="col-lg-9">
                          <input class="form-control" type="text" value="">
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="col-lg-3 col-form-label form-control-label">Website</label>
                      <div class="col-lg-9">
                          <input class="form-control" type="url" value="">
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="col-lg-3 col-form-label form-control-label">Address</label>
                      <div class="col-lg-9">
                          <input class="form-control" type="text" value="" placeholder="Street">
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="col-lg-3 col-form-label form-control-label"></label>
                      <div class="col-lg-6">
                          <input class="form-control" type="text" value="" placeholder="City">
                      </div>
                      <div class="col-lg-3">
                          <input class="form-control" type="text" value="" placeholder="State">
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="col-lg-3 col-form-label form-control-label">Time Zone</label>
                      <div class="col-lg-9">
                          <select id="user_time_zone" class="form-control" size="0">
                              <option value="Hawaii">(GMT-10:00) Hawaii</option>
                              <option value="Alaska">(GMT-09:00) Alaska</option>
                              <option value="Pacific Time (US &amp; Canada)">(GMT-08:00) Pacific Time (US &amp; Canada)</option>
                              <option value="Arizona">(GMT-07:00) Arizona</option>
                              <option value="Mountain Time (US &amp; Canada)">(GMT-07:00) Mountain Time (US &amp; Canada)</option>
                              <option value="Central Time (US &amp; Canada)" selected="selected">(GMT-06:00) Central Time (US &amp; Canada)</option>
                              <option value="Eastern Time (US &amp; Canada)">(GMT-05:00) Eastern Time (US &amp; Canada)</option>
                              <option value="Indiana (East)">(GMT-05:00) Indiana (East)</option>
                          </select>
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="col-lg-3 col-form-label form-control-label">Username</label>
                      <div class="col-lg-9">
                          <input class="form-control" type="text" value="janeuser">
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="col-lg-3 col-form-label form-control-label">Password</label>
                      <div class="col-lg-9">
                          <input class="form-control" type="password" value="11111122333">
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="col-lg-3 col-form-label form-control-label">Confirm password</label>
                      <div class="col-lg-9">
                          <input class="form-control" type="password" value="11111122333">
                      </div>
                  </div>
                  <div class="form-group row">
                      <label class="col-lg-3 col-form-label form-control-label"></label>
                      <div class="col-lg-9">
                          <input type="reset" class="btn btn-secondary" value="Cancel">
                          <input type="button" class="btn btn-primary" value="Save Changes">
                      </div>
                  </div>
              </form>
          </div>
        <div class="tab-pane" id="credentials">
        </div>
      </div>
      </div>
    </div>
    <div class="col-lg-3 order-lg-1 text-center">
        <img src="//placehold.it/150" class="mx-auto img-fluid img-circle d-block" alt="avatar">
        <h6 class="mt-2">Upload a different photo</h6>
        <label class="custom-file">
            <input type="file" id="file" class="custom-file-input">
            <span class="custom-file-control btn btn-primary">Choose file</span>
        </label>
    </div>
  </div>
</div>
</template>

<script>
import MaskedInput from 'vue-text-mask';
import VuePassword from 'vue-password';
import VeeValidate from 'vee-validate';
import { Validator } from 'vee-validate';

// Vue.use(VeeValidate);
Vue.use(VeeValidate, {
  errorBagName: 'vErrors',
  fieldsBagName: 'vformFields'
})

const MESSAGE_DURATION = 2500;
const STATUS_INITIAL = 0, STATUS_SAVING = 1, STATUS_SUCCESS = 2, STATUS_FAILED = 3;
export default {
  components: {
    MaskedInput, VuePassword
  },
  props: {
    user0: {
      type: Object,
      required: true
    },
    orgteams0: {
      type: Array,
      required: true
    },
    avatar0: {
      type: String
    }
  },
  data () {
    return {
      credential: '',
      credentialMessage: '',
      newEmail: '',
      oldPassword: '',
      newPassword: '',
      newPasswordConfirm: '',
      updateStatus: null,
      user: {},
      avatar_url: '',
      uploadedFiles: [],
      uploadError: null,
      currentStatus: null,
      newavatar: 'photo',
      orgData: [
        {id:1, name: 'Org 1', checked: true, editing: false,
            teams: [
                {id:1, name: 'Team 1', checked: false},
                {id:2, name: 'Team 2', checked: true}
            ]},
        {id:2, name: 'Org 2', checked: true, editing: false,
            teams: []},
        {id:3, name: 'Org 3', checked: false, editing: false,
            teams: [{id:1, name: 'Team 1', checked: false}]},
      ]
    }
  },
  mounted: function () {
    // this.avatar_url = this.avatar0;
    this.$nextTick(function () {  // Code that will run only after the entire view has been rendered
      this.user = this.user0;
      // this.avatar_url = this.avatar0;
      this.resetAvatar();
      this.orgData = [];
      this.orgteams0.forEach( org0 => {
        let teams = [];
        let userOrgCheckedItem=null;
        //look if the user is in this organization
        this.user.organizations.forEach( userOrgItem => {
          if (userOrgItem.id == org0.id) {
            userOrgCheckedItem=userOrgItem;
          }
        })

        org0.teams.forEach( team0 => {
          let isChecked=false;
          if (userOrgCheckedItem != null) {
            this.user.teams.forEach (userTeamItem => {
              if (userTeamItem.id == team0.id)
                isChecked = true;
            })
          }
          teams.push({id:team0.id, name:team0.name, checked: isChecked});
        })
        let isChecked = userOrgCheckedItem != null ? true: false;
        this.orgData.push({id: org0.id, name: org0.name,
            checked: isChecked, editing: false, teams: teams});
      });

    })
  },
  computed: {
    isInitial() {
      return this.currentStatus === STATUS_INITIAL;
    },
    isSaving() {
      return this.currentStatus === STATUS_SAVING;
    },
    isSuccess() {
      return this.currentStatus === STATUS_SUCCESS;
    },
    isFailed() {
      return this.currentStatus === STATUS_FAILED;
    },
    updateSuccess() {
      return this.updateStatus === STATUS_SUCCESS;
    },
    updateFailed() {
      return this.updateStatus === STATUS_FAILED;
    }
  },
  watch: {
    // newPasswordConfirm () {
    //   console.log(this.newPasswordConfirm);
    // }
  },
  methods: {
    uncheckTeams (org) {
     if (!org.checked) {
        for (let i=0; i<org.teams.length; i++) {
          org.teams[i].checked = false;
        }
      }
    },
    resetAvatar() {
        // reset form to initial state
        this.currentStatus = STATUS_INITIAL;
        this.uploadedFiles = [];
        this.uploadError = null;
    },
    update() {
      var url = '/api/member/' + this.user.id;
      axios.put(url, {user: this.user, org: this.orgData})
      .then(  (response) => {
        // console.log(response)
        this.updateStatus = STATUS_SUCCESS;
        var self = this;
        setTimeout(function(){
            self.updateStatus = STATUS_INITIAL;
            window.location.reload();
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
    saveAvatar(formData) {
      // upload photo to the server
      this.currentStatus = STATUS_SAVING;
      var url = '/api/member/' + this.user.id  + '/avatar';
      axios.post(url, formData)
      .then(  (response) => {
        this.uploadedFiles = [].concat(response);
        this.currentStatus = STATUS_SUCCESS;
        window.location.reload();
      }).catch((error) => {
        this.uploadError = error.response;
        this.currentStatus = STATUS_FAILED;
        console.log(error)
      });
    },
    filesChange(fieldName, fileList) {
      // handle file changes
      const formData = new FormData();

      if (!fileList.length) return;

      // append the files to FormData
      Array
        .from(Array(fileList.length).keys())
        .map(x => {
          formData.append(fieldName, fileList[x], fileList[x].name);
        });
      // save it
      this.saveAvatar(formData);

    },
  } //End of methods
} //End of export
</script>

<style lang="css" scoped>
.nav-tabs .nav-link.active {
  color: ghostwhite;
  background-color: #3D8AE9;
}
</style>
