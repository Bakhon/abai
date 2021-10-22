<template>
  <transition :name="`aw-${animation}__background`">
    <div @click="backgroundClick" ref="background" v-show="isShow" class="aw-modal__background">
      <transition :name="`aw-${animation}__modal`">
        <div v-show="isShow" ref="modal" :class="getClasses">
          <div class="aw-modal__header">
            <h5>{{ title }}</h5>
            <Button ref="closeBtn" @click="isConfirm ? action('cancel', $event) : closeModal" v-if="hasCloseBtn">
              Закрыть
            </Button>
          </div>
          <div :class="getBodyClasses">
            <slot />
          </div>
          <div v-if="$scopedSlots.footer||isConfirm" class="aw-modal__footer">
            <div v-if="isConfirm" class="d-flex align-items-center justify-content-center">
              <Button ref="acceptBtn" class="mr-3" @click="action('save', $event)">{{ trans('app.save') }}</Button>
              <Button ref="cancelBtn" color="primary" @click="action('cancel', $event)">{{ trans('app.cancel') }}</Button>
            </div>
            <slot name="footer" v-else />
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
  components: {
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
    position: {
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
    isShow(state) {
      if (state) {
        document.body.classList.add("aw-modal-opened")
      } else {
        document.body.classList.remove("aw-modal-opened")
      }
    }
  },
  computed: {
    getBodyClasses() {
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
    action(action, e) {
      e.stopPropagation();
      this.$emit(action);
      this.closeModal();
    },

    backgroundClick(e) {
      if ([this.$refs.background, this.$refs.closeBtn].includes(e.target))
        this.isConfirm ? this.action('cancel', e) : this.closeModal()
    },

    closeModal() {
      this.$emit("update:is-show", false);
    }
  }
}
</script>
