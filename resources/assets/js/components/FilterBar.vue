<template>
    <div class="filter-bar">
      <form class="form-inline">
        <div class="form-group">
            <label>Search for:</label>
            <input type="text" v-model="filterText" class="form-control"
                    @keyup.enter="doFilter"
                    :placeholder="filterPlaceholder">
        </div>
        <div class="form-group" v-if="filterByMemberships">
          <filter-memberships
              :userid="userid"
              :filterByTeam="filterByTeam"
              @org-team-selected="gotit"
          ></filter-memberships>
        </div>
        <button class="btn btn-primary" @click.prevent="doFilter">Go</button>
        <button class="btn" @click.prevent="resetFilter">Reset</button>
      </form>
    </div>
</template>

<script>
  export default {
    props: {
      userid: {
        type: Number,
        required: true
      },
      filterByMemberships: {
        type: Boolean,
        required: false
      },
      filterByTeam: {
        type: Boolean,
        required: false,
        default: true
      },
      filterPlaceholder: {
        type: String
      }
    },
    data () {
      return {
        filterOrgId: 0,
        filterTeamId: 0,
        filterText: ''
        // filterPlaceholder: 'hello'
      }
    },
    mounted: function () {

    },
    methods: {
      gotit (selectedOrgId, selectedTeamId) {
         // console.log(selectedOrgId, selectedTeamId)
         this.filterOrgId = selectedOrgId;
         this.filterTeamId = selectedTeamId;
      },
      doFilter () {
        this.$events.fire('filter-set',
              this.filterText, this.filterOrgId, this.filterTeamId)
      },
      resetFilter () {
        this.filterText = ''
        this.$events.fire('filter-reset')
      }
    }
  }
</script>
<style scoped>
.filter-bar {
  padding: 10px;
}
button.btn.btn-primary {
  margin-left: 3px;
}
</style>
