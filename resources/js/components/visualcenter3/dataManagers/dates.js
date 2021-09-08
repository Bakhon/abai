import moment from "moment";

export default {
    data: function () {
        return {
            previousPeriodStart: '',
            previousPeriodEnd: '',
            isOneDateSelected: true,
            timeSelectOld: '',
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
            selectedMonth: undefined,
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