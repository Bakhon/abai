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

    drawLithology(lithologyData, {options, options: {customParams}, wellID}) {
        let ctx = this.#__context, y = 0, lastLithology = null, startPolygonPosition = 0;
        let coord = this.#tCoords;
        let colorPalette = {
            "litho":[
                {name: "Глина", color: 'rgb(192,192,192)'},
                {name: "Песчаник", color: "rgb(255,255,0)"},
                {name: "Известняк", color: "rgb(0,0,255)"},
                {name: "Уголь", color: "rgb(0,0,0)", textColor: "white"},
            ],
            "fluid":[
                {name: "", color: 'rgba(0,0,0, 0)'},
                {name: "Вода", color: "rgb(0,255,255)"},
                {name: "Нефть", color: "rgb(0,190,0)"},
                {name: "Газ", color: "rgb(255,0,0)"},
            ]
        }[options.name[wellID].toLowerCase()];

        for (const lithology of lithologyData) {
            if (lithology !== lastLithology) {
                if (lithology !== null) {
                    let difference = Math.abs(y - startPolygonPosition);
                    ctx.save();
                    ctx.fillStyle = colorPalette[lithology].color;
                    ctx.globalCompositeOperation = "destination-over";
                    ctx.beginPath();
                    ctx.moveTo(0, coord.positionY(startPolygonPosition));
                    ctx.lineTo(ctx.canvas.width, coord.positionY(startPolygonPosition));
                    ctx.lineTo(ctx.canvas.width, coord.positionY(y));
                    ctx.lineTo(0, coord.positionY(y));
                    ctx.closePath();
                    ctx.fill();
                    ctx.restore();

                    ctx.save();
                    ctx.globalCompositeOperation = "source-over";
                    ctx.font = "13px Harmonia-sans";
                    ctx.textBaseline = "middle";
                    ctx.textAlign = "center";
                    ctx.fillStyle = colorPalette[lithology].textColor&&"black";
                    //TODO сделать скрытие надписей в зависимости от размера плитки
                    // ctx.fillText(colorPalette[lithology].name, ctx.canvas.width/2, coord.positionY(y-(difference/2)));
                    ctx.restore();
                }

                lastLithology = lithology
                startPolygonPosition = y
            }
            y++
        }
    }

    drawCurve(curve, {options, options: {customParams}, wellID}) {
        let ctx = this.#__context, y = 0, lastY = 0, lastX = options.startX[wellID];
        let coord = this.#tCoords, max, min;

        let minValue = min = customParams?.min?.use ? +customParams.min?.value ?? options.min[wellID] : options.min[wellID];
        let maxValue = max = customParams?.max?.use ? +customParams.max?.value ?? options.max[wellID] : options.max[wellID];
        let curveColor = customParams?.curveColor?.use ? customParams.curveColor?.value : "#000000";
        let dashLine = customParams?.dash && Array.isArray(customParams?.dash.value) ? customParams?.dash.value : customParams?.dash.value.split(',');

        ctx.globalCompositeOperation = "source-over";

        ctx.save();
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
