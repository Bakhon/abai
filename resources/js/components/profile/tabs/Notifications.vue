<template>
  <div class="container-fluid defaultPadding">
    <div class="row">
      <div class="col-sm-4 defaultPadding">
        <main-notifications-profile></main-notifications-profile>
      </div>
      <div class="col-sm-4 defaultPadding">
        <news-notifications-profile></news-notifications-profile>
      </div>
      <div class="col-sm-4 defaultPadding">
        <modules-notifications-profile></modules-notifications-profile>
      </div>
    </div>
  </div>
</template>

<script>
import NewsNotificationsProfile from './notifications-tabs/NewsNotifications'
import ModulesNotificationsProfile from './notifications-tabs/ModulesNotifications'
import MainNotificationsProfile from './notifications-tabs/MainNotifications'

export default {
  name: 'NotificationsProfile',
  props: {
  },
  components: {
    NewsNotificationsProfile,
    ModulesNotificationsProfile,
    MainNotificationsProfile
  },
  data() {
    return {
    }
  },
  methods: {}
}
</script>