import service from "../js/service";
export const Fetch_Horizons = async (wellsIDS)=> await service(`/wells/horizons?well=${wellsIDS.join('&well=')}`);
