<template>
  <div class="container-fluid">
  <div class="row mt-5">
      <div class="mx-auto">
          <div class="card">
              <div class="card-body text-center">
                   <h1>How are we doing?</h1>
                  <div class="form-group">
                      <filter-memberships :userid="userid" @orgteamselected="get_data"></filter-memberships>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <div class="card-group">
    <div class="card">
        <div class="card-header text-center">Overall Participation Rate</div>
        <div class="card-body">
            <pie-chart id="p1" :data="partdata" :labels="partlabels" :bg-colors="partBGColors"
            :hover-bg-colors="partHoverBGColors" :options="partoptions"></pie-chart>
        </div>
    </div>
    <div class="card">
        <div class="card-header text-center">Year-To-Date Count Per Event Type</div>
        <div class="card-body">
            <doughnut-chart id="d1" :data="doughnutdata1" :labels="doughnutlabels1"
            :bg-colors="doughnutBGColors1" :hover-bg-colors="doughnutHoverBGColors1" :options="doughnutoptions1"></doughnut-chart>
        </div>
    </div>
    <div class=" card">
        <div class="card-header text-center">Year-To-Date Events Per Month</div>
        <div class="card-body">
            <bar-chart id="b1" :datasets="bardata1" :labels="barlabels1" :options="baroptions1"></bar-chart>
        </div>
    </div>
  </div>
</div>
</template>

<script>
import BarChart from './bar'
import DoughnutChart from './doughnut'
import PieChart from './pie'
Vue.component('bar-chart', BarChart)
Vue.component('pie-chart', PieChart)
Vue.component('doughnut-chart', DoughnutChart)
export default {
  data () {
    return {
      bardata1: [],
      barlabels1: [],
      baroptions1: {},

      doughnutdata1: [],
      doughnutlabels1: [],
      doughnutBGColors1: [],
      doughnutHoverBGColors1: [],
      doughnutoptions1: {},

      partdata: [],
      partlabels: [],
      partBGColors: [],
      partHoverBGColors: [],
      partoptions: {},
    }
  },
  props: {
    userid: {
      type: Number,
      required: false
    }
  },
  mounted () {
    this.get_data(null,null);
  },
  methods: {
    get_data(selectedOrgId, selectedTeamId) {
       console.log(selectedOrgId, selectedTeamId)
      let params = {
          orgid: selectedOrgId,
          teamid: selectedTeamId
      }
      axios.get('/api/dashboard', {params: params})
      .then(response => {
        this.bar1(response.data.EventTypesOverTime);
        this.doughnut1(response.data.TotalByType);
        this.participation(response.data.ParticpationRate);
      })
      // axios.get('/api/db?q=ETOT', {params: params})
      // .then(response => {
      //   this.bar1(response.data.EventTypesOverTime);
      // })
      // .catch(e => {
      //   console.log(e);
      // })
      // axios.get('/api/db?q=TBT', {params: params})
      // .then(response => {
      //   this.doughnut1(response.data.TotalByType);
      // })
      // .catch(e => {
      //   console.log(e);
      // })
      // axios.get('/api/db?q=PR', {params: params})
      // .then(response => {
      //   this.participation(response.data.ParticpationRate);
      // })
      // .catch(e => {
      //   console.log(e);
      // })

    },
    participation(data) {
    // pie chart
      this.partlabels = ['Yes', 'No', 'NoReply'];
      this.partBGColors = [
                "rgba(0, 255, 0, 0.7)",
                "rgba(225, 58, 55, 0.7)",
                "rgba(255, 255, 0, 0.7)"];
      this.partoptions = {
        responsive: true,
        maintainAspectRatio: false,
        tooltips: {
          callbacks: {
            label: function(tooltipItem, data) {
                let index = tooltipItem['index'];
                let lbl = data.labels[index];
                let val = data.datasets[0].data[index];
                return lbl + ': ' + val + '%';
            }
          }
        },
        legend: {
          position: 'bottom'
        },
          pieceLabel: {
            // mode 'label', 'value' or 'percentage', default is 'percentage'
            mode: 'value',
            // precision for percentage, default is 0
            precision: 0,
            //identifies whether or not labels of value 0 are displayed, default is false
            showZero: true,
            // font size, default is defaultFontSize
            fontSize: 16,
            // font color, default is '#fff'
            fontColor: '#000',
            // font style, default is defaultFontStyle
            fontStyle: 'normal',
            // font family, default is defaultFontFamily
            fontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
            // draw label in arc, default is false
            arc: false,
            // position to draw label, available value is 'default', 'border' and 'outside'
            // default is 'default'
            position: 'border',
            // format text, work when mode is 'value'
            format: function (value) {
            return value + '%';
            }
          }
      };
      this.partdata = [data.yes, data.no, data.noreply];
    },
    doughnut1(data) {
        this.doughnutlabels1 = [];
        // this.doughnutoptions1 = {responsive: true,
        //   maintainAspectRatio: false,
        // };
        this.doughnutoptions1 = {
          responsive: true,
          maintainAspectRatio: false,
          legend: {
            position: 'bottom'
          },
        //   pieceLabel is a Chartjs plugin
          pieceLabel: {
            // mode 'label', 'value' or 'percentage', default is 'percentage'
            mode: 'value',
            // precision for percentage, default is 0
            precision: 0,
            //identifies whether or not labels of value 0 are displayed, default is false
            showZero: true,
            // font size, default is defaultFontSize
            fontSize: 18,
            // font color, default is '#fff'
            fontColor: '#000',
            // font style, default is defaultFontStyle
            fontStyle: 'normal',
            // font family, default is defaultFontFamily
            fontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
            // draw label in arc, default is false
            arc: false,
            // position to draw label, available value is 'default', 'border' and 'outside'
            // default is 'default'
            position: 'default',
            // format text, work when mode is 'value'
            format: function (value) {
            return value;
            }
          }
        };
        this.doughnutlabels1.push('Service');
        this.doughnutlabels1.push('Fellowship');
        this.doughnutlabels1.push('LearnTrainGrow');
        this.doughnutBGColors1.push("rgba(55, 160, 225, 0.7)");
        this.doughnutBGColors1.push("rgba(225, 58, 55, 0.7)");
        this.doughnutBGColors1.push("rgba(0, 255, 0, 0.7)");
        this.doughnutdata1.push(data.Service);
        this.doughnutdata1.push(data.Fellowship);
        this.doughnutdata1.push(data.LearnTrainGrow);
      },
    bar1(data) {
          this.barlabels1 = [];
          this.baroptions1 = {
            responsive: true,
            maintainAspectRatio: false,
            tooltips: {
              mode: 'label',
              callbacks: {
                label: function(tooltipItem, data) {
                  return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel;
                }
              }
            },
            scales: {
              xAxes: [{ stacked: true }],
              yAxes: [{ stacked: true }]
            },
            legend: {
              position: 'bottom'
            }
          };
          let ltg = []
          let service = []
          let fellowship = []
          for(var i=0; i<data.length; i++)
          {
            // console.log(data[i]);
            this.barlabels1.push(data[i].interval);
            service.push(data[i].types.Service);
            fellowship.push(data[i].types.Fellowship);
            ltg.push(data[i].types.LearnTrainGrow);
          }
          this.bardata1 = [
            {
                label: 'Service',
                data: service,
                backgroundColor: "rgba(55, 160, 225, 0.7)",
                hoverBackgroundColor: "rgba(55, 160, 225, 0.7)",
                hoverBorderWidth: 2,
                hoverBorderColor: 'lightgrey'
            },
            {
              label: 'Fellowship',
              data: fellowship,
              backgroundColor: "rgba(225, 58, 55, 0.7)",
              hoverBackgroundColor: "rgba(225, 58, 55, 0.7)",
              hoverBorderWidth: 2,
              hoverBorderColor: 'lightgrey'
            },
            {
              label: 'LearnTrainGrow',
              data: ltg,
              backgroundColor: "rgba(0, 255, 0, 0.7)",
              hoverBackgroundColor: "rgba(0, 255, 0, 0.7)",
              hoverBorderWidth: 2,
              hoverBorderColor: 'lightgrey'
            }
          ];

      }
  } //end-methods

}
</script>
