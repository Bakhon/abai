<template>
  <div class="pgno-table-block no-gutter">
    <perfect-scrollbar>
      <table class="gno-table-with-header pgno">
        <thead>
        <tr height="60" style="height: 60pt;">
          <td>
            {{trans('pgno.naimenovanie')}}
          </td>
          <td>
            {{trans('pgno.shgn_pokupka')}}
          </td>
          <td>
            {{trans('pgno.ecn_arenda')}}
          </td>
        </tr>
        </thead>
        <tbody>
        <tr>
          <td>{{trans('pgno.dop_dobycha_zhidkosti')}}</td>
          <td>
            {{ Math.round(expAnalysisData.npvTable1.liquid / 1000) }}
          </td>
          <td>
            {{ Math.round(expAnalysisData.npvTable2.liquid / 1000) }}
          </td>
        </tr>
        <tr>
          <td>{{trans('pgno.dop_dobycha_nefti')}}</td>
          <td>{{ Math.round(expAnalysisData.npvTable1.oil / 1000) }}</td>
          <td>{{ Math.round(expAnalysisData.npvTable2.oil / 1000) }}</td>
        </tr>
        <tr>
          <td>{{trans('pgno.kol_otrabot_dnei')}}</td>
          <td>
            {{ Math.round(expAnalysisData.npvTable1.workday) }}
          </td>
          <td>
            {{ Math.round(expAnalysisData.npvTable2.workday) }}
          </td>
        </tr>
        <tr>
          <td>{{trans('pgno.kol_prs')}}</td>
          <td>
            {{
              Math.round(expAnalysisData.npvTable1.kolichestvoPrs)
            }}
          </td>
          <td>
            {{
              Math.round(expAnalysisData.npvTable2.kolichestvoPrs)
            }}
          </td>
        </tr>
        <tr>
          <td>{{trans('pgno.srednee_prod_prs')}}</td>
          <td>
            {{ expAnalysisData.npvTable1.sredniiPrs }}
          </td>
          <td>
            {{ expAnalysisData.npvTable2.sredniiPrs }}
          </td>
        </tr>
        <tr>
          <td>
            {{trans('pgno.raspred_po_naprav_ndo')}}
          </td>
          <td>
            {{ Math.round(expAnalysisData.npvTable1.godovoiNdo / 1000) }}
          </td>
          <td>
            {{ Math.round(expAnalysisData.npvTable2.godovoiNdo / 1000) }}
          </td>
        </tr>
        <tr>
          <td>{{trans('pgno.opred_dohod_chasti')}}</td>
          <td>
            {{ Math.round(expAnalysisData.npvTable1.godovoiDohod / 1000) }}
          </td>
          <td>
            {{ Math.round(expAnalysisData.npvTable2.godovoiDohod / 1000) }}
          </td>
        </tr>
        <tr>
          <td>{{trans('pgno.raschet_ndpi')}}</td>
          <td>
            {{ Math.round(expAnalysisData.npvTable1.godovoiNdpi / 1000)}}
          </td>
          <td>
            {{ Math.round(expAnalysisData.npvTable2.godovoiNdpi / 1000) }}
          </td>
        </tr>
        <tr>
          <td>{{trans('pgno.raschet_rent_naloga')}}</td>
          <td>
            {{ Math.round(expAnalysisData.npvTable1.godovoiRent / 1000) }}
          </td>
          <td>
            {{ Math.round(expAnalysisData.npvTable2.godovoiRent / 1000) }}
          </td>
        </tr>
        <tr>
          <td>{{trans('pgno.raschet_etp')}}</td>
          <td>
            {{ Math.round(expAnalysisData.npvTable1.godovoiEtp / 1000) }}
          </td>
          <td>
            {{ Math.round(expAnalysisData.npvTable2.godovoiEtp / 1000) }}
          </td>
        </tr>
        <tr>
          <td>{{trans('pgno.raschet_rashodov_po_trans_nefti')}}</td>
          <td>
            {{ Math.round(expAnalysisData.npvTable1.godovoiTrans / 1000) }}
          </td>
          <td>
            {{ Math.round(expAnalysisData.npvTable2.godovoiTrans / 1000) }}
          </td>
        </tr>
        <tr>
          <td>{{trans('pgno.zatraty_na_electro')}}</td>
          <td>
            {{ Math.round(expAnalysisData.npvTable1.godovoiZatrElectShgn / 1000) }}
          </td>
          <td>
            {{ Math.round(expAnalysisData.npvTable2.godovoiZatrElectEcn / 1000) }}
          </td>
        </tr>
        <tr>
          <td>{{trans('pgno.zatraty_na_podgotovku')}}</td>
          <td>
            {{ Math.round(expAnalysisData.npvTable1.godovoiZatrPrep / 1000) }}
          </td>
          <td>
            {{ Math.round(expAnalysisData.npvTable2.godovoiZatrPrep / 1000) }}
          </td>
        </tr>
        <tr>
          <td>{{trans('pgno.zatraty_na_prs')}}</td>
          <td>
            {{ Math.round(expAnalysisData.npvTable1.godovoiZatrPrs / 1000) }}
          </td>
          <td>
            {{ Math.round(expAnalysisData.npvTable2.godovoiZatrPrs / 1000) }}
          </td>
        </tr>
        <tr>
          <td>{{trans('pgno.zatraty_za_sut_obsluzh')}}</td>
          <td>
            {{ Math.round(expAnalysisData.npvTable1.godovoiZatrSutObs / 1000) }}
          </td>
          <td>
            {{ Math.round(expAnalysisData.npvTable2.godovoiZatrSutObs / 1000) }}
          </td>
        </tr>
        <tr>
          <td>{{trans('pgno.stoimost_arendy_oborudov')}}</td>
          <td>
            {{Math.round(expAnalysisData.npvTable1.godovoiArenda / 1000)}}
          </td>
          <td>
            {{Math.round(expAnalysisData.npvTable2.godovoiArenda / 1000)}}
          </td>
        </tr>
        <tr>
          <td>{{trans('pgno.amortizacia')}}</td>
          <td>
            {{Math.round(expAnalysisData.npvTable1.godovoiAmortizacia / 1000)}}
          </td>
          <td>
            {{Math.round(expAnalysisData.npvTable2.godovoiAmortizacia / 1000)}}
          </td>
        </tr>
        <tr>
          <td>{{trans('pgno.operacionaya_prybil')}}</td>
          <td>
            {{Math.round(expAnalysisData.npvTable1.godovoiOperPryb / 1000)}}
          </td>
          <td>
            {{Math.round(expAnalysisData.npvTable2.godovoiOperPryb / 1000)}}
          </td>
        </tr>
        <tr>
          <td>{{trans('pgno.kpn')}}</td>
          <td>
            {{Math.round(expAnalysisData.npvTable1.godovoiKpn / 1000)}}
          </td>
          <td>
            {{Math.round(expAnalysisData.npvTable2.godovoiKpn / 1000)}}
          </td>
        </tr>
        <tr>
          <td>{{trans('pgno.chistaya_prybil')}}</td>
          <td>
            {{Math.round(expAnalysisData.npvTable1.godovoiChistPryb / 1000)}}
          </td>
          <td>
            {{Math.round(expAnalysisData.npvTable2.godovoiChistPryb / 1000)}}
          </td>
        </tr>
        <tr>
          <td>{{trans('pgno.kvl')}}</td>
          <td>
            {{Math.round(expAnalysisData.npvTable1.godovoiKvl / 1000)}}
          </td>
          <td>
            {{Math.round(expAnalysisData.npvTable2.godovoiKvl / 1000)}}
          </td>
        </tr>
        <tr>
          <td>{{trans('pgno.svobodni_denezh_potok')}}</td>
          <td>
            {{Math.round(expAnalysisData.npvTable1.godovoiSvobPot / 1000)}}
          </td>
          <td>
            {{Math.round(expAnalysisData.npvTable2.godovoiSvobPot / 1000)}}
          </td>
        </tr>
        <tr>
          <td>{{trans('pgno.npv')}}</td>
          <td>{{Math.round(expAnalysisData.npvTable1.npv / 1000000).toFixed(0)}}
          </td>
          <td>{{Math.round(expAnalysisData.npvTable2.npv  / 1000000).toFixed(0)}}
          </td>
        </tr>
        </tbody>
      </table>
    </perfect-scrollbar>
  </div>
</template>

<script>
import { pgnoMapState, pgnoMapGetters, pgnoMapMutations, pgnoMapActions } from '@store/helpers';

export default {
  computed: {
    ...pgnoMapState([
      'expAnalysisData'
    ])
  }
}
</script>