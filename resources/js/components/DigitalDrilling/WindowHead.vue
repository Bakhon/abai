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
                <button @click="closeSearchModal">{{ trans('digital_drilling.window_head.search') }}</button>
                <label for="inputSearch">{{ trans('digital_drilling.window_head.enter_text') }} |</label>
                <input type="text" name="search" id="inputSearch" v-model="searchItem" >
                <i class="fas fa-search" @click="searchBy"></i>
            </div>
            <div class="searchBlockItems">
                <table class="table defaultTable">
                    <thead>
                    <tr>
                        <th>№</th>
                        <th >
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
                    <tr v-for="(well, index) in wells">
                        <td>{{ index+1 }}</td>
                        <td @click="getWellID(well)" class="well">{{ well.Скважина }}</td>
                        <td>{{well.Месторождение}}</td>
                        <td>{{well.ДЗО}}</td>
                    </tr>
                    </tbody>
                </table>
                <p v-if="resultNot" class="not__result">{{trans(resultNot)}}</p>
            </div>
        </div>
    </div>
</template>

<script>
    import {digitalDrillingActions, digitalDrillingState} from '@store/helpers';
    export default {
        name: "WindowHead",
        data(){
            return{
                search: false,
                searchItem: null,
                resultNot: null,
                wells: [],
            }
        },
        computed:{
            ...digitalDrillingState([
                'currentWell'
            ]),
        },
        mounted(){
            if (this.isCurrentWell()){
                this.searchItem = this.currentWell.Месторождение + ' ' + this.currentWell.Скважина + ' ' + this.currentWell.ДЗО
            }
            this.searchBy()
        },
        methods:{
            openSearchModal(){
                this.search = true
            },
            closeSearchModal(){
                this.search = false
            },
            isCurrentWell () {
                return Object.keys(this.currentWell).length != 0;
            },

            searchBy(){
                if (this.searchItem) {
                    const searchItemList = this.searchItem.split(" ");
                    this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL +'/digital_drilling/api/search/?q='+searchItemList ).then((response) => {
                        let data = response.data;
                        if (data.length>0) {
                            this.wells = data;
                            this.resultNot = null
                        } else {
                            this.wells = []
                            this.resultNot = 'digital_drilling.request.result_not'
                        }
                    });
                }else{
                    this.wells = []
                    this.resultNot = 'digital_drilling.request.result_not'
                }
            },
            getWellID(well){
                this.search = false
                this.changeCurrentWellValue(well)
                this.$emit('getWellID', well.id)
            },
            ...digitalDrillingActions([
                'changeCurrentWellValue'
            ]),

        }
    }
</script>

<style scoped>
.not__result{
    color: #ffffff;
}
</style>