import axios from "axios";

export const getTableGraphData = async (postData) => {
  try {
    const response = await axios.post(
      `${process.env.MIX_PLAST_FLUIDS_API}/api/analytics/pvt-r-o-r-c`,
      postData
    );
    return response.data;
  } catch (error) {
    console.log(error.response);
  }
};
