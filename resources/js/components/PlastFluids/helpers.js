function convertTemplateData(dataset, lang) {
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
}

function handleSearch(arrayForSearch, query, type) {
  let name = "owner_name";
  if (type === "field") name = "field_name";
  const filtered = arrayForSearch.filter((item) =>
    item[name].toLowerCase().includes(query?.toLowerCase()) ? item : ""
  );
  return filtered;
}

export { handleSearch, convertTemplateData };
