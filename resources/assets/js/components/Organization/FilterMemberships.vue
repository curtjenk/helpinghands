<template>
  <div class="">
    <select v-model="selectedOrg" @change="tellParent" name="org">Organization
      <option disabled value="">Select Organization</option>
      <option value="">--- Show All ---</option>
      <template v-for="org in memberships">
        <option v-bind:value="org"
                :selected="selectedOrg.id==org.id"
        >
          {{ org.name }}
       </option>
     </template>
    </select>
    <select v-if="filterByTeam" v-model="selectedTeam" @change="tellParent" name="team">Team
      <option disabled value="">Select Team</option>
      <option value="0">--- Show All ---</option>
      <option v-for="team in selectedOrg.teams"
              v-bind:value="team"
      >
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
    organization: {
      type: Object,
      required: false
    },
    team: {
      type: Object,
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
  //  this.$nextTick(function () {
      if (this.organization != undefined && this.organization != null) {
        // console.log(this.organization)
        this.selectedOrg = this.organization;
        if (this.team != undefined && this.team != null) {
          this.selectedTeam = this.team
        }
      }
    // });
    axios('/api/member/'+this.userid+'/membership')
    .then(response => {
      // console.log(response.data)
      this.memberships = response.data;
    })
    .catch(e => {
      console.log(e);
    });
  },
  computed: {
    // computedOrg: function() {
    //   return this.organization;
    // }
  },
  watch: {
    // organization(newVal, oldVal) {
    //   this.selectedOrg = newVal;
    // }
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
