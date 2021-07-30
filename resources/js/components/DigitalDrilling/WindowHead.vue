<template>
    <div class="windowHead">
        <p class="headTitle">ДЗО, Месторождение, № скважины</p>
        <div class="controlBlock">
            <button @click="openSearchModal"><i class="fas fa-search"></i></button>
            <a href=""><img src="/img/digital-drilling/button1.svg" alt=""></a>
            <a href=""><img src="/img/digital-drilling/button2.svg" alt=""></a>
        </div>
        <div class="search" v-bind:class="{active: search}">
            <div class="searchBlock">
                <button>Поиск</button>
                <label for="inputSearch">Введите текст |</label>
                <input type="text" name="search" id="inputSearch">
                <i class="fas fa-search" @click="closeSearchModal"></i>
            </div>
            <div class="searchBlockItems">
                <table class="table defaultTable">
                    <thead>
                    <tr>
                        <th>
                            Номер скважины
                        </th>
                        <th>
                            Месторождение
                        </th>
                        <th>
                            ДЗО
                        </th>
                    </tr>
                    </thead>
                    <tbody>

                    <tr v-for="(n, i) in 10">
                        <td v-for="(n, i) in 3"></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "WindowHead",
        data(){
            return{
                search: false,
            }
        },
        methods:{
            openSearchModal(){
                this.search = true
            },
            closeSearchModal(){
                this.search = false
            }
        }
    }
</script>

<style scoped>

</style>