export const langPage = document.documentElement.lang;
export const currentUrlPage = window.location.pathname;
export const urlLink = (url) => {
    if (typeof url === "string" && url.length) {
        return (`/${langPage + url}`).trim();
    }
}

export function uuidv4() {
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
        var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
        return v.toString(16);
    });
}


export function isFloat(n) {
    return Number(n) === n && n % 1 !== 0;
}

export function letMeProperty(object, path, value) {
    let result;
    path = Array.isArray(path) ? [...path] : path.split('.');
    if (typeof object === "object" && !Array.isArray(object)) {
        for (let key of path) {
            let index = path.indexOf(key);
            let obj = object.hasOwnProperty(key) ? object[key] : Object.assign(object, {[key]: value});
            if (~index && path.length > 1) return letMeProperty(obj, [...path.slice(index + 1, path.length)], value);
            else result = value ? object[key] = (typeof value === 'function') ? value(obj, object) : value : obj;
        }
        return result;
    }
}
