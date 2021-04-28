<template>
  <div>
    {{ status }}
    <div class="menu__button btn btn-primary" @click="saveData()">
      {{ trans("visualcenter.saveButton") }}
    </div>
  </div>
</template>

<script>
export default {
  data: function () {
    return {
      status: "нет данных",
    };
  },
  methods: {
    saveData() {
      let uri = this.localeUrl("get-data-hive");

      this.axios.post(uri, this.data).then((response) => {
        if (response.status === 200) {
          this.status = "сохранено";
        } else {
          this.status = "не сохранено";
        }
      });
    },
  },
};
</script>
