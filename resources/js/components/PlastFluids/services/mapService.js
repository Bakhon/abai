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
