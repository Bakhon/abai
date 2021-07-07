export function init() {
    setMap();
}

function setMap() {
    loadData();
}

function loadData() {
    queue()
        .defer(d3.json, "https://raw.githubusercontent.com/FrontenderMagazine/d3js-map-visualization/master/src/data/topoworld.json")  // карта в topoJSON-формате
        .defer(d3.csv, "https://raw.githubusercontent.com/FrontenderMagazine/d3js-map-visualization/master/src/data/freedom.csv")  // данные о свободе слова в cvs-формате
        .await(processData);  // обработка загруженных данных
}

function processData(error, worldMap, countryData) {
    if (error) return console.error(error);
    console.log(worldMap);
    console.log(countryData);
}
