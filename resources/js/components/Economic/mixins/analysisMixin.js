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
        tableData() {
            let wellsByStatuses = {}

            let dates = {}

            this.wells.forEach(well => {
                dates[well.date] = 1

                if (!wellsByStatuses.hasOwnProperty(well.status_id)) {
                    wellsByStatuses[well.status_id] = []
                }

                wellsByStatuses[well.status_id].push(well)
            })

            dates = Object.keys(dates)

            let statuses = Object.keys(wellsByStatuses).map(status => {
                let wells = wellsByStatuses[status]

                return {
                    name: wells[0].status_name,
                    dates: dates.map(date => {
                        let wellsByDate = wells.filter(well => well.date === date)

                        let profitable = wellsByDate.find(well => well.profitability = 'profitable') || DEFAULT_WELL

                        let profitless = wellsByDate.find(well => well.profitability = 'profitless') || DEFAULT_WELL

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

            return {
                dates: dates,
                statuses: statuses
            }
        },

        tableUwiCount() {
            let rows = this.tableData.dates.map((date, dateIndex) => {
                return {
                    date: date,
                    values: this.statuses.map((status, statusIndex) => {
                        return this.columns.map(column => {
                            return this.tableData.statuses[statusIndex].dates[dateIndex][column.key].uwi_count
                        })
                    }),
                    style: `background: ${dateIndex % 2 === 0 ? '#2B2E5E' : '#333868'}`
                }
            })

            rows.push({
                date: 'Итого скважин',
                values: this.statuses.map((status, statusIndex) => {
                    return this.columns.map((column, columnIndex) => {
                        let sum = 0

                        rows.forEach(row => {
                            sum += row.values[statusIndex][columnIndex]
                        })

                        return sum
                    })
                }),
                style: 'background: #293688; font-weight: 600'
            })

            return rows
        },

        tableOil() {
            let rows = this.tableData.dates.map((date, dateIndex) => {
                return {
                    date: date,
                    values: this.statuses.map((status, statusIndex) => {
                        return this.columns.map(column => {
                            return this.tableData.statuses[statusIndex].dates[dateIndex][column.key].oil_loss
                        })
                    }),
                    style: `background: ${dateIndex % 2 === 0 ? '#2B2E5E' : '#333868'}`
                }
            })

            rows.push({
                date: 'Итог потерь нефти',
                values: this.statuses.map((status, statusIndex) => {
                    return this.columns.map((column, columnIndex) => {
                        let sum = 0

                        rows.forEach(row => {
                            sum += row.values[statusIndex][columnIndex]
                        })

                        return sum
                    })
                }),
                style: 'background: #293688; font-weight: 600'
            })

            return rows
        },

        statuses() {
            return this.tableData.statuses.map(status => ({name: status.name}))
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
    }
}