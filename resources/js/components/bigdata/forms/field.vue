<template>
  <div class="bd-form-field">
    <template v-if="['text', 'numeric'].indexOf(item.type) > -1">
      <input
          :type="item.type === 'numeric' ? 'number' : 'text'"
          :name="item.code"
          v-bind:value="formatValue(value)"
          v-on:change="updateValue($event.target.value)"
          v-on:input="updateValue($event.target.value)"
          class="form-control"
          :class="{'error': error}"
          placeholder=""
      >
    </template>
    <template v-else-if="item.type === 'list'">
      <v-select
          v-on:input="updateValue($event.id)"
          :options="item.values"
          :name="item.code"
      >
        <template #open-indicator="{ attributes }">
          <svg width="12" height="6" viewBox="0 0 12 6" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M1.5 1.00024L5.93356 4.94119C5.97145 4.97487 6.02855 4.97487 6.06644 4.94119L10.5 1.00024"
                  stroke="white" stroke-width="1.4" stroke-linecap="round"/>
          </svg>
        </template>
      </v-select>
    </template>
    <template v-else-if="item.type === 'radio'">
      <div class="radio-wrap" v-for="value in item.values">
        <input
            :name="item.code"
            v-bind:value="value"
            v-on:input="updateValue($event.target.value)"
            type="radio"
            :id="`${item.code}_${value}`"
        >
        <label :for="`${item.code}_${value}`">{{ value }}</label>
      </div>
    </template>
    <template v-else-if="item.type === 'checkbox'">
       <label :for="`${item.code}`"></label>
        <input
            :name="item.code"
            type="checkbox"
            :id="`${item.code}`"
            v-bind:checked="value"
            v-on:input="$emit('input', $event.target.checked); $emit('change', $event.target.checked)"
        >
    </template>
    <template v-else-if="item.type === 'dict'">
      <v-select
          :value="formatedValue"
          label="name"
          :options="dict"
          @input="updateValue($event.id)"
          :name="item.code"
      >
        <template #open-indicator="{ attributes }">
          <svg width="12" height="6" viewBox="0 0 12 6" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M1.5 1.00024L5.93356 4.94119C5.97145 4.97487 6.02855 4.97487 6.06644 4.94119L10.5 1.00024"
                  stroke="white" stroke-width="1.4" stroke-linecap="round"/>
          </svg>
        </template>
      </v-select>
    </template>
    <template v-else-if="item.type === 'dict_tree'">
      <treeselect
          v-bind:value="value || null"
          v-on:input="updateValue($event)"
          :multiple="false"
          :options="dict"
          :auto-load-root-options="false"
          :loading="true"
          :placeholer="`${trans('app.select')}...`"
      />
    </template>
    <template v-else-if="['date', 'datetime'].includes(item.type)">
      <datetime
          :format="dateFormat[item.type]"
          v-on:input="changeDate($event)"
          :value="formatedValue.value"
          :input-class="{'form-control date': true, 'error': error}"
          value-zone="Asia/Almaty"
          zone="Asia/Almaty"
          :type="item.type"
          :phrases="{ok: trans('app.select'), cancel: trans('app.exit')}"
          :week-start="1"
          use24-hour
          auto
      >
        <template slot="after">
          <svg class="calendar" width="28" height="28" viewBox="0 0 28 28" fill="none"
               xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd"
                  d="M0 0L24.0001 0.000397939C26.2092 0.000434567 28 1.79128 28 4.0004V24C28 26.2091 26.2091 28 24 28H0V0Z"
                  fill="#363B68"/>
            <path fill-rule="evenodd" clip-rule="evenodd"
                  d="M7.09091 6.00024C6.4909 6.00024 6 6.49114 6 7.09115V9.27296H22V7.09115C22 6.49114 21.5091 6.00024 20.9091 6.00024H19.8182H16.1818H12.1818H8.54545H7.09091ZM10.5 7.65C10.5 8.06421 10.1642 8.4 9.75 8.4C9.33579 8.4 9 8.06421 9 7.65C9 7.23579 9.33579 6.9 9.75 6.9C10.1642 6.9 10.5 7.23579 10.5 7.65ZM17.95 8.3999C18.3642 8.3999 18.7 8.06412 18.7 7.6499C18.7 7.23569 18.3642 6.8999 17.95 6.8999C17.5358 6.8999 17.2 7.23569 17.2 7.6499C17.2 8.06412 17.5358 8.3999 17.95 8.3999Z"
                  fill="white"/>
            <path
                d="M6 20.9091C6 21.509 6.4909 22 7.09091 22H20.9091C21.5091 22 22 21.509 22 20.9091V10H6V20.9091ZM18 11.8182C18 11.6182 18.1636 11.4545 18.3636 11.4545H19.8182C20.0182 11.4545 20.1818 11.6182 20.1818 11.8182V13.2727C20.1818 13.4727 20.0182 13.6364 19.8182 13.6364H18.3636C18.1636 13.6364 18 13.4727 18 13.2727V11.8182ZM18 15.0909C18 14.8909 18.1636 14.7273 18.3636 14.7273H19.8182C20.0182 14.7273 20.1818 14.8909 20.1818 15.0909V16.5454C20.1818 16.7454 20.0182 16.9091 19.8182 16.9091H18.3636C18.1636 16.9091 18 16.7454 18 16.5454V15.0909ZM18 18.3636C18 18.1636 18.1636 18 18.3636 18H19.8182C20.0182 18 20.1818 18.1636 20.1818 18.3636V19.8182C20.1818 20.0182 20.0182 20.1818 19.8182 20.1818H18.3636C18.1636 20.1818 18 20.0182 18 19.8182V18.3636ZM14.3636 11.8182C14.3636 11.6182 14.5273 11.4545 14.7273 11.4545H16.1818C16.3818 11.4545 16.5455 11.6182 16.5455 11.8182V13.2727C16.5455 13.4727 16.3818 13.6364 16.1818 13.6364H14.7273C14.5273 13.6364 14.3636 13.4727 14.3636 13.2727V11.8182ZM14.3636 15.0909C14.3636 14.8909 14.5273 14.7273 14.7273 14.7273H16.1818C16.3818 14.7273 16.5455 14.8909 16.5455 15.0909V16.5454C16.5455 16.7454 16.3818 16.9091 16.1818 16.9091H14.7273C14.5273 16.9091 14.3636 16.7454 14.3636 16.5454V15.0909ZM14.3636 18.3636C14.3636 18.1636 14.5273 18 14.7273 18H16.1818C16.3818 18 16.5455 18.1636 16.5455 18.3636V19.8182C16.5455 20.0182 16.3818 20.1818 16.1818 20.1818H14.7273C14.5273 20.1818 14.3636 20.0182 14.3636 19.8182V18.3636ZM11.0909 11.8182C11.0909 11.6182 11.2545 11.4545 11.4545 11.4545H12.9091C13.1091 11.4545 13.2727 11.6182 13.2727 11.8182V13.2727C13.2727 13.4727 13.1091 13.6364 12.9091 13.6364H11.4545C11.2545 13.6364 11.0909 13.4727 11.0909 13.2727V11.8182ZM11.0909 15.0909C11.0909 14.8909 11.2545 14.7273 11.4545 14.7273H12.9091C13.1091 14.7273 13.2727 14.8909 13.2727 15.0909V16.5454C13.2727 16.7454 13.1091 16.9091 12.9091 16.9091H11.4545C11.2545 16.9091 11.0909 16.7454 11.0909 16.5454V15.0909ZM11.0909 18.3636C11.0909 18.1636 11.2545 18 11.4545 18H12.9091C13.1091 18 13.2727 18.1636 13.2727 18.3636V19.8182C13.2727 20.0182 13.1091 20.1818 12.9091 20.1818H11.4545C11.2545 20.1818 11.0909 20.0182 11.0909 19.8182V18.3636ZM7.81818 11.8182C7.81818 11.6182 7.98182 11.4545 8.18182 11.4545H9.63636C9.83636 11.4545 10 11.6182 10 11.8182V13.2727C10 13.4727 9.83636 13.6364 9.63636 13.6364H8.18182C7.98182 13.6364 7.81818 13.4727 7.81818 13.2727V11.8182ZM7.81818 15.0909C7.81818 14.8909 7.98182 14.7273 8.18182 14.7273H9.63636C9.83636 14.7273 10 14.8909 10 15.0909V16.5454C10 16.7454 9.83636 16.9091 9.63636 16.9091H8.18182C7.98182 16.9091 7.81818 16.7454 7.81818 16.5454V15.0909ZM7.81818 18.3636C7.81818 18.1636 7.98182 18 8.18182 18H9.63636C9.83636 18 10 18.1636 10 18.3636V19.8182C10 20.0182 9.83636 20.1818 9.63636 20.1818H8.18182C7.98182 20.1818 7.81818 20.0182 7.81818 19.8182V18.3636Z"
                fill="white"/>
          </svg>
        </template>
      </datetime>
    </template>
    <template v-else-if="item.type === 'table'">
      <BigdataTableField :params="item" v-on:change="updateValue($event)"></BigdataTableField>
    </template>
    <div v-if="error" class="text-danger error" v-html="showError(error)"></div>
  </div>
</template>

<script>
import moment from 'moment'
import vSelect from "vue-select"
import Treeselect from '@riophae/vue-treeselect'
import '@riophae/vue-treeselect/dist/vue-treeselect.css'
import 'vue-select/dist/vue-select.css'
import BigdataTableField from './fields/Table'

export default {
  name: "BigdataFormField",
  components: {
    Treeselect,
    vSelect,
    BigdataTableField
  },
  props: [
    'item',
    'value',
    'error'
  ],
  data: function () {
    return {
      formatedValue: {
        value: null,
        text: null
      },
      dateFormat: {
        'date': {year: 'numeric', month: 'numeric', day: 'numeric'},
        'datetime': {year: 'numeric', month: 'numeric', day: 'numeric', hour: 'numeric', minute: 'numeric'}
      }
    }
  },
  computed: {
    dict() {
      return this.$store.getters['bd/dict'](this.item.dict);
    },
  },
  watch: {
    value(newValue) {
      this.formatedValue = this.getFormatedValue(newValue)
    }
  },
  created() {
    if (['dict', 'dict_tree'].indexOf(this.item.type) > -1) {
      this.loadDict()
    }

    this.formatedValue = this.getFormatedValue(this.value)
  },
  methods: {
    loadDict() {
      this.axios.get(this.localeUrl('/bigdata/dict/' + this.item.dict)).then(data => {
        this.$store.commit("bd/SAVE_DICT", {
          code: this.item.dict,
          items: data.data
        });
      })
    },
    changeDate(date) {
      if (date) {
        let formatedDate = moment.parseZone(date).format('YYYY-MM-DD HH:MM:SS')
        this.updateValue(formatedDate)
      }
    },
    updateValue(value) {
      this.formatedValue = this.getFormatedValue(value)
      this.$emit('change', value)
      this.$emit('input', value)
      this.$emit('update', this.formatedValue)
    },
    getFormatedValue(value) {
      if (this.item.type === 'dict') {
        let selected = this.dict.find(item => item.id === value) || {id: null, name: null}
        return {
          id: selected.id,
          name: selected.name,
          value: selected.id,
          text: selected.name
        }
      }
      if (this.item.type === 'date') {

        return {
          text: value ? moment(value).format('YYYY-MM-DD HH:MM:SS') : null,
          value: value ? moment(value).format() : null
        }
      }

      return {value: value, text: value}
    },
    showError(err) {
      return err.join('<br>')
    },
    formatValue(value) {

      if (this.item.prefix) {
        if (value && value.length <= this.item.prefix.length) return this.item.prefix

        if (value && value.indexOf(this.item.prefix) === 0) {
          value = value.replace(this.item.prefix, '')
        }

        return this.item.prefix + (value || '')
      }

      return value
    }
  }
}
</script>
<style lang="scss">
.bd-form-field {
  max-width: 600px;


  input.form-control {
    background: #1F2142;
    border: 0.5px solid #454FA1;
    box-sizing: border-box;
    border-radius: 4px;
    color: #fff;
    height: 28px;

    &.date {
      width: 156px;
    }
  }

  .vdatetime {
    display: inline-block;
    position: relative;

    svg.calendar {
      right: 0;
      top: 0;
      position: absolute;
    }
  }

  .v-select {
    background: #334296;
    height: 28px;
    min-width: 100%;

    .vs__search, .vs__selected {
      font-size: 14px;
      font-weight: normal;
      height: 28px;
      line-height: 1;
      margin-top: 0;
      max-width: 95%;
    }

    .vs__dropdown-menu {
      border: none;
      top: 30px;

      &::-webkit-scrollbar {
        width: 4px;
      }

      &::-webkit-scrollbar-track {
        background: #40467E;
      }

      &::-webkit-scrollbar-thumb {
        background: #656A8A;
      }

      &::-webkit-scrollbar-thumb:hover {
        background: #656A8A;
      }

      &::-webkit-scrollbar-corner {
        background: #20274F;
      }
    }

    .vs__actions {
      svg {
        path {
          fill: none;
        }
      }
    }
  }

  .vue-treeselect {
    &__control {
      background: #334296;
      border: none;
      height: 28px;
    }

    &__input {
      color: #fff;
    }

    &__menu {
      background: #40467E;
      border: none !important;

      &::-webkit-scrollbar {
        width: 4px;
      }

      &::-webkit-scrollbar-track {
        background: #40467E;
      }

      &::-webkit-scrollbar-thumb {
        background: #656A8A;
      }

      &::-webkit-scrollbar-thumb:hover {
        background: #656A8A;
      }

      &::-webkit-scrollbar-corner {
        background: #20274F;
      }
    }

    &__option {
      height: 16px;

      &--highlight, &--selected {
        background: #5897fb !important;
      }
    }

    &__single-value {
      color: #fff;
    }
  }

  .radio-wrap {
    display: inline-block;
    margin-right: 20px;

    input {
      left: 0;
      opacity: 0;
      position: absolute;

      &:checked + label {
        &:before {
          background: #237DEB;
          border: 2px solid #fff;
        }
      }
    }

    label {
      padding-left: 19px;
      position: relative;

      &:before {
        background: #fff;
        border: 1px solid #237DEB;
        border-radius: 50%;
        content: "";
        height: 14px;
        left: 0;
        position: absolute;
        top: -2px;
        width: 14px;
      }
    }
  }
}
</style>