<template>
  <div class="main-page">
    <div class="main-page__inner">
      <div class="main-page__logo">
          <img src="/img/icons/main_logo.svg" alt="">
      </div>
      <div class="main-page__search">
        <input placeholder="Введите текст" type="text" v-model="query">
        <button>
          <span>Поиск</span>
        </button>
      </div>
      <div class="d-flex justify-content-start w-100">
        <div
            class="main-page__blocks-item"
            v-for="(block, index) in filteredBlocks"
            :key="`mainpage_block_${index}`"
        >
            <div v-if="block.children && block.children.length"
                 class="main-page__blocks-item-bg position-relative mb-3 mx-auto">
                <a :href="block.url">
                    <span class="main-page__blocks-item-bg-img p-1 pb-3">
                        <div class="main-page__blocks-item-bg-img-children align-items-center p-2">
                            <a :href="block.url" class="main-page__blocks-item-bg-img">
                                <img :src="'/img/icons/' + block.icon" alt="">
                            </a>
                        </div>
                    </span>
                    <span @click.stop.prevent="childMenuToggle(index)"
                          class="toggle-btn">
                        <img width="12" src="/img/icons/small_arrow.svg"
                             :class="{inverted: childMenuCollapseList[index].value}" alt="">
                    </span>
                </a>
                <div
                    class="main-page__blocks-children p-3"
                    :class="{'collapse': childMenuCollapseList[index].value}">
                    <h3 class="my-3">Модули "{{ block.name }}"</h3>
                    <div class="d-flex justify-content-between my-4">
                        <div
                            class="main-page__blocks-child-item"
                            v-for="(child, i) in block.children"
                            :key="`mainpage_block_${index}_${i}`">
                            <div class="main-page__blocks-child-item-bg mx-auto">
                                <a :href="child.url" class="main-page__blocks-item-bg-img">
                                    <img :src="'/img/icons/' + child.icon" alt="">
                                </a>
                            </div>
                            <a :href="child.url" class="main-page__blocks-child-item-name">{{ child.name }}</a>
                        </div>
                    </div>
                </div>
            </div>
          <div v-else class="main-page__blocks-item-bg mx-auto mb-3">
            <a :href="block.url" class="main-page__blocks-item-bg-img">
                <img :src="'/img/icons/' + block.icon" alt="">
            </a>
          </div>
          <a :href="block.url" class="main-page__blocks-item-name">{{ block.name }}</a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  name: "main-page",
  data() {
    return {
      query: '',
      blocks: [
        {
          name: 'База данных',
          icon: 'bigdata.svg',
          url: this.localeUrl('/bigdata'),
          children: [
            {
              name: 'Формы ввода',
              icon: 'wells.svg',
              url: this.localeUrl('/bigdata/wells'),
            },
            {
              name: 'Регистрация скважины',
              icon: 'wells_create.svg',
              url: this.localeUrl('/bigdata/wells/create'),
            },
            {
              name: 'Карточка скважины',
              icon: 'well_card.svg',
              url: this.localeUrl('/bigdata/well-card'),
            },
          ]
        },
        {
          name: 'Центр визуализации',
          icon: 'visual_center.svg',

          url: this.localeUrl('/visualcenter3')
        },
        {
          name: 'Технологический режим',
          icon: 'tr.svg',
          url: this.localeUrl('/tr')
        },
        {
          name: 'Подбор ГНО',
          icon: 'podborgno.svg',
          url: this.localeUrl('/podborgno')
        },
        {
          name: 'Мониторинг осложнений',
          icon: 'monitor.svg',
          url: this.localeUrl('/tech-map')
        },
        {
          name: 'Подбор и АЭГТМ',
          icon: 'paegtm.svg',
          url: this.localeUrl('/paegtm')
        },
        {
          name: this.trans('economic_reference.economic_module_short'),
          icon: "nrs.svg",
          url: this.localeUrl('/economic/nrs')
        },
        {
          name: 'Цифровое бурение',
          icon: 'digital-drilling.svg',

          url: this.localeUrl('/digital-drilling/')
        },
        {
          name: this.trans('economy_pf.economy'),
          icon: 'economy-kenje.svg',
          url: this.localeUrl('/module_economy/proactive-factors/')
        },
        {
          name: this.trans('plast_fluids.pf'),
          icon: 'plastFluidsMain.svg',
          url: this.localeUrl('/pf')
        }
      ],
        childMenuCollapseList: [
            {
                value: true,
            }
        ],
    }
  },
  computed: {
    filteredBlocks() {
      if(this.query.length > 0) {
        return this.blocks.filter(block => {
          return block.name.toLowerCase().indexOf(this.query.toLowerCase()) > -1
        })
      }
      return this.blocks
    }
  },
  created() {
  },
  methods: {
      childMenuToggle(index) {
          this.childMenuCollapseList[index].value = !this.childMenuCollapseList[index].value;
      }
  },
}
</script>
<style lang="scss" scoped>
.toggle-btn {
    display: block;
    margin-top: -18px;
}

.inverted {
    transform: rotate(-180deg);
}
</style>