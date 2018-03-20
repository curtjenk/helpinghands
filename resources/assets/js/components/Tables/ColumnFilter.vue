<template>
  <!-- Based on Bootstrap vue table -->
<div class="">
  <span class="align-bottom">
    <a class="btn btn-secondary btn-sm dropdown-toggle" href="#"
          id="dropdownMenuButton" @click.stop="showFilter=!showFilter"
          data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      {{ label }}
    </a>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
      <b-input-group size="sm">
        <b-form-input id="name_filter" type="text" name="name_filter" autofocus></b-form-input>
        <b-input-group-append>
          <b-btn href="#""><i class="fa fa-search fa-fw"></i></b-btn>
        </b-input-group-append>
      </b-input-group>
    </div>
      <!-- <template v-if="showFilter">
        <b-input-group size="sm">
          <b-form-input id="name_filter" type="text" name="name_filter" autofocus></b-form-input>
          <b-input-group-append>
            <b-btn href="#""><i class="fa fa-search fa-fw"></i></b-btn>
          </b-input-group-append>
        </b-input-group>
      </template> -->
  </span>
  <!-- <span class="align-bottom">{{ label }}
      <a href="#" @click.stop="showFilter=!showFilter">
        <i v-show="!showFilter" class="fa fa-caret-down fa-fw"></i>
        <i v-show="showFilter" class="fa fa-caret-up fa-fw"></i>
      </a>
      <template v-if="showFilter">
        <b-input-group size="sm">
          <b-form-input id="name_filter" type="text" name="name_filter" autofocus></b-form-input>
          <b-input-group-append>
            <b-btn href="#""><i class="fa fa-search fa-fw"></i></b-btn>
          </b-input-group-append>
        </b-input-group>
      </template>
  </span> -->
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
  },
  data () {
    return {
      showFilter: false,
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

  } //End of methods
} //End of export
</script>

<style lang="css" scoped>
</style>