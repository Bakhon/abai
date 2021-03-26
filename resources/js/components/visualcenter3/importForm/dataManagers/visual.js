

export default {
    data: function () {
        return {
            isChemistryNeeded: true,
            columns: [
                {
                    prop: "column1",
                    size: 440,
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
                    size: 330,
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
                    size: 280,
                    cellProperties: ({prop, model, data, column}) => {
                        return {
                            style: {
                                border: '1px solid #F4F4F6'
                            },
                        };
                    },
                },
            ],
            rowsCount: 75,
            columnsCountForHighlight: {
                sixColumns: [0,1,2,3,4,5],
                fiveColumns: [0,1,2,3,4],
                fourColumns: [0,1,2,3],
                threeColumns: [0,1,2],
                twoColumns: [0,1]
            },
            stringColumns: [1,2],
            errorSelectors: [],
        };
    },
    methods: {
        changeButtonVisibility() {
            this.isChemistryNeeded = !this.isChemistryNeeded;
        },
        turnOffErrorHighlight() {
            let self = this;
            _.forEach(this.errorSelectors, function(selector) {
                self.setClassToElement($(selector),'cell__color-normal');
            });
            this.errorSelectors = [];
        },
        setTableFormat() {
            for (let rowIndex = 0; rowIndex < this.rowsCount; rowIndex++) {
                if (this.rowsFormatMapping.title.includes(rowIndex)) {
                    this.selectClassForCell(rowIndex,this.getColumnsForHighLight(rowIndex),'cell-title');
                } else if (this.rowsFormatMapping.subTitle.includes(rowIndex)) {
                    this.selectClassForCell(rowIndex,this.getColumnsForHighLight(rowIndex),'cell-subtitle');
                }
            }
        },
        selectClassForCell(rowIndex,columnsList,className) {
            let self = this;
            columnsList.forEach(function(columnIndex) {
                self.setClassToElement($('div[data-col="'+ columnIndex + '"][data-row="' + rowIndex + '"]'),className);
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
    }
}