import L from "leaflet";
import {kzRegions} from "../plugins/global";
import RK from "../plugins/rk_border"
import "leaflet-control-geocoder/dist/Control.Geocoder.css";
import "leaflet/dist/leaflet.css";

const initMap = () => {
    let selectedRegion;
    console.log(L)
    let mapSettings = {
        scrollWheelZoom: false,
        dragging: false,
        doubleClickZoom: false,
        boxZoom: false,
        zoomControl: false
    }
    let polygonsStyle = {
        fillColor: "#43487A",
        color: '#5c6090',
        fillOpacity: 1
    }
    let map = L.map("map", mapSettings).setView([47.78333, 67.76667], 5);
    let layersGroup = new L.featureGroup([]);
    L.geoJson(RK, {
        style: {
            color: '#43487A',
            opacity: .3
        }
    }).addTo(map);
    L.geoJson(kzRegions, {onEachFeature, style: polygonsStyle}).addTo(map);

    function zoomToFeature({target}) {
        selectedRegion?.setStyle(polygonsStyle)
        if (selectedRegion === target) {
            selectedRegion = null;
            map.fitBounds(layersGroup.getBounds())
        } else {
            selectedRegion = target;
            target.setStyle({color: '#797ec9'})
            map.fitBounds(target.getBounds());
        }
    }

    function onEachFeature(feature, layer) {
        layersGroup.addLayer(layer)
        layer.bindTooltip(layer.feature.properties?.name, {permanent: true, direction:"center", className: 'my-label'})
        layer.on({
            click: zoomToFeature,
        });
    }
};

export default initMap;
