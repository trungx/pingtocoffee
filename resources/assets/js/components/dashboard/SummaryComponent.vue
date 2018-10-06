<template>
  <div class="bg-white br2 pa3" style="box-shadow: 0 1px 1px #ccc;">
    <ul class="nav nav-tabs" role="tablist">
      <li class="nav-item">
        <a @click.prevent="setActiveTab('logs')" :class="[activeTab === 'logs' ? 'nav-link show active' : 'nav-link']" data-toggle="tab" href="#logs">Recents</a>
      </li>
      <li class="nav-item">
        <a @click.prevent="setActiveTab('reminders')" :class="[activeTab === 'reminders' ? 'nav-link show active' : 'nav-link']" data-toggle="tab" href="#reminders">Next Reminders</a>
      </li>
    </ul>
    <div class="tab-content">
      <div :class="[activeTab === 'logs' ? 'tab-pane fade show active' : 'tab-pane fade']" id="logs">
        <div class="pt3">
          <!--Loading spinner-->
          <div v-if="contactLogsLoading" class="tc pv3">
            <div class="m-auto" style="width:20px;">
              <half-circle-spinner
                :animation-duration="1000"
                :size="15"
                color="#808080"
              />
            </div>
          </div>

          <!--Empty state-->
          <div v-if="!contactLogsLoading && contactLogs.length === 0" class="tc light-gray-text">
            <div class="f5 mv2 b">{{ __('user.contact_logs_oops') }}</div>
            <div class="f6 mv2">{{ __('user.contact_logs_empty_state') }}</div>
          </div>
          
          <ul v-if="!contactLogsLoading && contactLogs.length !== 0" class="relative list pl3">
            <li v-for="contactLog in contactLogs" :key="contactLog.id" class="pt2 pb2">
              <a :href="'/' + contactLog.contact_username + '?tab=contact-logs'">
                <i :class="contactLog.log_icon_class" class="light-gray-text mr3"></i>{{ contactLog.contact_name }}
              </a>
              <span class="fr light-gray-text" :title="contactLog.full_contact_time">{{ contactLog.contact_time }}</span>
            </li>
          </ul>
        </div>
      </div>
      <div :class="[activeTab === 'reminders' ? 'tab-pane fade show active' : 'tab-pane fade']" id="reminders">
        <div class="pt3">
          <!--Loading spinner-->
          <div v-if="remindersLoading" class="tc pv3">
            <div class="m-auto" style="width:20px;">
              <half-circle-spinner
                :animation-duration="1000"
                :size="15"
                color="#808080"
              />
            </div>
          </div>

          <!--Empty state-->
          <div v-if="!remindersLoading && reminders.length === 0" class="tc light-gray-text">
            <div class="f5 mv2 b">{{ __('user.reminder_oops') }}</div>
            <div class="f6 mv2">{{ __('user.reminder_empty_state') }}</div>
          </div>

          <ul v-if="!remindersLoading && reminders.length !== 0" class="pa0 relative list">
            <li v-for="reminder in reminders" :key="reminder.id" class="mb3 relative pa2 pl3 br1" style="border: 1px solid #dee2e6;">
              <p>{{ reminder.title }}</p>
              <div class="f7 light-gray-text">
                <a :href="'/' + reminder.contact_username + '?tab=reminders'">{{ reminder.contact_name }}</a> - <span :title="reminder.full_next_expected_date">{{ reminder.next_expected_date }}</span><a :href="'/contact/' + reminder.contact_id + '/reminder/' + reminder.id" class="fr">{{ __('user.edit') }}</a>
              </div>
            </li>
          </ul>
        </div>
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

    data() {
      return {
        activeTab: '',
        contactLogsLoading: true,
        contactLogsAlreadyLoaded: false,
        remindersLoading: true,
        remindersAlreadyLoaded: false,
        contactLogs: [],
        reminders: [],
      };
    },
  
    mounted() {
      this.prepareComponent();
    },
    
    props: ['defaultActiveTab'],
    
    methods: {
      prepareComponent() {
        this.setActiveTab(this.defaultActiveTab);
      },
      
      setActiveTab(tab) {
        this.activeTab = tab;
        
        if (tab === 'logs' && !this.contactLogsAlreadyLoaded) {
          this.getContactLogs();
          this.contactLogsAlreadyLoaded = true;
        }
        
        if (tab === 'reminders' && !this.remindersAlreadyLoaded) {
          this.getNextReminders();
          this.remindersAlreadyLoaded = true;
        }
      },
      
      getContactLogs() {
        axios.get('/dashboard/summary/logs')
          .then(response => {
            this.contactLogs = response.data;
            this.contactLogsLoading = false;
          });
      },
  
      getNextReminders() {
        axios.get('/dashboard/summary/reminders')
          .then(response => {
            this.reminders = response.data;
            this.remindersLoading = false;
          });
      }
    }
  }
</script>
