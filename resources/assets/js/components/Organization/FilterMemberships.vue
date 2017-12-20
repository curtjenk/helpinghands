<template>
  <div class="">
    <select v-model="selectedOrg" @change="tellParent" id="" name="org">Organization
      <option disabled value="">Select Organization</option>
      <option value="0">--- Show All ---</option>
      <option v-for="org in memberships" v-bind:value="org">
        {{ org.name }}
     </option>
    </select>
    <select v-model="selectedTeam" @change="tellParent" id="" name="team">Team
      <option disabled value="">Select Team</option>
      <option value="0">--- Show All ---</option>
      <option v-for="team in selectedOrg.teams" v-bind:value="team">
        {{ team.name }}
     </option>
    </select>
  </div>
</template>

<script>

export default {
  components: {
  },
  props: {
    userid: {
      type: Number,
      required: true
    }
  },
  data () {
    return {
      selectedOrg: '',
      selectedTeam: '',
      memberships: ''
    }
  },
  mounted: function () {
    axios('/api/member/'+this.userid+'/membership')
    .then(response => {
      // console.log(response.data)
      this.memberships = response.data;
    })
    .catch(e => {
      console.log(e);
    });
  },
  // computed: {
  //
  // },
  watch: {

  },
  methods: {
    tellParent (event) {
      // console.log(event);
      let orgid = this.selectedOrg.id ? this.selectedOrg.id : 0;
      let teamid = event.name == 'org' || orgid==0 ? 0 : this.selectedTeam.id;
      this.$emit('orgTeamSelected', orgid, teamid);
    }
  } //End of methods
} //End of export
</script>

<style lang="css" scoped>
select {
  height: 36px;
  margin-left: 1px;
}
</style>
