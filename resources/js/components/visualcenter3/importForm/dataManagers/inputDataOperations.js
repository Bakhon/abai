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
        async getClipboardContent() {
            let clipText = await navigator.clipboard.readText();
            let clipRows = clipText.split(String.fromCharCode(13));

            for (let i = 0; i < clipRows.length; i++) {
                clipRows[i] = clipRows[i].split(String.fromCharCode(9));
            }
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
                document.querySelector('revo-grid').refresh('all');
            });
            document.querySelector('revo-grid').addEventListener('dblclick', function(e) {
                self.currentCellOptions.rowIndex = parseInt(e.target.dataset.row);
                self.currentCellOptions.columnIndex = parseInt(e.target.dataset.col) + 1;
            });
        }
    }
}