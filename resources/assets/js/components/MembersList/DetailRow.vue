<template>
  <div @click="onClick" :id="rowData.id">
    <div class="col-md-3">
        <div class="inline field">
          <label>Name: </label>
          <span>{{rowData.name}}</span>
        </div>
        <div class="inline field">
          <label>Email: </label>
          <span>{{rowData.email}}</span>
        </div>
        <div class="inline field">
          <label>Nickname: </label>
          <span>{{rowData.nickname}}</span>
        </div>
    </div>
    <div class="col-md-3">
        <p>
            Attended {{ rowData.events.length }} Events
        </p>
    </div>
    <div class="col-md-6" id="scrollarea-invalid">
        <div id="scrollarea-content">
            <ol id="">
              <li v-for="item in rowData.events">
                {{ item.subject }}
              </li>
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
  methods: {
    onClick (event) {
      console.log('my-detail-row: on-click', event.target)
    //   console.log(this.rowData);
    }
  },
}
</script>
<style>
.scrollbox {
    height: 50px;
    overflow-y: scroll;
    overflow-x:hidden;
}
#scrollarea-invalid {
    overflow-y: scroll;
    overflow-x:hidden;
    height: 50px;
}
#scrollarea-content{
    min-height:101%;
}
</style>
