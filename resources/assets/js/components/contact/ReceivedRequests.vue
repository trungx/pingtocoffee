<template>
  <div class="sidebar relative pa3 bg-white mb-3 br2">
    <div class="db mb2">
      <h6 class="light-gray-text dib fw6">{{ __('user.received_requests_title') }}</h6>
      <a v-if="enableSeeAll" href="/contacts/requests" class="dib fr">{{ __('user.see_all') }}</a>
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
        <li v-for="contact in receivedRequests" :key="contact.id" class="pv2">
          <div class="fl">
            <a :href="'/' + contact.username" class="mb-1 dib">
              <img :src="contact.avatar" v-if="contact.avatar" class="mr-2" width="30">
              <div v-if="contact.initials" class="default-avatar mr-2" :style="{backgroundColor: contact.default_avatar_color}" style="width:30px; height:30px; font-size:10px; padding-top:7px;">{{ contact.initials }}</div><span>{{ contact.first_name }}</span>
            </a>
          </div>
          <!-- Actions -->
          <div class="fr dib">
            <!-- Accept Friend Request -->
            <button v-if="contact.state === 'none'" class="btn btn-sm item default-btn b f7" @click="accept(contact.id)">
              {{ __('user.accept_cta') }}
            </button>

            <!-- Decline Friend Request -->
            <button v-if="contact.state === 'none'" class="btn btn-sm btn-link light-gray-text f7" @click="decline(contact.id)">
              {{ __('user.decline_cta') }}
            </button>

            <!-- Block User -->
            <button v-if="contact.state === 'declined'" class="btn btn-sm item btn-link light-gray-text f7" @click="block(contact.id)">
              {{ __('user.block_cta') }}
            </button>

            <!-- Friends Status -->
            <div v-if="contact.state === 'accepted'" class="pv1 ph2 br1 bg-lightest-blue f7">
              <i class="fa fa-user-check mr-2"></i>{{ __('user.friends_status') }}
            </div>

            <!-- Blocked Status -->
            <div v-if="contact.state === 'blocked'" class="pv1 ph2 br1 bg-black-10 f7">
              <i class="fas fa-ban mr-2"></i>{{ __('user.blocked_status') }}
            </div>
          </div>
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
        enableSeeAll: false,
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
        axios.get('/relationships/received-requests')
        .then(response => {
          this.enableSeeAll = response.data.enableSeeAll;
          this.receivedRequests = response.data.receivedRequests;
          this.loading = false;
        });
      },
      
      accept(userId) {
        axios.post('/relationships/' + userId + '/accept')
        .then(response => {
          let contact = this.receivedRequests.find(contact => contact.id === userId);
          contact.state = 'accepted';
        });
      },
      
      decline(userId) {
        axios.post('/relationships/' + userId + '/decline')
        .then(response => {
          let contact = this.receivedRequests.find(contact => contact.id === userId);
          contact.state = 'declined';
        });
      },

      block(userId) {
        axios.post('/relationships/' + userId + '/block')
        .then(response => {
          let contact = this.receivedRequests.find(contact => contact.id === userId);
          contact.state = 'blocked';
        });
      },
    }
  }
</script>
