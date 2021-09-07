<template>
    <table class="table defaultTable">
       <tbody>
         <tr>
           <th></th>
           <th>МД, (м)</th>
           <th>CL, (м)</th>
           <th>Inc, (м)</th>
           <th>Azi, (м)</th>
           <th>TVD, (м)</th>
           <th>TVDSS, (м)</th>
           <th>NS, (м)</th>
           <th>EW, (м)</th>
           <th>V.Sec (м)</th>
           <th>Dogleg, (м)</th>
           <th>T.Face, (м)</th>
           <th>Build, (м)</th>
           <th>Turn, (м)</th>
           <th>Section Type</th>
           <th>Targetz</th>
       </tr>
         <tr v-for="i in 20">
           <td>{{ i }}</td>
           <td>3946, 12</td>
           <td>16,12</td>
           <td>42,61</td>
           <td>264,15</td>
           <td>3209,93</td>
           <td>3057,43</td>
           <td>-210,59</td>
           <td>-2014,63</td>
           <td>2025,60</td>
           <td>0,000</td>
           <td>0,00</td>
           <td>0,000</td>
           <td>0,000</td>
           <td>Inc Azi MD</td>
           <td></td>
       </tr>
       </tbody>
    </table>
</template>

<script>
    export default {
        name: "well-profile"
    }
</script>

<style scoped>

</style>