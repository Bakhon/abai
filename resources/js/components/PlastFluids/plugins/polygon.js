const polygonJSON = {
  type: "FeatureCollection",
  features: [
    {
      type: "Feature",
      properties: {
        stroke: "#555555",
        "stroke-width": 2,
        "stroke-opacity": 1,
        fill: "#555555",
        "fill-opacity": 0.5,
        name: "rectangle",
      },
      geometry: {
        type: "Polygon",
        coordinates: [
          [
            [81.134033203125, 28.62310355452992],
            [82.0074462890625, 28.62310355452992],
            [82.0074462890625, 29.214507763499352],
            [81.134033203125, 29.214507763499352],
            [81.134033203125, 28.62310355452992],
          ],
        ],
      },
    },
    {
      type: "Feature",
      properties: {
        stroke: "#555555",
        "stroke-width": 2,
        "stroke-opacity": 1,
        fill: "#555555",
        "fill-opacity": 0.5,
        name: "pentagon",
      },
      geometry: {
        type: "Polygon",
        coordinates: [
          [
            [82.760009765625, 28.8927788645183],
            [82.6007080078125, 28.555576049185973],
            [82.8314208984375, 28.256005619824972],
            [83.3367919921875, 28.246327971048842],
            [83.33129882812499, 28.801359986481774],
            [82.760009765625, 28.8927788645183],
          ],
        ],
      },
    },
  ],
};

export { polygonJSON }
