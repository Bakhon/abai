import NotifyPlugin from "vue-easy-notify";
import Multiselect from "vue-multiselect";
import { pgnoMapState, pgnoMapGetters, pgnoMapMutations, pgnoMapActions } from '@store/helpers';

Vue.use(NotifyPlugin);

export default {
	components: {
		Multiselect,
	  },
	data: function()  {
		return {
			settings: {},
			svgTableN1: require('../../../../images/tableN1.svg'),
			svgTableN2: require('../../../../images/tableN2.svg'),
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
	  'shgnSettings',
	  'curveSettings'
    ]),
		...pgnoMapGetters([
      'steelMarkStore',
    ]),
	},
	methods: {
		...pgnoMapActions([
			'setShgnSettings',
		  ]),
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
		onSubmitParams() {
			this.setShgnSettings(this.settings)
			this.$emit('on-submit-params');
			this.$modal.show('tabs');
		},
		calKpod(){
			if (this.ql) {
				this.kpodCalced = this.ql / (1440 * 3.14 * this.pumpType ** 2 * this.strokeLen * (this.spm / 4000000))
				this.$store.commit('pgno/UPDATE_KPOD_CALCED', this.kpodCalced) 
			}
		},
		onChangeCorrosion(e) {
			this.settings.corrosion = e.target.value
			this.settings.steelMark = this.steelMarkStore
			this.steelMarks = this.steelMarksTypes[this.settings.corrosion]
		}


	},
	created: function() {
		this.settings =this.shgnSettings
		this.settings.steelMark = this.steelMarkStore
		this.steelMarks = this.steelMarksTypes[this.settings.corrosion]
		this.pumpType = this.well.pumpType
		this.spm = this.well.spm
		this.strokeLen = this.well.strokeLen
		this.ql = this.curveSettings.qLInput
		this.calKpod()

	}
}