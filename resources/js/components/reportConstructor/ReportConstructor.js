import {Datetime} from 'vue-datetime';
import {bTreeView} from "bootstrap-vue-treeview";
import Vue from "vue";

Vue.use(Datetime)
Vue.use(bTreeView)

export default {
    props: [
        'params'
    ],
    components: {},
    data() {
        return {
            baseUrl: process.env.MIX_MICROSERVICE_USER_REPORTS,
            structureTypes: {
                org: null,
                tech: null,
                geo: null
            },
            attributeDescriptions: null,
            attributesForObject: null,
            currentStructureType: 'geo',
            currentStructureId: null,
            currentItemType: null,
            items: [],
            isLoading: false,
            isDisplayParameterBuilder: false,
        }
    },
    mounted: function () {
        this.$nextTick(function () {
            this.$store.commit('globalloading/SET_LOADING', false);
        });
        for (let structureType in this.structureTypes) {
            this.loadStructureTypes(structureType);
        }
        this.loadAttributeDescriptions()
    },
    methods: {
        loadStructureTypes(type) {
            this.isLoading = true
            this.axios.get(this.baseUrl + "get_structures_types", {
                params: {
                    structure_type: type
                },
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
        loadAttributeDescriptions() {
            this.isLoading = true
            this.axios.get(this.baseUrl + "get_object_attributes_descriptions", {
                responseType: 'json',
                headers: {
                    'Content-Type': 'application/json'
                }
            }).then((response) => {
                this.attributeDescriptions = response.data
            }).catch((error) => {
                console.log(error)
            }).finally(() => {
                this.isLoading = false
            });

        },
        loadAttributesForSelectedObject() {
            this.isLoading = true
            this.axios.get(this.baseUrl + "get_object_attributes", {
                params: {
                    structure_type: this.currentStructureType,
                    structure_id: this.currentStructureId
                },
                responseType: 'json',
                headers: {
                    'Content-Type': 'application/json'
                }
            }).then((response) => {
                this.attributesForObject = response.data
            }).catch((error) => {
                console.log(error)
            }).finally(() => {
                this.isLoading = false
            });
        },
        loadItems(itemType) {
            this.isLoading = true
            this.axios.get(this.baseUrl + "get_items", {
                params: {
                    structure_type: this.currentStructureType,
                    item_type: itemType
                },
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
            }).catch((error) => {
                console.log(error)
            }).finally(() => {
                this.isLoading = false
            });

        },
        setCurrentStructureId(structureId) {
            this.currentStructureId = structureId.toString()
            this.loadAttributesForSelectedObject();
        },
        getAttributeDescription(descriptionField) {
            let fieldParts = descriptionField.split(".")
            if (fieldParts.length !== 3) {
                return descriptionField
            }
            let table = fieldParts[0] + "." + fieldParts[1]
            if (!(table in this.attributeDescriptions)) {
                return descriptionField
            }
            let fieldName = fieldParts[2]
            return this.attributeDescriptions[table][fieldName]
        }
    }
}
