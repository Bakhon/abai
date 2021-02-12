<template>
  <hot-table :data="data" id="example1" :colHeaders='true' :rowHeaders='true' licenseKey='non-commercial-and-evaluation'>
    <button type="submit" class="btn btn-primary" id="demo_btn">Сохранить</button>
    <input type="hidden" id="oil_plan" name='oil_plan'>
    <input type="hidden" id="oil_fact" name='oil_fact'>
    <input type="hidden" id="oil_dlv_plan" name='oil_dlv_plan'>
    <input type="hidden" id="oil_dlv_fact" name='oil_dlv_fact'>
    <input type="hidden" id="gas_plan" name='gas_plan'>
    <input type="hidden" id="gas_fact" name='gas_fact'>
    <input type="hidden" id="liq_plan" name='liq_plan'>
    <input type="hidden" id="liq_fact" name='liq_fact'>
    <input type="hidden" id="fond_neftedob_ef" name='fond_neftedob_ef'>
    <input type="hidden" id="fond_neftedob_df" name='fond_neftedob_df'>
    <input type="hidden" id="prod_wells_idle" name='prod_wells_idle'>
    <!-- <input type="hidden" id="prod_wells_work" name='prod_wells_work'> -->
    <input type="hidden" id="fond_neftedob_bd" name='fond_neftedob_bd'>
    <input type="hidden" id="fond_neftedob_osvoenie" name='fond_neftedob_osvoenie'>
    <input type="hidden" id="fond_nagnetat_ef" name='fond_nagnetat_ef'>
    <input type="hidden" id="fond_nagnetat_df" name='fond_nagnetat_df'>
    <input type="hidden" id="inj_wells_idle" name='inj_wells_idle'>
    <!-- <input type="hidden" id="inj_wells_work" name='inj_wells_work'> -->
    <input type="hidden" id="fond_nagnetat_bd" name='fond_nagnetat_bd'>
    <input type="hidden" id="fond_nagnetat_osvoenie" name='fond_nagnetat_osvoenie'>
    <input type="hidden" id="fond_neftedob_prs" name='fond_neftedob_prs'>
    <input type="hidden" id="fond_neftedob_oprs" name='fond_neftedob_oprs'>
    <input type="hidden" id="fond_neftedob_krs" name='fond_neftedob_krs'>
    <input type="hidden" id="fond_neftedob_okrs" name='fond_neftedob_okrs'>
    <input type="hidden" id="fond_neftedob_well_survey" name='fond_neftedob_well_survey'>
    <input type="hidden" id="fond_neftedob_others" name='fond_neftedob_others'>
    <input type="hidden" id="fond_neftedob_nrs" name='fond_neftedob_nrs'>
    <input type="hidden" id="otm_burenie_prohodka_plan" name='otm_burenie_prohodka_plan'>
    <input type="hidden" id="otm_burenie_prohodka_fact" name='otm_burenie_prohodka_fact'>
    <input type="hidden" id="otm_iz_burenia_skv_plan" name='otm_iz_burenia_skv_plan'>
    <input type="hidden" id="otm_iz_burenia_skv_fact" name='otm_iz_burenia_skv_fact'>
    <input type="hidden" id="tovarnyi_ostatok_nefti_today" name='tovarnyi_ostatok_nefti_today'>
  </hot-table>
</template>
 
<script>
  document.addEventListener("DOMContentLoaded", function() {

  var example1 = document.getElementById('example1');

  var hot1 = new Handsontable(example1, {
    colHeaders: true,
    rowHeaders: true,
    contextMenu: true,
    startCols: 30,
    startRows: 50,
    formulas: true,
    licenseKey: 'non-commercial-and-evaluation'
  });

  document.getElementById("demo_btn").onclick = function() {myFunction()};
  
  // var alldata = hot1.getData();
  // console.log(alldata[0]);
  
  function myFunction() {
    document.getElementById("oil_plan").value = hot1.getData()[4][2];
    document.getElementById("oil_fact").value = hot1.getData()[4][3];
    document.getElementById("oil_dlv_plan").value = hot1.getData()[4][9];
    document.getElementById("oil_dlv_fact").value = hot1.getData()[4][10];
    document.getElementById("gas_plan").value = hot1.getData()[9][2];
    document.getElementById("gas_fact").value = hot1.getData()[9][3];
    document.getElementById("liq_plan").value = hot1.getData()[13][2];
    document.getElementById("liq_fact").value = hot1.getData()[13][3];
    document.getElementById("fond_neftedob_ef").value = hot1.getData()[19][1];
    document.getElementById("fond_neftedob_df").value = hot1.getData()[19][2];
    document.getElementById("prod_wells_idle").value = hot1.getData()[19][3];
    document.getElementById("fond_neftedob_bd").value = hot1.getData()[19][4];
    document.getElementById("fond_neftedob_osvoenie").value = hot1.getData()[19][5];
    document.getElementById("fond_nagnetat_ef").value = hot1.getData()[19][6];
    document.getElementById("fond_nagnetat_df").value = hot1.getData()[19][7];
    document.getElementById("inj_wells_idle").value = hot1.getData()[19][8];
    document.getElementById("fond_nagnetat_bd").value = hot1.getData()[19][9];
    document.getElementById("fond_nagnetat_osvoenie").value = hot1.getData()[19][10];
    document.getElementById("fond_neftedob_prs").value = hot1.getData()[8][17];
    document.getElementById("fond_neftedob_oprs").value = hot1.getData()[9][17];
    document.getElementById("fond_neftedob_krs").value = hot1.getData()[11][17];
    document.getElementById("fond_neftedob_okrs").value = hot1.getData()[10][17];
    document.getElementById("fond_neftedob_well_survey").value = hot1.getData()[15][17];
    document.getElementById("fond_neftedob_nrs").value = hot1.getData()[20][17];
    document.getElementById("otm_burenie_prohodka_plan").value = hot1.getData()[24][2];
    document.getElementById("otm_burenie_prohodka_fact").value = hot1.getData()[24][3];
    document.getElementById("otm_iz_burenia_skv_plan").value = hot1.getData()[24][10];
    document.getElementById("otm_iz_burenia_skv_fact").value = hot1.getData()[24][9];
    document.getElementById("tovarnyi_ostatok_nefti_today").value = hot1.getData()[53][2];
  }

});
</script>

