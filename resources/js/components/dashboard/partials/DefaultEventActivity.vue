<template>
  <div class="entry-item relative pv2 ph3 ba b--black-10 hover-bg-washed-blue">
    <div class="info">{{ defaultEvent.body }}</div>
    <div class="mv1">
      <i :class="defaultEvent.icon_class" class="mr-2"></i>
      <span class="f7 light-gray-text" :title="log.full_datetime">{{ log.datetime }}</span>
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        defaultEvent: []
      };
    },

    props: ['log'],

    mounted() {
      this.prepareComponent();
    },

    methods: {
      prepareComponent() {
        this.defaultEvent = this.log.object;
      }
    }
  }
</script>
