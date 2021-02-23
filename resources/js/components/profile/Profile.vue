<template>
  <div class="user-profile">
    <div class="user-profile__top">
      <div class="user-profile__top-avatar">
        <img :src="user.profile.thumb || 'img/level1/icon_user.svg'">
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
        </template>
        <template v-else-if="activeTab === 'notifications'">

        </template>
        <template v-else-if="activeTab === 'access'">

        </template>
        <template v-else-if="activeTab === 'history'">

        </template>
        <template v-else-if="activeTab === 'settings'">

        </template>
      </div>
    </div>
  </div>
</template>

<script>
import ProfileField from './Field'

export default {
  name: "profile",
  props: {
    user: {
      type: Object,
      required: true
    }
  },
  components: {
    ProfileField
  },
  data() {
    return {
      fields: {},
      tabs: {},
      activeTab: 'profile'
    }
  },
  mounted() {
    this.axios.get('/js/json/profile.json').then(({data}) => {
      this.fields = data.fields
      this.tabs = data.tabs
    })
  },
  methods: {}
}
</script>