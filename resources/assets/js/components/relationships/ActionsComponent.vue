<template>
  <div class="actions" v-if="userId !== authenticatedUserId">
    <a v-if="type === 'none'" @click="addRelationship(userId)" href="javascript:void(0)" class="btn default-btn pv1 ph3 b w-100">
      <i class="fa fa-user-plus mr-2"></i>{{ __('user.add_cta') }}
    </a>
    
    <div class="dropdown" v-if="(type === 'pending_first_second' && authenticatedUserId < userId) || (type === 'pending_second_first' && authenticatedUserId > userId)">
      <button class="btn default-btn pv1 ph3 b dropdown-toggle w-100"
              type="button" data-toggle="dropdown"
              aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-user-times mr-2"></i>{{ __('user.waiting_status') }}
      </button>
      <div class="dropdown-menu w-100">
        <a class="dropdown-item" href="javascript:void(0)" @click="cancel(userId)">
          {{ __('user.cancel_request_cta') }}
        </a>
      </div>
    </div>
    
    <div class="dropdown" v-if="(type === 'pending_first_second' && authenticatedUserId > userId) || (type === 'pending_second_first' && authenticatedUserId < userId)">
      <button class="btn default-btn pv1 ph3 b dropdown-toggle w-100"
              type="button" data-toggle="dropdown" aria-haspopup="true"
              aria-expanded="false">
        <i class="fa fa-exclamation-circle mr-2"></i>{{ __('user.confirm_status') }}
      </button>
      <div class="dropdown-menu w-100">
        <a class="dropdown-item" href="javascript:void(0)" @click="accept(userId)">{{ __('user.accept_cta') }}</a>
        <a class="dropdown-item" href="javascript:void(0)" @click="decline(userId)">{{ __('user.decline_cta') }}</a>
      </div>
    </div>
    
    <div class="dropdown" v-if="type === 'friends'">
      <button class="btn default-btn pv1 ph3 b dropdown-toggle w-100"
              type="button" data-toggle="dropdown"
              aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-user-check mr-2"></i>{{ __('user.friends_status') }}
      </button>
      <div class="dropdown-menu w-100">
        <a class="dropdown-item" href="javascript:void(0)" @click="cancel(userId)">{{ __('user.unfriend_cta') }}</a>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        type: 'none'
      };
    },
    
    mounted() {
      this.prepareComponent();
    },
    
    props: ['userId', 'authenticatedUserId', 'defaultType'],
    
    methods: {
      prepareComponent() {
        this.setType(this.defaultType);
      },
      
      setType(type) {
        this.type = type;
      },
      
      addRelationship(userId) {
        axios.post('/relationships/' + userId + '/add')
        .then(response => {
          this.setType(response.data.type);
        });
      },
      
      cancel(userId) {
        axios.post('/relationships/' + userId + '/cancel')
        .then(response => {
          this.setType(response.data.type);
        });
      },
      
      accept(userId) {
        axios.post('/relationships/' + userId + '/accept')
        .then(response => {
          this.setType(response.data.type);
        });
      },
      
      decline(userId) {
        axios.post('/relationships/' + userId + '/decline')
        .then(response => {
          this.setType(response.data.type);
        });
      },
    }
  }
</script>
