<template>
    <div class="graph-img" v-if="type=='type1'">
        <span v-for="(structure, i) in data" :style="structureType1[i]" class="numbers" :key="i">{{structure}} {{unit[i]}}</span>
        <img src="/img/digital-drilling/constructor-1.svg" alt="" class="structure-img">
    </div>
    <div class="graph-img" v-else-if="type=='type2'">
        <span v-for="(structure, i) in data" :style="structureType2[i]" class="numbers" :key="i">{{structure}} {{unit[i]}}</span>
        <img src="/img/digital-drilling/constructor-2.svg" alt="" class="structure-img">
    </div>
    <div class="graph-img" v-else-if="type=='type3'">
        <span v-for="(structure, i) in data" :style="structureType3[i]" class="numbers" :key="i">{{structure}} {{unit[i]}}</span>
        <img src="/img/digital-drilling/constructor-3.svg" alt="" class="structure-img">
    </div>
    <div class="graph-img" v-else-if="type=='type4'">
        <span v-for="(structure, i) in data" :style="structureType4[i]" class="numbers" :key="i">{{structure}} {{unit[i]}}</span>
        <img src="/img/digital-drilling/constructor-4.svg" alt="" class="structure-img">
    </div>
    <div class="graph-img" v-else-if="type=='type5'">
        <span v-for="(structure, i) in data" :style="structureType5[i]" class="numbers" :key="i">{{structure}} {{unit[i]}}</span>
        <img src="/img/digital-drilling/constructor-5.svg" alt="" class="structure-img">
    </div>
    <div class="graph-img" v-else-if="type=='type6'">
        <span v-for="(structure, i) in data" :style="structureType6[i]" class="numbers" :key="i">{{structure}} {{unit[i]}}</span>
        <img src="/img/digital-drilling/constructor-6.svg" alt="" class="structure-img">
    </div>
    <div class="graph-img" v-else-if="type=='type7'">
        <span v-for="(structure, i) in data" :style="structureType7[i]" class="numbers" :key="i">{{structure}} {{unit[i]}}</span>
        <img src="/img/digital-drilling/constructor-7.svg" alt="" class="structure-img">
    </div>
    <div class="graph-img" v-else-if="type=='type8'">
        <span v-for="(structure, i) in data" :style="structureType8[i]" class="numbers" :key="i">{{structure}} {{unit[i]}}</span>
        <img src="/img/digital-drilling/constructor-8.svg" alt="" class="structure-img">
    </div>
    <div class="graph-img" v-else-if="type=='type9'">
        <span v-for="(structure, i) in data" :style="structureType9[i]" class="numbers" :key="i">{{structure}} {{unit[i]}}</span>
        <img src="/img/digital-drilling/constructor-9.svg" alt="" class="structure-img">
    </div>
</template>

<script>
    export default {
        name: "StructureType",
        props: ['data', 'type', 'unit'],
        data(){
            return{
                structureType1: [
                    'top:8px;left:87px;','top:262px;right:73px;',
                    'bottom:236px;left:112px;', 'bottom:12px;right:58px;'
                ],
                structureType2: [
                    'top:0px;left:57px;', 'top:100px;right:47px;',
                    'top:170px;left:85px;', 'top:263px;right:33px;',
                    'bottom:207px;left:131px;', 'bottom:12px;right:51px;'
                ],
                structureType3: [
                    'top:2px;left:89px;', 'top:29px;right:73px;',
                    'top:71px;left:105px;',  'top:115px;right:82px;',
                    'top:208px;left:123px;', 'bottom:381px;left:508px;',
                    'bottom:261px;left:157px;',  'bottom:144px;left:513px;',
                    'bottom:130px;left:147px;', 'bottom:13px;right:97px;',
                ],
                structureType4: [
                    'top:0;left:65px;', 'top:40px;left:572px;',
                    'top:89px;left:85px;', 'top:153px;left:576px;',
                    'bottom:346px;left:107px;', 'bottom:190px;left:575px;',
                    'bottom:192px;left:157px;', 'bottom:12px;left:571px;',
                ],
                structureType5: [
                    'top:0;left:65px;', 'top:76px;left:548px;',
                    'top:151px;left:106px;', 'top:214px;left:548px;',
                    'top:342px;left:125px;', 'bottom:158px;left:548px;',
                    'bottom:92px;left:125px;', 'bottom:11px;left:548px;',
                ],
                structureType6: [
                    'top:8px;left:146px;', 'top:193px;left:480px;',
                    'bottom:351px;left:163px;', 'bottom:192px;left:480px;',
                ],
                structureType7: [
                    'top:0;left:117px;', 'top:75px;left:496px;',
                    'top:120px;left:146px;', 'top:193px;left:500px;',
                    'bottom:330px;left:166px;', 'bottom:190px;left:496px;',
                ],
                structureType8: [
                    'top:0px;left:117px;', 'top:25px;left:492px;',
                    'top:56px;left:135px;', 'top:93px;left:478px;',
                    'top:167px;left:155px;', 'top:210px;left:474px;',
                    'bottom:343px;left:175px;', 'bottom:250px;left:470px;',
                    'bottom:244px;left:187px;', 'bottom:145px;left:475px;',
                ],
                structureType9: [
                    'top:0px;left:117px;', 'top:31px;left:512px;',
                    'top:64px;left:135px;',  'top:115px;left:510px;',
                    'top:221px;left:155px;',  'top:336px;left:512px;',
                    'bottom:307px;left:185px;',  'bottom:171px;left:512px;',
                ],
            }
        },
    }
</script>

<style scoped>
    .graph-img{
        width: 667px;
        height: 665px;
        position: relative;
        display: flex;
        justify-content: center;
        padding: 20px 0;
    }
    .graph-img img{
        height: 100% !important;
    }
    .numbers{
        font-family: Harmonia Sans Pro Cyr;
        font-style: normal;
        font-weight: bold;
        font-size: 18px;
        line-height: 22px;
        color: #FFFFFF;
        position: absolute;
    }
</style>