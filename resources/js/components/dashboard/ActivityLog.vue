<template>
  <div class="bg-white br2 pa3" style="box-shadow: 0 1px 1px #ccc;">
    <div class="mb2 f4 fw6">{{ __('dashboard.feed_heading') }}</div>
    <!--Loading spinner-->
    <div v-if="feedsLoading" class="tc pv3">
      <div class="m-auto" style="width:20px;">
        <half-circle-spinner
          :animation-duration="1000"
          :size="15"
          color="#808080"
        />
      </div>
    </div>
    <ul class="entry-list list ma0 pa0 relative">
      <li v-for="feed in feeds.data" class="relative">
        <div v-if="feed.show_calendar" class="pa2 b light-gray-text absolute" style="top:-22px;left:16px;">
          {{ feed.object.calendar }}
        </div>
        <event-activity :feed="feed" v-if="feed.feedable_type == 'App\\Event'"></event-activity>
        <default-event-activity :feed="feed" v-if="feed.feedable_type == 'App\\DefaultEvent'"></default-event-activity>
      </li>
    </ul>
    <div class="load-more tc" v-if="shouldShowLoadMore">
      <button v-if="!loadingMore" @click="loadMore()" class="btn default-btn fw6 pv1 ph3 mv2 br4">{{ __('dashboard.load_more') }}</button>
      <button v-else class="btn default-btn fw6 pv1 ph3 mv2 br4 disabled">{{ __('dashboard.loading') }}</button>
    </div>
  </div>
</template>

<script>
  import { HalfCircleSpinner } from 'epic-spinners'
  export default {
    components: {
      HalfCircleSpinner
    },

    data() {
      return {
        feeds: [],
        loadingMore: false,
        feedsLoading: true,
      };
    },

    computed: {
      shouldShowLoadMore: function() {
        let total = this.feeds.per_page * this.feeds.current_page;
        return total < this.feeds.total;
      }
    },

    mounted() {
      this.prepareComponent();
    },

    methods: {
      prepareComponent() {
        this.getTimelines();
      },

      getTimelines() {
        axios.get('/activity-log')
          .then(response => {
            this.feeds = response.data;
            this.feeds.current_page = response.data.current_page;
            this.feeds.next_page_url = response.data.next_page_url;
            this.feeds.per_page = response.data.per_page;
            this.feeds.prev_page_url = response.data.prev_page_url;
            this.feeds.total = response.data.total;
            this.feedsLoading = false;
          });
      },

      loadMore() {
        this.loadingMore = true;
        axios.get('/activity-log?page=' + (this.feeds.current_page + 1))
          .then(response => {
            this.feeds.current_page = response.data.current_page;
            this.feeds.next_page_url = response.data.next_page_url;
            this.feeds.per_page = response.data.per_page;
            this.feeds.prev_page_url = response.data.prev_page_url;
            this.feeds.total = response.data.total;

            for (let i of response.data.data) {
              this.feeds.data.push(i);
            }

            this.loadingMore = false;
          });
      }
    }
  }
</script>
