export default {
	props: [ 'dataReptt' ],
	data() {
		return {
			unit: this.trans("economy_pf.repttTable.unitKzt"),
			yearLast: 2019,
			day: '30.01.19',
			yearNow: 2020,
            col2Reptt: '',
			col3Reptt: '',
			col4Reptt: '',
			col5Reptt: '',
			col6Reptt: '',
			col7Reptt: '',
			col8Reptt: '',
			col9Reptt: '',
            col10Reptt: '',
            col11Reptt: '',
			defaultProps: {
				id: 'id',
				children: 'handbook_items'
			},
			tableHeader: [
				{
					label: this.trans('economy_pf.repttTable.name'),
					prop: 'name'
				},
				{
					label: this.trans('economy_pf.repttTable.planNa') + this.trans('economy_pf.months.0'),
					prop: 'value'
				}
			]
		};
	},
	computed: {
		currentYear: function() {
			return this.dataReptt.currentYear;
		},
		previousYear: function() {
			return this.dataReptt.previousYear;
		}
	},
	methods: {
		distributionSumOverTree(attributeName, year) {
			this.dataReptt.reptt.reduce(function x(r, a) {
				let hasChild = a.handbook_items.length > 0;
				let yearValue = a[attributeName][year];
				if (yearValue < 0) {
					a[attributeName][year] = yearValue * -1;
				}
				if (hasChild) {
					a[attributeName][year] = a.handbook_items.reduce(x, 0);
				}
				return r + a[attributeName][year];
			}, 0);
		},

		getChangedColumnClass(obj) {
			if ((obj.columnIndex >5) && (obj.columnIndex < 9 )) {
				return 'reptt-column-blue3 reptt-cell';
			} else if (obj.columnIndex > 8) {
                return 'reptt-column-blue reptt-cell';
            }
             else if (obj.columnIndex === 0) {
				return 'reptt-column-zero reptt-column reptt-cell';
			} else {
				return 'reptt-column reptt-cell';
			}
		},

		hideEmptyValues: function(row) {	
			if (row.row.plan_value[this.currentYear] === 0) {
				return 'hidden-row';
			}
			else if (row.row.name === 'Производственные показатели') {
				return 'hidden-row';
			}
			else if (row.row.name === 'Реализация') {
				return 'hidden-row';
			}
			else if (row.row.name === 'Транспортировка/Хранение') {
				return 'hidden-row';
			}
			else if (row.row.name === 'Закуп') {
				return 'hidden-row';
			}
			else if (row.row.name === 'Сальдо движения денежных средств на начало периода') {
				return 'hidden-row';
			}
			else if (row.row.name === 'Чистая сумма денежных средств по операционной деятельности') {
				return 'hidden-row';
			}
			else if (row.row.name === 'Чистое поступление денежных средств по инвестиц.деятельности') {
				return 'hidden-row';
			}
		},
		getAbsoluteDeviation(currentYearPlanValue, currentYearFactValue) {
			let result = Math.abs(currentYearPlanValue - currentYearFactValue).toFixed(1);
			return result;
		},
		getRelativeDeviation(currentYearPlanValue, currentYearFactValue) {
			let result = (Math.abs(currentYearPlanValue - currentYearFactValue) / currentYearPlanValue * 100).toFixed(1);
			if (isNaN(result) || !isFinite(result)) {
				return 0;
			}
			return result;
		},
        formatter: (data) => {
            data=data / 1000    
            return Math.round(data).toLocaleString();
        },
	},
	updated() {
        this.col2Reptt = this.trans('economy_pf.repttTable.planNa') +'\n' + this.trans('economy_pf.months.0') + '-' + this.trans('economy_pf.months.7') + ' \n ';
		this.col3Reptt = this.trans('economy_pf.repttTable.factNa') + '\n' + this.trans('economy_pf.months.0') + '-' + this.trans('economy_pf.months.7') + ' \n ';
		this.col4Reptt = this.trans('economy_pf.repttTable.absDeviation') + ' \n '+ '+/-';
		this.col5Reptt = this.trans('economy_pf.repttTable.relativeDeviation') + ' \n' + ' %';
		this.col6Reptt = this.trans('economy_pf.repttTable.forecast') + ' \n + 3 '+ this.trans('economy_pf.repttTable.monthShort'); 
		this.col7Reptt = this.trans('economy_pf.repttTable.absDeviation') + ' +/- \n ' + this.trans('economy_pf.repttTable.fromApprovedPlan'); 
		this.col8Reptt = this.trans('economy_pf.repttTable.relativeDeviation') + ' % \n ' + this.trans('economy_pf.repttTable.fromApprovedPlan'); 
        this.col9Reptt = this.trans('economy_pf.repttTable.forecast') + ' \n + 12 '+ this.trans('economy_pf.repttTable.monthShort'); 
		this.col10Reptt = this.trans('economy_pf.repttTable.absDeviation') + ' +/- \n ' + this.trans('economy_pf.repttTable.fromApprovedPlan'); 
		this.col11Reptt = this.trans('economy_pf.repttTable.relativeDeviation') + ' % \n ' + this.trans('economy_pf.repttTable.fromApprovedPlan'); 
		let handbookKeys = [ 'plan_value', 'fact_value', 'intermediate_plan_value', 'intermediate_fact_value' ];
		handbookKeys.forEach((key) => {
			this.distributionSumOverTree(key, this.currentYear);
			this.distributionSumOverTree(key, this.previousYear);
		});
		this.$store.commit('globalloading/SET_LOADING', false);
	}
};
