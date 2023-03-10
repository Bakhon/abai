import moment from "moment-timezone";

export default {
    data: function () {
        return {
            isChemistryNeeded: true,
            isWellsWorkoverNeeded: true,
            columns: [
                {
                    prop: "column1",
                    size: 400,
                    cellProperties: ({prop, model, data, column}) => {
                        return {
                            style: {
                                border: '1px solid #F4F4F6',
                            },
                        };
                    },
                },
                {
                    prop: "column2",
                    size: 280,
                    cellProperties: ({prop, model, data, column}) => {
                        return {
                            style: {
                                border: '1px solid #F4F4F6'
                            },
                        };
                    },
                },
                {
                    prop: "column3",
                    size: 260,
                    cellProperties: ({prop, model, data, column}) => {
                        return {
                            style: {
                                border: '1px solid #F4F4F6'
                            },
                        };
                    },
                },
                {
                    prop: "column4",
                    size: 280,
                    cellProperties: ({prop, model, data, column}) => {
                        return {
                            style: {
                                border: '1px solid #F4F4F6'
                            },
                        };
                    },
                },
                {
                    prop: "column5",
                    size: 280,
                    cellProperties: ({prop, model, data, column}) => {
                        return {
                            style: {
                                border: '1px solid #F4F4F6'
                            },
                        };
                    },
                },{
                    prop: "column6",
                    size: 220,
                    cellProperties: ({prop, model, data, column}) => {
                        return {
                            style: {
                                border: '1px solid #F4F4F6'
                            },
                        };
                    },
                },
            ],
            rowsCount: 85,
            columnsCountForHighlight: {
                eightColumns: [0,1,2,3,4,5,6,7],
                sevenColumns: [0,1,2,3,4,5,6],
                sixColumns: [0,1,2,3,4,5],
                fiveColumns: [0,1,2,3,4],
                fourColumns: [0,1,2,3],
                threeColumns: [0,1,2],
                twoColumns: [0,1]
            },
            stringColumns: [1,2],
            errorSelectors: [],
            currentDate: moment().tz('Asia/Almaty').subtract(1, 'days').format('DD-MM-YYYY'),
            limitForEnteringData: {
                hours: 8,
                minutes: 0,
            },
            isChemistryButtonVisible: false,
            daysWhenChemistryNeeded: [5,6,7,8,9,10],
        };
    },
    created() {
        this.changeDateToToday();
    },
    methods: {
        changeDateToToday() {
            let almatyCurrentDate = moment().tz('Asia/Almaty');
            if (this.isDateShouldBeChanged(almatyCurrentDate)) {
                this.currentDate = almatyCurrentDate.format('DD-MM-YYYY');
                this.currentDateDetailed = almatyCurrentDate.format("YYYY-MM-DD HH:mm:ss");
            } else {
                this.currentDate = moment().subtract(1, 'days').format('DD-MM-YYYY');
                this.currentDateDetailed = moment().subtract(1, 'days').format("YYYY-MM-DD HH:mm:ss");
            }
        },
        isDateShouldBeChanged(almatyCurrentDate) {
            return almatyCurrentDate.hour() >= this.limitForEnteringData.hours && almatyCurrentDate.minutes() > this.limitForEnteringData.minutes && !this.bigDzo.includes(this.selectedDzo.ticker);
        },
        changeButtonVisibility() {
            this.isChemistryNeeded = !this.isChemistryNeeded;
        },
        changeWellBlockVisibility() {
            this.isWellsWorkoverNeeded = !this.isWellsWorkoverNeeded;
        },
        turnOffErrorHighlight() {
            let self = this;
            _.forEach(this.errorSelectors, function(selector) {
                self.removeClassFromElement($(selector),'cell__color-red');
            });
            this.errorSelectors = [];
        },
        setTableFormat() {
            for (let rowIndex = 0; rowIndex < this.rowsCount; rowIndex++) {
                if (this.rowsFormatMapping.title.includes(rowIndex)) {
                    this.selectClassForCell(rowIndex,this.getColumnsForHighLight(rowIndex),'cell-title','add');
                } else if (this.rowsFormatMapping.subTitle.includes(rowIndex)) {
                    this.selectClassForCell(rowIndex,this.getColumnsForHighLight(rowIndex),'cell-subtitle','add');
                }
            }
        },
        selectClassForCell(rowIndex,columnsList,className,action) {
            let self = this;
            columnsList.forEach(function(columnIndex) {
                if (action === 'add') {
                    self.setClassToElement($('#factGrid').find('div[data-col="'+ columnIndex + '"][data-row="' + rowIndex + '"]'),className);
                } else {
                    self.removeClassFromElement($('#factGrid').find('div[data-col="'+ columnIndex + '"][data-row="' + rowIndex + '"]'),className);
                }
            });
        },
        getColumnsForHighLight(rowIndex) {
            let columnFormat = 'one';
            let self = this;
            _.forEach(Object.keys(this.columnsFormatMapping), function(key) {
                if (self.columnsFormatMapping[key].includes(rowIndex)) {
                    columnFormat = key;
                }
            });
            return this.columnsCountForHighlight[columnFormat];
        },
        setClassToElement(el,className) {
            el.addClass(className);
        },
        removeClassFromElement(el, className) {
            el.removeClass(className);
        },
        disableHighlightOnCells() {
            for (let i = 0; i < this.rowsCount; i++) {
                this.selectClassForCell(i,this.columnsCountForHighlight.sixColumns,'cell-title cell-subtitle','remove');
            }
        },
        removeClassFromElement(el,className) {
            el.removeClass(className);
        },
    }
}