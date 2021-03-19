<template>
  <div class="big-numbers">
    <!-- <h4>Цифровые показатели</h4> -->
    <div class="big-numbers__list">
      <div v-for="item in numbers" :key="item.name" class="big-numbers__item">
        <div class="big-numbers__count h2">{{ item.count }}</div>
        <div class="big-numbers__name">{{ item.name }}</div>
        <div class="big-numbers__percentbar">
          <div
            class="big-numbers__percentbar--fill"
            :style="{ flexBasis: item.percent + '%' }"
          ></div>
          <div class="big-numbers__percentbar--empty"></div>
        </div>
        <div class="big-numbers__percent">
          <span>{{ item.percent }}%</span>
          <span>100%</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "BigNumbers",
  components: {
  },
  props: {
    list: {
      type: Array,
      default() {
        return [];
      },
    },
    param: {
      type: String,
      default: "exp_meth",
    },
    baseName: {
      type: String,
      default() {
        return `${this.trans('tr.trbn1')}`;
      },
    },
    nameAlias: {
      type: String,
      default() {
        return [`${this.trans('tr.trbn2')}`, `${this.trans('tr.trbn3')}`, `${this.trans('tr.trbn4')}`, `${this.trans('tr.trbn5')}`];
      },
    },
    paramValues: {
      type: Array,
      default() {
        return ["ЭЦН", "ШГН", "Фонтан", "П-лифт"];
      },
    },
  },
  computed: {
    numbers() {
      const newNumbers = [];
      let list;
      if (this.list && this.list.length > 0) list = this.list;
      else list = [];
      newNumbers.push({
        name: this.baseName,
        count: list.length,
        percent: 100,
      });
      const parsedList = list.reduce((acc, res) => {
        const param = this.getStringOrFirstItem(res, this.param);
        acc[param] = acc[param] ? acc[param] + 1 : 1;
        return acc;
      }, {});
      for (let key in parsedList) {
        // Если понадобится выводить все параметры без выбора их из списка нужных, то props paramValues=[]
        if (
          this.paramValues.length === 0 ||
          this.paramValues.indexOf(key) !== -1
        ) {
          newNumbers.push({
            name: `${this.nameAlias[this.paramValues.indexOf(key)]}`,
            count: parsedList[key],
            percent: ((parsedList[key] / newNumbers[0].count) * 100).toFixed(2),
          });
        }
      }
      for (let key of this.paramValues) {
        if (!parsedList[key]) {
          newNumbers.push({
            name: `${this.nameAlias[this.paramValues.indexOf(key)]}`,
            count: 0,
            percent: 0,
          });
        }
      }
      return newNumbers;
    },
  },
  methods: {
    getStringOrFirstItem(el, param) {
      return Array.isArray(el[param]) ? el[param][0] : el[param];
    },
  },
};
</script>

<style  scoped>
.big-numbers {
  color: #fff;
  flex-basis: 300px;
  max-width: 100%;
  flex-grow: 0;
  flex-shrink: 0;
  margin-left: 13px;
  box-sizing: border-box;
}
.big-numbers__list {
  display: flex;
  flex-direction: column;
  height: 100%;
}
.big-numbers__list :first-child {
  margin-top: 0;
}
.big-numbers__list :last-child {
  margin-bottom: 0;
}
.big-numbers__item {
  padding: 5px 20px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  background: #272953;
  margin-top: 13px;
  flex-grow: 1;
}
.big-numbers__name {
  font-size: 17px;
  line-height: 20px;
  margin-bottom: 5px;
}
.big-numbers__count {
  font-size: 40px;
  font-weight: bold;
}
.big-numbers__percentbar {
  display: flex;
  width: 100%;
  height: 4px;
}
.big-numbers__percentbar--fill {
  flex-grow: 0;
  flex-shrink: 0;
  background: #2e50e9;
}
.big-numbers__percentbar--empty {
  flex-grow: 1;
  flex-basis: 0;
  flex-shrink: 0;
  background: #4f5281;
}
.big-numbers__percent {
  display: flex;
  justify-content: space-between;
  font-size: 10px;
}
</style>
