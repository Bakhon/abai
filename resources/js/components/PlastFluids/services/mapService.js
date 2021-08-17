import axios from "axios";

export const getMapOwners = async () => {
  try {
    const response = await axios.get(
      "http://172.20.103.51:8000/api/map/owners"
    );
    return response.data.data_for_map;
  } catch (error) {
    console.log(error);
  }
};
