<template>
   <div class="row">
        <div class="col-sm-3" v-for="item in modules">
          <div class="block" :class="{'open': item.status === 'open'}">
            <div class="imgBkg" v-html="icons.bkg" v-if="item.status === 'open'"></div>
            <p class="name">
              <span v-html="item.ico"></span>
              <span>"{{item.name}}"</span>
            </p>
            <div class="content" v-if="item.status === 'open'">
              <p><span class="icon" v-html="icons.icon"></span><span>Роль:</span> Администратор модуля</p>
              <a href="#">Перейти в модуль</a>
            </div>
            <div class="content verticalMain"  v-if="item.status === 'close'">
              <div class="verticalBlock">
                <a href="#">Запросить доступ</a>
              </div>
            </div>
          </div>
        </div>
    </div>
</template>

<script>
import params from '../../../../json/profile.json'

export default {
  name: 'LibraryAccessProfile',
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