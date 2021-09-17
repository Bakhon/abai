import {FETCH_GIS_DATA, SET_GIS_DATA, SET_WELL_NAME, SET_SELECTED_WELL_CURVES, ADD_BLOCK, SET_SCROLL_BLOCK_Y} from "./geologyGis.const";
import {uuidv4} from "../../components/geology/petrophysics/graphics/awGis/utils/utils";
import AwGisClass from "../../components/geology/petrophysics/graphics/awGis/utils/AwGisClass";

const geologyGis = {
    state: {
        gisDataCurves: {},
        gisData: {},
        wellName: null,
        selectedGisCurves: [],
        awGis: new AwGisClass(),
        gisWells: [],
        blocksScrollY: 0
    },
    mutations: {
        [SET_SCROLL_BLOCK_Y](state, y) {
            state.blocksScrollY = y;
        },
        [SET_GIS_DATA](state, data) {
            state.gisDataCurves = data.curves.reduce((acc, curr) => {
                acc[curr.mnemonic] = curr.curve.filter(item => +item)
                return acc
            }, {});
            state.gisData = mapGisData(data);
        },

        [SET_WELL_NAME](state, wellName) {
            state.wellName = wellName;
        },

        [SET_SELECTED_WELL_CURVES](state, arr) {
            state.selectedGisCurves = arr;
        },

        [ADD_BLOCK](state, blockName) {
            let well = state.gisWells.findIndex((w) => w.name === blockName);
            let addedData = {name: blockName, id: uuidv4()}
            if (~well) state.gisWells.splice(well, 1);
            else state.gisWells.push(addedData);
        },
    },
    actions: {
        async [FETCH_GIS_DATA]({commit}) {
            await fetch("/js/json/geology_demo/curve.json").then(async (res) => {
                commit(SET_GIS_DATA, await res.json());
            });
        }
    }
}

function mapGisData(data) {
    return {
        ...data,
        curves: data.curves.map(item => ({
            id: uuidv4(), // TODO переделать под api
            name: item?.mnemonic,
            value: item?.mnemonic,
            iconType: 'oilTower',
            iconFill: '#FF6600',
            isOpen: true,
            children: [
                {
                    name: item?.mnemonic,
                    value: item?.mnemonic,
                    id: uuidv4(), // TODO переделать под api
                }
            ]
        }))
    }
}

export default geologyGis;
