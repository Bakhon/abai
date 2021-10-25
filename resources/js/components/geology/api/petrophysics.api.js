import service from "../js/service";

export const Fetch_DZOS = async () => await service('/dzos/');
export const Fetch_Fields = async (id) => await service(`/fields/?organization_id=${id}`);
export const Fetch_Wells = async (id, limit = 2000) => await service(`/fields/${id}/wells?limit=${limit}`);
export const Fetch_WellsMnemonics = async (ids) => await service(`/wells/mnemonics?well=${ids.join('&well=')}`);
export const Fetch_Curves = async (ids) => await service(`/wells/curves?curve_id=${ids.join('&curve_id=')}`);
