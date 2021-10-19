import L from "leaflet";
import 'leaflet/dist/leaflet.css';
import { Minichart } from 'leaflet.minichart';
import { triangleMarker } from 'leaflet-triangle-marker';

export default {
  data() {
    return {
      circle: [],
      triangle: [],
      bounds: [[0, 15000], [0,15000]],
      center: [85000, 52000],
      zoom: -6,
      minZoom: -6,
      maxZoom: -1,
      renderer: L.canvas({ padding: 0.5 }),
    }
  },

  methods: {
    initMap(id) {
      this.map = L.map(id, {
        crs: L.CRS.Simple,
        zoomControl: false,
        minZoom: this.minZoom,
        maxZoom: this.maxZoom,
      });

      L.control.zoom({
        position: 'bottomright'
      }).addTo(this.map);

      this.map.fitBounds(this.bounds);
      this.map.setView( this.center, this.zoom);

      this.map.on('zoom', this.onMapZoom);
    },

    onMapZoom(event) {
      if (this.circle?.length) this.onZoomCircle(event);
      if (this.triangle?.length)this.onZoomTriangle(event);
    },

    onZoomCircle(event) {
      const radiusByZoom = { '-1': 10,'-2': 10,'-3': 8, '-4': 6, '-5': 3, '-6': 1};
      for (let key in radiusByZoom) {
        if (event.target._zoom == key) {
          this.setRadiusCircle(radiusByZoom[key])
        }
      }
    },

    onZoomTriangle(event) {
      const sizeByZoom = { '-1': 20, '-2': 16, '-3': 12, '-4': 10, '-5': 8, '-6': 4 }
      for (let key in sizeByZoom) {
        if(event.target._zoom == key) {
          this.setSizeTriangle(sizeByZoom[key]);
        }
      }
    },

    setRadiusCircle(radius) {
      this.circle.forEach((circleMarker) => {
        circleMarker.setRadius(radius);
      });
    },

    setSizeTriangle(size) {
      this.triangle.forEach((triangleMarker) => {
        triangleMarker.setWidth(size);
        triangleMarker.setHeight(size);
      });
    },

    xy(x, y) {
      let yx = L.latLng;
      if (L.Util.isArray(x)) {
        return yx(x[1], x[0]);
      }
      return yx(y, x);
    },

    getBounds(item) {
      const coordinateStart = this.xy(item['x1'], item['y1']);
      const coordinateEnd = this.xy(item['x2'], item['y2']);
      return [[coordinateStart], [coordinateEnd]];
    },

    setCircleMarker(coordinate, title) {
      const circleMarker = L.circleMarker(coordinate,{
        renderer: this.renderer,
        color: '#000',
        opacity: 1,
        weight: 1,
        fillColor: '#000',
        fillOpacity: 0,
        radius: 1,
      }).addTo(this.map).bindPopup(title);

      circleMarker.on('mouseover', function (e) {
        this.openPopup();
      });
      circleMarker.on('mouseout', function (e) {
        this.closePopup();
      });

      this.circle.push(circleMarker);
    },

    setTriangleMarker(coordinate, title) {
      const triangleMarker = L.triangleMarker(coordinate, {
        renderer:   this.renderer,
        color: '#000',
        fillColor: '#000',
        fillOpacity: 0,
        opacity: 1,
        weight: 1,
        height: 4,
        width: 4
      }).addTo(this.map).bindPopup(title);

      triangleMarker.on('mouseover', function (e) {
        this.openPopup();
      });
      triangleMarker.on('mouseout', function (e) {
        this.closePopup();
      });

      this.triangle.push(triangleMarker);
    },

    onMeasureDistance(event) {
      let polyline;
      if (this.startPoint) {
        this.endPoint = event.latlng;
        const res = Math.sqrt(
          Math.pow(this.startPoint?.lat - this.endPoint.lat, 2)
          + Math.pow(this.startPoint.lng - this.endPoint.lng, 2)
        );
        event.target.closePopup();
        setTimeout(() => {
          event.target.bindTooltip(res.toFixed(1)+'м').openTooltip();
        }, 0);
        polyline = L.polyline([this.startPoint, this.endPoint], {
          color: 'black',
          weight: 2
        }).addTo(this.map);
        setTimeout(() => {
          this.map.removeLayer(polyline);
        }, 3000);
        this.startPoint = this.endPoint = null;
      } else {
        this.startPoint = event.latlng;
      }
    },

    menuClick(data) {
      const path = window.location.pathname.slice(3);
      if (data?.url && data.url !== path) {
        window.location.href = this.localeUrl(data.url);
      }
    },
  }
}