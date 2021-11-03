import {
  pgnoMapState,
  pgnoMapGetters,
  pgnoMapMutations,
  pgnoMapActions,
} from "@store/helpers";
import dropdownMultiselect from "../../components/multiselect/MultiSelect.vue";

export default {
  props: ["shgnResult"],
  components: {
    dropdownMultiselect,
  },
  computed: {
    ...pgnoMapState([
      "well",
      "centralizerRange",
      "centralizerResult",
      "centralizerSettings"
    ]),
    ...pgnoMapGetters([
      'curveSettingsStore',
      'shgnSettings'
    ])
  },
  data: function() {
    return {
      apiUrl: process.env.MIX_PGNO_API_URL,
      selected: [],
      requiredRanges: [],
      recommendedRanges: [],
      mychoice: [],
      nkt_choose: [
        13,
        16,
        19,
        22,
        25,
        29,
      ],
      centralizers: {},
      centralizersResult: [],
      centralizersFullData: {
      },
    }
  },
  created() {
    this.centralizers = this.centralizerSettings
    this.centralizersFullData = this.centralizerResult
    this.centralizersResult = this.centralizersFullData.result
    this.centralizers.lowerRod = this.shgnResult.construction[Object.keys(this.shgnResult.construction)[Object.keys(this.shgnResult.construction).length - 1]][0]
    this.centralizers.hasRequiredIntervals = this.centralizerRange.red ? true : false
    this.centralizers.hasRecommendedIntervals = this.centralizerRange.yellow ? true : false
    this.centralizers.requiredRanges = this.requiredRanges = this.centralizerRange.red ? this.centralizerRange.red.split(", ") : []
    this.centralizers.recommendedRanges = this.recommendedRanges = this.centralizerRange.yellow ? this.centralizerRange.yellow.split(", ") : []
    this.calculateRods()
  },
  methods: {
    ...pgnoMapActions ([
      "setCentralizersResult",
    ]),
    onClickRequiredRanges(selectedValues) {
      this.centralizers.requiredRanges = selectedValues
      this.calculateRods()
    },
    onClickRecommendedRanges(selectedValues) {
      this.centralizers.recommendedRanges = selectedValues
      this.calculateRods()
    },
    async calculateRods() {
      let payload = {}
      payload.url = this.apiUrl + "centralizers/" + this.well.fieldUwi + "/" + this.well.wellUwi;
      payload.data = this.centralizers
      payload.data['result'] = this.shgnResult,
      axios.post(payload.url, payload.data).then((response) => {
        let data = response.data
        this.centralizersResult = data.result
        this.centralizersFullData = data
      })},
    closeModal() {
      this.setCentralizersResult(this.centralizersFullData)
      this.$emit('click', "close")
    }
  },
}
