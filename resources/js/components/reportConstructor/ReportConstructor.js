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
            baseUrl: 'http://172.20.103.187:8084/',
            showOptions: true,
            structureTypes: {
                org: null,
                tech: null,
                geo: null
            },
            attributeDescriptions: null,
            attributesForObject: null,
            currentStructureType: 'org',
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
            startMonthDate: null,
            endMonthDate: null,
            maxDepthOfSelectedAttributes: null,
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
        handleYearClick() {
            $('.start-year-date .vdatetime-input').click();
            $('.end-year-date .vdatetime-input').click();
        },
        handleMonthClick() {
            $('.start-month-date .vdatetime-input').click();
            $('.end-month-date .vdatetime-input').click();
        },
        formatStartMonth() {
            this.startDate = formatDate.getFirstDayOfMonth(this.startMonthDate);
        },
        formatEndMonth() {
            this.endDate = formatDate.getLastDayOfMonth(this.endMonthDate);
        },
        handleMenuClick(currentStructureType, btnClass) {
            this.showOptions = true;
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
            if (!this.isActualAttribute(descriptionField)) {
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
                    if (this._hasChildren(attribute)) {
                        newAttribute.children = this._getAllSelectedAttributes(attribute.children)
                    }
                    selectedAttributes.push(newAttribute)
                }
            }
            return selectedAttributes
        },
        _hasChildren(node) {
            return 'children' in node && node.children.length > 0
        },
        _cleanEmptyHeadersOfAttributes(attributes) {
            let cleanAttributes = []
            for (let attribute of attributes) {
                if (this.isActualAttribute(attribute.label)) {
                    cleanAttributes.push({'label': attribute.label})
                }
                if (!this._hasChildren(attribute)) {
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
                    download(response.data, "Отчет.xlsx", response.headers['content-type'])
                }
            }).catch((error) => console.log(error)
            ).finally(() => this.$store.commit('globalloading/SET_LOADING', false));
        },
        getHeaders() {
            let attributes = this.getSelectedAttributes()
            this.maxDepthOfSelectedAttributes = this._getMaxDepthOfTree(attributes)
            return this._convertTreeToLayersOfAttributes(attributes, this.maxDepthOfSelectedAttributes)

        },
        _getMaxDepthOfTree(attributes) {
            let maxChildrenDepth = 0
            for (let attribute of attributes) {
                if (!this._hasChildren(attribute)) {
                    continue
                }
                let childrenDepth = this._getMaxDepthOfTree(attribute.children)
                if (maxChildrenDepth < childrenDepth) {
                    maxChildrenDepth = childrenDepth
                }
            }
            return maxChildrenDepth + 1
        },
        _convertTreeToLayersOfAttributes(attributes, layerDepth)
        {
            let layers = []
            for (let i = 0; i < layerDepth; i++) {
                layers.push(this._getAttributesOnDepth(attributes, i))
            }
            return layers
        },
        _getAttributesOnDepth(attributes, targetDepth, startingDepth = 0) {
            let attributesOnTargetDepth = []
            for (let attribute of attributes) {
                if (startingDepth === targetDepth) {
                    attributesOnTargetDepth.push({
                        'label': attribute.label,
                        'maxChildrenNumber': this._getMaxChildrenNumber(attribute)
                    })
                    continue
                }
                if (!this._hasChildren(attribute)) {
                    continue
                }
                let attributesOnDepth = this._getAttributesOnDepth(
                    attribute.children, targetDepth, startingDepth + 1
                )
                attributesOnTargetDepth = attributesOnTargetDepth.concat(attributesOnDepth)
            }
            return attributesOnTargetDepth
        },
        _getMaxChildrenNumber(originalAttribute) {
            let maxChildrenNumber = 0;
            if (!this._hasChildren(originalAttribute)) {
                return maxChildrenNumber
            }
            for (let attribute of originalAttribute.children) {
                if (!this._hasChildren(attribute)) {
                    maxChildrenNumber += 1
                }
                maxChildrenNumber += this._getMaxChildrenNumber(attribute)
            }
            return maxChildrenNumber
        },
        getRowHeightSpan(attribute, currentDepth){
            if (currentDepth !== this.maxDepthOfSelectedAttributes) {
                return 1
            }
            return this.maxDepthOfSelectedAttributes - currentDepth
        },
        getRowWidthSpan(attribute) {
            if (attribute.maxChildrenNumber === 0) {
                return 1
            }
            return attribute.maxChildrenNumber
        }
    }
}
