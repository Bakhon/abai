<template>
    <div class="oldWell">
        <div class="oldWell-body">
            <div class="well_body-header">
                <div class="well_body-header-title">
                    Список скважин
                </div>
                <div class="well_body-header-close" @click="closeOldWell">
                    Закрыть
                </div>
            </div>
            <div class="oldWell-body-content defaultScroll">
                <table class="table defaultTable">
                    <tbody>
                       <tr>
                           <th>№</th>
                           <th>Скважина</th>
                           <th>Месторождение</th>
                           <th>ДЗО</th>
                           <th>Статус</th>
                       </tr>
                        <tr v-for="i in 25">
                            <td>{{i}}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="padding-0">
                                <select name="" id="" class="old-well__status">
                                    <option value="">Планируемые</option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="oldWell-body-btns">
                <button class="save">Сохранить</button>
                <button class="cancel">Отмена</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "OldWell",
        methods:{
            closeOldWell(){
                this.$emit('closeOldWell')
            },
        },
    }
</script>

<style scoped>
    td{
        padding: 3px 0 3px 10px!important;
    }
    td.padding-0{
        padding: 0!important;
    }
</style>