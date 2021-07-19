<template>
  <div class="d-flex list-of-wells__modal align-items-stretch">
    <div class="list-of-wells__modal__buttons-panel d-flex flex-column">
      <Button size="narrow" icon="rightwardsArrow" class="mb-2"/>
      <Button size="narrow" icon="AppendXYHingeToXSection" class="mb-2"/>
      <Button size="narrow" icon="downwardsArrow" class="mb-2"/>
      <Button size="narrow" icon="upwardsArrow" class="mb-2"/>
      <Button size="narrow" icon="copy" class="mb-2"/>
      <Button size="narrow" icon="remove" class="mb-2"/>
      <Button size="narrow" icon="returnButton" class="mb-2"/>
      <Button size="narrow" icon="AddPaddingToTheXScreen" class="mb-2" />
    </div>
    <div class="list-of-wells__modal__content d-flex flex-column customScroll">
      <div class="d-flex align-items-center list-of-wells__modal__content__item mb-2" v-for="(item, i) in listOfWills" :key="i">
        <Icon width="12" height="18" name="oilTower" fill="#5B78FC" class="mr-3"/>
        <label class="d-flex align-items-center m-0">
          <input type="checkbox" v-if="item.value" :value="item.value" class="mr-3">
          <span>{{item.label}}</span>
        </label>
      </div>
    </div>
  </div>
</template>

<script>
import Button from "../../components/buttons/Button";
import Icon from "../../components/icons/Icon"
export default {
  name: "ListOfWells",
  components:{
    Button,
    Icon
  },
  data(){
    return {
      listOfWills: [
        {label: "Default fence settings"},
        {label: "321", value: "test2"},
        {label: "322", value: "test2"},
        {label: "656", value: "test2"},
        {label: "367", value: "test2"},
        {label: "533", value: "test2"},
        {label: "316", value: "test2"},
        {label: "527", value: "test2"},
        {label: "81", value: "test2"},
        {label: "XY 1", value: "test2"},
        {label: "1RV", value: "test2"},
        {label: "53_bc", value: "test2"},
        {label: "319", value: "test2"},
        {label: "501", value: "test2"},
        {label: "53", value: "test2"},
        {label: "54", value: "test2"},
        {label: "XY 2", value: "test2"},
        {label: "150", value: "test2"},
        {label: "8", value: "test2"},
        {label: "500", value: "test2"},
        {label: "149", value: "test2"},
        {label: "8_bc", value: "test2"},
        {label: "56", value: "test2"},
        {label: "57", value: "test2"},
        {label: "176", value: "test2"},
        {label: "Test2", value: "test2"},
        {label: "Test2", value: "test2"},
        {label: "Test2", value: "test2"},
        {label: "Test2", value: "test2"},
        {label: "Test2", value: "test2"},
        {label: "Test2", value: "test2"},
        {label: "Test2", value: "test2"},
        {label: "Test2", value: "test2"},
        {label: "Test2", value: "test2"},
        {label: "Test2", value: "test2"},
        {label: "Test2", value: "test2"},
        {label: "Test2", value: "test2"},
        {label: "Test2", value: "test2"},
        {label: "Test2", value: "test2"},
        {label: "Test2", value: "test2"},
        {label: "Test2", value: "test2"},
        {label: "Test2", value: "test2"},
        {label: "Test2", value: "test2"},
        {label: "Test2", value: "test2"},
        {label: "Test2", value: "test2"},
        {label: "Test2", value: "test2"},
        {label: "Test2", value: "test2"},
        {label: "Test2", value: "test2"},
        {label: "Test2", value: "test2"},
        {label: "Test2", value: "test2"},
        {label: "Test2", value: "test2"},
        {label: "Test2", value: "test2"},
      ]
    }
  }
}
</script>

<style scoped lang="scss">
.list-of-wells__modal{
  &__content{
    max-height: 692px;
    width: 100%;
    overflow-y: auto;
    background: var(--a-accent-400);
    padding: 10px 14px;
    &__item{
      color: #fff;
      label{
        font-size: 14px;
        font-weight: 400;
        span{
          line-height: 1;
        }
      }
    }
  }
  &__buttons-panel{
    background: var(--a-accent-darken-100);
    padding: 14px 22px;
    border-right: 1px solid var(--a-default);
  }
}
</style>
