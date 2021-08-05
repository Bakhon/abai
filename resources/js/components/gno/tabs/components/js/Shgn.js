import NotifyPlugin from "vue-easy-notify";
import Multiselect from "vue-multiselect";

Vue.use(NotifyPlugin);
export default {
	components: {
		Multiselect,
	  },
	props: {"qLInput": Number,
		"strokeLenDev": Number, 
		"spm": Number,
		"pumpType": Number},
	data: function()  {
		return {
			svgTableN1: require('../../../images/tableN1.svg'),
			svgTableN2: require('../../../images/tableN2.svg'),
			pintakeMin: null,
			groupPosad: null,
			stup: "2",
			inclStep: null,
			gasMax: null,
			hvostovik: true,
			corrosion: null,
			strokeLenMin: null,
			strokeLenMax: null,
			spmMin: null,
			spmMax: null,
			kpodMin: null,
			isModal: false,
			kpodCalced: null,
			value: [],
			pumpTypeKpod: this.pumpType,
			qLInputKpod: this.qLInput,
			strokeLenDevKpod: this.strokeLenDev,
			spmKpod: this.spm,
			markShtangs: null,
			mechSep: null,
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
			selectedKomponovka: [],
			komponovkaTypes: [
				{
					id: 1,
					name: this.trans('pgno.yakor_truboderzhatel'),
					value: 'yakor',
					disabled: false,
					checked: true
				},
				{
					id: 2,
					name: this.trans('pgno.paker'),
					value: 'paker',
					disabled: false,
					checked: false
				},
				{
					id: 3,
					name: this.trans('pgno.hvostovik'),
					value: 'hvostovik',
					disabled: false,
					checked: false
				},

			],
			markShtang: [],
			markShtangsTypes: {
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
					"АЦ28ХГНЗФТ (О)",
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
		setNotify(message, type) {
      this.$notify({
        message: message,
        type: type,
        size: 'sm',
        timeout: 8000
      })
    },
		updateBoxes(selectedKomponovka) {
			if(selectedKomponovka.includes('paker')) {
				this.komponovkaTypes[0].disabled = true
				this.komponovkaTypes[2].disabled = true
			} else if (this.selectedKomponovka.includes('hvostovik')) {
				this.komponovkaTypes[1].disabled = true
			} else if(this.selectedKomponovka.includes('hvostovik', 'yakor')) {
				this.komponovkaTypes[1].disabled = true
			} else if(this.selectedKomponovka.includes('yakor')) {
				this.selectedKomponovka.push('hvostovik')
				this.komponovkaTypes[1].disabled = true
			} else if(this.selectedKomponovka.length === 0) {
				this.komponovkaTypes[0].disabled = false
				this.komponovkaTypes[1].disabled = false
				this.komponovkaTypes[2].disabled = false
			}
			this.$store.dispatch('setKomponovka', this.selectedKomponovka)
		},
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
			if (this.corrosion === "highCorrosion" || this.corrosion === "mediumCorrosion" ) {
				this.markShtang = []
			} else {
				this.markShtang = this.$store.getters.markShtang
			}
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
		calKpod(){
			if (this.qLInput) {
				this.kpodCalced = Number(((this.qLInputKpod / (1440 * 3.14 * this.pumpTypeKpod ** 2 * this.strokeLenDevKpod * (this.spmKpod / 4000000)))).toFixed(2))
				this.$store.commit('UPDATE_KPOD_CALCED', this.kpodCalced)
				if (this.kpodCalced < 0.4 || this.kpodCalced > 0.9) {
					var message = `${this.trans('pgno.kpod_warning_start')} ${this.kpodCalced.toFixed(2)} ${this.trans('pgno.kpod_warning_end')}`
					this.setNotify(message, "warning")
				}
			}
		},
		setKpodMode() {
			this.$store.commit('UPDATE_KPOD_MODE', this.kPodMode) 
		},
	},
	created: function() {
		this.mechSep = this.$store.getters.mechSep
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
		this.kPodMode = this.$store.getters.kPodMode
		this.kpodCalced = this.$store.getters.kPodCalced
		this.calKpod()
	}
}