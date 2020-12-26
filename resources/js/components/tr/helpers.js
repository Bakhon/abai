const textForms = {
    fields: [
        'месторождение',
        'месторождения',
        'месторождений',
    ],
    expMethods: [
        'способ',
        'способа',
        'способов',
    ],
    horizons: [
        'горизонт',
        'горизонта',
        'горизонтов',
    ],
}

exports.declOfNum = (n, row = "fields") => {  
    n = Math.abs(n) % 100; var n1 = n % 10;
    if (n > 10 && n < 20) { return textForms[row][2]; }
    if (n1 > 1 && n1 < 5) { return textForms[row][1]; }
    if (n1 == 1) { return textForms[row][0]; }
    return textForms[row][2];
}