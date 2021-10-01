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
    if (error.response.status === 409 && error.response.data.Template)
      return error.response.data;
    throw error;
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

export const getUploadTemplates = async () => {
  try {
    const response = await axios.get(
      `${process.env.MIX_PLAST_FLUIDS_API}/api/templates/download-report-templates`
    );
    return response.data.report;
  } catch (error) {
    console.log(error);
  }
};

export const getTemplateData = async (
  payload,
  url = "/reservoir-oil-study-of-samples"
) => {
  try {
    const response = await axios.post(
      `${process.env.MIX_PLAST_FLUIDS_API}/api/reports${url}`,
      payload
    );
    return response.data;
  } catch (error) {
    throw error;
  }
};
