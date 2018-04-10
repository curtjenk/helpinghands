<template>
  <div class="">
    <select v-model="selectedOrg" @change="tellParent" name="org">
      <option disabled value="" class="lead text-primary">Select Organization...</option>
      <option value="0">--- All Organizations---</option>
      <option v-for="org in memberships" v-bind:value="org">{{ org != null ? org.name : 'blah' }}</option>
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
    role: {
      type: String,
      required: false
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
      memberships: []
    }
  },
  mounted: function () {
    axios('/api/member/'+this.user.id+'/membership')
    .then(response => {
      if (!this.isObjectEmpty(this.role) && this.role.length>0) {
        this.memberships = response.data.filter (m => m.role == this.role)
      } else {
        this.memberships = response.data;
      }
      //Find the specified organization and team
      if (!this.isObjectEmpty(this.organization)) {
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
      let teamid = (event.name == 'org' || orgid==0) ? null : this.selectedTeam ? this.selectedTeam.id : null;
      this.$emit('org-team-selected', orgid, teamid, this.selectedOrg, this.selectedTeam);
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
