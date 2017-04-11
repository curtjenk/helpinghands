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
        <div class="inline field">
          <label>Mobile: </label>
          <span>{{rowData.mobilephone}}</span>
        </div>
        <div class="inline field">
          <label>Home: </label>
          <span>{{rowData.homephone}}</span>
        </div>
    </div>
    <span v-if="rowData.events != null">
    <div class="col-md-2">
        <h5 class="">
            Attended {{ rowData.events.length }} Event(s)
        </h5>
    </div>
    <div class="col-md-4" id="scrollarea-invalid">
        <div id="scrollarea-content">
            <ol id="">
              <li v-for="item in rowData.events">
                {{ item.subject }}
              </li>
           </ol>
        </div>
    </div>
    </span>
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
      //console.log('my-detail-row: on-click', event.target)
    //   console.log(this.rowData);
    }
  },
  events: {
    // 'hide-detail' () {
    //   console.log('hide-detail')
    // },
    // 'show-detail' () {
    //   console.log('show-detail')
    //   axios.get('/member/' + this.rowData.id )
    //   .then(  (response) => {
    //    console.log(response.data);
    //   }).catch((error) => {
    //       console.log('detail:', error)
    //   });
    // },
    // 'filter-reset' () {
    //     console.log('filter-reset caught in detailrow')
    // }
  }
}
</script>
<style>
ol {
    list-style-type: circle;
}
.scrollbox {
    height: 50px;
    overflow-y: scroll;
    overflow-x:hidden;
}
#scrollarea-invalid {
    padding-left: 0;
    overflow-y: scroll;
    overflow-x:hidden;
    height: 50px;
}
#scrollarea-content{
    min-height:101%;
}
</style>
