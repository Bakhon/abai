var simplemaps_countrymap_mapdata={
  main_settings: {
    //General settings
		width: "1200", //or 'responsive'
    background_color: "#fff",
    background_transparent: "yes",
    border_color: "#2b2e5f",
    pop_ups: "detect",
    
		//State defaults
		state_description: "State description",
    state_color: "#43487A",
    state_hover_color: "#54598f",
    state_url: "",
    border_size: 1,
    all_states_inactive: "no",
    all_states_zoomable: "yes",
    
		//Location defaults
		location_description: "Location description",
    location_url: "",
    location_color: "#2E50E9",
    location_opacity: 0.8,
    location_hover_opacity: 1,
    location_size: 25,
    location_type: "circle",
    location_image_source: "frog.png",
    location_border_color: "rgba(46,80,233,0.3)",
    location_border: 10,
    location_border_radius: 50,
    location_hover_border: 18,
    all_locations_inactive: "no",
    all_locations_hidden: "no",
    
		//Label defaults
		label_color: "#d5ddec",
    label_hover_color: "#d5ddec",
    label_size: 14,
    label_font: "Arial",
    hide_labels: "no",
    hide_eastern_labels: "no",
   
		//Zoom settings
		zoom: "yes",
    manual_zoom: "yes",
    back_image: "no",
    initial_back: "no",
    initial_zoom: "-1",
    initial_zoom_solo: "no",
    region_opacity: 1,
    region_hover_opacity: 0.6,
    zoom_out_incrementally: "yes",
    zoom_percentage: 0.99,
    zoom_time: 0.5,
      navigation_size: 20,
      navigation_color: "#3366FF",
      navigation_border_color: "#3366FF",

    
		//Popup settings
		popup_color: "white",
    popup_opacity: 0.9,
    popup_shadow: 1,
    popup_corners: 5,
    popup_font: "12px/1.5 Verdana, Arial, Helvetica, sans-serif",
    popup_nocss: "no",
    
		//Advanced settings
		div: "map",
    auto_load: "yes",
    url_new_tab: "no",
    images_directory: "default",
    fade_time: 0.1
  },
  state_specific: {
    KAZ3195: {
      name: "Aqtöbe",
      description: "default",
      color: "default",
      hover_color: "default",
      url: "default"
    },
    KAZ3196: {
      name: "Qostanay"
    },
    KAZ3197: {
      name: "Qyzylorda"
    },
    KAZ3198: {
      name: "Atyrau"
    },
    KAZ3201: {
      name: "West Kazakhstan"
    },
    KAZ3202: {
      name: "Aqmola"
    },
    KAZ3203: {
      name: "Qaraghandy"
    },
    KAZ3204: {
      name: "North Kazakhstan"
    },
    KAZ3205: {
      name: "Pavlodar"
    },
    KAZ3206: {
      name: "East Kazakhstan"
    },
    KAZ3207: {
      name: "Almaty"
    },
    KAZ3236: {
      name: "Mangghystau"
    },
    KAZ3251: {
      name: "South Kazakhstan"
    },
    KAZ3252: {
      name: "Zhambyl"
    },
    KAZ4829: {
      name: "Almaty City"
    },
    KAZ4830: {
      name: "Astana"
    }
  },
  locations: {
    "0": {
      lat: "51.166666",
      lng: "71.45",
      name: "Astana"
    }
  },
  labels: {
    "15": {
       name: "Нур-Султан",
       parent_id: "KAZ4830",
       x: 580.7,
       y: 130.4,
       size: 14
      }
  },
};