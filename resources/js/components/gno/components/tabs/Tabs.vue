<script src="../../../../../../webpack.mix.js"></script>
<template>
  <div>
    <div class="container">
      <ul class="tabs-choose">
        <li @click="activeTab = '1'" :class="[activeTab === '1' ? 'active' : '']">{{ trans('pgno.shgn') }}</li>
        <li @click="activeTab = '2'" :class="[activeTab === '2' ? 'active' : '']">{{trans('pgno.ecn')}}</li>
      </ul>
      <div class="tabs-content">
        <div class="content-shgn" v-if="activeTab === '1'"><shgn @on-submit-params="onPushParams()" :calcKpodTrigger="calcKpodTrigger"></shgn></div>
        <div class="content" v-if="activeTab === '2'"><ecn></ecn></div>
      </div>
    </div>
  </div>
</template>
<script>
import Economic from './components/Economic.vue'
import Shgn from './components/Shgn.vue'
import Ecn from './components/Ecn.vue'
import Develop from './components/Develop.vue'
import Fon from './components/Fon.vue'

export default {
  props: {"calcKpodTrigger": Boolean},
  components: { Shgn, Ecn, Fon, Develop, Economic },
  data: function () {
    return {
      activeTab: "1"
    }
  },
  methods: {
    onPushParams() {
      this.$emit('onPushParams')
      }
  }
}
</script>
<style scoped lang="scss">
.container {
  margin: 20px auto;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  .tabs-choose {
    margin-bottom: 0;
    li {
      display: inline-block;
      padding: 10px 20px;
      background-color: #363b68;
      color: white;
      cursor: pointer;
      opacity: 0.3;
      border-top-left-radius: 10px;
      border-top-right-radius: 10px;
      margin-right: 15px;
      &.active {
        opacity: 1;
      }
    }
  }
  .tabs-content {
    border: 12px solid #363b68;
    padding: 5px;
  }
}

.links-urls {
  position: absolute;
  bottom: 0;
  right: 0;
  padding: 10px;
  .link {
    padding: 10px 20px;
    display: block;
    background-color: #EEE;
    margin-bottom: 10px;
    text-decoration: none;
    color: #777;
  }
}

.content {
  padding-inline: 10px;
  width: 960px;
  font-weight: bold;
}

.content-shgn {
  padding-inline: 10px;
  width: 960px;
  font-weight: bold;
  height: 735px;
}


</style>