import service from "../js/service";
export const Fetch_FaciesClassification = async ([well, model])=> await service({
    url:`/wells/facies_classification`,
    baseURL: process.env.MIX_MICROSERVICE_AUTOCORRELATION,
    method: 'get',
    params:{
        well,
        model
    }
})
