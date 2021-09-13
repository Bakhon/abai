import L from 'leaflet';
import { Minichart } from 'leaflet.minichart';
import 'leaflet/dist/leaflet.css';
import wellsData from './json/dataWells.json';
import BtnDropdown from "./components/BtnDropdown";
import SettingModal from "./components/SettingModal";
import WellAtlasModal from "./components/WellAtlasModal";
import Accordion from "./components/Accordion";
import mainMenu from "../GTM/mock-data/main_menu.json";
import { legends, maps, properties, objects, fileActions, mapActions } from './json/data';
import { digitalRatingState, digitalRatingMutations } from '@store/helpers';

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
            objects: objects,
            maps: maps,
            legends: legends,
            properties: properties,
            fileActions: fileActions,
            mapsActions: mapActions,
            parentType: '',
            menu: mainMenu,
            map: null,
            rectangle: null,
            marker: null,
            bounds: [[0, 15000], [0,15000]],
            center: [85000, 52000],
            zoom: -6,
            minZoom: -6,
            maxZoom: 0,
            renderer: L.canvas({ padding: 0.5 }),
        };
    },

    async mounted() {
        await this.initMap();
        await this.initSectorOnMap();
    },

    computed: {
        ...digitalRatingState(['horizonNumber'])
    },

    methods: {
        ...digitalRatingMutations(['SET_SECTOR', 'SET_HORIZON']),

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

        async initSectorOnMap() {
            const maps = await import(`./json/grid_${this.horizonNumber}.json`).then(module => module.default);
            if(maps?.length === 0) return;
            for (let i = 0; i < maps.length; i++) {
                this.rectangle = L.rectangle(this.getBounds(maps[i]), {
                    renderer: this.renderer,
                    color: maps[i]['color'],
                    weight: 3,
                    fillColor: maps[i]['color'],
                    fillOpacity: 1,
                }).addTo(this.map).bindPopup(maps[i]['sector'].toString());

                this.rectangle.on('mouseover', function (e) {
                    this.openPopup();
                });
                this.rectangle.on('mouseout', function (e) {
                    this.closePopup();
                });
                this.rectangle.on('click', (e) => {
                    this.onMapClick(maps[i]['sector']);
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
                    radius: 3,
                }).addTo(this.map).bindPopup(wellsData[i]['well']);

                this.marker.on('mouseover', function (e) {
                    this.openPopup();
                });
            }
        },

        initChartOnMap() {
            function fakeData() {
                return [Math.random(), Math.random()];
            }

            const myBarChart = L.minichart([85000, 52000], {
                data: fakeData(),
                type: 'pie',
                width: 40,
                height: 40,
                labels: ['Test1', 'Test2']
            });

            this.map.addLayer(myBarChart);
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
        onMapClick(sector) {
            this.SET_SECTOR(sector);
            this.$bvModal.show('modalAtlas');
        },
        closeAtlasModal() {
            this.$bvModal.hide('modalAtlas');
        },
        openSettingModal() {
            this.$bvModal.show('modalSetting');
        },
        closeSettingModal() {
            this.$bvModal.hide('modalSetting');
        },
        menuClick(data) {
            const path = window.location.pathname.slice(3);
            if (data?.url && data.url !== path) {
                window.location.href = this.localeUrl(data.url);
            }
        },
        async selectPanelItem(type, item) {
            if(type === 'map' && item?.id === 1) {
                this.initWellOnMap();
            } else {
                this.map.remove();
                this.SET_HORIZON(item?.id);
                setTimeout(async() => {
                    this.initMap();
                    await this.initSectorOnMap();
                }, 0);
            }
        }
    },
}