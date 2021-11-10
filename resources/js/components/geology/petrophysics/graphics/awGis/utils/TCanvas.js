import TCoords from "./TCoords";
import {isFloat} from "./utils";

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

    drawLithology(lithologyData, {options, options: {customParams}, wellID}) {
        let ctx = this.#__context, y = 0, lastLithology = null, startPolygonPosition = 0;
        let coord = this.#tCoords;
        let color = ['gray', 'yellow', '#986321'];
        ctx.save();
        ctx.globalCompositeOperation = "destination-over";

        for (const lithology of lithologyData) {
            if (lithology !== lastLithology) {
                if (lastLithology !== null) {
                    ctx.fillStyle = color[lithology];
                    ctx.beginPath();
                    ctx.moveTo(0, coord.positionY(startPolygonPosition));
                    ctx.lineTo(ctx.canvas.width, coord.positionY(startPolygonPosition));
                    ctx.lineTo(ctx.canvas.width, coord.positionY(y));
                    ctx.lineTo(0, coord.positionY(y));
                    ctx.closePath();
                    ctx.fill();
                }
                lastLithology = lithology
            }

            if (lithology === null) startPolygonPosition = y
            y++
        }
        ctx.restore();
    }

    drawCurve(curve, {options, options: {customParams}, wellID}) {
        let ctx = this.#__context, y = 0, lastY = 0, lastX = options.startX[wellID];
        let coord = this.#tCoords, max, min;

        let minValue = min = customParams?.min?.use ? +customParams.min?.value ?? options.min[wellID] : options.min[wellID];
        let maxValue = max = customParams?.max?.use ? +customParams.max?.value ?? options.max[wellID] : options.max[wellID];
        let curveColor = customParams?.curveColor?.use ? customParams.curveColor?.value : "#000000";
        let dashLine = customParams?.dash && Array.isArray(customParams?.dash.value) ? customParams?.dash.value : customParams?.dash.value.split(',');

        ctx.save();
        ctx.globalCompositeOperation = "source-over";

        ctx.beginPath();
        ctx.moveTo(coord.percentPositionX(lastX, max, min), coord.positionY(lastY));

        if (customParams?.dash && dashLine) {
            ctx.setLineDash(dashLine);
        }

        if (customParams?.curveColor && curveColor) {
            ctx.strokeStyle = curveColor
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
