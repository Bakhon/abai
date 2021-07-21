<template>
  <transition :name="`aw-${animation}__background`">
    <div @click="closeModal" ref="background" v-show="isShow" class="aw-modal__background">
      <transition :name="`aw-${animation}__modal`">
        <div v-show="isShow" ref="modal" :class="getClasses">
          <div class="aw-modal__header">
            <h5>{{title}}</h5>
            <Button ref="closeBtn" @click="closeModal" v-if="hasCloseBtn">
              Закрыть
            </Button>
          </div>
          <div :class="getBodyClasses">
            <slot />
          </div>
          <div v-if="$scopedSlots.footer" class="aw-modal__footer">
            <slot name="footer"/>
          </div>
        </div>
      </transition>
    </div>
  </transition>
</template>

<script>
import Button from "../../buttons/Button";
export default {
  name: "AwModal",
  components:{
    Button
  },
  props: {
    title: String,
    isShow: Boolean,
    animation: {
      type: String,
      default: "fade"
    },
    size: {
      type: String,
      default: "md",
    },
    position:{
      type: String,
      default: "center"
    },
    hasBodyPadding: Boolean,
    hasCloseBtn: {
      type: Boolean,
      default: true
    }
  },
  watch: {
    isShow(state){
      if(state){
        document.body.classList.add("aw-modal-opened")
      }else{
        document.body.classList.remove("aw-modal-opened")
      }
    }
  },
  computed: {
    getBodyClasses(){
      return {
        "aw-modal__body": true,
        "p-0": !this.hasBodyPadding
      }
    },
    getClasses() {
      return {
        "aw-modal": true,
        [this.size]: this.size,
        [this.position]: this.position
      }
    }
  },
  methods: {
    closeModal(e) {
      let {target} = e;
      let {closeBtn, background} = this.$refs;
      if(target === background||target === closeBtn.$el) this.$emit("update:is-show", false);
    }
  }
}
</script>
