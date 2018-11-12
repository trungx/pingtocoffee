<template>
  <div class="bg-white br2 pa3 z-0" style="box-shadow: 0 1px 1px #ccc;">
    <div class="mb2 f4 fw6">{{ __('dashboard.feed_heading') }}</div>

    <!--Loading spinner-->
    <div v-if="loading" class="tc pv3">
      <div class="m-auto" style="width:20px;">
        <half-circle-spinner
          :animation-duration="1000"
          :size="15"
          color="#808080"
        />
      </div>
    </div>

    <div class="entry-milestone relative mb3" style="padding-left: 3rem;">
      <div v-for="activityLogObject in activityLogsData.data">
        <div class="milestone mt3 mb2 black-60">
          <svg class="icon mr3" viewBox="0 0 14 16" version="1.1" width="14" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M10.86 7c-.45-1.72-2-3-3.86-3-1.86 0-3.41 1.28-3.86 3H0v2h3.14c.45 1.72 2 3 3.86 3 1.86 0 3.41-1.28 3.86-3H14V7h-3.14zM7 10.2c-1.22 0-2.2-.98-2.2-2.2 0-1.22.98-2.2 2.2-2.2 1.22 0 2.2.98 2.2 2.2 0 1.22-.98 2.2-2.2 2.2z"></path></svg>{{ activityLogObject.logDate }}
        </div>

        <ol v-for="log in activityLogObject.logData" class="entry-list list ma0 pa0 relative">
          <li>
            <event-activity :log="log" v-if="log.feedable_type == 'App\\Event'"></event-activity>
            <default-event-activity :log="log" v-if="log.feedable_type == 'App\\DefaultEvent'"></default-event-activity>
          </li>
        </ol>
      </div>
    </div>

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
        activityLogsData: [],
        loadingMore: false,
        loading: true,
      };
    },

    computed: {
      shouldShowLoadMore: function() {
        let total = this.activityLogsData.per_page * this.activityLogsData.current_page;
        return total < this.activityLogsData.total;
      }
    },

    mounted() {
      this.prepareComponent();
    },

    methods: {
      prepareComponent() {
        this.getActivityLogs();
      },

      getActivityLogs() {
        axios.get('/activity-log')
          .then(response => {
            this.activityLogsData = response.data;
            this.activityLogsData.current_page = response.data.current_page;
            this.activityLogsData.next_page_url = response.data.next_page_url;
            this.activityLogsData.per_page = response.data.per_page;
            this.activityLogsData.prev_page_url = response.data.prev_page_url;
            this.activityLogsData.total = response.data.total;
            this.loading = false;
          });
      },

      loadMore() {
        this.loadingMore = true;
        axios.get('/activity-log?page=' + (this.activityLogsData.current_page + 1))
          .then(response => {
            this.activityLogsData.current_page = response.data.current_page;
            this.activityLogsData.next_page_url = response.data.next_page_url;
            this.activityLogsData.per_page = response.data.per_page;
            this.activityLogsData.prev_page_url = response.data.prev_page_url;
            this.activityLogsData.total = response.data.total;

            for (let i of response.data.data) {
              this.activityLogsData.data.push(i);
            }

            this.loadingMore = false;
          });
      }
    }
  }
</script>
