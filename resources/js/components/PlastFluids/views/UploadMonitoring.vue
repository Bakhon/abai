<template>
  <div class="wrapper">
    <div class="top_wrapper">
      <div class="select_wrapper_left">
        <svg width="19" height="18" viewBox="0 0 19 18" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M12.6099 2.85938V5.74349H15.494C15.494 4.15096 14.2024 2.85938 12.6099 2.85938Z" fill="white"/>
        <path d="M12.1761 9.06145C13.7686 9.06145 15.0602 7.77043 15.0602 6.17733H12.1761V3.29321C10.5836 3.29321 9.29199 4.58423 9.29199 6.17733C9.        29199 7.77043 10.5836 9.06145 12.1761 9.06145Z" fill="white"/>
        <path d="M3.63239 7.55103H2.50732V8.56528H3.63239V7.55103Z" fill="white"/>
        <path d="M5.31257 5.19556H4.1875V8.56514H5.31257V5.19556Z" fill="white"/>
        <path d="M6.99226 3.48315H5.86719V8.5651H6.99226V3.48315Z" fill="white"/>
        <path d="M8.67243 6.72461H7.54736V8.56466H8.67243V6.72461Z" fill="white"/>
        <path d="M5.9235 16.8749H4.92218V18H13.0789V16.8749H12.0776L11.6839 14.0966H17.0011C17.5534 14.0966 18.0011 13.6489 18.0011 13.0966V1C18.0011 0.447716 17.5534 0 17.0011 0H1C0.447717 0 0 0.447715 0 1V13.0971C0 13.6494 0.447715 14.0971 1 14.0971H6.31727L5.9235 16.8749ZM7.05982 16.8749L7.1442 16.2815L10.745 15.49L10.9413 16.8749H7.05982ZM10.5863 14.3728L7.31296 15.0928L7.45415 14.0966H10.5475L10.5863 14.3728ZM16.8761 1.12507V11.0459H1.12507V1.12507H16.8761ZM1.12507 12.171H16.8761V12.9715H1.12507V12.171Z" fill="white"/>
        </svg>

        <select class="select_left">
          <option>{{ trans("plast_fluids.downloads_monitoring") }}</option>
        </select>
      </div>
      <div class="select_wrapper_right">
        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.33434 2.2999C6.61637 2.2999 6.03434 2.88193 6.03434 3.5999V7.99993C6.03434 8.38653 5.72094 8.69993 5.33434 8.69993C4.94774 8.69993 4.63434 8.38653 4.63434 7.99993V3.5999C4.63434 2.10873 5.84317 0.899902 7.33434 0.899902H16.4049C17.896 0.899902 19.1049 2.10873 19.1049 3.5999V12.6704C19.1049 14.1616 17.8961 15.3704 16.4049 15.3704H12.0004C11.6138 15.3704 11.3004 15.057 11.3004 14.6704C11.3004 14.2838 11.6138 13.9704 12.0004 13.9704H16.4049C17.1229 13.9704 17.7049 13.3884 17.7049 12.6704V3.5999C17.7049 2.88193 17.1229 2.2999 16.4049 2.2999H7.33434ZM5.33434 10.236C5.72094 10.236 6.03434 10.5494 6.03434 10.936V13.9705H9.06927C9.45587 13.9705 9.76927 14.2839 9.76927 14.6705C9.76927 15.0571 9.45587 15.3705 9.06927 15.3705H6.03434V18.4049C6.03434 18.7915 5.72094 19.1049 5.33434 19.1049C4.94774 19.1049 4.63434 18.7915 4.63434 18.4049V15.3705H1.60039C1.21379 15.3705 0.900391 15.0571 0.900391 14.6705C0.900391 14.2839 1.21379 13.9705 1.60039 13.9705H4.63434V10.936C4.63434 10.5494 4.94774 10.236 5.33434 10.236Z" fill="white"/>
        </svg>

        <select class="select_right">
          <option>{{ trans("plast_fluids.creating_new_download_templates") }}</option>
        </select>
      </div>
    </div>
    <div class="central_wrapper">
      <div class="menu_wrapper">
        <div class="sectors">
          <div>
            <svg width="17" height="18" viewBox="0 0 17 18" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M5.33671 12.6923V12.5423H5.18671H3.52294V9.15H8.05965V12.5423H6.39588H6.24588V12.6923V17V17.15H6.39588H10.628H10.778V17V12.6923V12.5423H10.628H8.96424V9.15H13.5009V12.5423H11.8372H11.6872V12.6923V17V17.15H11.8372H16.0693H16.2193V17V12.6923V12.5423H16.0693H14.4055V8.38462V8.23462H14.2555H8.96424V5.45769H10.628H10.778V5.30769V1V0.85H10.628H6.39588H6.24588V1V5.30769V5.45769H6.39588H8.05965V8.23462H2.76835H2.61835V8.38462V12.5423H0.95459H0.80459V12.6923V17V17.15H0.95459H5.18671H5.33671V17V12.6923ZM15.3147 13.4577V16.2346H12.5918V13.4577H15.3147ZM7.15047 4.54231V1.76538H9.87341V4.54231H7.15047ZM9.87341 13.4577V16.2346H7.15047V13.4577H9.87341ZM4.43212 16.2346H1.70918V13.4577H4.43212V16.2346Z" fill="#3366FF" stroke="#3366FF" stroke-width="0.3"/>
            </svg>

            {{ trans("plast_fluids.sections") }}
          </div>
        </div>
        <div class="menu"></div>
      </div>
      <div class="monitoring_wrapper">
        <div class="monitoring_select">
          <div>
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M14 6L8 12L14 18" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
            </svg>

            {{ trans("plast_fluids.downloads_monitoring") }}
          </div>
        </div>
        <div class="service_wrapper">
          <div class="table_div">
            <table>
              <tr class="table_header">
                <th>{{ trans("plast_fluids.upload_date") }}</th>
                <th>{{ trans("plast_fluids.download_author") }}</th>
                <th>{{ trans("plast_fluids.subsurface_user") }}</th>
                <th>{{ trans("plast_fluids.field") }}</th>
                <th>{{ trans("plast_fluids.selection_date_start") }}</th>
                <th>{{ trans("plast_fluids.selection_date_end") }}</th>
                <th>{{ trans("plast_fluids.data_type") }}</th>
                <th>{{ trans("plast_fluids.number_uploaded_samples") }}</th>
              </tr>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
            </table>
          </div>
          <div class="upload_wrapper">
            <div class="file_upload">
              <div class="file_upload_title">
                {{ trans("plast_fluids.download_file") }}
                <div class="file_service">
                  <button class="btn-common upload_file">
                    {{ trans("plast_fluids.download_package") }}
                  </button>
                  <button class="btn-common exchange_file">
                    {{ trans("plast_fluids.replace_package") }}
                  </button>
                </div>
              </div>
            </div>
            <div class="upload_status">
              <div class="upload_status_title">
                {{ trans("plast_fluids.download_log") }}
              </div>
              <div class="log_status"></div>
              <button class="btn-common download_log">Скачать лог загрузки</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {};
</script>

<style scoped>
:root {
  box-sizing: border-box;
}
*,
::before,
::after {
  box-sizing: inherit;
}
.wrapper {
  margin: 0px;
  padding: 0px;
  width: 100%;
  height: 100%;
  border: none;
}
.top_wrapper {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  width: 100%;
}
/* img {
  margin-right: 1em;
}
.pc_img {
  width: 28px;
  height: 28px;
  margin-top: 10px;
  margin-left: 25px;
  margin-right: 0px;
}
.template_img {
  width: 18px;
  height: 18px;
  margin-top: 11px;
  margin-left: 30px;
  margin-right: 0px;
} */

.select_wrapper_left {
  width: 100%;
  height: 40px;
  border-radius: 4px;
  margin-bottom: 15px;
  margin-right: 7.5px;
  display: flex;
  align-items: center;
  flex-direction: row;
  padding: 0px 25px;
  background-color: #2e50e9;
}
.select_wrapper_right {
  width: 100%;
  height: 40px;
  border-radius: 4px;
  margin-bottom: 15px;
  margin-left: 7.5px;
  display: flex;
  align-items: center;
  padding: 0px 25px;
  flex-direction: row;
  background-color: #333975;
}
.top_wrapper select {
  /* font-family: "Harmonia Sans Pro Cyr"; */
  font-size: 16px;
  font-style: normal;
  font-weight: 700;
  line-height: 19px;
  letter-spacing: 0em;
  text-align: left;
  width: 100%;
  height: 100%;
  color: aliceblue;
  border: none;
  /* padding-left: 25px; */
}
.select_left {
  background-color: #2e50e9;
}
.select_right {
  background-color: #333975;
}
.central_wrapper {
  display: flex;
  flex-direction: row;
  width: 100%;
  height: calc(100% - 55px);
}
.menu_wrapper {
  width: calc((350 / (1457+15+350) * 100%));
  background-color: #272953;
  margin-right: 15px;
}

.sectors > div {
  height: 50px;
  /* font-family: "Harmonia Sans Pro Cyr"; */
  font-size: 16px;
  font-style: normal;
  font-weight: 400;
  line-height: 19px;
  letter-spacing: 0em;
  text-align: left;
  color: white;
  padding-top: 15px;
  padding-left: 15px;
  border-bottom: 1px solid #555BA6;
}
.monitoring_wrapper {
  width: calc((1457 / (1457+15+350) * 100%));
  background-color: #272953;
  display: flex;
  flex-direction: column;
}
.service_wrapper {
  display: flex;
  flex-direction: row;
}
.upload_wrapper {
  display: flex;
  flex-direction: column;
  max-width: 445px;
  width: 445px;
  margin-top: 15px;
  margin-right: 15px;
}

.monitoring_select > div {
  /* height: 67px; */
  padding-top: 20px;
  padding-left: 25px;
  /* font-family: "Harmonia Sans Pro Cyr"; */
  font-size: 22px;
  font-style: normal;
  font-weight: 700;
  line-height: 26px;
  letter-spacing: 0em;
  text-align: left;
  color: aliceblue;
}
.table_div {
  max-width: 960px;
  width: 100%;
  height: 100%;
  margin: 15px;
}
table,
th,
td {
  border: 1px solid #454d7d;
}
th,
td {
  padding: 15px;
}

tr:nth-child(even) {
  background-color: #454d7d52;
}
.table_header {
  background-color: #333975;
  /* font-family: "Harmonia Sans Pro Cyr"; */
  font-size: 12px;
  font-style: normal;
  font-weight: 700;
  line-height: 14px;
  letter-spacing: 0em;
  text-align: center;
  color: aliceblue;
}

.file_upload {
  background-color: #363b68;
  width: 445px;
  height: 333px;
}

.upload_status {
  background-color: #363b68;
  margin-top: 15px;
  width: 445px;
  height: 491px;
}

.file_upload_title {
  /* font-family: "Harmonia Sans Pro Cyr"; */
  font-size: 20px;
  font-style: normal;
  font-weight: 700;
  line-height: 24px;
  letter-spacing: 0em;
  text-align: left;
  color: aliceblue;
  margin-left: 17px;
  margin-top: 25px;
}

.upload_status_title {
  /* font-family: "Harmonia Sans Pro Cyr"; */
  font-size: 20px;
  font-style: normal;
  font-weight: 700;
  line-height: 24px;
  letter-spacing: 0em;
  text-align: left;
  color: aliceblue;
  margin-left: 17px;
  margin-top: 25px;
}

.file_service {
  margin-top: 11px;
  width: 422px;
  height: 260px;
  background-color: #272953;
}

.log_status {
  margin-top: 11px;
  margin-left: 12px;
  width: 421px;
  height: 367px;
  background-color: #272953;
}

.btn-common {
  height: 32px;
  background-color: #3366ff;
  /* font-family: "Harmonia Sans Pro Cyr"; */
  font-size: 14px;
  font-style: normal;
  font-weight: 600;
  line-height: 24px;
  letter-spacing: 0em;
  text-align: center;
  color: aliceblue;
  border-radius: 4px;
}
.upload_file {
  width: 132px;
  margin-top: 218px;
  margin-left: 74px;
}

.exchange_file {


  width: 132px;
  margin-top: 218px;
  margin-right: 74px;
}

.download_log {

  width: 183px;
  margin-top: 12px;
  margin-left: 131px;
}
</style>
