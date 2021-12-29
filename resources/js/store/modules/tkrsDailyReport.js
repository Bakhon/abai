const tkrsDailyReport = {
    namespaced: true,
  
    state: {
        areaChartData: null,
        contractor_name: null,
        report_number: null,
        machine_type: null,
        field_name: null,
        well_type: null,
        well_name: null,
        programmes_target_name: null,
        chief: null,
        master_day_shift: null,
        master_day_shift_number: null,
        master_night_shift: null,
        master_night_shift_number: null,
        works_report_range: [],
        start_drill: null,
        end_drill: null,
        all_day_hour_works: [],
        curr_hour_works: [],
        prev_hour_works: [],
        parameters: [],
    },
  
    mutations: {
      SET_AREACHARTDATA(state, val) {
        state.areaChartData = val;
      },
      SET_CONTRACTORNAME(state, val) {
        state.contractor_name = val;
      },
      SET_REPORTNUMBER(state, val) {
        state.report_number = val;
      },
      SET_MACHINETYPE(state, val) {
        state.machine_type = val;
      },
      SET_FIELDNAME(state, val) {
        state.field_name = val;
      },
      SET_WELLTYPE(state, val) {
        state.well_type = val;
      },
      SET_WELLNAME(state, val) {
        state.well_name = val;
      },
      SET_PROGRAMMESTARGETNAME(state, val) {
        state.programmes_target_name = val;
      },
      SET_CHIEF(state, val) {
        state.chief = val;
      },
      SET_MASTERDAYSHIFT(state, val) {
        state.master_day_shift = val;
      },
      SET_MASTERDAYSHIFTNUMBER(state, val) {
        state.master_day_shift_number = val;
      },
      SET_MASTERNIGHTSHIFT(state, val) {
        state.master_night_shift = val;
      },
      SET_MASTERNIGHTSHIFTNUMBER(state, val) {
        state.master_night_shift_number = val;
      },
      SET_WORKSREPORTRANGE(state, val) {
        state.works_report_range = val;
      },
      SET_STARTDRILL(state, val) {
        state.start_drill = val;
      },
      SET_ENDDRILL(state, val) {
        state.end_drill = val;
      },
      SET_ALLDAYHOURWORKS(state, val) {
        state.all_day_hour_works = val;
      },
      SET_CURRHOURWORKS(state, val) {
        state.curr_hour_works = val;
      },
      SET_PREVHOURWORKS(state, val) {
        state.prev_hour_works = val;
      },
      SET_PARAMETERS(state, val) {
        state.parameters = val;
      },
    },
  
    actions: {
        getSelectedtWellFile({commit, state}, { well_name, well_date }) {
        axios
            .get(
              process.env.MIX_TKRS_POST_API_URL + `drHeaderWorkReport/${well_name}/${well_date}/`,
                
            )
            .then((response) => {
                let data = response.data;
                if (data) {
                  commit("SET_AREACHARTDATA", data.data);
                  commit("SET_CONTRACTORNAME", data.data.header.contractor_name);
                  commit("SET_REPORTNUMBER", data.data.header.report_number);
                  commit("SET_MACHINETYPE", data.data.header.machine_type);
                  commit("SET_FIELDNAME", data.data.header.field_name);
                  commit("SET_WELLTYPE", data.data.header.well_type);
                  commit("SET_WELLNAME", data.data.header.well_name);
                  commit("SET_PROGRAMMESTARGETNAME", data.data.header.programmes_target_name);
                  commit("SET_CHIEF", data.data.works_report.chief);
                  commit("SET_MASTERDAYSHIFT", data.data.works_report.master_day_shift);
                  commit("SET_MASTERDAYSHIFTNUMBER", data.data.works_report.master_day_shift_number);
                  commit("SET_MASTERNIGHTSHIFT", data.data.works_report.master_night_shift);
                  commit("SET_MASTERNIGHTSHIFTNUMBER", data.data.works_report.master_night_shift_number);
                  commit("SET_WORKSREPORTRANGE", data.data.works_report_range);
                  commit("SET_STARTDRILL", data.data.header.start_drill);
                  commit("SET_ENDDRILL", data.data.header.end_drill);
                  commit("SET_ALLDAYHOURWORKS", data.data.all_day_hour_works.all_day_hour_works);
                  commit("SET_CURRHOURWORKS", data.data.all_day_hour_works.curr_hour_works);
                  commit("SET_PREVHOURWORKS", data.data.all_day_hour_works.prev_hour_works);
                  commit("SET_PARAMETERS", data.data.parameters);
                } else {
                    console.log("No data");
                }
            });
      },
    },
  };
  
  export default tkrsDailyReport;
    
    //                 this.annular_pressure = data.data.parameters.annular_pressure;
    //                 this.descent_depth = data.data.parameters.descent_depth;
    //                 this.pipe_pressure = data.data.parameters.pipe_pressure;
    //                 this.artificial_slaughter = data.data.parameters.artificial_slaughter;
    //                 this.current_bottomhole = data.data.parameters.current_bottomhole;
    //                 this.prod_casing_outer_d = data.data.parameters.prod_casing_outer_d;
    //                 this.wall_thickness = data.data.parameters.wall_thickness;