<template>
  <div>
    <full-calendar
      :events="events"
      defaultView="month"
      :editable="false"
      >
    </full-calendar>
  </div>
</template>

<script>
import { commonMixins } from "../../mixins/common";
import { FullCalendar } from 'vue-full-calendar'
import 'fullcalendar/dist/fullcalendar.css';

export default {
  name: 'EventsCalendar',
  mixins: [commonMixins],
  components: {
    FullCalendar,
  },
  props: {
    eventDates: { type: Array, required: true },
  },
  data() {
    return {
      ready: false,
      events: [],
    };
  },
  mounted: function() {
    this.eventDates.forEach( (d)=> {
      const event = {
        title: d.subject,
        url: '/event/'+ d.id,
        start: d.date_start,
        end: d.date_end
      };
      this.events.push(event);
    })
    this.$nextTick(function() {
      this.ready = true;
    });
  },
  updated: function() {
    // console.log('dom updated')
  },
  computed: {
  },
  watch: {
  },
  methods: {
  } //End of methods
}; //End of export
</script>

<style lang="css" scoped>

</style>
