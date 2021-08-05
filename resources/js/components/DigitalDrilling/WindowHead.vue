<template>
    <div class="windowHead">
        <p class="headTitle">{{ trans('digital_drilling.window_head.headTitle') }}</p>
        <div class="controlBlock">
            <button @click="openSearchModal"><i class="fas fa-search"></i></button>
            <a href=""><img src="/img/digital-drilling/button1.svg" alt=""></a>
            <a href=""><img src="/img/digital-drilling/button2.svg" alt=""></a>
        </div>
        <div class="search" v-bind:class="{active: search}">
            <div class="searchBlock">
                <button>{{ trans('digital_drilling.window_head.search') }}</button>
                <label for="inputSearch">{{ trans('digital_drilling.window_head.enter_text') }} |</label>
                <input type="text" name="search" id="inputSearch">
                <i class="fas fa-search" @click="closeSearchModal"></i>
            </div>
            <div class="searchBlockItems">
                <table class="table defaultTable">
                    <thead>
                    <tr>
                        <th>
                            {{ trans('digital_drilling.window_head.well_number') }}
                        </th>
                        <th>
                            {{ trans('digital_drilling.window_head.field') }}
                        </th>
                        <th>
                            {{ trans('digital_drilling.window_head.DZO') }}
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