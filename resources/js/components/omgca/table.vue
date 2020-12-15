<template>
    <div class="table-page">
        <div class="float-right table-page__links">
            <a class="table-page__links-item table-page__links-item_add" :href="params.links.create">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M16 9.6H9.6V16H6.4V9.6H0V6.4H6.4V0H9.6V6.4H16V9.6Z"
                          fill="white"/>
                </svg>
            </a>
            <a class="table-page__links-item table-page__links-item_excel" @click.prevent="exportExcel" href="#">
                <svg width="16" height="20" viewBox="0 0 16 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M14.7071 5.70711L10.293 1.2929C10.1055 1.10536 9.8511 1 9.58588 1L2.00028 1.00002C1.448 1.00002 1.00029 1.44774 1.00029 2.00002L1.00029 18C1.00029 18.5523 1.448 19 2.00029 19L14 19C14.5523 19 15 18.5523 15 18L15 6.41421C15 6.14899 14.8946 5.89464 14.7071 5.70711Z"
                        stroke="white" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M9.11719 1V6.02353C9.11719 6.57581 9.5649 7.02353 10.1172 7.02353H14.9994" stroke="white"
                          stroke-width="1.4" stroke-linejoin="round"/>
                    <path
                        d="M4.37372 13.1938C4.66705 13.1938 4.90572 13.2885 5.08972 13.4778C5.27372 13.6645 5.36572 13.9085 5.36572 14.2098C5.36572 14.2685 5.36305 14.3218 5.35772 14.3698H4.01372C4.01372 14.4792 4.05105 14.5725 4.12572 14.6498C4.20039 14.7245 4.29239 14.7618 4.40172 14.7618C4.55105 14.7618 4.65639 14.7018 4.71772 14.5818H5.34172C5.27505 14.7818 5.16305 14.9418 5.00572 15.0618C4.84839 15.1818 4.64305 15.2418 4.38972 15.2418C4.10439 15.2418 3.86172 15.1472 3.66172 14.9578C3.46439 14.7685 3.36572 14.5192 3.36572 14.2098C3.36572 13.9165 3.45372 13.6738 3.62972 13.4818C3.80839 13.2898 4.05639 13.1938 4.37372 13.1938ZM4.36572 13.6298C4.26705 13.6298 4.18705 13.6605 4.12572 13.7218C4.06439 13.7805 4.02839 13.8538 4.01772 13.9418H4.71372C4.70305 13.8512 4.66572 13.7765 4.60172 13.7178C4.54039 13.6592 4.46172 13.6298 4.36572 13.6298ZM5.42922 15.1738L6.11722 14.2178L5.46522 13.2578H6.20922L6.39722 13.5978C6.42922 13.6565 6.45855 13.7258 6.48522 13.8058H6.50122C6.53855 13.6938 6.56255 13.6272 6.57322 13.6058L6.74522 13.2578H7.48522L6.83722 14.2058L7.50522 15.1738H6.73322L6.54922 14.8338C6.50389 14.7458 6.47855 14.6738 6.47322 14.6178H6.45722C6.44122 14.6765 6.41189 14.7498 6.36922 14.8378L6.18522 15.1738H5.42922ZM8.5735 13.1938C8.8295 13.1938 9.04017 13.2725 9.2055 13.4298C9.37083 13.5845 9.4695 13.7672 9.5015 13.9778H8.8495C8.83617 13.9112 8.80283 13.8578 8.7495 13.8178C8.69883 13.7778 8.6375 13.7578 8.5655 13.7578C8.44817 13.7578 8.3615 13.8005 8.3055 13.8858C8.25217 13.9712 8.2255 14.0805 8.2255 14.2138C8.2255 14.3472 8.25483 14.4578 8.3135 14.5458C8.37217 14.6312 8.46017 14.6738 8.5775 14.6738C8.65217 14.6738 8.71483 14.6525 8.7655 14.6098C8.81883 14.5645 8.85483 14.5072 8.8735 14.4378H9.5375C9.47883 14.6805 9.36683 14.8752 9.2015 15.0218C9.03883 15.1685 8.82683 15.2418 8.5655 15.2418C8.28017 15.2418 8.0375 15.1472 7.8375 14.9578C7.64017 14.7685 7.5415 14.5192 7.5415 14.2098C7.5415 13.9218 7.63483 13.6805 7.8215 13.4858C8.00817 13.2912 8.25883 13.1938 8.5735 13.1938ZM10.7604 13.1938C11.0538 13.1938 11.2924 13.2885 11.4764 13.4778C11.6604 13.6645 11.7524 13.9085 11.7524 14.2098C11.7524 14.2685 11.7498 14.3218 11.7444 14.3698H10.4004C10.4004 14.4792 10.4378 14.5725 10.5124 14.6498C10.5871 14.7245 10.6791 14.7618 10.7884 14.7618C10.9378 14.7618 11.0431 14.7018 11.1044 14.5818H11.7284C11.6618 14.7818 11.5498 14.9418 11.3924 15.0618C11.2351 15.1818 11.0298 15.2418 10.7764 15.2418C10.4911 15.2418 10.2484 15.1472 10.0484 14.9578C9.8511 14.7685 9.75244 14.5192 9.75244 14.2098C9.75244 13.9165 9.84044 13.6738 10.0164 13.4818C10.1951 13.2898 10.4431 13.1938 10.7604 13.1938ZM10.7524 13.6298C10.6538 13.6298 10.5738 13.6605 10.5124 13.7218C10.4511 13.7805 10.4151 13.8538 10.4044 13.9418H11.1004C11.0898 13.8512 11.0524 13.7765 10.9884 13.7178C10.9271 13.6592 10.8484 13.6298 10.7524 13.6298ZM12.107 15.1738V12.2938H12.783V15.1738H12.107Z"
                        fill="white"/>
                </svg>
                <span>Выгрузить в Excel</span>
            </a>
            <a class="table-page__links-item table-page__links-item_add" @click.prevent="resetFilters" href="#"
               v-if="activeFilters">
                Сбросить фильтр
            </a>
        </div>
        <h1 style="color:#fff">{{ params.title }}</h1>

        <div class="alert alert-success" v-if="params.success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <p>{{ params.success }}</p>
        </div>
        <div class="table-page__wrapper">
            <div class="loader" v-if="loading"></div>
            <table class="table">
                <thead>
                <tr v-if="params.table_header">
                    <th v-for="(colspan, header) in params.table_header" :colspan="colspan">{{ header }}</th>
                    <th rowspan="2">Управление</th>
                </tr>
                <tr>
                    <th v-for="(field, code) in params.fields">{{ field.title }}</th>
                    <th v-if="!params.table_header">Управление</th>
                </tr>
                <tr v-if="omgca && omgca.data" class="table-sort">
                    <th v-for="(field, code) in params.fields" class="sort">
                        <i @click="filters[code].show = !filters[code].show" class="fa fa-filter"
                           aria-hidden="true"></i>
                        <div v-if="filters[code].show">
                            <template v-if="params.fields[code].type === 'select'">
                                <select v-model="filters[code].value" @change="loadData()">
                                    <option></option>
                                    <option v-for="(value, id) in params.fields[code].filter.values" :value="id">
                                        {{ value }}
                                    </option>
                                </select>
                            </template>
                            <template v-else-if="params.fields[code].type === 'date'">
                                <input type="text" v-model="filters[code].value['from']" placeholder="С">
                                <input type="text" v-model="filters[code].value['to']" placeholder="По">
                                <button @click="loadData()">V</button>
                            </template>
                            <template v-else>
                                <input type="text" v-model="filters[code].value" @keyup.enter="loadData">
                                <button @click="loadData()">V</button>
                            </template>
                        </div>
                        <span
                            class="arrows"
                            :class="{
                            'asc': sort.by === code && sort.desc === false,
                            'desc': sort.by === code && sort.desc === true,
                        }"
                            @click="sortBy(code)">
                        </span>
                    </th>
                    <th></th>
                </tr>
                </thead>
                <tbody v-if="omgca && omgca.data">
                <tr v-for="row in omgca.data">
                    <td v-for="(field, code) in params.fields">
                        {{ row.fields[code] }}
                    </td>
                    <td class="row__links">
                        <div class="links">
                            <a class="links__item links__item_edit" :href="row.links.edit"></a>
                            <a class="links__item links__item_view" :href="row.links.show"></a>
                            <a class="links__item links__item_history" :href="row.links.history"></a>
                            <a class="links__item links__item_delete" @click="deleteItem(row)"></a>
                        </div>
                    </td>
                </tr>
                </tbody>
                <tbody v-else>
                <tr>
                    <td colspan="5" class="text-center">Loading</td>
                </tr>
                </tbody>
            </table>
            <pagination :limit="3" v-if="omgca" :data="omgca" @pagination-change-page="changePage"></pagination>
        </div>
    </div>
</template>

<script>
export default {
    name: "omgca-table",
    props: [
        'params'
    ],
    data: function () {
        return {
            omgca: null,
            sort: {
                by: null,
                desc: false
            },
            loading: false,
            currentPage: 1,
            filters: {}
        }
    },
    mounted() {
        this.initFilters()
        this.loadData()
    },
    computed: {
        activeFilters() {
            let activeFilter = false
            Object.entries(this.filters).forEach(([code, filter]) => {
                if (!filter.value) return
                if (typeof filter.value == 'object' && !filter.value.from && !filter.value.to) return

                activeFilter = true

            })
            return activeFilter
        }
    },
    methods: {
        prepareQueryParams() {
            let queryParams = {
                page: this.currentPage
            }
            if (this.sort.by) {
                queryParams.order_by = this.sort.by
                queryParams.order_desc = Number(!!this.sort.desc)
            }

            if (this.filters) {
                Object.entries(this.filters).forEach(([code, filter]) => {
                    if (!filter.value) return
                    if (typeof filter.value == 'object' && !filter.value.from && !filter.value.to) return

                    queryParams['filter[' + code + ']'] = filter.value

                })
            }
            return queryParams
        },
        changePage(page = 1) {
            this.currentPage = page
            this.loadData()
        },
        loadData() {
            this.loading = true

            this.axios.get(this.params.links.list, {params: this.prepareQueryParams()}).then(response => {
                this.omgca = response.data
            }).catch(e => {

            }).finally(() => {
                this.loading = false
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        },
        sortBy(field) {
            if (this.sort.by === field) {
                this.sort.desc = !this.sort.desc
            } else {
                this.sort.by = field
                this.sort.desc = false
            }
            this.loadData()
        },
        deleteItem(item) {
            this.axios.delete(item.links.delete).then(response => {
                this.loadData()
                this.params.success = 'Удалено'
            })
        },
        exportExcel() {

            let queryParams = this.prepareQueryParams();
            let esc = encodeURIComponent;
            let query = Object.keys(queryParams)
                .map(k => esc(k) + '=' + esc(queryParams[k]))
                .join('&');

            document.location.href = this.params.links.export + '?' + query
        },
        resetFilters() {
            this.initFilters()
            this.loadData()
        },
        initFilters() {
            if (this.params) {
                Object.entries(this.params.fields).forEach(([code, field]) => {
                    let filter = {
                        show: false,
                        value: field.type === 'date' ? {from: null, to: null} : null
                    }
                    Vue.set(this.filters, code, filter)
                })
            }
        }
    },
};
</script>
<style lang="scss">
.table-page {
    background: #272953;
    padding: 16px 24px 20px 19px;

    &__wrapper {
        overflow-x: auto;
        position: relative;
    }

    h1 {
        font-weight: bold;
        font-size: 22px;
        line-height: 26px;
        margin-bottom: 19px;
    }

    &__links {
        display: flex;

        &-item {
            align-items: center;
            background: #656A8A;
            border-radius: 6px;
            color: #fff;
            display: flex;
            font-weight: bold;
            justify-content: center;
            height: 30px;
            margin-left: 8px;
            padding: 0 7px;

            &:hover {
                color: #fff;
                text-decoration: none;
            }

            &_excel {
                padding: 0 17px 0 20px;

                span {
                    margin-left: 9px;
                }
            }
        }
    }

    .loader {
        background: rgba(255, 255, 255, 0.2);
        bottom: 0;
        left: 0;
        position: absolute;
        top: 0;
        right: 0;
        z-index: 100;
    }

    .alert {
        p {
            margin: 0;
        }
    }

    .table {
        border: 1px solid #454D7D;
        color: white !important;
        margin-bottom: 28px;

        th {
            background: #333975;
            border: 1px solid #454D7D;
            font-weight: bold;
            font-size: 12px;
            padding: 10px 0;
            text-align: center;

            &.sort {
                font-weight: normal;
                padding: 10px 5px;
                position: relative;

                .arrows {
                    display: block;
                    height: 16px;
                    position: absolute;
                    right: 2px;
                    top: 50%;
                    transform: translateY(-50%);
                    width: 15px;

                    &:before {
                        background: url(/img/icons/table_sort_up.svg);
                        background-size: cover;
                        content: "";
                        height: 4px;
                        position: absolute;
                        top: 0;
                        right: 0;
                        width: 6px;
                    }

                    &:after {
                        background: url(/img/icons/table_sort_down.svg);
                        background-size: cover;
                        content: "";
                        height: 4px;
                        position: absolute;
                        bottom: 0;
                        right: 0;
                        width: 7px;
                    }

                    &.asc {
                        &:before {
                            display: none;
                        }
                    }

                    &.desc {
                        &:after {
                            display: none;
                        }
                    }
                }
            }

        }

        tbody {
            tr {
                td {
                    background: #303560;
                    border: none;
                    border-left: 1px solid #454D7D;
                    border-right: 1px solid #454D7D;
                    font-size: 14px;
                    padding: 7px 5px;
                    text-align: center;
                    vertical-align: middle;

                    &.row__links {
                        padding-left: 20px;
                        padding-right: 20px;
                        width: 150px;
                    }

                    .links {
                        align-items: center;
                        display: flex;
                        justify-content: space-between;
                        width: 112px;

                        &__item {
                            display: block;

                            &_edit {
                                background: url(/img/icons/edit.svg);
                                height: 14px;
                                width: 14px;
                            }

                            &_view {
                                background: url(/img/icons/view.svg);
                                height: 10px;
                                width: 21px;
                            }

                            &_history {
                                background: url(/img/icons/history.svg);
                                height: 14px;
                                width: 17px;
                            }

                            &_delete {
                                background: url(/img/icons/delete.svg);
                                height: 14px;
                                width: 15px;
                            }
                        }
                    }
                }

                &:nth-child(2n) {
                    td {
                        background: #272953;
                    }
                }
            }
        }
    }

    .pagination {
        justify-content: center;

        .page-item {
            .page-link {
                background: none;
                border-color: #40489C;
                color: #636A99;
                padding: 0.8rem 1.35rem;
            }

            &.active {
                .page-link {
                    background: #3366FF;
                    color: #fff;
                }
            }
        }
    }

}
</style>
