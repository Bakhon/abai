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

export function letMeProperty(object, path, value, immutable) {
    if (!immutable) object = JSON.parse(JSON.stringify(object));

    function func(object, path, value) {
        path = Array.isArray(path) ? [...path] : path.split(".");
        if (typeof object === "object" || Array.isArray(object)) {
            for (let [index, key] of path.entries()) {
                let obj = object.hasOwnProperty(key.toString()) ? object[key] : Object.assign(object, {[key]: value});
                if (~index && path.length > 1) return func.apply(this, [obj, [...path.slice(index + 1, path.length)], value]);
                else (value !== undefined) ? (object[key] = typeof value === "function" ? value(obj, object) : value) : obj;

                if (index === path.length - 1 && !value === undefined) return obj;
            }
        }
        return this;
    }

    if (Array.isArray(path)) {
        for (let [i, p] of path.entries()) if (func.apply(object, [object, p[0], p[1]]), i === path.length - 1) return func.apply(object, [object, p[0], p[1]]);
    } else {
        return func.apply(object, [object, path, value]);
    }
}

