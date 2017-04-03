<template>
  <div @click="onClick" :id="rowData.id">
    <div class="col-md-3">
        <h5 class="">
         {{ rowData.members.length }} Member(s) Signed-up
        </h5>
    </div>
    <div class="col-md-9" id="scrollarea-invalid">
        <div class="col-md-12">
            <div id="scrollarea-content">
                <ol id="">
                  <li v-for="item in rowData.members"  class="col-md-4">
                    {{ item.name }}
                  </li>
               </ol>
            </div>
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
  methods: {
    onClick (event) {
      //console.log('events-detail-row: on-click', event.target)
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
    height: 100px;
}
#scrollarea-content{
    min-height:101%;
}
</style>
