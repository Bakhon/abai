import moment from "moment";
import {globalloadingMutations} from '@store/helpers';

export default {
    data: function () {
        return {
            productionByPeriods: {},
            previousMonth: moment().month(),
            currentDate: moment().format('DD.MM.YYYY'),
            previousMonthName: moment().format('MMMM'),
            currentYear: moment().year(),
            menu: {
                'daily': true,
                'monthly': false,
                'yearly': false
            }
        }
    },
    methods: {
       async getProductionForPeriods() {
            let queryOptions = {
                'date': moment().subtract(1,'days').startOf('day').format()
            };
           const response = await axios.get(this.localeUrl('get-daily-report-production'),{params:queryOptions});
            return response.data;
        },
        async handleExcelDownload() {
            this.SET_LOADING(true);
            let uri = this.localeUrl("/daily-report-export");
            const response = await axios.get(uri,{'params': this.productionByPeriods,responseType:'arraybuffer'});
            this.SET_LOADING(false);
            let fileName = `Суточная информация по добыче нефти и конденсата НК КМГ_${moment().format('DD MM YY')} г.xlsx`;
            var fileURL = window.URL.createObjectURL(new Blob([response.data]));
            var fileLink = document.createElement('a');
            fileLink.href = fileURL;
            fileLink.setAttribute('download', fileName);
            document.body.appendChild(fileLink);
            fileLink.click();
        },
        ...globalloadingMutations([
            'SET_LOADING'
        ]),
        getFormattedNumber(num) {
            return (new Intl.NumberFormat("ru-RU").format(Math.round(num)))
        },
        getColorBy(index) {
           if (index % 2 === 0) {
               return 'dzo-row__light';
           }
            return 'dzo-row__dark';
        },
        switchView(name) {
           this.menu = _.mapValues(this.menu, () => false);
           this.menu[name] = true;
        }
    },
    async mounted() {
        this.SET_LOADING(true);
        this.productionByPeriods = await this.getProductionForPeriods();
        this.SET_LOADING(false);
    },
}
