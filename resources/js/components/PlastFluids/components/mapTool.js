import * as d3 from "d3";
import * as topojson from "topojson-client";

export default class MapTool {
    constructor(id = "#map") {
        this.id = id
        this.svg = null;
        this.path = null;
        this.svgParams = {
            width: 100,
            height: 100,
            scale: 40,
            center: [0, 0],
            background: "#c9e8fd",
        }
    }

    createSvg(params = {}) {
        this.svgParams = {...this.svgParams, ...params};
        this.svg = d3.select(this.id)
            .append("svg")
            .attr("preserveAspectRatio", this.svgParams.preserveAspectRatio)
            .attr("width", this.svgParams.width)
            .attr("height", this.svgParams.height)
            .attr("viewBox", this.svgParams.viewBox ? this.svgParams.viewBox : "0 0 " + this.svgParams.width + " " + this.svgParams.height)
            .style("background", this.svgParams.background)
            .classed("svg-content", true);
        this.projection();
        return this.svg;
    }

    projection() {
        let pr = d3.geoMercator()
            .translate([this.svgParams.width ? 0 : this.svgParams.width / 2, this.svgParams.height ? 0 : this.svgParams.height / 2])
            .scale(this.svgParams.scale)
            .center(this.svgParams.center)
        return this.path = d3.geoPath().projection(pr);
    }

    async json(url) {
        if (url) {
            return await d3.json(url);
        }
    }

    async csv(url) {
        if (url) {
            return await d3.csv(url);
        }
    }

    async createMap(url, obj = false, topo = true, attrs = {}) {
        await this.json(url).then((values) => {
            let topoJson;
            if (obj) {
                topoJson = topo ? topojson.feature(values, values.objects[obj]) : values.features;
                this.drawTopo(obj, topoJson, attrs[obj])
            } else {
                Object.keys(values.objects).forEach((key) => {
                    topoJson = topojson.feature(values, values.objects[key]);
                    this.drawTopo(key, topoJson, attrs[key])
                })
            }
        })
    }

    drawTopo(name, topoJson, attrs) {
        this.svg.append("path")
            .datum(topoJson).attr("d", this.path).attr('id', name)
            .on("click", this.click.bind(this))
        if (Array.isArray(attrs) && attrs.length) {
            attrs.forEach((attr) => {
                this.svg.select(`path#${name}`).attr(attr[0], attr[1])
                    .on('click', this.click.bind(this));
            });
        }
    }

     click(ev,d) {
         let x, y, k;
         let centered;

         if (d && this.centered !== d) {
             let centroid = this.path.centroid(d);
             x = centroid[0];
             y = centroid[1];
             k = 4;
             centered = d;
         } else {
             x = this.svgParams.width / 2;
             y = this.svgParams.height / 2;
             k = 1;
             this.centered = null;
         }
         this.svg.selectAll("path")
             .classed("active", this.centered && function(d) { return d === this.centered; });

         this.svg.transition()
             .duration(600)
             .attr("transform", "translate(" + this.svgParams.width / 2 + "," + this.svgParams.height / 2 + ")scale(" + k + ")translate(" + -x + "," + -y + ")")
             .style("stroke-width", 1.5 / k + "px");
     }
}
