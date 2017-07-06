partdata<template>
    <div class="">
        <div class="container-fluid">
            <div class="col-md-6 panel panel-default">
                <div class="panel-heading text-center">
                    Overall Participation Rate
                </div>
                <div class="panel-body">
                    <pie-chart id="p1" :data="partdata"
                        :labels="partlabels"
                        :bgColors="partBGColors"
                        :hoverBGColors="partHoverBGColors"
                        :options="partoptions">
                    </pie-chart>
                </div>
            </div>
            <div class="col-md-6 panel panel-default">
                <div class="panel-heading text-center">
                    Relative Proportion of Event Types
                </div>
                <div class="panel-body">
                    <doughnut-chart id="d1" :data="doughnutdata1"
                        :labels="doughnutlabels1"
                        :bgColors="doughnutBGColors1"
                        :hoverBGColors="doughnutHoverBGColors1"
                        :options="doughnutoptions1">
                    </doughnut-chart>
                </div>
            </div>
            <div class="col-md-6 panel panel-default">
                <div class="panel-heading text-center">
                    Year-To-Date Events Per Month
                </div>
                <div class="panel-body">
                    <bar-chart id="b1" :datasets="bardata1"
                        :labels="barlabels1"
                        :options="baroptions1">
                    </bar-chart>
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
  mounted () {
    console.log("mounted.")
    axios('/db')
    .then(response => {
      this.bar1(response.data.EventTypesOverTime);
      this.doughnut1(response.data.TotalByType);
      this.participation(response.data.ParticpationRate);
    })
    .catch(e => {
      console.log(e);
    })

  },
  methods: {
    participation(data) {
    // pie chart
      this.partlabels = ['Yes', 'No', 'NoReply'];
      this.partdata = [data.yes, data.no, data.noreply];
      this.partBGColors = [
                "rgba(0, 255, 0, 0.7)",
                "rgba(225, 58, 55, 0.7)",
                "rgba(255, 255, 0, 0.7)"];
      this.partoptions = {
        responsive: true,
        maintainAspectRatio: false,
        legend: {
          position: 'bottom'
        }
      };
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
