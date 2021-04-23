<template>
  <select
      v-model="form.field_id"
      class="form-control text-white bg-main4-important border-0"
      @change="$emit('change')"
  >
    <option
        v-for="field in fields"
        :key="field.id"
        :value="field.id">
      {{ field.name }}
    </option>
  </select>
</template>

<script>
const FIELDS = [
  {value: 'UZN', org: 2, label: 'Узень'},
  {value: 'KMB', org: 2, label: 'Карамандыбас'},
  {value: 'NBZ', org: 5, label: 'Новобагатинск Западный'},
  {value: 'KSG', org: 5, label: 'Косшагил'},
  {value: 'ZKS', org: 5, label: 'Карасор Западный'},
  {value: 'BNS', org: 5, label: 'Байчунас'},
  {value: 'NRG', org: 5, label: 'С.Нуржанов'},
  {value: 'VMT', org: 5, label: 'В.Макат'},
  {value: 'GRN', org: 5, label: 'Гран'},
  {value: 'KLR', org: 5, label: 'Кульсары'},
  {value: 'AKD', org: 5, label: 'Аккудук'},
  {value: 'ATB', org: 5, label: 'Актюбе'},
  {value: 'UAZ', org: 5, label: 'УАЗ'},
  {value: 'VMB', org: 5, label: 'Восточный Молдабек'},
  {value: 'KRK', org: 5, label: 'Карсак'},
  {value: 'UZS', org: 5, label: 'УАЗ Северный'},
  {value: 'UZV', org: 5, label: 'УАЗ'},
  {value: 'ZHT', org: 5, label: 'Жанаталап'},
  {value: 'UVK', org: 5, label: 'Ю-В Камышитовое'},
  {value: 'SJB', org: 5, label: 'С.Жолдыбай'},
  {value: 'UZK', org: 5, label: 'Ю-З Камышитовое'},
  {value: 'JLM', org: 5, label: 'Б.Жоламанов'},
  {value: 'ZPV', org: 5, label: 'Западная Прорва'},
  {value: 'ATK', org: 5, label: 'Алтыколь'},
  {value: 'AKG', org: 5, label: 'Акингень'},
  {value: 'BTN', org: 5, label: 'Ботахан'},
  {value: 'BLG', org: 5, label: 'С.Балгимбаев'},
  {value: 'KSB', org: 5, label: 'Кисимбай'},
  {value: 'ZBN', org: 5, label: 'Забурунье'},
  {value: 'SKS', org: 5, label: 'Северный Котыртас'},
  {value: 'KRT', org: 5, label: 'Каратон'},
  {value: 'DMB', org: 5, label: 'Досмухамбетовское'},
  {value: 'UVN', org: 5, label: 'Новобогатинск Ю-В'},
  {value: 'KKR', org: 5, label: 'Кошкар'},
  {value: 'TNU', org: 5, label: 'Терен-Узек'},
  {value: 'KZH', org: 3, label: 'Каражанбас'},
  {value: 'AKH', org: 4, label: 'Акшабулак'},
  {value: 'AKS', org: 4, label: 'Аксай'},
  {value: 'NUR', org: 4, label: 'Нуралы'},
  {value: 'ALA', org: 6, label: 'Ала-Тюбе'},
  {value: 'BEK', org: 6, label: 'Бектурлы'},
  {value: 'JET', org: 6, label: 'Жетыбай'},
  {value: 'ATA', org: 6, label: 'Атанбай'},
  {value: 'PRI', org: 6, label: 'Придорожное'},
  {value: 'VOS', org: 6, label: 'Восточный Жетыбай'},
  {value: 'ASA', org: 6, label: 'Асар'},
  {value: 'KAL', org: 6, label: 'Каламкас'},
  {value: 'SAK', org: 6, label: 'Сев.Аккар'},
  {value: 'ASH', org: 6, label: 'Ашиагар'},
  {value: 'UJE', org: 6, label: 'Ю.Жетыбай'},
  {value: 'BUR', org: 6, label: 'Бурмаша'},
  {value: 'SKA', org: 6, label: 'Сев.Карагие'},
  {value: 'AIR', org: 6, label: 'Айрантакыр'},
  {value: 'OIM', org: 6, label: 'Оймаша'},
]

export default {
  name: "SelectField",
  props: {
    form: {
      required: true,
      type: Object
    },
    org_id: {
      required: true,
      type: Number
    }
  },
  data: () => ({
    fields: []
  }),
  created() {
    this.getFields()
  },
  methods: {
    async getFields() {
      this.form.field_id = null

      this.fields = [{
        id: null,
        name: this.trans('economic_reference.select_field')
      }]

      const params = {org_id: this.form.org_id}

      const {data} = await this.axios.get(this.localeUrl('/fields'), {params: params})

      this.fields = [...this.fields, ...data.fields]
    },
  },
  watch: {
    org_id() {
      this.getFields()
    }
  }

}
</script>

<style scoped>
.bg-main4-important {
  background-color: #333975;
}
</style>