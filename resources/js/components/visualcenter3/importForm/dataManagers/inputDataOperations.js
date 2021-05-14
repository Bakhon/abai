export default {
    data: function () {
        return {
            currentCellOptions: {
                rowIndex: 0,
                columnIndex: 0
            }
        };
    },
    methods: {
        async pasteClipboardContent() {
            let clipText = await navigator.clipboard.readText();
            let clipRows = clipText.split(String.fromCharCode(13));

            for (let i = 0; i < clipRows.length; i++) {
                clipRows[i] = clipRows[i].split(String.fromCharCode(9));
            }

            if (clipRows.length < 40) {
                this.status = this.trans("visualcenter.importForm.status.dataIsNotValid");
                return;
            }
            let self = this;
            _.forEach(this.rows, function (row,index) {
                self.setColumnValues(row,clipRows,index);
            });
            this.refreshGridData();
            this.isDataExist = true;
        },
        setColumnValues(row,clipRows,rowIndex) {
          _.forEach(Object.keys(row), function(key) {
              let colIndex = parseInt(key.replace(/\D+/g, '')) - 1;
              row[key] = clipRows[rowIndex][colIndex];
          });
        },
        beforeRangeEdit(e) {
            this.setTableFormat();
            this.isDataExist = true;
            this.isDataReady = false;
        },
        addListeners() {
            let self = this;
            document.querySelector('revo-grid').addEventListener('keyup', function(e) {
                self.rows[self.currentCellOptions.rowIndex]['column' + self.currentCellOptions.columnIndex] = e.target.value;
                self.refreshGridData();
                self.isDataExist = true;
                self.isDataReady = false;
            });
            document.querySelector('revo-grid').addEventListener('dblclick', function(e) {
                self.currentCellOptions.rowIndex = parseInt(e.target.dataset.row);
                self.currentCellOptions.columnIndex = parseInt(e.target.dataset.col) + 1;
            });
            document.querySelector('revo-grid').addEventListener('click', function(e) {
                self.currentCellOptions.rowIndex = parseInt(e.target.dataset.row);
                self.currentCellOptions.columnIndex = parseInt(e.target.dataset.col) + 1;
            });
        },
        refreshGridData() {
            document.querySelector('revo-grid').refresh('all');
        },
    }
}