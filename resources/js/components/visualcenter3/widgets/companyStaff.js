
export default {
    data: function () {
        return {
            staffPercent: 0,
            staff: 0,
            quarter1: 0,
            quarter2: 0,
            covidPercent: '',
            covid: '',
        };
    },
    methods: {
        getStaff() {
            let uri = this.localeUrl("/visualcenter3GetDataStaff");
            this.axios.get(uri).then((response) => {
                let data = response.data;
                if (data) {
                    var staff = _(data)
                        .groupBy("date")
                        .map((date, id) => ({
                            date: id,
                            staff_number: _.round(_.sumBy(date, 'staff_number'), 0),

                        }))
                        .value();
                    staff = _.orderBy(
                        staff,
                        ["date"],
                        ["desc"]
                    );
                    this.staff = staff[0]['staff_number'];
                    this.staffPercent = staff[1]['staff_number'];

                    this.quarter1 = this.getQuarter(new Date(staff[0]['date']));
                    this.quarter2 = this.getQuarter(new Date(staff[1]['date']));

                } else {
                    console.log('No data Personal')
                }
            });
        },

        getProductionPercentCovid(data) {
            var timestampToday = this.timestampToday;
            var timestampEnd = this.timestampEnd;
            var quantityRange = this.quantityRange;

            var dataWithMay = new Array();
            dataWithMay = _.filter(data, function (item) {
                return _.every([
                    _.inRange(
                        item.__time,
                        timestampToday - quantityRange * 86400000,
                        (timestampToday - (quantityRange * 86400000)) + 86400000
                    ),
                ]);
            });


            this.covidPercent = _.reduce(
                dataWithMay,
                function (memo, item) {
                    return memo + item['tb_covid_total'];
                },
                0
            );
        },

        getProductionPercent(data) {
            var timestampToday = this.timestampToday;
            var timestampEnd = this.timestampEnd
            var quantityRange = this.quantityRange;


            var productionPlan = this.planFieldName;
            var productionFact = this.factFieldName;


            var dataWithMay = new Array();
            dataWithMay = _.filter(data, function (item) {
                return _.every([
                    _.inRange(
                        item.__time,
                        timestampToday - quantityRange * 86400000,
                        timestampToday
                    ),
                ]);

            });


            return _(dataWithMay)
                .groupBy("dzo")
                .map((dzo, id) => ({
                    dzoPercent: id,
                    productionFactPercent: _.round(_.sumBy(dzo, productionFact), 0),
                    productionPlanPercent: _.round(_.sumBy(dzo, productionPlan), 0),
                }))
                .value();
        },
    }
}