import TCoords from "./TCoords";

export default class TCanvas {
    #__canvas = null;
    #__context = null;
    #tCoords = new TCoords();

    set setCanvas(canvas) {
        this.#__canvas = canvas;
        this.#__context = canvas.getContext('2d');
        this.#tCoords.setCanvas = canvas;
        this.#tCoords.setParams();
    }

    get getContext() {
        return this.#__context;
    }

    set setOffsetY(offsetY) {
        this.#tCoords.setOffsetY = offsetY;
    }

    drawCurve(curve, {options, options: {customParams}, wellID}) {
        let ctx = this.#__context, y = 0, lastY = 0, lastX = options.startX[wellID];
        let coord = this.#tCoords, max, min;

        let minValue = min = customParams?.min?.use ? +customParams.min?.value ?? options.min[wellID] : options.min[wellID];
        let maxValue = max = customParams?.max?.use ? +customParams.max?.value ?? options.max[wellID] : options.max[wellID];
        let dashLine = customParams?.dash&&Array.isArray(customParams?.dash.value)?customParams?.dash.value:customParams?.dash.value.split(',');
        ctx.save();
        ctx.beginPath();
        ctx.moveTo(coord.percentPositionX(lastX, max, min), coord.positionY(lastY));

        if (customParams?.dash && dashLine) {
            ctx.setLineDash(dashLine);
        }

        if (customParams?.direction && customParams.direction.value === "reverse") {
            max = minValue;
            min = maxValue;
        }

        for (const c of curve) {
            if (c !== null) {
                ctx.lineTo(coord.percentPositionX(c, max, min), coord.positionY(y));
                lastX = c
            } else {
                ctx.moveTo(coord.percentPositionX(lastX, max, min), coord.positionY(y));
            }
            lastY = y
            y++
        }

        ctx.stroke();
        ctx.restore();
    }

    clearCanvas() {
        if (this.#__context) this.#__context?.clearRect(0, 0, this.#__canvas.width, this.#__canvas.height);
    }
}
