import moment from "moment";

export default {
    methods: {
        formatDigitToThousand(num) {
            if (num == null) {
                return 0;
            }
            if (this.quantityRange < 2) {
                this.thousand = '';
                return new Intl.NumberFormat("ru-RU").format(Math.round(num));
            } else {
                this.thousand = this.trans("visualcenter.thousand");
                if (num >= 1000) {
                    num = (num / 1000).toFixed(0)
                } else if (num >= 100) {
                    num = Math.round((num / 1000) * 10) / 10
                } else if (num >= 10) {
                    num = Math.round((num / 1000) * 100) / 100
                } else if (num > 0) {
                    num = 0.01
                } else {
                    num = 0;
                }
                return new Intl.NumberFormat("ru-RU").format(num)
            }
        },

        ISODateString(d) {
            function pad(n) {
                return n < 10 ? '0' + n : n
            }

            return d.getUTCFullYear() + '-'
                + pad(d.getUTCMonth() + 1) + '-'
                + pad(d.getUTCDate()) + 'T'
                + pad(d.getUTCHours()) + ':'
                + pad(d.getUTCMinutes()) + ':'
                + pad(d.getUTCSeconds()) + '+06:00'
        },

        getDiffProcentLastBigN(a, b) {
            if (a != '') {
                return ((a / b) * 100).toFixed(2);
            } else {
                return 0
            }
        },

        getDiffProcentLastP(a, b, c) {
            if (c) {
                if (a > b) {
                    return 'Снижение'
                } else if (a < b) {
                    return 'Рост'
                }
                ;
            } else {
                if (b == 0) {
                    return 0
                } else if (a == 0) {
                    return 0
                }
                {
                    if (a != '') return ((b / a - 1) * 100).toFixed(2)
                }
            }
        },

        pad(n) {
            return n < 10 ? "0" + n : n;
        },

        getNameDzoFull: function (dzo) {
            if (typeof this.NameDzoFull[dzo] !== 'undefined') {
                return this.NameDzoFull[dzo]
            }
            return dzo;
        },

        getDaysCountInYear() {
            let currentDate = new Date(this.timestampToday);
            let yearEnd = moment().endOf("year");

            return yearEnd.diff(currentDate, 'days')
        },

        getQuarter(d) {
            return [parseInt(d.getMonth() / 3) + 1, d.getFullYear()];
        },

        getPreviousWorkday(){
            let workday = moment();
            let day = workday.day();
            let diff = 1;
            if (day === 0 || day === 1){
                diff = day + 2;
            }
            return workday.subtract(diff, 'days').format();
        },

        formatVisTableNumber3(a, b) {
            if (a && b) {
                return new Intl.NumberFormat("ru-RU").format(Math.abs(((a - b) / b) * 100).toFixed(1))
            } else {
                return 0
            }
        },

        getFormattedNumber(num) {
            return (new Intl.NumberFormat("ru-RU").format(Math.round(num)))
        },
    },
    computed: {
        periodSelectFunc() {
            let DMY = [
                // "Неделя",
                this.trans("visualcenter.week"),
                // "Месяц",
                this.trans("visualcenter.Month"),
                // "Квартал",
                this.trans("visualcenter.Quarter"),
                // "Год",
                this.trans("visualcenter.Year"),
                // "Всё"
                this.trans("visualcenter.All")
            ];
            let DMY_titles = [
                // "За последние 7 дней",
                this.trans("visualcenter.kurs7day"),
                // "За последний месяц",
                this.trans("visualcenter.kurslastmonth"),
                // "За последние 3 месяца",
                this.trans("visualcenter.kurs3month"),
                // "За последний год",
                this.trans("visualcenter.kurslastyear"),
                // "За всё время"
                this.trans("visualcenter.kursalltime"),
            ];

            let menuDMY = [];
            let id = 0;

            for (let i = 0; i <= 4; i++) {
                let a = {
                    index: i,
                    id: i,
                    active_oil: false,
                    active_usd: false,
                };

                a.DMY = DMY[i];
                a.DMY_title = DMY_titles[i];
                menuDMY.push(a);

                if (this.period === i) {
                    a.active = true;
                    this.DMY = menuDMY[i]["DMY"];
                }
            }
            return menuDMY;
        },
    },
}