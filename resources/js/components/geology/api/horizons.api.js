import service from "../js/service";
export const Fetch_Horizons = async (wellsIDS)=> await service(`/wells/horizons?well=${wellsIDS.join('&well=')}`);
export const Post_Horizons = async (data)=> await service({
    url: `/wells/horizons`,
    method: 'post',
    data
}).then((resp)=> resp).catch(e=>{
    return e;
})
