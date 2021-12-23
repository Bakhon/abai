import service from "../js/service";
export const Fetch_Autocorrelation = async (data)=> await service({url:`/wells/autocorrelation`, baseURL: process.env.MIX_MICROSERVICE_AUTOCORRELATION, method: 'post', data}).then((resp)=> resp);
