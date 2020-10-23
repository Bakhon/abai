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
      <div class="inclinom" @click="pushBign('bign0')">Инклинометрия</div>

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
          style="width: 845px; height: 35px;"
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
          style="width: 845px; height: 45px;"
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
        <modal name="bign0" :width="551" :height="780">
          <div class="modal-bign">
            <div class="Table" align="center" x:publishsource="Excel">
              <table
                border="1"
                cellpadding="0"
                cellspacing="0"
                width="545"
                style="
                  border-collapse: collapse;
                  table-layout: fixed;
                  width: 401pt;
                "
              >
                <col width="64" span="3" style="width: 48pt;" />
                <col
                  width="88"
                  style="
                    mso-width-source: userset;
                    mso-width-alt: 3218;
                    width: 66pt;
                  "
                />
                <col
                  width="95"
                  style="
                    mso-width-source: userset;
                    mso-width-alt: 3474;
                    width: 71pt;
                  "
                />
                <col
                  width="160"
                  style="
                    mso-width-source: userset;
                    mso-width-alt: 5851;
                    width: 120pt;
                  "
                />
                <tr height="80" style="height: 60pt;">
                  <td
                    height="80"
                    class="xl6321650"
                    width="64"
                    style="height: 60pt; width: 48pt;"
                  >
                    MD,м
                  </td>
                  <td
                    class="xl6321650"
                    width="64"
                    style="border-left: none; width: 48pt;"
                  >
                    TVD, м
                  </td>
                  <td
                    class="xl6321650"
                    width="64"
                    style="border-left: none; width: 48pt;"
                  >
                    Удл,м
                  </td>
                  <td
                    class="xl6321650"
                    width="88"
                    style="border-left: none; width: 66pt;"
                  >
                    Зенитный угол, гр
                  </td>
                  <td
                    class="xl6321650"
                    width="95"
                    style="border-left: none; width: 71pt;"
                  >
                    Азимут, гр
                  </td>
                  <td
                    class="xl6321650"
                    width="160"
                    style="border-left: none; width: 120pt;"
                  >
                    Темп набора пространственной кривизны, (DLS), гр/10м
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    0
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    0
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    0
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    0,00
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    0
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,00
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    13
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    13
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    0
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    0,17
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    313
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,38
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    27
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    27
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    0
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    0,33
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    267
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,56
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    40
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    40
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    0
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    0,50
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    220
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,82
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    60
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    60
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    0
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    0,50
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    210
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,13
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    80
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    80
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    0
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    0,50
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    205
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,07
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    100
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    100
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    0
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    0,50
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    195
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,13
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    120
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    120
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    0
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    0,50
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    185
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,13
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    140
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    140
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    0
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    0,50
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    165
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,26
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    160
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    160
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    0
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    0,50
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    160
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,07
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    180
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    180
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    0
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    0,50
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    155
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,07
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    193
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    193
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    0
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    0,83
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    158
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,75
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    200
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    200
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    0
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    1,00
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    160
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,76
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    220
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    220
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    0
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    1,00
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    155
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,13
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    240
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    240
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    0
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    1,00
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    155
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,00
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    245
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    245
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    0
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    1,13
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    149
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    1,02
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    250
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    250
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    0
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    1,25
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    143
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    1,08
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    255
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    255
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    0
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    1,38
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    136
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    1,14
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    260
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    260
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    0
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    1,50
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    130
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    1,20
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    270
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    270
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    0
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    1,75
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    123
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,98
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    280
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    280
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    0
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    2,00
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    115
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    1,05
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    300
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    300
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    0
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    2,50
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    113
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,76
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    320
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    320
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    0
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    2,50
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    110
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,20
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    340
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    340
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    0
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    2,50
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    114
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,26
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    360
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    360
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    0
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    2,50
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    110
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,26
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    370
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    370
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    0
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    2,50
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    106
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,52
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    380
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    380
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    0
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    2,50
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    102
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,52
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    390
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    390
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    0
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    2,75
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    99
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,89
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    400
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    400
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    0
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    3,00
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    95
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,92
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    420
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    420
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    0
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    3,00
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    95
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,00
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    433
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    433
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    0
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    3,00
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    100
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,63
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    440
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    440
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    0
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    3,00
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    103
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,63
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    460
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    460
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    0
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    3,00
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    98
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,39
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    473
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    473
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    0
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    3,00
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    93
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,63
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    480
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    480
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    0
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    3,00
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    90
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,63
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    493
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    493
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    0
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    2,67
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    87
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,84
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    500
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    500
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    0
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    2,50
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    85
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,82
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    513
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    513
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    0
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    2,50
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    92
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,65
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    520
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    520
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    0
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    2,50
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    95
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,65
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    533
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    533
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    0
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    2,50
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    88
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,65
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    540
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    540
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    0
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    2,50
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    85
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,65
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    560
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    560
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    0
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    2,50
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    86
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,07
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    570
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    570
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    0
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    2,50
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    91
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,59
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    580
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    580
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    0
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    2,50
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    95
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,59
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    600
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    600
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    0
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    2,50
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    90
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,33
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    613
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    613
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    0
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    2,50
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    97
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,65
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    620
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    620
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    0
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    2,50
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    100
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,65
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    633
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    633
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    0
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    2,83
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    97
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,83
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    640
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    640
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    0
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    3,00
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    95
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,84
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    653
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    653
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    0
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    3,00
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    88
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,78
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    660
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    660
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    0
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    3,00
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    85
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,78
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    673
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    673
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    0
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    3,33
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    82
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,86
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    680
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    680
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    0
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    3,50
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    80
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,87
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    700
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    699
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    3,50
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    80
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,00
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    720
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    719
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    3,50
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    85
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,46
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    728
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    727
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    3,70
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    81
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    1,20
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    736
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    735
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    3,90
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    77
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    1,24
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    740
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    739
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    4,00
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    75
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    1,28
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    760
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    759
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    4,00
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    80
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,52
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    780
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    779
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    4,00
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    80
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,00
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    800
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    799
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    3,50
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    80
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,75
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    810
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    809
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    3,50
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    75
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,92
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    820
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    819
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    3,50
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    70
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,92
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    833
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    833
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    3,83
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    73
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,89
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    840
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    839
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    4,00
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    75
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,91
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    850
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    849
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    4,00
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    80
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    1,05
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    860
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    859
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    4,00
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    85
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    1,05
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    868
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    867
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    3,80
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    81
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    1,27
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    876
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    875
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    3,60
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    77
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    1,22
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    880
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    879
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    3,50
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    75
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    1,19
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    893
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    892
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    3,83
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    72
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,89
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    900
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    899
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    4,00
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    70
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,91
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    908
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    907
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    3,80
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    66
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    1,27
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    916
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    915
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    3,60
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    62
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    1,22
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    920
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    919
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    3,50
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    60
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    1,19
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    933
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    932
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    3,17
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    63
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,87
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    940
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    939
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    3,00
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    65
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,85
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    960
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    959
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    3,00
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    60
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,39
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    973
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    972
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    3,00
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    53
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,78
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    980
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    979
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    3,00
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    50
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,78
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    990
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    989
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    3,25
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    55
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    1,11
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1000
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    999
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    3,50
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    60
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    1,16
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1020
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1019
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    3,50
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    60
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,00
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1040
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1039
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    3,50
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    65
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,46
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1050
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1049
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    3,25
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    60
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    1,16
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1060
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1059
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    3,00
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    55
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    1,11
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1073
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1072
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    3,33
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    58
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,86
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1080
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1079
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    3,50
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    60
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,87
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1093
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1092
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    3,17
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    57
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,87
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1100
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1099
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    3,00
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    55
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,85
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1113
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1112
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    3,00
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    48
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,78
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1120
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1119
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    3,00
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    45
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,78
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1140
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1139
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    3,00
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    45
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,00
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1150
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1149
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    2,75
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    40
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    1,06
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1160
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1159
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    2,50
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    35
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    1,02
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1180
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1179
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    2,50
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    35
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,00
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1200
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1199
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    3,00
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    35
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,75
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1210
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1209
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    2,75
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    30
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    1,06
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1220
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1219
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    2,50
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    25
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    1,02
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1233
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1232
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    2,50
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    32
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,65
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1240
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1239
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    2,50
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    35
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,65
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1253
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1252
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    2,83
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    38
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,83
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1260
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1259
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    3,00
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    40
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,84
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1273
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1272
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    3,33
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    37
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,86
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1280
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1279
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    3,50
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    35
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,87
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1300
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1298
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    2
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    3,50
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    30
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,46
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1310
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1308
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    2
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    3,50
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    35
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,92
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1320
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1318
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    2
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    3,50
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    40
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,92
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1333
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1332
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    2
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    3,17
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    37
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,87
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1340
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1338
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    2
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    3,00
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    35
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,85
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1360
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1358
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    2
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    3,00
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    30
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,39
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1370
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1368
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    2
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    3,00
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    38
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    1,18
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1380
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1378
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    2
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    3,00
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    45
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    1,18
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1390
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1388
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    2
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    2,75
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    40
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    1,06
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1400
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1398
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    2
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    2,50
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    35
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    1,02
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1420
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1418
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    2
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    2,58
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    37
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,18
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1440
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1438
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    2
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    2,33
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    40
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,42
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1450
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1448
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    2
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    2,54
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    35
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,90
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1460
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1458
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    2
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    2,75
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    30
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,94
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1480
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1478
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    2
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    2,75
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    35
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,36
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1500
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1498
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    2
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    2,50
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    37
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,40
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1520
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1518
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    2
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    2,25
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    40
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,42
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1530
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1528
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    2
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    2,13
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    43
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,47
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1540
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1538
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    2
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    2,00
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    45
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,46
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1548
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1546
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    2
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    1,90
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    35
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    1,33
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1556
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1554
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    2
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    1,80
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    25
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    1,27
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1560
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1558
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    2
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    1,75
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    20
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    1,22
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1570
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1568
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    2
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    1,88
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    30
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    1,02
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1580
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1578
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    2
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    2,00
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    40
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    1,08
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1590
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1588
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    2
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    1,88
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    36
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,55
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1600
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1598
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    2
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    1,75
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    32
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,53
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1620
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1618
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    2
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    2,00
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    35
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,40
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1628
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1626
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    2
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    2,10
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    25
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    1,39
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1636
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1634
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    2
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    2,20
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    15
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    1,45
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1640
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1638
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    2
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    2,25
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    10
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    1,50
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1648
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1646
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    2
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    2,35
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    18
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    1,26
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1656
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1654
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    2
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    2,45
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    26
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    1,31
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1660
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1658
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    2
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    2,50
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    30
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    1,35
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1670
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1668
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    2
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    2,50
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    21
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    1,18
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1680
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1678
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    2
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    2,50
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    12
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    1,18
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1690
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1688
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    2
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    2,25
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    17
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,97
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1700
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1698
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    2
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    2,00
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    22
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,93
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1720
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1718
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    2
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    2,25
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    21
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,38
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1730
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1728
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    2
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    2,38
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    18
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,52
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1740
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1738
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    2
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    2,50
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    15
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,54
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1753
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1751
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    2
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    2,17
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    13
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,77
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1760
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1758
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    2
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    2,00
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    12
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,77
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1780
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1778
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    2
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    2,25
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    11
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,38
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1800
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1798
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    2
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    1,75
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    13
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,76
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1820
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1818
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    2
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    2,00
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    13
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,38
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1840
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1838
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    2
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    2,00
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    5
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    0,42
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1845
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1843
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    2
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    1,75
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    359
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    1,91
                  </td>
                </tr>
                <tr height="20" style="height: 15pt;">
                  <td
                    height="20"
                    class="xl6621650"
                    style="height: 15pt; border-top: none;"
                  >
                    1850
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    1848
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    2
                  </td>
                  <td
                    class="xl6521650"
                    style="border-top: none; border-left: none;"
                  >
                    1,50
                  </td>
                  <td
                    class="xl6621650"
                    style="border-top: none; border-left: none;"
                  >
                    353
                  </td>
                  <td
                    class="xl6421650"
                    style="border-top: none; border-left: none;"
                  >
                    1,81
                  </td>
                </tr>

                <tr height="0" style="display: none;">
                  <td width="64" style="width: 48pt;"></td>
                  <td width="64" style="width: 48pt;"></td>
                  <td width="64" style="width: 48pt;"></td>
                  <td width="88" style="width: 66pt;"></td>
                  <td width="95" style="width: 71pt;"></td>
                  <td width="160" style="width: 120pt;"></td>
                </tr>
              </table>
            </div>
          </div>
        </modal>

        <modal name="bign1" :width="1150" :height="400" :adaptive="true">
          <div class="modal-bign">
            Тест 1
          </div>
        </modal>

        <modal name="bign2" :width="1150" :height="395" :adaptive="true" class="chart" style="    margin-top: -180px;
    margin-left:100px;">
          <div class="modal-bign2">
            <gno-chart-bar></gno-chart-bar>
          </div>
        </modal>

        <modal name="bign3" :width="1150" :height="400" :adaptive="true">
          <div class="modal-bign">
            Тест 3
          </div>
        </modal>
        <!--<gno-iframe className="iframe"  width="1000" :src="test"> </gno-iframe>
   <gno-test-chart></gno-test-chart>-->
        <gno-line-points-chart></gno-line-points-chart>
      </div>

      <div class="tables-string-gno4 col-6">
        <div class="tables-string-gno4-inner">
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
        <div class="tables-string-gno5 col-12" @click="pushBign('bign1')">
          Анализ потенциала скважины
        </div>
      </div>
      <div class="col-6 tables-string-gno44">
        <div class="tables-string-gno44-inner">
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
        <div class="tables-string-gno55 col-12" @click="pushBign('bign2')">
          Анализ эффективности способа эксплуатации
        </div>
      </div>

      <div class="col-12 row">
        <!--<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-6">
    
        </div>-->
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-6"></div>
      </div>
      <div class="tables-string-gno6 col-12" @click="pushBign('bign3')">
        Подбор ГНО
      </div>
    </div>
  </div>
</template>

<script>
import { EventBus } from "../../event-bus.js";
export default {
  data: function () {
    return {
      src: {
        type: String,
        required: true,
      },
      test: "monitor",
    };
  },

  methods: {
    pushBign(bign) {
      switch (bign) {
        case "bign1":
          //  this.params.data = this.wellsList;
          break;
        case "bign2":
          // this.params.data = this.OperatingProfitYear;
          break;
        case "bign3":
          //  this.params.data = this.OperatingProfitMonth;
          break;
        case "bign4":
          //  this.params.data = this.prs1;
          break;
      }
      this.$modal.show(bign);
    },
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
