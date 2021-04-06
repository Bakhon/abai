<template>
   <div class="user-profile__logs-block">

        <table style="width:100%" class="modulesTable">
        <tr>
            <th>{{ trans('profile.access.date') }}</th>
            <th>{{ trans('profile.access.module') }}</th>
            <th>{{ trans('profile.access.status') }}</th>
        </tr>
        <tr v-for="item in accesses">
            <td>{{item.updated_at}}</td>
            <td><p class="default"><span v-html="item.module_icon"></span><span>{{item.module_name}}</span></p></td>
            <td v-if="item.status === 'open'"><p class="default"><span class="status green">{{ trans('profile.access.opened') }}</span><!--<span>Ваша роль - <b>Администратор</b></span>--></p></td>
            <td v-if="item.status === 'close'"><p class="default"><span class="status red">{{ trans('profile.access.closed') }}</span></p></td>
            <td v-if="item.status === 'process'"><p class="default"><span class="status grey">{{ trans('profile.access.process') }}</span></p></td>
        </tr>
        </table>
            
    </div>
</template>

<script>

export default {
  name: 'HistoryAccessProfile',
  props: {
    accesses: {
      type: Array,
      required: true
    },
  },
  components: {},
  data() {
    return {
    }
  },
  methods: {}
}
</script>

<style scoped>
  span.status.grey{
    color: #B9BDDE;
  }
</style>