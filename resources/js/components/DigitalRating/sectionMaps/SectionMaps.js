import axios from "axios";
import wellsData from '../json/dataWells.json';
import BtnDropdown from "../components/BtnDropdown";
import SettingModal from "../components/SettingModal";
import WellAtlasModal from "../components/WellAtlasModal";
import Accordion from "../components/Accordion";
import SearchFormRefresh from "../../ui-kit/SearchFormRefresh";
import mainMenu from "../../GTM/mock-data/main_menu.json";
import { legends, mapList, properties, horizons, fileActions, mapActions } from '../json/data';
import { digitalRatingState, digitalRatingMutations,globalloadingMutations } from '@store/helpers';
import maps from '../mixins/maps.js';

export default {
    name: "SectionMaps",

    components: {
        BtnDropdown,
        SettingModal,
        WellAtlasModal,
        Accordion,
        SearchFormRefresh
    },

    mixins: [maps],

    data() {
        return {
            horizons: horizons,
            maps: mapList,
            legends: legends,
            properties: properties,
            fileActions: fileActions,
            mapsActions: mapActions,
            parentType: '',
            menu: mainMenu,
            map: null,
            rectangle: null,
            searchSector: '',
            startPoint: null,
            endPoint: null,
            isRulerActive: false
        };
    },

    async mounted() {
        this.SET_LOADING(true);
        await this.initMap('map');
        await this.initSectorOnMap();
        this.SET_LOADING(false);
    },

    computed: {
        ...digitalRatingState(['horizonNumber'])
    },

    methods: {
        ...digitalRatingMutations([
          'SET_SECTOR', 'SET_HORIZON'
        ]),
        ...globalloadingMutations([
            'SET_LOADING'
        ]),

        async fetchMaps(horizonId) {
            try {
                const res = await axios.get(`${process.env.MIX_DIGITAL_RATING_MAPS}/maps/${horizonId}`);
                return res.data;
            } catch (error) {
                this.SET_LOADING(false);
                console.error(error);
            }
        },

        async initSectorOnMap() {
            const maps = await this.fetchMaps(this.horizonNumber);
            if(maps?.length === 0) return;
            for (let i = 0; i < maps.length; i++) {
                this.rectangle = L.rectangle(this.getBounds(maps[i]), {
                    renderer: this.renderer,
                    color: maps[i]['color'],
                    weight: 1,
                    fillColor: maps[i]['color'],
                    fillOpacity: 0.8,
                }).addTo(this.map).bindPopup(maps[i]['sector'].toString());

                this.rectangle.on('mouseover', function (e) {
                    this.openPopup();
                });
                this.rectangle.on('mouseout', function (e) {
                    this.closePopup();
                });
                this.rectangle.on('click', (e) => {
                    if(this.isRulerActive) {
                        this.onMeasureDistance(e);
                    } else {
                        this.onMapClick(maps[i]['sector']);
                    }
                });
            }
        },

        initWellOnMap() {
            for(let i = 0; i < wellsData.length; i++) {
                const coordinate = this.xy(wellsData[i]['x'], wellsData[i]['y']);
                this.setCircleMarker(coordinate, wellsData[i]['well']);
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
        async selectPanelItem(type, item) {
            this.map.remove();
            if(type === 'map' && item?.id === 1) {
                setTimeout(async() => {
                    this.initMap('map');
                    await this.initSectorOnMap();
                    this.initWellOnMap();
                }, 0);
            } else {
                this.SET_HORIZON(item?.id);
                setTimeout(async() => {
                    this.initMap('map');
                    await this.initSectorOnMap();
                }, 0);
            }
        },
        onSearchSector() {
            this.map.eachLayer(function(layer) {
                if (layer?._popup?._content === this.searchSector?.toString()) {
                    const {lat, lng} = layer._bounds?._northEast;
                    this.map.setView([lat, lng], -2);
                    layer.openPopup();
                }
            }, this);
        }
    },
}