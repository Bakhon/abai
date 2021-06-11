const trHelper = {
    data: function () {
        return {
            textForms: {
                fields: [
                    'tr.field_e',
                    'tr.field_ya',
                    'tr.field_i',
                    'tr.field_ya',
                ],
                expMethods: [
                    'tr.way',
                    'tr.way_a',
                    'tr.way_v',
                    'tr.way_y',
                ],
                horizons: [
                    'tr.horizon',
                    'tr.horizon_a',
                    'tr.horizon_v',
                    'tr.horizon_y',
                ],
                objects: [
                    'tr.object',
                    'tr.object_a',
                    'tr.object_v',
                    'tr.object_y',
                ],
                blocks: [
                    'tr.block',
                    'tr.block_a',
                    'tr.block_v',
                    'tr.block_i',
                ],
            }
        }
    },
    methods: {
        declOfNum(n, row = "fields") {
            n = Math.abs(n) % 100;
            var n1 = n % 10;
            if (n > 10 && n < 20) {
                return this.textForms[row][2];
            }
            if (n1 > 1 && n1 < 5) {
                return this.textForms[row][1];
            }
            if (n1 == 1) {
                return this.textForms[row][0];
            }
            return this.textForms[row][2];
        },
        getFilterText (filter, options, field){
            if (filter.length === 0) {
                return this.trans('tr.choose') + ' ' + this.textForms[field][3];
            } else {
                return filter.join(', ');
            }
        }
    }
}

export default trHelper;
