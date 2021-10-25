export default class TElements {

    #__elements = new Set();
    #__elementsOptions = new Map();
    #__elementsData = new Map();
    #__old = {};

    save(){
        this.#__old = {
            elements: new Set(this.#__elements),
            elementsData: new Map(this.#__elementsData),
            elementsOptions: new Map(this.#__elementsOptions)
        }
    }

    reset(){
        this.#__elements = new Set(this.#__old.elements);
        this.#__elementsData = new Map(this.#__old.elementsData);
        this.#__elementsOptions = new Map(this.#__old.elementsOptions);
    }

    get getElements() {
        return [...this.#__elements.keys()]
    }

    getElement(elementName) {
        if(this.#__elements.has(elementName)){
            return {
                options: this.#__elementsOptions.get(elementName),
                data: this.#__elementsData.get(elementName)
            }
        }
        return {}
    }

    get getElementsWithData() {
        let elementsList = [];
        this.#__elements.forEach((key) => {
            let elementsOptions = this.#__elementsOptions.has(key) ? this.#__elementsOptions.get(key) : {};
            let data = this.#__elementsData.has(key) ? this.#__elementsData.get(key) : {};
            elementsList.push({
                name: key,
                options: {...elementsOptions},
                data: {...data}
            })
        })
        return elementsList
    }

    hasElement(elementName) {
        return this.#__elements.has(elementName)
    }

    addElement(elementName, data = {}, options = {}) {
        this.#mapAction(elementName, 'set', data, options);
    }

    removeElement(elementName) {
        this.#mapAction(elementName, 'delete');
    }

    editElementData(elementName, data = {}, force) {
        this.#propertyEdit(elementName, data, force, 'data')
    }

    editElementOptions(elementName, options = {}, force) {
        this.#propertyEdit(elementName, options, force, 'options')
    }

    #propertyEdit = (elementName, dataOrOptions, force, propName) => {
        elementName = elementName?.trim();
        let map = {
            'options': this.#__elementsOptions,
            'data': this.#__elementsData
        }
        if (map[propName].has(elementName)) {
            let element = map[propName].get(elementName);
            map[propName].set(elementName, force ? {...dataOrOptions} : {...element, ...dataOrOptions});
        }
    }

    #mapAction = (elementName, action, data = {}, options = {}) => {
        elementName = elementName?.trim();
        this.#__elements[action === 'set' ? 'add' : action](elementName);
        this.#__elementsOptions[action](elementName, options);
        this.#__elementsData[action](elementName, data);
    }
}
