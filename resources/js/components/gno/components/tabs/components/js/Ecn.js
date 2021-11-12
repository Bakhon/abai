import NotifyPlugin from "vue-easy-notify";
import Multiselect from "vue-multiselect";
import { pgnoMapState, pgnoMapGetters, pgnoMapMutations, pgnoMapActions } from '@store/helpers';
import _ from 'lodash';

Vue.use(NotifyPlugin);

export default {
	components: {
		Multiselect,
	  },
	props: {"calcKpodTrigger": Boolean},
	data: function()  {
		return {
      settings: {},
      cabels: [
        {
          name: "3x10",
          value: 10
        },
        {
          name: "3x13",
          value: 13.3
        },
        {
          name: "3x16",
          value: 16
        },
        {
          name: "3x21",
          value: 21.15
        },
        {
          name: "3x25",
          value: 25
        },
        {
          name: "3x33",
          value: 33.6
        },
        {
          name: "3x35",
          value: 35
        },
      ]
    }
  }
}