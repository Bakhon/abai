<template>
    <div class="main-block">
        <div class="d-flex">
            <div class="col-12 d-flex header justify-content-between">
                <div>Исторические сведения по добыче нефти</div>
                <div class="cancel-icon" @click.stop="$emit('changeHistoricalVisible')"></div>
            </div>
            <div class="col-12">
                <table class="historical-table">
                    <thead>
                        <tr>
                            <th rowspan="2">Год</th>
                            <th colspan="2">Добыча за период</th>
                            <th colspan="3">Ср. сут. показатели за период</th>
                            <th rowspan="2">Отработанное время</th>
                        </tr>
                        <tr>
                            <th>Жидкость<br>(м3)</th>
                            <th>Нефть<br>(т)</th>
                            <th>Дебит<br>жидкости<br>(м3/сут.)</th>
                            <th>Обводненность<br>(%)</th>
                            <th>Дебит<br>нефти<br>(т/сут.)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import moment from "moment";
export default {
    props: {
        mainWell: {},
    },
    data() {
        return {
            wells: []
        };
    },
    methods: {

    },
    mounted() {
        this.wells.push(this.mainWell);
    }
}
</script>
<style scoped lang="scss">
.main-block {
    height: 100%;
    margin-left: 15px;
    min-width: 340px;
    max-width: 340px;
    color: white;
    font-size: 16px;
}
.header {
    background: #293688;
}
.cancel-icon {
    background: url(/img/bd/cancel-icon.svg) no-repeat;
    margin-left: 20px;
    margin-top: 7px;
}
.historical-table {
    th {
        background: #37408B;
        border: 1px solid #A1A4DE;
    }
    tbody {
        overflow-y: auto;
    }
}

</style>