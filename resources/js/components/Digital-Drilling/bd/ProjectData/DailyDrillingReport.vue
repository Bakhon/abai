<template>
    <div class="DailyDrillingReport">
        <table class="table defaultTable">
            <tbody>
                <tr>
                    <th>№ суточного рапорта</th>
                    <th>Дата</th>
                    <th class="raport">Суточный рапорт</th>
                    <th></th>
                </tr>
                <tr v-for="i in 10">
                    <td v-for="i in 3"></td>
                    <td>
                        <button class="download">
                            Скачать
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        name: "DailyDrillingReport"
    }
</script>

<style scoped>
.DailyDrillingReport{
    width: 100%;
    height: 100%;
    background: #272953;
}
    .DailyDrillingReport .raport{
        min-width: 700px;
    }
    .DailyDrillingReport .download{
        background: #205AA3;
        border: 1px solid #454FA1;
        box-shadow: 0px 4px 3px rgba(0, 0, 0, 0.25);
        border-radius: 4px;
        width: 160px;
        height: 25px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
    }

</style>