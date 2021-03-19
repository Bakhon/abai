<template>
    <div>
        <div class="d-flex">
            <div class="col-10">
                <h4 class="text-left pl-3 pt-4"><strong>{{ tableTitle }}</strong></h4>
            </div>
            <div class="col-2 pr-3 pt-4">
                <div class="float-right">
                    <div class="close2 d-none d-sm-block cursor-pointer"
                         @click="$emit('closeTable')">
                        Закрыть
                    </div>
                </div>
            </div>
        </div>
        <div class="ml-0 ml-sm-3 mr-0 mr-sm-3 pb-3">
            <div class="w-100">
                <table class="table pl-2 table-striped table-borderless economics-table-border">
                    <thead class="economics-table-color text-center">
                    <tr>
                        <th class="text-left" scope="col">Наименование</th>
                        <th scope="col">Порог</th>
                        <th scope="col">Цель</th>
                        <th scope="col">Вызов</th>
                        <th scope="col">Факт</th>
                        <th scope="col">Абс. откл.<br />за&nbsp;отч.&nbsp;период, +/-</th>
                        <th scope="col">Отн. откл.<br />за&nbsp;отч.&nbsp;период, %</th>
                        <th scope="col">Вес влияния на<br />исполнение цели, %</th>
                    </tr>
                    </thead>
                    <tbody class="text-center">
                    <tr v-for="item in tableData['data']">
                        <td class="text-left">{{item[4]}}</td>
                        <td>
                            <div class="mt-2 d-flex d-flex-row align-items-center justify-content-center">
                                {{item[0]}}
                            </div>
                        </td>
                        <td>
                            <div class="mt-2 d-flex d-flex-row align-items-center justify-content-center">
                                {{item[1]}}
                            </div>
                        </td>
                        <td>
                            <div class="mt-2 d-flex d-flex-row align-items-center justify-content-center">
                                {{item[2]}}
                            </div>
                        </td>
                        <td>
                            <div class="mt-2 d-flex d-flex-row align-items-center justify-content-center">
                                {{item[3]}}
                            </div>
                        </td>
                        <td>
                            <div class="mt-2 d-flex d-flex-row align-items-center justify-content-center">
                                <div v-if="item[6] < 0 && item[0] < item[2]" class="arrow2"></div>
                                <div v-else class="arrow3"></div>
                                {{Math.abs(item[6])}}
                            </div>
                        </td>
                        <td>
                            <div class="mt-2 d-flex d-flex-row align-items-center justify-content-center">
                                <div v-if="item[7] < 0 && item[0] < item[2]" class="arrow2"></div>
                                <div v-else class="arrow3"></div>
                                {{Math.abs(item[7])}}
                            </div>
                        </td>
                        <td>
                            <div class="mt-2 d-flex d-flex-row align-items-center justify-content-center">
                                <div v-if="item[8] < 0 && item[0] < item[2]" class="arrow2"></div>
                                <div v-else class="arrow3"></div>
                                {{Math.abs(item[8])}}
                            </div>
                        </td>
                    </tr>
                    <tr style="background-color: #293688;">
                        <td>Итого:</td>
                        <td>
                            <div class="mt-2 d-flex d-flex-row align-items-center justify-content-center">
                                {{tableData['sum'][0]}}
                            </div>
                        </td>
                        <td>
                            <div class="mt-2 d-flex d-flex-row align-items-center justify-content-center">
                                {{tableData['sum'][1]}}
                            </div>
                        </td>
                        <td>
                            <div class="mt-2 d-flex d-flex-row align-items-center justify-content-center">
                                {{tableData['sum'][2]}}
                            </div>
                        </td>
                        <td>
                            <div class="mt-2 d-flex d-flex-row align-items-center justify-content-center">
                                {{tableData['sum'][3]}}
                            </div>
                        </td>
                        <td>
                            <div class="mt-2 d-flex d-flex-row align-items-center justify-content-center">
                                <div v-if="tableData['sum'][4] < 0 && tableData['sum'][0] < tableData['sum'][2]" class="arrow2"></div>
                                <div v-else class="arrow3"></div>
                                {{Math.abs(tableData['sum'][4])}}
                            </div>
                        </td>
                        <td>
                            <div class="mt-2 d-flex d-flex-row align-items-center justify-content-center">
                                <div v-if="tableData['sum'][5] < 0 && tableData['sum'][0] < tableData['sum'][2]" class="arrow2"></div>
                                <div v-else class="arrow3"></div>
                                {{Math.abs(tableData['sum'][5])}}
                            </div>
                        </td>
                        <td>
                            <div class="mt-2 d-flex d-flex-row align-items-center justify-content-center">
                                <div v-if="tableData['sum'][6] < 0 && tableData['sum'][0] < tableData['sum'][2]" class="arrow2"></div>
                                <div v-else class="arrow3"></div>
                                {{Math.abs(tableData['sum'][6])}}
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        tableData: Object,
        tableTitle: "",
    }
}
</script>