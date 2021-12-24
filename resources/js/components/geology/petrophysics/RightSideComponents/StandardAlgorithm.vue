<template>
<div>
  <ToolBlock title="Выбор кривых" class="mb-2">
    <div class="p-2">
      <div class="buttons-grid">
        <Button color="accent" align="center">GR</Button>
        <Button color="accent" align="center">NPHI</Button>
        <Button color="accent" align="center">SP</Button>
        <Button color="accent" align="center">RHOB</Button>
        <Button color="accent" align="center">LLD</Button>
        <Button color="accent" align="center">SONIC</Button>
      </div>
    </div>
  </ToolBlock>
  <Button class="mb-2 w-100" color="gray" align="center" @click="demoModal = true">Константы</Button>
  <Button class="mb-2 w-100" color="primary" align="center">Старт</Button>
  <dropdown multiple :selected-value.sync="multipleSelect" block class="w-100 mb-2" button-text="Результаты"
            :options="[
        {label: 'Option 0'},
        {label: 'Option 1'},
        {label: 'Option 2'},
        {label: 'Option 3'},
    ]" />
  <AwModal position="top" size="xl" title="Список скважин" :is-show.sync="demoModal">
    <div class="scroll-table">
      <table class="aw-table w-100 no-padding center">
        <thead>
        <tr>
          <th rowspan="2">Well</th>
          <th rowspan="2">Горизонты</th>
          <th>DTPGL</th>
          <th>RHOBGL</th>
          <th rowspan="2">Oxf_ngld</th>
          <th rowspan="2">Val_ngld</th>
          <th rowspan="2">x</th>
          <th rowspan="2">y</th>
          <th>RW</th>
          <th>PHIE_cut</th>
          <th>VSH_fin_cut</th>
          <th>GR_max</th>
          <th>GR_min</th>
          <th>SP_max</th>
          <th>SP_min</th>
        </tr>
        <tr>
          <th>us/m</th>
          <th>g/cm3</th>
          <th>ohmm</th>
          <th>v/v</th>
          <th>v/v</th>
          <th>gapi</th>
          <th>gapi</th>
          <th>mV</th>
          <th>mV</th>
        </tr>
        </thead>
        <tbody>
        <tr>
          <td>UZN_6979</td>
          <td>Val</td>
          <td>340</td>
          <td>2,3</td>
          <td>1,05</td>
          <td>0,5127</td>
          <td>-0,1833</td>
          <td>0,5633</td>
          <td>0,034</td>
          <td>0,14</td>
          <td>0,38</td>
          <td>140</td>
          <td>55</td>
          <td>90</td>
          <td>30</td>
        </tr>
        </tbody>
      </table>
    </div>
  </AwModal>
</div>
</template>

<script>
import Button from "../../components/buttons/Button";
import ToolBlock from "../../components/toolBlock/ToolBlock";
import dropdown from "../../components/dropdowns/dropdown";
import AwInput from "../../components/form/AwInput";
import AwModal from "../../components/notifications/awModal/AwModal";
export default {
  name: "StandardAlgorithm",
  components:{
    ToolBlock,
    dropdown,
    AwInput,
    Button,
    AwModal
  },

  data(){
    return {
      multipleSelect: [],
      demoModal: false,
    }
  },
}
</script>

<style scoped lang="scss">
.buttons-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  grid-gap: 10px;
}
</style>
