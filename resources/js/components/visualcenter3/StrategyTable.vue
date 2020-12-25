<template>
    <div>
        <div class="d-flex">
            <div class="col-10">
                <h4 class="text-left pl-3 pt-4"><strong>Чистый денежный поток</strong></h4>
            </div>
            <div class="col-2 pr-3 pt-4">
                <div class="float-right">
                    <div class="close2 d-none d-sm-block cursor-pointer"
                         @click="isShowMainBlock = true; isShowInteractiveBlock = false;">
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
                        <th scope="col">Вес влияния на<br />исполнение цели</th>
                    </tr>
                    </thead>
                    <tbody class="text-left">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: {
            tableToShowId: 0
        }
    }
</script>