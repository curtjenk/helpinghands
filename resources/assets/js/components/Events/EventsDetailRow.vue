<template>
  <div @click="onClick" :id="rowData.id" class="container-fluid">
    <div class="row">
      <b-col md="5">
          <h5 class="">
           {{ rowData.members.length }} Signed-up
          </h5>
      </b-col>
    </div>
    <div id="scrollarea-invalid" class="row">
      <div id="scrollarea-content">
        <ol>
          <template v-if="rowData.members">
            <div v-for="items in groupedItems" class="row">
              <div v-for="item in items" class="col-md-3">
                <li>
                    {{ item.name }}
                </li>
              </div>
            </div>
          </template>
        </ol>
      </div>
    </div>
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
  computed: {
    groupedItems() {
      //using lodash
      return _.chunk(this.rowData.members, 4);
    }
  },
  methods: {
    onClick (event) {
      console.log('events-detail-row: on-click', event.target)
    //   console.log(this.rowData);
    }
  },
}
</script>
<style>
ol {
    list-style-type: circle;
}
.scrollbox {
    height: 100px;
    overflow-y: scroll;
    overflow-x:hidden;
}
#scrollarea-invalid {
    padding-left: 0;
    overflow-y: scroll;
    overflow-x:hidden;
    height: 150px;
}
#scrollarea-content{
    min-height:101%;
    min-width:100%;
}
</style>
