<template>
    <div class="table-wrapper">
        <div class="loader" v-if="loading"></div>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th colspan="1">Узел отбора</th>
                <th colspan="3">Фактические данные ОМГ ЦА</th>
                <th rowspan="3">Управление</th>
            </tr>
            <tr>
                <th>ГУ</th>
                <th>Год</th>
                <th>Планируемая дозировка</th>
                <th>Техрежим Qв</th>
            </tr>
            <tr v-if="omgca && omgca.data" class="table-sort">
                <th v-for="(field, code) in params.fields" class="sort">
                    <span
                        class="arrows"
                        :class="{
                        'asc': sort.by === code && sort.desc === false,
                        'desc': sort.by === code && sort.desc === true,
                    }"
                        @click="sortBy(code)">
                    </span>
                    {{ field.title }}
                </th>
            </tr>
            </thead>
            <tbody v-if="omgca && omgca.data">
            <tr v-for="row in omgca.data">
                <td v-for="(field, code) in params.fields">
                    {{ row.fields[code] }}
                </td>
                <td>
                    <form :action="row.links.delete" method="POST" class="mb-0">
                        <a class="btn btn-sm btn-primary" :href="row.links.edit"><i class="fas fa-edit"></i></a>
                        <a class="btn btn-sm btn-primary" :href="row.links.show"><i class="fas fa-eye"></i></a>
                        <a class="btn btn-sm btn-primary" :href="row.links.history"><i class="fas fa-history"></i></a>
                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            </tbody>
            <tbody v-else>
            <tr>
                <td colspan="5" class="text-center">Loading</td>
            </tr>
            </tbody>
        </table>
        <pagination v-if="omgca" :data="omgca" @pagination-change-page="loadData"></pagination>
    </div>
</template>

<script>
export default {
    name: "omgca-table",
    data: function () {
        return {
            omgca: null,
            params: null,
            sort: {
                by: null,
                desc: false
            },
            loading: false,
            currentPage: 1
        }
    },
    mounted() {
        this.loadData()
    },
    methods: {
        loadData(page) {

            if(page) {
                this.currentPage = page
            }

            this.loading = true

            let queryParams = {
                page: page
            }
            if (this.sort.by) {
                queryParams.order_by = this.sort.by
                queryParams.order_desc = Number(!!this.sort.desc)
            }

            this.axios.get('/ru/omgca/list', {params: queryParams}).then(response => {
                this.omgca = response.data.omgca
                this.params = response.data.params
            }).catch(e => {

            }).finally(() => {
                this.loading = false
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
        }
    },
};
</script>
<style lang="scss">
.table-wrapper {
    position: relative;

    .loader {
        background: rgba(255,255,255,0.2);
        bottom: 0;
        left: 0;
        position: absolute;
        top: 0;
        right: 0;
        z-index: 100;
    }

    .table{
        th{
            background: #333975;
            border: 1px solid #454D7D;
            font-weight: bold;
            font-size: 12px;
            padding: 10px 0;
            text-align: center;

            &.sort{
                font-weight: normal;
                padding: 10px 5px;
                position: relative;
                .arrows{
                    display: block;
                    height: 16px;
                    position: absolute;
                    right: 2px;
                    top: 50%;
                    transform: translateY(-50%);
                    width: 15px;
                    &:before{
                        background: url(/img/icons/table_sort_up.svg);
                        background-size: cover;
                        content: "";
                        height: 4px;
                        position: absolute;
                        top: 0;
                        right: 0;
                        width: 6px;
                    }
                    &:after{
                        background: url(/img/icons/table_sort_down.svg);
                        background-size: cover;
                        content: "";
                        height: 4px;
                        position: absolute;
                        bottom: 0;
                        right: 0;
                        width: 7px;
                    }
                    &.asc{
                        &:before{
                            display: none;
                        }
                    }
                    &.desc{
                        &:after{
                            display: none;
                        }
                    }
                }
            }

        }
        tbody{
            tr{
                td{
                    background: #303560;
                    border: 1px solid #454D7D;
                    font-size: 14px;
                    padding: 7px 5px;
                    text-align: center;
                    vertical-align: middle;
                }
                &:nth-child(2n){
                    td{
                        background: #272953;
                    }
                }
            }
        }
    }

}
</style>
