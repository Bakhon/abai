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
            },
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
        },
        switchKpdVisibility(manager) {
            manager['name'] = manager['name'] + ' ';
            manager['isSelected'] = !manager['isSelected'];
            _.forEach(this.managers, (item,index) => {
                if (item.id !== manager.id) {
                    item['isSelected'] = false;
                }
            });
            _.forEach(manager.kpdList, (item) => {
                item.isVisible = !item.isVisible;
            });
        },
        getManagerKpdList(managerId) {
            let filtered = _.filter(this.kpdList, (kpd) => {
                return parseInt(kpd.type) === managerId;
            });
            _.forEach(filtered, (item) => {
                item.isVisible = false;
            })
            return filtered;
        },
        fillKpdList(managers) {
            _.forEach(managers, (manager) => {
                manager['isSelected'] = false;
                let filteredKpd = _.filter(_.cloneDeep(this.kpdList), (kpd) => {
                    return parseInt(kpd.type) === manager.id;
                });
                manager['kpdList'] = filteredKpd;
                _.forEach(filteredKpd, (kpd) => {
                    let sorted = _.orderBy(kpd.kpd_fact, ['date'],['asc']);
                    if (sorted.length === 0) {
                        kpd.rating = 0;
                        kpd.summary = 0;
                    } else {
                        kpd.rating = this.getKpdEfficiency(kpd.step,kpd.target,kpd.maximum,sorted.at(-1).fact);
                        kpd.summary = Math.round(kpd.rating * (kpd.weight / 100));
                    }
                });
                manager['fact'] = _.sumBy(filteredKpd, 'summary');
            });
        },
        getKpdEfficiency(step,target,maximum,fact) {
            if (fact < step) {
                return 0;
            }
            if (fact === step) {
                return 50;
            }
            if (fact > step && fact < target) {
                return (fact - step) / (target - step) * 50 + 50;
            }
            if (fact === target) {
                return 100;
            }
            if (fact > target && fact < maximum) {
                return (fact - target) / (maximum - target) * 25 + 100;
            }
            if (fact >= maximum) {
                return 125;
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
        if (this.corporateManager.id) {
            this.corporateKpdList = this.getKpdByType(this.corporateManager.id.toString());
        }
        this.fillKpdList(this.managers);
        this.SET_LOADING(false);
    },
    computed: {

    }
}