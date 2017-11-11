<template>
    <div class="filter-bar">
      <form class="form-inline">
        <div class="form-group">
          <div class="pull-left">
          <label>Search for:</label>
          <input type="text" v-model="filterText" class="form-control"
                  @keyup.enter="doFilter"
                  :placeholder="filterPlaceholder">
          </div>
          <div class="pull-left">
            <filter-memberships :userid="userid"
                @orgTeamSelected="gotit"
            ></filter-memberships>
          </div>
          <button class="btn btn-primary" @click.prevent="doFilter">Go</button>
          <button class="btn" @click.prevent="resetFilter">Reset</button>

        </div>
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
         console.log(selectedOrgId, selectedTeamId)
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
