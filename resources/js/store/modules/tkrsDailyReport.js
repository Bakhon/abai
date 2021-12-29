const tkrsDailyReport = {
    namespaced: true,
  
    state: {
        areaChartData: null,
        contractor_name: null,
        report_number: null,
        machine_type: null,
        field_name: null,
        well_type: null,
      
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
  
                } else {
                    console.log("No data");
                }
            });
      },
    },
  };
  
  export default tkrsDailyReport;

   //                 this.machine_type = data.data.header.machine_type;
    //                 this.field_name = data.data.header.field_name;
    //                 this.well_type = data.data.header.well_type;
    //                 this.well_name = data.data.header.well_name;
    //                 this.programmes_target_name = data.data.header.programmes_target_name;
    //                 this.chief = data.data.works_report.chief;
    //                 this.master_day_shift = data.data.works_report.master_day_shift;
    //                 this.master_day_shift_number = data.data.works_report.master_day_shift_number;
    //                 this.master_night_shift = data.data.works_report.master_night_shift;
    //                 this.master_night_shift_number = data.data.works_report.master_night_shift_number;
    //                 this.works_report_range = data.data.works_report_range;
    //                 this.start_drill = data.data.header.start_drill;
    //                 this.end_drill = data.data.header.end_drill;
    //                 this.all_works = data.data.works_report_range.all_works;
    //                 this.all_day_hour_works = data.data.all_day_hour_works.all_day_hour_works;
    //                 this.curr_hour_works = data.data.all_day_hour_works.curr_hour_works;
    //                 this.prev_hour_works = data.data.all_day_hour_works.prev_hour_works;
    //                 this.annular_pressure = data.data.parameters.annular_pressure;
    //                 this.descent_depth = data.data.parameters.descent_depth;
    //                 this.pipe_pressure = data.data.parameters.pipe_pressure;
    //                 this.artificial_slaughter = data.data.parameters.artificial_slaughter;
    //                 this.current_bottomhole = data.data.parameters.current_bottomhole;
    //                 this.prod_casing_outer_d = data.data.parameters.prod_casing_outer_d;
    //                 this.wall_thickness = data.data.parameters.wall_thickness;