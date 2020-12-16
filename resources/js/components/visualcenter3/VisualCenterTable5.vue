<template>
    <div class="d-flex flex-column flex-sm-row justify-content-between w-sm-100">
        <div class="flex-grow-1">
            <horizontal-indicators></horizontal-indicators>
            <div class="d-flex flex-column first-string flex-sm-row mr-sm-2">
                <div class="w-25 m-3">
                    <h5>
                        <strong>
                            Оперативные итоги<br />
                            по финансовым показателям
                        </strong>
                    </h5>
                </div>
                <div class="w-50">
                    <select class="w-100 h-50 mt-3 mb-3" :style="{background: '#2A2E5C', color: 'white'}">
                        <option :value="0" :selected="'selected'">Выбор ДЗО</option>
                    </select>
                </div>
                <div class="w-25 align-right">
                    <div class="w-25 float-right m-3">
                        <div class=" align-right close2 d-none d-sm-block">Закрыть</div>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-column first-string flex-sm-row justify-content-between mr-sm-2">
                <div class="w-25 ml-3">
                    <select class="w-100 mt-3 mb-3 p-2" :style="{background: '#2A2E5C', color: 'white'}">
                        <option :value="0" :selected="'selected'">С начала года</option>
                    </select>
                </div>
                <div class="w-25 ml-3">
                    <select class="w-100 mt-3 mb-3 p-2" :style="{background: '#2A2E5C', color: 'white'}">
                        <option :value="0" :selected="'selected'">За месяц</option>
                    </select>
                </div>
                <div class="w-25 ml-3">
                    <select class="w-100 mt-3 mb-3 p-2" :style="{background: '#2A2E5C', color: 'white'}">
                        <option :value="0" :selected="'selected'">Квартал</option>
                    </select>
                </div>
                <div class="w-25 ml-3 mr-3">
                    <select class="w-100 mt-3 mb-3 p-2" :style="{background: '#2A2E5C', color: 'white'}">
                        <option :value="0" :selected="'selected'">Актуализированный месяц</option>
                    </select>
                </div>
            </div>
            <div class="first-string mr-2">
                <h5 class="text-center mr-2"><strong>Макропоказатели</strong></h5>
                <table class="ml-3 mr-3 w-100">
                    <thead>
                    <tr class="economics-table-color m-1">
                        <th>
                            Наименование
                        </th>
                        <th>
                            Наименование
                        </th>
                        <th>
                            Наименование
                        </th>
                        <th>
                            Наименование
                        </th>
                        <th>
                            Наименование
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>adfgadf</td>
                        <td>adfgadf</td>
                        <td>adfgadf</td>
                        <td>adfgadf</td>
                        <td>adfgadf</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="flex-grow-1">
            <vertical-indicators></vertical-indicators>
        </div>
    </div>
</template>
<script src="./VisualCenterTable5.js"></script>