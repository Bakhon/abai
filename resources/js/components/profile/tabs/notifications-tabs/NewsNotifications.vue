<template>
   <div class="notificationsBlock">
      <p class="title">{{ trans('profile.notifications.for_news') }} <span>2 {{ trans('profile.notifications.new') }}</span></p>
      <div class="item" v-for="(item,index) in news" v-if="index <= 4">
        <div class="iconBlock">
        <span class="img" v-html="icons.tech" v-if="item.type === 'tech'"></span>
        <span class="img" v-html="icons.database" v-if="item.type === 'database'"></span>
        </div>
        <p><span>{{item.name}}</span>{{item.descr}}</p>
      </div>
      <button class="more" data-toggle="modal" data-target="#myModal2">{{ trans('profile.notifications.show_all') }}</button>

      <!-- Modal -->
       <div class="modal customModulesModal" id="myModal2">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="notificationsBlock">
              <div class="firstBlock">
                <p class="title">{{ trans('profile.notifications.for_news') }}</p>
                <button type="button" class="btn btn-danger" data-dismiss="modal">{{ trans('profile.notifications.close') }}</button>
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
  </div>
</template>

<script>
import params from '../../../../json/profile.json'

export default {
  name: 'NewsNotificationsProfile',
  props: {
  },
  components: {},
  data() {
    return {
        icons: params.icons,
        news: params.news,
    }
  },
  methods: {}
}
</script>