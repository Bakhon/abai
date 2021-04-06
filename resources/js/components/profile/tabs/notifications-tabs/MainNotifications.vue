<template>
   <div class="notificationsBlock">
     <p class="title">{{ trans('profile.notifications.are_common') }} <span>3 {{ trans('profile.notifications.new') }}</span></p>
     <div class="item" v-for="(item,index) in notifications" v-if="index <= 4">
       <div class="iconBlock" :class="{'green': item.type === 'doc','red': item.type === 'database'}">
       <span class="img" v-html="icons.doc" v-if="item.type === 'doc'"></span>
       <span class="img" v-html="icons.database" v-if="item.type === 'database'"></span>
       </div>
       <p><span>{{item.name}}</span>{{item.descr}} <a v-if="item.type === 'doc'" href="#"><span v-html="icons.link"></span></a></p>
     </div>
     <button class="more" data-toggle="modal" data-target="#myModal">{{ trans('profile.notifications.show_all') }}</button>

    <!-- Modal -->
     <div class="modal customModulesModal" id="myModal">
       <div class="modal-dialog">
         <div class="modal-content">
           <div class="notificationsBlock">
             <div class="firstBlock">
               <p class="title">{{ trans('profile.notifications.are_common') }}</p>
               <button type="button" class="btn btn-danger" data-dismiss="modal">{{ trans('profile.notifications.close') }}</button>
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
   </div>
</template>

<script>
import params from '../../../../json/profile.json'

export default {
  name: 'MainNotificationsProfile',
  props: {
  },
  components: {},
  data() {
    return {
        icons: params.icons,
        notifications: params.notifications,
    }
  },
  methods: {}
}
</script>