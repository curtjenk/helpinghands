  <template>
    <div class="custom-actions">
      <!-- <button class="btn btn-sm" @click="itemAction('view-item', rowData, rowIndex)"><i class="glyphicon glyphicon-zoom-in"></i></button> -->
      <a class="" @click="itemAction('edit-item', rowData, rowIndex)"><i class="fa fa-address-card-o fa-lg" aria-hidden="true"></i></a>
      <!-- <button v-if="rowData.authUserCanDelete" class="btn btn-sm" @click="itemAction('delete-item', rowData, rowIndex)"><i class="glyphicon glyphicon-trash"></i></button> -->
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
      },
    },
    methods: {
      itemAction (action, data, index) {
        console.log('custom-actions member: ' + action, data.name, index)
        window.location.href = '/user/'+this.rowData.id+'/edit';
      }
    }
  }
  </script>

  <style>
    .custom-actions button.ui.button {
      padding: 8px 8px;
    }
    .custom-actions button.ui.button > i.icon {
      margin: auto !important;
    }
  </style>
