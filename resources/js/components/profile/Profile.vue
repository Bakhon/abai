<template>
  <div class="user-profile">
    <div class="user-profile__top">
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
          <div class="container-fluid defaultPadding">
            <div class="row">
              <div class="col-sm-4 defaultPadding">
                <div class="notificationsBlock">
                  <p class="title">Общие уведомления <span>3 новых</span></p>
                  <div class="item" v-for="(item,index) in notifications" v-if="index <= 4">
                    <div class="iconBlock" :class="{'green': item.type === 'doc','red': item.type === 'database'}">
                    <span class="img" v-html="icons.doc" v-if="item.type === 'doc'"></span>
                    <span class="img" v-html="icons.database" v-if="item.type === 'database'"></span>
                    </div>
                    <p><span>{{item.name}}</span>{{item.descr}} <a v-if="item.type === 'doc'" href="#"><span v-html="icons.link"></span></a></p>
                  </div>
                  <button class="more" data-toggle="modal" data-target="#myModal">Раскрыть</button>
                </div>
              </div>
              <div class="col-sm-4 defaultPadding">
                <div class="notificationsBlock">
                  <p class="title">Новостные уведомления <span>2 новых</span></p>
                  <div class="item" v-for="(item,index) in news" v-if="index <= 4">
                    <div class="iconBlock">
                    <span class="img" v-html="icons.tech" v-if="item.type === 'tech'"></span>
                    <span class="img" v-html="icons.database" v-if="item.type === 'database'"></span>
                    </div>
                    <p><span>{{item.name}}</span>{{item.descr}}</p>
                  </div>
                  <button class="more" data-toggle="modal" data-target="#myModal2">Раскрыть</button>
                </div>
              </div>
              <div class="col-sm-4 defaultPadding">
                <div class="notificationsBlock">
                  <p class="title">Уведомления по модулям <span>4 новых</span></p>
                 <div class="item" v-for="(item,index) in modules" v-if="index <= 4">
                    <div class="iconBlock blue">
                      <span class="img" v-html="item.ico"></span>
                      </div>
                      <p><span>Модуль {{item.name}}:</span>Описание уведомления по модулю <a href="#"><span v-html="icons.link"></span></a></p>
                  </div>
                  <button class="more" data-toggle="modal" data-target="#myModal3">Раскрыть</button>
                </div>
              </div>
            </div>
          </div>


          <div class="modal customModulesModal" id="myModal">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="notificationsBlock">
                  <div class="firstBlock">
                    <p class="title">Общие уведомления</p>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Закрыть</button>
                  </div>
                  <div class="secondBlock">
                    <div class="item" v-for="item in notifications">
                      <div class="iconBlock" :class="{'green': item.type === 'doc','red': item.type === 'database'}">
                      <span class="img" v-html="icons.doc" v-if="item.type === 'doc'"></span>
                      <span class="img" v-html="icons.database" v-if="item.type === 'database'"></span>
                      </div>
                      <p><span>{{item.name}}</span>{{item.descr}} <a v-if="item.type === 'doc'" href="#"><span v-html="icons.link"></span></a></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="modal customModulesModal" id="myModal2">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="notificationsBlock">
                  <div class="firstBlock">
                    <p class="title">Новостные уведомления</p>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Закрыть</button>
                  </div>
                  <div class="secondBlock">
                    <div class="item" v-for="item in news">
                    <div class="iconBlock">
                    <span class="img" v-html="icons.tech" v-if="item.type === 'tech'"></span>
                    <span class="img" v-html="icons.database" v-if="item.type === 'database'"></span>
                    </div>
                    <p><span>{{item.name}}</span>{{item.descr}}</p>
                  </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          
          <div class="modal customModulesModal" id="myModal3">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="notificationsBlock">
                  <div class="firstBlock">
                    <p class="title">Уведомления по модулям</p>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Закрыть</button>
                  </div>
                  <div class="secondBlock">
                    <div class="item" v-for="item in modules">
                    <div class="iconBlock blue">
                      <span class="img" v-html="item.ico"></span>
                      </div>
                      <p><span>Модуль {{item.name}}:</span>Описание уведомления по модулю <a href="#"><span v-html="icons.link"></span></a></p>
                  </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </template>
        <template v-else-if="activeTab === 'access'">
          <div class="mainAccessBlock">
            <div class="accessMenu">
              <ul>
                <li v-for="(tab, code) in access"
                :class="{'active': accessTab === code}"
            @click="accessTab = code">
                  <a href="#">
                  <span v-html="tab.ico"></span>
                  <span>{{tab.name}}</span>
                  </a>
                </li>
              </ul>
            </div>
            <div class="accessContent">
              <div class="mainBlock" v-if="accessTab === 'open'">
                    <div class="row">
                        <div class="col-sm-3" v-for="item in modules">
                          <div class="block open" v-if="item.status === 'open'">
                            <div class="imgBkg" v-html="icons.bkg"></div>
                            <p class="name">
                              <span v-html="item.ico"></span>
                              <span>"{{item.name}}"</span>
                            </p>
                            <div class="content">
                              <p><span class="icon" v-html="icons.icon"></span><span>Роль:</span> Администратор модуля</p>
                              <a href="#">Перейти в модуль</a>
                            </div>
                          </div>
                        </div>
                    </div>
              </div>
              <div class="mainBlock" v-else-if="accessTab === 'library'">
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
              </div>
              <div class="mainBlock" v-else-if="accessTab === 'history'">
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
              </div>
            </div>
          </div>
        </template>
        <template v-else-if="activeTab === 'history'">
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
        <template v-else-if="activeTab === 'settings'">
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
      </div>
    </div>
  </div>
</template>

<script>
import ProfileField from './Field'
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
  },
  components: {
    ProfileField
  },
  data() {
    return {
      fields: params.fields,
      tabs: params.tabs,
      access: params.access,
      modules: params.modules,
      icons: params.icons,
      notifications: params.notifications,
      news: params.news,
      activeTab: 'profile',
      accessTab: 'open',
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