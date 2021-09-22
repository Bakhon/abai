<template>
  <div
    class="page-accordion"
    :class="{ 'is-active': isOpen }"
  >
    <div class="page-accordion__header" @click="handleToggle">
      <div class="page-accordion__title">
        <img src="/img/digital-drilling/menu3.svg" alt="">
        <div class="name">{{trans(content.name)}}</div>
      </div>
      <div class="page-accordion__icon"/>
    </div>
    <transition-expand duration="100">
      <div v-show="isOpen" class="page-accordion__body">
        <ul class="list">
          <li v-for="page in content.child">
            <input type="radio" :id="page.id" v-model="page.checked" @click="changePage(page)">
            <label :for="page.id">{{trans(page.name)}}</label>
          </li>
        </ul>
      </div>
    </transition-expand>
  </div>
</template>

<script>
import { TransitionExpand } from 'vue-transition-expand';

export default {
  name: "Accordion",

  props: ['content'],

  components: {
    TransitionExpand,
  },

  data() {
    return {
      isOpen: false,
      test: false,
    }
  },
  methods: {
    handleToggle() {
      this.isOpen = !this.isOpen;
      this.$emit('changePage', this.content.child[0])
    },
    changePage(page){
        for (let i=0; i<this.content.child.length; i++){
            this.content.child[i].checked = false
        }
        page.checked=!page.checked
        this.$emit('changePage', page)
    }
  }
}
</script>

<style scoped>
  .page-accordion {
    margin-bottom: 10px;
  }

  .page-accordion__icon {
    display: block;
    position: absolute;
    top: 0;
    right: 1.25rem;
    bottom: 0;
    margin: auto;
    width: 8px;
    height: 8px;
    border-right: 2px solid #fff;
    border-bottom: 2px solid #fff;
    transform: translateY(-2px) rotate(45deg);
    transition: transform 0.2s ease;
  }

  .page-accordion.is-active .page-accordion__header {
    background: #2E50E9;
    border-radius: 5px 5px 0 0;
  }

  .page-accordion.is-active .page-accordion__icon {
    transform: translateY(2px) rotate(225deg);
  }

  .page-accordion__header {
    position: relative;
    background: #3A4280;
    border-radius: 5px;
    padding: 11px 17px;
    min-height: 44px;
    cursor: pointer;
    transition: 0.8s ease;
  }
  .page-accordion__title{
    display: flex;
    align-items: center;
  }
  .page-accordion__title .name{
    margin-left: 22px;
    font-size: 18px;
    line-height: 22px;
    cursor: pointer;
  }

  .page-accordion__body {
    background: #363B68;
    border: 1px solid #545580;
    border-top: none;
    height: auto;
    overflow: auto;
    max-height: 200px;
  }

  .page-accordion__body .list {
    list-style: none;
    margin: 12px 0;
  }

  .page-accordion__body .list li {
    display: flex;
    align-items: center;
    font-size: 14px;
    line-height: 17px;

    color: #FFFFFF;
    padding: 4px 13px;
  }
  .page-accordion__body .list li label{
    display: block;
    margin: 0;
    cursor: pointer;
  }
  .page-accordion__body .list li input{
    margin-right: 13px;
    cursor: pointer;
  }
  /*.page-accordion__body .list li:hover {*/
    /*background: #2E50E9;*/
    /*cursor: pointer;*/
  /*}*/
.expand-enter-active, .expand-leave-active {
  -webkit-transition: height 0.3s ease-in-out, margin 0.3s ease-in-out, padding 0.3s ease-in-out;
  transition: height 0.3s ease-in-out, margin 0.3s ease-in-out, padding 0.3s ease-in-out;
  overflow: hidden;
}

.expand-enter, .expand-leave-to {
  height: 0;
  margin-top: 0 !important;
  margin-bottom: 0 !important;
  padding-top: 0 !important;
  padding-bottom: 0 !important
}
</style>
