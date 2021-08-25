<template>
  <div>
    <div class="modal-old-well-content-container">
      <div class="modal-old-well-plotly-container">
        <Plotly :data="data" :layout="layout" :display-mode-bar="false"></Plotly>
      </div>
      <div class="modal-analysis-menu">
        <div v-if="!well.newWell" class="form-check">
          <input v-model="settings.analysisOld" class="checkbox-analysis-modal" @change="updateGraph()"
                 value="analysisOldPres" type="checkbox"/>
          <label class="checkbox-modal-analysis-menu-label">{{ trans('pgno.ppl_equal_pnach') }}</label>
        </div>
        <div v-if="well.newWell" class="form-check-new">
          <input v-model="settings.analysisNew" class="new-checkbox-modal-analysis-menu" @change="updateGraph()"
                 value="analysisNewPres" type="checkbox"/>
          <label class="new-checkbox-modal-analysis-menu-label">{{ trans('pgno.p_pl_p_izobar') }}</label>
        </div>

        <div v-if="!well.newWell" class="form-check">
          <input v-model="settings.analysisOld" class="checkbox-modal-analysnauryzbekis-menu" @change="updateGraph()"
                 value="analysisOldHdyn" type="checkbox"/>
          <label class="checkbox-modal-analysis-menu-label">{{ trans('pgno.hdin_equal_hdin_min') }}</label>
        </div>
        <div v-if="well.newWell" class="form-check-new">
          <input v-model="settings.analysisNew" class="new-checkbox-modal-analysis-menu" @change="updateGraph()"
                 value="analysisNewPi" type="checkbox"/>
          <label class="new-checkbox-modal-analysis-menu-label">{{ trans('pgno.k_pr_k_po_okr') }}</label>
        </div>

        <div v-if="!well.newWell" class="form-check">
          <input v-model="settings.analysisOld" class="checkbox-modal-analysnauryzbekis-menu" @change="updateGraph()"
                 value="analysisOldBhp" type="checkbox"/>
          <label class="checkbox-modal-analysis-menu-label">{{ trans('pgno.p_zab_more_p_nas') }}</label>
        </div>

        <div v-if="well.newWell" class="form-check-new">
          <label class="new-checkbox-modal-analysis-menu-label">{{ trans('pgno.obv_po_okr') }}</label>
          <label>{{ well.wct }}%</label>
        </div>

        <div v-if="!well.newWell" class="form-check">
          <input v-model="settings.analysisOld" class="checkbox-analysis-modal" @change="updateGraph()"
                 value="analysisOldQlAsma" type="checkbox"/>
          <label class="checkbox-modal-analysis-menu-label">{{ trans('pgno.q_liq_equal_q_liq') }}</label>
        </div>
        <div v-if="well.newWell" class="form-check-new">
          <input v-model="settings.analysisNew" class="new-checkbox-modal-analysis-menu" @change="updateGraph()"
                value="analysisNewBhp" type="checkbox"/>
          <label class="new-checkbox-modal-analysis-menu-label">{{ trans('pgno.p_zab_more_p_nas') }}</label>
        </div>

        <div v-if="!well.newWell" class="form-check">
          <input v-model="settings.analysisOld" class="checkbox-analysis-modal" @change="updateGraph()"
                 value="analysisOldWctAsma" type="checkbox"/>
          <label class="checkbox-modal-analysis-menu-label">{{ trans('pgno.obv_obv_acma') }}</label>
        </div>
        <div v-if="well.newWell" class="form-check-new">
          <input v-model="settings.hasGrp" class="new-checkbox-modal-analysis-menu"  @change="updateGraph()" type="checkbox"/>
          <label class="new-checkbox-modal-analysis-menu-label">{{ trans('pgno.s_grp') }}</label>
        </div>


        <div v-if="!well.newWell" class="form-check">
          <input v-model="settings.analysisOld" class="checkbox-analysis-modal" @change="updateGraph()"
                 value="analysisOldGorAsma" type="checkbox"/>
          <label class="checkbox-modal-analysis-menu-label">{{ trans('pgno.gor_gor_acma') }}</label>
        </div>
        <div v-if="well.newWell" class="form-check-new">
          {{ trans('pgno.near_dist') }}
          <input v-model="settings.nearDist" class="new-checkbox-modal-analysis-menu curve-settings-input w-25"  @change="updateGraph()"
                onfocus="this.value=''" type="text"/>
        </div>
        <div v-if="well.newWell" class="icon-near-wells" @click="openNearWellsModal()">
          <svg class="near-wells-icon" width="31" height="35" viewBox="0 0 31 35" fill="none"
               xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd"
                  d="M15.8654 0.56543C7.5741 0.56543 0.851562 7.05353 0.851562 15.0557C0.851562 19.2903 2.73469 23.1007 5.73609 25.7508L4.40373 34.6378L11.9882 29.0583C13.2252 29.3767 14.5247 29.5473 15.8654 29.5473C24.1566 29.5473 30.8807 23.0578 30.8807 15.0557C30.8807 7.05353 24.1566 0.56543 15.8654 0.56543ZM18.9912 23.0236C18.2183 23.3179 17.6029 23.541 17.1415 23.6956C16.6815 23.8503 16.1462 23.9274 15.5377 23.9274C14.6019 23.9274 13.8735 23.7069 13.3551 23.2663C12.8364 22.826 12.5786 22.2678 12.5786 21.5896C12.5786 21.3258 12.5974 21.0558 12.6359 20.7811C12.6751 20.506 12.7373 20.1971 12.8225 19.8499L13.7899 16.5522C13.8747 16.236 13.9487 15.9355 14.0071 15.6557C14.0655 15.3733 14.0937 15.1146 14.0937 14.8792C14.0937 14.4596 14.0033 14.1653 13.8242 13.9997C13.6421 13.8338 13.3005 13.753 12.7908 13.753C12.5416 13.753 12.2849 13.7887 12.0218 13.8633C11.7612 13.9408 11.535 14.0106 11.3495 14.0794L11.6047 13.0635C12.2377 12.8146 12.844 12.601 13.4223 12.4245C14.0006 12.2451 14.5473 12.1571 15.0623 12.1571C15.9913 12.1571 16.7079 12.3754 17.2128 12.8069C17.7149 13.2403 17.968 13.8032 17.968 14.4953C17.968 14.6387 17.9499 14.8915 17.916 15.2521C17.8813 15.6138 17.8163 15.9438 17.7225 16.2469L16.7603 19.5348C16.6815 19.7983 16.6115 20.1003 16.5481 20.4376C16.4855 20.7749 16.4553 21.0325 16.4553 21.2053C16.4553 21.642 16.5557 21.9403 16.7593 22.0986C16.9599 22.2569 17.3119 22.3366 17.8099 22.3366C18.0452 22.3366 18.3085 22.2959 18.6059 22.2176C18.9008 22.139 19.1145 22.0692 19.2491 22.0091L18.9912 23.0236ZM18.8208 9.6788C18.3722 10.0812 17.8318 10.2825 17.1999 10.2825C16.5696 10.2825 16.0256 10.0812 15.5732 9.6788C15.123 9.27673 14.8957 8.78698 14.8957 8.21535C14.8957 7.64517 15.1245 7.1543 15.5732 6.74823C16.0256 6.34106 16.5696 6.13876 17.1999 6.13876C17.8318 6.13876 18.3733 6.34106 18.8208 6.74823C19.2694 7.1543 19.4944 7.64517 19.4944 8.21535C19.4944 8.78843 19.2694 9.27673 18.8208 9.6788Z"
                  fill="#FEFEFE"/>
          </svg>
        </div>
        <button type="button" class="old-well-button" @click="changeAnalysisSettings()">
          {{ trans('pgno.primenit_korrektirovki') }}
        </button>
      </div>
    </div>
  </div>
</template>

<script src="./js/AnalysisMenu.js"></script>

<style scoped>

.near-wells-icon {
  margin-top: -30px;
  margin-left: 30px;
}

.w-25 {
  width: 25%
}

</style>
