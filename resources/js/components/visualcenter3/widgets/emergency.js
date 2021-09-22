import moment from "moment";

export default {
    data: function () {
        return {
            emergencyHistory: [],
            currentMonth: moment().month() + 1,
            emergencyFinished: [],
            emergencyOpen: [],
            emergencyTable: [],
            isOpenActive: true
        };
    },
    methods: {
        async getEmergencyByMonth() {
            let queryOptions = {
                'currentMonth': this.currentMonth,
                'dzoName': this.getDzoTicker()
            };

            let uri = this.localeUrl("/get-emergency-history");
            const response = await axios.get(uri,{params:queryOptions});

            if (response.status === 200) {
                return response.data;
            }
            return {};
        },

        fillEmergencyByType() {
            this.emergencyFinished = _.filter(this.emergencyHistory, (item) => item.approved);
            this.emergencyOpen = _.filter(this.emergencyHistory, (item) => !item.approved);
            this.emergencyTable = this.emergencyOpen;
        }
    }
}