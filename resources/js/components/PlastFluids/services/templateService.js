import axios from "axios";

export const getDownloadTemplates = async () => {
  try {
    const response = await axios.get(
      `${process.env.MIX_PLAST_FLUIDS_API}/api/templates/report-templates`
    );
    return response.data.report;
  } catch (error) {
    console.log(error);
  }
};

export const downloadTemplate = async (postData) => {
  try {
    const response = await axios.post(
      `${process.env.MIX_PLAST_FLUIDS_API}/api/templates/report-template-file-download`,
      postData,
      {
        responseType: "blob",
      }
    );
    return response;
  } catch (error) {
    console.log(error);
  }
};

export const uploadTemplate = async (postData) => {
  try {
    const response = await axios.post(
      `${process.env.MIX_PLAST_FLUIDS_API}/api/templates/report-upload`,
      postData
    );
    return response.data;
  } catch (error) {
    return error.response.data;
  }
};

export const getTemplateHistory = async (postData) => {
  try {
    const response = await axios.post(
      `${process.env.MIX_PLAST_FLUIDS_API}/api/templates/upload-monitoring`,
      postData
    );
    return response.data;
  } catch (error) {
    console.log(error);
  }
};
