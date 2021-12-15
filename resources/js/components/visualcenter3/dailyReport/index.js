import moment from "moment";
import {globalloadingMutations} from '@store/helpers';

export default {
    data: function () {
        return {
            productionByPeriods: {}
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
    },
    async mounted() {
        this.SET_LOADING(true);
        this.productionByPeriods = await this.getProductionForPeriods();
        this.SET_LOADING(false);
    },
}
