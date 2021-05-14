<template>
   <div class="row">
     <div class="col-sm-12">
        <div class="moduleModal">
          <p>{{ text }}</p>
          <button class="close" onclick="$('.moduleModal').hide();"></button>
        </div>
     </div>
        <div class="col-sm-3" v-for="item in modules">
          <div class="block open" >
            <div class="imgBkg" v-html="icons.bkg"></div>
            <p class="name">
              <span v-html="item.ico"></span>
              <span>"{{item.name}}"</span>
            </p>
            <div class="content">
              <p><span class="icon" v-html="icons.icon"></span><span>{{ trans('profile.access.role') }}:</span> <!--Администратор модуля--></p>
              <a :href="item.url">{{ trans('profile.access.go') }}</a>
            </div>
          </div>
        </div>

        <div class="col-sm-3" v-for="item in other_modules">
          <div class="block">
            <p class="name">
              <span v-html="item.ico"></span>
              <span>"{{item.name}}"</span>
            </p>
            <div class="content verticalMain">
              <div class="verticalBlock">
                <a class="addModule" v-on:click="addModule(item.id)">{{ trans('profile.access.add_module') }}</a>
              </div>
            </div>
          </div>
        </div>

    </div>
</template>

<script>
import params from '../../../../json/profile.json'
import axios from 'axios'

export default {
  name: 'LibraryAccessProfile',
  props: {
    modules: {
      type: Array,
      required: true
    },
    other_modules: {
      type: Array,
      required: true
    },
  },
  components: {},
  data() {
    return {
        icons: params.icons,
        text: ''
    }
  },
  methods: {
    addModule: function(id){
      var bodyFormData = new FormData();
      bodyFormData.set('id', id);
      const self = this;
      axios({
        method: 'post',
        url: 'modulerequest',
        data: bodyFormData,
        config: { headers: {'Content-Type': 'multipart/form-data' }}
        })
        .then(function (response) {
          if(response.data.status == 1){
            self.text = response.data.message;
            $('.moduleModal').show().removeClass("red");
          }else if(response.data.status == 0){
            self.text = response.data.message;
            $('.moduleModal').show().addClass("red");
          }else{}
            
        })
        .catch(function (response) {
            self.text = response.data.message;
            $('.moduleModal').show().addClass("red");
        });
    }
  }
}
</script>

<style scoped>
  a.addModule:hover{
    cursor: pointer;
  }
  .moduleModal {
    display: table;
    width: auto;
    position: relative;
    padding: 8px 25px;
    margin: 0 auto 15px;
    border-radius: 3px;
    background: #38c172;
    display: none;
    max-width: 50%;
    text-align: center;
}
.moduleModal.red{
  background: #e3342f;
}

.moduleModal p {
    display: inline-table;
    margin: 0;
    font-size: 18px;
    vertical-align: middle;
}

.moduleModal button.close {
    display: inline-table;
    margin: 0 0 0 12px;
    position: relative;
    padding: 0;
    vertical-align: middle;
    float: unset;
    opacity: 1;
    font-weight: 100;
}

.moduleModal button.close:before {content: '✕';font-size: 13px;color: #fff;opacity: 1;font-weight: 100;display: table;margin: 0;}
</style>