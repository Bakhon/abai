<template>
  <div class="table-page">
<!--    <b-table :items="pipeSegments" thead-class="hidden_header"/>-->
    <table class="table table-bordered table-dark">
      <tbody v-if="pipeSegments">
        <tr v-for="segment in pipeSegments">
          <template v-for="(column, index) in segment">
            <th v-if="index == 0" scope="row" >{{column}}</th>
            <td v-else>{{column}}</td>
          </template>

        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  name: "pipeLongInfo",
  props: {
    pipe: Object
  },
  data() {
    return {
      fields: [
        {
          name: 'Pin (atm)',
          field: 'pin'
        },
        {
          name: 'Pout (atm)',
          field: 'pout'
        },
        {
          name: 'Tin (C)',
          field: 'tin'
        },
        {
          name: 'Tout (C)',
          field: 'tout'
        },
        {
          name: 'EV (m/s)',
          field: 'ev'
        },
        {
          name: 'Vliq (m/s)',
          field: 'vliq'
        },
        {
          name: 'Vgas (m/s)',
          field: 'vgas'
        },
        {
          name: 'Vm (m/s)',
          field: 'vm'
        },
        {
          name: 'Comment',
          field: 'comment'
        }
      ]
    }
  },
  computed: {
    pipeSegments () {
      let segments = [];

      this.fields.forEach((field, fIndex) => {
        segments[fIndex] = [field.name];
        this.pipe.hydro_calc_long.forEach((segment, sIndex) => {
          segments[fIndex].push(segment[field.field]);
        })
      });

      return segments;
    }
  }
}
</script>

<style lang="scss" scoped>
.table {
  //border: 1px solid #454D7D;
  //color: white !important;
}
</style>