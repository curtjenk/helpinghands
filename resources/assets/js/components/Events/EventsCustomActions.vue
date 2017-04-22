  <template>
    <div class="custom-actions">
      <!-- <a class="" data-toggle="tooltip" title="View"  @click="itemAction('view-item', rowData, rowIndex)"><i class="fa fa-eye fa-lg"></i></a> -->
      <a class="" data-toggle="tooltip" title="Details"  @click="itemAction('edit-item', rowData, rowIndex)"><i class="fa fa-edit fa-lg"></i></a>
      <!-- <a class="" data-toggle="tooltip" title="Sign-up" @click="itemAction('signup-item', rowData, rowIndex)"><i class="fa fa-edit fa-lg"></i></a> -->
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
      itemAction (action, data, index) {
        console.log('custom-actions: ' + action, data.subject, index)
        window.location.href = '/event/'+data.id;
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
