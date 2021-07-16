import moment from "moment";

export default {
    data: function () {
        return {
            previousPeriodStart: '',
            previousPeriodEnd: '',
            isOneDateSelected: true,
            timeSelectOld: '',
            range: {},
            modelConfig: {
                start: {
                    timeAdjust: '00:00:00',
                    type: 'string',
                    mask: 'YYYY-MM-DDTHH:mm:ssXXX',
                },
                end: {
                    timeAdjust: '23:59:00',
                    type: 'string',
                    mask: 'YYYY-MM-DDTHH:mm:ssXXX',
                },
            },
            selectedDate: "",
            selectedDMY: 0,
            timeSelect: "",
            chemistrySelectedDate: moment().format("MMMM-yyyy"),
            DMY: this.trans("visualcenter.day"),
            month: new Date().getMonth() + 1,
            year: new Date().getFullYear(),
            currentMonth: [],
            date2: new Date().toLocaleString("ru", {
                hour: "numeric",
                minute: "numeric",
            }),

            dFirstMonth: "0",
            day: ["Mn", "Tu", "We", "Th", "Fr", "Sa", "Su"],
            monthes: [
                "ЯНВАРЬ",
                "ФЕВРАЛЬ",
                "МАРТ",
                "АПРЕЛЬ",
                "МАЙ",
                "ИЮНЬ",
                "ИЮЛЬ",
                "АВГУСТ",
                "СЕНТЯБРЬ",
                "ОКТЯБРЬ",
                "НОЯБРЬ",
                "ДЕКАБРЬ",
            ],
            monthes3: [
                "",
                "январь",
                "февраль",
                "март",
                "апрель",
                "май",
                "июнь",
                "июль",
                "август",
                "сентябрь",
                "октябрь",
                "ноябрь",
                "декабрь",
            ],
            monthes2: [
                "Jan",
                "Feb",
                "Mar",
                "Apr",
                "May",
                "Jun",
                "Jul",
                "Aug",
                "Sep",
                "Oct",
                "Nov",
                "Dec",
            ],
            date: new Date(),
            selectedDay: undefined,
            selectedMonth: undefined,
            selectedYear: undefined,
            selectedPeriod: 0,
        };
    },
    methods: {
        setPreviousPeriod() {
            this.previousPeriodStart = moment(new Date(this.timestampToday)).subtract(this.quantityRange, 'days').format('DD.MM.YYYY');
            this.previousPeriodEnd = moment(new Date(this.timestampToday)).subtract(1, 'days').format('DD.MM.YYYY');
            this.currentMonthDateStart = moment(new Date(this.timestampToday)).subtract(1, 'months').format('MMMM YYYY');
            this.currentMonthDateEnd = moment(new Date(this.timestampEnd)).subtract(1, 'months').format('MMMM YYYY');
        },

        isOneDatePeriodSelected() {
            let periodStart = new Date(this.timestampToday);
            let periodEnd = new Date(this.timestampEnd);
            return this.formatDateWithoutTimezone(periodStart) === this.formatDateWithoutTimezone(periodEnd);
        },

        dayClicked() {
            this.changeMenu2('period');
        },

        periodSelect() {
            if (this.period === 0) {
                return this.$moment(new Date()).diff(this.$moment(new Date()).subtract(7, 'days'), 'days') + 1;
            }
            if (this.period === 1) {
                return this.$moment(new Date()).diff(this.$moment(new Date()).subtract(1, 'months'), 'days') + 1;
            }
            if (this.period === 2) {
                return this.$moment(new Date()).diff(this.$moment(new Date()).subtract(3, 'months'), 'days') + 1;
            }
            if (this.period === 3) {
                return this.$moment(new Date()).diff(this.$moment(new Date()).subtract(1, 'years'), 'days') + 1;
            }
            if (this.period === 4) {
                return null;
            }
        },

        changeDate() {
            this.selectedDay = 0;
            this.timestampToday = this.formatDateWithoutTimezone(new Date(this.range.start));
            this.timestampEnd = new Date(this.range.end).getTime();
            let differenceBetweenDates = this.timestampEnd - this.timestampToday;
            this.quantityRange = Math.trunc((Math.abs(differenceBetweenDates) / 86400000) + 1);
            this.timeSelect = new Date(this.range.start).toLocaleDateString();
            this.chemistrySelectedDate = moment(new Date(this.range.start).toString()).format("MMM yyyy");
            this.timeSelectOld = new Date(this.range.end).toLocaleDateString();
            this.updateProductionData(this.planFieldName, this.factFieldName, this.chartHeadName, this.metricName, this.chartSecondaryName);
            this.getCurrencyNow(new Date().toLocaleDateString());
            this.updatePrices(this.period);
        },

        formatDateWithoutTimezone(date) {
            return new Date(date.getFullYear(), date.getMonth(), date.getDate(), 0, 0, 0).getTime();
        },

        menuDMY() {
            var DMY = ["День", "Месяц", "Год"];
            var menuDMY = [];
            var id = 0;
            for (let i = 0; i <= 2; i++) {
                var a = {index: i, id: i};
                a.DMY = DMY[i];
                menuDMY.push(a);
                if (this.selectedPeriod == i) {
                    a.current = "#1D70B7";
                    this.DMY = menuDMY[i]["DMY"];
                }
            }

            localStorage.setItem("selectedPeriod", this.selectedPeriod);
            return menuDMY;
        },
    },
}