export default class TGroup {
    #__groups = new Set();
    #__subGroups = new Map();
    #__groupsElements = new Map();
    #__groupsOptions = new Map();

    get getGroupsList() {
        return [...this.#__groups.keys()];
    }

    get getGroupsWithData() {
        let groupList = [];
        this.#__groups.forEach((key) => {
            let groupOptions = this.#__groupsOptions.has(key) ? this.#__groupsOptions.get(key) : {};
            let elements = this.#__groupsElements.has(key) ? this.#__groupsElements.get(key) : [];
            groupList.push({
                groupName: key,
                options: {...groupOptions},
                elements: [...elements]
            })
        });
        return groupList
    }

    getGroupWithData(groupName) {
        let groupOptions = this.#__groupsOptions.has(groupName) ? this.#__groupsOptions.get(groupName) : {};
        let elements = this.#__groupsElements.has(groupName) ? this.#__groupsElements.get(groupName) : [];
        return {
            groupName: groupName,
            options: {...groupOptions},
            elements: [...elements]
        }
    }

    getGroupElements(groupName) {
        return this.#__groupsElements.has(groupName) ? [...this.#__groupsElements.get(groupName).values()] : [];
    }

    createGroup(groupName, options, data = []) {
        groupName = groupName.trim();
        this.#__groups.add(groupName);
        this.#__groupsOptions.set(groupName, options);
        this.#__subGroups.set(groupName, []);
        if (Array.isArray(data) && data.length) {
            this.editGroupElement(groupName, data, true);
        }
        return {
            name: groupName,
            options: this.#__groupsOptions.get(groupName)
        };
    }

    removeGroup(groupName) {
        groupName = groupName.trim();
        if (this.#__groups.has(groupName)) {
            this.#__groups.delete(groupName);
            this.#__groupsOptions.delete(groupName);
            if (this.#__groupsElements.has(groupName)) this.#__groupsElements.delete(groupName);
        }
        return this.#__groups;
    }

    removeSelectedGroup(groupsNameArray = []) {
        if (groupsNameArray.length) {
            groupsNameArray.forEach(item => {
                this.removeGroup(item);
            });
        }
    }

    hasElementInGroup(groupName, elementName) {
        return (this.#__groupsElements.has(groupName) && this.#__groupsElements.get(groupName).includes(elementName));
    }

    getGroupOptions(groupName) {
        return this.#__groupsOptions.get(groupName)
    }

    editGroupOptions(groupName, options) {
        groupName = groupName.trim();
        let groupOptions = this.#__groupsOptions.get(groupName);
        this.#__groupsOptions.set(groupName, {...groupOptions, ...options});
    }

    editGroupElement(groupName, data = [], force = false) {
        groupName = groupName.trim();
        if (Array.isArray(data) && data.length && this.#__groupsElements.has(groupName) && !force) {
            let groupElements = this.#__groupsElements.get(groupName);
            this.#__groupsElements.set(groupName, [...groupElements, ...data]);
        } else {
            this.#__groupsElements.set(groupName, [...data]);
        }
    }

    removeGroupElements(groupName, data = []) {
        groupName = groupName.trim();
        if (this.#__groupsElements.has(groupName) && Array.isArray(data)) {
            let groupElements = [...this.#__groupsElements.get(groupName).values()];
            this.#__groupsElements.set(groupName, data.length ? groupElements.filter(element => !data.includes(element)) : []);
            return this.#__groupsElements.get(groupName);
        }
    }
}
