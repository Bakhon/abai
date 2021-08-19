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
