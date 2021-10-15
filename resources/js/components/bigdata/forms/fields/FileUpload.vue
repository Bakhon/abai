<template>
  <div class="bd-file-field">
    <div class="bd-file-field__buttons">
      <vue-upload-component
          ref="upload"
          v-model="files"
          :multiple="true"
          :name="fileInputName"
      >
      </vue-upload-component>
      <label :for="fileInputName" class="bd-file-field__buttons-button bd-file-field__buttons-button_add">
        {{ trans('app.create') }}
      </label>
      <a :class="{'bd-file-field__buttons-button_disabled': selectedFile === null}"
         class="bd-file-field__buttons-button bd-file-field__buttons-button_remove" href="#"
         @click.prevent="$refs.upload.remove(selectedFile)">{{ trans('app.delete') }}</a>
    </div>
    <table class="table">
      <thead>
      <tr>
        <th></th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="file in files" :class="{'selected': selectedFile === file}"
          @click="selectedFile = file">
        <td>
          {{ file.name }}
        </td>
      </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import VueUploadComponent from 'vue-upload-component'

export default {
  name: "BigdataFileUploadField",
  props: {
    params: {
      type: Object,
      required: true
    },
    existedFiles: {
      type: Array,
      required: false
    },
  },
  components: {
    VueUploadComponent
  },
  data() {
    return {
      selectedFile: null,
      fileInputName: 'file_input_' + Math.random().toString(36).replace(/[^a-z]+/g, '').substr(0, 5),
      files: []
    }
  },
  mounted() {
    if (this.existedFiles) {
      this.files = this.existedFiles.map(file => {
        file.name = file.filename
        file.isExist = true
        return file
      })
    }
  },
  watch: {
    files(val) {
      this.$emit('change', val)
    }
  }
};
</script>
<style lang="scss" scoped>
.bd-file-field {
  &__buttons {
    align-items: center;
    display: flex;
    margin-bottom: 20px;

    &-button {
      align-items: center;
      background-size: 16px;
      background-position: 0 50%;
      background-repeat: no-repeat;
      color: #fff;
      display: flex;
      font-size: 14px;
      height: 16px;
      font-weight: bold;
      margin-right: 45px;
      padding-left: 28px;
      text-decoration: none;

      &_add {
        background-image: url('/img/bd/add.svg');
      }

      &_remove {
        background-image: url('/img/bd/remove.svg');
      }

      &_disabled {
        opacity: 0.5;
      }

      &:hover {
        color: #fff;
        text-decoration: none;
      }
    }
  }


  .table {
    color: #fff;
    font-size: 14px;

    th {
      background: #2b2e5e;
      border: none;
      border-top: 1px solid #3c4270;
      border-bottom: 1px solid #3c4270;
      padding: 5px;
      text-align: center;
      vertical-align: middle;

      &:nth-child(2n + 1) {
        background: #2b40a9;
      }
    }

    tbody {
      tr {
        &.selected {
          filter: saturate(2);
        }

        td {
          background: #2b2e5e;
          border: none;

          &:nth-child(2n + 1) {
            background: #343868;
          }

          a {
            color: #82BAFF;
          }
        }

        &:nth-child(2n + 1) {
          td {
            background: #343868;

            &:nth-child(2n + 1) {
              background: #383d6d;
            }
          }
        }
      }
    }
  }
}
</style>