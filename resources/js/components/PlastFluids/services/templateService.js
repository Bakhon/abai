import translation from "../../../VueTranslation/Translation";

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

export const downloadUserReport = async (postData) => {
  try {
    const response = await axios.post(
      `${process.env.MIX_PLAST_FLUIDS_API}/api/templates/download-report-file`,
      postData,
      {
        responseType: "blob",
      }
    );
    return response;
  } catch (error) {
    throw error;
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
    if (error.response.status === 409 && error.response.data.description)
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

export const getHorizonBlocks = async (postData) => {
  try {
    const response = await axios.post(
      `${process.env.MIX_PLAST_FLUIDS_API}/api/reports/horizons-blocks`,
      postData
    );
    return response.data.data;
  } catch (error) {
    alert(error);
  }
};

export const getUploadTemplates = async (postData) => {
  try {
    const response = await axios.post(
      `${process.env.MIX_PLAST_FLUIDS_API}/api/reports/user-templates`,
      postData
    );
    return response.data;
  } catch (error) {
    console.log(error);
  }
};

export const getTemplateData = async (postData) => {
  try {
    const response = await axios.post(
      `${process.env.MIX_PLAST_FLUIDS_API}/api/reports/table-report`,
      postData
    );
    if (response.status === 204)
      throw translation.translate("plast_fluids.no_report_content");
    return response.data;
  } catch (error) {
    throw error;
  }
};

export const getTemplateFile = async (postData) => {
  try {
    const response = await axios.post(
      `${process.env.MIX_PLAST_FLUIDS_API}/api/reports/file-report`,
      postData,
      {
        responseType: "blob",
      }
    );
    return response.data;
  } catch (error) {
    alert(error);
  }
};

export const saveCustomTemplate = async (postData) => {
  try {
    const response = await axios.post(
      `${process.env.MIX_PLAST_FLUIDS_API}/api/reports/custom-template-save`,
      postData
    );
    return response.data;
  } catch (error) {
    throw error;
  }
};

export const deleteCustomTemplate = async (postData) => {
  try {
    const response = await axios.post(
      `${process.env.MIX_PLAST_FLUIDS_API}/api/reports/custom-template-delete`,
      postData
    );
    return response.data;
  } catch (error) {
    throw error;
  }
};
