import NotifyPlugin from "vue-easy-notify";

Vue.use(NotifyPlugin);
export default {
	data: function()  {
		return {
			svgTableN1: require('../../../images/tableN1.svg'),
			svgTableN2: require('../../../images/tableN2.svg'),
			davMin: '30атм',
			groupPosad: 2,
			yakor: false,
			paker: false,
			hvostovik: false,
			heavyDown: 'heavy_down',
			stup: '2',
			dlinaPolki: '10м',
			gasMax: '10%',
			hvostovik: true,
			koroz: 'srednekor',
			h2s: false,
			lenMin: 2,
			lenMax: 3,
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
			markShtang: [],
			markShtangs: [
        		{
          		mValue: 1,
          		tempValue: "40 (Н)",
        		},
        		{
          		mValue: 2,
          		tempValue: "40 (НсУ)",
        		},
        		{
          		mValue: 3,
          		tempValue: "14Х3ГМЮ (НВО)",
        		},
        		{
          		mValue: 4,
          		tempValue: "15НЗМА (Н)",
        		},
        		{
          		mValue: 5,
          		tempValue: "15НЗМА (НсУ)",
        		},
        		{
          		mValue: 6,
          		tempValue: "15Х2ГМФ (НВО)",
        		},
				{
          		mValue: 7,
          		tempValue: "15Х2НМФ (НВО)",
        		},
				{
          		mValue: 8,
          		tempValue: "20Н2М (Н)",
        		},
				{
          		mValue: 9,
          		tempValue: "20Н2М (НсУ)",
        		},
				{
          		mValue: 10,
          		tempValue: "30ХМ(А) (НсУ)",
        		},
				{
          		mValue: 11,
          		tempValue: "АЦ28ХГНЗФТ (О)",
        		},
				],
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
	},
	methods: {
		setActiveOption(val) {
			this.$store.commit('UPDATE_MARKSHTANG', val)
		},
		onChangePump(event) {
			this.$store.commit("update", event.target.value)
		},
		closeModal(modalName) {
      		this.$modal.hide(modalName)
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
		onChangeKpod(event) {
			this.$store.commit("UPDATE_KPOD", event.target.value)
		},
		onChangeGroupPosad(event) {
			this.$store.commit("UPDATE_GROUP_POSAD", event.target.value)
		},
		

		onClick() {
			this.$modal.show('modalTable')
			this.isModal = true;
			this.$emit('myEvent', this.isModal);
      		this.$modal.hide('modalTable')
		},
		onClickI1() {
			this.$modal.show('modalTable2')
		},
		onClickI2() {
			this.$modal.show('modalTable3')
		},
		onSubmitParams() {
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
	}
}