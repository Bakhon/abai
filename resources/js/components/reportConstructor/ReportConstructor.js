import {Datetime} from 'vue-datetime';
import 'vue-datetime/dist/vue-datetime.css';
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
            baseUrl: 'http://localhost:8092/',
            showOptions: true,
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
            currentOption: null,
            statistics: null,
            statisticsColumns: null,
            items: [],
            isLoading: false,
            isDisplayParameterBuilder: false,
            startDate: null,
            endDate: null,
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
        handleMenuClick(currentStructureType, btnClass) {
            this.currentStructureType = currentStructureType;
            $('.left-section-title').removeClass('active');
            $(btnClass).addClass('active');
        },
        onClickOption(structureType) {
            this.showOptions = false;
            this.currentOption = structureType
            this.currentItemType = structureType.id
        },
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
        },
        updateStatistics() {
            this.loadStatistics()
            this.statisticsColumns = this.getStatisticsColumnNames(this.attributesForObject)
        },
        loadStatistics() {
            this.statistics = null;
            let jsonData = JSON.stringify({
                "fields": this.attributesForObject,
                "joins": [["dict.well_type.id", "dict.well.well_type"]],
                // TODO when dates will work:
                //  "dates" : [""]
            })
            this.axios.post(this.baseUrl + "get_statistics", jsonData, {
                responseType: 'json',
                headers: {
                    'Content-Type': 'application/json'
                }
            }).then((response) => {
                this.statistics = response.data
            }).catch((error) => {
                console.log(error)
            }).finally(() => {
                this.isLoading = false
            });

        },
        getStatisticsColumnNames(attributes){
            let columns = []
            for ( let attribute of attributes){
                if ('children' in attribute) {
                    columns = columns.concat(this.getStatisticsColumnNames(attribute['children']))
                } else {
                    columns.push(attribute['label'])
                }
            }
            return columns
        },
    }
}
