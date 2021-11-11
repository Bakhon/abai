const DEFAULT_WELL = {
    uwi_count: 0,
    oil: 0,
    oil_loss: 0,
    liquid: 0,
    liquid_loss: 0,
    prs_portion: 0,
    prs_cost: 0,
    active_hours: 0,
    paused_hours: 0,
    total_hours: 0,
}

export const tableDataMixin = {
    props: {
        wells: {
            required: true,
            type: Array
        },
    },
    computed: {
        tableData() {
            let wellsByStatus = {}

            let dates = {}

            let statuses = {}

            this.wells.forEach(well => {
                dates[well.date] = 1

                if (!wellsByStatus.hasOwnProperty(well.status_id)) {
                    wellsByStatus[well.status_id] = []
                }

                statuses[well.status_id] = well.status_name

                wellsByStatus[well.status_id].push(well)
            })

            dates = Object.keys(dates)

            return {
                wellsByStatus: wellsByStatus,
                statuses: Object.keys(statuses),
                statusNames: Object.values(statuses),
                dates: dates
            }
        },

        wellsByDates() {
            return this.tableData.statuses.map((status, statusIndex) => ({
                status_name: this.tableData.statusNames[statusIndex],
                wells: this.tableData.dates.map(date => {
                    return this.getWellsByDate(status, date, 'wellsByStatus')
                }),
            }))
        },

        tableUwiCount() {
            return this.generateTable('uwi_count', 'Итого скважин')
        },

        tableOilLoss() {
            return this.generateTable('oil_loss', 'Итог потерь нефти')
        },

        tablePrs() {
            return this.generateTable('prs_cost', 'Общий итог')
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
            let statuses = Object.keys(this.tableData.statuses)

            let rows = this.tableData.dates.map((date, dateIndex) => ({
                date: date,
                values: statuses.map((status, statusIndex) => {
                    let wells = this.wellsByDates[statusIndex].wells[dateIndex]

                    return this.columns.map(column => wells[column.key][wellKey])
                }),
                style: `background: ${dateIndex % 2 === 0 ? '#2B2E5E' : '#333868'}`
            }))

            rows.push({
                date: sumTitle,
                values: statuses.map((status, statusIndex) => {
                    let wells = this.wellsByDates[statusIndex].wells

                    return this.columns.map(column => {
                        let sum = 0

                        wells.forEach(date => sum += date[column.key][wellKey])

                        return sum
                    })
                }),
                style: 'background: #293688; font-weight: 600'
            })

            return rows
        },

        getWellsByDate(status, date, tableKey) {
            let wells = this.tableData[tableKey][status].filter(well => well.date === date)

            let profitable = wells.find(well => well.profitability === 'profitable') || DEFAULT_WELL

            let profitless = wells.find(well => well.profitability === 'profitless') || DEFAULT_WELL

            let total = {}

            Object.keys(DEFAULT_WELL).forEach(wellKey => {
                profitable[wellKey] = +profitable[wellKey]

                profitless[wellKey] = +profitless[wellKey]

                total[wellKey] = profitable[wellKey] + profitless[wellKey]
            })

            return {
                profitable: profitable,
                profitless: profitless,
                total: total
            }
        }
    }
}