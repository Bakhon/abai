<template>
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
                <div class="icon-all" style="margin-left: auto;" @click="isLeftColumnFolded = !isLeftColumnFolded">
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
    <div class="col-md-6 mid-col">
      <div class="row mid-col__main">
        <div class="col-md-12 mid-col__main-inner bg-dark-transparent">
          <div class="row">
            <div class="col">
              <select class="transparent-select">
                <option>Дело скважины {{ well.uwi }}</option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col table-wrapper">
              <template v-if="well && activeFormCode">
                <BigDataPlainFormResult :code="activeFormCode" :well-id="well.id"></BigDataPlainFormResult>
              </template>
            </div>
          </div>
          <div v-if="graph" class="mid-col__main row">
            <div class="col">
              <div class="bg-dark graphics">
                <div class="dropdown small-select">
                  <button class="btn btn-secondary select-button" type="button" id="OilDropdown"
                          data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="button1-vc-inner">
                      <div class="icon-all ">
                      </div>
                      <div class="text-wrapper">
                        <div class="txt5">Нефть, жикость</div>
                        <div class="icon-pointer" style="margin-left:auto"></div>
                      </div>

                    </div>
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <form>
                      <ul>
                        <li>
                          <div class="flag"></div>
                          <label class="container" for="oil">
                            <span class="bottom-border">Нефть, жидкость</span>
                            <input type="checkbox" id="oil" name="tech_structire" value="tech_structire"
                                   class="dropdown-item">
                            <span class="checkmark"></span>
                          </label>
                        </li>
                        <li>
                          <div class="flag"></div>
                          <label class="container" for="water_percent">
                            <span class="bottom-border">Обводненность, Н дин</span>
                            <input type="checkbox" id="water_percent" name="tech_structire_1" value="tech_structire"
                                   class="dropdown-item">
                            <span class="checkmark"></span>
                          </label>
                        </li>
                      </ul>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="passport right-column">
      <template v-if="well">
        <div class="bg-dark-transparent">
          <template>
            <div class="row">
              <div class="col">
                <div class="heading">
                  <div class="icon-all">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M1.0001 1L6.19482 6L1.0001 11" stroke="white" stroke-width="1.2" stroke-linecap="round"
                            stroke-linejoin="round"/>
                      <path d="M5.80528 1L11 6L5.80528 11" stroke="white" stroke-width="1.2" stroke-linecap="round"
                            stroke-linejoin="round"/>
                    </svg>
                  </div>
                  <p>Паспорт скважины</p>
                </div>
                <div class="sheare-icon">
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
                <div class="sheare-text">
                  Скачать в MS-Excel
                </div>
              </div>
            </div>
          </template>
          <div class="info">
            <div class="info-element">
              <div class="row">
                <div class="col">
                  <table>
                    <tr>
                      <th colspan="3">Общая информация</th>
                    </tr>
                    <tr>
                      <td>1</td>
                      <td>Скважина</td>
                      <td>{{ well.uwi }}</td>
                    </tr>
                    <tr>
                      <td>2</td>
                      <td>Месторождение</td>
                      <td>Каламкас</td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </template>
      <div v-else class="right-column__inner bg-dark"></div>
    </div>
    <div class="b-popup">
      <div class="b-container bg-dark">
        <div class="row">
          <div class="col">
            <div class="b-title-block">
              <svg width="35" height="36" viewBox="0 0 35 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M17.9676 27.2673L21.6393 32.3344C21.827 32.6303 22.057 32.8869 22.2575 33.1805C22.3944 33.3803 22.807 33.8905 22.8595 34.0711L13.07 34.0704L13.9561 32.7783C14.0436 32.6448 14.1727 32.5086 14.2739 32.365C14.6153 31.882 17.7799 27.4311 17.9676 27.2673ZM6.59072 27.2437L6.59443 27.5888L6.58299 28.7147C6.58534 28.8701 6.62571 28.9979 6.54129 29.1022L5.34841 29.1045L5.05651 29.1059L4.81537 29.1048L4.79217 21.6423L6.59139 21.6358L6.59072 27.2437ZM7.57913 26.9989L7.57274 26.7665L7.57341 21.3393C7.55693 20.4726 6.98924 20.8173 6.18581 20.7201V18.2311C6.48613 18.0468 7.04945 17.8107 7.41703 17.6493L11.1988 15.9019C11.7063 15.6557 16.0819 13.6123 16.2793 13.6073L11.0585 34.0667L10.3782 34.0663L9.7567 30.1868C9.74795 30.0031 9.70053 29.7785 9.65815 29.5824C9.60905 29.3534 9.58922 29.278 9.39013 29.1798C9.28587 29.0463 8.8174 29.1082 8.60183 29.1035L7.57172 29.1022L7.58484 28.1639L7.57913 26.9989ZM28.2148 8.42246C28.2228 8.54723 28.1784 8.54217 28.2888 8.50854L28.4354 8.84485C28.5346 9.05975 29.414 10.5644 29.5059 10.633L29.5734 10.7171C29.5512 10.8788 29.5388 10.791 29.6242 10.828C29.6404 10.9726 29.6037 10.8613 29.6851 11.007C29.7177 11.0658 29.7668 11.1176 29.8119 11.1916C29.9027 11.3409 29.899 11.395 30.0382 11.5413C30.0782 11.696 31.0081 13.2531 31.1329 13.4156L31.8354 13.4441L31.8351 34.0707L24.8739 34.069L19.6225 13.463C20.2951 13.0685 20.8706 12.4255 20.997 11.3681L26.2652 8.96154C26.8601 8.68644 27.4268 8.41339 28.008 8.15746L28.2148 8.42246ZM18.8272 26.065L20.1142 24.2429C20.2581 24.0458 20.4152 23.8504 20.5531 23.6607L22.4586 31.0867C22.1606 30.7665 21.8179 30.2476 21.5415 29.8585C21.3975 29.656 21.258 29.4654 21.1016 29.2545L18.8272 26.065ZM13.4971 31.084L15.3642 23.6739C15.5233 23.7754 15.6225 23.9718 15.7325 24.1222L17.0656 25.9799C17.1598 26.1706 16.3943 27.0655 16.1828 27.3628L15.2069 28.7369C14.6852 29.4697 13.9682 30.362 13.4971 31.084ZM17.9676 13.923C18.1088 13.9832 18.0184 13.9113 18.095 14.033C18.1192 14.0707 18.1458 14.1793 18.1583 14.2304L19.977 21.3756C20.1472 22.0061 20.2111 21.7822 19.5983 22.6199C19.337 22.9771 19.0542 23.3712 18.7922 23.7492C18.6678 23.9288 18.059 24.7857 17.9676 24.8529L15.9524 22.1107C15.755 21.8333 15.8492 21.7889 15.9407 21.4156C16.0661 20.903 16.1902 20.4137 16.3298 19.9052L17.6736 14.6347C17.7813 14.2076 17.7624 14.0075 17.9676 13.923ZM17.6232 9.95869C19.3747 9.50401 20.1075 11.9876 18.3012 12.3939C17.0569 12.674 16.125 11.4233 16.8154 10.4931C17.0296 10.2045 17.148 10.0825 17.6232 9.95869ZM26.5376 5.65501L24.8292 6.45406C24.2598 6.71638 23.6753 6.9723 23.105 7.25177C22.5077 7.54402 21.9659 7.76903 21.379 8.04681C19.0602 9.14384 19.9619 8.87177 18.9284 8.55396C18.1374 8.31081 17.1564 8.40464 16.469 8.76852C16.2941 8.86101 15.9938 9.07691 15.8953 9.1556C15.3061 9.62643 15.0427 10.3004 14.9271 11.0376C14.5699 11.1472 12.7538 12.0391 12.1966 12.2822C11.5421 12.5681 4.26484 15.9772 3.98638 16.0451C4.07113 16.3162 4.35599 16.7793 4.4969 17.0244C5.23912 18.3169 5.20279 18.0024 5.20279 19.279C5.20279 19.7465 5.18296 20.2513 5.20818 20.714C4.84665 20.7779 4.28704 20.6454 4.00858 20.8351C3.7234 21.0298 3.81049 21.4623 3.81049 21.8427L3.80747 29.1072C1.41097 29.1072 1.8115 28.6946 1.43047 31.7116C1.34034 32.4265 1.22196 33.1425 1.13318 33.8568C1.06995 34.367 0.821086 35.573 0.862115 36.0004L34.4354 35.9984L34.4405 34.0956L32.8104 34.0701L32.8097 13.4859L33.48 13.502C33.6814 11.7808 33.7638 10.3764 33.2943 8.69049C32.7428 6.71033 32.1489 5.66676 31.1009 4.09218C30.9109 3.80666 30.7065 3.59043 30.5127 3.32206C30.3227 3.05874 30.0944 2.81559 29.8835 2.58489C29.6491 2.32829 29.4275 2.07706 29.183 1.86351C28.5164 1.28136 26.9052 0.0172016 25.3353 0.0555403L24.623 1.49255C24.3631 2.01685 24.2672 1.84367 24.9318 2.90841L26.5376 5.65501Z"
                      fill="#82BAFF"/>
              </svg>
              <h6>Скважины</h6>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <p>
              Поиск скважины по номеру
            </p>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <form class="search-form">
              <input type="text" placeholder="Номер скважины" class="search-input">
              <div class="flex">
                <input type="date" class="b-date" id="date" name="trip-start" value="2021-04-07" required>
                <input type="time" class="b-time" id="time" required>
              </div>
              <div class="b-button-container">
                <button id="ok" class="accept">Применить</button>
                <button id="undo" class="cancel">Отмена</button>
              </div>
            </form>
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
      well: {
        uwi: "test"
      },
      graph: {test: "test"},
      activeFormCode: null,
      loading: false,
      isLeftColumnFolded: false
    }
  },
  mounted() {

  },
  methods: {
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
        this.well = data.well
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
  width: 404px;
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
    margin-top: 50px;
    margin-bottom: 20px;
  }

  .b-title-block {
    padding-top: 10px;
    padding-left: 40px;
    display: flex;

    button {
      margin-top: 30px;
      height: 40px;
      font-size: 14px;
      FLEX-DIRECTION: row-reverse;
      BACKGROUND: #4F5979;
      WIDTH: 65%;
      BORDER-RADIUS: 10PX;
      color: white;
      margin-right: 7px;
    }

  }

  .search-form {

    .search-input {
      width: 100%;
      margin-bottom: 20px;
      BACKGROUND: url(/img/bd/search.svg) 1% no-repeat #4F5979;
    }

    .b-date {
      height: 40px;
      font-size: 14px;
      FLEX-DIRECTION: row-reverse;
      BACKGROUND: #4F5979;
      WIDTH: 65%;
      BORDER-RADIUS: 10PX;
      color: white;
      margin-right: 7px;
    }

    .b-time {
      height: 40px;
      font-size: 14px;
      FLEX-DIRECTION: row-reverse;
      BACKGROUND: #4F5979;
      BORDER-RADIUS: 10PX;
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
      FLEX-DIRECTION: row-reverse;
      BACKGROUND: #4F5979;
      WIDTH: 130px;
      BORDER-RADIUS: 10PX;
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
  display: none;
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
  .select-button {
    background: #272953;
    width: 230px !important;
    margin-top: 14px;
    margin-left: 10px;

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
  width: 100%;
  padding: 5px 10px;

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
    border: 0;;
  }
}

.transparent-select {
  padding: 10px 0;
  color: white;
  background: none;
  border: none;

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
  height: calc(100vh - 490px);
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
  margin-left: auto;
  margin-top: auto;
  margin-bottom: auto;
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

.left-column {
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

    & + .mid-col {
      min-width: calc(100% - #{$leftColumnFoldedWidth} - #{$rightColumnWidth} - 11px);
    }

  }

  &__inner {
    height: 100%;
  }
}

.right-column {
  min-width: $rightColumnWidth;
  padding-left: 15px;

  &__inner {
    height: 100%;
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
  min-width: calc(100% - #{$leftColumnWidth} - #{$rightColumnWidth} - 11px);
  padding: 0 15px;

  &__main {
    height: calc(100% - 150px);

    &-inner {
      margin-bottom: 0;
    }
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
</style>