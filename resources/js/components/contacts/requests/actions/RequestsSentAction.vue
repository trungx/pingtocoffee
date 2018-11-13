<template>
  <div class="absolute" style="right: 0; top: 50%; margin-top: -14px;">
    <!-- Send Friend Request -->
    <button v-if="contact.state === 'canceled'" class="btn default-btn fw6 btn-sm f7" @click="add(contact.id)">
      {{ __('user.add_cta') }}
    </button>

    <!-- Remove User -->
    <button v-if="contact.state === 'canceled'" class="btn btn-sm btn-link light-gray-text f7" @click="remove()">
      {{ __('user.remove_cta') }}
    </button>

    <!-- Cancel Request -->
    <button v-if="contact.state === 'requestSent'" class="btn btn-sm btn-link light-gray-text f7" @click="cancel(contact.id)">
      {{ __('user.cancel_cta') }}
    </button>
  </div>
</template>

<script>
  export default {
    props: ["contact"],

    methods: {
      add(contactId) {
        axios.post('/relationships/' + contactId + '/add')
          .then(response => {
            this.contact.state = 'requestSent';
          });
      },

      remove() {
        this.contact.state = 'removed';
      },

      cancel(contactId) {
        axios.post('/relationships/' + contactId + '/cancel')
          .then(response => {
            this.contact.state = 'canceled';
          });
      },
    }
  }
</script>
