export const getGraphApproximation = async (postData) => {
  try {
    const response = await axios.post(
      `${process.env.MIX_PLAST_FLUIDS_API}/api/analytics/approximation`,
      postData
    );
    return response.data;
  } catch (error) {
    console.log(error);
  }
};

export const getCorrelations = async () => {
  try {
    const response = await axios.get(
      `${process.env.MIX_PLAST_FLUIDS_API}/api/analytics/correlations`
    );
    return response.data;
  } catch (error) {
    console.log(error);
  }
};

export const getCorrelationData = async (postData) => {
  try {
    const response = await axios.post(
      `${process.env.MIX_PLAST_FLUIDS_API}/api/analytics/correlations`,
      postData
    );
    return response.data;
  } catch (error) {
    console.log(error);
  }
};
