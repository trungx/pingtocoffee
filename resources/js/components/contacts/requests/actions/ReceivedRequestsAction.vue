<template>
  <div class="fr dib">
    <!-- Accept Friend Request -->
    <button v-if="contact.state === 'none'" class="btn btn-sm item default-btn fw6 f7" @click="accept(contact.id)">
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
</template>

<script>
  export default {
    props: ["contact"],

    methods: {
      accept(userId) {
        axios.post('/relationships/' + userId + '/accept')
          .then(response => {
            this.contact.state = 'accepted';
          });
      },

      decline(userId) {
        axios.post('/relationships/' + userId + '/decline')
          .then(response => {
            this.contact.state = 'declined';
          });
      },

      block(userId) {
        axios.post('/relationships/' + userId + '/block')
          .then(response => {
            this.contact.state = 'blocked';
          });
      },
    }
  }
</script>
