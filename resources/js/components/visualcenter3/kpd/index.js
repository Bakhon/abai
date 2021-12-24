import moment from "moment";
import Vue from "vue";
import {globalloadingMutations} from '@store/helpers';

Vue.component('kpd-modal-documents', require('./modalDocuments.vue').default);
Vue.component('kpd-modal-catalog', require('./modalCatalog.vue').default);
Vue.component('kpd-modal-map', require('./modalMap.vue').default);
Vue.component('kpd-modal-monitoring', require('./modalMonitoring.vue').default);
Vue.component('kpd-modal-kpd-edit', require('./modalEditKpd.vue').default);
Vue.component('modal-settings', require('./modalSettings.vue').default);
Vue.component('modal-corporate-manager', require('./modalCorporateManager.vue').default);
Vue.component('modal-manager', require('./modalManager.vue').default);

export default {
    data: function () {
        return {
            currentYear: moment().year(),
            selectedManager: {},
            selectedKpd: {},
            kpdList: [],
            corporateManager: {
                'name': null,
                'title': null,
                'avatar': null,
                'year': moment().year()
            },
            managers: [],
            deputy: [],
            strategicKpdList: [],
            corporateKpdList: [],
            menuVisibility: {
                'strategic': true,
                'corporate': true,
                'manager': true,
                'deputy': false
            }
        };
    },
    methods: {
        async getCorporateManager() {
            let uri = this.localeUrl("/get-kpd-corporate-manager");
            const response = await axios.get(uri);
            if (response.status !== 200) {
                return [];
            }
            return response.data;
        },
        async getAllManagers(type) {
            let uri = this.localeUrl("/get-kpd-managers");
            const response = await axios.get(uri,{params:{'type':type}});
            if (response.status !== 200) {
                return [];
            }
            return response.data;
        },
        async getAllKpd() {
            let uri = this.localeUrl("/kpd-tree-catalog");
            const response = await axios.get(uri);
            if (response.status !== 200) {
                return [];
            }
            return response.data;
        },
        getKpdByType(type) {
            let kpdList = [];
            _.forEach(this.kpdList, (kpd) => {
                if (kpd.type === type) {
                    kpdList.push(kpd);
                }
            });
            return kpdList;
        },
        getProgressBarFillingColor(progress) {
            if (progress <= 70) {
                return 'progress-bar_filling__medium';
            } else if (progress > 70) {
                return 'progress-bar_filling__high';
            }
        },
        switchManager(manager) {
            this.selectedManager = manager;
            this.$modal.show('modalMonitoring');
        },
        ...globalloadingMutations([
            'SET_LOADING'
        ]),
        switchMenuVisiblity(item) {
            this.menuVisibility[item] = !this.menuVisibility[item];
            if (item === 'manager' && this.menuVisibility[item]) {
                this.menuVisibility['deputy'] = false;
            }
            if (item === 'deputy' && this.menuVisibility[item]) {
                this.menuVisibility['manager'] = false;
            }
        }
    },
    async mounted() {
        this.SET_LOADING(true);
        let corporateManager = await this.getCorporateManager();
        if (Object.keys(corporateManager).length > 0) {
            this.corporateManager = corporateManager;
        }
        this.managers = await this.getAllManagers('manager');
        this.deputy = await this.getAllManagers('deputy');
        this.selectedManager = this.kpdDecompositionA;
        this.kpdList = await this.getAllKpd();
        this.strategicKpdList = this.getKpdByType('strategic');
        this.corporateKpdList = this.getKpdByType(this.corporateManager.id.toString());
        this.SET_LOADING(false);
    },
    computed: {
        thirdDecompositionStyles() {
            let height = Math.round(780 / (this.managers.length) + this.managers.length) + 'px';
            return {'height':height};
        },
        strategicDecompositionStyles() {
            let height = Math.round(780 / (this.strategicKpdList.length) - (this.strategicKpdList.length * 2)) + 'px';
            return {'height':height};
        },
        corporateDecompositionStyles() {
            let height = Math.round(780 / (this.corporateKpdList.length) - (this.corporateKpdList.length * 2)) + 'px';
            return {'height':height};
        }
    }
}