<template>
  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="col-xs-12 col-sm-4 col-md-4">
        <label for>Прочие объекты</label>
        <div class="form-label-group">
            <div class="alert alert-danger" role="alert" v-show="companies.length < 1">
            <router-link to="/company">Создайте сначала компанию</router-link>, чтобы добавить контрагаента!
            </div>
            <select class="form-control" v-model="from" @change="chooseCompany($event)" v-show="companies.length > 0"
            >
            <option v-for="row in companies" v-bind:value="[row.contractor.id,row.id]">{{ row.contractor.name }}</option>
            </select>
        </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-4">
    </div>
    <div class="col-xs-12 col-sm-4 col-md-4">
    </div>
  </div>
</template>

<script>
export default {
  name: "wm-create",
  methods: {
  },
  data: function () {
    return {
      otherObjects: {},
    }
  },
  computed: {

  }
};
</script>
<style scoped>
</style>
