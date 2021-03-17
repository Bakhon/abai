<template>
  <div class="user-profile">
    <div class="user-profile__top">
      <button class="bkgEditButton">Обложка профиля</button>
      <div class="user-profile__top-avatar">
        <img :src="user.profile.thumb || '/img/level1/icon_user.svg'">
      </div>
      <p class="user-profile__top-welcome">{{ trans('profile.welcome') }}, <b>{{ user.username }}!</b></p>
      <ul class="user-profile__top-menu">
        <li
            v-for="(tab, code) in tabs"
            :class="{'active': activeTab === code}"
            class="user-profile__top-menu-item"
            @click="activeTab = code"
        >
          <a href="#">
            <span v-html="tab.ico"></span>
            <span>{{ trans(tab.name) }}</span>
          </a>
        </li>
      </ul>
    </div>
    <div class="user-profile__bottom">
      <div class="user-profile__tab">
        <template v-if="activeTab === 'profile'">
          <div class="container-fluid defaultPadding">
            <div class="row">
              <div class="col-sm-6 defaultPadding">
          <div class="user-profile__tab-block">
            <p class="user-profile__tab-block-title">{{ trans('profile.main_info') }}</p>
            <div class="user-profile__tab-field-row">
              <profile-field :field="fields.name" :value="user.name"></profile-field>
              <profile-field :field="fields.birthday" :value="user.profile.birthday"></profile-field>
            </div>
            <div class="user-profile__tab-field-row">
              <profile-field :field="fields.gender" :value="user.profile.gender"></profile-field>
              <profile-field :field="fields.city" :value="user.profile.city"></profile-field>
            </div>
            <div class="user-profile__tab-field-row">
              <profile-field :field="fields.position" :value="user.profile.position"></profile-field>
              <profile-field :field="fields.org" :value="user.profile.org"></profile-field>
            </div>
            <div class="user-profile__tab-field-row">
              <profile-field :field="fields.department" :value="user.profile.department"></profile-field>
              <profile-field :field="fields.sector" :value="user.profile.sector"></profile-field>
            </div>
            <div class="user-profile__tab-field-row">
              <profile-field :field="fields.boss" :value="user.profile.boss"></profile-field>
            </div>
          </div>
              </div>
          <div class="col-sm-6 defaultPadding">
          <div class="user-profile__tab-block">
            <p class="user-profile__tab-block-title">{{ trans('profile.contact_info') }}</p>
            <div class="user-profile__tab-field-row">
              <profile-field :field="fields.phone" :value="user.profile.phone"></profile-field>
              <profile-field :field="fields.cabinet" :value="user.profile.cabinet"></profile-field>
            </div>
            <div class="user-profile__tab-field-row">
              <profile-field :field="fields.mobile" :value="user.profile.mobile"></profile-field>
              <profile-field :field="fields.email" :value="user.profile.email"></profile-field>
            </div>
            <div class="user-profile__tab-field-row">
              <profile-field :field="fields.phone_work" :value="user.profile.phone_work"></profile-field>
            </div>
          </div>
          </div>
            </div>
          </div>
        </template>

        <template v-else-if="activeTab === 'notifications'">
            <notifications-profile></notifications-profile>
        </template>

        <template v-else-if="activeTab === 'access'">
            <access-profile :modules="modules" :other_modules="other_modules" :accesses="accesses"></access-profile>
        </template>

        <template v-else-if="activeTab === 'history'">
            <history-profile :logs="logs"></history-profile>
        </template>

        <template v-else-if="activeTab === 'settings'">
            <settings-profile :user="user"></settings-profile>
        </template>

      </div>
    </div>
  </div>
</template>

<script>
import ProfileField from './Field'
import SettingsProfile from './tabs/Settings'
import HistoryProfile from './tabs/History'
import AccessProfile from './tabs/Access'
import NotificationsProfile from './tabs/Notifications'
import params from '../../json/profile.json'

export default {
  name: "profile",
  props: {
    user: {
      type: Object,
      required: true
    },
    logs: {
      type: Array,
      required: true
    },
    modules: {
      type: Array,
      required: true
    },
    other_modules: {
      type: Array,
      required: true
    },
    accesses: {
      type: Array,
      required: true
    },
  },
  components: {
    ProfileField,
    SettingsProfile,
    HistoryProfile,
    AccessProfile,
    NotificationsProfile
  },
  data() {
    return {
      fields: params.fields,
      tabs: params.tabs,
      icons: params.icons,
      activeTab: 'profile'
    }
  },
  methods: {}
}
</script>