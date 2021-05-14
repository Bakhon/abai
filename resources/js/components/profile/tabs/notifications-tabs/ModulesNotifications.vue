<template>
   <div class="notificationsBlock">
     <p class="title">{{ trans('profile.notifications.for_modules') }} <span>4 {{ trans('profile.notifications.new') }}</span></p>
     <div class="item" v-for="(item,index) in modules" v-if="index <= 4">
       <div class="iconBlock blue">
         <span class="img" v-html="item.ico"></span>
         </div>
         <p><span>{{ trans('profile.access.module') }} {{item.name}}:</span>{{ trans('profile.notifications.module_about') }} <a href="#"><span v-html="icons.link"></span></a></p>
     </div>
     <button class="more" data-toggle="modal" data-target="#myModal3">{{ trans('profile.notifications.show_all') }}</button>

     <!-- Modal -->
            <div class="modal customModulesModal" id="myModal3">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="notificationsBlock">
                    <div class="firstBlock">
                        <p class="title">{{ trans('profile.notifications.for_modules') }}</p>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">{{ trans('profile.notifications.close') }}</button>
                    </div>
                    <div class="secondBlock">
                        <div class="item" v-for="item in modules">
                        <div class="iconBlock blue">
                        <span class="img" v-html="item.ico"></span>
                        </div>
                        <p><span>{{ trans('profile.access.module') }} {{item.name}}:</span>{{ trans('profile.notifications.module_about') }} <a href="#"><span v-html="icons.link"></span></a></p>
                    </div>
                    </div>
                    </div>
                </div>
                </div>
          </div>
   </div>
</template>

<script>
import params from '../../../../json/profile.json'

export default {
  name: 'ModulesNotificationsProfile',
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