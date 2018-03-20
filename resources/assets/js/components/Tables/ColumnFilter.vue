<template>
  <!-- Based on Bootstrap vue table -->
    <!-- :toggle-class="filter_check(column.name)" -->
<div class="">
  <span class="align-bottom"> {{ label }}
    <b-dropdown :id="label"
      variant="link"
      v-b-tooltip title="Filter"
      toggle-class="p-0"
    >
      <b-dropdown-header @click.stop="" class="p-1">
        <i class="fa fa-filter"></i> Filter
      </b-dropdown-header>
      <b-dropdown-item disabled class="p-1">
        <input type="text" class="" placeholder=""
          v-model="filterBy"
          v-on:keyup.enter="filter_check_submit"
        ></input>
        <b-btn variant="primary" block
          class="mt-1 px-2" size="sm"
          @click="filter_check_submit"
        >
          Go
        </b-btn>
      </b-dropdown-item>
    </b-dropdown>
  </span>
</div>
</template>

<script>
export default {
  mixins: [],
  components: {},
  props: {
    field: {
      type: String,
      required: true
    },
    label: {
      type: String,
      required: true
    },
    callback: {
      required: true
    }
  },
  data () {
    return {
      showFilter: false,
      filterBy: ''
    }
  },
  mounted: function () {

  },
  updated: function() {
    // console.log('dom updated')
  },
  computed: {

  },
  watch: {
    // newPasswordConfirm () {
    //   console.log(this.newPasswordConfirm);
    // }
  },
  methods: {
    filter_check_submit () {
      if (this.filterBy.trim().length > 1) {
        this.callback(this.field, this.filterBy);
      } else {
        console.log('invalid filterBy')
      }
    }
  } //End of methods
} //End of export
</script>

<style lang="css" scoped>
</style>