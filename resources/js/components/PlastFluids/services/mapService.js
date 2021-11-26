export const getTableData = async (postData, url) => {
  try {
    const response = await axios.post(
      `${process.env.MIX_PLAST_FLUIDS_API}/api/${url}`,
      postData
    );
    return response.data;
  } catch (error) {
    throw error;
  }
};

export const getMapOwners = async () => {
  try {
    const response = await axios.get(
      `${process.env.MIX_PLAST_FLUIDS_API}/api/map/owners-pivot`
    );
    return response.data.data_for_map;
  } catch (error) {
    console.log(error);
  }
};

export const getSubsoilCounters = async (payload) => {
  try {
    const response = await axios.post(
      `${process.env.MIX_PLAST_FLUIDS_API}/api/home/counters`,
      payload
    );
    return response.data;
  } catch (error) {
    console.log(error);
  }
};

export const getInitialMapNGP = async () => {
  try {
    const response = await axios.get(
      `${process.env.MIX_PLAST_FLUIDS_API}/api/home/map/ngp`
    );
    return response.data;
  } catch (error) {
    console.log(error);
  }
};

export const getMapDataByField = async (fieldId) => {
  const payload = new FormData();
  payload.append("geo_parent_id", fieldId);
  try {
    const response = await axios.post(
      `${process.env.MIX_PLAST_FLUIDS_API}/api/home/map/geo-childs`,
      payload
    );
    return response.data;
  } catch (error) {
    console.log(error);
  }
};

export const getMapGeoJSONCoords = async (payload) => {
  try {
    const response = await axios.post(
      `${process.env.MIX_PLAST_FLUIDS_API}/api/home/map/geojson`,
      payload
    );
    return response.data;
  } catch (error) {
    console.log(error);
  }
};

export const createIsohypsumModel = async (payload) => {
  try {
    const response = await axios.post(
      `${process.env.MIX_PLAST_FLUIDS_API}/api/map/isogyps`,
      payload
    );
    return response;
  } catch (error) {
    console.log(error);
  }
};

export const getModels = async (payload) => {
  try {
    const params = new URLSearchParams();
    payload.forEach((horizonID) => params.append("horizon_id", horizonID));
    const response = await axios.get(
      `${process.env.MIX_PLAST_FLUIDS_API}/api/map/isogyps`,
      { params }
    );
    return response.data;
  } catch (error) {
    console.log(error);
  }
};

export const getModelIsohypses = async (payload) => {
  try {
    const response = await axios.get(
      `${process.env.MIX_PLAST_FLUIDS_API}/api/map/isogyps-json`,
      { params: payload }
    );
    return response.data;
  } catch (error) {
    console.log(error);
  }
};

export const getModelWells = async (payload) => {
  try {
    const response = await axios.get(
      `${process.env.MIX_PLAST_FLUIDS_API}/api/map/isogyps-wells`,
      { params: payload }
    );
    return response.data;
  } catch (error) {
    console.log(error);
  }
};

export const getModelWellsProperties = async (payload) => {
  try {
    const response = await axios.post(
      `${process.env.MIX_PLAST_FLUIDS_API}/api/map/isogyps-wells-menu`,
      payload
    );
    return response.data.well_menu;
  } catch (error) {
    console.log(error);
  }
};
