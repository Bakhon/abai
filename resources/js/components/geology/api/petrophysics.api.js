import service from "../js/service";

export const Fetch_DZOS = async () => await service('/dzos/');
export const Fetch_Fields = async (id) => await service(`/fields/?organization_id=${id}`);
export const Fetch_Wells = async (id, limit = 500) => await service(`/fields/${id}/wells?limit=${limit}`);
export const Fetch_WellsMnemonics = async (ids) => await service(`/wells/mnemonics?well_id=${[1037, 1038, 1337].join('&&well_id=')}`); // TODO Переделать под api.
