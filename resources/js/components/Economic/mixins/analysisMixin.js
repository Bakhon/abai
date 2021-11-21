import {TechnicalWellStatusModel} from "../models/TechnicalWellStatusModel";

const DEFAULT_WELL = {
    uwi_count: 0,
    oil: 0,
    oil_loss: 0,
    oil_tech_loss: 0,
    liquid: 0,
    liquid_loss: 0,
    liquid_tech_loss: 0,
    liquid_forecast: 0,
    prs_portion: 0,
    prs_cost: 0,
    active_hours: 0,
    paused_hours: 0,
    total_hours: 0,
    operating_profit: 0,
    operating_profit_tech_loss: 0
}

export const tableDataMixin = {
    props: {
        wells: {
            required: true,
            type: Array
        },
        isTechLoss: {
            required: false,
            type: Boolean
        },
    },
    computed: {
        tableData() {
            let wellsByStatus = {}

            let dates = {}

            let statuses = {}

            this.wells.forEach(well => {
                let statusId = +well.status_id

                let statusName = well.status_name

                if (this.isTechLoss) {
                    let isPrs = statusName.startsWith(this.trans('economic_reference.prs_status'))

                    if (!TechnicalWellStatusModel.ids.includes(statusId) && !isPrs) return

                    if (isPrs) {
                        statusId = TechnicalWellStatusModel.PRS

                        statusName = this.trans('economic_reference.prs_status')
                    }
                }

                dates[well.date_month] = 1

                if (!wellsByStatus.hasOwnProperty(statusId)) {
                    wellsByStatus[statusId] = []
                }

                statuses[statusId] = statusName

                wellsByStatus[statusId].push(well)
            })

            dates = Object.keys(dates)

            return {
                wellsByStatus: wellsByStatus,
                statuses: Object.keys(statuses),
                statusNames: Object.values(statuses),
                dates: dates
            }
        },

        tableUwiCount() {
            return this.generateTable('uwi_count')
        },

        totalRowOilLoss() {
            return this.generateTotalRow(
                this.isTechLoss ? 'oil_tech_loss' : 'oil_loss',
                this.trans('economic_reference.total_oil_loss')
            )
        },

        totalRowOperatingProfit() {
            return this.generateTotalRow(
                this.isTechLoss ? 'operating_profit_tech_loss' : 'operating_profit',
                `
                    ${this.trans('economic_reference.lost_profit')}, 
                    ${this.trans('economic_reference.thousand_tenge')}
                `
            )
        },

        tableOilLoss() {
            let key = this.isTechLoss ? 'oil_tech_loss' : 'oil_loss'

            let table = this.generateTable(key)

            table.push(this.totalRowOilLoss)

            return table
        },

        tablePrs() {
            let table = this.generateTable('prs_cost')

            table.push(this.generateTotalRow(
                'prs_cost',
                this.trans('economic_reference.total_grand')
            ))

            return table
        },

        columns() {
            return [
                {
                    name: this.trans('economic_reference.total'),
                    key: 'total'
                },
                {
                    name: this.trans('economic_reference.profitable_short'),
                    key: 'profitable'
                },
                {
                    name: this.trans('economic_reference.profitless_short'),
                    key: 'profitless'
                },
            ]
        },

        wellsByDates() {
            return this.tableData.statuses.map((status, statusIndex) => ({
                status_id: +status,
                status_name: this.tableData.statusNames[statusIndex],
                wells: this.tableData.dates.map(date => (
                    this.getWellsByDate(status, date, 'wellsByStatus')
                )),
            }))
        },
    },
    methods: {
        generateTable(wellKey) {
            return this.tableData.dates.map((date, dateIndex) => ({
                date: date,
                values: this.tableData.statuses.map((status, statusIndex) => {
                    let wells = this.wellsByDates[statusIndex].wells[dateIndex]

                    return this.columns.map(column => wells[column.key][wellKey])
                }),
                style: `background: ${dateIndex % 2 === 0 ? '#2B2E5E' : '#333868'}`
            }))
        },

        generateTotalRow(wellKey, title) {
            return {
                date: title,
                values: this.tableData.statuses.map((status, statusIndex) => {
                    let wells = this.wellsByDates[statusIndex].wells

                    return this.columns.map(column => {
                        let sum = 0

                        wells.forEach(date => sum += date[column.key][wellKey])

                        return sum
                    })
                }),
                style: 'background: #293688; font-weight: 600'
            }
        },

        getWellsByDate(status, date, tableKey) {
            let wells = this.tableData[tableKey][status].filter(well => well.date_month === date)

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