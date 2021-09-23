const getValueOrNoData = {
    methods: {
        getValueOrNoData(param) {
            return (_.isUndefined(param) || _.isNull(param)) ? this.trans('monitoring.no_data') : parseFloat(param).toFixed(2);
        }
    }
}

export default getValueOrNoData;