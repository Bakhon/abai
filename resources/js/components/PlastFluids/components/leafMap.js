import L from "leaflet";
import { lineJSON } from "../plugins/line";
import { pointJSON } from "../plugins/point";
import { nepaldataa } from "../plugins/nepaldata";
import { polygonJSON } from "../plugins/polygon";
import { statesData } from "../plugins/usstates";
import { kzStatesData } from "../plugins/global";
import geocoder from "../plugins/Control.Geocoder";
import "leaflet-control-geocoder/dist/Control.Geocoder.css";
import "leaflet/dist/leaflet.css";

const initMap = () => {
  let map = L.map("map").setView([47.78333, 67.76667], 5);
  let osm = L.tileLayer("http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}", {
    attribution:
      '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
  });
  osm.addTo(map);

  let singleMarker = L.marker([28.25255, 83.97669]);
  singleMarker.addTo(map);
  let popup = singleMarker.bindPopup("This is a popup");
  popup.addTo(map);

  let CartoDB_DarkMatter = L.tileLayer(
    "https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png",
    {
      attribution:
        '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
      subdomains: "abcd",
      maxZoom: 19,
    }
  );
  CartoDB_DarkMatter.addTo(map);

  // Google Map Layer

  let googleStreets = L.tileLayer(
    "http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}",
    {
      maxZoom: 20,
      subdomains: ["mt0", "mt1", "mt2", "mt3"],
    }
  );
  googleStreets.addTo(map);

  // Satelite Layer
  let googleSat = L.tileLayer(
    "http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}",
    {
      maxZoom: 20,
      subdomains: ["mt0", "mt1", "mt2", "mt3"],
    }
  );
  googleSat.addTo(map);

  let Stamen_Watercolor = L.tileLayer(
    "https://stamen-tiles-{s}.a.ssl.fastly.net/watercolor/{z}/{x}/{y}.{ext}",
    {
      attribution:
        'Map tiles by <a href="http://stamen.com">Stamen Design</a>, <a href="http://creativecommons.org/licenses/by/3.0">CC BY 3.0</a> &mdash; Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
      subdomains: "abcd",
      minZoom: 1,
      maxZoom: 16,
      ext: "jpg",
    }
  );
  // Stamen_Watercolor.addTo(map);

  let linedata = L.geoJSON(lineJSON.lineJSON).addTo(map);
  let pointdata = L.geoJSON(pointJSON).addTo(map);
  // let nepalData = L.geoJSON(nepaldataa).addTo(map);
  let polygondata = L.geoJSON(polygonJSON, {
    onEachFeature: function(feature, layer) {
      layer.bindPopup("<b>This is a </b>" + feature.properties.name);
    },
    style: {
      fillColor: "red",
      fillOpacity: 1,
      color: "green",
    },
  }).addTo(map);

  let baseLayers = {
    Satellite: googleSat,
    "Google Map": googleStreets,
    // "Water Color": Stamen_Watercolor,
    OpenStreetMap: osm,
  };

  let overlays = {
    Marker: singleMarker,
    PointData: pointdata,
    LineData: linedata,
    PolygonData: polygondata,
  };

  L.control.layers(baseLayers, overlays).addTo(map);

  L.Control.geocoder().addTo(map);

  L.geoJSON(kzStatesData).addTo(map);

  function getColor(d) {
    return d > 1000
      ? "#800026"
      : d > 500
      ? "#BD0026"
      : d > 200
      ? "#E31A1C"
      : d > 100
      ? "#FC4E2A"
      : d > 50
      ? "#FD8D3C"
      : d > 20
      ? "#FEB24C"
      : d > 10
      ? "#FED976"
      : "#43487A";
  }

  function style(feature) {
    return {
      fillColor: getColor(feature.properties.density),
      weight: 2,
      opacity: 1,
      color: "white",
      dashArray: "3",
      fillOpacity: 0.7,
    };
  }

  L.geoJson(kzStatesData, { style: style }).addTo(map);

  function highlightFeature(e) {
    let layer = e.target;

    layer.setStyle({
      weight: 5,
      color: "#666",
      dashArray: "",
      fillOpacity: 0.7,
    });

    if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
      layer.bringToFront();
    }

    info.update(layer.feature.properties);
  }

  function resetHighlight(e) {
    geojson.resetStyle(e.target);
    info.update();
  }

  let geojson;
  geojson = L.geoJson(kzStatesData);

  function zoomToFeature(e) {
    map.fitBounds(e.target.getBounds());
  }

  function onEachFeature(feature, layer) {
    layer.on({
      mouseover: highlightFeature,
      mouseout: resetHighlight,
      click: zoomToFeature,
    });
  }

  geojson = L.geoJson(kzStatesData, {
    style: style,
    onEachFeature: onEachFeature,
  }).addTo(map);

  let info = L.control();

  info.onAdd = function(map) {
    this._div = L.DomUtil.create("div", "info"); // create a div with a class "info"
    info.update();
    return this._div;
  };

  info.addTo(map);

  let legend = L.control({ position: "bottomright" });

  legend.onAdd = function(map) {
    let div = L.DomUtil.create("div", "info legend"),
      grades = [0, 10, 20, 50, 100, 200, 500, 1000],
      labels = [];

    // loop through our density intervals and generate a label with a colored square for each interval
    for (let i = 0; i < grades.length; i++) {
      div.innerHTML +=
        '<i style="background:' +
        getColor(grades[i] + 1) +
        '"></i> ' +
        grades[i] +
        (grades[i + 1] ? "&ndash;" + grades[i + 1] + "<br>" : "+");
    }

    return div;
  };

  legend.addTo(map);
};

export default initMap;
