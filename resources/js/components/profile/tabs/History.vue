<template>
    <div class="user-profile__logs-block">

        <table style="width:100%">
          <tr>
            <th>{{ trans('profile.history.date') }}</th>
            <th>{{ trans('profile.history.act') }}</th>
            <th>{{ trans('profile.history.user_os') }}</th>
          </tr>
          <tr v-for="log in logs">
            <td>{{log.created_at}}</td>
            <td>{{log.url}}</td>
            <td>
              <span>
                <b class="ico" v-if="log.os_logo == 'windows'" v-html="icons.windows"></b>
                <b class="ico" v-if="log.os_logo == 'linux'" v-html="icons.linux"></b>
                <b class="ico" v-if="log.os_logo == 'ios'" v-html="icons.ios"></b>
                <b class="ico" v-if="log.os_logo == 'android'" v-html="icons.android"></b>
            {{log.user_os}}</span><span>IP: {{log.ip_address}}</span></td>
          </tr>
        </table>
            
    </div>
</template>

<script>

import params from '../../../json/profile.json'

export default {
  name: 'HistoryProfile',
  props: {
    logs: {
      type: Array,
      required: true
    },
  },
  components: {},
  data() {
    return {
    icons: params.icons,
    }
  },
  methods: {}
}
</script>

<style>
  b.ico{
  display: inline-table;
    margin: -2px 5px 0 0;
    vertical-align: middle;
    line-height: 0;
  }
</style>