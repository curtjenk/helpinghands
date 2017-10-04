<template>
  <div class="col-lg-12 col-sm-12">
    <div class="card hovercard">
        <div class="card-background">
            <img class="card-bkimg" alt=""  v-if="avatar_url" :src="avatar_url">
            <img class="card-bkimg" alt="" src="http://lorempixel.com/150/150/people/3/">
        </div>
        <div class="useravatar">
            <img alt="" v-if="avatar_url" :src="avatar_url">
            <img alt="" v-else src="http://lorempixel.com/150/150/people/3/">
        </div>
    </div>

    <div class="btn-pref btn-group btn-group-justified" role="group" aria-label="...">
        <div class="btn-group" role="group">
            <button v-on:click="changetab(0)" type="button" id="myinfo" class="btn btn-primary" href="#tab1" data-toggle="tab"><span class="fa fa-star" aria-hidden="true"></span>
                <div class="hidden-xs">Personal Information</div>
            </button>
        </div>
        <div class="btn-group" role="group">
            <button v-on:click="changetab(1)" type="button" id="myprefs" class="btn btn-default" href="#tab2" data-toggle="tab"><span class="fa fa-heart" aria-hidden="true"></span>
                <div class="hidden-xs">Preferences</div>
            </button>
        </div>
        <div class="btn-group" role="group">
            <button v-on:click="changetab(2)" type="button" id="organizations" class="btn btn-default" href="#tab3" data-toggle="tab">
              <span class="fa fa-sitemap" aria-hidden="true"></span>
              <div class="hidden-xs">Organizations</div>
            </button>
        </div>
        <div class="btn-group" role="group">
            <button v-on:click="changetab(3)" type="button" id="mypswd" class="btn btn-default" href="#tab4" data-toggle="tab">
              <span class="fa fa-key" aria-hidden="true"></span>
              <div class="hidden-xs">Username/Password</div>
            </button>
        </div>
    </div>

    <div class="well">
      <div class="tab-content">
        <div class="tab-pane fade in active" id="tab1">
          <div class="form-horizontal">
            <div class="row">
              <div class="alert alert-success" v-if="updateSuccess" transition="expand">Your information was updated.</div>
              <div class="alert alert-danger" v-if="updateFailed" transition="expand">
                  Sorry, unable to update your information at this time.
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                    <label for="name" class="col-md-3 col-sm-3 control-label">Name</label>
                    <div class="col-md-5 col-sm-5">
                        <input id="name" v-model="user.name" type="text" class="editInfo" name="name" maxlength="255">
                    </div>
                  </div>
                <div class="form-group">
                    <label for="nickname" class="col-md-3 col-sm-3 control-label">Nick Name</label>
                    <div class="col-md-5 col-sm-5">
                      <input id="nickname" v-model="user.nickname" type="text" class="editInfo" name="nickname" maxlength="255">
                    </div>
                  </div>
                <div class="form-group">
                    <label for="phone1" class="col-md-3 col-sm-3 control-label">Phone 1</label>
                    <div class="col-md-5 col-sm-5">
                      <input id="phone1" v-model="user.homephone" type="tel" v-mask="'(###) ###-####'"
                        placeholder="" class="editInfo" name="phone1">
                    </div>
                  </div>
                <div class="form-group">
                    <label for="phone2" class="col-md-3 col-sm-3 control-label">Phone 2</label>
                    <div class="col-md-5 col-sm-5">
                      <input id="phone2" v-model="user.mobilephone" type="text" v-mask="'(###) ###-####'"
                        placeholder="" class="editInfo" name="phone2">
                    </div>
                  </div>
              </div>
              <div class="col-md-3 col-sm-3">
                <!-- <div class="form-group"> -->
                <!-- <form enctype="multipart/form-data" novalidate v-if="isInitial || isSaving"> -->
                <form enctype="multipart/form-data" novalidate>
                  <div class="dropbox">
                    <input id="newavatar" class="" :name="newavatar" :disabled="isSaving" type="file"
                        @change="filesChange($event.target.name, $event.target.files); fileCount=$event.target.files.length" accept="image/*"
                        class="input-file"/>
                    <p v-if="isInitial">
                        Drag your picture here <br />  or click to browse
                    </p>
                    <p v-if="isSaving">
                      Uploading {{ fileCount }} files...
                    </p>
                  </div>
                </form>
                <div v-if="isFailed">
                    <div>Upload Failed</div>
                    <pre>{{ uploadError }}</pre>
                </div>
              </div>
              <div class="col-md-5 col-sm-4"></div>
            </div>
            <br>
            <div class="row block text-center">
              <div class="col-md-offset-1 col-md-2">
                <button type="submit" class="btn btn-primary" name="submit" @click="update">
                  <i class="fa fa-btn fa-check"></i> Update Information
                </button>
              </div>.
              <div class="col-md-7"></div>
            </div>
          </div>
        </div>
        <!--End of tab1  -->
        <div class="tab-pane fade in" id="tab2">
          <div class="form-horizontal">
            <div class="row">
              <div class="alert alert-success" v-if="updateSuccess" transition="expand">Your preferences were updated.</div>
              <div class="alert alert-danger" v-if="updateFailed" transition="expand">
                  Sorry, unable to update your preferences at this time.
              </div>
            </div>
            <div class="row">
              <div class="col-md-3 col-sm-3">
                <div>
                  <switches v-model="user.opt_receive_evite" theme="bootstrap" type-bold="true" color="success"
                    text-enabled="I Want Evites"
                    text-disabled="I Don't Want Evites"
                  ></switches>
                <div>
                </div>
                  <switches v-model="user.opt_show_email" theme="bootstrap" type-bold="true" color="success"
                    text-enabled="Others Can See My Email Address"
                    text-disabled="My Email - My Eyes Only"
                  ></switches>
                </div>
              </div>
              <div class="col-md-3 col-sm-3">
                <div>
                  <switches v-model="user.opt_show_mobilephone" theme="bootstrap" type-bold="true" color="warning"
                    text-enabled="Show My Phone1"
                    text-disabled="Hide My Phone1"
                  ></switches>
                <div>
                </div>
                  <switches v-model="user.opt_show_homephone" theme="bootstrap" type-bold="true" color="warning"
                  text-enabled="Show My Phone2"
                  text-disabled="Hide My Phone2"
                  ></switches>
                </div>
              </div>
              <div class="col-md-5 col-sm-4"></div>
            </div>
            <br>
            <div class="row block text-center">
              <div class="col-md-offset-1 col-md-2">
                <button type="submit" class="btn btn-primary" name="submit" @click="update">
                  <i class="fa fa-btn fa-check"></i> Update Preferences
                </button>
              </div>.
              <div class="col-md-7"></div>
            </div>
          </div>
        </div>
        <!--End of tab2  -->
        <div class="tab-pane fade in" id="tab3">
          <div v-for="org in this.orgData">
            <input type="checkbox" :checked="org.checked" v-model="org.checked" @change="uncheckTeams(org)">
            <span v-if="org.teams.length">
              <a href="#"><span @click="org.editing = !org.editing">{{ org.name }}</span></a>
            </span>
            <span v-else @click="org.editing = !org.editing">{{ org.name }}</span>
            <div v-for="team in org.teams" v-show="org.editing">
              <input style="margin-left: 20px;" type="checkbox" :checked="team.checked" v-model="team.checked" :disabled="!org.checked">{{ team.name}}
            </div>
          </div>
        </div>
        <div class="tab-pane fade in" id="tab4">
          <h3>This is tab 4</h3>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {TheMask} from 'vue-the-mask';
import Switches from 'vue-switches';
const MESSAGE_DURATION = 2500;
const STATUS_INITIAL = 0, STATUS_SAVING = 1, STATUS_SUCCESS = 2, STATUS_FAILED = 3;
export default {
  components: {
    TheMask, Switches
  },
  props: {
    user0: {
      type: Object,
      required: true
    },
    userorgs0: {
      type: Array,
      required: true
    },
    userteams0: {
      type: Array,
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
      updateStatus: null,
      orgTreeData: {},
      user: {},
      avatar_url: '',
      uploadedFiles: [],
      uploadError: null,
      currentStatus: null,
      newavatar: 'photo',
      orgData: [
        {name: 'Org 1', checked: true, editing: false,
            teams: [
                {id:1, name: 'Team 1', checked: false},
                {id:2, name: 'Team 2', checked: true}
            ]},
        {name: 'Org 2', checked: true, editing: false,
            teams: []},
        {name: 'Org 3', checked: false, editing: false,
            teams: [{id:1, name: 'Team 1', checked: false}]},
      ]
    }
  },
  mounted: function () {
    this.$nextTick(function () {  // Code that will run only after the entire view has been rendered
      this.user = this.user0;
      this.avatar_url = this.avatar0;
      this.resetAvatar();
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
      var url = '/member/' + this.user.id;
      axios.put(url, this.user)
      .then(  (response) => {
        console.log(response)
        this.updateStatus = STATUS_SUCCESS;
        var self = this;
        setTimeout(function(){
            self.updateStatus = STATUS_INITIAL;
        }, MESSAGE_DURATION);
      }).catch((error) => {
        console.log(error)
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
      var url = '/member/' + this.user.id  + '/avatar';
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
    changetab: function (ndx) {
      var tabs = $(".btn-pref .btn").removeClass("btn-primary").addClass("btn-default");
      for (var i=0; i<tabs.length; i++) {
        if (i===ndx) {
          $(tabs[i]).removeClass("btn-default").addClass("btn-primary");
          break;
        }
      }
    }//End changetab
  } //End of methods
} //End of export
</script>

<style lang="css" scoped>
/*  file upload            */
.dropbox {
    outline: 2px dashed grey; /* the dash box */
    outline-offset: -10px;
    background: lightcyan;
    color: dimgray;
    padding: 2px 2px;
    min-height: 50px; /* minimum height */
    position: relative;
    cursor: pointer;
  }

  .input-file {
    opacity: 0; /* invisible but it's there! */
    width: 50%;
    height: 50px;
    position: absolute;
    cursor: pointer;
  }

  .dropbox:hover {
    background: lightblue; /* when mouse over to the drop zone, change color */
  }

  .dropbox p {
    font-size: 1.2em;
    text-align: center;
    padding: 25px 0;
  }
/*   */
label {
  padding-left: 0px;
  padding-right:0px;
}
.cbSwitch {
  margin-top: 3px;
}
.editInfo {
  background-color: #f5f5f5;
}
.well {
  border-radius: 0px;
  font-size: 12px;
}
/* USER PROFILE PAGE */
 .card {
    margin-top: 5px;
    padding: 30px;
    background-color: rgba(214, 224, 226, 0.2);
    -webkit-border-top-left-radius:5px;
    -moz-border-top-left-radius:5px;
    border-top-left-radius:5px;
    -webkit-border-top-right-radius:5px;
    -moz-border-top-right-radius:5px;
    border-top-right-radius:5px;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}
.card.hovercard {
    position: relative;
    padding-top: 0;
    overflow: hidden;
    text-align: center;
    background-color: #fff;
    background-color: rgba(255, 255, 255, 1);
}
.card.hovercard .card-background {
    height: 200px;
}
.card-background img {
    -webkit-filter: blur(25px);
    -moz-filter: blur(25px);
    -o-filter: blur(25px);
    -ms-filter: blur(25px);
    filter: blur(25px);
    margin-left: -100px;
    margin-top: -200px;
    min-width: 130%;
}
.card.hovercard .useravatar {
    position: absolute;
    top: 15px;
    left: 0;
    right: 0;
}
.card.hovercard .useravatar img {
    width: 200px;
    height: 200px;
    max-width: 200px;
    max-height: 200px;
    -webkit-border-radius: 50%;
    -moz-border-radius: 50%;
    border-radius: 50%;
    border: 5px solid rgba(255, 255, 255, 0.5);
}
.card.hovercard .card-info {
    position: absolute;
    bottom: 14px;
    left: 0;
    right: 0;
}
.card.hovercard .card-info .card-title {
    padding:0 5px;
    font-size: 20px;
    line-height: 1;
    color: #262626;
    background-color: rgba(255, 255, 255, 0.1);
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
}
.card.hovercard .card-info {
    overflow: hidden;
    font-size: 12px;
    line-height: 20px;
    color: #737373;
    text-overflow: ellipsis;
}
.card.hovercard .bottom {
    padding: 0 20px;
    margin-bottom: 17px;
}
.btn-pref .btn {
    -webkit-border-radius:0 !important;
}
</style>
