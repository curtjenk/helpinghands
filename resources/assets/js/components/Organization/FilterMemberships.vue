<template>
  <div class="">
    <select v-model="selectedOrg" @change="tellParent" id="" name="org">Organization
      <option disabled value="">Select Organization</option>
      <option value="0">--- Show All ---</option>
      <option v-for="org in memberships" v-bind:value="org">
        {{ org.name }}
     </option>
    </select>
    <select v-if="filterByTeam" v-model="selectedTeam" @change="tellParent" id="" name="team">Team
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
    },
    selectedOrg0: {
      type: Number,
      required: false
    },
    selectedTeam0: {
      type: Number,
      required: false
    },
    filterByTeam: {
      type: Boolean,
      required: false,
      default: true
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
      this.$nextTick(function () {
        if (this.selectedOrg0 != undefined) {
          this.selectedOrg = this.selectedOrg0;
          if (this.selectedTeam0 != undefined) {
            this.selectedTeam = this.selectedTeam0
          }
        }
      });
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
      this.$emit('orgTeamSelected', orgid, teamid, this.selectedOrg, this.selectedTeam);
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
