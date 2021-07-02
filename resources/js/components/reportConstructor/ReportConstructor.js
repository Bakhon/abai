import {Datetime} from 'vue-datetime';
import {bTreeView} from "bootstrap-vue-treeview";
import Vue from "vue";
import 'vue-datetime/dist/vue-datetime.css';
import {formatDate} from "../common/FormatDate";
import download from "downloadjs";

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
            selectedObjects: [],
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
                    structure_subtype: this.currentStructureSubType
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
        setCurrentStructure(structureId, structureSubType) {
            this.currentStructureId = structureId.toString()
            this.currentStructureSubType = structureSubType
            this.isDisplayParameterBuilder = false
            this.loadAttributesForSelectedObject();
        },
        getAttributeDescription(descriptionField) {
            if (!(this.isActualAttribute(descriptionField))) {
                return descriptionField
            }
            let fieldParts = descriptionField.split(".")
            let table = fieldParts[0] + "." + fieldParts[1]
            if (!(table in this.attributeDescriptions)) {
                return descriptionField
            }
            let fieldName = fieldParts[2]
            if (!(fieldName in this.attributeDescriptions[table])) {
                return fieldName
            }
            return this.attributeDescriptions[table][fieldName]
        },
        isActualAttribute(field) {
            let fieldParts = field.split(".")
            return fieldParts.length === 3
        },
        updateStatistics() {
            this.loadStatistics()
            let selectedAttributes = this.getSelectedAttributes()
            this.statisticsColumns = this.getStatisticsColumnNames(selectedAttributes)
        },
        loadStatistics() {
            this.statistics = null;

            try {
                this.validateStatisticsParams()
            } catch (e) {
                this.showToast(e.name, e.message, 'danger', 10000)
                return
            }
            let jsonData = this._getStatisticsRequestParams()
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
        validateStatisticsParams() {
            if (this.selectedObjects.length === 0) {
                throw new Error("Не выбраны объекты для отображения")
            }
            if (this.getSelectedAttributes().length === 0) {
                throw new Error("Не выбраны поля для отображения")
            }
        },
        getSelectedAttributes() {
            let allSelectedAttributes = this._getAllSelectedAttributes(this.attributesForObject)
            allSelectedAttributes = this._cleanEmptyHeadersOfAttributes(allSelectedAttributes)
            return allSelectedAttributes
        },
        _getAllSelectedAttributes(attributes) {
            let selectedAttributes = []
            for (let attribute of attributes) {
                if ('isChecked' in attribute && attribute.isChecked) {
                    let newAttribute = {
                        label: attribute['label']
                    }
                    if ('children' in attribute && attribute.children.length > 0) {
                        newAttribute.children = this._getAllSelectedAttributes(attribute.children)
                    }
                    selectedAttributes.push(newAttribute)
                }
            }
            return selectedAttributes
        },
        _cleanEmptyHeadersOfAttributes(attributes) {
            let cleanAttributes = []
            for (let attribute of attributes) {
                if (this.isActualAttribute(attribute.label)) {
                    cleanAttributes.push({'label': attribute.label})
                }
                if (!('children' in attribute) || attribute.children.length === 0) {
                    continue
                }
                let cleanChildren = this._cleanEmptyHeadersOfAttributes(attribute.children)
                if (cleanChildren.length > 0) {
                    attribute.children = cleanChildren
                    cleanAttributes.push(attribute)
                }
            }
            return cleanAttributes
        },
        _getStatisticsRequestParams() {
            return JSON.stringify({
                "fields": this.getSelectedAttributes(),
                "selectedObjects": this.selectedObjects,
                "structureType": this.currentStructureType,
                "dates": this.getDates()
            })
        },
        getDates() {
            let dates = []
            if (this.startDate) {
                dates.push(formatDate.getMinOfDayFormatted(this.startDate))
            } else {
                dates.push(null)
            }
            if (this.endDate) {
                dates.push(formatDate.getMaxOfDayFormatted(this.endDate))
            } else {
                dates.push(null)
            }
            return dates
        },
        getStatisticsColumnNames(attributes) {
            let columns = []
            for (let attribute of attributes) {
                if ('children' in attribute) {
                    columns = columns.concat(this.getStatisticsColumnNames(attribute['children']))
                } else {
                    columns.push(attribute['label'])
                }
            }
            return columns
        },
        updateSelectedNodes(node, level) {
            let index = this._findNodeInSelectedNodes(node)
            if (typeof index === 'undefined') {
                node.level = level
                this.selectedObjects.push(node)
            } else {
                this.selectedObjects.splice(index)
            }
        },
        _findNodeInSelectedNodes(node) {
            for (let i = 0; i < this.selectedObjects.length; i++) {
                let n = this.selectedObjects[i]
                if (n['id'] === node['id'] && n['structureId'] === node['structureId']) {
                    return i
                }
            }
            return undefined;
        },

        getStatisticsFile() {
            try {
                this.validateStatisticsParams()
            } catch (e) {
                this.showToast(e.name, e.message, 'danger', 10000)
                return
            }
            let jsonData = this._getStatisticsRequestParams()
            this.axios.post(
                this.baseUrl + 'get_excel/',
                jsonData,
                {
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    responseType: 'arraybuffer',
                }
            ).then((response) => {
                if (response.data) {
                    let content = response.headers['content-type']
                    console.log(response)
                    download(response.data, "Отчет.xlsx", content)
                }
            }).catch((error) => console.log(error)
            ).finally(() => this.$store.commit('globalloading/SET_LOADING', false));
        },
    }
}
