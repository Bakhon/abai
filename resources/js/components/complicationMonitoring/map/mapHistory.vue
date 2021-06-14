<template>
  <div class="row history">
    <template v-if="activity">
      <div class="col-12">
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
          <tr v-for="(change, index) in changes" :key="index" class="changed">
            <td>{{ index }}</td>
            <td>{{ change.old }}</td>
            <td>{{ change.current }}</td>
          </tr>
        </table>
      </div>
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
    activity: {
      type: Object,
    },
    changes: {
      type: Array,
    }
  },
  data: function () {
    return {

    }
  },
  mounted() {

  },
  methods: {

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