export default class TCoords {
    canvas = null
    canvasOptions = {
        width: 0,
        height: 0,
        centerX: 0,
        centerY: 0,
        origin: {x: 0, y: 0},
        zoom: 1,
        scale: 1,
        scaleX: 1,
        scaleY: 1,
    }

    constructor(canvas, options) {
        let {offsetWidth, offsetHeight} = this.canvas = canvas;
        options = {
            width: offsetWidth,
            height: offsetHeight,
            centerX: offsetWidth / 2,
            centerY: offsetHeight /2,
            ...options,
        }

        this.setDefaultOptions = options
    }

    set setOrigin(origin) {
        this.setDefaultOptions = origin
    }

    set setCenter(center){
        this.setDefaultOptions = center
    }

    set setSizeCanvas(size){
        this.setDefaultOptions = size
    }

    set setDefaultOptions(options){
        this.canvasOptions = {
            ...this.canvasOptions,
            ...options,
        }
    }

    width(w){
        return this.scale(w);
    }

    height(h){
        return this.scale(h);
    }

    coordinateX(x){
        return this.scaleX(+x) + +this.canvasOptions.centerX;
    }

    coordinateY(y){
        return this.scaleY(+y) + +this.canvasOptions.centerY;
    }

    scale(s){
        return s * this.canvasOptions.scale
    }

    scaleX(s){
        return s * this.canvasOptions.scaleX
    }

    scaleY(s){
        return s * this.canvasOptions.scaleY
    }
}
