<template>
<div>
    <pivot
           :data="data"
           :fields="fields"
           :available-field-keys="availableFieldKeys"
           :row-field-keys="rowFieldKeys"
           :col-field-keys="colFieldKeys"
           :reducer="reducer"
           >
    </pivot>
</div>
</template>

<script>
import Pivot from '@marketconnect/vue-pivot-table'
export default {
  components: { Pivot },
  data: function() {
    return {
      data:[
            {"country": "United States", "year": 2010, "gender": "male", "count": 153295220},
            {"country": "United States", "year": 2010, "gender": "female", "count": 156588400},
            {"country": "United States", "year": 2011, "gender": "male", "count": 154591960},
            {"country": "United States", "year": 2011, "gender": "female", "count": 157800200},
            {"country": "United States", "year": 2012, "gender": "male", "count": 155851840},
            {"country": "United States", "year": 2012, "gender": "female", "count": 158944800},
            {"country": "China", "year": 2010, "gender": "male", "count": 690256342},
            {"country": "China", "year": 2010, "gender": "female", "count": 650712406},
            {"country": "China", "year": 2011, "gender": "male", "count": 694106441},
            {"country": "China", "year": 2011, "gender": "female", "count": 654068030},
            {"country": "China", "year": 2012, "gender": "male", "count": 697964288},
            {"country": "China", "year": 2012, "gender": "female", "count": 657422649},
            {"country": "India", "year": 2010, "gender": "male", "count": 638354751},
            {"country": "India", "year": 2010, "gender": "female", "count": 592629727},
            {"country": "India", "year": 2011, "gender": "male", "count": 646873890},
            {"country": "India", "year": 2011, "gender": "female", "count": 600572093},
            {"country": "India", "year": 2012, "gender": "male", "count": 655193693},
            {"country": "India", "year": 2012, "gender": "female", "count": 608395922},
            {"country": "France", "year": 2010, "gender": "male", "count": 30675773},
            {"country": "France", "year": 2010, "gender": "female", "count": 32285363},
            {"country": "France", "year": 2011, "gender": "male", "count": 30815839},
            {"country": "France", "year": 2011, "gender": "female", "count": 32452566},
            {"country": "France", "year": 2012, "gender": "male", "count": 30948916},
            {"country": "France", "year": 2012, "gender": "female", "count": 32612882}
            ],
      asyncData: [],

      // Pivot params
      fields: [{
        key: 'country',
        getter: item => item.country,
        label: 'Country',
        valueFilter: true
      }, {
        key: 'gender',
        getter: item => item.gender,
        label: 'Gender',
        valueFilter: true
      }, {
        key: 'year',
        getter: item => item.year,
        label: 'Year',
        valueFilter: true
      }],
      availableFieldKeys: [],
      rowFieldKeys: ['country', 'gender'],
      colFieldKeys: ['year'],
      reducer: (sum, item) => sum + item.count,
      defaultShowSettings: true,
      isDataLoading: false,
    }
  }
}
</script>
