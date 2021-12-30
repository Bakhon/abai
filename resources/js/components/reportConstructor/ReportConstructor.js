import {Datetime} from 'vue-datetime';
import {bTreeView} from "bootstrap-vue-treeview";
import Vue from "vue";
import 'vue-datetime/dist/vue-datetime.css';
import {formatDate} from "../common/FormatDate";
import download from "downloadjs";
import {globalloadingMutations} from '@store/helpers';


Vue.use(Datetime)
Vue.use(bTreeView)

export default {
    props: [
        'params'
    ],
    data() {
        return {
            baseUrl: process.env.MIX_MICROSERVICE_USER_REPORTS,
            frontendApiVersion: "1.03",
            microserviceApiVersion: null,
            structureTypes: {
                org: null,
                tech: null,
                geo: null
            },
            reportName: null,
            isAttachScrollOfTwoReports: true,
            attributeDescriptions: null,
            attributesForObject: null,
            attributesByHeader: null,
            attributesByHeaderAtRequest: null,
            sheetTypesDescription: {
                "well_production": "добывающие скважины",
                "well_pump": "нагнетающие скважины",
                "object": "объекты",
                "well_summary": "суммарные данные по скважинам",
                "object_summary": "суммарные данные по объекту",
            },
            indexFields: {
                "well_production": "dict.well.uwi",
                "well_pump": "dict.well.uwi",
                "object": "dict.org.name_ru",
                "well_summary": "dict.well.uwi",
                "object_summary": "dict.org_type.name_ru",
            },
            sheetConfigurations: {
                well_production: {
                    mandatoryFields: ['prod.well_status_view.dbeg', 'prod.well_status_view.dend', 'dict.well.uwi'],
                    dateField: 'prod.well_status_view.dbeg',
                    uniqueField: 'dict.well.uwi',
                    reports: [
                        {
                            orderedDates: []
                        },
                        {
                            orderedDates: []
                        }
                    ]
                },
                well_pump: {
                    mandatoryFields: ['prod.well_status_view.dbeg', 'prod.well_status_view.dend', 'dict.well.uwi'],
                    dateField: 'prod.well_status_view.dbeg',
                    uniqueField: 'dict.well.uwi',
                    reports: [
                        {
                            orderedDates: []
                        },
                        {
                            orderedDates: []
                        }
                    ]
                }
            },
            dailyParametersCategoryLabel: 'Параметры по дням',
            sheetTypes: ["well_production", "well_pump", "object", "well_summary", "object_summary"],
            activeTab: 0,
            activeButtonId: 1,
            currentStructureType: 'org',
            currentStructureId: null,
            currentItemType: null,
            currentDatePickerFilter: 'date',
            currentOption: null,
            statisticsColumns: null,
            items: [],
            isLoading: false,
            isComparisonComplete: true,
            isDisplayParameterBuilder: false,
            isDisplayReportComparison: false,
            isLeftSectionHidden: false,
            wellSheetTypes: {
                'well_production': 'Добывающие скважины',
                'well_pump': 'Нагнетательные скважины'
            },
            wellTypeSelected: 'well_production',
            selectedObjects: {'org': {}, 'geo': {}, 'tech': {}},
            datesByReport: [
                {
                    startDate: null,
                    endDate: null,
                },
                {
                    startDate: null,
                    endDate: null,
                }
            ],
            reportsContent: [
                {
                    statistics: null,
                    indexFields: {
                        "well_production": [],
                        "well_pump": [],
                        "object": [],
                        "well_summary": [],
                        "object_summary": [],
                    },
                    comparisonResults: null,
                },
                {
                    statistics: null,
                    indexFields: {
                        "well_production": [],
                        "well_pump": [],
                        "object": [],
                        "well_summary": [],
                        "object_summary": [],
                    },
                    comparisonResults: null,
                }
            ],
            dateFlow: ['year', 'month', 'date'],
            maxDepthOfSelectedAttributes: null,
            templates: [],
            newTemplateName: "",
            storableParameters: [
                "datesByReport", "isDisplayReportComparison", "selectedObjects",
                "activeTab", "activeButtonId", "currentStructureType",
                "currentItemType", "currentOption", "attributesByHeader",
                "wellTypeSelected"
            ]
        }
    },
    mounted: function () {
        this.$nextTick(function () {
            this.SET_LOADING(false);
        });
        this.setMicroserviceApiVersion()
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
        setMicroserviceApiVersion() {
            this.SET_LOADING(true)
            this.axios.get(this.baseUrl + "api_version", {
                responseType: 'json',
                headers: {
                    'Content-Type': 'application/json'
                }
            }).then((response) => {
                if (response.data) {
                    this.microserviceApiVersion = response.data['version']
                } else {
                    console.log("No data");
                }
                this.SET_LOADING(false);
            }).catch((error) => {
                console.log(error)
                this.SET_LOADING(false)
            });

        },
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
        async updateStatistics() {
            await this.loadStatistics()
        },
        async loadStatistics() {
            this.SET_LOADING(true)
            this.isComparisonComplete = false
            this.reportsContent[0]['statistics'] = null;
            this.reportsContent[1]['statistics'] = null;
            let wellTypeSelectedAtRequest = this.copyString(this.wellTypeSelected)
            this.attributesByHeaderAtRequest = JSON.parse(JSON.stringify(this.attributesByHeader))

            try {
                this.validateStatisticsParams()
            } catch (e) {
                this.showToast(e.name, e.message, 'danger', 10000)
                this.SET_LOADING(false)
                return
            }

            let paramsFirstReport = await this.getStatisticsRequestParams(0);
            let paramsSecondReport = null
            if (this.isDisplayReportComparison) {
                paramsSecondReport = await this.getStatisticsRequestParams(1);
            }

            await this.axios.post(this.baseUrl + "get_statistics", JSON.stringify(paramsFirstReport), {
                responseType: 'json',
                headers: {
                    'Content-Type': 'application/json'
                }
            }).then((response) => {
                this.setAttributesParameters()
                this.reportsContent[0]['statistics'] = this.postProcessStatistics(response.data, wellTypeSelectedAtRequest, 0);
                this.setActiveTab(wellTypeSelectedAtRequest)
            }).catch((error) => {
                console.log(error)
            }).finally(() => {
                if (!this.isDisplayReportComparison) {
                    this.SET_LOADING(false)
                }
            })

            if (!this.isDisplayReportComparison) {
                return
            }
            await this.axios.post(this.baseUrl + "get_statistics", JSON.stringify(paramsSecondReport), {
                responseType: 'json',
                headers: {
                    'Content-Type': 'application/json'
                }
            }).then((response) => {
                this.reportsContent[1]['statistics'] = this.postProcessStatistics(response.data, wellTypeSelectedAtRequest, 1);
            }).catch((error) => {
                console.log(error)
            }).finally(() => {
                this.SET_LOADING(false)
                if (this.isAttachScrollOfTwoReports) {
                    this.attachScrollOfTwoReports()
                }
                this.setComparisonResults(0, 1)
                this.setComparisonResults(1, 0)
                this.isComparisonComplete = true
            })
        },
        validateStatisticsParams() {
            if (!this.isHasSelectedObjects()) {
                throw new Error("Не выбраны объекты для отображения")
            }
            if (this.getSelectedAttributes().length === 0) {
                throw new Error("Не выбраны поля для отображения")
            }
        },
        isHasSelectedObjects() {
            let content = this.selectedObjects;
            for (let structureType in content) {
                for (let option in content[structureType]) {
                    for (let node of content[structureType][option]) {
                        if (node.isChecked) {
                            return true;
                        }
                        this.getSelectedChildren(node)
                            .then((target) => {
                                if (target) return true;
                            });
                    }
                }
            }
            return false;
        },
        getSelectedAttributes() {
            let allSelectedAttributes = {}
            for (let sheetType in this.attributesByHeaderAtRequest) {
                let selectedAttributes = this._getAllSelectedAttributes(this.attributesByHeaderAtRequest[sheetType])
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
        async getStatisticsRequestParams(reportNum) {
            let selectedObjects = await this.getSelectedObjects();
            let fields = await this.getSelectedAttributes();
            fields = await this.addMandatoryFields(fields);
            let dates = this.getDates(reportNum);
            let currentStructureType = this.currentStructureType;
            fields['well'] = fields[this.wellTypeSelected]

            return {
                "fields": fields,
                "selectedObjects": selectedObjects,
                "structureType": currentStructureType,
                "dates": dates,
                "filters": {
                    "wellFilter": this.wellTypeSelected
                }
            }
        },
        async getSelectedObjects() {
            let selectedObjects = [];
            for (let structureType in this.selectedObjects) {
                for (let option in this.selectedObjects[structureType]) {
                    for (let node of this.selectedObjects[structureType][option]) {
                        if (node.isChecked) {
                            selectedObjects.push(node);
                        }
                        selectedObjects = selectedObjects.concat(await this.getSelectedChildren(node));
                    }
                }
            }
            for (let node of selectedObjects) {
                if (node.type === "well") continue;
                await this.$refs.itemSelectTree.loadChildren(node)
                    .then(async () => {
                        await this.updateChildrenOfNode(node, node.level)
                    })
                    .then(async () => {
                        selectedObjects = selectedObjects.concat(await this.getSelectedChildren(node));
                    });
            }

            return selectedObjects.filter((value, index, self) => {
                return self.indexOf(value) === index;
            });
        },
        async updateChildrenOfNode(node, level) {
            if (!node?.children) return;
            for (let child of node.children) {
                if (!('isChecked' in child)) {
                    child.isChecked = node.isChecked;
                }
                child.level = level + 1;
                await this.updateChildrenOfNode(child, level + 1);
            }
        },
        async getSelectedChildren(node) {
            if (!node || !('children' in node)) return [];
            let selectedChildren = [];

            for (let child of node.children) {
                if (child.isChecked) {
                    selectedChildren.push(child);
                }
                selectedChildren = selectedChildren.concat(await this.getSelectedChildren(child));
            }
            return selectedChildren;
        },
        addMandatoryFields(fields) {
            for (let sheetType in fields) {
                if (fields[sheetType].length === 0) {
                    continue
                }
                if (!(sheetType in this.sheetConfigurations)) {
                    continue
                }
                for (let parameter of this.sheetConfigurations[sheetType]['mandatoryFields']) {
                    fields[sheetType][0]['children'].push({'label': parameter})
                }
            }
            return fields
        },
        getDates(reportNum) {
            let dates = []
            if (this.datesByReport[reportNum]['startDate']) {
                dates.push(formatDate.getMinOfDayFormatted(this.datesByReport[reportNum]['startDate']))
            } else {
                dates.push(null)
            }
            if (this.datesByReport[reportNum]['endDate']) {
                dates.push(formatDate.getMaxOfDayFormatted(this.datesByReport[reportNum]['endDate']))
            } else {
                dates.push(formatDate.getTodayDateFormatted());
            }
            return dates
        },
        copyString(originalString) {
            return (' ' + originalString).slice(1)
        },
        setAttributesParameters() {
            let selectedAttributes = this.getSelectedAttributes()
            this.statisticsColumns = {}
            this.maxDepthOfSelectedAttributes = {}
            for (let sheetType in selectedAttributes) {
                if (selectedAttributes[sheetType].length === 0) {
                    this.statisticsColumns[sheetType] = {'generic': [], 'daily': []}
                    continue
                }
                let genericAttributes = this.getGenericAttributesBranches(selectedAttributes[sheetType])
                let dailyAttributes = this.getDailyAttributesBranch(selectedAttributes[sheetType])
                this.statisticsColumns[sheetType] = {
                    'generic': this.getStatisticsColumnNames(genericAttributes),
                    'daily': this.getStatisticsColumnNames(dailyAttributes)
                }
                this.maxDepthOfSelectedAttributes[sheetType] = this.getMaxDepthOfTree(selectedAttributes[sheetType])
            }
        },
        postProcessStatistics(statistics, wellTypeSelectedAtRequest, reportNum) {
            statistics[wellTypeSelectedAtRequest] = statistics['well']
            delete statistics['well']
            this.setUniqueOrderedDates(statistics, reportNum)
            statistics = this.processDailyStatistics(statistics)
            this.setIndexFields(statistics, reportNum)
            return statistics
        },
        setIndexFields(statistics, reportNum) {
            for (let sheet in statistics) {
                if (!this.isSheetHasContent(statistics, sheet)) {
                    continue
                }
                let indexField = this.indexFields[sheet]
                let indexValues = statistics[sheet].map(row => row[indexField])
                this.reportsContent[reportNum]['indexFields'][sheet] = indexValues
            }
        },
        setUniqueOrderedDates(statistics, reportNum) {
            for (let sheet in this.sheetConfigurations) {
                if (!this.isSheetHasContent(statistics, sheet)) {
                    continue
                }
                let dateField = this.sheetConfigurations[sheet]['dateField']
                let uniqueDates = new Set(statistics[sheet].map(row => row[dateField]))
                this.sheetConfigurations[sheet]['reports'][reportNum]['orderedDates'] = Array.from(uniqueDates).sort(
                    function (a, b) {
                        return new Date(a) - new Date(b)
                    }
                )
            }
        },
        isSheetHasContent(statistics, sheet) {
            return (statistics[sheet] && statistics[sheet].length > 0)
        },
        processDailyStatistics(statistics) {
            for (let sheetType in this.sheetConfigurations) {
                if (!this.isSheetHasContent(statistics, sheetType)) {
                    continue
                }
                statistics[sheetType] = this.processDailyStatisticsOfSheet(statistics, sheetType)
            }
            return statistics
        },
        processDailyStatisticsOfSheet(statistics, sheetType) {
            let sheetByDays = {}
            let uniqueField = this.sheetConfigurations[sheetType]['uniqueField']
            let columnsKeys = this.statisticsColumns[sheetType]
            let dateField = this.sheetConfigurations[sheetType]['dateField']
            for (let row of statistics[sheetType]) {
                let uniqueId = row[uniqueField]
                if (!(uniqueId in sheetByDays)) {
                    sheetByDays[uniqueId] = {}
                }

                for (let genericParameter of columnsKeys['generic']) {
                    if (row[genericParameter] && row[genericParameter] !== '') {
                        sheetByDays[uniqueId][genericParameter] = row[genericParameter]
                    }
                }

                let day = row[dateField]
                sheetByDays[uniqueId][day] = {}
                for (let dailyParameter of columnsKeys['daily']) {
                    sheetByDays[uniqueId][day][dailyParameter] = row[dailyParameter]
                }
            }
            return sheetByDays
        },
        setActiveTab(wellTypeSelectedAtRequest) {
            if (this.isStatisticsOfTabExists(wellTypeSelectedAtRequest)) {
                this.activeTab = this.sheetTypes.indexOf(wellTypeSelectedAtRequest)
                return
            }
            for (let tabId = 0; tabId < this.sheetTypes.length; tabId++) {
                let tabName = this.sheetTypes[tabId]
                if (tabName in this.wellSheetTypes) {
                    continue
                }
                if (this.isStatisticsOfTabExists(tabName)) {
                    this.activeTab = tabId
                    return
                }
            }
        },
        isStatisticsOfTabExists(tabName) {
            if (!(tabName in this.reportsContent[0]['statistics'])) {
                return false
            }
            if (Array.isArray(this.reportsContent[0]['statistics'][tabName]) && this.reportsContent[0]['statistics'][tabName].length > 0) {
                return true
            }
            return !Array.isArray(this.reportsContent[0]['statistics'][tabName]) && Object.keys(this.reportsContent[0]['statistics'][tabName]).length > 0;
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
        attachScrollOfTwoReports() {
            $('#top-table').scroll(function () {
                $('#bottom-table').scrollTop($(this).scrollTop());
                $('#bottom-table').scrollLeft($(this).scrollLeft());
            });

            $('#bottom-table').scroll(function () {
                $('#top-table').scrollTop($(this).scrollTop());
                $('#top-table').scrollLeft($(this).scrollLeft());
            });
        },
        setComparisonResults(reportNum1, reportNum2) {
            let firstReport = this.reportsContent[reportNum1]['statistics']
            let comparisonResults = {}
            for (let sheet in firstReport) {
                if (sheet in this.sheetConfigurations) {
                    comparisonResults[sheet] = this.getDailySheetComparisonResult(sheet, reportNum1, reportNum2);
                } else {
                    comparisonResults[sheet] = this.getGenericSheetComparisonResults(sheet, reportNum1, reportNum2);
                }
            }
            this.reportsContent[reportNum1]['comparisonResults'] = comparisonResults
        },
        getGenericSheetComparisonResults(sheet, reportNum1, reportNum2) {
            let firstReport = this.reportsContent[reportNum1]['statistics']
            let secondReport = this.reportsContent[reportNum2]['statistics']
            let comparisonResults = []
            let rowNumInSecondReport = 0
            let indexField = this.indexFields[sheet]
            for (let i = 0; i < firstReport[sheet].length; i++) {
                let comparisonRow = {}
                let rowIdFirstReport = firstReport[sheet][i][indexField]
                let rowNumInSecondReportOfCurrentRowId = this.findNextRowNumByIndexValue(
                    rowIdFirstReport, rowNumInSecondReport, indexField, secondReport[sheet]
                )
                if (rowNumInSecondReportOfCurrentRowId === -1) {
                    comparisonRow = {'_isRowNew': true}
                    comparisonResults.push(comparisonRow)
                    continue
                }
                rowNumInSecondReport = rowNumInSecondReportOfCurrentRowId
                let row1 = firstReport[sheet][i]
                let row2 = secondReport[sheet][rowNumInSecondReport]
                for (let parameter in row1) {
                    let value1 = row1[parameter]
                    let value2 = row2[parameter]
                    comparisonRow[parameter] = this.compareValues(value1, value2)
                }
                comparisonResults.push(comparisonRow)
            }
            return comparisonResults;
        },
        getDailySheetComparisonResult(sheet, reportNum1, reportNum2) {
            let firstReport = this.reportsContent[reportNum1]['statistics']
            let secondReport = this.reportsContent[reportNum2]['statistics']
            let comparisonResults = {}
            for (let indexParameter in firstReport[sheet]) {
                let comparisonRow = {}
                let row1 = firstReport[sheet][indexParameter]
                if (!(indexParameter in secondReport[sheet])) {
                    comparisonRow = {'_isRowNew': true}
                    comparisonResults[indexParameter] = comparisonRow
                    continue

                }
                let row2 = secondReport[sheet][indexParameter]
                let comparisonRowOfGeneric = this.getGenericParametersComparison(row1, row2, sheet);
                let comparisonRowOfDates = this.getDatesParametersComparison(reportNum1, reportNum2, row1, row2, sheet);
                comparisonRow = Object.assign(comparisonRow, comparisonRowOfDates, comparisonRowOfGeneric)
                comparisonResults[indexParameter] = comparisonRow
            }
            return comparisonResults;
        },
        findNextRowNumByIndexValue(rowId, start, indexField, statisticsToSearchIn) {
            for (let j = start; j < statisticsToSearchIn.length; j++) {
                if (rowId === statisticsToSearchIn[j][indexField]) {
                    return j
                }
            }
            return -1
        },
        getOrderedDates(sheet, reportNum) {
            if (!(sheet in this.sheetConfigurations)) {
                return []
            }
            return this.sheetConfigurations[sheet]['reports'][reportNum]['orderedDates']
        },
        getGenericParameters(sheet, reportNum) {
            let dates = this.getOrderedDates(sheet, reportNum)
            let row = this.reportsContent[reportNum]['statistics'][sheet][0]
            let parameters = []
            for (let parameter in row) {
                if (dates.includes(parameter)) {
                    continue
                }
                parameters.push(parameter)
            }
            return parameters
        },
        compareValues(value1, value2) {
            if ((value1 === 'None') && this.isFloat(value2)) {
                return -1
            }
            if ((value2 === 'None') && this.isFloat(value1)) {
                return 1
            }
            if (!(this.isFloat(value1) && this.isFloat(value2))) {
                return 0
            }
            if (+value1 > +value2) {
                return 1
            }
            if (+value1 < +value2) {
                return -1
            }
            return 0
        },
        isFloat(n) {
            return parseFloat(n.match(/^-?\d*(\.\d+)?$/)) > 0;
        },
        async getStatisticsFile() {
            this.SET_LOADING(true)
            try {
                this.validateStatisticsParams()
            } catch (e) {
                this.showToast(e.name, e.message, 'danger', 10000)
                return
            }
            let params = await this.getStatisticsDownloadRequestParams()
            this.axios.post(
                this.baseUrl + 'get_excel/',
                JSON.stringify(params),
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
        getGenericParametersComparison(row1, row2, sheet) {
            let genericParams = this.getGenericParameters(sheet, 0)
            let comparisonRow = {}
            for (let parameter of genericParams) {
                let value1 = row1[parameter]
                let value2 = row2[parameter]
                comparisonRow[parameter] = this.compareValues(value1, value2)
            }
            return comparisonRow;
        },
        getDatesParametersComparison(reportNum1, reportNum2, row1, row2, sheet) {
            let dates1 = this.getOrderedDates(sheet, reportNum1)
            let dates2 = this.getOrderedDates(sheet, reportNum2)
            let comparisonRow = {}
            for (let j = 0; j < dates1.length; j++) {
                comparisonRow[dates1[j]] = {}
                let parametersOfDate1 = row1[dates1[j]]
                if (j >= dates2.length) {
                    for (let parameter in parametersOfDate1) {
                        comparisonRow[dates1[j]][parameter] = 1
                    }
                    continue
                }

                let parametersOfDate2 = row2[dates2[j]]
                for (let parameter in parametersOfDate1) {
                    let value1 = parametersOfDate1[parameter]
                    let value2 = parametersOfDate2[parameter]
                    comparisonRow[dates1[j]][parameter] = this.compareValues(value1, value2)
                }
            }
            return comparisonRow;
        },
        async getStatisticsDownloadRequestParams() {
            let params = await this.getStatisticsRequestParams(0)
            params['sheetConfigurations'] = {'well': this.sheetConfigurations[this.wellTypeSelected]}
            params['dailyParametersCategoryLabel'] = this.dailyParametersCategoryLabel
            return params
        },
        getHeaders(sheetType, reportNum) {
            let genericHeaders = this.getGenericHeaders(sheetType)
            if (!(sheetType in this.sheetConfigurations)) {
                return genericHeaders
            }
            let dailyHeaders = this.getDailyHeaders(sheetType)
            if (dailyHeaders.length === 0) {
                return genericHeaders
            }
            let dates = this.getDatesForHeaders(sheetType, dailyHeaders, reportNum)
            let maxDepth = Math.max(dailyHeaders.length + 1, genericHeaders.length)
            let layers = []
            for (let i = 0; i < maxDepth; i++) {
                let newLayer = []
                if (i < genericHeaders.length) {
                    newLayer = newLayer.concat(genericHeaders[i])
                }
                newLayer = newLayer.concat(this.getDailyLayer(dates, dailyHeaders, i))
                layers.push(newLayer)
            }
            return layers
        },
        getDailyLayer(dates, dailyHeaders, i) {
            let newLayer = []
            for (let j = 0; j < dates.length; j++) {
                if ((i - 1) < dailyHeaders.length && i !== 0) {
                    newLayer = newLayer.concat(dailyHeaders[i - 1])
                }
            }
            if (i === 0) {
                newLayer = newLayer.concat(dates)
            }
            return newLayer
        },
        getDatesForHeaders(sheetType, dailyHeaders, reportNum) {
            let dates = this.sheetConfigurations[sheetType]['reports'][reportNum]['orderedDates']
            let maxChildren = 0
            for (let layer of dailyHeaders) {
                if (maxChildren < layer.length) {
                    maxChildren = layer.length
                }
            }
            let formattedDates = []
            for (let date of dates) {
                formattedDates.push({
                        'label': this.formatCell(date),
                        'maxChildrenNumber': maxChildren
                    }
                )
            }
            return formattedDates
        },
        getGenericHeaders(sheetType) {
            let attributes = this.getSelectedAttributes()
            if (attributes[sheetType].length === 0) {
                return []
            }
            let maxDepthOfSelectedAttributes = this.getMaxDepthOfTree(attributes[sheetType]) - 1
            let genericAttributesBranches = this.getGenericAttributesBranches(attributes[sheetType])
            return this.convertTreeToLayersOfAttributes(genericAttributesBranches, maxDepthOfSelectedAttributes)
        },
        getGenericAttributesBranches(attributesOfSheet) {
            let children = []
            for (let child of attributesOfSheet[0]['children']) {
                if (child['label'] === this.dailyParametersCategoryLabel) {
                    continue
                }
                children.push(child)
            }
            return children
        },
        getMaxDepthOfTree(attributes) {
            let maxChildrenDepth = 0
            for (let attribute of attributes) {
                if (!this._hasChildren(attribute)) {
                    continue
                }
                let childrenDepth = this.getMaxDepthOfTree(attribute.children)
                if (maxChildrenDepth < childrenDepth) {
                    maxChildrenDepth = childrenDepth
                }
            }
            return maxChildrenDepth + 1
        },
        convertTreeToLayersOfAttributes(attributes, layerDepth) {
            let layers = []
            for (let i = 0; i < layerDepth; i++) {
                layers.push(this.getAttributesOnDepth(attributes, i))
            }
            return layers
        },
        getAttributesOnDepth(attributes, targetDepth, startingDepth = 0) {
            let attributesOnTargetDepth = []
            for (let attribute of attributes) {
                if (attribute['label'] === this.dailyParametersCategoryLabel) {
                    continue
                }
                if (startingDepth === targetDepth) {
                    attributesOnTargetDepth.push({
                        'label': attribute.label,
                        'maxChildrenNumber': this.getMaxChildrenNumber(attribute)
                    })
                    continue
                }
                if (!this._hasChildren(attribute)) {
                    continue
                }
                let attributesOnDepth = this.getAttributesOnDepth(
                    attribute.children, targetDepth, startingDepth + 1
                )
                attributesOnTargetDepth = attributesOnTargetDepth.concat(attributesOnDepth)
            }
            return attributesOnTargetDepth
        },
        getMaxChildrenNumber(originalAttribute) {
            let maxChildrenNumber = 0;
            if (!this._hasChildren(originalAttribute)) {
                return maxChildrenNumber
            }
            for (let attribute of originalAttribute.children) {
                if (!this._hasChildren(attribute)) {
                    maxChildrenNumber += 1
                }
                maxChildrenNumber += this.getMaxChildrenNumber(attribute)
            }
            return maxChildrenNumber
        },
        getDailyHeaders(sheetType) {
            if (!(sheetType in this.sheetConfigurations)) {
                return []
            }
            let attributes = this.getSelectedAttributes()
            if (attributes[sheetType].length === 0) {
                return []
            }
            let maxDepthOfSelectedAttributes = this.getMaxDepthOfTree(attributes[sheetType]) - 2
            let dailyAttributes = this.getDailyAttributesBranch(attributes[sheetType])
            if (dailyAttributes.length === 0) {
                return []
            }
            return this.convertTreeToLayersOfAttributes(dailyAttributes, maxDepthOfSelectedAttributes)
        },
        getDailyAttributesBranch(attributesOfSheet) {
            for (let child of attributesOfSheet[0]['children']) {
                if (child['label'] === this.dailyParametersCategoryLabel) {
                    return child['children']
                }
            }
            return []
        },
        getRowHeightSpan(attribute, currentDepth, sheetType) {
            if (attribute.maxChildrenNumber > 0) {
                return 1
            }
            return this.maxDepthOfSelectedAttributes[sheetType] - currentDepth
        },
        getRowWidthSpan(attribute) {
            if (attribute.maxChildrenNumber === 0) {
                return 1
            }
            return attribute.maxChildrenNumber
        },
        getOptionName() {
            return this.currentOption?.name ? this.currentOption.name : 'Выбор объекта';
        },
        onMenuClick(currentStructureType) {
            this.currentStructureType = currentStructureType;
            this.currentOption = null;
            this.currentItemType = null;
        },
        onSelectStructureType(structureType) {
            this.currentOption = structureType;
            this.currentItemType = structureType.id;
        },
        onSelectWellSheetType(sheetType) {
            this.wellTypeSelected = sheetType
        },
        onYearClick() {
            if (this.currentDatePickerFilter === 'year') {
                this.setDefaultDateFilter();
                return;
            }
            this.currentDatePickerFilter = 'year';
            this.dateFlow = ['year'];
        },
        onMonthClick() {
            if (this.currentDatePickerFilter === 'month') {
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
        onStartDatePickerClick(date, reportNum) {
            if (!date) return;
            switch (this.currentDatePickerFilter) {
                case "year":
                    this.setStartOfYear(date, reportNum);
                    break;
                case "month":
                    this.setStartOfMonth(date, reportNum);
                    break;
                default:
                    this.datesByReport[reportNum]['startDate'] = date;
            }
        },
        setStartOfYear(date, reportNum) {
            this.datesByReport[reportNum]['startDate'] = formatDate.getStartOfYearFormatted(date, 'datetimePickerFormat');
        },
        setStartOfMonth(date, reportNum) {
            this.datesByReport[reportNum]['startDate'] = formatDate.getFirstDayOfMonthFormatted(date, 'datetimePickerFormat');
        },
        onEndDatePickerClick(date, reportNum) {
            if (!date) return;
            switch (this.currentDatePickerFilter) {
                case "year":
                    this.setEndOfYear(date, reportNum);
                    break;
                case "month":
                    this.setEndOfMonth(date, reportNum);
                    break;
                default:
                    this.datesByReport[reportNum]['endDate'] = date;
            }
        },
        setEndOfYear(date, reportNum) {
            this.datesByReport[reportNum]['endDate'] = formatDate.getEndOfYearFormatted(date, 'datetimePickerFormat');
        },
        setEndOfMonth(date, reportNum) {
            this.datesByReport[reportNum]['endDate'] = formatDate.getLastDayOfMonthFormatted(date, 'datetimePickerFormat');
        },
        clearDate(reportNum) {
            this.setDefaultDateFilter();
            this.datesByReport[reportNum]['startDate'] = null;
            this.datesByReport[reportNum]['endDate'] = null;
        },
        saveTemplate() {
            this.SET_LOADING(true)
            let params = {
                name: this.newTemplateName,
                template: JSON.stringify(this.composeTemplate())
            }
            this.axios.post(this.localeUrl('/bigdata/report-constructor/save-template/'), JSON.stringify(params))
                .then((response) => {
                })
                .catch((error) => {
                    console.log(error)
                })
                .finally(() => {
                    this.SET_LOADING(false)
                });
        },
        composeTemplate() {
            let template = {}
            for (let parameter of this.storableParameters) {
                template[parameter] = this[parameter]
            }
            return template
        },
        showTemplatesModal(modal) {
            this.showModal(modal)
            this.loadTemplates()
        },
        showModal(modal) {
            this.$modal.show(modal)
        },
        loadTemplates() {
            this.SET_LOADING(true)
            this.axios.get(this.localeUrl('/bigdata/report-constructor/get-templates/'))
                .then((response) => {
                    this.templates = response.data
                }).catch((error) => {
                console.log(error)
            }).finally(() => {
                this.SET_LOADING(false)
            });
        },
        closeModal(modal) {
            this.$modal.hide(modal)
        },
        loadTemplate(index) {
            let template = JSON.parse(this.templates[index].template)
            for (let parameter of this.storableParameters) {
                this[parameter] = template[parameter]
            }
        },
        isCheckedCheckbox(currentNode, level) {
            let selectedObjects = this.getSelectedObjects();
            for (let node of selectedObjects) {
                if (currentNode.id === node.id && level === node.level) {
                    return true
                }
            }
            return false
        },
        isContainsData(row) {
            if (Object.keys(row).length === 0) {
                return false
            }
            for (const [key, value] of Object.entries(row)) {
                if (!value.match(/None/)) {
                    return true
                }
            }
            return false
        },
        formatCell(string) {
            if (string.match(/None/)) {
                return ""
            }

            let dateRegexp = new RegExp(/(\d{4}-\d{2}-\d{2})/, "g")
            let match = dateRegexp.exec(string);
            if (match != null) {
                return match[0]
            }

            if (!isNaN(+string)) {
                return +parseFloat(string).toFixed(2)
            }

            return string
        },
        isDisplayParametersOfSheet(sheetType) {
            if (!(sheetType in this.wellSheetTypes)) {
                return this.isDisplayParameterBuilder
            }

            if (!this.isDisplayParameterBuilder) {
                return false
            }
            return this.wellTypeSelected === sheetType
        },
        isStatisticsForSheetTypeExists(sheetType) {
            let sheet = this.reportsContent[0]['statistics'][sheetType]
            if (sheetType in this.sheetConfigurations) {
                return (sheet && Object.keys(sheet).length > 0)
            }
            return (sheet && sheet.length > 0)
        },
        onSectionHidingEvent(method) {
            if (method === 'left') {
                this.isLeftSectionHidden = !this.isLeftSectionHidden
            }
        },
        isCreateReportAvailable() {
            if (this.isDisplayReportComparison) {
                return this.datesByReport[0]['startDate'] && this.datesByReport[0]['endDate'] && this.datesByReport[1]['startDate'] && this.datesByReport[1]['endDate']
            }
            return this.datesByReport[0]['startDate'] && this.datesByReport[0]['endDate']
        },
        getSectionClass() {
            if (this.isDisplayReportComparison) {
                return 'section-content-half bg-dark'
            }
            return 'section-content bg-dark'
        },
        onCommonScrollForTwoReports() {
            this.isAttachScrollOfTwoReports = !this.isAttachScrollOfTwoReports
            if (this.isAttachScrollOfTwoReports) {
                this.attachScrollOfTwoReports()
            } else {
                this.detachScrollOfTwoReports()
            }
        },
        detachScrollOfTwoReports() {
            $('#top-table').off("scroll")
            $('#bottom-table').off("scroll")
        },
        getCompareResultClass(rowId, columnId, sheet, reportNum) {
            if (!this.isComparisonComplete) {
                return ""
            }
            if (!this.reportsContent[reportNum]['comparisonResults']) {
                return ""
            }
            let comparisonResults = this.reportsContent[reportNum]['comparisonResults'][sheet]
            if (!comparisonResults) {
                return ""
            }
            if ('_isRowNew' in comparisonResults[rowId] && comparisonResults[rowId]['_isRowNew']) {
                return 'green-compare'
            }
            if (comparisonResults[rowId][columnId] === 1) {
                return 'green-compare'
            }

            if (comparisonResults[rowId][columnId] === -1) {
                return 'red-compare'
            }
            return ''
        },

        getCompareDailyResultClass(rowId, date, columnId, sheet, reportNum) {
            if (!this.isComparisonComplete) {
                return ""
            }
            if (!this.reportsContent[reportNum]['comparisonResults']) {
                return ""
            }
            let comparisonResults = this.reportsContent[reportNum]['comparisonResults'][sheet]
            if (!comparisonResults) {
                return ""
            }
            if ('_isRowNew' in comparisonResults[rowId] && comparisonResults[rowId]['_isRowNew']) {
                return 'green-compare'
            }
            if (comparisonResults[rowId][date][columnId] === 1) {
                return 'green-compare'
            }

            if (comparisonResults[rowId][date][columnId] === -1) {
                return 'red-compare'
            }
            return ''
        }
    }
}
