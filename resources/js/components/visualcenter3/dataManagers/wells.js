import moment from "moment";

export default {
    data: function () {
        return {
            fondNamesByDBFields: {
                'fond_neftedob_df': 'operatingFond',
                'fond_neftedob_bd': 'nonOperatingFond',
                'fond_neftedob_osvoenie': 'masteringFond',
                'fond_neftedob_ofls': 'liquidationFond',
                'fond_neftedob_konv': 'conservationFond',
                'fond_neftedob_prs': 'undergroundRepairFond',
                'fond_neftedob_oprs': 'waitingUndergroundRepairFond',
                'fond_neftedob_krs': 'overhaulFond',
                'fond_neftedob_okrs': 'waitingOverhaulFond',
                'fond_neftedob_well_survey': 'researchFond',
                'fond_neftedob_others': 'othersFond',
                'fond_neftedob_ef': 'exploitationFond',
                'fond_nagnetat_df': 'operatingFond',
                'fond_nagnetat_bd': 'nonOperatingFond',
                'fond_nagnetat_osvoenie': 'masteringFond',
                'fond_nagnetat_ofls': 'liquidationFond',
                'fond_nagnetat_konv': 'conservationFond',
                'fond_nagnetat_prs': 'undergroundRepairFond',
                'fond_nagnetat_oprs': 'waitingUndergroundRepairFond',
                'fond_nagnetat_krs': 'overhaulFond',
                'fond_nagnetat_okrs': 'waitingOverhaulFond',
                'fond_nagnetat_well_survey': 'researchFond',
                'fond_nagnetat_others': 'othersFond',
                'fond_nagnetat_ef': 'exploitationFond',
                'fond_neftedob_nrs': 'unprofitableFond',
            },
            selectedSecondaryOption: '',
            selectedDzo: 'all',
        };
    },
    methods: {
        getSummaryProductionWellsForChart(inputData) {
            let innerWells = _.groupBy(inputData, item => {
                return moment(parseInt(item.__time)).format("YYYY-MM-DD");
            });

            let result = {}
            if (typeof innerWells !== 'undefined') {
                for (let i in innerWells) {
                    result[i] = {
                        fond_neftedob_ef: _.round(_.sumBy(innerWells[i], 'fond_neftedob_ef'), 0),
                        fond_neftedob_df: _.round(_.sumBy(innerWells[i], 'fond_neftedob_df'), 0),
                        fond_neftedob_bd: _.round(_.sumBy(innerWells[i], 'fond_neftedob_bd'), 0),
                        fond_neftedob_osvoenie: _.round(_.sumBy(innerWells[i], 'fond_neftedob_osvoenie'), 0),
                        fond_neftedob_ofls: _.round(_.sumBy(innerWells[i], 'fond_neftedob_ofls'), 0),
                        fond_neftedob_prs: _.round(_.sumBy(innerWells[i], 'fond_neftedob_prs'), 0),
                        fond_neftedob_oprs: _.round(_.sumBy(innerWells[i], 'fond_neftedob_oprs'), 0),
                        fond_neftedob_krs: _.round(_.sumBy(innerWells[i], 'fond_neftedob_krs'), 0),
                        fond_neftedob_okrs: _.round(_.sumBy(innerWells[i], 'fond_neftedob_okrs'), 0),
                        fond_neftedob_well_survey: _.round(_.sumBy(innerWells[i], 'fond_neftedob_well_survey'), 0),
                        fond_neftedob_nrs: _.round(_.sumBy(innerWells[i], 'fond_neftedob_nrs'), 0),
                        fond_neftedob_others: _.round(_.sumBy(innerWells[i], 'fond_neftedob_others'), 0),
                    }
                }
            }
            return result;
        },

        updateWellsWidgetsForAllCompanies(arr) {
            let wells = this.getGroupedWells(arr);

            this.inj_wells_idle = wells[0]['inj_wells_idle'];
            this.inj_wells_work = wells[0]['inj_wells_work'];
            this.prod_wells_work = parseInt(wells[0]['prod_wells_work']);
            this.prod_wells_idle = wells[0]['prod_wells_idle'];
        },

        updateWellsWidgetData(data, workFieldName, idleFieldName) {
            this[idleFieldName] = data[0][idleFieldName];
            this[workFieldName] = data[0][workFieldName];
        },
        updateWellsPercentWidgetData(data, workFieldName, idleFieldName, workParameterName, idleParameterName) {
            let periodStartTimestamp = this.timestampToday - this.quantityRange * 86400000;
            let filteredDataByPeriod = this.getProductionDataInPeriodRange(data,periodStartTimestamp,this.timestampToday);
            let groupedWellsData = this.getGroupedWells(filteredDataByPeriod);

            this[idleParameterName] = groupedWellsData[0][idleFieldName];
            this[workParameterName] = groupedWellsData[0][workFieldName];
        },

        getGroupedWells(data) {
              return _(data)
                  .groupBy("data")
                  .map((__time, id) => ({
                      __time: id,
                      inj_wells_idle: (_.sumBy(__time, 'inj_wells_idle')) / this.quantityRange,
                      inj_wells_work: (_.sumBy(__time, 'inj_wells_work')) / this.quantityRange,
                      prod_wells_work: (_.sumBy(__time, 'prod_wells_work')) / this.quantityRange,
                      prod_wells_idle: (_.sumBy(__time, 'prod_wells_idle')) / this.quantityRange,
                  }))
                  .value();
        },

        getSummaryWells(inputData, isIdleActive, fondsName) {
            let self = this;
            let fonds = _.cloneDeep(this[fondsName]);
            let productionPlanAndFactMonthWells = _(inputData)
                .groupBy("data")
                .map((__time, id) => (this.$_getSummaryFonds(fonds,__time,id)))
                .value();
            let halfOfProductionFondsLength = Math.ceil(fonds.length / 2);
            let productionFondsForIterations = [];
            let productionFondsSummary = [];
            if (!isIdleActive) {
                productionFondsForIterations = fonds.splice(0,halfOfProductionFondsLength);
            } else {
                productionFondsForIterations = fonds.splice(halfOfProductionFondsLength,fonds.length);
            }

            if (fondsName === 'productionFonds') {
                productionFondsForIterations = this.getUpdatedByPrsFond(isIdleActive, productionFondsForIterations);
            }

            if (productionPlanAndFactMonthWells[0]['fond_neftedob_df']) {
                productionPlanAndFactMonthWells[0]['fond_neftedob_df'] = Math.round(this.prod_wells_work) + Math.round(this.prod_wells_idle);
            }
            if (productionPlanAndFactMonthWells[0]['fond_nagnetat_df']) {
                productionPlanAndFactMonthWells[0]['fond_nagnetat_df'] = Math.round(this.inj_wells_work) + Math.round(this.inj_wells_idle);
            }

            _.forEach(productionFondsForIterations, function(fondName) {
                let translationName = "visualcenter." + self.fondNamesByDBFields[fondName.trim()];
                productionFondsSummary.push(
                    {
                        value: productionPlanAndFactMonthWells[0][fondName],
                        name: self.trans(translationName),
                        code: fondName
                    }
                );
            });

            return productionFondsSummary;
        },

        $_getSummaryFonds(fonds,time, id) {
            let summaryWells = {__time: id};
            let self = this;
            _.forEach(fonds, function(fond) {
                summaryWells[fond] = (_.sumBy(time, fond)) / self.quantityRange;
            });
            return summaryWells;
        },

        getUpdatedByPrsFond(isIdleActive,productionFondsForIterations) {
            if (!isIdleActive) {
                productionFondsForIterations.splice(-1,1);
            } else {
                productionFondsForIterations.push('fond_neftedob_prs');
            }
            return productionFondsForIterations;
        },
    },
}