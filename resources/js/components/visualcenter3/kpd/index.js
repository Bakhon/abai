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
            corporateManager: [
                {
                    'name': null,
                    'title': null,
                    'avatar': null,
                    'year': moment().year()
                }
            ],
            managers: [],
            deputy: [],
            strategicKpdList: [],
            menuVisibility: {
                'strategic': true,
                'corporate': true,
                'manager': true,
                'deputy': false
            },
            managerType: undefined,
            corporateKpdWaiting: [125,100,125,125,125,100,125]
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
        getProgressBarFillingColor(kpd) {
            if (!kpd || (kpd && !kpd['fact'])) {
                return 'progress-bar_filling__high';
            }
            let fact = parseFloat(kpd.fact);
            let step = parseFloat(kpd.step);
            let target = parseFloat(kpd.target);
            let isDate = kpd.step.includes('.');
            if (isDate) {
                step = moment(kpd.step, 'DD.MM.YYYY').toDate().getTime();
                target = moment(kpd.target, 'DD.MM.YYYY').toDate().getTime();
            }

            if (fact < step) {
                return 'progress-bar_filling__low';
            } else if (fact >= step && fact < target) {
                return 'progress-bar_filling__medium';
            } else if (fact >= target) {
                return 'progress-bar_filling__high';
            }
        },
        switchManager(manager,type) {
            this.managerType = type;
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
        switchKpdVisibility(manager,managers) {
            manager['name'] = manager['name'] + ' ';
            manager['isSelected'] = !manager['isSelected'];
            _.forEach(managers, (item,index) => {
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
        fillKpdList(managers,type) {
            _.forEach(managers, (manager) => {
                manager['isSelected'] = false;
                let filteredKpd = _.filter(_.cloneDeep(this.kpdList), (kpd) => {
                    if (type === 'corporate') {
                        return kpd.type === type;
                    }
                    return parseInt(kpd.type) === manager.id;
                });
                manager['kpdList'] = filteredKpd;
                _.forEach(filteredKpd, (kpd,index) => {
                    let sorted = _.orderBy(kpd.kpd_fact, ['date'],['asc']);
                    if (sorted.length === 0) {
                        kpd.rating = 0;
                        kpd.summary = 0;
                        kpd.fact = 0;
                    } else {
                        kpd.fact = sorted.at(-1).fact;
                        if (kpd.fact.includes('.')) {
                            kpd.fact = moment(sorted.at(-1).fact, 'DD.MM.YYYY').toDate().getTime();
                        }
                        kpd.rating = Math.round(this.getKpdEfficiency(kpd.step,kpd.target,kpd.maximum,kpd.fact));
                        kpd.summary = kpd.rating * (kpd.weight / 100);
                    }
                    kpd['waiting'] = this.corporateKpdWaiting[index];
                    let elements = kpd.kpd_elements;
                    filteredKpd[index]['elements'] = kpd.kpd_elements;
                    delete filteredKpd[index]['kpd_elements'];
                });
                manager['fact'] = _.sumBy(filteredKpd, item => Number(item.summary));
                if (isNaN(manager['fact'])) {
                    manager['fact'] = moment(filteredKpd.at(-1).fact,'DD.MM.YYYY').toDate().getTime();
                }
            });
        },
        getKpdEfficiency(inputStep,inputTarget,inputMaximum,inputFact) {
            let fact = parseFloat(inputFact);
            let target = parseFloat(inputTarget);
            let maximum = parseFloat(inputMaximum);
            let step = parseFloat(inputStep);

            let isDate = inputStep.includes('.');
            if (isDate) {
                step = moment(inputStep, 'DD.MM.YYYY').toDate().getTime();
                target = moment(inputTarget, 'DD.MM.YYYY').toDate().getTime();
                maximum = moment(inputMaximum, 'DD.MM.YYYY').toDate().getTime();
            }

            if (fact < step) {
                return 5;
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
        },
        async updateData() {
            this.SET_LOADING(true);
            let corporateManager = await this.getCorporateManager();
            if (Object.keys(corporateManager).length > 0) {
                this.corporateManager = [corporateManager];
            }
            this.managers = await this.getAllManagers('manager');
            this.deputy = await this.getAllManagers('deputy');
            this.kpdList = await this.getAllKpd();
            this.strategicKpdList = this.getKpdByType('strategic');
            this.fillKpdList(this.managers);
            this.fillKpdList(this.deputy);
            this.fillKpdList(this.corporateManager,'corporate');
            this.SET_LOADING(false);
        },
        getCorporateSummaryWaiting() {
            return Math.round(_.sum(this.corporateKpdWaiting) / this.corporateKpdWaiting.length);
        }
    },
    async mounted() {
        await this.updateData();
        this.$watch(
            () => {
                if (this.$refs.kpdMonitoring) {
                    return this.$refs.kpdMonitoring.isOperationFinished
                }
            },
            async (update) => {
                if (update) {
                    await this.updateData();
                }
            }
        );
    },
    computed: {

    }
}