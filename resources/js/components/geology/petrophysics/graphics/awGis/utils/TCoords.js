export default class TCoords {
    #canvas = null;
    #__settings = {
        width: 0,
        height: 0,
        scaleX: 1,
        scaleY: 1,
        offsetY: 0,
        offsetX: 0,
        center: {
            x: 0,
            y: 0
        }
    }

    set setCanvas(canvas) {
        this.#canvas = canvas;
        this.setParams();
    }

    get getCanvas() {
        return this.#canvas;
    }

    set setOrigin(origin) {
        this.#__settings.centerX = origin.x === 'default' ? this.#__settings.width / 2 : +origin.x ?? +origin[0] ?? +origin;
        this.#__settings.centerY = origin.y === 'default' ? this.#__settings.height / 2 : +origin.y ?? +origin.x ?? +origin[1] ?? +origin[0] ?? +origin;
    }

    set setOffsetY(offsetY) {
        this.#__settings.offsetY = offsetY;
    }

    set setOffsetX(offsetX) {
        this.#__settings.offsetX = offsetX;
    }

    set setScaleY(scaleY) {
        this.#__settings.scaleY = scaleY;
    }

    set setScaleX(scaleX) {
        this.#__settings.scaleX = scaleX;
    }

    setParams() {
        this.#__settings.width = this.#canvas.width;
        this.#__settings.height = this.#canvas.height;
        this.#__settings.centerX = this.#__settings.width / 2;
        this.#__settings.centerY = this.#__settings.height / 2;
    }

    width(w) {
        return this.scaleX(w);
    }

    height(h) {
        return this.scaleX(h);
    }

    positionX(x) {
        return this.scaleX(+x) + +this.#__settings.centerX - this.#__settings.offsetX;
    }

    positionY(y) {
        return this.scaleY(+y) + +this.#__settings.centerY - this.#__settings.offsetY;
    }

    percentPositionX(X, maxValue) {
        return ((this.#__settings.width / maxValue * 100) * X) / 100 - this.#__settings.offsetX;
    }

    percentPositionY(Y, maxValue) {
        return ((this.#__settings.width / maxValue * 100) * Y) / 100 - this.#__settings.offsetY;
    }

    scaleX(s) {
        return s * this.#__settings.scaleX
    }

    scaleY(s) {
        return s * this.#__settings.scaleY
    }
}
