<template>
  <div class="entry-item relative mv4 ml4 pv2 ph3 br3">
    <span></span>
    <div class="info" v-html="event.body"></div>
    <div class="mv1">
      <i :class="event.icon_class" class="mr-2"></i>
      <span class="f7 light-gray-text" :title="feed.full_datetime">{{ feed.datetime }}</span>
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
        
    props: ['feed'],
        
    mounted() {
      this.prepareComponent();
    },
        
    methods: {
      prepareComponent() {
        this.event = this.feed.object;
      }
    }
  }
</script>
