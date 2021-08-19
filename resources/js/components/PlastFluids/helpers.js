function createDataTree(dataset) {
  const tempHash = {};
  dataset.forEach(
    (aData) =>
      (tempHash[aData.owner_id] = {
        field_id: aData.owner_id,
        field_name: aData.owner_name,
      })
  );

  const fullDataset = [...dataset, ...Object.values(tempHash)];
  const hashTable = {};
  fullDataset.forEach((aData) => {
    if (undefined === (hashTable[aData.field_id] || {}).horizon_id)
      hashTable[aData.field_id] = { ...aData, childNodes: [] };
  });

  const dataTree = [];

  fullDataset.forEach((aData) => {
    if (aData.owner_id)
      hashTable[aData.owner_id].childNodes.push(hashTable[aData.field_id]);
    else dataTree.push(hashTable[aData.field_id]);
  });

  return dataTree;
}

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

function handleSearch(arrayForSearch, query) {
  const filtered = arrayForSearch.filter((item) =>
    item.field_name.toLowerCase().includes(query.toLowerCase()) ? item : ""
  );
  return filtered;
}

export { createDataTree, handleSearch, convertTemplateData };
