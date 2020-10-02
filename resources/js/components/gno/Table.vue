<template>
  <div class="main col-md-12 col-lg-12 row">
    <div class="tables-one col-xs-12 col-sm-5 col-md-5 col-lg-3 col-xl-2">
      <div class="tables-string-gno col-12">
        <div class="select-well col-12">Выбор скважины</div>
        <div class="cell4-gno col-7">Месторождение</div>
        <div class="cell4-gno table-border-gno cell4-gno-second col-5">
          Узень
        </div>

        <div class="cell4-gno table-border-gno-top col-7">Скважина №</div>
        <div
          class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
        >
          6550
        </div>

        <div class="cell4-gno table-border-gno-top col-7">Пласт</div>
        <div
          class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
        >
          14Осн
        </div>

        <div class="cell4-gno table-border-gno-top col-7">
          Новая скважина <input class="checkbox0" type="checkbox" />
        </div>
        <div
          class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
        >
          с ГРП <input class="checkbox0" type="checkbox" />
        </div>

        <div class="cell4-gno table-border-gno-top col-7">ЦДНГ-13</div>
        <div
          class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
        >
          ГУ-101
        </div>

        <div class="cell4-gno table-border-gno-top col-7">НГДУ-1</div>
        <div
          class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
        >
          АО «ОМГ»
        </div>
      </div>
      <div class="tables-string-gno">
        <div class="select-well col-12">Конструкция</div>
        <div class="cell4-gno col-7">Наружн. ØЭК</div>
        <div class="cell4-gno table-border-gno cell4-gno-second col-5">
          168 мм
        </div>

        <div class="cell4-gno table-border-gno-top col-7">Внутрен. ØЭК</div>
        <div
          class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
        >
          150 мм
        </div>

        <div class="cell4-gno table-border-gno-top col-7">Нперф.(ВДП MD)</div>
        <div
          class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
        >
          1352 м
        </div>

        <div class="cell4-gno table-border-gno-top col-7">Удл. на Нперф.</div>
        <div
          class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
        >
          4 м
        </div>

        <div class="cell4-gno table-border-gno-top col-7">Текущий забой</div>
        <div
          class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
        >
          1369 м
        </div>
      </div>
      <div class="inclinom">Инклинометрия</div>

      <!-- <div class="tables-string-gno1">
        <select class="select-gno">
          <option value="" hidden>Оборудование</option>
          <option>Арбуз</option>
          <option>Длинный-предлинный пункт</option>
          <option>Дыня</option>
          <option>Тыква</option>
        </select>
      </div>
      <div class="tables-string-gno1">
        <select class="select-gno">
          <option value="" hidden>PVT</option>
          <option>Арбуз</option>
          <option>Длинный-предлинный пункт</option>
          <option>Дыня</option>
          <option>Тыква</option>
        </select>
      </div>-->

      <div class="spoiler">
        <!--* Добавлен tabindex="-1" для снятия фокуса при переходе по "tab" -->
        <input
          style="width: 545px; height: 45px;"
          type="checkbox"
          tabindex="-1"
        />
        <div class="box">
          <div class="select-well col-12">
            <div class="select-gno">Оборудование</div>
          </div>
          <span class="closer">Скрыть</span><span class="open">Показать</span>
          <blockquote>
            <div class="cell4-gno col-7">Qж</div>
            <div class="cell4-gno table-border-gno cell4-gno-second col-5">
              55 м3/сут
            </div>

            <div class="cell4-gno table-border-gno-top col-7">Qж</div>
            <div
              class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
            >
              10 т/сут
            </div>

            <div class="cell4-gno table-border-gno-top col-7">Обв.</div>
            <div
              class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
            >
              82 %
            </div>

            <div class="cell4-gno table-border-gno-top col-7">Рзаб</div>
            <div
              class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
            >
              68 ат
            </div>

            <div class="cell4-gno table-border-gno-top col-7">Рпл</div>
            <div
              class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
            >
              124 ат
            </div>

            <div class="cell4-gno table-border-gno-top col-7">Ндин</div>
            <div
              class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
            >
              658
            </div>
            <div class="cell4-gno table-border-gno-top col-7">Рзат</div>
            <div
              class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
            >
              4 ат
            </div>
            <div class="cell4-gno table-border-gno-top col-7">Рбуф</div>
            <div
              class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
            >
              4 ат
            </div>
            <div class="cell4-gno table-border-gno-top col-7">Рлин</div>
            <div
              class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
            >
              4 ат
            </div>
          </blockquote>
        </div>
      </div>

      <div class="spoiler">
        <!--* Добавлен tabindex="-1" для снятия фокуса при переходе по "tab" -->
        <input
          style="width: 545px; height: 45px;"
          type="checkbox"
          tabindex="-1"
        />
        <div class="box">
          <div class="select-well col-12">
            <div class="select-gno">PVT</div>
          </div>
          <span class="closer">Скрыть</span><span class="open">Показать</span>
          <blockquote>
            <div class="cell4-gno col-7">Qж</div>
            <div class="cell4-gno table-border-gno cell4-gno-second col-5">
              55 м3/сут
            </div>

            <div class="cell4-gno table-border-gno-top col-7">Qж</div>
            <div
              class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
            >
              10 т/сут
            </div>

            <div class="cell4-gno table-border-gno-top col-7">Обв.</div>
            <div
              class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
            >
              82 %
            </div>

            <div class="cell4-gno table-border-gno-top col-7">Рзаб</div>
            <div
              class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
            >
              68 ат
            </div>

            <div class="cell4-gno table-border-gno-top col-7">Рпл</div>
            <div
              class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
            >
              124 ат
            </div>

            <div class="cell4-gno table-border-gno-top col-7">Ндин</div>
            <div
              class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
            >
              658
            </div>
            <div class="cell4-gno table-border-gno-top col-7">Рзат</div>
            <div
              class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
            >
              4 ат
            </div>
            <div class="cell4-gno table-border-gno-top col-7">Рбуф</div>
            <div
              class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
            >
              4 ат
            </div>
            <div class="cell4-gno table-border-gno-top col-7">Рлин</div>
            <div
              class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
            >
              4 ат
            </div>
          </blockquote>
        </div>
      </div>

      <div class="tables-string-gno2">
        <div class="select-well col-12">Технологический режим</div>
        <div class="cell4-gno col-7">Qж</div>
        <div class="cell4-gno table-border-gno cell4-gno-second col-5">
          55 м3/сут
        </div>

        <div class="cell4-gno table-border-gno-top col-7">Qж</div>
        <div
          class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
        >
          10 т/сут
        </div>

        <div class="cell4-gno table-border-gno-top col-7">Обв.</div>
        <div
          class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
        >
          82 %
        </div>

        <div class="cell4-gno table-border-gno-top col-7">Рзаб</div>
        <div
          class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
        >
          68 ат
        </div>

        <div class="cell4-gno table-border-gno-top col-7">Рпл</div>
        <div
          class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
        >
          124 ат
        </div>

        <div class="cell4-gno table-border-gno-top col-7">Ндин</div>
        <div
          class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
        >
          658
        </div>
        <div class="cell4-gno table-border-gno-top col-7">Рзат</div>
        <div
          class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
        >
          4 ат
        </div>
        <div class="cell4-gno table-border-gno-top col-7">Рбуф</div>
        <div
          class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
        >
          4 ат
        </div>
        <div class="cell4-gno table-border-gno-top col-7">Рлин</div>
        <div
          class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
        >
          4 ат
        </div>
      </div>
    </div>

    <div class="tables-two col-xs-12 col-sm-7 col-md-7 col-lg-8 col-xl-10">
      <div class="tables-string-gno3">
        <gno-line-points-chart></gno-line-points-chart>
      </div>

      <div class="tables-string-gno4 col-6">
        <div class="select-well col-12">Настройка кривой притока</div>
        <div class="col-12 relative">
          <div class="col-6">
            <div class="cell4-gno col-4">
              Рпл
            </div>
            <div class="cell4-gno table-border-gno cell4-gno-second col-5">
              124 ат
            </div>

            <div class="cell4-gno table-border-gno-top col-4">
              <input class="checkbox" type="radio" name="set" />Кпрод
            </div>
            <div
              class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
            >
              1,4 м3/сут/ат
            </div>

            <div class="cell4-gno table-border-gno-top col-4">
              <input class="checkbox" type="radio" name="set" />Qж
            </div>
            <div
              class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
            >
              46 м3/сут
            </div>
          </div>
        </div>

        <br />
        <br />
        <div class="col-12 relative left-center">
          <div class="cell4-gno col-4 table-border-gno-top">
            <input class="checkbox2" type="radio" name="set2" />
            <div class="text2">Рзаб</div>
          </div>
          <div
            class="cell4-gno table-border-gno cell4-gno-second col-2 table-border-gno-top"
          >
            64 ат
          </div>
          <div
            class="cell4-gno table-border-gno cell4-gno-second col-2 table-border-gno-top"
          ></div>
          <div
            class="cell4-gno table-border-gno cell4-gno-second col-2 table-border-gno-top"
          ></div>
        </div>

        <div class="col-12 relative left-center">
          <div class="cell4-gno col-4 table-border-gno-top">
            <input class="checkbox2" type="radio" name="set2" />
            <div class="text2">Ндин</div>
          </div>
          <div
            class="cell4-gno table-border-gno cell4-gno-second col-2 table-border-gno-top"
          >
            672
          </div>
          <div
            class="cell4-gno table-border-gno cell4-gno-second col-2 table-border-gno-top"
          >
            Рзат
          </div>
          <div
            class="cell4-gno table-border-gno cell4-gno-second col-2 table-border-gno-top"
          >
            4 ат
          </div>
        </div>

        <div class="col-12 relative left-center">
          <div class="cell4-gno col-4 table-border-gno-top">
            <input class="checkbox2" type="radio" name="set2" />
            <div class="text2">Рманом</div>
          </div>
          <div
            class="cell4-gno table-border-gno cell4-gno-second col-2 table-border-gno-top"
          ></div>
          <div
            class="cell4-gno table-border-gno cell4-gno-second col-2 table-border-gno-top"
          >
            Нсп маном
          </div>
          <div
            class="cell4-gno table-border-gno cell4-gno-second col-2 table-border-gno-top"
          ></div>
        </div>

        <div class="col-12 relative left-center">
          <div class="cell4-gno col-4 table-border-gno-top">
            <input class="checkbox2" type="radio" name="set2" />
            <div class="text2">Рбуф (ФЭ)</div>
          </div>
          <div
            class="cell4-gno table-border-gno cell4-gno-second col-2 table-border-gno-top"
          >
            7 ат
          </div>
          <div
            class="cell4-gno table-border-gno cell4-gno-second col-2 table-border-gno-top"
          >
            Рзат
          </div>
          <div
            class="cell4-gno table-border-gno cell4-gno-second col-2 table-border-gno-top"
          >
            4 ат
          </div>
        </div>
      </div>
      <div class="tables-string-gno44 col-6">
        <div class="select-well col-12">Параметры подбора</div>
        <div class="select-well col-12">ГНО</div>
        <div class="col-12 relative left-center">
          <div class="cell4-gno col-3">
            <div class="text3">ШГН</div>
            <input class="checkbox3" type="radio" name="gno" />
          </div>
          <div class="cell4-gno table-border-gno cell4-gno-second col-3">
            <div class="text3">ЭЦН</div>
            <input class="checkbox3" type="radio" name="gno" />
          </div>
          <div class="cell4-gno table-border-gno cell4-gno-second col-3">
            <div class="text3">НСП</div>
          </div>
          <div class="cell4-gno table-border-gno cell4-gno-second col-2">
            1280 м
          </div>
        </div>

        <div class="select-well col-12">Целевой параметр</div>
        <div class="col-12 relative left-center">
          <div class="cell4-gno col-3">
            <div class="text3">Qж</div>
            <input class="checkbox3" type="radio" name="gno" />
          </div>
          <div class="cell4-gno table-border-gno cell4-gno-second col-3">
          <div class="target">64 м3/сут</div> 
            <div class="text3">Рзаб</div>
            <input class="checkbox3" type="radio" name="gno" />
          </div>
          <div class="cell4-gno table-border-gno cell4-gno-second col-3">
            <div class="target">84 ат</div>        
            <div class="text3"> Pnp</div>
            <input class="checkbox3" type="radio" name="gno" />
          </div>
          <div class="cell4-gno table-border-gno cell4-gno-second col-2">
            75 атм
          </div>
        </div>
      </div>

      <div
        class="tables-string-gno5 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-6"
      >
        Анализ потенциала скважины
      </div>

      <div
        class="tables-string-gno55 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-6"
      >
        Анализ эффективности способа эксплуатации
      </div>

      <div class="tables-string-gno6 col-12">
        Подбор ГНО
      </div>
    </div>
  </div>
</template>

<script>
import { EventBus } from "../../event-bus.js";
export default {
  data: function () {
    return {};
  },

  methods: {
    getLinePoints: function () {
      let uri = "/js/json/gno/line_points.json";
      this.axios.get(uri).then((response) => {
        var data = response.data;
        if (data) {
          this.$emit("data", data);
        } else {
          console.log("No data");
        }
      });
    },
  },
  async mounted() {
    this.getLinePoints();
  },
};
</script>
