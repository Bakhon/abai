export class TechnicalWellLossStatus {
    static NRS = 1

    static CRF = 2

    static OPEK = 3

    static DEOPTIMIZATION = 4

    static DOWNLOAD_LIMIT = 5

    static get factualIds() {
        return [
            this.NRS,
            this.CRF,
            this.OPEK,
        ]
    }
}
