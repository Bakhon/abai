export default {
    methods: {
        filterSelect(text, val, optionsVal) {
            if (text == 'dzo') {
                optionsVal = (val.hasOwnProperty('oilFields') && val.oilFields.length) ? val.oilFields : [];
                this.oilFileds = 0;
                this.horizonts = 0;
                this.objects = 0;
            }  else if (text =='oil') {
                optionsVal = (val.hasOwnProperty('horizonts') && val.horizonts.length) ? val.horizonts : [];
                this.horizonts = 0;
                this.objects = 0;
            } else if (text == 'horizon') {
                optionsVal = (val.hasOwnProperty('objects') && val.objects.length) ? val.objects : [];
                this.objects = 0;
            }
        }
    }
}