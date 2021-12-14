<template>
  <div>
    <div class="rect mb-2">
      <div class="d-flex justify-content-between">
        <div class="d-flex mr-2">
          <Button align="center"  ref="button_1" class="mr-2" size="small">GRmin</Button>
          <label class="align-self-center">
            Линия песчаника
          </label>
        </div>
        <AwTextarea class="text"/>
      </div>
    </div>

    <div class="rect mb-2">
      <div class="d-flex justify-content-between">
        <div class="d-flex mr-2">
          <Button align="center"  ref="button_2" class="mr-2" size="small">GRmax</Button>
          <label class="align-self-center">
            Линия глин
          </label>
        </div>
        <AwTextarea class="text"/>
      </div>
    </div>

    <div class="rect mb-2">
      <div class="d-flex justify-content-between">
        <div class="d-flex mr-2">
          <Button align="center"  ref="button_3" class="mr-2" size="small">SPmax</Button>
          <label class="align-self-center">
            Макс. значения ПС
          </label>
        </div>
        <AwTextarea class="text"/>
      </div>
    </div>

    <div class="rect mb-2">
      <div class="d-flex justify-content-between">
        <div class="d-flex mr-2">
          <Button align="center"  ref="button_4" class="mr-2" size="small">DTPGL</Button>
          <label class="align-self-center">
            Значения АК на глинах
          </label>
        </div>
        <AwTextarea class="text"/>
      </div>
    </div>

    <div class="rect mb-2">
      <div class="d-flex justify-content-between">
        <div class="d-flex mr-2">
          <Button align="center"  ref="button_5" class="mr-2" size="small">DTPm</Button>
          <label class="align-self-center">
            Значения АК на матрице
          </label>
        </div>
        <AwTextarea class="text"/>
      </div>
    </div>

    <div class="rect mb-2">
      <div class="d-flex justify-content-between">
        <div class="d-flex mr-2">
          <Button align="center"  ref="button_6" class="mr-2" size="small">RHOBGL</Button>
          <label class="align-self-center">
            Значения ГГК на глинах
          </label>
        </div>
        <AwTextarea class="text"/>
      </div>
    </div>

    <div class="rect mb-2">
      <div class="d-flex justify-content-between">
        <div class="d-flex mr-2">
          <Button align="center"  ref="button_7" class="mr-2" size="small">RHOBm</Button>
          <label class="align-self-center">
            Значения ГГК на матрице
          </label>
        </div>
        <AwTextarea class="text"/>
      </div>
    </div>

    <div class="rect mb-2">
      <div class="d-flex justify-content-between">
        <div class="d-flex mr-2">
          <Button align="center"  ref="button_8" class="mr-2" size="small">NGK_Oxf</Button>
          <label class="align-self-center">
            Значения НГК на Оксфорде
          </label>
        </div>
        <AwTextarea class="text"/>
      </div>
    </div>

    <div class="rect mb-2">
      <div class="d-flex justify-content-between">
        <div class="d-flex mr-2">
          <Button align="center"  ref="button_9" class="mr-2" size="small">NGK_val</Button>
          <label class="align-self-center">
            Значения НГК на валажине
          </label>
        </div>
        <AwTextarea class="text"/>
      </div>
    </div>

    <div class="rect mb-2">
      <div class="d-flex justify-content-between">
        <div class="d-flex mr-2">
          <Button align="center"  ref="button_10" class="mr-2" size="small">RW</Button>
          <label class="align-self-center">
            Сопротивление пластовой воды
          </label>
        </div>
        <AwTextarea class="text"/>
      </div>
    </div>

    <div class="rect mb-2">
      <div class="d-flex justify-content-between">
        <div class="d-flex mr-2">
          <Button align="center"  ref="button_11" class="mr-2" size="small">TEMP</Button>
          <label class="align-self-center">
            Температура пластовой воды
          </label>
        </div>
        <AwTextarea class="text"/>
      </div>
    </div>

  </div>
</template>

<script>
import Button from "../../components/buttons/Button";
import AwTextarea from "../../components/form/AwTextarea";
export default {
  name: "SecondComponent",
  components:{
    Button,
    AwTextarea
  },
}
</script>

<style scoped lang="scss">
    .rect{
      border: 1px solid #545580;
      background: #363B68;
      padding: 6px;
      button{
        min-width: 55px;
      }
      .text {
        width: 103px;
      }
    }
</style>
