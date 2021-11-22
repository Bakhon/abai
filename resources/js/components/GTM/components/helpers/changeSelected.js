export const crossTree = (obj, title) => {
    for (let k in obj) {
        if(obj[k] && typeof obj[k] === 'object') {
            crossTree(obj[k], title)
        } else {
            obj['selected'] = false
        }
    }
}