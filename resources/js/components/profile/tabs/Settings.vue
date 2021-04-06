<template>
    <div class="container-fluid defaultPadding">
        <div class="row">
          <div class="col-sm-6 defaultPadding">
            <div class="settingsBlock">
              <p class="title">{{ trans('profile.settings.title1') }}</p>
              <div class="firstBlock">
                <img :src="user.profile.thumb || '/img/level1/icon_user.svg'" class="avatar">
                <div class="rightBlock">
                  <p class="name">{{ trans('profile.settings.avatar') }}</p>
                  <div class="feedback"  v-if="feedback">
                    <span  style="color:red">{{feedbackstatus}}</span>
                  </div>
                  <div class="delete" v-if="deletebool">
                    <span>{{deletestatus}}</span>
                  </div>
                  <form method="post" enctype="multipart/form-data" id="avatar_form" v-on:submit.prevent="submitAvatar">
                    <input type="file" class="form-control-file" name="avatar" id="avatarFile" aria-describedby="fileHelp">
                    <button class="blue" type="submit" onclick="$('input#avatarFile').change()">{{ trans('profile.settings.upload') }}</button>
                  </form>
                  <button v-on:click="deleteAvatar()">{{ trans('profile.settings.delete') }}</button>
                  <p class="descr">{{ trans('profile.settings.avatar_validation') }}</p>
                </div>
              </div> 
              <div class="secondBlock">
                <div class="blockName">
                  <span class="blockIcon" v-html="icons.earth"></span>
                  <p><span>{{ trans('profile.settings.langs') }}</span>{{ trans('profile.settings.langs_info') }}</p>
                </div>
                <div class="form-group"><el-radio v-model="radio" name="userLang" id="lang_ru" label="1">Русский язык</el-radio></div>
                <div class="form-group"><el-radio v-model="radio" name="userLang" id="lang_kz" label="2">Қазақ тілі</el-radio></div>
                <div class="form-group"><el-radio v-model="radio" name="userLang" id="lang_en" label="3">English</el-radio></div>
                <button class="submitButton">{{ trans('profile.settings.save') }}</button>
              </div>
            </div>
          </div>
          <div class="col-sm-6 defaultPadding">
            <div class="settingsBlock">
              <p class="title">{{ trans('profile.settings.title2') }}</p>
              <div class="firstBlock">
                <div class="blockName">
                    <span class="blockIcon" v-html="icons.new"></span>
                    <p><span>{{ trans('profile.settings.types') }}</span></p>
                  </div>
                  <div class="form-group">
                    <el-switch v-model="value1" active-color="#2E50E9" inactive-color="#393D75" active-value="1" inactive-value="0" name="type1" id="type1"></el-switch>
                    <label>{{ trans('profile.settings.type1') }}</label>
                  </div>
                  <div class="form-group">
                    <el-switch v-model="value2" active-color="#2E50E9" inactive-color="#393D75" active-value="1" inactive-value="0" name="type2" id="type2"></el-switch>
                    <label>{{ trans('profile.settings.type2') }}</label></div>
                  <div class="form-group">
                    <el-switch v-model="value3" active-color="#2E50E9" inactive-color="#393D75" active-value="1" inactive-value="0" name="type3" id="type3"></el-switch>
                    <label>{{ trans('profile.settings.type3') }}</label></div>
              </div>
              <div class="secondBlock">
                <div class="blockName">
                    <span class="blockIcon" v-html="icons.new"></span>
                    <p><span>{{ trans('profile.settings.external') }}</span>{{ trans('profile.settings.external_info') }}</p>
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
                <button class="submitButton">{{ trans('profile.settings.save') }}</button>
              </div>
            </div>
          </div>
        </div>
    </div>
</template>

<script>
import params from '../../../json/profile.json'
import axios from 'axios';

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
      feedback: false,
      deletebool: false,
      feedbackstatus: '',
      deletestatus: '',
    }
  },
  methods: {
    submitAvatar(){
      const self = this;
      const files = document.querySelector('#avatar_form'); 
      var bodyFormData = new FormData(files);
      self.deletebool = false;
      self.feedback = false;
      axios({
        method: 'post',
        url: 'update_avatar',
        data: bodyFormData,
        config: { headers: {'Content-Type': 'multipart/form-data' }}
        })
        .then(function (response) {
          $('img.avatar').attr('src',response.data.thumb);
          self.feedback = false;
          $('input#avatarFile').val('');
        })
        .catch(error => {
          self.feedback = true;
          self.feedbackstatus = error.response.data.errors.avatar;
         });
    },
    deleteAvatar(){
      const self = this;
      self.deletebool = false;
      self.feedback = false;
      axios({
        method: 'post',
        url: 'delete_avatar',
        })
        .then(function (response) {
          if(response.data.status == 1){
            self.deletestatus = response.data.message;
            self.deletebool = true;
            $('img.avatar').attr('src','/img/level1/icon_user.svg');
          }else if(response.data.status == 0){
            self.deletestatus = response.data.message;
            self.deletebool = true;
          }
        })
        .catch(function (response) {
          self.deletestatus = response.data.message;
          self.deletebool = true;
        });
    }
  }
}
</script>
