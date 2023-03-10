import {letMeProperty} from "../../../../js/utils";
import TCoords from "./TCoords";
export default class THorizon {
    #graphSettings = {
        scrollY: 0,
        offsetY: 0,
        blocksMargin: 20,
        headerHeight: 60,
        depthColumnWidth: 85,
        heightContainer: 500,
        columnTopPadding: 30,
        offsetColumnsLeft: 200,
        offsetColumnsRight: 200
    };
    #tCoords = new TCoords();
    #svg = null;
    #svgns = "http://www.w3.org/2000/svg";
    #wellsRefs = [];
    #wells = [];
    #wellsBlockData = new Map();
    #elements = new Map();
    #maps = new Map();
    #lastSelectElements = []
    set settings(settings) {
        if (typeof settings === "object" && !Array.isArray(settings)) {
            this.#graphSettings = {
                ...this.#graphSettings,
                ...settings
            }
        }
    }

    set scrollY(val) {
        this.settings = {scrollY: val};
        this.#tCoords.setOffsetY = val;
        this.redrawLastElements();
    }

    get settings() {
        return this.#graphSettings;
    }

    set svg(svg) {
        this.#svg = svg;
        this.#tCoords.setSvg = svg;
        this.#tCoords.setParams();
    }

    get svg() {
        return this.#svg;
    }

    set selectedWells(wells) {
        this.#wells = wells;
    }

    set wells(refs) {
        this.#wellsRefs = refs;
        this.calcWells();
    }

    get wells() {
        return this.#wellsRefs;
    }

    get wellsBlockWithData() {
        return this.#wellsBlockData;
    }

    get elements() {
        return Array.from(this.#elements.values());
    }

    get lastSelectElements(){
        return this.#lastSelectElements;
    }

    calcWells() {
        for (const wellData of this.#wellsRefs) {
            this.#wellsBlockData.set(wellData.props.wellName, wellData)
        }
    }

    getElementPath(elementName) {
        let d = [], moveTo = false;
        for (let wellName of this.#maps.keys()) {
            let elData = this.#elements.get(elementName);
            if (elData.wells.includes(wellName)) {
                let wellData = this.#wellsBlockData.get(wellName);
                let {left, right} = wellData.props;
                let y = this.#tCoords.positionY(elData.toWells[wellName].md);
                if(moveTo) {
                    d.push(`M${left} ${y}`);
                    moveTo = false;
                }
                d.push(`L${left} ${y}  L${right} ${y}`);
            }else{
                moveTo = true;
            }
        }
        return d;
    }

    clearSvg(){
        this.#svg.innerHTML = "";
    }

    redrawLastElements(){
        if(this.#lastSelectElements.length) this.drawSelectedPath(this.#lastSelectElements)
    }
    drawSelectedPath(elements) {
        this.#lastSelectElements = elements;
        if (Array.isArray(elements)) {
            let filteredElements = elements.filter((el) => Array.from(this.#maps.values()).find((wElements) => wElements.includes(el)));
            this.clearSvg();
            for (let element of filteredElements) {
                const elementData = this.getElement(element);
                const g = document.createElementNS(this.#svgns, 'g');
                const path = document.createElementNS(this.#svgns, 'path');
                const text = document.createElementNS(this.#svgns, 'text');
                const circle = document.createElementNS(this.#svgns, 'circle');

                let circleRadius = 5;
                let strokeWidth = 2;
                let fillAndStroke = `${elementData.fill}`;

                let firstWellMD = Object.entries(elementData.toWells).sort(([a])=> (Array.from(this.#maps.keys())[0] === a)?-1:1)[0][1].md;
                circle.setAttribute('r', circleRadius.toString());
                circle.setAttribute('stroke', fillAndStroke);
                circle.setAttribute('fill', "none");
                circle.setAttribute('stroke-width', `${strokeWidth}`);
                circle.setAttribute('cx', `${this.#graphSettings.offsetColumnsLeft / 2 - (circleRadius/2)-strokeWidth}`);
                circle.setAttribute('cy', `${(this.#tCoords.positionY(firstWellMD + (circleRadius/2)-strokeWidth))}`);

                text.textContent = elementData.name;
                text.setAttribute('text-anchor', "start");
                text.setAttribute('fill', fillAndStroke);
                text.setAttribute('x', (this.#graphSettings.offsetColumnsLeft / 2 + 5).toString());
                text.setAttribute('y', (this.#tCoords.positionY(firstWellMD-5)).toString());

                path.setAttribute('fill', "none");
                path.setAttribute('stroke', fillAndStroke);
                path.setAttribute('stroke-linecap', 'round');
                path.setAttribute('stroke-linejoin', 'round');
                path.setAttribute('stroke-width', '2');
                path.setAttribute('d', [`M${this.#graphSettings.offsetColumnsLeft / 2} ${this.#tCoords.positionY(firstWellMD) }`, ...this.getElementPath(element)].join(' '));

                g.appendChild(path);
                g.appendChild(text);
                g.appendChild(circle);
                this.#svg.appendChild(g);
            }
        }
    }

    getElement(elementName) {
        return this.#elements.get(elementName);
    }

    hasElement(elementName) {
        return this.#elements.has(elementName);
    }

    addElement(elementName, data, force = false) {
        if (!this.hasElement(elementName) && !force) this.#elements.set(elementName, data);
        else this.editDataElement(elementName, data, force)
    }

    editDataElement(elementName, data, force) {
        if (this.hasElement(elementName)) {
            let dataElement = this.getElement(elementName);
            this.#elements.set(elementName, force ? {...data} : {...dataElement, ...data});
        }
    }

    editPropertyElementData(elementName, path, value, force = false) {
        let data = this.getElement(elementName);
        if (typeof data === "object" && !Array.isArray(data)) {
            data = JSON.parse(JSON.stringify(data));
            this.editDataElement(elementName, {...letMeProperty(data, path, value)}, force);
        } else {
            console.error("???? ?????? ?????? ???????????? ????????????????");
        }
    }

    updateMaps() {
        this.#maps = new Map();
        for (let well of this.#wells) {
            let e = [];
            for (let [key, element] of this.#elements) {
                if (element.wells.includes(well) && !e.includes(key) ) e.push(key);
            }
            this.#maps.set(well, e);
        }
    }
}
