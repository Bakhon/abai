<template>
  <div>
    <div class="map-wrapper">
      <h2 v-if="province" class="province-title">{{province.state}}</h2>
      <div v-if="currentProvince" class="province-info">
        <h3 class="text-center">{{currentProvince.state}}</h3>
        <ul>
          <li>cartodb_id: {{currentProvince.cartodb_id}}</li>
          <li>slug: {{currentProvince.slug}}</li>
        </ul>
      </div>
      <svg></svg>
    </div>
    <div class="container">
      <p>Reference</p>
      <ul>
        <li><a href="https://bl.ocks.org/john-guerra/43c7656821069d00dcbc">https://bl.ocks.org/john-guerra/43c7656821069d00dcbc</a></li>
      </ul>
    </div>
  </div>
</template>

<script>
/*import mapZoom from "./mapZoom";*/
import * as d3 from "d3";
import {scaleLinear} from "d3-scale";

// Set svg width & height
let centered = undefined;
const mapCenter = {
  lat: 1.4,
  lng: 117.5
};
const size = {
  height: 700,
  width: 600
};

const color = d3.scale.linear()
    .domain([1, 20])
    .clamp(true)
    .range(['#08304b', '#08304b']);

const projection = d3.geo.equirectangular()
    .scale(1400)
    .center([mapCenter.lng, mapCenter.lat])
    .translate([size.width / 2, size.height / 2]);

const path = d3.geo.path()
    .projection(projection);

const svg = d3.select('svg')
    .attr('width', size.width)
    .attr('height', size.height);

// Add background
svg.append('rect')
    .attr('class', 'background')
    .attr('width', size.width)
    .attr('height', size.height)
    .on('click', clicked);

const g = svg.append('g');

const effectLayer = g.append('g')
    .classed('effect-layer', true);
const mapLayer = g.append('g')
    .classed('map-layer', true);

// Load map data
const geoJsonUrl = 'https://raw.githubusercontent.com/superpikar/indonesia-geojson/master/indonesia.geojson';
d3.json(geoJsonUrl, function(error, mapData) {
  var features = mapData.features;

  // Update color scale domain based on data
  color.domain([0, d3.max(features, nameLength)]);

  // Draw each province as a path
  mapLayer.selectAll('path')
      .data(features)
      .enter().append('path')
      .attr('d', path)
      .attr('vector-effect', 'non-scaling-stroke')
      .style('fill', fillFn)
      .on('mouseover', mouseover)
      .on('mouseout', mouseout)
      .on('click', clicked);
});

function clicked(d) {
  var x, y, k;

  // Compute centroid of the selected path
  if (d && centered !== d) {
    var centroid = path.centroid(d);
    x = centroid[0];
    y = centroid[1];
    k = 4;
    centered = d;
    app.openInfo(d.properties);
  } else {
    x = size.width / 2;
    y = size.height / 2;
    k = 1;
    centered = null;
    app.closeInfo();
  }

  // Highlight the clicked province
  mapLayer.selectAll('path')
      .style('fill', function(d){
        return centered && d===centered ? '#D5708B' : fillFn(d);
      });

  // Zoom
  g.transition()
      .duration(750)
      .attr('transform', 'translate(' + size.width / 2 + ',' + size.height / 2 + ')scale(' + k + ')translate(' + -x + ',' + -y + ')');
}

function mouseover(d){
  // Highlight hovered province
  d3.select(this).style('fill', '#1483ce');
  if(d) {
    app.selectProvince(d.properties);
  }
}

function mouseout(d){
  app.selectProvince(undefined);
  // Reset province color
  mapLayer.selectAll('path')
      .style('fill', (d) => {
        return centered && d===centered ? '#D5708B' : fillFn(d);
      });
}

// Get province name length
function nameLength(d){
  const n = nameFn(d);
  return n ? n.length : 0;
}

// Get province name
function nameFn(d){
  return d && d.properties ? d.properties.name : null;
}

// Get province color
function fillFn(d){
  return color(nameLength(d));
}

export default {
  name: "OilMapKz",
  data() {
    return {
      map: null,
      province: undefined,
      currentProvince: undefined,
    }
  },
  mounted() {
    this.initmap()
    /*this.map = map.createSvg({
      background: "none",
      scale: 1000,
      center: [50, 50],
      viewBox: `-100 0 800 50`,
    });*/

    /*map.createMap('/coords/kz.json', "kz", true, {
      kz: [
        ['fill', 'none'],
        ['stroke', 'white'],
        ['stroke-width','1px']
      ]
    });*/
    /*map.createMap('/coords/balkhash.json', false, true, {
      balkhash: [
        ['fill', 'transparent'],
        ['stroke', 'yellow']
      ]
    });
    map.createMap('/coords/torgai.json', false, true, {
      torgai: [
        ['fill', 'none'],
        ['stroke', 'yellow']
      ]
    });
    map.createMap('/coords/ustyrt.json', false, true, {
      ustyrt: [
        ['fill', 'none'],
        ['stroke', 'yellow']
      ]
    });
    map.createMap('/coords/alakol.json', false, true, {
      alakol: [
        ['fill', 'none'],
        ['stroke', 'yellow']
      ]
    });
    map.createMap('/coords/aral.json', false, true, {
      aral: [
        ['fill', 'none'],
        ['stroke', 'yellow']
      ]
    });
    map.createMap('/coords/mangyshlak.json', false, true, {
      mangyshlak: [
        ['fill', 'none'],
        ['stroke', 'yellow']
      ]
    });
    map.createMap('/coords/precaspian.json', false, true, {
      precaspian: [
        ['fill', 'none'],
        ['stroke', 'yellow']
      ]
    });
    map.createMap('/coords/preertis.json', false, true, {
      preertis: [
        ['fill', 'none'],
        ['stroke', 'yellow']
      ]
    });
    map.createMap('/coords/storgay.json', false, true, {
      storgay: [
        ['fill', 'none'],
        ['stroke', 'yellow']
      ]
    });
    map.createMap('/coords/zaisan.json', false, true, {
      zaisan: [
        ['fill', 'none'],
        ['stroke', 'yellow']
      ]
    });
    /!*map.createMap('/coords/Ili.json', false, true, {
      Ili: [
        ['fill', 'none'],
        ['stroke', 'yellow']
      ]
    });*!/
    map.createMap('/coords/norkz.json', false, true, {
      norkz: [
        ['fill', 'none'],
        ['stroke', 'yellow']
      ]
    });
    map.createMap('/coords/syrdaria.json', false, true, {
      syrdaria: [
        ['fill', 'none'],
        ['stroke', 'yellow']
      ]
    });
    map.createMap('/coords/teniz.json', false, true, {
      teniz: [
        ['fill', 'none'],
        ['stroke', 'yellow']
      ]
    });
    map.createMap('/coords/borderbasin.json', false, true, {
      borderbasin: [
        ['fill', 'none'],
        ['stroke', 'yellow']
      ]
    });*/
  },
  methods:{
    selectProvince(province) {
      this.province = province;
    },
    openInfo(province) {
      this.currentProvince = province;
    },
    closeInfo() {
      this.currentProvince = undefined;
    },
    initmap(){
      // Set svg width & height
      let centered = undefined;
      const mapCenter = {
        lat: 1.4,
        lng: 117.5
      };
      const size = {
        height: 700,
        width: 600
      };

      const color = scaleLinear()
          .domain([1, 20])
          .clamp(true)
          .range(['#08304b', '#08304b']);

      const projection = d3.geo.equirectangular()
          .scale(1400)
          .center([mapCenter.lng, mapCenter.lat])
          .translate([size.width / 2, size.height / 2]);

      const path = d3.geo.path()
          .projection(projection);

      const svg = d3.select('svg')
          .attr('width', size.width)
          .attr('height', size.height);

// Add background
      svg.append('rect')
          .attr('class', 'background')
          .attr('width', size.width)
          .attr('height', size.height)
          .on('click', clicked);

      const g = svg.append('g');

      const effectLayer = g.append('g')
          .classed('effect-layer', true);
      const mapLayer = g.append('g')
          .classed('map-layer', true);

// Load map data
      const geoJsonUrl = 'https://raw.githubusercontent.com/superpikar/indonesia-geojson/master/indonesia.geojson';
      d3.json(geoJsonUrl, function(error, mapData) {
        var features = mapData.features;

        // Update color scale domain based on data
        color.domain([0, d3.max(features, nameLength)]);

        // Draw each province as a path
        mapLayer.selectAll('path')
            .data(features)
            .enter().append('path')
            .attr('d', path)
            .attr('vector-effect', 'non-scaling-stroke')
            .style('fill', fillFn)
            .on('mouseover', mouseover)
            .on('mouseout', mouseout)
            .on('click', clicked);
      });

      function clicked(d) {
        var x, y, k;

        // Compute centroid of the selected path
        if (d && centered !== d) {
          var centroid = path.centroid(d);
          x = centroid[0];
          y = centroid[1];
          k = 4;
          centered = d;
          app.openInfo(d.properties);
        } else {
          x = size.width / 2;
          y = size.height / 2;
          k = 1;
          centered = null;
          app.closeInfo();
        }

        // Highlight the clicked province
        mapLayer.selectAll('path')
            .style('fill', function(d){
              return centered && d===centered ? '#D5708B' : fillFn(d);
            });

        // Zoom
        g.transition()
            .duration(750)
            .attr('transform', 'translate(' + size.width / 2 + ',' + size.height / 2 + ')scale(' + k + ')translate(' + -x + ',' + -y + ')');
      }

      function mouseover(d){
        // Highlight hovered province
        d3.select(this).style('fill', '#1483ce');
        if(d) {
          app.selectProvince(d.properties);
        }
      }

      function mouseout(d){
        app.selectProvince(undefined);
        // Reset province color
        mapLayer.selectAll('path')
            .style('fill', (d) => {
              return centered && d===centered ? '#D5708B' : fillFn(d);
            });
      }

// Get province name length
      function nameLength(d){
        const n = nameFn(d);
        return n ? n.length : 0;
      }

// Get province name
      function nameFn(d){
        return d && d.properties ? d.properties.name : null;
      }

// Get province color
      function fillFn(d){
        return color(nameLength(d));
      }
    }
    }
}
</script>

<style lang="scss" scoped>
#mapContainer{
  &::v-deep{
    svg{
      width: 100%;
      height: 100%;
    }
  }
}
</style>
