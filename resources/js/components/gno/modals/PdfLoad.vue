<template>
  <div style="position: absolute; left: -9999px; height: 0; overflow: hidden;">
    <div class="gno-line-chart-clone" ref="gno-chart" v-if="isVisibleChart" style="background-color: #272953;">
      <div>
        <div style="font-weight: bold; font-size: 20px; margin-left: 16px;  padding-top: 10px;">
          {{ trans('pgno.well') }}: {{ field }}-{{ wellNumber }}
        </div>
        <div style="font-weight: bold; font-size: 20px; margin-left: 16px;  padding-top: 10px;">
          {{ trans('pgno.data_form') }}: {{ new Date().toJSON().slice(0, 10).replace(/-/g, '/') }}
        </div>
      </div>
      <inflow-curve></inflow-curve>
    </div>

    <div class="gno-line-chart-well-old-clone" ref="gno-chart-new-old-well" v-if="isVisibleChart"
         style="background-color: #272953;">
      <div>
        <div style="font-weight: bold; font-size: 20px; margin-left: 16px;  padding-top: 10px;">
          {{ trans('pgno.analis_potenciala_skvazhini') }}: {{ field }}-{{ wellNumber }}
        </div>
        <div style="font-weight: bold; font-size: 20px; margin-left: 16px;  padding-top: 10px;">
          {{ trans('pgno.data_form') }}: {{ new Date().toJSON().slice(0, 10).replace(/-/g, '/') }}
        </div>
      </div>
      <Plotly :data="data" :layout="layout" :display-mode-bar="false"></Plotly>
    </div>

    <div class="report" ref="gno-page">
      <div class="row">
        <div class="col-10" style="background-color: #20274f; width: 1500px; left: 76px; margin: 0;">
          <div class="logo" style="top: 0px;"></div>
          <div style="left: 90px; color: white; padding-top: 10px; font-size: 20px;">
            {{ trans('pgno.is_Abai_modul_gno') }}
          </div>
        </div>
      </div>
      <div class="first-report-block row">
        <div class="report-block-title col-5">
          {{ trans('pgno.otchet_pgno') }}
        </div>
        <div class="report-block-title col-5">
          {{ trans('pgno.well') }} {{ wellNumber }}
        </div>
      </div>

      <div class="first-report-block-data row">
        <div class="report-block-data col-5">
          {{ trans('pgno.data_form') }}: {{ new Date().toJSON().slice(0, 10).replace(/-/g, '/') }}
        </div>
        <div class="report-block-data col-5">
          {{ trans('pgno.mestorozhdenie') }}: {{ field }}
        </div>
      </div>

      <div class="first-report-block-data row">
        <div class="report-block-data col-5">
          {{ trans('pgno.technolog_kmgi') }}
        </div>
        <div class="report-block-data col-5">
          {{ trans('pgno.horizon') }}: {{ horizon }}
        </div>
      </div>

      <div class="first-report-block-data row">
        <div class="report-block-data col-5">

        </div>
        <div class="report-block-data col-5">
          {{ trans('pgno.method_of_operation') }}: {{ expMeth }}
        </div>
      </div>

      <div class="first-report-block-data row">
        <div class="report-block-data-second-bottom col-5">

        </div>
        <div class="report-block-data-second-bottom col-5">
          {{ trans('pgno.org_struktura') }}: {{ ngdu }}
        </div>
      </div>

      <div class="second-report-block row">
        <div class="second-report-block-title-main col-10" style="border-bottom: 2px solid #8c8caf">
          {{ trans('pgno.data_for_raschet') }}
        </div>
      </div>

      <div class="first-report-block row">
        <div class="second-report-block-title col-5">
          {{ trans('pgno.construction') }}
        </div>
        <div class="second-report-block-title col-5">
          PVT
        </div>
      </div>

      <div class="first-report-block-data row">
        <div class="report-block-data-second-top col-5">
          {{ trans('pgno.naruznii_diametr_ex_col') }}: {{ casOD }} {{ trans('measurements.mm') }}
        </div>
        <div class="report-block-data-second-top col-5">
          {{ trans('pgno.p_nas') }}: {{ PBubblePoint }} {{ trans('measurements.atm') }}
        </div>
      </div>

      <div class="first-report-block-data row">
        <div class="report-block-data-second-top col-5">
          {{ trans('pgno.vnutrenii_diametr_ex_col') }}: {{ casID }}
        </div>
        <div class="report-block-data-second-top col-5">
          {{ trans('pgno.gaz_faktor') }}: {{ gorInput }}
        </div>
      </div>

      <div class="first-report-block-data row">
        <div class="report-block-data-second-top col-5">
          {{ trans('pgno.glubina_perf') }}: {{ hPerf }} {{ trans('measurements.m') }}
        </div>
        <div class="report-block-data-second-top col-5">
          {{ trans('pgno.temp_plasta') }}: {{ tRes }} {{ trans('measurements.celsius') }}
        </div>
      </div>

      <div class="first-report-block-data row">
        <div class="report-block-data-second-top col-5">
          {{ trans('pgno.udlinenie_perf') }}: {{ udl }} {{ trans('measurements.m') }}
        </div>
        <div class="report-block-data-second-top col-5">
          {{ trans('pgno.vyazkost_nefti') }}: {{ viscOilRc }} {{ trans('measurements.spz') }}
        </div>
      </div>

      <div class="first-report-block-data row">
        <div class="report-block-data-second-top col-5">
          {{ trans('pgno.tekushii_zaboi') }}: {{ curr }} {{ trans('measurements.m') }}
        </div>
        <div class="report-block-data-second-top col-5">
          {{ trans('pgno.vyazkost_vody') }}: {{ viscWaterRc }} {{ trans('measurements.g/sm3') }}
        </div>
      </div>

      <div class="first-report-block-data row">
        <div class="report-block-data-second-top col-5">

        </div>
        <div class="report-block-data-second-top col-5">
          {{ trans('pgno.plotnost_nefti') }}: {{ densOil }} {{ trans('measurements.g/sm3') }}
        </div>
      </div>

      <div class="first-report-block-data row">
        <div class="report-block-data-second-bottom-2 col-5">

        </div>
        <div class="report-block-data-second-bottom-2 col-5">
          {{ trans('pgno.plotnost_vody') }}: {{ densWater }} {{ trans('measurements.g/sm3') }}
        </div>
      </div>

      <div class="second-report-block row">
        <div class="second-report-block-title-main-2 col-10" style="border-bottom: 2px solid #8c8caf">
          {{ trans('pgno.technologicheskii_rezhim') }}:
        </div>
      </div>

      <div class="first-report-block-data row">
        <div class="report-block-data-second-top col-5">
          {{ trans('pgno.q_liq') }}: {{ qL }} {{ trans('measurements.m3/day') }}
        </div>
        <div class="report-block-data-second-top col-5">
          {{ trans('pgno.p_zab') }}: {{ bhp }} {{ trans('measurements.atm') }}
        </div>
      </div>

      <div class="first-report-block-data row">
        <div class="report-block-data-second-top col-5">
          {{ trans('pgno.obvodnenost') }}: {{ wct }} {{ trans('measurements.percent') }}
        </div>
        <div class="report-block-data-second-top col-5">
          {{ trans('pgno.q_nefti') }}: {{ qO }} {{ trans('measurements.t/d') }}
        </div>
      </div>

      <div class="first-report-block-data row">
        <div class="report-block-data-second-top col-5">
          {{ trans('pgno.h_dyn') }}: {{ hDyn }} {{ trans('measurements.m') }}
        </div>
        <div class="report-block-data-second-top col-5">
          {{ trans('pgno.p_zat') }}: {{ pAnnular }} {{ trans('measurements.atm') }}
        </div>
      </div>

      <div class="first-report-block-data row">
        <div class="report-block-data-third-bottom col-5">
          {{ trans('pgno.gf') }}: {{ gor }} {{ trans('measurements.m3/t') }}
        </div>
        <div class="report-block-data-third-bottom col-5">
          {{ trans('pgno.p_pl') }}: {{ pRes }} {{ trans('measurements.atm') }}
        </div>
      </div>

      <div class="gno-chart-clone col-10">
        <inflow-curve></inflow-curve>
      </div>

      <div class="title-page-2 col-10">
        <h2>{{ trans('pgno.result_podbora_gno') }}</h2>
      </div>

      <div class="block-results row">
        <div class="col-12">
          <div class="block-results row">
            <div class="image-data-clone col-4">

              <div class="shgn-rod image-text-1">{{ trans('pgno.eks_kolonna') }} {{
                  this.casID
                }}{{ trans('measurements.mm') }}
              </div>
              <div class="shgn-rod image-text-2">{{ trans('pgno.nkt') }} {{
                  this.tubOD
                }}{{ trans('measurements.mm') }}
              </div>
              <div class="shgn-rod image-text-3">{{ trans('pgno.shtangi') }} {{
                  this.shgnS1D
                }}{{ trans('measurements.mm') }} 0-{{ this.shgnS1L }}{{ trans('measurements.m') }}
              </div>
              <div class="shgn-rod image-text-4">
                {{ trans('pgno.shtangi') }} {{ this.shgnS2D }}{{ trans('measurements.mm') }} {{ this.shgnS1L }}-{{
                  this.shgnS1L * 1 + this.shgnS2L * 1
                }}{{ trans('measurements.m') }}
              </div>
              <div class="shgn-rod image-text-5">
                {{ trans('pgno.shtangi') }} {{ this.shgnS1D }}{{ trans('measurements.mm') }}
                {{ this.shgnS1L * 1 + this.shgnS2L * 1 }}-{{
                  this.shgnS1L * 1 + this.shgnS2L * 1 + this.shgnTNL * 1
                }}{{ trans('measurements.m') }}
              </div>
              <div class="shgn-rod image-text-6">{{ trans('pgno.nasos') }} {{
                  this.shgnPumpType
                }}{{ trans('measurements.mm') }}
              </div>
              <div class="shgn-rod image-text-7">
                {{ trans('pgno.interval_perf') }} <br> {{ this.hPerf }}-{{
                  this.hPerf * 1 + this.hPerfND * 1
                }}{{ trans('measurements.m') }}
              </div>
              <div class="shgn-rod image-text-8">{{ trans('pgno.tekushii_zaboi') }} {{
                  this.curr
                }}{{ trans('measurements.m') }}
              </div>

              <img class="rods-image"
                   src="/img/gno/shgn.png"
                   alt="podbor-gno"/>

            </div>

            <div class="block-gno-data col-6">
              <div class="row">
                <div class="col-12">
                  <div class="col-12"
                       style="margin-left: -15px; background-color: #656a8a; width: 513px; max-width: 1000px; font-size: 20px; color: white; height: 50px; padding-top: 10px; font-weight: bold;">
                    {{ trans('pgno.raschetnii_rezhim') }}:
                  </div>

                  <div class="row">
                    <div class="col-6"
                         style="background-color: white; color: black; border-right: 2px solid #8c8caf; border-bottom: 2px solid #8c8caf; border-left: 2px solid #8c8caf;">
                      {{ trans('pgno.q_liq') }}: {{ qLInput }}
                    </div>
                    <div class="col-6"
                         style="background-color: white; color: black; border-bottom: 2px solid #8c8caf; border-right: 2px solid #8c8caf;">
                      {{ trans('pgno.q_nefti') }}: {{ qO }}
                    </div>

                    <div class="col-6"
                         style="background-color: white; color: black; border-right: 2px solid #8c8caf; border-bottom: 2px solid #8c8caf; border-left: 2px solid #8c8caf;">
                      {{ trans('pgno.obvodnenost') }}: {{ wctInput }}
                    </div>
                    <div class="col-6"
                         style="background-color: white; color: black; border-bottom: 2px solid #8c8caf; border-right: 2px solid #8c8caf;">
                      {{ trans('pgno.p_zab') }}: {{ bhpInput }}
                    </div>

                    <div class="col-6"
                         style="background-color: white; color: black; border-bottom: 2px solid #8c8caf; border-left: 2px solid #8c8caf;">
                      {{ trans('pgno.p_pr') }}: {{ piCelValue }}
                    </div>
                    <div class="col-6"
                         style="background-color: white; color: black; border-bottom: 2px solid #8c8caf; border-right: 2px solid #8c8caf;">

                    </div>

                  </div>
                </div>

                <div class="col-12">
                  <div class="col-12"
                       style="margin-left: -15px; background-color: #656a8a; width: 513px; max-width: 1000px; font-size: 20px; color: white; height: 50px; padding-top: 10px; font-weight: bold;">
                    {{ trans('pgno.komponovka_shgn') }}
                  </div>
                  <div class="col-12"
                       style="margin-left: -15px; background-color: #c1c3d0; width: 513px; max-width: 1000px; font-size: 20px; color: black; height: 50px; padding-top: 10px;">
                    {{ trans('pgno.diametr_nasosa') }}:
                  </div>
                  <div class="row">
                    <div class="col-6"
                         style="background-color: white; color: black; border-right: 2px solid #8c8caf; border-bottom: 2px solid #8c8caf; border-left: 2px solid #8c8caf;">
                      {{ trans('pgno.h_spuska') }}: {{ hPumpManomInput }}
                    </div>
                    <div class="col-6"
                         style="background-color: white; color: black; border-bottom: 2px solid #8c8caf; border-right: 2px solid #8c8caf;">
                      {{ trans('pgno.typ_sk') }}: {{ sk }}
                    </div>

                    <div class="col-6"
                         style="background-color: white; color: black; border-right: 2px solid #8c8caf; border-bottom: 2px solid #8c8caf; border-left: 2px solid #8c8caf;">
                      {{ trans('pgno.dlina_hoda') }}: {{ strokeLenDev }} {{ trans('measurements.m') }}
                    </div>
                    <div class="col-6"
                         style="background-color: white; color: black; border-bottom: 2px solid #8c8caf; border-right: 2px solid #8c8caf;">
                      {{ trans('pgno.chislo_kachanii') }}: {{ spmDev }} {{ trans('measurements.1/min') }}
                    </div>

                  </div>

                  <div class="col-12"
                       style="margin-left: -15px; background-color: #c1c3d0; width: 513px; max-width: 1000px; font-size: 20px; color: black; height: 50px; padding-top: 10px; font-weight: bold;">
                    {{ trans('pgno.kolonna_shtang') }}:
                  </div>
                  <div class="row">
                    <div class="col-4"
                         style="background-color: white; color: black; border-bottom: 2px solid #8c8caf; border-left: 2px solid #8c8caf; height: 29px;">
                      {{ trans('pgno.sekcia') }} 1
                    </div>
                    <div class="col-4"
                         style="background-color: white; color: black; border-right: 2px solid #8c8caf; border-bottom: 2px solid #8c8caf; border-left: 2px solid #8c8caf; height: 29px;">
                      {{ trans('measurements.diameter') }}: {{ shgnS1D }} {{ trans('measurements.mm') }}
                    </div>

                    <div class="col-4"
                         style="background-color: white; color: black; border-right: 2px solid #8c8caf; border-bottom: 2px solid #8c8caf; height: 29px;">
                      {{ trans('measurements.dlina') }}: {{ shgnS1L }} {{ trans('measurements.m') }}
                    </div>

                    <div class="col-4"
                         style="background-color: white; color: black;  border-bottom: 2px solid #8c8caf; border-left: 2px solid #8c8caf; height: 29px;">
                      {{ trans('pgno.sekcia') }} 2
                    </div>
                    <div class="col-4"
                         style="background-color: white; color: black; border-right: 2px solid #8c8caf; border-bottom: 2px solid #8c8caf; border-left: 2px solid #8c8caf; height: 29px;">
                      {{ trans('measurements.diameter') }}: {{ shgnS2D }} {{ trans('measurements.mm') }}
                    </div>

                    <div class="col-4"
                         style="background-color: white; color: black; border-right: 2px solid #8c8caf; border-bottom: 2px solid #8c8caf; height: 29px;">
                      {{ trans('measurements.dlina') }}: {{ shgnS2L }} {{ trans('measurements.m') }}
                    </div>

                    <div class="col-4"
                         style="background-color: white; color: black; border-bottom: 2px solid #8c8caf; border-left: 2px solid #8c8caf; height: 29px;">
                      {{ trans('pgno.tn') }}
                    </div>
                    <div class="col-4"
                         style="background-color: white; color: black; border-right: 2px solid #8c8caf; border-bottom: 2px solid #8c8caf; border-left: 2px solid #8c8caf; height: 29px;">
                      {{ trans('measurements.diameter') }}: {{ shgnS1D }} {{ trans('measurements.mm') }}
                    </div>

                    <div class="col-4"
                         style="background-color: white; color: black; border-right: 2px solid #8c8caf; border-bottom: 2px solid #8c8caf; height: 29px;">
                      {{ trans('measurements.dlina') }}: {{ shgnTNL }} {{ trans('measurements.m') }}
                    </div>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>