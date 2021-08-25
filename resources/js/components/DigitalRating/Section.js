import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import mapsData from './json/test_grid.json';
import wellsData from './json/dataWells.json';
import BtnDropdown from "./components/BtnDropdown";
import SettingModal from "./components/SettingModal";
import WellAtlasModal from "./components/WellAtlasModal";
import Accordion from "./components/Accordion";
import mainMenu from "../GTM/mock-data/main_menu.json";

export default {
    name: "Sections",

    components: {
        BtnDropdown,
        SettingModal,
        WellAtlasModal,
        Accordion,
    },

    data() {
        return {
            objects: ['Объект 1', 'Объект 2'],
            maps: ['Скважина', 'Накопленные отборы'],
            cods: ['1', '2', '3'],
            properties: ['Значок', 'Шрифт', 'Палитра'],
            fileActions: [
                { title: 'digital_rating.import', icon: 'upload', type: 'import'  },
                { title: 'digital_rating.export', icon: 'download', type: 'export' },
                { title: 'digital_rating.save', icon: 'save', type: 'save' }
            ],
            mapsActions: [
                { title: 'digital_rating.uploadCustomMaps', icon: 'share', type: 'upload' },
                { title: 'digital_rating.importPlannedWells', icon: 'upload', type: 'importWells' }
            ],
            parentType: '',
            menu: mainMenu,
            map: null,
            rectangle: null,
            marker: null,
            bounds: [[0, 15000], [0,15000]],
            center: [85000, 52000],
            zoom: -5,
            minZoom: -10,
            maxZoom: 1,
            renderer: L.canvas({ padding: 0.5 }),
        };
    },

    async mounted() {
        await this.initMap();
        await this.initSectorOnMap();
    },

    methods: {
        initMap() {
            this.map = L.map('map', {
                crs: L.CRS.Simple,
                zoomControl: false,
                minZoom: this.minZoom,
                maxZoom: this.maxZoom,
            });
            L.control.zoom({
                position: 'bottomright'
            }).addTo(this.map);
            this.map.fitBounds(this.bounds);
            this.map.setView( this.center, this.zoom);
        },

        initSectorOnMap() {
            for (let i = 0; i < mapsData.length; i++) {
                this.rectangle = L.rectangle(this.getBounds(mapsData[i]), {
                    renderer: this.renderer,
                    color: mapsData[i]['color'],
                    weight: 3,
                    fillColor: mapsData[i]['color'],
                    fillOpacity: 1,
                }).addTo(this.map).bindPopup(mapsData[i]['sector'].toString());

                this.rectangle.on('mouseover', function (e) {
                    this.openPopup();
                });
                this.rectangle.on('mouseout', function (e) {
                    this.closePopup();
                });
                this.rectangle.on('click', (e) => {
                    this.onMapClick();
                })
            }
        },

        initWellOnMap() {
            for(let i = 0; i < wellsData.length; i++) {
                const coordinate = this.xy(wellsData[i]['x'], wellsData[i]['y']);
                this.marker = L.circleMarker(coordinate,{
                    renderer: this.renderer,
                    color: '#000',
                    opacity: 1,
                    weight: 1,
                    fillColor: '#000',
                    fillOpacity: 0,
                    radius: 5,
                }).addTo(this.map).bindPopup(wellsData[i]['well']);

                this.marker.on('mouseover', function (e) {
                    this.openPopup();
                });
            }
        },

        getBounds(item) {
            const coordinateStart = this.xy(item['x1'], item['y1']);
            const coordinateEnd = this.xy(item['x2'], item['y2']);
            return [[coordinateStart], [coordinateEnd]];
        },

        xy(x, y) {
            let yx = L.latLng;
            if (L.Util.isArray(x)) {
                return yx(x[1], x[0]);
            }
            return yx(y, x);
        },
        onMapClick() {
            this.$modal.show('modalAtlas');
        },
        closeAtlasModal() {
            this.$modal.hide('modalAtlas');
        },
        openSettingModal() {
            this.$modal.show('modalSetting');
        },
        closeSettingModal() {
            this.$modal.hide('modalSetting');
        },
        menuClick(data) {
            const path = window.location.pathname.slice(3);
            if (data?.url && data.url !== path) {
                window.location.href = this.localeUrl(data.url);
            }
        },
        async selectPanelItem(item) {
            if(item === 'Скважина') {
                this.initWellOnMap();
            } else {
                document.location.reload();
            }
        }
    },
}