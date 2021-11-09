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

export const getIsohypsumModel = async (payload) => {
  try {
    const response = await axios.get(
      `${process.env.MIX_PLAST_FLUIDS_API}/api/map/isogyps`,
      { params: { horizon_id: payload } }
    );
    return response.data;
  } catch (error) {
    console.log(error);
  }
};

export const getIsohypsumModelCoords = async (payload) => {
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
