<template>
  <div class="row history">
    <template v-if="params.activity">
      <div class="col-12">
        <p><b>{{ params.subject + ' ' + trans('app.' + params.activity.description)}}</b></p>
        <table class="table table-bordered history__fields" >
          <tr>
            <th><b>{{ trans('app.param_name') }}</b></th>
            <th>
              <b>{{ trans('monitoring.map-history.old-value') }}</b>
            </th>
            <th>
              <b>{{ trans('monitoring.map-history.new-value') }}</b>
            </th>
          </tr>
          <tr v-for="(change, index) in params.changes" :key="index" class="changed">
            <td>{{ index }}</td>
            <td>{{ change.old }}</td>
            <td>{{ change.current }}</td>
          </tr>
        </table>
      </div>
      <b-button variant="danger" @click="restore" >{{ btnText }}</b-button>
    </template>
    <template v-else>
      <p class="w-100 text-center mb-0">{{ trans('monitoring.history.no_history') }}</p>
    </template>
  </div>
</template>

<script>
export default {
  name: "mapHistory",
  props: {
    params: {
      type: Object,
    },
  },
  data: function () {
    return {

    }
  },
  mounted() {

  },
  computed: {
    btnText () {
      switch (this.params.activity.description) {
        case 'created':
          return this.trans('app.delete');
        case 'updated':
          return this.trans('app.rollback');
        case 'deleted':
          return this.trans('app.restore');
      }
    }
  },
  methods: {
    restore () {
      this.$bvModal.msgBoxConfirm(this.trans('app.are-you-sure-to-restore'), {
        title: this.trans('app.restore_title'),
        headerBgVariant: 'danger',
        okTitle: this.btnText,
        cancelTitle: this.trans('app.cancel'),
      })
          .then(value => {
            if (value) {
              this.axios.get(this.localeUrl("/map-history/restore") + '/' + this.params.activity.id).then((response) => {
                if (response.data.status == 'success') {
                  window.location.href = this.localeUrl('/map-history');
                } else {
                  this.showToast(this.trans('app.error'), this.trans('app.error'), 'danger');
                }
              });
            }
          })
    }
  }
}
</script>

<style lang="scss">
.history {
  background: #20274e;
  color: #fff;

  margin: 0 0 20px;
  padding: 20px 10px;

  &__list {
    max-height: calc(100vh - 270px);
    overflow-y: auto;

    &-item {
      border: 1px solid #ccc;
      border-radius: 10px;
      margin-bottom: 5px;
      padding: 5px 20px;

      &_active {
        background: #15509d;
        border-color: transparent;
      }

      p {
        margin: 0;
      }
    }
  }

  &__fields {
    tr {
      color: #ccc;

      th {
        color: #fff;
        font-weight: normal;

        p {
          margin: 0;
        }
      }

      &.changed {
        color: #fff;
        font-weight: bold;
      }
    }
  }
}
</style>