import mapboxgl from "mapbox-gl";

export const profitabilityMapMixin = {
    data: () => ({
        map: null,
        popup: null
    }),
    methods: {
        initMap(centerCoordinates) {
            this.map = new mapboxgl.Map({
                container: 'map',
                style: 'mapbox://styles/mapbox/dark-v9',
                zoom: 8,
                accessToken: process.env.MIX_MAPBOX_TOKEN,
                center: centerCoordinates,
            })

            this.map.on('load', () => this.plotMap())
        },

        initPopup() {
            this.hidePopup()

            this.popup = new mapboxgl.Popup({
                closeButton: false,
                closeOnClick: false
            })
        },

        addHeatLayer(layerId, color) {
            this.map.addLayer(
                {
                    'id': `${layerId}-heat`,
                    'type': 'heatmap',
                    'source': layerId,
                    'maxzoom': 12,
                    'paint': {
                        'heatmap-color': [
                            'interpolate',
                            ['linear'],
                            ['heatmap-density'],
                            0, 'rgba(33,102,172,0)',
                            0.2, color,
                            0.4, color,
                            0.6, color,
                            0.8, color,
                            1, color
                        ],
                        'heatmap-radius': {
                            stops: [
                                [10, 15],
                                [15, 20]
                            ]
                        },
                        'heatmap-opacity': {
                            default: 1,
                            stops: [
                                [11, 1],
                                [12, 0]
                            ]
                        }
                    }
                },
                'waterway-label'
            )
        },

        addPointLayer(layerId, color) {
            this.map.addLayer({
                    'id': `${layerId}-point`,
                    'type': 'circle',
                    'source': layerId,
                    'minzoom': 11,
                    'paint': {
                        'circle-color': color,
                        'circle-radius': 6,
                    }
                },
                'waterway-label'
            )
        },

        showPopup(event) {
            this.map.getCanvas().style.cursor = 'pointer'

            let coordinates = event.features[0].geometry.coordinates.slice()

            while (Math.abs(event.lngLat.lng - coordinates[0]) > 180) {
                coordinates[0] += event.lngLat.lng > coordinates[0] ? 360 : -360
            }

            this.popup
                .setLngLat(coordinates)
                .setHTML(event.features[0].properties.description)
                .addTo(this.map)
        },

        hidePopup() {
            if (!this.popup) return

            this.map.getCanvas().style.cursor = ''

            this.popup.remove()
        },

        getColor(profitability = null, isStopped = false) {
            if (isStopped) {
                return '#8125B0'
            }

            if (profitability === 'profitable') {
                return '#387249'
            }

            return profitability === 'profitless_cat_2'
                ? '#F7BB2E'
                : '#8D2540'
        },

        getMapSource(wells) {
            return {
                type: 'geojson',
                data: {
                    type: 'FeatureCollection',
                    features: wells.map(well => ({
                        type: 'Feature',
                        geometry: {
                            type: 'Point',
                            coordinates: [well.coordinates.lon, well.coordinates.lat]
                        },
                        properties: {
                            description: `<strong>${well.uwi}</strong>`
                        },
                    })),
                }
            }
        },

        removeMapSource(layerId) {
            if (!this.map.getSource(layerId)) return

            this.map
                .removeLayer(`${layerId}-heat`)
                .removeLayer(`${layerId}-point`)
                .removeSource(layerId)
        },
    },
    computed: {
        totalProfitability() {
            return [
                'profitable',
                'profitless',
                'profitless_cat_1',
                'profitless_cat_2',
            ]
        }
    }
}