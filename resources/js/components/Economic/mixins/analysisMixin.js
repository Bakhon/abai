const DEFAULT_WELL = {
    uwi_count: 0,
    oil: 0,
    oil_loss: 0,
    liquid: 0,
    liquid_loss: 0,
    prs_portion: 0
}

export const tableDataMixin = {
    props: {
        wells: {
            required: true,
            type: Array
        }
    },
    computed: {
        wellsByStatuses() {
            let statuses = {}

            let dates = {}

            this.wells.forEach(well => {
                dates[well.date] = 1

                if (!statuses.hasOwnProperty(well.status_id)) {
                    statuses[well.status_id] = []
                }

                statuses[well.status_id].push(well)
            })

            dates = Object.keys(dates)

            return {
                statuses: statuses,
                dates: dates
            }
        },

        tableData() {
            return Object.keys(this.wellsByStatuses.statuses).map(status => {
                let wells = this.wellsByStatuses.statuses[status]

                return {
                    name: wells[0].status_name,
                    dates: this.wellsByStatuses.dates.map(date => {
                        let wellsByDate = wells.filter(well => well.date === date)

                        let profitable = wellsByDate.find(
                            well => well.profitability = 'profitable'
                        ) || DEFAULT_WELL

                        let profitless = wellsByDate.find(
                            well => well.profitability = 'profitless'
                        ) || DEFAULT_WELL

                        let total = {}

                        Object.keys(DEFAULT_WELL).forEach(wellKey => {
                            total[wellKey] = profitable[wellKey] + profitless[wellKey]
                        })

                        return {
                            profitable: profitable,
                            profitless: profitless,
                            total: total
                        }
                    })
                }
            })
        },

        tableUwiCount() {
            return this.generateTable('uwi_count', 'Итого скважин')
        },

        tableOilLoss() {
            return this.generateTable('oil_loss', 'Итог потерь нефти')
        },

        tablePrs() {
            return this.generateTable('prs_portion', 'Общий итог')
        },

        statuses() {
            return Object.values(this.wellsByStatuses.statuses).map(status => {
                return {name: status[0].status_name}
            })
        },

        columns() {
            return [
                {
                    name: 'Всего',
                    key: 'total'
                },
                {
                    name: 'Рентаб.',
                    key: 'profitable'
                },
                {
                    name: 'Нерент.',
                    key: 'profitless'
                },
            ]
        },
    },
    methods: {
        generateTable(wellKey, sumTitle) {
            let rows = this.wellsByStatuses.dates.map((date, dateIndex) => ({
                date: date,
                values: this.statuses.map((status, statusIndex) => {
                    status = this.tableData[statusIndex].dates[dateIndex]

                    return this.columns.map(column => status[column.key][wellKey])
                }),
                style: `background: ${dateIndex % 2 === 0 ? '#2B2E5E' : '#333868'}`
            }))

            rows.push({
                date: sumTitle,
                values: this.statuses.map((status, statusIndex) => {
                    status = this.tableData[statusIndex]

                    return this.columns.map(column => {
                        let sum = 0

                        status.dates.forEach(date => sum += date[column.key][wellKey])

                        return sum
                    })
                }),
                style: 'background: #293688; font-weight: 600'
            })

            return rows
        }
    }
}