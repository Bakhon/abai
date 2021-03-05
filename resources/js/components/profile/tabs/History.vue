<template>
    <div class="user-profile__logs-block">

        <table style="width:100%">
          <tr>
            <th>Дата и время последнего сеанса</th>
            <th>Действие</th>
            <th>IP адрес и устройство входа</th>
          </tr>
          <tr v-for="log in logs">
            <td>{{log.created_at}}</td>
            <td>{{log.url}}</td>
            <td><span>Win 10</span><span>IP: {{log.ip_address}}</span></td>
          </tr>
        </table>
            
    </div>
</template>

<script>
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
    
    }
  },
  methods: {}
}
</script>