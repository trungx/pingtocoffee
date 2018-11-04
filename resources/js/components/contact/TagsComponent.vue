<template>
  <div class="section pt3">
    <div class="f5 mb3">{{ __('user.tags') }}</div>

    <div v-if="editable" class="mb2">
      <input-tag v-model="tags"></input-tag>

      <div class="mv2">
        <a href="javascript:void(0);" class="default-btn b pv1 ph3 mr2" @click="save()">
          {{ __('user.tags_save') }}
        </a>
        <a href="javascript:void(0);" class="btn-link light-gray-text" @click="cancel()">
          {{ __('user.tags_cancel') }}
        </a>
      </div>
    </div>

    <ul v-if="!editable" class="tags f7">
      <li v-for="tag in tags">
        <a :href="'/contacts?tag=' + tag" class="tag">{{ tag }}</a>
      </li>
      <li>
        <a v-if="tags.length === 0" href="javascript:void(0);" class="edit-tag-link underline" @click="turnOnEdit()">
          {{ __('user.tags_add_cta') }}
        </a>
        <a v-else href="javascript:void(0);" class="edit-tag-link underline" @click="turnOnEdit()">
          {{ __('user.tags_edit_cta') }}
        </a>
      </li>
    </ul>
  </div>
</template>

<script>
  import InputTag from 'vue-input-tag'

  export default {
    components: {
      InputTag
    },

    data () {
      return {
        editable: false,
        tags: [],
      };
    },

    mounted() {
      this.prepareComponent();
    },

    props: ['userId'],

    methods: {
      prepareComponent() {
        this.getTags();
      },

      getTags() {
        axios.get('/' + this.userId + '/tags')
          .then(response => {
            this.tags = response.data.tags;
          })
      },

      save() {
        axios.post('/' + this.userId + '/tags', {
          tags: this.tags
        })
          .then(response => {
            this.turnOffEdit();
            this.tags = response.data.tags;
          })
      },

      cancel() {
        this.turnOffEdit();

        // Return the tasks back to it's previous state
        this.tags = this._beforeEditingCache;
      },

      turnOnEdit() {
        this.editable = true;

        // Keep track of the original tags information
        this._beforeEditingCache = this.tags;
      },

      turnOffEdit() {
        this.editable = false;
      },
    }
  }
</script>
