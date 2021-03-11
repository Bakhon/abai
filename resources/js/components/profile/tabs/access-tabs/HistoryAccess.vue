<template>
   <div class="user-profile__logs-block">

        <table style="width:100%" class="modulesTable">
        <tr>
            <th>Дата и время</th>
            <th>Модуль</th>
            <th>Статус</th>
        </tr>
        <tr v-for="item in modules">
            <td>26 января 2021 в 11:15</td>
            <td><p class="default"><span v-html="item.ico"></span><span>{{item.name}}</span></p></td>
            <td v-if="item.status === 'open'"><p class="default"><span class="status green">Одобрен:</span><span>Ваша роль - <b>Администратор</b></span></p></td>
            <td v-if="item.status === 'close'"><p class="default"><span class="status red">Отклонен</span></p></td>
        </tr>
        </table>
            
    </div>
</template>

<script>
import params from '../../../../json/profile.json'

export default {
  name: 'HistoryAccessProfile',
  props: {
  },
  components: {},
  data() {
    return {
        icons: params.icons,
        modules: params.modules,
    }
  },
  methods: {}
}
</script>