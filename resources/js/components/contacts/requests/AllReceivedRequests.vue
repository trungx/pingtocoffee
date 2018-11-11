<template>
  <div class="sidebar relative pa3 bg-white mb-3 br2">
    <div class="db mb2">
      <h6 class="light-gray-text dib fw6">{{ __('user.received_requests_title') }}</h6>
      <a href="/contacts/requests?outgoing=1" class="db dib-ns fn fr-ns gray-text">{{ __('user.view_requests_sent') }}</a>
    </div>
    <div class="content">
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

      <!-- Exist request -->
      <ul v-if="!loading && receivedRequests.length > 0" class="list pa0 ma0">
        <li v-for="contact in receivedRequests" :key="contact.id" class="pv2 mb2 relative">
          <div class="fl">
            <a :href="'/' + contact.username" class="dib">
              <img :src="contact.avatar" v-if="contact.avatar" class="mr-2 br-100" style="width: 42px;">
              <div v-if="contact.initials" class="default-avatar mr-2 br-100" :style="{backgroundColor: contact.default_avatar_color}" style="width:42px; height:42px; line-height: 42px;">{{ contact.initials }}</div><span>{{ contact.first_name }}</span>
            </a>
          </div>

          <!-- Actions -->
          <received-requests-action :contact="contact"></received-requests-action>
        </li>
      </ul>

      <!-- Empty request -->
      <div v-if="!loading && receivedRequests.length === 0" class="tc mv3">
        <div class="f6 light-gray-text">{{ __('user.empty_received_requests') }}</div>
      </div>
    </div>
  </div>
</template>

<script>
  import { HalfCircleSpinner } from 'epic-spinners'
  export default {
    components: {
      HalfCircleSpinner
    },

    data () {
      return {
        loading: true,
        receivedRequests: [],
      };
    },

    mounted() {
      this.prepareComponent();
    },

    props: [],

    methods: {
      prepareComponent() {
        this.getReceivedRequestsData();
      },

      getReceivedRequestsData() {
        axios.get('/contacts/all-received-requests')
          .then(response => {
            this.receivedRequests = response.data.receivedRequests;
            this.loading = false;
          });
      },
    }
  }
</script>
