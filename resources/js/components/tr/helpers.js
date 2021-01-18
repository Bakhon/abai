const textForms = {
    fields: [
        'tr.trwf1',
        'tr.trwf2',
        'tr.trwf3',
        'tr.trwf4',
    ],
    expMethods: [
        'tr.tref1',
        'tr.tref2',
        'tr.tref3',
        'tr.tref4',
    ],
    horizons: [
        'tr.trhf1',
        'tr.trhf2',
        'tr.trhf3',
        'tr.trhf4',
    ],
    objects: [
        'tr.trof1',
        'tr.trof2',
        'tr.trof3',
        'tr.trof4',
    ],
    blocks: [
        'tr.trbf1',
        'tr.trbf2',
        'tr.trbf3',
        'tr.trbf4',
    ],
}

exports.declOfNum = (n, row = "fields") => {  
    n = Math.abs(n) % 100; var n1 = n % 10;
    if (n > 10 && n < 20) { return textForms[row][2]; }
    if (n1 > 1 && n1 < 5) { return textForms[row][1]; }
    if (n1 == 1) { return textForms[row][0]; }
    return textForms[row][2];
}

exports.getFilterText = (filter, options, field) => {
    if (filter.length === 0) return `Выберите ${textForms[field][3]}`
    // if (filter.length === options.length) return `Все ${textForms[field][3]}`
    else return filter.join(', ');
}
