<template>
  <div class="tkrs-main">
    <mainHeader />
    <div class="sidebar_graph" style="display:flex">
        
        <div class="data-analysis-left-block">
          <div class="left-block-collapse-holder">
            <div>

              <div class="nav nav-tabs all-tabs">
                <div style="display:flex; width: 249px;">
                  <li class="nav-item">
                      <a class="nav-link active tab-lblock-header" 
                      @click="selectBlockTab(1)" href="#">
                      <a>{{trans('tkrs.current_work')}}</a></a>
                  </li>
                  <li class="nav-item" style="width: 107px;">
                      <a class="nav-link tab-lblock-header" 
                      @click="selectBlockTab(2)" href="#">
                      <a>{{trans('tkrs.archive')}}</a></a>
                  </li>
                </div>
              </div>
             
            </div>
          </div>
          <div class="dropdown-holder">
            
            <div class="line-block"></div>
            <div class="tab-archive-div" v-if="currentBlockTab == 1">
              <div class="form-input-block-header">Добавление скважины</div>
        <b-dropdown class="left-block-dropdown" >
              <template #button-content >
                <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M8.19995 10.3394C6.87237 10.6948 6.04238 11.1658 5 11.1992V11.9992H11.9999V9.93942C10.3439 9.87222 9.06914 10.1068 8.19995 10.3394ZM8.65154 11.3992L8.54815 11.0128C9.39093 10.7872 10.2801 10.6514 11.1905 10.609L11.2091 11.0086C10.3273 11.0496 9.46693 11.181 8.65154 11.3992Z" fill="#868BB2"/>
                <path d="M2.99995 10.801C2.88496 10.7752 2.75396 10.7496 2.59996 10.725C1.52318 10.5532 0.610191 10.6304 0 10.725V12.0009H2.99995V10.801Z" fill="#868BB2"/>
                <path d="M4.80156 9.59921C4.91201 9.59921 5.00156 9.50967 5.00156 9.39922C5.00156 9.28876 4.91201 9.19922 4.80156 9.19922C4.6911 9.19922 4.60156 9.28876 4.60156 9.39922C4.60156 9.50967 4.6911 9.59921 4.80156 9.59921Z" fill="#868BB2"/>
                <path d="M6.2 9.20078C6.31045 9.20078 6.39999 9.11123 6.39999 9.00078C6.39999 8.89032 6.31045 8.80078 6.2 8.80078C6.08954 8.80078 6 8.89032 6 9.00078C6 9.11123 6.08954 9.20078 6.2 9.20078Z" fill="#868BB2"/>
                <path d="M5.39922 10.4C5.50967 10.4 5.59921 10.3105 5.59921 10.2C5.59921 10.0895 5.50967 10 5.39922 10C5.28876 10 5.19922 10.0895 5.19922 10.2C5.19922 10.3105 5.28876 10.4 5.39922 10.4Z" fill="#868BB2"/>
                <path d="M7.2 9.9996C7.31045 9.9996 7.4 9.91006 7.4 9.79961C7.4 9.68915 7.31045 9.59961 7.2 9.59961C7.08954 9.59961 7 9.68915 7 9.79961C7 9.91006 7.08954 9.9996 7.2 9.9996Z" fill="#868BB2"/>
                <path d="M8.2 9.20078C8.31045 9.20078 8.39999 9.11123 8.39999 9.00078C8.39999 8.89032 8.31045 8.80078 8.2 8.80078C8.08954 8.80078 8 8.89032 8 9.00078C8 9.11123 8.08954 9.20078 8.2 9.20078Z" fill="#868BB2"/>
                <path d="M11.2 9.20078C11.3105 9.20078 11.4 9.11123 11.4 9.00078C11.4 8.89032 11.3105 8.80078 11.2 8.80078C11.0895 8.80078 11 8.89032 11 9.00078C11 9.11123 11.0895 9.20078 11.2 9.20078Z" fill="#868BB2"/>
                <path d="M9.79765 9.39999C9.90811 9.39999 9.99765 9.31045 9.99765 9.2C9.99765 9.08954 9.90811 9 9.79765 9C9.6872 9 9.59766 9.08954 9.59766 9.2C9.59766 9.31045 9.6872 9.39999 9.79765 9.39999Z" fill="#868BB2"/>
                <path d="M0.399216 9.20078C0.509671 9.20078 0.599213 9.11123 0.599213 9.00078C0.599213 8.89032 0.509671 8.80078 0.399216 8.80078C0.28876 8.80078 0.199219 8.89032 0.199219 9.00078C0.199219 9.11123 0.28876 9.20078 0.399216 9.20078Z" fill="#868BB2"/>
                <path d="M1.59843 9.9996C1.70889 9.9996 1.79843 9.91006 1.79843 9.79961C1.79843 9.68915 1.70889 9.59961 1.59843 9.59961C1.48798 9.59961 1.39844 9.68915 1.39844 9.79961C1.39844 9.91006 1.48798 9.9996 1.59843 9.9996Z" fill="#868BB2"/>
                <path d="M3.00078 9.59921C3.11123 9.59921 3.20078 9.50967 3.20078 9.39922C3.20078 9.28876 3.11123 9.19922 3.00078 9.19922C2.89032 9.19922 2.80078 9.28876 2.80078 9.39922C2.80078 9.50967 2.89032 9.59921 3.00078 9.59921Z" fill="#868BB2"/>
                <path d="M11.1983 6.19991H9.59834V6.5999H9.15315L8.22216 2.09857L10.1983 1.71617V5.19992H9.59834V5.79991H11.1983V5.19992H10.5983V1.63858L10.6113 1.63598C10.7159 1.61578 10.7863 1.51698 10.7713 1.41138L10.6281 0.409194C10.6119 0.295595 10.5035 0.218797 10.3909 0.241396L4.59842 1.39998V0.599991L3.99843 0L3.39844 0.599991V3.19995L3.79843 3.73334V4.79993H3.59843C3.48804 4.79993 3.39844 4.88953 3.39844 4.99992V5.79991C3.39844 5.91031 3.48804 5.99991 3.59843 5.99991H3.79843V10.8388C3.56563 10.9234 3.39844 11.142 3.39844 11.3998C3.39844 11.7306 3.67223 11.9998 4.00883 11.9998C4.34542 11.9998 4.61922 11.7306 4.61922 11.3998C4.61922 11.1344 4.44182 10.9114 4.19843 10.8324V5.99991H4.39842C4.50882 5.99991 4.59842 5.91031 4.59842 5.79991V4.99992C4.59842 4.88953 4.50882 4.79993 4.39842 4.79993H4.19843V3.73334L4.59842 3.19995V2.79996L6.54519 2.42316L5.6372 6.5999H4.59842V8.39987H11.9983V6.5999H11.1983V6.19991ZM10.1591 0.803988L10.2377 1.19618L9.23775 1.39618L9.15915 1.00398L10.1591 0.803988ZM4.21923 11.3998C4.21923 11.51 4.12483 11.5998 4.00883 11.5998C3.89283 11.5998 3.79843 11.51 3.79843 11.3998C3.79843 11.2896 3.89283 11.1998 4.00883 11.1998C4.12483 11.1998 4.21923 11.2896 4.21923 11.3998ZM4.19843 5.59992H3.79843V5.19992H4.19843V5.59992ZM4.19843 2.19997H3.79843V1.79997H4.19843V2.19997ZM8.23376 4.19694L8.45296 5.29272L6.96198 4.47953L8.23376 4.19694ZM6.97238 2.34036L7.82917 2.17457L8.13477 3.70234L6.88078 2.76176L6.97238 2.34036ZM6.78739 3.19175L7.73037 3.89914L6.57779 4.15534L6.78739 3.19175ZM6.46719 4.66533L8.08617 5.54832L6.1454 6.14551L6.46719 4.66533ZM6.0466 6.5999L6.0522 6.5743L6.0574 6.5909L8.55896 5.82111L8.75256 6.5999H6.0466Z" fill="#868BB2"/>
                <path d="M3.39995 6.59961H0V8.39958H3.39995V6.59961Z" fill="#868BB2"/>
                </svg>
                <a>Месторождение</a>
              </template>
              <b-dropdown-item href="#">Бригада</b-dropdown-item>
              <b-dropdown-item href="#">Скважина</b-dropdown-item>
        </b-dropdown>
        <b-dropdown class="left-block-dropdown" >
              <template #button-content class="outer_button_filter">
                <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M11.2295 10.4023H10.668V7.84256C10.668 7.77532 10.6068 7.72048 10.5317 7.72048H9.89921V5.76466L9.96604 5.78922C10.0008 5.80162 10.0353 5.80829 10.07 5.80829C10.1761 5.80829 10.2782 5.75131 10.3209 5.65713L10.7078 4.81786C10.7349 4.7573 10.7349 4.69031 10.7078 4.6307C10.6805 4.5711 10.6272 4.52293 10.5604 4.49861L4.68815 2.3127C4.90244 1.94409 5.09551 1.57025 5.26127 1.19854C5.31696 1.07408 5.25039 0.933162 5.11328 0.882139L2.79377 0.0185678C2.65587 -0.0324556 2.49834 0.0252363 2.43866 0.148026C1.86476 1.35733 1.49373 2.70492 1.27308 4.3887C1.25982 4.49742 1.32745 4.60138 1.43963 4.6431L2.43442 5.01337C2.54634 5.0551 2.6755 5.02458 2.75108 4.93875C3.18257 4.44735 3.55465 3.98552 3.88987 3.52678L5.06289 3.96454L5.00481 4.32337L4.83031 5.41298L4.02858 10.4023H2.1533H0.771569C0.621727 10.4023 0.5 10.5117 0.5 10.6469V11.7563C0.5 11.8903 0.621727 12 0.771569 12H11.2295C11.3783 12 11.5 11.8903 11.5 11.7563V10.6469C11.5 10.5117 11.3783 10.4023 11.2295 10.4023ZM9.35633 7.72048H8.72487C8.64929 7.72048 8.58776 7.77532 8.58776 7.84256V10.4023H7.97142L7.16969 5.41298L7.05672 4.70627L9.35633 5.56247V7.72048ZM6.67297 6.06602L5.71822 5.42633L6.47724 4.84886L6.67297 6.06602ZM6.35445 6.52047L5.14352 7.21311L5.36072 5.85526L6.35445 6.52047ZM6.80636 6.89742L7.09836 8.71352L5.52621 7.62868L6.80636 6.89742ZM5.64078 10.4023L7.20603 9.3835L7.36966 10.4023H5.64078ZM6.17491 4.37844L5.51904 4.87652L5.63096 4.1753L6.17491 4.37844ZM5.02338 7.95676L6.6528 9.08117L4.63193 10.3985L5.02338 7.95676Z" fill="#868BB2"/>
                </svg>

                <a>Скважина</a>
              </template>
              <b-dropdown-item href="#">Бригада</b-dropdown-item>
              <b-dropdown-item href="#">Скважина</b-dropdown-item>
        </b-dropdown>
        <b-button class="online-block" >Создать новый отчет</b-button>
                  <currentFormInput
                    v-for="template in wellsTreeCurrent"
                    :key="template.well_name" 
                    :template="template">
                  </currentFormInput>
              </div>

              <div class="tab-archive-div" v-if="currentBlockTab == 2">
                <svg width="230" height="24" viewBox="0 0 230 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0.25 0.25H245.75V23.75H0.25V0.25Z" fill="#121227" stroke="#363B68" stroke-width="0.5"/>
                    <path opacity="0.8" d="M33.712 15.5V8.564H30.232V15.5H28.852V7.316H35.092V15.5H33.712ZM36.3293 12.62C36.3293 11.74 36.6213 11.012 37.2053 10.436C37.7973 9.852 38.5293 9.56 39.4013 9.56C40.2973 9.56 41.0333 9.852 41.6093 10.436C42.1853 11.012 42.4733 11.74 42.4733 12.62C42.4733 13.476 42.1813 14.204 41.5973 14.804C41.0133 15.404 40.2813 15.704 39.4013 15.704C38.5293 15.704 37.7973 15.408 37.2053 14.816C36.6213 14.224 36.3293 13.492 36.3293 12.62ZM38.1653 11.276C37.8533 11.628 37.6973 12.076 37.6973 12.62C37.6973 13.164 37.8613 13.616 38.1893 13.976C38.5253 14.328 38.9293 14.504 39.4013 14.504C39.9053 14.504 40.3173 14.328 40.6373 13.976C40.9573 13.616 41.1173 13.164 41.1173 12.62C41.1173 12.092 40.9613 11.648 40.6493 11.288C40.3373 10.928 39.9213 10.748 39.4013 10.748C38.8893 10.748 38.4773 10.924 38.1653 11.276ZM43.6511 15.5V9.752H44.9471V11.96C44.9471 12.672 44.9351 13.26 44.9111 13.724H44.9351C45.0551 13.5 45.3191 13.108 45.7271 12.548L47.8031 9.752H48.9911V15.5H47.6951V13.304C47.6951 12.592 47.7071 12 47.7311 11.528H47.7071C47.5791 11.76 47.3151 12.152 46.9151 12.704L44.8391 15.5H43.6511ZM53.2174 9.56C53.9694 9.56 54.5734 9.756 55.0294 10.148C55.4854 10.54 55.7654 10.984 55.8694 11.48H54.4894C54.2814 10.96 53.8534 10.7 53.2054 10.7C52.7094 10.7 52.3054 10.872 51.9934 11.216C51.6894 11.56 51.5374 12.028 51.5374 12.62C51.5374 13.172 51.6934 13.632 52.0054 14C52.3254 14.368 52.7414 14.552 53.2534 14.552C53.8854 14.552 54.3254 14.264 54.5734 13.688H55.9654C55.7894 14.272 55.4734 14.756 55.0174 15.14C54.5694 15.516 53.9734 15.704 53.2294 15.704C52.3494 15.704 51.6174 15.42 51.0334 14.852C50.4494 14.276 50.1574 13.528 50.1574 12.608C50.1574 11.744 50.4374 11.02 50.9974 10.436C51.5574 9.852 52.2974 9.56 53.2174 9.56ZM57.1159 15.5V9.752H58.4599V12.296L60.8599 9.752H62.4319L59.8639 12.476L62.5039 15.5H60.8719L58.4599 12.692V15.5H57.1159Z" fill="#9EA4C9"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10.7406 6C12.0573 6 13.177 6.46091 14.0984 7.38274C15.0203 8.30407 15.4812 9.42378 15.4812 10.7404C15.4812 11.6622 15.2344 12.5016 14.7409 13.2591L18 16.5181L16.518 18L13.2589 14.7406C12.4688 15.234 11.6294 15.4813 10.7406 15.4813C9.42345 15.4813 8.30468 15.0204 7.38282 14.0985C6.46046 13.1767 6 12.0575 6 10.7404C6 9.42378 6.46046 8.30407 7.38282 7.38274C8.30468 6.46091 9.42345 6 10.7406 6ZM10.7406 8.12345C10.0161 8.12345 9.39876 8.37858 8.88848 8.88884C8.3782 9.3991 8.12307 10.0165 8.12307 10.7404C8.12307 11.4648 8.3782 12.0817 8.88848 12.5919C9.39876 13.1027 10.0161 13.3578 10.7406 13.3578C11.4646 13.3578 12.0819 13.1027 12.5922 12.5919C13.103 12.0817 13.3576 11.4648 13.3576 10.7404C13.3576 10.0165 13.103 9.3991 12.5922 8.88884C12.0819 8.37858 11.4646 8.12345 10.7406 8.12345Z" fill="#9EA4C9"/>
                    <path d="M23 3V21" stroke="#363B68" stroke-width="0.6"/>
                </svg>
                <div class="inline-arch-div"></div>
                <archFormInput
                  v-for="template in wellsTree"
                  :key="template.year" 
                  type="year" :template="template">
                </archFormInput>
              </div>
         
          </div>
          
        </div>

        <div class="tkrs-content">
            <div>
              <div class="table-div">
            <div>
              
              <table>
                
                <tbody>
                    <tr>
                      <td><svg width="268" height="79" viewBox="0 0 268 79" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
<rect width="268" height="78.8806" fill="url(#pattern0)"/>
<defs>
<pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1">
<use xlink:href="#image0_1443:85818" transform="translate(0 -0.000756598) scale(0.00373134 0.0126774)"/>
</pattern>
<image id="image0_1443:85818" width="268" height="79" xlink:href="data:image/png;base64,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"/>
</defs>
</svg></td>
                      <td class="header_name">Служба бурение и ремонт скважин (СБ и РС)</td>
                    </tr>
                </tbody>
              </table>
              <table>
                <tbody>
                    <tr>
                      <td class="header_name">Ежедневный отчет по освоению, капитальному и подземному ремонту скважин </td>
                    </tr>
                </tbody>
              </table>
              <table>
                <tbody>
                    <tr>
                      <td class="header_name">Дата отчета</td>
                      <td class="input-form-auto header_name">{{wellFile}}</td>
                      <td class="input-form-auto header_name_red">{{well_name}}</td>
                      <td class="input-form-auto header_name_red">{{field_name}}</td>
                      <td class="header_name">Начало бурения:</td>
                      <td class="input-form-auto header_name_red">{{start_drill}}</td>
                      <td class="header_name">Конец бурения:</td>
                      <td class="input-form-auto header_name_red">{{end_drill}}</td>
                    </tr>
                    <tr>
                      <td class="header_name"> № отчета:</td>
                      <td class="input-form-auto header_name">{{report_number}}</td>
                      <td class="header_name">Задание по программе:</td>
                      <td class="input-form-auto header_name" colspan="2">{{programmes_target_name}}</td>
                      <td class="header_name">Тип скважины:</td>
                      <td class="input-form-auto header_name_red" colspan="2">{{well_type}}</td>
                    </tr>
                    <tr>
                      <td colspan="2" class="header_name">Тип станка:</td>
                      <td class="input-form-auto header_name">{{machine_type}}</td>
                      <td colspan="2" class="header_name">Подрядчик:</td>
                      <td colspan="3" class="input-form-auto header_name_red">{{contractor_name}}</td>
                    </tr>
                </tbody>
              </table>
              <table>
                <tbody>
                    <tr>
                      <td colspan="6" class="header_name">Параметры (давления) по скважине </td>
                    </tr>
                    <tr>
                      <td class="header_name">Трубное давление:</td>
                      <td class="input-form-auto header_name_red">{{pipe_pressure}}</td>
                      <td class="header_name">Затрубное давление:</td>
                      <td class="input-form-auto header_name_red">{{annular_pressure}}</td>
                      <td class="header_name">Межколонное давление:</td>
                      <td class="input-form-auto header_name_red">0 атм</td>
                    </tr>
                </tbody>
              </table>
              <table>
                <tbody>
                    <tr>
                      <td class="header_name">Начало</td>
                      <td class="header_name">Конец</td>
                      <td class="header_name">Часы</td>
                      <td rowspan="2" class="header_name">Сводка по работам (описание проделаных работ)</td>
                    </tr>
                    <tr>
                      <td colspan="3" class="header_name">Дневное время</td>
                    </tr>
                    <tr v-for="(item, item_index) in works_report_range.dbeg_day" :key="item_index">
                      <td    class="header_name manual-edit">{{item}}</td>
                      <td class="header_name manual-edit">{{works_report_range.dend_day[item_index]}}</td>
                      <td class="header_name input-form-auto">{{works_report_range.duration_day[item_index]}}</td>
                      <td class="manual-edit day-works">{{works_report_range.day_works[item_index]}}<input class="manual-input"/></td>
                    </tr>
                    
                    <tr>
                      <td colspan="3" class="header_name">Ночное время</td>
                      <td></td>
                    </tr>
                    <tr v-for="(item, item_index) in works_report_range.dbeg_night" :key="item_index">
                      <td class="header_name manual-edit">{{item}}</td>
                      <td class="header_name manual-edit">{{works_report_range.dend_night[item_index]}}</td>
                      <td class="header_name input-form-auto">{{works_report_range.duration_night[item_index]}}</td>
                      <td class="manual-edit day-works">{{works_report_range.night_works[item_index]}}<input class="manual-input"/></td>
                    </tr>
                </tbody>
              </table>
              <table>
                <tbody>
                    <tr>
                      <td class="header_name">Всего за сутки:</td>
                      <td class="input-form-auto header_name">24</td>
                      <td class="header_name">Сегодня</td>
                      <td class="header_name">Предыдущее</td>
                      <td class="header_name">Итого</td>
                      <td colspan="6" class="header_name">Данные по скважине</td>
                    </tr>
                    <tr>
                      <td colspan="2" class="header_name">Всего часов, в т.ч:</td>
                      <td class="input-form-auto header_name">{{curr_hour_works[0]}}</td>
                      <td class="input-form-auto header_name">{{prev_hour_works[0]}}</td>
                      <td class="input-form-auto header_name">{{all_day_hour_works[0]}}</td>
                      <td class="header_name">Превышение стола ротора, м</td>
                      <td class="input-form-auto"></td>
                      <td class="header_name">наружный диаметр, мм</td>
                      <td class="header_name">толщина стенки, мм</td>
                      <td class="header_name">глубина спуска, м</td>
                      <td class="header_name">объем, литр на 1-метр</td>
                    </tr>
                    <tr>
                      <td colspan="2" class="header_name">Производительное время:</td>
                      <td class="header_name manual-edit">{{curr_hour_works[1]}}</td>
                      <td class="input-form-auto header_name">{{prev_hour_works[1]}}</td>
                      <td class="input-form-auto header_name">{{all_day_hour_works[1]}}</td>
                      <td colspan="2" class="header_name"> Эксплуатационная колонна</td>
                      <td class="input-form-auto header_name">{{prod_casing_outer_d}}</td>
                      <td class="input-form-auto header_name">{{wall_thickness}}</td>
                      <td class="input-form-auto header_name">{{descent_depth}}</td>
                      <td class="input-form-auto header_name">17,76</td>
                    </tr>
                    <tr>
                      <td colspan="2" class="header_name">прочее (ОЗЦ и т.д)</td>
                      <td class="header_name manual-edit">{{curr_hour_works[2]}}</td>
                      <td class="input-form-auto header_name">{{prev_hour_works[2]}}</td>
                      <td class="input-form-auto header_name">{{all_day_hour_works[2]}}</td>
                      <td colspan="6" class="header_name">Примечание</td>
                    </tr>
                    <tr>
                      <td colspan="2" class="header_name">Непроизводительное время в т.ч:</td>
                      <td class="input-form-auto header_name">{{curr_hour_works[3]}}</td>
                      <td class="input-form-auto header_name">{{prev_hour_works[3]}}</td>
                      <td class="input-form-auto header_name">{{all_day_hour_works[3]}}</td>
                      <td colspan="2" class="header_name">Искусственный забой, м</td>
                      <td class="input-form-auto header_name">{{artificial_slaughter}}</td>
                      <td colspan="2" class="header_name">Текущий забой, м</td>
                      <td class="input-form-auto header_name">{{current_bottomhole}}</td>
                    </tr>
                    <tr>
                      <td colspan="2" class="header_name">обеденный перерыв</td>
                      <td class="header_name manual-edit">{{curr_hour_works[4]}}</td>
                      <td class="input-form-auto header_name">{{prev_hour_works[4]}}</td>
                      <td class="input-form-auto header_name">{{all_day_hour_works[4]}}</td>
                      <td colspan="2" class="header_name">Интервал перфорации</td>
                      <td colspan="4" class="input-form-auto header_name">1700-1710м.</td>
                    </tr>
                    <tr>
                      <td colspan="2" class="header_name">ремонт оборудования</td>
                      <td class="header_name manual-edit">{{curr_hour_works[5]}}</td>
                      <td class="input-form-auto header_name">{{prev_hour_works[5]}}</td>
                      <td class="input-form-auto header_name">{{all_day_hour_works[5]}}</td>
                      <td colspan="6" rowspan="4" class="input-form-auto day-works">{{all_works}}</td>
                    </tr>
                    <tr>
                      <td colspan="2" class="header_name">метеоусловия</td>
                      <td class="header_name manual-edit">{{curr_hour_works[6]}}</td>
                      <td class="input-form-auto header_name">{{prev_hour_works[6]}}</td>
                      <td class="input-form-auto header_name">{{all_day_hour_works[6]}}</td>
                    </tr>
                    <tr>
                      <td colspan="2" class="header_name"> ожидание по вине Подрядчика</td>
                      <td class="header_name manual-edit">{{curr_hour_works[7]}}</td>
                      <td class="input-form-auto header_name">{{prev_hour_works[7]}}</td>
                      <td class="input-form-auto header_name">{{all_day_hour_works[7]}}</td>
                    </tr>
                    <tr>
                      <td colspan="2" class="header_name">ожидание по вине третьей стороны</td>
                      <td class="header_name manual-edit">{{curr_hour_works[8]}}</td>
                      <td class="input-form-auto header_name">{{prev_hour_works[8]}}</td>
                      <td class="input-form-auto header_name">{{all_day_hour_works[8]}}</td>
                    </tr>
                </tbody>
              </table>
              <table>
                <tbody>
                    <tr>
                      <td rowspan="3" class="header_name">Начальник Б и РС ТОО СП "КГМ"</td>
                      <td rowspan="3" class="header_name">{{chief}}</td>
                      <td class="header_name">подпись</td>
                      <td class="header_name">Мастер КПРС</td>
                      <td class="header_name">ФИО</td>
                      <td class="header_name">подпись</td>
                      <td class="header_name">номер телефона</td>
                    </tr>
                    <tr>
                      
                      <td></td>
                      <td class="header_name">дневная смена</td>
                      <td class="manual-edit header_name"><input class="manual-input"/>{{master_day_shift}}</td>
                      <td></td>
                      <td class="manual-edit header_name"><input class="manual-input"/>{{master_day_shift_number}}</td>
                    </tr>
                    <tr>
                      
                      <td></td>
                      <td class="header_name">ночная смена</td>
                      <td class="manual-edit header_name"><input class="manual-input"/>{{master_night_shift}}</td>
                      <td></td>
                      <td class="manual-edit header_name"><input class="manual-input"/>{{master_night_shift_number}}</td>
                    </tr>
                </tbody>
              </table>
            </div>
            
      </div>
      <div class="daily-report">
        <div class="daily-report-buttons">
         
          <button class="daily-report-button">{{trans('tr.form')}}</button>
          <button class="daily-report-button">{{trans('tr.save')}}</button>
          <button class="daily-report-button">{{trans('tr.cancel')}}</button> 
        </div>
      </div>      
            </div>

        </div>
    </div>
    
  </div>
</template>

<script>
import mainHeader from "./mainHeader.vue";
import baseBlock from './baseBlock.vue';
import BaseTable from './BaseTable.vue';
import {globalloadingMutations} from '@store/helpers'
import dailyReportCurrent from "./dailyReportCurrent.vue";
import currentFormInput from './tabs/currentFormInput.vue';
import archFormInput from './tabs/archFormInput.vue';
import {mapState, mapActions} from 'vuex'

export default {
  name: "gps",
  props: {
    route: String,
  },
  components: {
    mainHeader,
    BaseTable,
    baseBlock,
    dailyReportCurrent,
    currentFormInput,
    archFormInput
  },
  computed: {
    ...mapState('tkrsDailyReport', ["contractor_name", "areaChartData", "report_number","machine_type",
    "field_name","well_type"]),
  },
  data(){
    return {
      currentBlockTab: 1,
      calendarDate: '2020-06-17',
      Date1: null,
      // areaChartData: [],
      isChart: true,
      wellList: [],
      wellDate: [],
      wellNumber: null,
      wellFile: null,
      maximum: null,
      minimum: null,
      chartData: null,
      // contractor_name: null,
      // report_number:  null,
      // well_type:  null,
      // field_name:  null,
      // machine_type:  null,
      well_name:  null,
      programmes_target_name:  null,
      chief:  null,
      master_day_shift:  null,
      master_day_shift_number:  null,
      master_night_shift:  null,
      master_night_shift_number:  null,
      programmes_target_name:  null,
      works_report_range: [],
      all_day_hour_works: [],
      prev_hour_works: [],
      curr_hour_works: [],
      start_drill:  null,
      end_drill:  null,
      all_works:  null,
      postApiUrl: process.env.MIX_TKRS_POST_API_URL,
      linkWell: "drWellName/",
      linkWellDate: "drWellDates/",
      linkWellReport: "drHeaderWorkReport/",
      annular_pressure: null,
      descent_depth: null,
      pipe_pressure: null,
      artificial_slaughter: null,
      current_bottomhole: null,
      prod_casing_outer_d: null,
      wall_thickness: null,
      wellsTreeCurrent: {},
      wellsTree: {},
    }
  },
  created: async function () {
    this.SET_LOADING(true);
    await this.axios
      .get(
        this.postApiUrl + this.linkWell,
        )
      .then((response) => {
        this.SET_LOADING(false);
        let data = response.data;
        if (data) {
        
        } else {
          console.log("No data");
        }
        return Promise
      })
      .catch((error) => {
        console.log(error.data);
        this.SET_LOADING(false);
      });
      this.getListWell();
      this.getDataTreeCurrent();
      this.getDataTreeArchive()
  
    },
  
  methods: {
    ...globalloadingMutations([
      'SET_LOADING'
    ]),

    comparison_graphs() {
        this.$modal.show('comparison_graphs')
    },
    onChangeWell(number) {
      this.wellNumber = number;
      this.postSelectedtWell();        
    },
    onChangeWellDate(number) {
      this.wellFile = number;
      this.postSelectedtWellFile();
    },
    getListWell() {
      
        this.axios
            .get(
                this.postApiUrl + this.linkWell,
            )
            .then((response) => {
              
                let data = response.data;
                if (data) {
                    this.wellList = data.data.wells;
                    console.log(this.wellList);
                    
                } else {
                    console.log("No data");
                }
            });
    },
    postSelectedtWell() {
        this.axios
            .get(
                this.postApiUrl + this.linkWellDate + `${this.wellNumber}/`,
            )
            .then((response) => {
                let data = response.data;
                if (data) {
                    this.wellDate = data.data.dates;
                    
                    
                } else {
                    console.log("No data");
                }
            });
    },
    // postSelectedtWellFile() {
    //   this.SET_LOADING(false);
    //     this.axios
    //         .get(
    //             this.postApiUrl + this.linkWellReport + `${this.wellNumber}/${this.wellFile}/`,
    //         )
    //         .then((response) => {
    //             let data = response.data;
    //             if (data) {
    //                 this.areaChartData = data.data;
    //                 this.contractor_name = data.data.header.contractor_name;
    //                 this.report_number = data.data.header.report_number;
    //                 this.machine_type = data.data.header.machine_type;
    //                 this.field_name = data.data.header.field_name;
    //                 this.well_type = data.data.header.well_type;
    //                 this.well_name = data.data.header.well_name;
    //                 this.programmes_target_name = data.data.header.programmes_target_name;
    //                 this.chief = data.data.works_report.chief;
    //                 this.master_day_shift = data.data.works_report.master_day_shift;
    //                 this.master_day_shift_number = data.data.works_report.master_day_shift_number;
    //                 this.master_night_shift = data.data.works_report.master_night_shift;
    //                 this.master_night_shift_number = data.data.works_report.master_night_shift_number;
    //                 this.works_report_range = data.data.works_report_range;
    //                 this.start_drill = data.data.header.start_drill;
    //                 this.end_drill = data.data.header.end_drill;
    //                 this.all_works = data.data.works_report_range.all_works;
    //                 this.all_day_hour_works = data.data.all_day_hour_works.all_day_hour_works;
    //                 this.curr_hour_works = data.data.all_day_hour_works.curr_hour_works;
    //                 this.prev_hour_works = data.data.all_day_hour_works.prev_hour_works;
    //                 this.annular_pressure = data.data.parameters.annular_pressure;
    //                 this.descent_depth = data.data.parameters.descent_depth;
    //                 this.pipe_pressure = data.data.parameters.pipe_pressure;
    //                 this.artificial_slaughter = data.data.parameters.artificial_slaughter;
    //                 this.current_bottomhole = data.data.parameters.current_bottomhole;
    //                 this.prod_casing_outer_d = data.data.parameters.prod_casing_outer_d;
    //                 this.wall_thickness = data.data.parameters.wall_thickness;
    //             } else {
    //                 console.log("No data");
    //             }
    //         });
    // },
    getDataTreeCurrent() {
      
      this.axios
          .get(
               `http://172.20.103.203:8090/wellNameDate1/`,
              
          )
          .then((response) => {
              let data = response.data;
              if (data) {
                this.wellsTreeCurrent = data
              } else {
                  console.log("No data");
              }
          });
    },
    getDataTreeArchive() {
      
      this.axios
          .get(
               `http://172.20.103.203:8090/wellTreeName/`,
              
          )
          .then((response) => {
              let data = response.data;
              if (data) {
                this.wellsTree = data

              } else {
                  console.log("No data");
              }
          });
    },
    cancelChat() {
        this.isChart = false;
    },
    returnChat() {
      this.isChart = true;
    },
    
    selectTab(selectedTab) {
            this.currentTab = selectedTab
    },

    selectBlockTab(selectedBlockTab) {
      this.currentBlockTab = selectedBlockTab
    },
  },
};
</script>
<style lang="scss" scoped src="./InputFormTableStyles.scss"></style>
<style scoped>
.tkrs-main {
  width: 100%;
  height: 100%;
}

.tkrs-content {
  display: flex;
  width: 100%;
  height: calc(100vh - 143px);
  padding-left: 6px;
}
table {
  color: white;
  background: #333975;
}
table, th, td {
  border:1px solid black;
}
.input-form-auto{
background: #eaf3fa
}
.input-form-dropdown {
background: #eaf3fa !important; 
color: black !important; 
border: none !important;
}
.manual-edit {
  background: #ffff;
}
.manual-input {
  width: 100%; 
  height: 22px;
  border: none;
}
.manual-input:hover {
  border: none;
}
.daily-report-buttons {
  background: #323370;
  height: 4%;
  float: right;
}
.daily-report {
  background: #323370;
  height: 4%;
}
.sidebar_graph {
  height: calc(100% - 36px);
}
.tkrs-content-down {
      height: 100%;
}
.custom-dropdown-block {
  background: #1F2142;
  border: none;
  color: #fff;
}
.line-block {
  height: 4px;
}
.online-block {
  width: 100%;
}
.comparison-graphs {
  color: #fff;
  font-size: 16px;
}
.data-analysis-left-block {
  width: 249px;
  flex-shrink: 0;
  display: flex;
  flex-flow: column;
  height: 100%;
  background: #272953;
  color: #fff;
}

.left-block-collapse-holder {
  display: flex;
  width: 100%;
  height: 42px;
  background-color: #323370;
}

.left-block-collapse-holder > div {
  display: flex;
  height: 100%;
  width: calc(100% - 29px);
  align-items: center;
  background-color: #323370;
}

.left-block-collapse-holder > div > img {
  margin: 0 8px 0 10px;
}

.collapse-left__sidebar {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 29px;
  background: var(--a-accent);
  padding: 14px 6px;
  border-radius: 10px 0 0 10px;
  border: none;
  border-left: 5px solid #272953;
}
.daily-report-button {
  background: #3C4280;
    color: white;
    border: none;
}
.header_name {
  font-size: 14px;
  font-weight: bold;
}
.header_name_red {
  font-size: 14px;
  font-weight: bold;
  color: #E31F25;
}
.day-works {
  font-size: 14px;
  font-weight: bold;
  text-align: left;
}
.tab-lblock-header {
  color: white !important;
  background: #181837 !important;
}
.dropdown-holder {
  background-color: rgba(255, 255, 255, 0.04);
  width: 100%;
  padding: 6px 6px 1px 6px;
  margin-bottom: 10px;
}
.btn-group::v-deep .btn-secondary {
    color: #fff;
    background-color: #20274F;
    border-color: #20274F;
    width: 100%;
}
.form-input-block-header {
    font-size: 14px;
    color: white;
    padding-left: 7px;
    padding-bottom: 6px;
}
.online-block {
  width: 100%;
  background: #293688;
}
.left-block-dropdown {
  width: 100% !important;
}
.inline-arch-div {
  padding-top: 21px;
}
</style>