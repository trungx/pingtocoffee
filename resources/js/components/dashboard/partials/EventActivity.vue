<template>
  <div class="entry-item relative pv2 ph3 hover-bg-washed-blue">
    <div class="info" v-html="event.body"></div>
    <div class="mv1">
      <i :class="event.icon_class" class="mr-2"></i>
      <span class="f7 light-gray-text">{{ log.date }}</span>
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        event: []
      };
    },
        
    props: ['log'],
        
    mounted() {
      this.prepareComponent();
    },
        
    methods: {
      prepareComponent() {
        this.event = this.log.object;
      }
    }
  }
</script>
