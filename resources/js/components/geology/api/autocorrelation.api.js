import service from "../js/service";
export const Fetch_Autocorrelation = async (data)=> await service({url:`/wells/autocorrelation`, baseURL: "http://172.20.103.203:8620", method: 'post', data}).then((resp)=> resp);
