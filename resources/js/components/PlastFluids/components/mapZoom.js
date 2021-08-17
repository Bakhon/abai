
// import {scaleLinear} from "d3-scale";

// // Set svg width & height
// let centered = undefined;
// const mapCenter = {
//     lat: 1.4,
//     lng: 117.5
// };
// const size = {
//     height: 700,
//     width: 600
// };

// const color = scaleLinear()
//     .domain([1, 20])
//     .clamp(true)
//     .range(['#08304b', '#08304b']);

// const projection = d3.geo.equirectangular()
//     .scale(1400)
//     .center([mapCenter.lng, mapCenter.lat])
//     .translate([size.width / 2, size.height / 2]);

// const path = d3.geo.path()
//     .projection(projection);

// const svg = d3.select('svg')
//     .attr('width', size.width)
//     .attr('height', size.height);

// // Add background
// svg.append('rect')
//     .attr('class', 'background')
//     .attr('width', size.width)
//     .attr('height', size.height)
//     .on('click', clicked);

// const g = svg.append('g');

// const effectLayer = g.append('g')
//     .classed('effect-layer', true);
// const mapLayer = g.append('g')
//     .classed('map-layer', true);

// // Load map data
// const geoJsonUrl = 'https://raw.githubusercontent.com/superpikar/indonesia-geojson/master/indonesia.geojson';
// d3.json(geoJsonUrl, function(error, mapData) {
//     var features = mapData.features;

//     // Update color scale domain based on data
//     color.domain([0, d3.max(features, nameLength)]);

//     // Draw each province as a path
//     mapLayer.selectAll('path')
//         .data(features)
//         .enter().append('path')
//         .attr('d', path)
//         .attr('vector-effect', 'non-scaling-stroke')
//         .style('fill', fillFn)
//         .on('mouseover', mouseover)
//         .on('mouseout', mouseout)
//         .on('click', clicked);
// });

// function clicked(d) {
//     var x, y, k;

//     // Compute centroid of the selected path
//     if (d && centered !== d) {
//         var centroid = path.centroid(d);
//         x = centroid[0];
//         y = centroid[1];
//         k = 4;
//         centered = d;
//         app.openInfo(d.properties);
//     } else {
//         x = size.width / 2;
//         y = size.height / 2;
//         k = 1;
//         centered = null;
//         app.closeInfo();
//     }

//     // Highlight the clicked province
//     mapLayer.selectAll('path')
//         .style('fill', function(d){
//             return centered && d===centered ? '#D5708B' : fillFn(d);
//         });

//     // Zoom
//     g.transition()
//         .duration(750)
//         .attr('transform', 'translate(' + size.width / 2 + ',' + size.height / 2 + ')scale(' + k + ')translate(' + -x + ',' + -y + ')');
// }

// function mouseover(d){
//     // Highlight hovered province
//     d3.select(this).style('fill', '#1483ce');
//     if(d) {
//         app.selectProvince(d.properties);
//     }
// }

// function mouseout(d){
//     app.selectProvince(undefined);
//     // Reset province color
//     mapLayer.selectAll('path')
//         .style('fill', (d) => {
//             return centered && d===centered ? '#D5708B' : fillFn(d);
//         });
// }

// // Get province name length
// function nameLength(d){
//     const n = nameFn(d);
//     return n ? n.length : 0;
// }

// // Get province name
// function nameFn(d){
//     return d && d.properties ? d.properties.name : null;
// }

// // Get province color
// function fillFn(d){
//     return color(nameLength(d));
// }