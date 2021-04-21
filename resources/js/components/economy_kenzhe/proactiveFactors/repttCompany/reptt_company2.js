export default {
	props: [
		'dataReptt'
	],
	data() {
		return {
			yearLast: 2019,
			day: '30.01.19',
			yearNow: 2020,
			col3Reptt: '',
			col4Reptt: '',
			col5Reptt: '',
			col6Reptt: '',
			col7Reptt: '',
			col8Reptt: '',
			col9Reptt: '',
			defaultProps: {
				id: 'id',
				children: 'handbook_items'
			},
			tableHeader: [
				{
					label:
						'Наименование',
					prop:
						'name'
				},
				{
					label:
						'План на январь',
					prop:
						'value'
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
					a[
						attributeName
					][
						year
					] =
						yearValue *
						-1;
				}
				if (hasChild) {
					a[
						attributeName
					][
						year
					] = a.handbook_items.reduce(
						x,
						0
					);
				}
				return r + a[attributeName][year];
			}, 0);
		},

		getChangedColumnClass(obj) {
			if (obj.columnIndex > 4) {
				return 'reptt-column-blue reptt-cell';
			} else {
				return obj.columnIndex === 0 ? 'reptt-column-zero reptt-column reptt-cell' : 'reptt-column reptt-cell';
			}
		},

		hideEmptyValues: function(row, index) {
			if (row.row.plan_value[this.currentYear] === 0 && row.row.level !== 0) {
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
			data = data / 1000000000;
			data = data.toLocaleString();
			return data;
		}
	},
	updated() {
		this.col3Reptt = this.trans('economy_pf.repttTable.factZa') + ' \n' + this.yearLast + ' ' + this.trans('economy_pf.repttTable.year');
		this.col4Reptt = this.trans('economy_pf.repttTable.factZa') + ' \n' + this.day;
		this.col5Reptt = this.trans('economy_pf.repttTable.planNa') + ' \n' + this.yearNow;
		this.col6Reptt = this.trans('economy_pf.repttTable.plan') + ' \n' + this.trans('economy_pf.repttTable.sinceTheBeginningOfTheYear');
		this.col7Reptt = this.trans('economy_pf.repttTable.fact') + ' \n' + this.trans('economy_pf.repttTable.sinceTheBeginningOfTheYear');
		this.col8Reptt = this.trans('economy_pf.repttTable.absDeviation') + ' \n ' + this.trans('economy_pf.repttTable.sinceTheBeginningOfTheYear') + ', +/-';
		this.col9Reptt = this.trans('economy_pf.repttTable.relativeDeviation') + ' \n' + this.trans('economy_pf.repttTable.sinceTheBeginningOfTheYear') + ', %';
		let handbookKeys = [
			'plan_value',
			'fact_value',
			'intermediate_plan_value',
			'intermediate_fact_value'
		];
		handbookKeys.forEach((key) => {
			this.distributionSumOverTree(key, this.currentYear);
			this.distributionSumOverTree(key, this.previousYear);
		});
		this.$store.commit('globalloading/SET_LOADING', false);
	}
};
