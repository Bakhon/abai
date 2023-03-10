export const convertTemplateData = (dataset, lang) => {
  const hash = {};
  dataset.forEach((template) => {
    hash[template["type_" + lang]] = {
      name: template["type_" + lang],
      childNodes: [],
    };
  });
  dataset.forEach((template) =>
    hash[template["type_" + lang]].childNodes.push(template)
  );

  const dataTree = Object.values(hash);
  return dataTree;
};

export const handleSearch = (arrayForSearch, query, key) => {
  const filtered = arrayForSearch.filter((item) =>
    item[key].toLowerCase().includes(query?.toLowerCase()) ? item : ""
  );
  return filtered;
};

export const between = (x, min, max) => {
  return x >= min && x <= max;
};

export const convertToFormData = (convertObject) => {
  const postData = new FormData();
  for (let key in convertObject) {
    if (!Array.isArray(convertObject[key])) {
      postData.append(key, convertObject[key]);
    } else {
      convertObject[key].forEach((item) => postData.append(key, item));
    }
  }
  return postData;
};

export const downloadExcelFile = (fileName, fileContent) => {
  let link = document.createElement("a");

  link.download = `${fileName}.xlsx`;
  const blob = new Blob([fileContent], {
    type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
  });

  link.href = URL.createObjectURL(blob);
  link.click();
};

export const compareNumbers = (a, b) => a - b;
