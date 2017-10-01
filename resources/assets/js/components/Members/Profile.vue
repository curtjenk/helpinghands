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
            <button v-on:click="changetab(2)" type="button" id="myactivity" class="btn btn-default" href="#tab3" data-toggle="tab"><span class="fa fa-hourglass" aria-hidden="true"></span>
                <div class="hidden-xs">My Activity</div>
            </button>
        </div>
        <div class="btn-group" role="group">
            <button v-on:click="changetab(3)" type="button" id="mypswd" class="btn btn-default" href="#tab4" data-toggle="tab"><span class="fa fa-key" aria-hidden="true"></span>
                <div class="hidden-xs">Username/Password</div>
            </button>
        </div>
    </div>

    <div class="well">
      <div class="tab-content">
        <div class="tab-pane fade in active" id="tab1">
          <div class="form-horizontal">
            <div class="row">
              <div class="col-md-5">
                <div class="form-group">
                    <label for="name" class="col-md-2 col-sm-2 control-label">Name</label>
                    <div class="col-md-5 col-sm-5">
                        <input id="name" v-model="user.name" type="text" class="editInfo" name="name" maxlength="255">
                    </div>
                  </div>
                <div class="form-group">
                    <label for="nickname" class="col-md-2 col-sm-2 control-label">Nick Name</label>
                    <div class="col-md-5 col-sm-5">
                      <input id="nickname" v-model="user.nickname" type="text" class="editInfo" name="nickname" maxlength="255">
                    </div>
                  </div>
                <div class="form-group">
                    <label for="phone1" class="col-md-2 col-sm-2 control-label">Phone 1</label>
                    <div class="col-md-5 col-sm-5">
                      <input id="phone1" v-model="user.homephone" type="tel" v-mask="'(###) ###-####'"
                        placeholder="" class="editInfo" name="phone1">
                    </div>
                  </div>
                <div class="form-group">
                    <label for="phone2" class="col-md-2 col-sm-2 control-label">Phone 2</label>
                    <div class="col-md-5 col-sm-5">
                      <input id="phone2" v-model="user.mobilephone" type="text" v-mask="'(###) ###-####'"
                        placeholder="" class="editInfo" name="phone2">
                    </div>
                  </div>
              </div>
              <div class="col-md-1 col-sm-1"></div>
              <div class="col-md-3 col-sm-3">
                <!-- <div class="form-group"> -->
                <form enctype="multipart/form-data" novalidate v-if="isInitial || isSaving || isSuccess">
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
              </div>
              <div class="col-md-3 col-sm-3">
                 Nothing here yet!
              </div>
            </div>
            <div class="row block text-center">
              <button type="submit" class="btn btn-primary" name="submit">
                <i class="fa fa-btn fa-check"></i> Update Information
              </button>
            </div>
          </div>
        </div>
        <!--End of tab1  -->
        <div class="tab-pane fade in" id="tab2">
          <h3>This is tab 2</h3>
        </div>
        <div class="tab-pane fade in" id="tab3">
          <h3>This is tab 3</h3>
        </div>
        <div class="tab-pane fade in" id="tab4">
          <h3>This is tab 4</h3>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {TheMask} from 'vue-the-mask'
const STATUS_INITIAL = 0, STATUS_SAVING = 1, STATUS_SUCCESS = 2, STATUS_FAILED = 3;
export default {
  components: {
    TheMask
  },
  props: {
    user0: {
      type: Object,
      required: true
    },
    avatar0: {
      type: String
    }
  },
  data () {
    return {
      user: {},
      avatar_url: '',
      uploadedFiles: [],
      uploadError: null,
      currentStatus: null,
      newavatar: 'photo'
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
    }
  },
  methods: {
    resetAvatar() {
        // reset form to initial state
        this.currentStatus = STATUS_INITIAL;
        this.uploadedFiles = [];
        this.uploadError = null;
    },
    saveAvatar(formData) {
      // upload data to the server
      this.currentStatus = STATUS_SAVING;
      //
      // upload(formData)
      //   .then(x => {
      //     this.uploadedFiles = [].concat(x);
      //     this.currentStatus = STATUS_SUCCESS;
      //   })
      //   .catch(err => {
      //     this.uploadError = err.response;
      //     this.currentStatus = STATUS_FAILED;
      //   });
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
