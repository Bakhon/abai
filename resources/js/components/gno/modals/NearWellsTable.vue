<template>
  <div class="pgno-table-block no-gutter">
    <perfect-scrollbar>
      <table class="gno-table-with-header pgno" style="height: inherit;">
        <thead>
        <tr height="10" style="height: 10pt;">
          <td>
            № п/п
          </td>
          <td>
            {{trans('pgno.number_of_well')}}
          </td>
          <td>
            {{trans('pgno.distance')}}, {{trans('measurements.m')}}
          </td>
          <td>
            {{trans('pgno.influence_factor')}}
          </td>
          <td>
            {{trans('pgno.k_prod')}}, {{trans('measurements.m3/d/atm')}}
          </td>
          <td>
            {{trans('pgno.kh')}}
          </td>
          <td>
            {{trans('pgno.skin_factor')}}
          </td>
          <td>
            {{trans('pgno.p_pl')}}, {{trans('measurements.atm')}}
          </td>
          <td>
            {{trans('pgno.p_zab')}}, {{trans('measurements.atm')}}
          </td>
          <td>
            {{trans('pgno.q_liq')}}, {{trans('measurements.m3/day')}}
          </td>
          <td>
            {{trans('pgno.wc')}}, {{trans('measurements.percent')}}
          </td>
          <td>
            {{trans('pgno.q_nefti')}}, {{trans('measurements.t/d')}}
          </td>
        </tr>
        </thead>
        <tbody>
        <tr style="font-weight: bold;">
          <td></td>
          <td>{{this.wellAnalysis.well}}</td>
          <td></td>
          <td></td>
          <td>{{this.wellAnalysis.pi.toFixed(2)}}</td>
          <td>{{this.wellAnalysis.kh.toFixed(1)}}</td>
          <td>{{this.wellAnalysis.skin.toFixed(1)}}</td>
          <td>{{this.wellAnalysis.pRes.toFixed(0)}}</td>
          <td></td>
          <td></td>
          <td>{{this.wellAnalysis.wct.toFixed(0)}}</td>
          <td></td>

        </tr>
        <tr v-for="(row, row_index) in this.nearWells" :key="row_index">
          <td>{{Number(row_index) + 1}}</td>
          <td>{{row.well}}</td>
          <td>{{row.dist.toFixed(0)}}</td>
          <td>{{row.k_v.toFixed(3)}}</td>
          <td>{{row.pi.toFixed(2)}}</td>
          <td>{{row.kh.toFixed(1)}}</td>
          <td>{{row.skin.toFixed(1)}}</td>
          <td>{{row.p_res.toFixed(0)}}</td>
          <td>{{row.bhp.toFixed(0)}}</td>
          <td>{{row.q_l.toFixed(0)}}</td>
          <td>{{row.wct.toFixed(0)}}</td>
          <td>{{row.q_o.toFixed(1)}}</td>
        </tr>
        </tbody>
      </table>
    </perfect-scrollbar>
  </div>
</template>
<script src="./js/NearWellsTable.js"></script>