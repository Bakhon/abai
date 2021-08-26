const getValueOrNoData = {
    methods: {
        getValueOrNoData(param) {
            return (typeof param == 'undefined' || param == null) ? this.trans('monitoring.no_data') : param;
        }
    }
}

export default getValueOrNoData;