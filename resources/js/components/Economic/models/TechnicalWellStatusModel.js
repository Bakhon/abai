export class TechnicalWellStatusModel {
    static GDIS = 1

    static KRF_FOR_RECOVERY = 2

    static KRF_FOR_INCREASE = 3

    static PRS = -1

    static get ids() {
        return [
            this.GDIS,
            this.KRF_FOR_RECOVERY,
            this.KRF_FOR_INCREASE,
        ]
    }
}
