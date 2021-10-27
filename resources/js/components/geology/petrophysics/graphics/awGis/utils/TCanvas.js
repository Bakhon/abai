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
        this.#tCoords.setOrigin = 0;
    }

    get getContext() {
        return this.#__context;
    }

    set setOffsetY(offsetY) {
        this.#tCoords.setOffsetY = offsetY;
    }

    drawCurve(curve, {options, wellID}) {
        let ctx = this.#__context, y = 0, lastY = 0, lastX = options.startX[wellID];
        let coord = this.#tCoords;
        ctx.save()
        ctx.beginPath();
        ctx.translate(-options.min[wellID], 0)
        let i = 0;
        for (const c of curve) {
            if (c !== null) {
                ctx.moveTo(coord.positionX(lastX), coord.positionY(lastY));
                ctx.lineTo(coord.positionX(c), coord.positionY(y));
                lastX = c
            } else {
                ctx.moveTo(coord.positionX(0), coord.positionY(y));
            }
            i++;
            lastY = y
            y++
        }
        ctx.stroke();
        ctx.restore()
    }

    clearCanvas() {
        if (this.#__context) this.#__context?.clearRect(0, 0, this.#__canvas.width, this.#__canvas.height);
    }
}
