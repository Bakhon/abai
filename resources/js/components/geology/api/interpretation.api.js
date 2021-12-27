import service from "../js/service";
export const Post_Interpretation = async (data)=> await service({
    url:`/wells/autointerpretation`,
    baseURL: process.env.MIX_MICROSERVICE_AUTOCORRELATION,
    method: 'post',
    data
});

export const Get_InterpretationStatus = async (id)=> await service({
    url:`/wells/autointerpretation/${id}`,
    baseURL: process.env.MIX_MICROSERVICE_AUTOCORRELATION,
    method: 'get'
});
