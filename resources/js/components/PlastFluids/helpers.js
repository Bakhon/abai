export default {
  createDataTree(dataset) {
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
      if(undefined === (hashTable[aData.field_id] || {}).horizon_id)
      hashTable[aData.field_id] = { ...aData, childNodes: [] };
    });

    const dataTree = [];

    fullDataset.forEach((aData) => {
      if (aData.owner_id)
        hashTable[aData.owner_id].childNodes.push(hashTable[aData.field_id]);
      else dataTree.push(hashTable[aData.field_id]);
    });

    return dataTree;
  },
};
