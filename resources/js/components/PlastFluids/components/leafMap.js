import L from "leaflet";
import {kzRegions} from "../plugins/global";
import RK from "../plugins/rk_border"
import {field} from "../plugins/field";
import "leaflet-control-geocoder/dist/Control.Geocoder.css";
import "leaflet/dist/leaflet.css";

const initMap = (click) => {
    let selectedPolygon;
    let targetPolygon;
    let zoomLevel;
    let polygonsLabelsSetting = {
        permanent: true,
        direction: "center",
        className: 'my-label'
    };

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

    let regionsGroup = new L.featureGroup();
    let fieldGroup = new L.featureGroup();
    let regionFieldGroup = new L.featureGroup();

    L.geoJson(RK, {style: {color: '#43487A', opacity: .3}}).addTo(map);
    L.geoJson(kzRegions, {onEachFeature, style: polygonsStyle}).addTo(map);
    L.geoJson(field, {onEachFeature, style: polygonsStyle}).addTo(map);

    toggleTooltips();
    map.on("zoomend moveend", ()=>{
        toggleTooltips()
    })

    function zoomToFeature(e) {
        let {target} = e;
        targetPolygon = target;
        zoomLevel = target.feature.properties?.type || null;
        selectedPolygon?.setStyle(polygonsStyle)
        click(e)
        bounds();
    }

    function bounds(){
        regionFieldGroup.clearLayers();
        if (selectedPolygon === targetPolygon) {
            selectedPolygon = zoomLevel = null;
            map.fitBounds(regionsGroup.getBounds())
        } else {
            selectedPolygon = targetPolygon;
            fieldGroup.eachLayer((layer)=>{
                if(targetPolygon.feature.properties.id === layer.feature.properties.region)
                    regionFieldGroup.addLayer(layer)
            })
            map.fitBounds(Object.entries(regionFieldGroup._layers).length?regionFieldGroup?.getBounds():targetPolygon?.getBounds())
            targetPolygon.setStyle({color: '#797ec9'})
        }
    }

    function toggleTooltips(){
        regionsGroup.eachLayer(layer => {
            if(targetPolygon !== layer||!selectedPolygon) layer.openTooltip()
            else layer.closeTooltip()
        })

        fieldGroup.eachLayer((layer)=>{
            if(zoomLevel === "region") layer.openTooltip()
            else layer.closeTooltip()
        })
    }

    function onEachFeature(feature, layer) {
        let type = feature.properties?.type;
        if (type === "region") {
            regionsGroup.addLayer(layer)
        }
        if(type === "field"){
            fieldGroup.addLayer(layer)
        }
        layer.bindTooltip(feature.properties.name, polygonsLabelsSetting)
        layer.on({
            click: zoomToFeature,
        });
    }
};

export default initMap;
