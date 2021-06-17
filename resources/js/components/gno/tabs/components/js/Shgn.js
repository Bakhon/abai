import NotifyPlugin from "vue-easy-notify";

Vue.use(NotifyPlugin);
export default {
	data: function()  {
		return {
			svgTableN1: require('../../../images/tableN1.svg'),
			svgTableN2: require('../../../images/tableN2.svg'),
			pintakeMin: 30,
			groupPosad: 2,
			stup: "2",
			inclStep: 10,
			gasMax: 10,
			hvostovik: true,
			corrosion: 'mediumCorrosion',
			strokeLenMin: 2,
			strokeLenMax: 3,
			spmMin: 3,
			spmMax: 8,
			kpodMin: 0.6,
			isModal: false,
			pumpCheckboxes: [
				{
					id: 1,
					value: 27
				},
				{
					id: 2,
					value: 32
				},
				{
					id: 3,
					value: 38
				},
				{
					id: 4,
					value: 44
				},
				{
					id: 5,
					value: 50
				},

				],
			markShtang: "30ХМ(А) (НсУ)",
			markShtangsTypes: {
				"mediumCorrosion": [
					{mValue: "20Н2М (Н)",
					tempValue: "20Н2М (Н)"},
				  	{mValue: "20Н2М (НсУ)",
					tempValue: "20Н2М (НсУ)"},
					{mValue: "30ХМ(А) (НсУ)",
					tempValue: "30ХМ(А) (НсУ)"},
					{mValue: "15НЗМА (НсУ)",
					tempValue: "15НЗМА (НсУ)"},
					{mValue: "15Х2НМФ (НВО)",
					tempValue: "15Х2НМФ (НВО)"},
					{mValue: "15Х2ГМФ (НВО)",
					tempValue: "15Х2ГМФ (НВО)"},
					{mValue: "14Х3ГМЮ (НВО)",
					tempValue: "14Х3ГМЮ (НВО)"},
					{mValue: "АЦ28ХГНЗФТ (О)",
					tempValue: "АЦ28ХГНЗФТ (О)"}
				],
				"antiCorrosion": [
					{mValue: "40 (Н)",
					tempValue: "40 (Н)"},
					{mValue: "40 (НсУ)",
					tempValue: "40 (НсУ)"},
					{mValue: "20Н2М (Н)",
					tempValue: "20Н2М (Н)"},
					{mValue: "20Н2М (НсУ)",
					tempValue: "20Н2М (НсУ)"},
					{mValue: "30ХМ(А) (НсУ)",
					tempValue: "30ХМ(А) (НсУ)"},
					{mValue: "15НЗМА (НсУ)",
					tempValue: "15НЗМА (НсУ)"},
					{mValue: "15Х2НМФ (НВО)",
					tempValue: "15Х2НМФ (НВО)"},
					{mValue: "15Х2ГМФ (НВО)",
					tempValue: "15Х2ГМФ (НВО)"},
					{mValue: "14Х3ГМЮ (НВО)",
					tempValue: "14Х3ГМЮ (НВО)"},
					{mValue: "АЦ28ХГНЗФТ (О)",
					tempValue: "АЦ28ХГНЗФТ (О)"}
				],
				"highCorrosion": [
					{mValue: "15НЗМА (Н)",
					tempValue: "15НЗМА (Н)"},
					{mValue: "АЦ28ХГНЗФТ (О)",
					tempValue: "АЦ28ХГНЗФТ (О)"}
				]
				}
		}
	},
	computed: {
		dmPumps: {
			get() {
				return this.$store.getters.dmPumps;
			},
			set(val) {
				this.$store.dispatch('setDmPumps', val)
			}	
		},
		dmRods: {
			get() {
				return this.$store.getters.dmRods
			},
			set(val) {
				this.$store.dispatch('setDmRods', val)
			}
		},
		komponovka: {
			get() {
				return this.$store.getters.komponovka
			},
			set(val) {
				this.$store.dispatch('setKomponovka', val)
			}
		},
		h2s: {
			get() {
				return this.$store.getters.h2s
			},
			set(val) {
				this.$store.dispatch('setH2S', val)
			}
		},
		heavyDown: {
			get() {
				return this.$store.getters.heavyDown
			},
			set(val) {
				this.$store.dispatch('setheavyDown', val)
			}
		},
	},
	methods: {
		setActiveOption(val) {
			this.$store.commit('UPDATE_MARKSHTANG', val)
		},
		onChangePump(event) {
			this.$store.commit("update", event.target.value)
		},
		onChangeSpmMin(event) {
			this.$store.commit("UPDATE_SPM_MIN", event.target.value)
		},
		onChangeSpmMax(event) {
			this.$store.commit("UPDATE_SPM_MAX", event.target.value)
		},
		onChangeLenMin(event) {
			this.$store.commit("UPDATE_LEN_MIN", event.target.value)
		},
		onChangeLenMax(event) {
			this.$store.commit("UPDATE_LEN_MAX", event.target.value)
		},
		onChangePintakeMin(event) {
			this.$store.commit("UPDATE_PINTAKE_MIN", event.target.value)
		},
		onChangeGasMax(event) {
			this.$store.commit("UPDATE_GAS_MAX", event.target.value)
		},
		onChangeInclStep(event) {
			this.$store.commit("UPDATE_INCL_STEP", event.target.value)
		},
		onChangeKpod(event) {
			this.$store.commit("UPDATE_KPOD", event.target.value)
		},
		onChangeGroupPosad(event) {
			this.$store.commit("UPDATE_GROUP_POSAD", event.target.value)
		},
		onChangeCorrosion(event) {
			this.$store.commit("UPDATE_CORROSION", event.target.value)
			this.markShtangs = this.markShtangsTypes[this.corrosion]
		},
		onChangeStupColumns(event) {
			this.$store.commit("UPDATE_STUP_COLUMNS", event.target.value)
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
		onSubmitParams() {
			this.$store.commit('UPDATE_MARKSHTANG', this.markShtang) 
			this.$emit('on-submit-params');
			this.$modal.show('tabs');
		},
	},
	created: function() {
		this.spmMin = this.$store.getters.spmMin
    	this.spmMax = this.$store.getters.spmMax
    	this.strokeLenMin = this.$store.getters.strokeLenMin
    	this.strokeLenMax = this.$store.getters.strokeLenMax
    	this.kpodMin = this.$store.getters.kpodMin
		this.groupPosad = this.$store.getters.groupPosad
		this.komponovka = this.$store.getters.komponovka
		this.dmRods = this.$store.getters.dmRods
		this.stupColumns = this.$store.getters.stupColumns
		this.h2s = this.$store.getters.h2s
		this.heavyDown = this.$store.getters.heavyDown
		this.corrosion = this.$store.getters.corrosion
		this.pintakeMin = this.$store.getters.pintakeMin
		this.gasMax = this.$store.getters.gasMax
		this.inclStep = this.$store.getters.inclStep
		this.markShtang = this.$store.getters.markShtang
		this.markShtangs = this.markShtangsTypes[this.corrosion]
	}
}