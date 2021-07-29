<template>
    <div class="page-wrapper">
        <div class="block-container row">
            <div class="col-12 header-title p-2">
                Таблица согласований операционных активов
            </div>
        </div>
        <div class="block-container row mt-10px">
            <div class="col-4 header-title">
                Необходимо согласовать
            </div>
            <div class="col-8 header-title">
                Список изменений
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                allProduction: [],
                actual: []
            }
        },

        methods: {
            async getForApprove() {
                let uri = this.localeUrl("/get-daily-production-for-approve");
                const response = await axios.get(uri);
                if (response.status === 200) {
                    return response.data;
                }
                return [];
            }
        },
        async mounted() {
            this.allProduction = await this.getForApprove();
            console.log(this.allProduction);
        }
    }
</script>

<style scoped>
    .page-wrapper {
        font-family: HarmoniaSansProCyr-Regular, Harmonia-sans;
        position: relative;
        min-height: calc(100vh - 78px);
        color: white;
        text-align: center;
    }
    .block-container {
        background: #272953;
        flex-wrap: wrap;
        margin: 0;
    }
    .header-title {
        font-weight: bold;
        font-size: 20px;
    }
</style>