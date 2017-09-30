<template>
  <div class="col-lg-12 col-sm-12">
    <div class="card hovercard">
        <div class="card-background">
            <img class="card-bkimg" alt="" src="http://lorempixel.com/100/100/people/3/">
        </div>
        <div class="useravatar">
            <img alt="" src="http://lorempixel.com/100/100/people/3/">
        </div>
        <div class="card-info">
          <span class="card-title">{{ username }}</span>
        </div>
    </div>

    <div class="btn-pref btn-group btn-group-justified" role="group" aria-label="...">
        <div class="btn-group" role="group">
            <button v-on:click="changetab(0)" type="button" id="myinfo" class="btn btn-primary" href="#tab1" data-toggle="tab"><span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                <div class="hidden-xs">Personal Information</div>
            </button>
        </div>
        <div class="btn-group" role="group">
            <button v-on:click="changetab(1)" type="button" id="myprefs" class="btn btn-default" href="#tab2" data-toggle="tab"><span class="glyphicon glyphicon-heart" aria-hidden="true"></span>
                <div class="hidden-xs">Preferences</div>
            </button>
        </div>
        <div class="btn-group" role="group">
            <button v-on:click="changetab(2)" type="button" id="myactivity" class="btn btn-default" href="#tab3" data-toggle="tab"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                <div class="hidden-xs">My Activity</div>
            </button>
        </div>
        <div class="btn-group" role="group">
            <button v-on:click="changetab(3)" type="button" id="mypswd" class="btn btn-default" href="#tab4" data-toggle="tab"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                <div class="hidden-xs">Change Password</div>
            </button>
        </div>
    </div>

    <div class="well">
      <div class="tab-content">
        <div class="tab-pane fade in active" id="tab1">
          <h3>This is tab 1</h3>
        </div>
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
export default {
  components: {
  },
  props: [
    'username'
  ],
  data () {
    return {

    }
  },
  methods: {
    changetab: function (ndx) {
      var tabs = $(".btn-pref .btn").removeClass("btn-primary").addClass("btn-default");
      for (var i=0; i<tabs.length; i++) {
        if (i===ndx) {
          $(tabs[i]).removeClass("btn-default").addClass("btn-primary");
        }
      }
    }//End changetab
  } //End of methods
} //End of export
</script>

<style lang="css">
.well {
  border-radius: 0px;
}
/* USER PROFILE PAGE */
 .card {
    margin-top: 20px;
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
    height: 250px;
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
