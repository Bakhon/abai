import {Datetime} from 'vue-datetime';
import {bTreeView} from "bootstrap-vue-treeview";
import Vue from "vue";
import 'vue-datetime/dist/vue-datetime.css';
import {formatDate} from "../common/FormatDate";
import download from "downloadjs";
import {globalloadingMutations} from '@store/helpers';
import CatLoader from '@ui-kit/CatLoader';

Vue.use(Datetime)
Vue.use(bTreeView)

export default {
    props: [
        'params'
    ],
    components: {
        CatLoader
    },
    data() {
        return {
            baseUrl: process.env.MIX_MICROSERVICE_USER_REPORTS,
            structureTypes: {
                org: null,
                tech: null,
                geo: null
            },
            attributeDescriptions: null,
            attributesByHeader: null,
            sheetTypesDescription: {
                "well": "скважины",
                "object": "объекты",
                "well_summary": "суммарные данные по скважинам",
                "object_summary": "суммарные данные по объекту",
            },
            sheetTypes: ["well", "object", "well_summary", "object_summary"],
            activeTab: 0,
            activeButtonId: 1,
            currentStructureType: 'org',
            currentStructureId: null,
            currentItemType: null,
            currentDatePickerFilter: 'date',
            currentOption: null,
            statistics: null,
            statisticsColumns: null,
            items: [],
            isLoading: false,
            isDisplayParameterBuilder: false,
            selectedObjects: [],
            startDate: null,
            endDate: null,
            dateFlow: ['year', 'month', 'date'],
            maxDepthOfSelectedAttributes: null,
        }
    },
    mounted: function () {
        this.$nextTick(function () {
            this.SET_LOADING(false);
        });
        for (let structureType in this.structureTypes) {
            this.loadStructureTypes(structureType);
        }
        this.loadAttributeDescriptions()
        this.loadHeaders()
    },
    methods: {
        ...globalloadingMutations([
            'SET_LOADING'
        ]),
        loadStructureTypes(type) {
            this.SET_LOADING(true)
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
                this.SET_LOADING(false);
            }).catch((error) => {
                console.log(error)
                this.SET_LOADING(false)
            });

        },
        loadAttributeDescriptions() {
            this.SET_LOADING(true)
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
                this.SET_LOADING(false)
            });

        },
        loadHeaders() {
            this.SET_LOADING(true)
            this.axios.get(this.baseUrl + "get_headers", {
                responseType: 'json',
                headers: {
                    'Content-Type': 'application/json'
                }
            }).then((response) => {
                this.attributesByHeader = response.data
            }).catch((error) => {
                console.log(error)
            }).finally(() => {
                this.SET_LOADING(false)
            });
        },
        loadItems(itemType) {
            this.SET_LOADING(true)
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
                this.SET_LOADING(false)
            });

        },
        getAttributeDescription(descriptionField) {
            if (descriptionField in this.attributeDescriptions["formulas"]) {
                return this.attributeDescriptions["formulas"][descriptionField]["description"]
            }
            if (!this.isActualAttribute(descriptionField)) {
                return descriptionField
            }
            let fieldParts = descriptionField.split(".")
            let table = fieldParts[0] + "." + fieldParts[1]
            if (!(table in this.attributeDescriptions["tables"])) {
                return descriptionField
            }
            let fieldName = fieldParts[2]
            if (!(fieldName in this.attributeDescriptions["tables"][table])) {
                return fieldName
            }
            return this.attributeDescriptions["tables"][table][fieldName]
        },
        isActualAttribute(field) {
            let fieldParts = field.split(".")
            return fieldParts.length === 3
        },
        updateStatistics() {
            this.loadStatistics()
            let selectedAttributes = this.getSelectedAttributes()
            this.statisticsColumns = {}
            this.maxDepthOfSelectedAttributes = {}
            for (let sheetType in selectedAttributes) {
                this.statisticsColumns[sheetType] = this.getStatisticsColumnNames(selectedAttributes[sheetType])
            }
        },
        loadStatistics() {
            this.SET_LOADING(true)
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
                this.SET_LOADING(false)
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
            let allSelectedAttributes = {}
            for (let sheetType in this.attributesByHeader) {
                let selectedAttributes = this._getAllSelectedAttributes(this.attributesByHeader[sheetType])
                selectedAttributes = this._cleanEmptyHeadersOfAttributes(selectedAttributes)
                allSelectedAttributes[sheetType] = selectedAttributes
            }
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
                if (this.isActualAttributeOrFormula(attribute.label)) {
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
        isActualAttributeOrFormula(field) {
            if (this.isActualAttribute(field)) {
                return true
            }
            return field in this.attributeDescriptions["formulas"]
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
            this.SET_LOADING(true)
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
            ).finally(() => this.SET_LOADING(false));
        },
        getHeaders(sheetType) {
            let attributes = this.getSelectedAttributes()
            this.maxDepthOfSelectedAttributes[sheetType] = this._getMaxDepthOfTree(attributes[sheetType])
            return this._convertTreeToLayersOfAttributes(attributes[sheetType], this.maxDepthOfSelectedAttributes[sheetType])
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
        _convertTreeToLayersOfAttributes(attributes, layerDepth) {
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
        getRowHeightSpan(attribute, currentDepth) {
            if (attribute.maxChildrenNumber > 0) {
                return 1
            }
            return this.maxDepthOfSelectedAttributes - currentDepth
        },
        getRowWidthSpan(attribute) {
            if (attribute.maxChildrenNumber === 0) {
                return 1
            }
            return attribute.maxChildrenNumber
        },
        getOptionName() {
            return this.currentOption && this.currentOption.name ? this.currentOption.name : 'Выбор объекта'; 
        },
        onMenuClick(currentStructureType) {
            this.currentStructureType = currentStructureType;
            this.currentOption = null;
            this.currentItemType = null;
        },
        onClickOption(structureType) {
            this.currentOption = structureType;
            this.currentItemType = structureType.id;
        },
        onYearClick() {
            if(this.currentDatePickerFilter === 'year') {
                this.setDefaultDateFilter();
                return;
            }
            this.currentDatePickerFilter = 'year';
            this.dateFlow = ['year'];
        },
        onMonthClick() {
            if(this.currentDatePickerFilter === 'month') {
                this.setDefaultDateFilter();
                return;
            }
            this.currentDatePickerFilter = 'month';
            this.dateFlow = ['year', 'month'];
        },
        setDefaultDateFilter() {
            this.currentDatePickerFilter = 'date';
            this.dateFlow = ['year', 'month', 'date'];
        },
        onStartDatePickerClick(date) {
            if(!date) return;
            switch(this.currentDatePickerFilter) {
                case "year":
                    this.setStartOfYear(date);
                    break;
                case "month": 
                    this.setStartOfMonth(date);
                    break;
                default: 
                    this.startDate = date;
            }
        },
        setStartOfYear(date) {
            this.startDate = formatDate.getStartOfYearFormatted(date, 'datetimePickerFormat');
        },
        setStartOfMonth(date) {
            this.startDate = formatDate.getFirstDayOfMonthFormatted(date, 'datetimePickerFormat');
        },
        onEndDatePickerClick(date) {
            if(!date) return;
            switch(this.currentDatePickerFilter) {
                case "year":
                    this.setEndOfYear(date);
                    break;
                case "month": 
                    this.setEndOfMonth(date);
                    break;
                default: 
                    this.endDate = date;
            }
        },
        setEndOfYear(date) {
            this.endDate = formatDate.getEndOfYearFormatted(date, 'datetimePickerFormat');
        },
        setEndOfMonth(date) {
            this.endDate = formatDate.getLastDayOfMonthFormatted(date, 'datetimePickerFormat');
        },
    }
}
