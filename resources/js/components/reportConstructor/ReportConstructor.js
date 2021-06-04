import download from "downloadjs";
import moment from 'moment';
import {Datetime} from 'vue-datetime';
import Vue from "vue";

Vue.use(Datetime)

export default {
    props: [
        'params'
    ],
    components: {},
    data() {
        return {
            baseUrl: 'http://127.0.0.1:8092/',
            structureTypes: {
                org: null,
                tech: null,
                geo: null
            },
            currentStructureType: 'geo',
            items: [],
            isLoading: false,
        }
    },
    mounted: function () {
        this.$nextTick(function () {
            this.$store.commit('globalloading/SET_LOADING', false);
        });
        this.loadStructureTypes('geo');
        this.loadStructureTypes('tech');
        this.loadStructureTypes('org');
    },
    methods: {
        loadStructureTypes(type) {
            let uri = this.baseUrl + "get_structures_types/?structure_type=" + type;
            this.isLoading = true
            this.axios.get(uri, {
                responseType: 'json',
                headers: {
                    'Content-Type': 'application/json'
                }
            }).then((response) => {
                if (response.data) {
                    this.structureTypes[type] = response.data
                } else {
                    console.log("No data");
                }
                this.isLoading = false;
            }).catch((error) => {
                console.log(error)
                this.isLoading = false
            });

        },
        loadItems(itemId) {
            let uri = this.baseUrl + "get_items/?"
                + "structure_type=" + this.currentStructureType
                + "&item_type=" + itemId;
            this.isLoading = true
            this.axios.get(uri, {
                responseType: 'json',
                headers: {
                    'Content-Type': 'application/json'
                }
            }).then((response) => {
                if (response.data) {
                    this.items = response.data
                } else {
                    console.log("No data");
                }
                this.isLoading = false;
            }).catch((error) => {
                console.log(error)
                this.isLoading = false
            });

        },
        debug2(msg) {
            console.log(msg)
        }
    }
}
