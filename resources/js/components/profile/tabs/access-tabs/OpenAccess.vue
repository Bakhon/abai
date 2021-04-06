<template>
   <div class="row">
       <div class="col-sm-3" v-for="item in modules">
         <div class="block open">
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
   </div>
</template>

<script>
import params from '../../../../json/profile.json'

export default {
  name: 'OpenAccessProfile',
  props: {
    modules: {
      type: Array,
      required: true
    },
  },
  components: {},
  data() {
    return {
        icons: params.icons,
    }
  },
  methods: {}
}
</script>