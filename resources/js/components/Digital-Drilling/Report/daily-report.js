import SelectInput from '../components/SelectInput'
import SelectAdd from '../components/SelectAdd'
import NozzlesTable from '../components/NozzlesTable'
import componentComposition from '../core/componentComposition'
import geologicalInformation from '../core/geologicalInformation'
import threadTypesJson from '../core/threadType'
import inclino from '../core/inclino'
import mudDaily from '../core/drillingmudDaily'
import moment from "moment";
import PreviousDailyRaport from './PreviousDailyRaport'

export default {
    name: "DailyRaport",
    components: {SelectInput, NozzlesTable, SelectAdd, PreviousDailyRaport},
    props: ['report', 'user', 'isEdit', 'show', 'fixedStyle'],
    data(){
        return{
            validationError: false,
            validationErrorMinMax: [
                {name: '', check: true}
            ],
            reportDate: moment(this.report.report_daily.date, 'DD-MM-YYYY').format('YYYY-MM-DD'),
            saveModal: false,
            previous: false,
            previousReport: false,
            summTotalTime: '00:00',
            pump:[
                {
                    number: 3,
                    active: false
                },
                {
                    number: 4,
                    active: false
                },
            ],
            newMudDaily: mudDaily,
            componentComposition: componentComposition,
            geologicalInformation: geologicalInformation,
            inclino: inclino,
            threadTypesJson: threadTypesJson,
            catalog: '',
            catalogCompany: {
                name_ru: '',
                bin: ''
            },
            currentCatalogAdd: {
                name: '',
                url: '',
                type: '',
            },
            headDrilling: '',
            companyName: {
                id: '',
                name_ru: '',
            },
            Unit_Name: {
                id: '',
                name_ru: ''
            },
            manufacturer1: {
                id: '',
                name_ru: ''
            },
            manufacturer2: {
                id: '',
                name_ru: ''
            },
            catalogError: false,
            catalogModal: false,
            catalogModalCompany: false,
            rigCharacteristic: [],
            addRigModal: false,
            addRigModalError: false,
            constructors: [],
            bushings:[],
            diameters:[],
            drillingMudTypes: [],
            BHAelements: [],
            operationCodes:[],
            chemicalNames:['Бикорбанат натрия', 'Биополимер ксантановый Гламин', 'Калий Хлор', 'Лубрикон ТУ',
                'ATREN Antifoam (гаспен силикон)', 'Atren Bio (Биоцидол)', 'PAC LV - ХимПАК В',
                'PAC HV - ХимПАК Н', 'Aquaflo LV', 'Асфасол', 'Известь Са(ОН)2 тн',
                'Ингидол ДТ - 1 противосальниковая', 'Ингидол ГГЛ', 'Ингидол Б',
                'FRACSEAL (Кислотнорастворимый)', 'Desco CF', 'Карбонат Кальция (SOLUFLAKE D хлопьевидный)',
                'Биксол Фри', 'БИОЦИДОЛ - бактерицид', 'Карбонат Кальция М-5', 'Карбонат Кальция М-50',
                'Гаммаксан/Ксантангам/Гламин (биополимер)', 'Полимер акриловый (PHPA) ',
                'Бентонит порошкообразный для струтуро образования', 'Лимонная кислота',
                'Ореховая скорлупа', 'Соль техническая', 'Шелуха рисовая', 'Ингибитор глин, Стабилайт II',
                'Микрошарик, 500-1000 мкм', 'Микрошарик, 150-600 мкм' ],
            threadTypes: [],
            pumps: [],
            timeSpents: ['Организ. простой', 'Ремонт после 21 часа', 'Осложения по стволу', 'Авария',
                'Неэффективность работы', 'Ожидание оборудования', 'Ожидание персонала',
                'Ожидание техники', 'Некачествен. цементир.', 'Ожидание указ. Заказчика',
                'Подогрев оборудования', 'Ожидание химреагентов', 'Отключение элек.энерг. ', 'Превыш. нормы времени'],
            stratigraphy: [],
            lithology: [],
            drillingContractors: [],
            deviceType: [],
            bitWare: {
                I: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                O: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                D: ["BC", "BF", "BT", "BU", "CC", "CD", "CI", "CR", "CT", "ER", "FC", "HC", "JD", "LC", "LN",
                    "LT", "OC", "PB", "PN", "RG", "RO", "SD", "SS", "TR", "WO", "WT", "NO"],
                L: ["C", "N", "T", "S", "G", "A" ],
                B: [0, 1, 2, 3, 4, 5, 6, 7, 8, "E", "F", "N", "X"],
                G: [1, "1/16", "1/8", "1/4"],
                D1:  ["BC", "BF", "BT", "BU", "CC", "CD", "CI", "CR", "CT", "ER", "FC", "HC", "JD", "LC", "LN",
                    "LT", "OC", "PB", "PN", "RG", "RO", "SD", "SS", "TR", "WO", "WT", "NO"],
                R: ["BHA", "CM", "CP", "DMF", "DP", "DSF", "DST", "DTF", "FM", "HP", "HR",
                    "LIH”", "LOG;", "PP”", "PR”", "RIG", "TD”", "TQ", "TW", "WC"],
            },
            bit_cond_iadc_letter: {
                I: 'inner_rows',
                O: 'outer_rows',
                D: 'dull_characteristics',
                L: 'location',
                B: 'bearing_seals',
                G: 'gauge',
                D1: 'other_dull_characteristics',
                R: 'reason_for_pulling_bit',

            },
            bitWareLetters: ["I", "O", "D", "L", "B", "G", "D1", "R"],
            operation1: [],
            operation2: [],
            drillingRigTypes:[],
            drillingRig:[],
            nameChemicals: [],
            NozzlesTable: {
                7: [ 0.038, 0.075,  0.113,  0.150,  0.188,  0.225,  0.263,  0.301,  0.338,  0.376],
                8: [ 0.049, 0.098,  0.147,  0.196,  0.245,  0.295,  0.344,  0.393,  0.442,  0.491],
                9: [0.062,	0.124,	0.186,	0.249,	0.311,	0.373,	0.435,	0.497,	0.559,	0.621],
                10:[ 0.077,	0.153,	0.230,	0.307,	0.383,	0.460,	0.537,	0.614,	0.690,	0.767],
                11:[ 0.093,	0.186,	0.278,	0.371,	0.464,	0.557,	0.650,	0.742,	0.835,	0.928],
                12:[ 0.110,	0.221,	0.331,	0.442,	0.552,	0.663,	0.773,	0.884,	0.994,	1.104],
                13:[ 0.130,	0.259,	0.389,	0.518,	0.648,	0.778,	0.907,	1.037,	1.167,	1.296],
                14:[ 0.150,	0.301,	0.451,	0.601,	0.752,	0.902,	1.052,	1.203,	1.353,	1.503],
                15:[ 0.173,	0.345,	0.518,	0.690,	0.863,	1.035,	1.208,	1.381,	1.553,	1.726],
                16:[ 0.196,	0.393,	0.589,	0.785,	0.982,	1.178,	1.374,	1.571,	1.767,	1.963],
                18:[ 0.249,	0.497,	0.746,	0.994,	1.243,	1.491,	1.740,	1.988,	2.237,	2.485],
                20:[ 0.307,	0.614,	0.920,	1.227,	1.534,	1.841,	2.148,	2.454,	2.761,	3.068],
                22:[ 0.371,	0.742,	1.114,	1.485,	1.856,	2.227,	2.599,	2.970,	3.341,	3.712],
                24:[ 0.442,	0.884,	1.325,	1.767,	2.209,	2.651,	3.093,	3.534,	3.976,	4.418],
                26:[ 0.518,	1.037,	1.555,	2.074,	2.592,	3.111,	3.629,	4.148,	4.666,	5.185],
                28:[ 0.601,	1.203,	1.804,	2.405,	3.007,	3.608,	4.209,	4.811,	5.412,	6.013],
                30:[ 0.690,	1.381,	2.071,	2.761,	3.451,	4.142,	4.832,	5.522,	6.213,	6.903],
                32:[ 0.785,	1.571,	2.356,	3.142,	3.927,	4.712,	5.498,	6.283,	7.069,	7.854],

            },
            Nozzles: [7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 18, 20, 22, 24, 26, 28, 30, 32],
            bitTypes:[],
            manufacturers: [],
            bitDiameters: [],
            unitNames: ['ZJ-10', 'ZJ-15', 'ZJ-20', 'ZJ-30', 'ZJ-40', 'ZJ-40/2250DBT', 'ZJ-50', 'ZJ-70', 'МБУ ZJ-30',
                'МБУ ZJ-30/27', 'МБУ-125', 'МБУ-140', 'МБУ-160', 'XJ-120', 'XJ-100', 'XJ-350', 'XJ-450',
                'XJ-550', 'XJ-750', 'XCMG XZ360E', 'XCMG XR150d', 'IRI IDECO-270', 'АРБ-100', 'VR-500'],
        }
    },
    watch:{
        report(){
            this.reportDate = moment(this.report.report_daily.date, 'DD-MM-YYYY').format('YYYY-MM-DD')
            this.getResourses()
        },
    },
    mounted(){
        if (this.show){
            this.openForShow()
        } else{
            this.getResourses()
        }

    },
    methods: {
        getResourses(){
            this.getRigType()
            this.getRig()
            this.getBitDiameters()
            this.getDrillingMudTypes()
            this.getThreadTypes()
            this.getDiameters()
            this.getConstructors()
            this.getDrillingContractors()
            this.getOperationCodes()
            this.getBitTypes()
            this.getManufacturers()
            this.getPumps()
            this.getBushings()
            this.getNameChemicals()
            this.getStratigraphy()
            this.getLithology()
            this.getOperation1()
            this.getoperation2()
            this.getDeviceType()
            this.getBHAelements()
            this.changeTotalTime(24)
            this.changeTotalTime(6)
        },
        closeReport(){
            this.$emit('closeReport')
        },
        getPreviousDay(){
            let date = new Date();
            date.setDate(date.getDate() - 1);
            return moment(date).format('YYYY-MM-DD') ;
        },
        editReport(id){
            this.previous = false
            this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/report/'+id).then((response) => {
                if (response) {
                    this.$emit('changeReport', response.data)
                } else {
                    console.log("No data");
                }
            })
                .catch((error) => {
                    console.log(error)
                    this.showToast('', 'No result', 'danger');
                })
        },
        openForShow(){
            this.previousReport = this.report
            this.previous = true
        },
        changeDate(){
            let date =  moment(this.reportDate, 'YYYY-MM-DD').format('DD-MM-YYYY')
            this.axios.post(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/report/well/date',{
                well: this.report.general_data_daily.well.id,
                date: date
            }).then((response) => {
                if (response) {
                    this.previousReport = response.data
                    this.previous = true
                } else {
                    console.log("No data");
                }
            })
                .catch((error) => {
                    console.log(error)
                    this.showToast('', 'No result', 'danger');
                })
            this.reportDate = moment(this.report.report_daily.date, 'DD-MM-YYYY').format('YYYY-MM-DD')

        },
        changePreviousReport(report){
            this.previousReport = report
        },
        getPreviousReport(){
            if (this.report.previous_report.id) {
                this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/report/'+this.report.previous_report.id).then((response) => {
                    if (response) {
                        this.previousReport = response.data
                    } else {
                        console.log("No data");
                    }
                })
                    .catch((error) => console.log(error))
            }

        },
        nozzleSelect(index){
            let nozzles = ['nozzle_1', 'nozzle_2', 'nozzle_3', 'nozzle_4', 'nozzle_5', 'nozzle_6', 'nozzle_7']
            let nozzleValues = []
            let sum = 0
            if (index == 1){
                for (let i=0; i<nozzles.length; i++) {
                    nozzleValues.push(this.report.bit_info_daily[0].nozzle[nozzles[i]])
                }
                let counts = {};
                nozzleValues.forEach(function(x) { counts[x] = (counts[x] || 0)+1; });
                for (const [key, value] of Object.entries(counts)) {
                    if (key){
                        sum += this.NozzlesTable[key][value-1]
                    }
                }
                this.report.bit_info_daily[0].tfa = sum.toFixed(3)
            }else  if (index == 2){
                for (let i=0; i<nozzles.length; i++) {
                    nozzleValues.push(this.report.bit_info_daily[1].nozzle[nozzles[i]])
                }
                let counts = {};
                nozzleValues.forEach(function(x) { counts[x] = (counts[x] || 0)+1; });
                for (const [key, value] of Object.entries(counts)) {
                    if (key){
                        sum += this.NozzlesTable[key][value-1]
                    }
                }
                this.report.bit_info_daily[1].tfa = sum.toFixed(3)
            }
        },
        addMudDaily(){
            this.report.drilling_mud_daily.push(this.newMudDaily)
        },
        deleteMudDaily(index){
            this.report.drilling_mud_daily.splice(index, 1);
        },
        addComposition(){
            this.report.drilling_mud_composition_daily.push(this.componentComposition)
        },
        deleteComposition(index){
            this.report.drilling_mud_composition_daily.splice(index, 1);
        },
        addInclino(){
            this.report.incl_daily.push({
                "depth": "",
                "alt": "",
                "angle": "",
                "bearing": "",
                "equip_type": {
                    "id": "",
                    "name_ru": ""
                }
            })
        },
        deleteInclino(index){
            this.report.incl_daily.splice(index, 1);
        },
        addStratigraphy(){
            this.report.geo_data_daily.push({
                "stratigraphy": {
                    "id": "",
                    "name_ru": ""
                },
                "plan_top_of_formation": "",
                "fact_top_of_formation": "",
                "thickness_top_of_formation": "",
                "lithology": {
                    "id": "",
                    "name_ru": ""
                },
                "formation_pressure_gradient": "",
                "frac_gradient": ""
            })
            this.report.coring_daily.push({
                "age": "",
                "interval": "",
                "plan": "",
                "fact": "",
                "percentage": ""
            })
        },
        deleteStratigraphy(index){
            this.report.geo_data_daily.splice(index, 1);
            this.report.coring_daily.splice(index, 1);
        },
        addConsDaily(){
            this.report.material_cons_daily.push({
                "name": "",
                "last": "",
                "receipts": "",
                "consumption": "",
                "total_balance": ""
            })
        },
        deleteConsDaily(index){
            this.report.material_cons_daily.splice(index, 1);
        },
        saveReport(){
            let validate = true
            for (let i=0; i< this.validationErrorMinMax.length; i++){
                if (this.validationErrorMinMax[i].check == false){
                    validate = false
                    break
                }
            }
            if (this.checkRequiredValue() == true && validate) {
                this.validationError = false
                if (this.isEdit){
                    this.axios.put(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/report/'+this.report.report_daily.id,
                        this.report).then((response) => {
                        if (response) {
                            this.$bvToast.toast("Отчет создан!!", {
                                title: "Отчет",
                                variant: "success",
                                solid: true,
                                toaster: "b-toaster-top-center",
                                autoHideDelay: 8000,
                            });
                            window.location.href = this.localeUrl('/digital-drilling');
                        } else {
                            console.log("No data");
                        }
                    }).catch((error) =>{
                        console.log(error)
                        this.$bvToast.toast("Ошибка!!", {
                            title: "Отчет",
                            variant: "danger",
                            solid: true,
                            toaster: "b-toaster-top-center",
                            autoHideDelay: 8000,
                        });
                        this.saveModal = false
                    })
                } else{
                    this.axios.post('http://172.20.103.68:8630' + '/digital_drilling/daily_report/report',
                        this.report).then((response) => {
                        if (response) {
                            window.location.href = this.localeUrl('/digital-drilling');
                        } else {
                            console.log("No data");
                        }
                    }).catch((error) =>{
                        console.log(error)
                        this.$bvToast.toast("Ошибка!!", {
                            title: "Отчет",
                            variant: "danger",
                            solid: true,
                            toaster: "b-toaster-top-center",
                            autoHideDelay: 8000,
                        });
                        this.saveModal = false
                    })
                }
            }else{
                this.validationError = true
                this.saveModal = false
            }


        },
        checkRequiredValue(){
            let check = true
            for (let prop in this.report.general_data_daily) {
                if (prop == 'rig'){
                    if (this.report.general_data_daily[prop].name_ru == ''){
                        check =  false
                        break
                    }
                }else if(prop == 'rig_type'){
                    if (this.report.general_data_daily[prop].name_ru == ''){
                        check =  false
                        break
                    }
                }
                else {
                    if (this.report.general_data_daily[prop] == '' && prop!= 'previous_bhd' && prop!='drilling_progress') {
                        check =  false
                        break
                    }
                }
            }
            if (check){
                for (let prop in this.report.drilling_parameters_daily) {
                    if (this.report.drilling_parameters_daily[prop] == '') {
                        check =  false
                        break
                    }
                }
            }
            if (check){
                for (let prop in this.report.contractor_daily) {
                    if (prop == 'contractor'){
                        if (this.report.contractor_daily[prop].name_ru == ''){
                            check =  false
                            break
                        }
                    } else {
                        if (this.report.contractor_daily[prop] == '') {
                            check =  false
                            break
                        }
                    }
                }
            }
            return check
        },

        checkMinMaxLength(value, min, max, name){
            let check = true
            if (value != ""){
                if (max==null){
                    if (value>=min){
                        check = true
                    } else {
                        check = false
                    }
                }else{
                    if (value>=min && value<=max){
                        check = true
                    } else {
                        check = false
                    }
                }
            }
            let isHas = false
            for (let i=0; i<this.validationErrorMinMax.length; i++) {
                if(this.validationErrorMinMax[i].name == name){
                    isHas = true
                    this.validationErrorMinMax[i].check = check
                }
            }
            if (!isHas){
                this.validationErrorMinMax.push({
                    name: name,
                    check: check
                })
            }
        },
        checkMinMaxLengthVar(value, min, max){
            let check = true
            if (value != ""){
                if (max==null){
                    if (value>=min){
                        check = true
                    } else {
                        check = false
                    }
                }else{
                    if (value>=min && value<=max){
                        check = true
                    } else {
                        check = false
                    }
                }
            }
            return check
        },
        saveCatalog(){
            if (this.catalog != '') {
                this.axios.post(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/dictionary/'+this.currentCatalogAdd.url+'/',
                    {name_ru: this.catalog}).then((response) => {
                    if (response.data) {
                        this.catalogModal = false
                        switch (this.currentCatalogAdd.url) {
                            case "manufacturer":
                                switch (this.currentCatalogAdd.type){
                                    case "manufacturer1":
                                        this.manufacturer1 = response.data
                                        this.report.bit_info_daily[0].manufacturer = response.data
                                        break
                                    case "manufacturer2":
                                        this.manufacturer2 = response.data
                                        this.report.bit_info_daily[1].manufacturer = response.data
                                        break
                                }
                                this.getManufacturers()
                                break
                            case "pump_barrel":
                                for (let i=0; i<this.report.pump_daily.length; i++) {
                                    if (this.currentCatalogAdd.type == 'bushings'+i){
                                        this.report.pump_daily[i].pump_barrel_type = response.data
                                        break
                                    }
                                }
                                this.getBushings()
                                break
                            case "pump_type":
                                for (let i=0; i<this.report.pump_daily.length; i++) {
                                    if (this.currentCatalogAdd.type == 'pump'+i){
                                        this.report.pump_daily[i].pump_type = response.data
                                        break
                                    }
                                }
                                this.getPumps()
                                break
                            case "mud_composition":
                                for (let i=0; i<this.report.drilling_mud_composition_daily.length; i++) {
                                    if (this.currentCatalogAdd.type == 'chemical_name'+i){
                                        this.report.drilling_mud_composition_daily[i].mud_composition= response.data
                                        break
                                    }
                                }
                                this.getNameChemicals()
                                break
                            case "stratigraphy":
                                for (let i=0; i<this.report.geo_data_daily.length; i++) {
                                    if (this.currentCatalogAdd.type == 'stratigraphy'+i){
                                        this.report.geo_data_daily[i].stratigraphy = response.data
                                        break
                                    }
                                }
                                this.getStratigraphy()
                                break
                            case "lithology":
                                for (let i=0; i<this.report.geo_data_daily.length; i++) {
                                    if (this.currentCatalogAdd.type == 'lithology'+i){
                                        this.report.geo_data_daily[i].lithology = response.data
                                        break
                                    }
                                }
                                this.getLithology()
                                break
                            case "device_type":
                                for (let i=0; i<this.report.incl_daily.length; i++) {
                                    if (this.currentCatalogAdd.type == 'inclino1'+i){
                                        this.report.incl_daily[i].equip_type = response.data
                                        break
                                    }
                                }
                                this.getDeviceType()
                                break
                            case "screw_size":
                                for (let i=0; i<this.report.bha_daily.length; i++) {
                                    if (this.currentCatalogAdd.type == 'threadTypes'+i){
                                        this.report.bha_daily[i].screw_size = response.data
                                        break
                                    }
                                }
                                this.getThreadTypes()
                                break
                        }
                        this.catalogError = false
                        this.catalog = ""
                    } else {
                        console.log("No data");
                    }
                })
                    .catch((error) => console.log(error))
            }else{
                this.catalogError = true
            }
        },
        saveCatalogCompany(){
            if (this.catalogCompany.name_ru == '' || this.catalogCompany.bin == '' || this.catalogCompany.bin.toString().length !=12) {
                this.catalogError = true
            }else{
                this.catalogError = false
                this.axios.post(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/dictionary/'+this.currentCatalogAdd.url+'/',
                    this.catalogCompany).then((response) => {
                    if (response.data) {
                        this.companyName = response.data
                        this.report.contractor_daily.contractor = response.data
                        this.catalogModalCompany = false
                        this.getDrillingContractors()
                    } else {
                        console.log("No data");
                    }
                })
                    .catch((error) => console.log(error))
            }
        },
        openCatalog(name, url, catalog){
            if (name == "Буровой подрядчик") {
                this.catalogModalCompany = true
            }else{
                this.catalogModal = true
            }
            this.currentCatalogAdd.name = name
            this.currentCatalogAdd.url = url
            this.currentCatalogAdd.type = catalog
        },
        selectOption(item, name){
            switch (name) {
                case "drillingContractors":
                    this.companyName = item
                    this.report.contractor_daily.contractor = item
                    break
                case "Unit_Name":
                    this.report.general_data_daily.rig = item
                    break
                case "manufacturer1":
                    this.manufacturer1 = item
                    this.report.bit_info_daily[0].manufacturer = item
                    break
                case "manufacturer2":
                    this.manufacturer2 = item
                    this.report.bit_info_daily[1].manufacturer = item
                    break
            }
            for (let i=0; i<this.report.drilling_mud_composition_daily.length; i++) {
                if (name == 'chemical_name'+i){
                    this.report.drilling_mud_composition_daily[i].mud_composition = item
                    break
                }
            }
            for (let i=0; i<this.report.pump_daily.length; i++) {
                if (name == 'pump'+i){
                    this.report.pump_daily[i].pump_type = item
                    break
                }else if (name == 'bushings'+i){
                    this.report.pump_daily[i].pump_barrel_type = item
                    break
                }
            }
            for (let i=0; i<this.report.bha_daily.length; i++) {
                if (name == 'threadTypes'+i){
                    this.report.bha_daily[i].screw_size = item
                    break
                }
            }
            for (let i=0; i<this.report.geo_data_daily.length; i++) {
                if (name == 'stratigraphy'+i){
                    this.report.geo_data_daily[i].stratigraphy = item
                    break
                }else if(name =="lithology"+i){
                    this.report.geo_data_daily[i].lithology = item
                    break
                }
            }
            for (let i=0; i<this.report.incl_daily.length; i++) {
                if (name == 'inclino1'+i){
                    this.report.incl_daily[i].equip_type = item
                    break
                }
            }
        },
        uploadRig(){
            this.rigCharacteristic[0][0].value = this.companyName.id
            this.rigCharacteristic[0][1].value = this.headDrilling
            if (this.rigCharacteristic[0][0].value == "" || this.rigCharacteristic[0][1].value == ""){
                this.addRigModalError = true
            }else{
                this.addRigModalError = false
            }
            if(this.rigCharacteristic[1][0].value==''){
                this.addRigModalError = true
            }else{
                this.addRigModalError = false
            }
            if (!this.addRigModalError) {
                this.axios.post(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/reports/rig',{array: this.rigCharacteristic}).then((response) => {
                    if (response.data) {
                        this.Unit_Name = response.data[0]
                        this.addRigModal = false
                        this.getRig()
                    } else {
                        console.log("No data");
                    }
                })
                    .catch((error) => console.log(error))

            }

        },
        addItemRig(){
            if (this.addRigModal){
                this.addRigModal = false
                document.body.overflow = 'auto'
            } else{
                document.body.overflow = 'hidden'
                this.addRigModal = true
                this.getRigCharacteristic()
            }
        },
        getRigCharacteristic(){
            this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/reports/rig').then((response) => {
                let data = response.data;
                this.rigCharacteristic = data
            });

        },
        getDeviceType(){
            this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/dictionary/device_type/').then((response) => {
                let data = response.data;
                this.deviceType = data
            });

        },
        getBHAelements(){
            this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/dictionary/bha_element/').then((response) => {
                let data = response.data;
                this.BHAelements = data
            });

        },
        getOperation1(){
            this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/dictionary/prod_operation/').then((response) => {
                let data = response.data;
                this.operation1 = data
            });

        },
        getoperation2(){
            this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/dictionary/unprod_operation/').then((response) => {
                let data = response.data;
                this.operation2 = data
            });

        },
        getStratigraphy(){
            this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/dictionary/stratigraphy/').then((response) => {
                let data = response.data;
                this.stratigraphy = data
            });

        },
        getLithology(){
            this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/dictionary/lithology/').then((response) => {
                let data = response.data;
                this.lithology = data
            });

        },
        getNameChemicals(){
            this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/dictionary/mud_composition/').then((response) => {
                let data = response.data;
                this.nameChemicals = data
            });

        },
        getBushings(){
            this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/dictionary/pump_barrel/').then((response) => {
                let data = response.data;
                this.bushings = data
            });

        },
        getPumps(){
            this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/dictionary/pump_type/').then((response) => {
                let data = response.data;
                this.pumps = data
            });

        },
        getManufacturers(){
            this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/dictionary/manufacturer/').then((response) => {
                let data = response.data;
                this.manufacturers = data
            });

        },
        getDiameters(){
            this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/dictionary/casing_diameter/').then((response) => {
                let data = response.data;
                this.diameters = data
            });

        },
        getRig(){
            this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/dictionary/rig/').then((response) => {
                let data = response.data;
                this.drillingRig = data
            });

        },
        getRigType(){
            this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/dictionary/rig_type/').then((response) => {
                let data = response.data;
                this.drillingRigTypes = data
            });

        },
        getBitTypes(){
            this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/dictionary/chisel/').then((response) => {
                let data = response.data;
                this.bitTypes = data
            });

        },
        getBitDiameters(){
            this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/dictionary/bit_diameter/').then((response) => {
                let data = response.data;
                this.bitDiameters = data
            });

        },
        getDrillingMudTypes(){
            this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/dictionary/mud_type/').then((response) => {
                let data = response.data;
                this.drillingMudTypes = data
            });

        },
        getThreadTypes(){
            this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/dictionary/screw_size/').then((response) => {
                let data = response.data;
                this.threadTypes = data
            });

        },
        getOperationCodes(){
            this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/dictionary/operations_code/').then((response) => {
                let data = response.data;
                this.operationCodes = data
            });

        },
        getConstructors(){
            this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/dictionary/equip_type/').then((response) => {
                let data = response.data;
                this.constructors = data
            });

        },
        getDrillingContractors(){
            this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/dictionary/company/').then((response) => {
                let data = response.data;
                this.drillingContractors = data
            });

        },
        addPump(){
            if (!this.pump[0].active){
                this.pump[0].active = true
            } else{
                this.pump[1].active = true
            }
        },
        deletePump(index){
            this.pump[index-2].active = false
            this.report.pump_daily[index] = {
                "id": "",
                "pump_type": {
                    "id": "",
                    "name_ru": ""
                },
                "pump_barrel_type": {
                    "id": "",
                    "name_ru": ""
                },
                "coeff_type": "",
                "liters_type": "",
                "liquid_dens": "",
                "pressure": "",
                "pumping_pressure": [
                    {
                        "progress": "",
                        "depth": "",
                        "pressure": ""
                    },
                    {
                        "progress": "",
                        "depth": "",
                        "pressure": ""
                    },
                    {
                        "progress": "",
                        "depth": "",
                        "pressure": ""
                    },
                    {
                        "progress": "",
                        "depth": "",
                        "pressure": ""
                    }
                ]
            }
        },
        changeOveralTime(index){
            if (this.report.bit_info_daily[index].drilling_time) {
                this.report.bit_info_daily[index].overall_drilling_time = parseInt(this.report.bit_info_daily[index].prev_overall_drilling_time)
                    + parseInt(this.report.bit_info_daily[index].drilling_time)
            }else{
                this.report.bit_info_daily[index].overall_drilling_time = this.report.bit_info_daily[index].prev_overall_drilling_time
            }
        },
        sumBHA(){
            let arr = this.report.bha_daily
            for (let i=arr.length-1; i>=0; i--){
                if (arr[i].increasing_length) {
                    return parseInt(arr[i].increasing_length)
                }
            }
        },
        getSum(arr){
            let sum = 0
            for (let i=0; i<arr.length; i++){
                if (arr[i].hours) {
                    sum += parseInt(arr[i].hours)
                }
            }
            return sum
        },
        summSLT(index){
            this.report.slt_daily[index].overall = this.sumValues(this.report.slt_daily[index].previous, this.report.slt_daily[index].daily)
        },
        sumValues(a, b){
            if (!a){
                a = 0
            }
            if (!b){
                b = 0
            }
            if (!a && !b){
                return ''
            }
            return parseFloat(a) + parseFloat(b)
        },
        subtractValues(a, b){
            if (!a){
                a = 0
            }
            if (!b){
                b = 0
            }
            if (!a && !b){
                return ''
            }
            return parseFloat(a) - parseFloat(b)
        },
        getAllProdTime(type){
            let arr = []
            if(type=='un'){
                arr = this.report.unprod_time_daily
            }else{
                arr = this.report.prod_time_daily
            }
            let sum = 0
            for (let i=0; i<arr.length; i++){
                if (arr[i].previous && arr[i].daily) {
                    sum += parseFloat(arr[i].previous) + parseFloat(arr[i].daily)
                }
            }
            return sum
        },
        changeTotalTime(type){
            let arr = []
            if (type == 24){
                arr = this.report.job_status_daily
            }else{
                arr = this.report.job_status_6_hours
            }
            for (let i=0; i<arr.length; i++){
                this.getTotalTime(i, type)
            }
        },
        getTotalTime(i, type){
            let arr = []
            if (type == 24){
                arr = this.report.job_status_daily
            }else{
                arr = this.report.job_status_6_hours
            }
            if (arr[i].tbeg && arr[i].tend) {
                let startTime = arr[i].tbeg;
                let endTime = arr[i].tend;

                let todayDate = moment(new Date()).format("MM-DD-YYYY");

                let startDate = new Date(`${todayDate} ${startTime}`);
                let endDate = new Date(`${todayDate } ${endTime}`);
                let timeDiff = Math.abs(startDate.getTime() - endDate.getTime());

                let hh = Math.floor(timeDiff / 1000 / 60 / 60);
                hh = ('0' + hh).slice(-2)

                timeDiff -= hh * 1000 * 60 * 60;
                let mm = Math.floor(timeDiff / 1000 / 60);
                mm = ('0' + mm).slice(-2)

                arr[i].total_time = hh + ":" + mm
                if (startDate > endDate) {
                    if (mm == '00'){
                        arr[i].total_time = (24-hh)  + ":" + mm
                    } else{
                        arr[i].total_time = (23-hh)  + ":" + (60-mm)
                    }
                }
                if(type == 24){
                    this.getAllTotalTime()
                }

            }
        },
        getAllTotalTime(){
            let sum = '00:00:00'
            for (let i=0; i<this.report.job_status_daily.length; i++){
                if (this.report.job_status_daily[i].total_time){
                    let time = this.report.job_status_daily[i].total_time + ':00'
                    sum = this.formatTime(this.timestrToSec(sum) + this.timestrToSec(time));
                }
            }
            this.summTotalTime = sum.slice(0, -3);
        },
        timestrToSec(timestr) {
            let parts = timestr.split(":");
            return (parts[0] * 3600) +
                (parts[1] * 60) +
                (+parts[2]);
        },

        pad(num) {
            if(num < 10) {
                return "0" + num;
            } else {
                return "" + num;
            }
        },
        formatTime(seconds) {
            return [this.pad(Math.floor(seconds/3600)),
                this.pad(Math.floor(seconds/60)%60),
                this.pad(seconds%60),
            ].join(":");
        }

    }
}