<template>
  <div class="">
    <select v-model="selectedOrg" @change="tellParent" name="org">
      <option disabled value="" class="lead text-primary">Select Organization...</option>
      <option value="0">--- All Organizations---</option>
      <option v-for="org in memberships" v-bind:value="org">{{ org.name }}</option>
    </select>
    <select v-if="filterByTeam" v-model="selectedTeam" @change="tellParent" name="team">
      <option disabled value="" class="lead text-primary">Select Team...</option>
      <option v-show="selectedOrg.teams" value="0">--- All Teams ---</option>
      <option v-for="team in selectedOrg.teams" v-bind:value="team">{{ team.name }}</option>
    </select>
  </div>
</template>

<script>
import {commonMixins} from '../../mixins/common';
export default {
  name:'FilterMemberships',
  mixins: [commonMixins],
  components: {
  },
  props: {
    userid: {
      type: Number,
      required: true
    },
    organization: {
      // type: Object,
      required: false
    },
    team: {
      // type: Object,
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
      this.memberships = response.data;
      if (!this.isObjectEmpty(this.organization)) {
        // console.log('here')
        // this.selectedOrg = this.organization;
        this.selectedOrg = this.memberships.find( (m)=> {
          return m.id == this.organization.id;
        });
        if (!this.isObjectEmpty(this.team)) {
          this.selectedTeam = this.selectedOrg.teams.find( (t)=> {
            return t.id == this.team.id;
          })
        }
      }
    })
    .catch(e => {
      console.log(e);
    });
  },
  computed: {
  },
  watch: {
  },
  methods: {
    tellParent (event) {
      // console.log(event.name);
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
