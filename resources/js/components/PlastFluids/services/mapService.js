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

export const getInitialMapNPG = async () => {
  try {
    const response = await axios.get(
      `${process.env.MIX_PLAST_FLUIDS_API}/api/home/map/npg`
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
