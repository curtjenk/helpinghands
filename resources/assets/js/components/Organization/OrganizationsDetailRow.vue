<template>
  <div @click="onClick" :id="rowData.id" class="container-fluid">
    <template v-if="rowData.teams.length > 0">
      <div class="col-sm-offset-2 col-mdm-offset-2  col-md-8 col-sm-8">
        <table class="table table-responsive table-striped table-condensed">
          <thead>
            <tr class="info">
              <th colspan="3" class="text-center text-primary"><i>{{rowData.name}} : Team(s)</i></th>
            </tr>
            <tr class="info">
              <th class="text-center"><i>Name</i></th>
              <th class="text-center"><i>Description</i></th>
              <th class="text-center"><i>Members</i></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="team in rowData.teams">
              <td>{{team.name}}</td>
              <td>{{team.description}}</td>
              <td class="text-center">{{team.users.length}}
                <span v-if="team.users.length>1" class="text-success">
                  <i class="fa fa-users"></i>
                </span>
                <span v-else-if="team.users.length==1" class="text-warning">
                  <i class="fa fa-user"></i>
                </span>
                <span v-else class="text-danger">
                  <i class="fa fa-exclamation"></i>
                </span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </template>
  </div>
</template>

<script>
export default {
  props: {
    rowData: {
      type: Object,
      required: true
    },
    rowIndex: {
      type: Number
    }
  },
  methods: {
    onClick (event) {
      //console.log('my-detail-row: on-click', event.target)
    //   console.log(this.rowData);
    }
  },
  events: {
  }
}
</script>
<style>
ol {
    list-style-type: circle;
}
/*.scrollbox {
    height: 50px;
    overflow-y: scroll;
    overflow-x:hidden;
}*/
#scrollarea-invalid {
    padding-left: 0;
    overflow-y: scroll;
    overflow-x:hidden;
    height: 150px;
}
#scrollarea-content{
    min-height:101%;
}
</style>
