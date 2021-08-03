<template>
  <div>
    <div class="d-flex align-items-center">
    <LinkButton has-check-active href="/geology/petrophysics" color="accent" icon="moleqq" class="flex-grow-1 mr-3" align="left">
      Загрузка данных
    </LinkButton>
    <LinkButton has-check-active href="/geology/core" color="accent" icon="kern" class="flex-grow-1 mr-3" align="left">
      Анализ данных
    </LinkButton>
    <LinkButton has-check-active href="/geology/visualization" color="accent" icon="d3" class="flex-grow-1 mr-3" align="">
      Выгрузка данных
    </LinkButton>
  </div>
  <div class="geology-l-side__top d-flex align-items-start w-100">
      <button class="geology-l-side__toggle">
        <Icon name="arrowLeft" />
      </button>
      <div class="w-100 mb-2">
        <Button align="left" color="accent" class="w-100 mb-2">Выбор месторождения</Button>
      </div>
  </div>
  <ToolBlock class="mb-2" title="Выбор горизонта">
      <ToolBlockList
          @click="selectedHandle"
          :selected.sync="listSelect"
          description="Выбор с 1м/5м"
          has-checkbox
          :list="[
              {label: '1 m', value: '1m'},
              {label: 'Ящик/Коробка', value: 'box'},
          ]"
      />
    </ToolBlock>
  <ToolBlock class="mb-2" title="Выбор УФ/ Дневной">
    <ToolBlockList
        @click="selectedHandle"
        :selected.sync="listSelect"
        has-checkbox
        :list="[
            {label: 'УФ', value: 'УФ'},
            {label: 'Дневной', value: 'Дневной'},
        ]"
    />
  </ToolBlock>
  <ToolBlock class="mb-2" title="Список файлов">
    <ToolBlockList
        @click="selectedHandle"
        :selected.sync="listSelect"
        has-checkbox
        :list="[
            {label: 'ZN_0001_1000_1001_WL.jpeg', value: 'ZN_0001_1000_1001_WL.jpeg'},
            {label: 'ZN_0001_1000_1001_WL.jpeg', value: 'ZN_0001_1000_1001_WL.jpeg'},
        ]"
    />
  </ToolBlock>
  <div class="rect mb-3">
      <div class="d-flex align-items-center">
        <Button @click.native="gridSwapperActiveID = 'item1'" icon="i3d" class="flex-grow-1 mr-3" align="center"
                :color="gridSwapperActiveButton('item1')">
          3D window 3(Any)
        </Button>
        <Button @click.native="gridSwapperActiveID = 'item2'" icon="i2d" class="flex-grow-1 mr-3" align="center"
                :color="gridSwapperActiveButton('item2')">
          2D window 5(Any)
        </Button>
        <Button @click.native="gridSwapperActiveID = 'item3'" icon="interpret" class="flex-grow-1 mr-3" align="center"
                :color="gridSwapperActiveButton('item3')">
          Interpretation window 3 (TVD) - Asar_3DLand_IL2002_3193_KPSDMstk_AGC_zph_dtm150_v1 (realized) 1 - Seismic Time
          5...
        </Button>
      </div>
    </div>
  </div>
</template>

<script>
import LinkButton from "../../geology/components/buttons/LinkButton";
import Button from "../../geology/components/buttons/Button";
import Icon from "../../geology/components/icons/Icon";
import ToolBlock from "../../geology/components/toolBlock/ToolBlock";
import ToolBlockList from "../../geology/components/toolBlock/ToolBlockList";

export default {
  name: "SuperTemplatePvtPlastOil",
  components: {
    LinkButton,
    Button,
    Icon,
    ToolBlock,
    ToolBlockList
  },
  data() {
    return {
      gridSwapperActiveID: "item1",
      dropdownValue: {
        value: null
      }
    }
  },
  methods: {
    gridSwapperActiveButton(id) {
      return this.gridSwapperActiveID === id ? 'primary' : 'accent';
    },
    gridSwapperItemsClasses(id) {
      return {
        "grid-swapper__item": true,
        "active": this.gridSwapperActiveID === id
      }
    }
  }
  // computed:{
  //   cListSelect(){
  //     return this.listSelect
  //   }
  // },
  // methods:{
  //   selectedHandle(item){
  //     if(this.cListSelect.includes(item.value)){
  //       const index = this.cListSelect.indexOf(item.value)
  //       return this.listSelect.splice(index, 1);
  //     }
  //     this.listSelect.push(item.value);
  //   }
  // }

}
</script>

<style lang="scss" scoped>
.geology-l-side{
  &__toggle{
    border: none;
    background: var(--a-accent);
    margin: -6px 10px 0 -7px;
    padding: 14px 6px;
    border-radius: 0 10px 10px 0;
  }
}

</style>