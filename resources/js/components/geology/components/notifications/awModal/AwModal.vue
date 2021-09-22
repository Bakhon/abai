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
          <div v-if="$scopedSlots.footer||isConfirm" class="aw-modal__footer">
            <div v-if="isConfirm" class="d-flex align-items-center justify-content-center">
              <Button class="mr-3">{{ trans('app.save') }}</Button>
              <Button ref="cancelBtn" color="primary" @click="cancel">{{ trans('app.cancel') }}</Button>
            </div>
            <slot name="footer" v-else/>
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
    isConfirm: Boolean,
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
    cancel(e){
      this.$emit('cancel');
      this.closeModal(e);
    },
    closeModal(e) {
      let {target} = e;
      let {closeBtn, background, cancelBtn} = this.$refs;
      if(target === background||target === closeBtn.$el||target === cancelBtn.$el) this.$emit("update:is-show", false);
    }
  }
}
</script>
