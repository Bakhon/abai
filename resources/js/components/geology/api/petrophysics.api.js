import service from "../js/service";

export const Fetch_DZOS = async () => await service('/dzos/');
export const Fetch_Fields = async (id) => await service(`/fields/?organization_id=${id}`);
export const Fetch_Wells = async (id, limit = 500) => await service(`/fields/${id}/wells?limit=${limit}`);
