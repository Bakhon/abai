const textForms = {
    fields: [
        'месторождение',
        'месторождения',
        'месторождений',
        'месторождения',
    ],
    expMethods: [
        'способ',
        'способа',
        'способов',
        'способы',
    ],
    horizons: [
        'горизонт',
        'горизонта',
        'горизонтов',
        'горизонты',
    ],
    objects: [
        'объект',
        'объекта',
        'объектов',
        'объекты',
    ],
    blocks: [
        'блок',
        'блока',
        'блоков',
        'блоки',
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