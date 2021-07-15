import moment from "moment";

export default {
    data: function () {
        return {
            emergencyHistory: [],
            currentMonth: moment().month() + 1,
        };
    },
    methods: {
        async getEmergencyByMonth() {
            let queryOptions = {
                'currentMonth': this.currentMonth
            };

            let uri = this.localeUrl("/get-emergency-history");
            const response = await axios.get(uri,{params:queryOptions});
            if (response.status === 200) {
                return response.data;
            }
            return {};
        },
    }
}