import TGroup from "./TGroup";
import TElements from "./TElements";

export default class AwGisClass {
    #__tGroup = new TGroup();
    #__tElements = new TElements();

    save(){
        this.#__tGroup.save();
        this.#__tElements.save();
    }

    reset(){
        this.#__tGroup.reset();
        this.#__tElements.reset();
    }

    get getGroupsWithData() {
        return this.#__tGroup.getGroupsWithData;
    }

    getGroupWithData(groupName) {
        return this.#__tGroup.getGroupWithData(groupName);
    }

    getElement(elName) {
        return this.#__tElements.getElement(elName);
    }

    getElementsWithData() {
        return this.#__tElements.getElementsWithData;
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
    addElement(elementName, data, options){
        this.#__tElements.addElement(elementName, data, options)
    }
    addGroup(groupName, settings) {
        this.#__tGroup.createGroup(groupName, settings);
    }

    editGroupOptions(groupName, settings) {
        this.#__tGroup.editGroupOptions(groupName, settings);
    }

    editElementData(elementName, data) {
        this.#__tElements.editElementData(elementName, data)
    }

    editElementOptions(elementName, settings) {
        this.#__tElements.editElementOptions(elementName, settings)
    }

    addElementToGroup(groupName, curveName) {
        this.#__tGroup.editGroupElement(groupName, [curveName])
    }

    moveElement(elementName, fromGroup, toGroup, removeEmpty = true){
        this.#__tGroup.removeGroupElements(fromGroup, [elementName]);
        this.#__tGroup.editGroupElement(toGroup, [elementName]);
        if(removeEmpty&&!this.#__tGroup.getGroupElements(fromGroup).length) this.#__tGroup.removeGroup(fromGroup)
    }
    hasElement(elName){
        return this.#__tElements.hasElement(elName);
    }
    hasGroup(groupName){
        return this.#__tGroup.hasGroup(groupName);
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
