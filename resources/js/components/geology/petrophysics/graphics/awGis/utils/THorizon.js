import {letMeProperty} from "../../../../js/utils";

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
    }

    get settings() {
        return this.#graphSettings;
    }

    set svg(svg) {
        this.#svg = svg;
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
    calcStartPoint(elementData){

    }
    getElementPath(elementName) {
        let d = [], moveTo = false;
        for (let wellName of this.#maps.keys()) {
            let elData = this.#elements.get(elementName);
            if (elData.wells.includes(wellName)) {
                let wellData = this.#wellsBlockData.get(wellName);
                let {left, right} = wellData.props;
                let y = elData.toWells[wellName].md;
                let offsetY = y - this.#graphSettings.scrollY * 10
                if(moveTo) {
                    d.push(`M${left} ${offsetY}`);
                    moveTo = false;
                }
                d.push(`L${left} ${offsetY}  L${right} ${offsetY}`);
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
        this.drawSelectedPath(this.#lastSelectElements)
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
                circle.setAttribute('cy', `${(firstWellMD + (circleRadius/2)-strokeWidth) - this.#graphSettings.scrollY * 10}`);

                text.textContent = elementData.name;
                text.setAttribute('text-anchor', "start");
                text.setAttribute('fill', fillAndStroke);
                text.setAttribute('x', (this.#graphSettings.offsetColumnsLeft / 2 + 5).toString());
                text.setAttribute('y', ((firstWellMD-5) - this.#graphSettings.scrollY * 10).toString());

                path.setAttribute('fill', "none");
                path.setAttribute('stroke', fillAndStroke);
                path.setAttribute('stroke-linecap', 'round');
                path.setAttribute('stroke-linejoin', 'round');
                path.setAttribute('stroke-width', '2');
                path.setAttribute('d', [`M${this.#graphSettings.offsetColumnsLeft / 2} ${firstWellMD - this.#graphSettings.scrollY * 10}`, ...this.getElementPath(element)].join(' '));

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
            letMeProperty(data, path, value);
            this.editDataElement(elementName, {...data}, force);
        } else {
            console.error("Не тот тип данных элемента");
        }
    }

    updateMaps() {
        this.#maps = new Map();
        for (let well of this.#wells) {
            let e = [];
            for (let [key, element] of this.#elements) {
                if (element.wells.includes(well))
                    if (!e.includes(key)) e.push(key);
            }
            this.#maps.set(well, e);
        }
    }
}
