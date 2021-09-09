import NotifyPlugin from "vue-easy-notify";
import Multiselect from "vue-multiselect";
import { pgnoMapState, pgnoMapGetters, pgnoMapMutations, pgnoMapActions } from '@store/helpers';
import _ from 'lodash';

Vue.use(NotifyPlugin);

export default {
	components: {
		Multiselect,
	  },
	props: {"calcKpodTrigger": Boolean},
	data: function()  {
		return {
			settings: {},
			steelMark: null,
			steelMarks: null,
			isModal: false,
			kpodCalced: null,
			value: [],
			ql: Number,
			spm: Number,
			strokeLen: Number,
			pumpType: Number,
			diametersShgn: [
				{
					pumpType: 27,
					value: 27
				},
				{
					pumpType: 32,
					value: 32
				},
				{
					pumpType: 38,
					value: 38
				},
				{
					pumpType: 44,
					value: 44
				},
				{
					pumpType: 50,
					value: 50
				},
				{
					pumpType:57,
					value: 57
				},
				{
					pumpType: 60,
					value: 60
				},
				{
					pumpType: 70,
					value: 70
				},
				{
					pumpType: 95,
					value: 95
				},

			],
			steelMarksTypes: {
				"mediumCorrosion": [
					"20Н2М (Н)",
					"20Н2М (НсУ)", 
					"30ХМ(А) (НсУ)",
					"15НЗМА (НсУ)",
					"15Х2НМФ (НВО)",
					"15Х2ГМФ (НВО)",
					"14Х3ГМЮ (НВО)",
					"АЦ28ХГНЗФТ (О)",
				],
				"antiCorrosion": [
					"40 (Н)",
					"40 (НсУ)",
					"20Н2М (Н)",
					"20Н2М (НсУ)",
					"30ХМ(А) (НсУ)",
					"15НЗМА (НсУ)",
					"15Х2НМФ (НВО)",
					"15Х2ГМФ (НВО)",
					"14Х3ГМЮ (НВО)",
					"С (API)",
					"D (API)",
					"K (API)",
					"D super",
					"15Х2ГМФ-D-sup",
					"Ст-40(С)рем",
					"Ст-40(Д)рем",
					"20Н2М(D)рем",
					"30ХМА(D)рем",
					"15Х2ГМФ(D)рем",
					"15Х2МНФ(D)рем",
					"АЦ28ХГНЗФТ (О)"
				],
				"highCorrosion": [
					"15НЗМА (Н)",
					"АЦ28ХГНЗФТ (О)"
				]
			},
			kPodMode: true,
		}
	},
	computed: {
		...pgnoMapState([
      'well',
      'lines',
      'points',
	  	'curveSettings',
			'kPodSettings',
			'settingsMode'
    ]),
		...pgnoMapGetters([
      'steelMarkStore',
			'shgnSettings'
    ]),
	},
	methods: {
		...pgnoMapActions([
			'setKpodSettings',
			'setShgnSettings',
			'setDefaultShgnSettings'
		  ]),
		setNotify(message, title, type) {
				this.$bvToast.toast(message, {
					title: title,
					variant: type,
					solid: true,
					toaster: "b-toaster-top-center",
					autoHideDelay: 8000,
				});
		},
		onClick() {
			this.$modal.show('modalTable')
			this.isModal = true;
			this.$emit('myEvent', this.isModal);
      		this.$modal.hide('modalTable')
		},
		closeModal(modalName) {
			this.$modal.hide(modalName)
	  	},
		onClickI1() {
			this.$modal.show('modalTable2')
		},
		onClickI2() {
			this.$modal.show('modalTable3')
		},
		isStupColumnsNumber(val) {
			return (Number(this.settings.stupColumns) === val && this.settings.rodsTypes.length < val)
		},

		onSubmitParams(mode) {
			for (let i of [1,2,3]){
				if (this.isStupColumnsNumber(i)) {
						this.setNotify("Укажите необходимые диаметры штанг", "Warning", "warning")
						return
				}
			}			
			this.$store.commit('pgno/SET_SETTINGS_MODE', mode)
			if (mode === "getDefault"){
				this.setDefaultShgnSettings(this.settings)
			} else {
				this.setShgnSettings(this.settings)
			}
			this.setKpodSettings(this.kPodSettings)
			this.$emit('on-submit-params');
			this.$modal.show('tabs');
		},
		calKpod(){
			if (this.kPodSettings.ql) {
				this.kpodCalced = this.kPodSettings.ql / (1440 * 3.14 * this.kPodSettings.pumpType ** 2 * this.kPodSettings.strokeLen * (this.kPodSettings.spm / 4000000))
				if (this.kpodCalced < 0.4 || this.kpodCalced > 0.9) {
					var message = this.trans('pgno.kpodWarning', {kpod: this.kpodCalced.toFixed(2)}) 
					this.setNotify(message, "Warning", "warning")
				}
				this.settings.kPodCalced = this.kpodCalced
			}
		},
		onChangeCorrosion(e) {
			this.settings.corrosion = e.target.value
			this.settings.steelMark = this.steelMarkStore
			this.steelMarks = this.steelMarksTypes[this.settings.corrosion]
		}
	},
	created: function() {
		this.settings = _.cloneDeep(this.shgnSettings)
		this.settings.steelMark = this.steelMarkStore
		this.steelMarks = this.steelMarksTypes[this.settings.corrosion]
		this.calKpod()
	}
}