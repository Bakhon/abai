<template>
  <div class="all-contents">
    <div class="row well-cart__wrapper">
      <cat-loader v-show="loading"/>
      <div
          :class="{'left-column_folded': isLeftColumnFolded}"
          class="left-column"
      >
        <div class="bg-dark left-column__inner">
          <div class="row">
            <div class="col">
              <div class="well-deal">
                <div class="well-deal__header">
                  <div class="title">
                    <div class="icon-ierarchy"></div>
                    <h2>Дело скважины</h2>
                  </div>
                  <div class="icon-all" style="margin-left: auto;"
                       @click="onLeftColumnFoldingEvent(isLeftColumnFolded, isRightColumnFolded, isBothColumnFolded)">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M11 1L5.8053 6L11 11" stroke="white" stroke-width="1.2" stroke-linecap="round"
                            stroke-linejoin="round"/>
                      <path d="M6.19472 1L1 6L6.19472 11" stroke="white" stroke-width="1.2" stroke-linecap="round"
                            stroke-linejoin="round"/>
                    </svg>
                  </div>
                </div>
              </div>
            </div>
            <div class="directory">
              <div class="custom-directory">
                <ul id="myUL">
                  <li :class="{'selected': activeFormCode === 'well_design'}" @click="setForm('well_design')">
                    <p>
                      <span class="file">Конструкция скважины по проекту</span>
                    </p>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div :class="{'right-column_folded': isRightColumnFolded, 'both-pressed_folded' : isBothColumnFolded}"
           class="right-column__inner bg-dark" style="display:none"></div>
      <div class="col-md-6 mid-col">
        <div class="row mid-col__main">
          <div class="col-md-12 mid-col__main-inner bg-dark-transparent">
            <div class="row">
              <div class="col">
                <button class="transparent-select">
                  Скважина: <span v-if="allData">{{ allData.uwi }}</span>
                  <svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1 1L7 7L13 1" stroke="white" stroke-width="1.6" stroke-linecap="round"
                          stroke-linejoin="round"/>
                  </svg>
                </button>
              </div>
              <div class="col">
                <form class="search-form">
                  <v-select
                      :filterable="false"
                      :options="options"
                      placeholder="Номер скважины"
                      @input="selectWell"
                      @search="onSearch"
                      v-model="wellName"
                  >
                    <template slot="option" slot-scope="option">
                      <span>{{ option.name }}</span>
                    </template>
                  </v-select>
                </form>
              </div>
            </div>
            <div v-if="allData" class="mid-col__main row">
              <div class="col">
                <div class="graphics">
                  <div class="row">
                    <div class="col" style="max-width: 64px; display: grid; padding: 0px;">
                      <svg width="42" height="42" viewBox="0 0 42 42" fill="none" xmlns="http://www.w3.org/2000/svg"
                           style="margin: 12px 0px 0px 24px;">
                        <path
                            d="M20.9993 0.999999C25.0498 0.999999 31.5236 0.999999 36.0037 0.999999C38.7652 0.999999 41 3.23536 41 5.99678C41 10.9694 41 18.2449 41 21C41 24.4924 41 31.3063 41 36.0027C41 38.7641 38.7632 40.9999 36.0018 40.9999C31.2512 40.9999 24.3497 41 20.9993 41C17.1648 41 10.5605 41 5.99621 41C3.23481 41 1.00023 38.763 1.00018 36.0016C1.0001 31.1169 1 23.9922 1 21C1 17.6496 1.0001 10.7485 1.00018 5.99813C1.00022 3.23674 3.23602 0.999999 5.99741 0.999999C10.6937 0.999999 17.5075 0.999999 20.9993 0.999999Z"
                            stroke="#2E50E9" stroke-miterlimit="22.9256"/>
                        <path
                            d="M20.9994 2.99996C24.7981 2.99996 30.9653 2.99996 35.0024 2.99996C37.2115 2.99996 39 4.79063 39 6.99977C39 11.4726 39 18.4269 39 21C39 24.2698 39 30.7748 39 35.0039C39 37.213 37.2127 38.9999 35.0036 38.9999C30.7266 39 24.135 39 20.9994 39C17.4055 39 11.1085 39 6.99658 39C4.78747 39 3.00021 37.2109 3.00017 35.0018C3.0001 30.6063 3 23.7971 3 21C3 17.8643 3.0001 11.2731 3.00017 6.9963C3.00021 4.78719 4.78713 2.99996 6.99624 2.99996C11.2252 2.99996 17.73 2.99996 20.9994 2.99996Z"
                            fill="#323370"/>
                        <path
                            d="M14.7029 25L13.5829 20.472C13.4656 19.96 13.3536 19.4053 13.2469 18.808H13.1829C13.0763 19.5333 12.9483 20.1947 12.7989 20.792L11.7749 25H10.1269L8.11094 17.336H9.39094L10.5909 22.392C10.7189 22.9573 10.8256 23.464 10.9109 23.912H10.9749C11.0283 23.624 11.1509 23.0907 11.3429 22.312L12.5429 17.336H13.9189L15.1669 22.376C15.2736 22.8133 15.3856 23.3253 15.5029 23.912H15.5509C15.6256 23.3787 15.7216 22.872 15.8389 22.392L17.0709 17.336H18.3349L16.3189 25H14.7029ZM22.9856 17.08C23.6469 17.08 24.2336 17.208 24.7456 17.464C25.2576 17.72 25.6522 18.0507 25.9296 18.456C26.2176 18.8613 26.4309 19.288 26.5696 19.736C26.7082 20.1733 26.7776 20.616 26.7776 21.064C26.7776 21.2667 26.7669 21.4213 26.7456 21.528H20.4896C20.4896 22.2213 20.7616 22.8347 21.3056 23.368C21.8496 23.8907 22.4842 24.152 23.2096 24.152C23.9989 24.152 24.6549 23.8427 25.1776 23.224H26.6336C26.3349 23.7893 25.8976 24.2747 25.3216 24.68C24.7562 25.0747 24.0629 25.272 23.2416 25.272C22.0362 25.272 21.0549 24.872 20.2976 24.072C19.5509 23.272 19.1776 22.2693 19.1776 21.064C19.1776 19.9653 19.5296 19.0267 20.2336 18.248C20.9376 17.4693 21.8549 17.08 22.9856 17.08ZM22.9856 18.184C22.2922 18.184 21.7216 18.4133 21.2736 18.872C20.8256 19.32 20.5696 19.8533 20.5056 20.472H25.4496C25.3856 19.8427 25.1242 19.304 24.6656 18.856C24.2176 18.408 23.6576 18.184 22.9856 18.184ZM28.4556 25V13.48H29.7196V25H28.4556ZM31.9243 25V13.48H33.1883V25H31.9243Z"
                            fill="white"/>
                      </svg>
                    </div>
                    <div class="col">
                      <div class="well-info">
                        <div class="title">Основное</div>
                        <p>Номер скважины:<span>{{ allData.uwi }}</span></p>
                        <p>Категория скважины: <span></span></p>
                        <div class="title">Привязка</div>
                        <p>Оргструктура: <span></span></p>
                        <div class="title">Координаты устья</div>
                        <p>Оргструктура: <span></span></p>
                        <p>Координаты устья X:<span></span></p>
                        <p>Координаты устья Y:<span></span></p>
                        <div class="title">Координаты забоя</div>
                        <p>Координаты устья X:<span></span></p>
                        <p>Координаты устья Y:<span></span></p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div :class="{'right-column_folded': isRightColumnFolded}" class="right-column__inner">
        <div class="bg-dark-transparent">
          <template>
            <div class="row">
              <div class="col">
                <div class="heading">
                  <div class="icon-all"
                       @click="onRightColumnFoldingEvent(isLeftColumnFolded, isRightColumnFolded, isBothColumnFolded)">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M1.0001 1L6.19482 6L1.0001 11" stroke="white" stroke-width="1.2" stroke-linecap="round"
                            stroke-linejoin="round"/>
                      <path d="M5.80528 1L11 6L5.80528 11" stroke="white" stroke-width="1.2" stroke-linecap="round"
                            stroke-linejoin="round"/>
                    </svg>
                  </div>
                  <p v-if="allData">Паспорт скважины</p>
                </div>
                <div class="title-container">
                  <div class="sheare-icon" v-if="allData">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path
                          d="M17.5443 8.3734L13.9393 4.79071C13.752 4.60451 13.4986 4.5 13.2344 4.5L7.10023 4.50002C6.54794 4.50002 6.10023 4.94773 6.10023 5.50002L6.10023 18.5C6.10023 19.0523 6.54795 19.5 7.10023 19.5H16.8394C17.3916 19.5 17.8394 19.0523 17.8394 18.5L17.8394 9.0827C17.8394 8.81641 17.7331 8.56111 17.5443 8.3734Z"
                          stroke="white" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M12.9067 4.5V8.51961C12.9067 9.07189 13.3545 9.51961 13.9067 9.51961H17.8391"
                            stroke="white" stroke-width="1.4" stroke-linejoin="round"/>
                      <path
                          d="M8.23505 15.02C8.52838 15.02 8.76705 15.1147 8.95105 15.304C9.13505 15.4907 9.22705 15.7347 9.22705 16.036C9.22705 16.0947 9.22438 16.148 9.21905 16.196H7.87505C7.87505 16.3053 7.91238 16.3987 7.98705 16.476C8.06171 16.5507 8.15371 16.588 8.26305 16.588C8.41238 16.588 8.51771 16.528 8.57905 16.408H9.20305C9.13638 16.608 9.02438 16.768 8.86705 16.888C8.70971 17.008 8.50438 17.068 8.25105 17.068C7.96571 17.068 7.72305 16.9733 7.52305 16.784C7.32571 16.5947 7.22705 16.3453 7.22705 16.036C7.22705 15.7427 7.31505 15.5 7.49105 15.308C7.66971 15.116 7.91771 15.02 8.23505 15.02ZM8.22705 15.456C8.12838 15.456 8.04838 15.4867 7.98705 15.548C7.92571 15.6067 7.88971 15.68 7.87905 15.768H8.57505C8.56438 15.6773 8.52705 15.6027 8.46305 15.544C8.40171 15.4853 8.32305 15.456 8.22705 15.456ZM9.29055 17L9.97855 16.044L9.32655 15.084H10.0705L10.2585 15.424C10.2905 15.4827 10.3199 15.552 10.3465 15.632H10.3625C10.3999 15.52 10.4239 15.4533 10.4345 15.432L10.6065 15.084H11.3465L10.6985 16.032L11.3665 17H10.5945L10.4105 16.66C10.3652 16.572 10.3399 16.5 10.3345 16.444H10.3185C10.3025 16.5027 10.2732 16.576 10.2305 16.664L10.0465 17H9.29055ZM12.4348 15.02C12.6908 15.02 12.9015 15.0987 13.0668 15.256C13.2322 15.4107 13.3308 15.5933 13.3628 15.804H12.7108C12.6975 15.7373 12.6642 15.684 12.6108 15.644C12.5602 15.604 12.4988 15.584 12.4268 15.584C12.3095 15.584 12.2228 15.6267 12.1668 15.712C12.1135 15.7973 12.0868 15.9067 12.0868 16.04C12.0868 16.1733 12.1162 16.284 12.1748 16.372C12.2335 16.4573 12.3215 16.5 12.4388 16.5C12.5135 16.5 12.5762 16.4787 12.6268 16.436C12.6802 16.3907 12.7162 16.3333 12.7348 16.264H13.3988C13.3402 16.5067 13.2282 16.7013 13.0628 16.848C12.9002 16.9947 12.6882 17.068 12.4268 17.068C12.1415 17.068 11.8988 16.9733 11.6988 16.784C11.5015 16.5947 11.4028 16.3453 11.4028 16.036C11.4028 15.748 11.4962 15.5067 11.6828 15.312C11.8695 15.1173 12.1202 15.02 12.4348 15.02ZM14.6218 15.02C14.9151 15.02 15.1538 15.1147 15.3378 15.304C15.5218 15.4907 15.6138 15.7347 15.6138 16.036C15.6138 16.0947 15.6111 16.148 15.6058 16.196H14.2618C14.2618 16.3053 14.2991 16.3987 14.3738 16.476C14.4484 16.5507 14.5404 16.588 14.6498 16.588C14.7991 16.588 14.9044 16.528 14.9658 16.408H15.5898C15.5231 16.608 15.4111 16.768 15.2538 16.888C15.0964 17.008 14.8911 17.068 14.6378 17.068C14.3524 17.068 14.1098 16.9733 13.9098 16.784C13.7124 16.5947 13.6138 16.3453 13.6138 16.036C13.6138 15.7427 13.7018 15.5 13.8778 15.308C14.0564 15.116 14.3044 15.02 14.6218 15.02ZM14.6138 15.456C14.5151 15.456 14.4351 15.4867 14.3738 15.548C14.3124 15.6067 14.2764 15.68 14.2658 15.768H14.9618C14.9511 15.6773 14.9138 15.6027 14.8498 15.544C14.7884 15.4853 14.7098 15.456 14.6138 15.456ZM15.9683 17V14.12H16.6443V17H15.9683Z"
                          fill="white"/>
                    </svg>
                  </div>
                  <div class="sheare-text" v-if="allData">
                    Скачать в MS-Excel
                  </div>
                </div>
              </div>
            </div>
          </template>
          <div class="info">
            <div class="info-element">
              <div class="row">
                <div class="col">
                  <table v-if="allData">
                    <tr>
                      <th colspan="3">Общая информация</th>
                    </tr>
                    <tr>
                      <td>1</td>
                      <td>Скважина</td>
                      <td>{{ allData.uwi }}</td>
                    </tr>
                    <tr>
                      <td>2</td>
                      <td>Вид скважины</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>3</td>
                      <td>Месторождение</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>4</td>
                      <td> Горизонт / Pнас, атм</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>5</td>
                      <td> H ротора</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>6</td>
                      <td>Тех. структура</td>
                      <td>{{ tech[0].name_ru }}</td>
                    </tr>
                    <tr>
                      <td>7</td>
                      <td>Отвод</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>8</td>
                      <td>ГУ/Ряд</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>9</td>
                      <td>Орг. структура</td>
                      <td>
                        <span v-for="value in org">
                          {{ value.name_ru + "/" }}
                        </span>
                      </td>
                    </tr>
                    <tr>
                      <td>10</td>
                      <td>Зона скважины</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>11</td>
                      <td>Влияющие скважины</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>12</td>
                      <td>Категория</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>13</td>
                      <td>Период бурения</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>14</td>
                      <td>Дата ввода в эксплуатацию</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>15</td>
                      <td>Дата ввода в эксплуатацию</td>
                      <td>{{ tech[0].dbeg }}</td>
                    </tr>
                    <tr>
                      <td>16</td>
                      <td>Состояние</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>17</td>
                      <td>Способ эксплуатации</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>18</td>
                      <td>Тип УО / наличие эксц.болта</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>19</td>
                      <td>Диаметр экспл.колонны/доп. экспл.колонны,мм</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>20</td>
                      <td>Тип колонной головки / размеры</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>21</td>
                      <td>глубина спуска насоса (м)</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>22</td>
                      <td>Код насоса</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>23</td>
                      <td>Диаметр насоса (мм)</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>24</td>
                      <td>Глубина спуска пакера</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>25</td>
                      <td>Тип СК</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>26</td>
                      <td>длина хода (м)</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>27</td>
                      <td>число качаний (об/мин)</td>
                      <td></td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import BigDataPlainFormResult from '../bigdata/forms/PlainFormResults'
import vSelect from "vue-select"
import axios from "axios";

export default {
  components: {
    BigDataPlainFormResult,
    vSelect
  },
  data() {
    return {
      options: [],
      well: null,
      tech: null,
      wellName: null,
      org: null,
      geo: null,
      graph: null,
      activeFormCode: null,
      loading: false,
      isLeftColumnFolded: false,
      isRightColumnFolded: false,
      isBothColumnFolded: false,
      allData: null,
      popup: false
    }
  },
  mounted() {

  },
  methods: {
    onLeftColumnFoldingEvent(isLeftColumnFolded, isRightColumnFolded, isBothColumnFolded) {
      //method check the isLeftColumnFolded & isRightColumnFolded var and returns isBothColumnFolded if true
      this.isLeftColumnFolded = !isLeftColumnFolded;
      if (this.isLeftColumnFolded === true && this.isRightColumnFolded === true) {
        this.isBothColumnFolded = !isBothColumnFolded;
        this.isBothColumnFolded = true;
      } else {
        this.isBothColumnFolded = false;
      }
    },
    onRightColumnFoldingEvent(isLeftColumnFolded, isRightColumnFolded, isBothColumnFolded) {
      //method check the isLeftColumnFolded & isRightColumnFolded var and returns isBothColumnFolded if true
      this.isRightColumnFolded = !isRightColumnFolded;
      if (this.isLeftColumnFolded === true && this.isRightColumnFolded === true) {
        this.isBothColumnFolded = !isBothColumnFolded;
        this.isBothColumnFolded = true;
      } else {
        this.isBothColumnFolded = false;
      }
    },
    onSearch(search, loading) {
      if (search.length) {
        loading(true);
        this.search(loading, search, this);
      }
    },
    search: _.debounce((loading, search, vm) => {
          axios.get(vm.localeUrl('/api/bigdata/wells/search'), {params: {query: escape(search)}}).then(({data}) => {
            vm.options = data.items;
            loading(false);
          })
        },
        350
    ),
    selectWell(well) {
      this.loading = true
      this.axios.get(this.localeUrl(`/api/bigdata/wells/${well.id}`)).then(({data}) => {
        this.tech = data[0].techs
        this.org = data[0].orgs
        this.geo = data[0].geo
        this.wellName = data[0].uwi
        this.allData = data[0]
        console.log(data[0])
        this.loading = false
      })
    },
    setForm(formCode) {
      this.activeFormCode = formCode
    }
  }
}
</script>

<style scoped lang="scss">
$leftColumnWidth: 398px;
$leftColumnFoldedWidth: 84px;
$rightColumnWidth: 348px;
$rightColumnFoldedWidth: 84px;

.well-cart {
  &__wrapper {
    height: calc(100vh - 90px);
  }
}

.flex {
  display: flex;
}

.inline-table {
  display: inline-table;
}

.b-container {
  font-family: Roboto;
  width: 480px;
  margin: 200px auto auto auto;
  padding: 10px;
  font-size: 30px;
  color: #fff;
  border-radius: 30px;
  padding: 10px;

  h6 {
    color: #FEFEFE;
    font-weight: 400;
    font-size: 24px;
    padding-left: 20px;
    margin-bottom: auto;
    margin-top: auto;

  }

  p {
    text-align: center;
    width: 100%;
    color: #FEFEFE;
    font-weight: 400;
    font-size: 24px;
    padding-left: 20px;
    margin-top: 30px;
    margin-bottom: 20px;
  }

  .b-title-block {
    padding-top: 10px;
    padding-left: 40px;
    display: flex;

  }

  .search-form {
    .search-input {
      width: 100%;
      margin-bottom: 20px;
      background: url(/img/bd/search.svg) 1% no-repeat #4F5979;
      font-size: 16px;
      padding: 10px 0px 10px 30px;
      border-radius: 10px;
    }

    .b-date {
      height: 40px;
      font-size: 14px;
      flex-direction: row-reverse;
      background: #4F5979;
      width: 65%;
      border-radius: 10PX;
      color: white;
      margin-right: 7px;
    }

    .b-time {
      height: 40px;
      font-size: 14px;
      flex-direction: row-reverse;
      background: #4F5979;
      border-radius: 10PX;
      color: white;
      margin-left: auto;
    }

  }

  .b-button-container {
    display: flex;
    margin-left: auto;
    margin-right: auto;

    button {
      margin-top: 30px;
      height: 40px;
      font-size: 14px;
      flex-direction: row-reverse;
      background: #4F5979;
      width: 130px;
      border-radius: 10PX;
      color: white;
      margin-right: 7px;
    }

    .accept {
      background: #2E50E9;
      margin-left: auto;
      margin-right: auto;
    }

    .cancel {
      margin-left: auto;
      margin-right: auto;
      background: #132152;
      color: #ABADB8;
    }
  }
}

.b-popup {
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  overflow: hidden;
  position: fixed;
  top: 0;
  display: block;
  z-index: 800;

  button {
    margin-top: 30px;
    height: 40px;
    font-size: 14px;
    flex-direction: row-reverse;
    background: #4F5979;
    width: 130px;
    border-radius: 10PX;
    color: white;
    margin-right: 7px;
  }

}

.b-popup .b-popup-content {
  margin: 40px auto 0 auto;
  width: 100px;
  height: 40px;
  padding: 10px;
  background-color: #c5c5c5;
  border-radius: 5px;
  box-shadow: 0 0 10px #000;
}

.custom-directory {
  img {
    padding-bottom: 5px;
  }

  ul, li {
    color: white;
    list-style: none;
    margin: 0;
    padding: 0;
  }

  ul .nested {
    border-top: 1px dashed #555BA6;
    border-left: 0;
  }

  ul {
    padding-left: 1em;
    border: 0;
  }

  li {
    border: 1px dashed #555BA6;
    padding-left: 1em;
    border-width: 0 0 1px 1px;

    &.selected {
      font-weight: bold;
    }
  }

  li p {
    margin: 0;
    background: #272953;
    position: relative;
    bottom: 0.6em;
  }

  li ul {
    margin-left: -1em;
    padding-left: 2em;
  }

  ul li:last-child ul {
    border-bottom: 0;
    margin-left: -17px;
  }

  li:last-child {
    border-bottom: 0
  }

  ul, #myUL {
    list-style-type: none;
  }

  .caret {
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    margin-right: auto;
  }

  .file {
    cursor: pointer;
    padding-left: 0;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    margin-right: auto;
  }

  .file::before {
    content: URL(/img/bd/file.svg);
    color: white;
    display: inline-block;
    padding-right: 10px;
  }

  .caret::before {
    content: URL(/img/bd/folder.svg);
    color: white;
    display: inline-block;
    padding-right: 10px;
  }

  .caret-down::before {
    color: white;
    background: white;
  }

  .nested {
    display: block;
  }

  .active {
    display: block;
  }
}

h4 {
  text-align: left;
  font-size: 16px;
  font-weight: 700;
  line-height: 20px;
  color: white;
  padding-right: 20px;
}

.well-deal {
  width: 100%;
  display: flex;
  padding: 15px 19px;

  &__header {
    border-bottom: 1px solid #555BA6;
    display: flex;
    height: 45px;
    width: 100%;

    .title {
      display: flex;
    }
  }

  h2 {
    font-size: 20px;
    line-height: 24px;
    margin: 0;
    padding: 10px 5px;
  }

  .icon-ierarchy {
    width: 10px;
    height: 100%;
    background: url(/img/bd/ierarhy.svg) 50% 50% no-repeat;
    padding: 0 15px 0 10px;
  }
}

.new-directory {
  color: whitesmoke;

  ul, li {
    list-style: none;
    margin: 0;
    padding: 0;
  }

  ul {
    padding-left: 1em;
  }

  li {
    padding-left: 1em;
    border: 1px dotted white;
    border-width: 0 0 1px 1px;
  }

  li.container {
    border-bottom: 0;
  }

  li.empty {
    font-style: italic;
    color: silver;
    border-color: silver;
  }

  li p {
    margin: 0;
    position: relative;
    bottom: 1em;
    background: #20274F;
  }

  li ul {
    border-top: 1px dotted white;
    margin-left: -1em;
    padding-left: 2em;
  }

  ul li:last-child ul {
    border-left: 0 solid white;
    margin-left: -17px;
  }
}

.graphics {
  color: white;
  background: rgb(39, 41, 83);

  .select-button {
    background: #272953;
    width: 230px !important;
    margin-top: 14px;
    margin-left: 10px;
  }

  .title {
    font-family: 'Harmonia Sans Pro Cyr', 'Harmonia-Sans', 'Robato';
    font-weight: 700;
    font-size: 14px;
    line-height: 17px;
    border-bottom: 1px solid #2D43B4;
    padding-bottom: 8px;
  }

  p {
    font-family: 'Harmonia Sans Pro Cyr', 'Harmonia-Sans', 'Robato';
    font-weight: 400;
    font-size: 14px;
    line-height: 17px;
    margin: 0px;
  }

  span {
    font-weight: 600;
    color: #82BAFF;
  }

  .well-info {
    margin: 12px;

    :nth-child(1n) {
      margin: 4px 0px;
    }
  }
}

.directory {
  display: block;
  width: 100%;
  padding: 10px;
  margin: 10px 40px 10px 25px;

  col {
    display: flex;
  }

  h3 {
    font-size: 14px;
    font-weight: 700;
    line-height: 17px;
  }

  .names {
    color: #999DC0;
  }

  .icon-directory {
    width: 10px;
    height: 100%;
    background: url(/img/bd/folder.svg) no-repeat;
    padding: 0 15px 0 10px;
  }

  .border-pointer-solid {
    width: 10px;
    height: 100%;
    padding: 0 15px 0 10px;
    margin-top: 2px;
    border-top: 1px dashed #555BA6;
    border-left: 1px dashed #555BA6;
    border-bottom: 1px dashed #555BA6;
  }

  .pointer {
    position: absolute;
    width: 10px;
    margin-bottom: auto;
  }

  &:first-child {
    border-top: 1px solid #555BA6;
  }
}

.search-form {
  width: 280px;
  padding: 10px 10px;
  margin-left: auto;

  .v-select {
    background: url(/img/bd/search.svg) 20px 45% #272953 no-repeat;
    border: 1px solid #3b4a84;
    min-width: 0;
  }
}

.heading {
  margin-left: 11.19px;
  font-family: 'Harmonia Sans Pro Cyr', 'Harmonia-Sans', 'Robato';
  color: white;
  font-size: 16px;
  line-height: 18px;
  font-weight: 700;
  display: flex;
  height: 48px;

  p {
    margin: auto;
    font-size: 16px;
    font-weight: 700;
    line-height: 19px;
  }
}

.file-container {
  background: #313563;
  margin-left: auto;
  margin-right: auto;
  width: 200px;
  height: 250px;

  :first-child .col {
    height: 51.1px;
  }

  .file-icon-large {
    margin-left: auto;
    margin-right: auto;
    background: url(/img/bd/file-large.svg) no-repeat;
    height: 158.21px;
    width: 120px;

    .well-name {
      padding-right: 30.03px;
      margin-top: 114.67px;
      margin-left: 11.6px;
      background: none;
      font-family: 'Harmonia Sans Pro Cyr', 'Harmonia-Sans', 'Robato';
      font-weight: 400;
      font-size: 10px;
      line-height: 12px;

      p {
        background: none;
        font-family: 'Harmonia Sans Pro Cyr', 'Harmonia-Sans', 'Robato';
        font-weight: 400;
        font-size: 10px;
        line-height: 12px;
      }

      .well-own-name {
        font-weight: 700;
        font-size: 14px;
        line-height: 16.8px;
        color: #82BAFF;

      }
    }
  }

  p {
    margin-left: auto;
    color: white;
    background-color: #A18F47;
  }

  .icon-container {
    width: 100%;
    margin-top: 8.68px;
    margin-left: 12.82px;
    margin-right: 15.48px;
    margin-bottom: 9.64px;
  }
}

.txt5 {
  display: flex;
  padding-left: 5px;
  font-size: 12px;
  text-align: left;
  padding-left: 10px;
}

.dropdown {
  position: relative;

  :focus {
    background: #2E50E9;
  }

}

.small-select {
  width: 100%;
  max-width: 400px;
  height: 45px;
  margin-right: auto;
  margin-left: auto;
  margin-bottom: 1em;
  white-space: pre-line;

  .txt5 {
    padding-right: 15px;
    font-family: Roboto;
    font-weight: 700;
    font-size: 14px;
    line-height: 17px;
    margin-top: auto;
    margin-bottom: auto;
  }

  :focus {
    background: #2E50E9;
    border: 0;
  }

  :visited {
    background: #2E50E9;
    border: 0;
  }
}

.transparent-select {
  padding: 10px 0;
  color: white;
  background: none;
  border: none;
  font-weight: 700;
  font-size: 16px;
  line-height: 19px;
  font-family: 'Harmonia Sans Pro Cyr', 'Harmonia-Sans', 'Robato';

  &:focus {
    color: white;
    background: #20274f;
  }
}

.table-container {
  background-color: #272953;
  overflow-y: auto;
  overflow-x: auto;
  width: 100%;
  color: white;

  .table-container-header {
    text-align: center;
    padding: 14px 20px 0 20px;
    background-color: #32346C;
  }

  .table-container-column-header {
    text-align: center;
    background-color: #505684;
    height: 50px;

    .row {
      height: 100%;
    }
  }

  &-element {
    height: 340px;
    background-color: #272953;

    .table-container-svg {
      display: flex;
    }

    .svg-element {
      padding: 5px 13px 5px 23px;
      display: grid;

      svg {
        margin-left: auto;
        margin-right: auto;
        margin-top: auto;
        margin-bottom: auto;
      }
    }

    .element-position {
      padding: 5px 13px 5px 23px;
      display: flex;

      p {
        float: right;
        margin-top: auto;
        margin-bottom: auto;
        margin-left: auto;
      }

      .title {
        margin-left: unset !important;
        margin-right: auto !important;
      }

      svg {
        margin: auto;
      }
    }

    .row {
      flex-wrap: nowrap;
      min-height: 40px;

      &:nth-child(2n) {
        background-color: #31355E;
      }
    }
  }

  .row {
    margin-right: 0;
  }

  .table-border {
    border-top: hidden;
    border-left: 1px solid #464D7A;
    border-bottom: hidden;
    border-right: hidden;

    p {
      margin-top: auto;
      margin-bottom: auto;
    }
  }
}

.info {
  height: calc(100vh - 160px);
  margin-bottom: 0 !important;
  overflow-y: auto;
  overflow-x: hidden;

  table {
    margin: 0px 10px;
    font-family: 'Harmonia Sans Pro Cyr', 'Harmonia-Sans', 'Robato';
    border-collapse: collapse;
    width: 100%;

    th {
      background: #333975;
    }
  }

  td, th {
    border: 1px solid #454D7D;
    text-align: left;
    padding: 8px;
  }

  tr:nth-child(2n) {
    background-color: #2B2E5E;
  }

  .heading {
    padding: 11px 0 15px 13px;
    font-family: 'Harmonia Sans Pro Cyr', 'Harmonia-Sans', 'Robato';
    font-weight: 700;
  }

  .info-element {
    p {
      padding: 10px 10px 12px 14px;
      margin: 0;
      font-family: 'Harmonia Sans Pro Cyr', 'Harmonia-Sans', 'Robato';
      font-weight: 400;
      font-size: 16px;
    }
  }

}

.full-size-icon {
  width: 20px;
  margin-bottom: auto;
  padding-right: 5px;
}

.icon-all {
  float: left;
  height: 20px;
  width: 20px;
  border-radius: 15px;
  margin-top: auto;
  margin-bottom: auto;

  :hover {
    cursor: pointer;
  }
}

.button1-vc-inner {
  display: flex;
  float: left;
  width: 100%;
  height: 100%;

  .icon-all {
    height: 100%;

    .txt5 {
      margin-bottom: auto;
      margin-top: auto;
      width: 100%;
    }
  }

  .icon-pointer {
    margin-bottom: auto;
  }

  .text-wrapper {
    display: flex;
    width: 100%;
  }
}

.btn:not(:disabled):not(.disabled) {
  width: 100%;
}

.dropdown-menu.show {
  background: #40467E;
  color: white;
  width: 100%;
  padding: 0 7px 0 16px;
  border: 1px solid #2E50E9;
  border-radius: 8px;
  margin-top: 7px;

  ul:last-child li:last-child .bottom-border {
    border-bottom: 0;
  }

  .container {
    margin: 0;
  }

  li {
    display: flex;
    width: 100%;

    input[type=checkbox] {
      width: 5%;
      margin-left: auto;
    }

  }

  .flag {
    margin-top: auto;
    margin-bottom: auto;
    padding-right: 10px;
    content: URL(/img/bd/check-marker.svg);
  }

  .bottom-border {
    border-bottom: 1px solid rgba(196, 222, 242, 0.3);
    padding-bottom: 15px;
    padding-top: 15px;
    width: 100%;
  }

  .container {
    padding: 0;
    display: flex;
    position: relative;
    cursor: pointer;
  }

  .container input {
    opacity: 0;
    cursor: pointer;
    height: 0;
    width: 0;
  }

  .checkmark {
    height: 20px;
    width: 20px;
    border-radius: 6px;
    border: 2px solid #237DEB;
    margin-bottom: auto;
    margin-top: auto;
  }

  .container:hover input ~ .checkmark {
    background-color: #6A6D9C;
  }

  .container input:checked ~ .checkmark {
    background: #2196F3;

  }

  .checkmark:after {
    content: "";
    position: absolute;
    display: none;
  }

  .container input:checked ~ .checkmark:after {
    display: block;
  }

  .container .checkmark:after {
    width: 5px;
    height: 10px;
    bottom: 10px;
    border: solid white;
    border-width: 0 3px 3px 0;
    -webkit-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
    position: inherit;
    margin: auto;
  }

}

.dropdown-menu :last-child {
  border-bottom: 0;
}

.select-button {
  background: #656A8A;
  width: 100%;
  overflow: hidden;
  border-radius: 10px;
  cursor: pointer;
  padding: 0 7px;
  height: 40px;

  .icon-all {
    align-items: center;
    display: flex;
    height: 100%;
    width: auto;
  }
}

.icon-pointer {
  margin-left: 10px;
  width: 10px;
  height: 10px;
  white-space: nowrap;
  background: url(/img/bd/pointer.svg) 50% 100% no-repeat;
  margin-left: 0px;
  margin-top: auto;
  margin-bottom: auto;
  margin-right: auto;
}

.col {
  display: flex;
  margin-right: auto;
  margin-left: auto;
}

.sheare-icon {
  margin-left: auto;
  margin-top: auto;
  margin-bottom: auto;
  display: inline-flex;
}

.sheare-text {
  font-family: 'Harmonia Sans Pro Cyr', 'Harmonia-Sans', 'Robato';
  color: white;
  margin: auto 11.19px auto 0px;
  font-weight: 700;
  font-size: 12px;
  line-height: 14px;
}

.bg-dark {
  padding-bottom: 20px;
  margin-bottom: 20px;
}

.center {
  margin-left: auto;
  margin-right: auto;

  h2 {
    margin: 0;
    padding: 22px 25px;
    font-size: 20px;
    font-weight: 400;
    line-height: 24px;
    font-family: 'Harmonia Sans Pro Cyr', 'Harmonia-Sans', 'Robato';
  }
}

.pointer-large-icon {
  padding: 20px;
}

.bg-dark-transparent {
  background-color: rgba(39, 41, 83, 0.85);
  padding-bottom: 20px;
  margin-bottom: 20px;

  .graphics {
    height: 333px;
    width: 100%;
  }
}

.blue-section {
  color: #82BAFF;
}

::-webkit-scrollbar {
  width: 15px;
  background: #272953;

}

::-webkit-scrollbar-track {
  background: #272953;

}

::-webkit-scrollbar-thumb {
  background: URL("/img/bd/scroll-img.svg") no-repeat 50% #374178;
  height: 10px;
}

::-webkit-scrollbar-button {
  background: URL("/img/bd/scroll-array.svg") no-repeat 50% #485499;

  &:end {
    background: URL("/img/bd/scroll-array-end.svg") no-repeat 50% #485499;
  }
}

.table-wrapper {
  margin: 10px 20px;
  padding: 0;

}

.col-no-right-padding {
  padding-right: 0;
  width: 250px;
  max-width: 250px;
  min-width: 250px;
  margin-left: auto;
}

.passport {
  .bg-dark-transparent {
    padding-bottom: 0;
  }
}

.vertical-wrapper {
  width: 100%;
  margin-right: 0;
  margin-left: 0;
}

.both-pressed {
  min-width: $leftColumnWidth;
  width: $leftColumnWidth;
  padding: 0 15px;
  margin-bottom: 15px;

  &_folded {
    min-width: $leftColumnFoldedWidth;
    width: $leftColumnFoldedWidth;

    .icon-all {
      transform: rotate(180deg);
    }

    .well-deal__header {
      border: none;
    }

    .title, .directory {
      display: none;
    }

    & ~ .mid-col {
      min-width: calc(100% - #{$leftColumnFoldedWidth} - #{$rightColumnFoldedWidth} - 9px) !important;
    }

  }

  &__inner {
    height: 100%;
  }
}

.left-column {
  min-width: $leftColumnWidth;
  width: $leftColumnWidth;
  padding: 0 15px;
  margin-bottom: 0px;

  &_folded {
    min-width: $leftColumnFoldedWidth;
    width: $leftColumnFoldedWidth;

    .icon-all {
      transform: rotate(180deg);
    }

    .well-deal__header {
      border: none;
    }

    .title, .directory {
      display: none;
    }

    & ~ .mid-col {
      min-width: calc(100% - #{$leftColumnFoldedWidth} - #{$rightColumnWidth} - 9px);
    }

  }

  &__inner {
    height: 100%;
  }
}

.title-container {
  display: flex;
}

.right-column {
  min-width: $rightColumnWidth;
  padding-left: 15px;
  flex: 0 0 5%;


  &__inner {
    height: 100%;
    margin-left: 15px;
    min-width: 340px;
    max-width: 340px;
  }

  &_folded {
    min-width: $leftColumnFoldedWidth;
    width: $leftColumnFoldedWidth;
    max-width: $leftColumnFoldedWidth;
    margin: 0px;
    padding: 0px 15px;

    & ~ .mid-col {
      min-width: calc(100% - #{$leftColumnWidth} - #{$rightColumnFoldedWidth} - 9px);
    }

    .icon-all {
      transform: rotate(180deg);
    }

    p {
      display: none;
    }

    table {
      display: none;
    }

    .title-container {
      display: none;
    }
  }
}

.buttons-no-wrap {
  min-width: 150px !important;
}

.calc-width {
  flex: calc(100% - 250px);
  max-width: calc(100% - 250px);

}

.mid-col {
  min-width: calc(100% - #{$leftColumnWidth} - #{$rightColumnWidth} - 9px);
  padding: 0 15px;
  height: calc(100vh - 90px);

  &__main {
    height: 100%;
    overflow: hidden;

    &-inner {
      margin-bottom: 0;
    }
  }
  .col-md-12{
    height: 100%;
  }
}

.file-size {
  margin-left: auto;
  margin-bottom: auto;

  p {
    padding: 2.59px 5px 5px 5.55px;
    font-size: 14px;
    font-weight: 700;
    font-family: 'Harmonia Sans Pro Cyr', 'Harmonia-Sans', 'Robato';
    line-height: 16px;
  }
}
</style>
<style lang="scss">
.search-form {
  .v-select {
    border-radius: 10px;

    .vs__search {
      font-family: Roboto, sans-serif;
      font-size: 14px;
      font-weight: 400;
      margin-top: 0;
      padding-left: 45px;
    }

    .vs__selected {
      font-family: Roboto, sans-serif;
      font-size: 14px;
      font-weight: 400;
      margin-top: 0;
      padding-left: 45px;
    }

    .vs__actions {
      padding: 0 5px;

      .vs__clear, .vs__open-indicator {
        display: none;
      }

      .vs__spinner, .vs__spinner:after {
        border-color: rgba(238, 238, 238, 0.7);
        border-left-color: rgba(170, 170, 170, 0.7);
      }
    }
  }
}

.block {
  display: block;
}
</style>