<template>
  <div class="bg-white br2 pa3" style="box-shadow: 0 1px 1px #d9d9d9;">

    <ul class="nav pa2" role="tablist" style="border-bottom: 1px solid #d9d9d9;">
      <li class="nav-item gray-text">
        <a @click.prevent="setActiveTab('logs')" :class="[activeTab === 'logs' ? 'nav-link gray-text show active b' : 'nav-link gray-text']" data-toggle="tab" href="#logs">Recents</a>
      </li>
      <li class="nav-item gray-text">
        <a @click.prevent="setActiveTab('reminders')" :class="[activeTab === 'reminders' ? 'nav-link gray-text show active b' : 'nav-link gray-text']" data-toggle="tab" href="#reminders">Next Reminders</a>
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

          <!--Contact log blank state-->
          <div v-if="!contactLogsLoading && contactLogs.length === 0" class="tc light-gray-text pa3">
            <div class="f5 mv2 b">{{ __('user.contact_logs_oops') }}</div>
            <div class="f6 mv2">{{ __('user.contact_logs_empty_state') }}</div>
          </div>

          <!--Contact log list-->
          <div v-if="!contactLogsLoading && contactLogs.length !== 0" class="pv3 ph3-ns">
            <div v-for="contactLog in contactLogs" :key="contactLog.id" class="mb3 ml2">
              <div class="dib light-gray-text">
                <i :class="contactLog.log_icon_class" class="mr2"></i>
                <span class="light-gray-text" :title="contactLog.full_contact_time">{{ contactLog.contact_time }}</span>
              </div>
              <span class="middotDivider"></span>
              <a :href="'/' + contactLog.contact_username + '?tab=contact-logs'">{{ contactLog.contact_name }}</a>
            </div>
          </div>
        </div>
      </div>

      <div :class="[activeTab === 'reminders' ? 'tab-pane fade show active' : 'tab-pane fade']" id="reminders">
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

        <!--Reminder blank state-->
        <div v-if="!remindersLoading && reminders.length === 0" class="tc light-gray-text p">
          <div class="f5 mv2 b">{{ __('user.reminder_oops') }}</div>
          <div class="f6 mv2">{{ __('user.reminder_empty_state') }}</div>
        </div>

        <!--Reminder list-->
        <div v-if="!remindersLoading && reminders.length !== 0" class="pv3 ph3-ns ml2-ns">
          <div v-for="reminder in reminders" :key="reminder.id" class="mb3 cf">
            <!--Calendar-->
            <div v-if="reminder.show_calendar" class="mb3 b dark-text">{{ reminder.calendar }}</div>

            <div class="tc fl gray-text pt2" style="width:100px;" :title="reminder.full_next_expected_date">
              <i class="fas fa-bell db mb2"></i>{{ reminder.next_expected_date }}
            </div>

            <div style="margin-left:100px;">
              <div class="mb2">{{ reminder.title }}</div>
              <a :href="'/' + reminder.contact_username + '?tab=reminders'" class="f7 light-gray-text">{{ reminder.contact_name }}</a>
            </div>
          </div>
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
