<template>
    <div class="graph-img" v-if="type=='type1'">
        <span v-for="(structure, i) in data" :style="structureType1[i]" class="numbers">{{structure}} мм.</span>
        <img src="/img/digital-drilling/constructor-1.svg" alt="" class="structure-img">
    </div>
    <div class="graph-img" v-else-if="type=='type2'">
        <span v-for="(structure, i) in data" :style="structureType2[i]" class="numbers">{{structure}} мм.</span>
        <img src="/img/digital-drilling/constructor-2.svg" alt="" class="structure-img">
    </div>
    <div class="graph-img" v-else-if="type=='type3'">
        <span v-for="(structure, i) in data" :style="structureType3[i]" class="numbers">{{structure}} мм.</span>
        <img src="/img/digital-drilling/constructor-3.svg" alt="" class="structure-img">
    </div>
    <div class="graph-img" v-else-if="type=='type4'">
        <span v-for="(structure, i) in data" :style="structureType4[i]" class="numbers">{{structure}} мм.</span>
        <img src="/img/digital-drilling/constructor-4.svg" alt="" class="structure-img">
    </div>
    <div class="graph-img" v-else-if="type=='type5'">
        <span v-for="(structure, i) in data" :style="structureType5[i]" class="numbers">{{structure}} мм.</span>
        <img src="/img/digital-drilling/constructor-5.svg" alt="" class="structure-img">
    </div>
    <div class="graph-img" v-else-if="type=='type6'">
        <span v-for="(structure, i) in data" :style="structureType6[i]" class="numbers">{{structure}} мм.</span>
        <img src="/img/digital-drilling/constructor-6.svg" alt="" class="structure-img">
    </div>
    <div class="graph-img" v-else-if="type=='type7'">
        <span v-for="(structure, i) in data" :style="structureType7[i]" class="numbers">{{structure}} мм.</span>
        <img src="/img/digital-drilling/constructor-7.svg" alt="" class="structure-img">
    </div>
    <div class="graph-img" v-else-if="type=='type8'">
        <span v-for="(structure, i) in data" :style="structureType8[i]" class="numbers">{{structure}} мм.</span>
        <img src="/img/digital-drilling/constructor-8.svg" alt="" class="structure-img">
    </div>
    <div class="graph-img" v-else-if="type=='type9'">
        <span v-for="(structure, i) in data" :style="structureType9[i]" class="numbers">{{structure}} мм.</span>
        <img src="/img/digital-drilling/constructor-9.svg" alt="" class="structure-img">
    </div>
</template>

<script>
    export default {
        name: "StructureType",
        props: ['data', 'type'],
        data(){
            return{
                structureType1: [
                    'top:8px;left:87px;', 'top:0px;right:65px;', 'top:274px;right:88px;',
                    'bottom:236px;left:112px;', 'bottom:235px;right:75px;', 'bottom:12px;right:88px;'
                ],
                structureType2: [
                    'top:0px;left:57px;', 'top:0px;right:20px;', 'top:104px;right:76px;',
                    'top:170px;left:85px;', 'top:180px;right:45px;', 'top:266px;right:75px;',
                    'bottom:207px;left:131px;', 'bottom:187px;right:85px;', 'bottom:14px;right:60px;'
                ],
                structureType3: [
                    'top:2px;left:89px;', 'top:0;right:80px;', 'top:36px;right:83px;',
                    'top:71px;left:105px;', 'top:73px;right:86px;', 'top:123px;right:102px;',
                    'top:179px;right:123px;', 'top:211px;left:127px;', 'bottom:376px;right:100px;',
                    'bottom:261px;left:157px;', 'bottom:144px;right:87px;', 'bottom:130px;left:147px;',
                    'bottom:100px;right:160px;', 'bottom:13px;right:97px;',
                ],
                structureType4: [
                    'top:0;left:65px;', 'top:0;right:39px;', 'top:36px;right:34px;',
                    'top:86px;left:105px;', 'top:76px;right:50px;', 'top:153px;right:34px;',
                    'bottom:317px;right:92px;', 'top:298px;left:127px;', 'bottom:190px;right:33px;',
                    'bottom:192px;left:157px;', 'bottom:129px;right:96px;', 'bottom:16px;right:18px;',
                ],
                structureType5: [
                    'top:0;left:65px;', 'top:0;left:548px;', 'top:76px;left:548px;',
                    'top:139px;left:527px;', 'top:150px;left:99px;', 'top:214px;left:548px;',
                    'top:342px;left:503px;', 'top:345px;left:127px;', 'bottom:158px;left:548px;',
                    'bottom:113px;left:479px;', 'bottom:93px;left:145px;', 'bottom:11px;left:548px;',
                ],
                structureType6: [
                    'top:8px;left:146px;', 'top:0px;left:482px;', 'top:200px;left:469px;',
                    'bottom:351px;left:163px;', 'bottom:354px;left:463px;', 'bottom:192px;left:469px;',
                ],
                structureType7: [
                    'top:0;left:117px;', 'top:0px;left:482px;', 'top:75px;left:477px;',
                    'top:120px;left:146px;', 'top:131px;left:487px;', 'top:193px;left:474px;',
                    'bottom:330px;left:166px;', 'bottom:316px;left:461px;', 'bottom:190px;left:472px;',
                ],
                structureType8: [
                    'top:0px;left:117px;', 'top:0px;left:482px;', 'top:31px;left:484px;',
                    'top:56px;left:135px;', 'top:56px;left:470px;', 'top:99px;left:468px;',
                    'top:167px;left:155px;', 'top:148px;left:457px;', 'top:212px;left:472px;',
                    'bottom:338px;left:185px;', 'bottom:250px;left:471px;', 'bottom:215px;left:424px;',
                    'bottom:244px;left:187px;', 'bottom:142px;left:475px;',
                ],
                structureType9: [
                    'top:0px;left:117px;', 'top:0px;left:511px;', 'top:31px;left:512px;',
                    'top:64px;left:135px;', 'top:62px;left:495px;', 'top:115px;left:510px;',
                    'top:221px;left:155px;', 'top:242px;left:469px;', 'top:336px;left:512px;',
                    'bottom:307px;left:185px;', 'bottom:258px;left:456px;', 'bottom:171px;left:512px;',
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