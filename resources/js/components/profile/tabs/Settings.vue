<template>
    <div class="container-fluid defaultPadding">
        <div class="row">
          <div class="col-sm-6 defaultPadding">
            <div class="settingsBlock">
              <p class="title">Основные настройки</p>
              <div class="firstBlock">
                <img :src="user.profile.thumb || '/img/level1/icon_user.svg'" class="avatar">
                <div class="rightBlock">
                  <p class="name">Фотография</p>
                  <button class="blue">Загрузить</button><button>Удалить</button>
                  <p class="descr">Поддерживаются JPG, GIF или PNG. Максимальный размер 800kB</p>
                </div>
              </div>
              <div class="secondBlock">
                <div class="blockName">
                  <span class="blockIcon" v-html="icons.earth"></span>
                  <p><span>Выбор языка</span>Выберите язык интерфейса ИС ABAI по умолчанию</p>
                </div>
                <div class="form-group"><el-radio v-model="radio" name="userLang" id="lang_ru" label="1">Русский язык</el-radio></div>
                <div class="form-group"><el-radio v-model="radio" name="userLang" id="lang_kz" label="2">Қазақ тілі</el-radio></div>
                <div class="form-group"><el-radio v-model="radio" name="userLang" id="lang_en" label="3">English</el-radio></div>
                <button class="submitButton">Сохранить</button>
              </div>
            </div>
          </div>
          <div class="col-sm-6 defaultPadding">
            <div class="settingsBlock">
              <p class="title">Настройки уведомлений</p>
              <div class="firstBlock">
                <div class="blockName">
                    <span class="blockIcon" v-html="icons.new"></span>
                    <p><span>Тип уведомлений</span></p>
                  </div>
                  <div class="form-group">
                    <el-switch v-model="value1" active-color="#2E50E9" inactive-color="#393D75" active-value="1" inactive-value="0" name="type1" id="type1"></el-switch>
                    <label>Общие уведомления</label>
                  </div>
                  <div class="form-group">
                    <el-switch v-model="value2" active-color="#2E50E9" inactive-color="#393D75" active-value="1" inactive-value="0" name="type2" id="type2"></el-switch>
                    <label>Новостные</label></div>
                  <div class="form-group">
                    <el-switch v-model="value3" active-color="#2E50E9" inactive-color="#393D75" active-value="1" inactive-value="0" name="type3" id="type3"></el-switch>
                    <label>По модулям</label></div>
              </div>
              <div class="secondBlock">
                <div class="blockName">
                    <span class="blockIcon" v-html="icons.new"></span>
                    <p><span>Внешние уведомления</span>Выберите доставку уведомлений в удобное для вас приложение</p>
                  </div>
                  <div class="form-group">
                    <el-switch v-model="value4" active-color="#2E50E9" inactive-color="#393D75" active-value="1" inactive-value="0" name="type4" id="type4"></el-switch>
                    <label>E-mail</label></div>
                  <div class="form-group">
                    <el-switch v-model="value5" active-color="#2E50E9" inactive-color="#393D75" active-value="1" inactive-value="0" name="type5" id="type5"></el-switch>
                    <label>Telegram</label></div>
                  <div class="form-group">
                    <el-switch v-model="value6" active-color="#2E50E9" inactive-color="#393D75" active-value="1" inactive-value="0" name="type6" id="type6"></el-switch>
                    <label>WhatsApp</label></div>
                <button class="submitButton">Сохранить</button>
              </div>
            </div>
          </div>
        </div>
    </div>
</template>

<script>
import params from '../../../json/profile.json'

export default {
  name: 'SettingsProfile',
  props: {
    user: {
      type: Object,
      required: true
    }
  },
  components: {},
  data() {
    return {
      icons: params.icons,
      value1: '0',
      value2: '0',
      value3: '0',
      value4: '0',
      value5: '0',
      value6: '0',
      radio: '1',
    }
  },
  methods: {}
}
</script>