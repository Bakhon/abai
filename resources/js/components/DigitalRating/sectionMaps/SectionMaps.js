import axios from "axios";
import BtnDropdown from "../components/BtnDropdown";
import SettingModal from "../components/SettingModal";
import WellAtlasModal from "../components/WellAtlasModal";
import Accordion from "../components/Accordion";
import SearchFormRefresh from "../../ui-kit/SearchFormRefresh";
import mainMenu from "../../GTM/mock-data/main_menu.json";
import { mapList, properties, horizons, fileActions, mapActions } from '../json/data';
import { digitalRatingState, digitalRatingMutations,globalloadingMutations } from '@store/helpers';
import maps from '../mixins/maps.js';
import L from "leaflet";

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
            legends: [],
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
            isRulerActive: false,
            selectedMaps: [],
        };
    },

    async mounted() {
        this.SET_LOADING(true);
        await this.initMap('map');
        await this.getLegends();
        await this.initSectorOnMap();
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
                this.SET_LOADING(false);
                return res.data;
            } catch (error) {
                this.SET_LOADING(false);
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

        async initCurrentProdOnMap() {
            const horizonNumber = this.horizonNumber;
            const res = await axios.get(`${process.env.MIX_DIGITAL_RATING_MAPS}/maps/current-prod/${horizonNumber}`);
        },

        async initCumulativeProdOnMap() {
            const horizonNumber = this.horizonNumber;
            const res = await axios.get(`${process.env.MIX_DIGITAL_RATING_MAPS}/maps/cumulative-prod/${horizonNumber}`);
            const cum_prod = res?.data?.cum_prod;
            if (cum_prod?.length) {
                function fakeData() {
                    return [Math.random(), Math.random()];
                }
                console.log('fakeData', fakeData())
                console.log('data', [cum_prod[0].oil, cum_prod[0].water])
                // const myBarChart = L.minichart([85000, 52000], {
                //     data: fakeData(),
                //     type: 'pie',
                //     width: 40,
                //     height: 40,
                //     labels: ['Test1', 'Test2']
                // });
                //
                // this.map.addLayer(myBarChart);
                // for (let i = 0; i < cum_prod.length; i++) {
                //     let cumProdChart = L.minichart([cum_prod[i].x, cum_prod[i].y], {
                //         // renderer: L.canvas({ padding: 0.5 }),
                //         data: [cum_prod[i].oil, cum_prod[i].water],
                //         type: 'pie',
                //         width: cum_prod[i].r,
                //         height: cum_prod[i].r,
                //         labels: ['Test1', 'Test2']
                //     });
                //     this.map.addLayer(cumProdChart);
                // }
            }
        },

        async initDrilledOnMap() {
            const horizonNumber = this.horizonNumber;
            const res = await axios.get(`${process.env.MIX_DIGITAL_RATING_MAPS}/maps/drilled-fond/${horizonNumber}`);
            if (!res.data?.length) return;

            for (let i = 0; i < res.data.length; i++) {
                const coordinate = this.xy(res.data[i]['x'], res.data[i]['y']);
                this.setCircleMarker(coordinate, res.data[i]['well']);
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

        async handleSelectHorizon(horizon) {
            this.SET_LOADING(true);
            this.SET_HORIZON(horizon?.id);
            this.map.remove();
            this.selectedMaps = [];
            setTimeout(async() => {
                this.initMap('map');
                await this.initSectorOnMap();
            }, 0);
        },

        handleSelectMap(map) {
            if (this.selectedMaps.includes(map.id)) return;
            this.selectedMaps.push(map.id);
            if (map.id === 1) {
                this.initDrilledOnMap();
            } else if (map.id === 2) {
                this.initCurrentProdOnMap();
            } else {
                this.initCumulativeProdOnMap();
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
        },

        async getLegends() {
            try {
                const res = await axios.get(`${process.env.MIX_DIGITAL_RATING_MAPS}/legend`);
                this.legends = res.data;
            } catch (error) {}
        }
    },
}