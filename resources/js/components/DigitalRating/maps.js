import * as topojson from 'topojson-client';

const width = 900;
const height = 600;

const svg = d3.select('#map').append('svg').attr('width', width).attr('height', height);

const projection = d3.geo.mercator().scale(140)
    .translate([width / 2, height / 1.4]);
const path = d3.geo.path(projection);

const g = svg.append('g');

const initMap = d3.json('https://cdn.jsdelivr.net/npm/world-atlas@2/countries-110m.json', function(data) {
    console.log('data', data);
    const countries = topojson.feature(data, data.objects.countries);
    g.selectAll('path').data(countries.features).enter().append('path').attr('class', 'country').attr('d', path);
});

export default initMap;
