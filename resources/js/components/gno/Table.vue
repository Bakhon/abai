<template>
  <div class="main col-md-12 col-lg-12 row">
    <div class="tables-one col-xs-12 col-sm-5 col-md-5 col-lg-3 col-xl-3">
      <div class="tables-string-gno col-12">
        <div class="select-well col-12">Выбор скважины</div>
        <div class="cell4-gno col-7">Месторождение</div>
        <div class="cell4-gno table-border-gno cell4-gno-second col-5">
          <select class="select-gno2">
            <option value="" hidden>Выбор</option>
            <option>Узень</option>
            <option>Карамандыбас</option>
          </select>
        </div>

        <div class="cell4-gno table-border-gno-top col-7">Скважина №</div>
        <div
          class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
        >
          <input type="text" value="46" class="square2" />
        </div>
        <div class="cell4-gno table-border-gno-top col-7">
          Новая скважина <input class="checkbox0" type="checkbox" />
        </div>
        <div
          class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
        >
          с ГРП <input class="checkbox0" type="checkbox" />
        </div>

        <div class="cell4-gno table-border-gno-top col-7">Пласт</div>
        <div
          class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
        >
          14_Основной свод
        </div>

        <div class="cell4-gno table-border-gno-top col-7">
          Способ эксплуатации
        </div>
        <div
          class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
        >
          <div class="center">
            ШГН
          </div>
        </div>

        <div class="cell4-gno table-border-gno-top col-7">ЦДНГ-13</div>
        <div
          class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
        >
          ГУ-68
        </div>

        <div class="cell4-gno table-border-gno-top col-7">НГДУ-3</div>
        <div
          class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
        >
          АО «ОМГ»
        </div>
      </div>
      <div class="tables-string-gno1-1">
        <div class="select-well col-12">Конструкция</div>
        <div class="cell4-gno col-7">Наружн. ØЭК</div>
        <div class="cell4-gno table-border-gno cell4-gno-second col-5">
          139,7 мм
        </div>

        <div class="cell4-gno table-border-gno-top col-7">Внутрен. ØЭК</div>
        <div
          class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
        >
          127,7 мм
        </div>

        <div class="cell4-gno table-border-gno-top col-7">Нперф.(ВДП м)</div>
        <div
          class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
        >
          18 м
        </div>

        <div class="cell4-gno table-border-gno-top col-7">Удл. на Нперф.</div>
        <div
          class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
        >
          0 м
        </div>

        <div class="cell4-gno table-border-gno-top col-7">Текущий забой</div>
        <div
          class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
        >
          1185 м
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
            <div class="cell4-gno table-border-gno-top col-7">
              Станок-качалка
            </div>
            <div
              class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
            >
              7СК-8
            </div>

            <div class="cell4-gno table-border-gno-top col-7">
              Диаметр насоса
            </div>
            <div
              class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
            >
              57 мм
            </div>

            <div class="cell4-gno table-border-gno-top col-7">Код насоса</div>
            <div
              class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
            >
              ННАБ-57-35-12-2
            </div>

            <div class="cell4-gno table-border-gno-top col-7">Нсп</div>
            <div
              class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
            >
              1040 м
            </div>

            <div class="cell4-gno table-border-gno-top col-7">Наружн. фНКТ</div>
            <div
              class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
            >
              73 м
            </div>
            <div class="cell4-gno table-border-gno-top col-7">Внутр. фНКТ</div>
            <div
              class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
            >
              50,3 мм
            </div>
            <div class="cell4-gno table-border-gno-top col-7">Дата запуска</div>
            <div
              class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
            >
              06.04.2020
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
            <div class="cell4-gno col-7">Рнас</div>
            <div class="cell4-gno table-border-gno cell4-gno-second col-5">
              68,97 атм
            </div>

            <div class="cell4-gno table-border-gno-top col-7">ГФ</div>
            <div
              class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
            >
              42,65
            </div>

            <div class="cell4-gno table-border-gno-top col-7">Т пл</div>
            <div
              class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
            >
              60 ℃
            </div>

            <div class="cell4-gno table-border-gno-top col-7">
              Вязкость нефти (пл.усл.)
            </div>
            <div
              class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
            >
              2,8 сПз
            </div>

            <div class="cell4-gno table-border-gno-top col-7">
              Вязкость воды (пл.усл.)
            </div>
            <div
              class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
            >
              0,4 сПз
            </div>

            <div class="cell4-gno table-border-gno-top col-7">
              Плотность нефти
            </div>
            <div
              class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
            >
              0,853 г/cм³
            </div>
            <div class="cell4-gno table-border-gno-top col-7">
              Плотность воды
            </div>
            <div
              class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
            >
              1,04 г/cм³
            </div>
          </blockquote>
        </div>
      </div>

      <div class="tables-string-gno2">
        <div class="select-well col-12">Технологический режим</div>
        <div class="cell4-gno col-7">Qж</div>
        <div class="cell4-gno table-border-gno cell4-gno-second col-5">
          36 м3/сут
        </div>

        <div class="cell4-gno table-border-gno-top col-7">Qн</div>
        <div
          class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
        >
          23 т/сут
        </div>

        <div class="cell4-gno table-border-gno-top col-7">Обвод</div>
        <div
          class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
        >
          25 %
        </div>

        <div class="cell4-gno table-border-gno-top col-7">Рзаб</div>
        <div
          class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
        >
          54 атм
        </div>

        <div class="cell4-gno table-border-gno-top col-7">Рпл</div>
        <div
          class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
        >
          101 ат
        </div>

        <div class="cell4-gno table-border-gno-top col-7">Ндин</div>
        <div
          class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
        >
          486 м
        </div>
        <div class="cell4-gno table-border-gno-top col-7">Рзат</div>
        <div
          class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
        >
          2,25 атм
        </div>
        <div class="cell4-gno table-border-gno-top col-7">Рбуф</div>
        <div
          class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
        >
          4 атм
        </div>
        <div class="cell4-gno table-border-gno-top col-7">Рлин</div>
        <div
          class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
        >
          4 атм
        </div>
      </div>
    </div>

    <div class="tables-two col-xs-12 col-sm-7 col-md-7 col-lg-8 col-xl-9">
      <div class="tables-string-gno3">
        <gno-line-points-chart></gno-line-points-chart>
      </div>

      <div class="tables-string-gno4 col-6">
        <div class="select-well col-12">Настройка кривой притока</div>
        <div class="col-8 relative">
          <div class="col-6">
            <div class="cell4-gno col-4">
              Рпл
            </div>
            <div class="cell4-gno table-border-gno cell4-gno-second col-5">
              <input type="text" value="124 ат" class="square2" />
            </div>

            <div class="cell4-gno table-border-gno-top col-4">
              <input class="checkbox" type="radio" name="set" />Кпрод
            </div>
            <div
              class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
            >
              <input type="text" value="1,4 м3/сут/ат" class="square2" />
            </div>

            <div class="cell4-gno table-border-gno-top col-4">
              <input class="checkbox" type="radio" name="set" />Qж
            </div>
            <div
              class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
            >
              <input type="text" value="46 м3/сут" class="square2" />
            </div>
          </div>
        </div>

        <div class="col-4 relative">
          <div class="cell4-gno col-4">
            Обв.
          </div>
          <div class="cell4-gno table-border-gno cell4-gno-second col-5">
            <input type="text" value="82 %" class="square2" />
          </div>

          <div class="cell4-gno table-border-gno-top col-4">
            ГФ.
          </div>
          <div
            class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5"
          >
            <input type="text" value="47 м3/т" class="square2" />
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
            <input type="text" value="64 ат" class="square2" />
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
            <input type="text" value="672" class="square2" />
          </div>
          <div
            class="cell4-gno table-border-gno cell4-gno-second col-2 table-border-gno-top"
          >
            Рзат
          </div>
          <div
            class="cell4-gno table-border-gno cell4-gno-second col-2 table-border-gno-top"
          >
            <input type="text" value="4 ат" class="square2" />
          </div>
        </div>

        <div class="col-12 relative left-center">
          <div class="cell4-gno col-4 table-border-gno-top">
            <input class="checkbox2" type="radio" name="set2" />
            <div class="text2">Рманом</div>
          </div>
          <div
            class="cell4-gno table-border-gno cell4-gno-second col-2 table-border-gno-top"
          >
            <input type="text" value="" class="square2" />
          </div>
          <div
            class="cell4-gno table-border-gno cell4-gno-second col-2 table-border-gno-top"
          >
            Нсп маном
          </div>
          <div
            class="cell4-gno table-border-gno cell4-gno-second col-2 table-border-gno-top"
          >
            <input type="text" value="" class="square2" />
          </div>
        </div>

        <div class="col-12 relative left-center">
          <div class="cell4-gno col-4 table-border-gno-top">
            <input class="checkbox2" type="radio" name="set2" />
            <div class="text2">Рбуф (ФЭ)</div>
          </div>
          <div
            class="cell4-gno table-border-gno cell4-gno-second col-2 table-border-gno-top"
          >
            <input type="text" value="7 ат" class="square2" />
          </div>
          <div
            class="cell4-gno table-border-gno cell4-gno-second col-2 table-border-gno-top"
          ></div>
          <div
            class="cell4-gno table-border-gno cell4-gno-second col-2 table-border-gno-top"
          ></div>
        </div>
      </div>
      <div class="tables-string-gno44 col-6">
        <div class="select-well col-12">Параметры подбора</div>

        <div class="select-well col-12">ГНО</div>
        <div class="col-12 relative left-center">
          <div class="cell4-gno col-3">
            <div class="text3">ШГН</div>
            <input class="checkbox3" type="radio" name="gno10" />
          </div>
          <div class="cell4-gno table-border-gno cell4-gno-second col-3">
            <div class="text3">ЭЦН</div>
            <input class="checkbox3" type="radio" name="gno10" />
          </div>
          <div class="cell4-gno table-border-gno cell4-gno-second col-3">
            <div class="text3">НСП</div>
          </div>
          <div class="cell4-gno table-border-gno cell4-gno-second col-2">
            <input type="text" value="1280 м" class="square2" />
          </div>
        </div>

        <div class="select-well col-12">Целевой параметр</div>
        <div class="col-12 relative left-center">
          <div class="cell4-gno col-3">
            <div class="text3">Qж</div>
            <input class="checkbox3" type="radio" name="gno11" />
          </div>
          <div class="cell4-gno table-border-gno cell4-gno-second col-3">
            <div class="target">
              <input type="text" value="64 м3/сут" class="square2" />
            </div>
            <div class="text3">Рзаб</div>
            <input class="checkbox3" type="radio" name="gno11" />
          </div>
          <div class="cell4-gno table-border-gno cell4-gno-second col-3">
            <div class="target">
              <input type="text" value="84 ат" class="square2" />
            </div>
            <div class="text3">Pnp</div>
            <input class="checkbox3" type="radio" name="gno11" />
          </div>
          <div class="cell4-gno table-border-gno cell4-gno-second col-2">
            <input type="text" value="75 атм" class="square2" />
          </div>
        </div>
      </div>
      <div class="col-12 row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-6">
          <div class="tables-string-gno5 col-12">
            Анализ потенциала скважины
          </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-6">
          <div class="tables-string-gno55 col-12">
            Анализ эффективности способа эксплуатации
          </div>
        </div>
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
