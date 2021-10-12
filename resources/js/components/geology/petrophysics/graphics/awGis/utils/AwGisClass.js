import TGroup from "./TGroup";
import TElements from "./TElements";

export default class AwGisClass {
    #__tGroup = new TGroup();
    #__tElements = new TElements();

    get getGroupsWithData() {
        return this.#__tGroup.getGroupsWithData;
    }

    getGroupWithData(groupName) {
        return this.#__tGroup.getGroupWithData(groupName);
    }

    getElement(elName) {
        return this.#__tElements.getElement(elName);
    }

    get getGroupList() {
        return this.#__tGroup.getGroupsList;
    }

    getGroupElements(groupName) {
        return this.#__tGroup.getGroupElements(groupName);
    }

    getGroupElementsWithData(groupName) {
        let elements = [];
        let groupElements = this.#__tGroup.getGroupElements(groupName);

        groupElements.forEach((elName) => {
            let elData = this.#__tElements.getElement(elName);
            elements.push(elData)
        })
        return elements;
    }

    addGroup(groupName, settings) {
        this.#__tGroup.createGroup(groupName, settings);
    }

    editGroupOptions(groupName, settings) {
        this.#__tGroup.editGroupOptions(groupName, settings);
    }

    editElementOptions(elementName, settings) {
        this.#__tElements.editElementOptions(elementName, settings)
    }

    addElementToGroup(groupName, curveName, curve = [], elementOptions = {}) {
        if (!this.#__tElements.hasElement(curveName)) {
            let data = {
                name: curveName,
                curve
            }
            this.#__tElements.addElement(curveName, data, elementOptions)
        }

        this.#__tGroup.editGroupElement(groupName, [curveName])
    }

    hasElementInGroup(groupName, elementName) {
        return this.#__tGroup.hasElementInGroup(groupName, elementName);
    }

    removeElementFromGroup(groupName, elementName) {
        this.#__tGroup.removeGroupElements(groupName, [elementName]);
    }

    removeGroup(groupName) {
        this.#__tGroup.removeGroup(groupName);
    }

}
