<template>
  <div>
       <img
        class="rods-image"
        :src="shgnImg"
        alt="podbor-gno"/>
  </div>
</template>

<script>
import {pgnoMapGetters, pgnoMapState} from "../../../store/helpers";

export default {
    data: function () {
        return {
          shgnImg: null,
          stup: null,
          heavyDown:  null,
          komponovka:  null,
          mechSep: null,
          mydata: [],
          tn: null,
          paker: null,
          yakor: null,
          hvostovik: null,
          yagp: null,
          hd: null,
          imgName: '',
          shgnDict: {
            "3_nohd_nop_noy_noh_noyagp" : '/img/gno/shgn/3s.svg',
            "3_nohd_p_noy_noh_noyagp" :  '/img/gno/shgn/3s-p.svg',
            "3_nohd_nop_yakor_h_noyagp" : '/img/gno/shgn/3s-h-y.svg',
            "3_nohd_nop_noy_h_noyagp" : '/img/gno/shgn/3s-h.svg',
            "3_nohd_nop_noy_h_yagp" : '/img/gno/shgn/3s-h-yagp.svg',
            "3_hd_nop_noy_noh_noyagp" : '/img/gno/shgn/3s-hd.svg',
            "3_hd_p_noy_noh_noyagp" : '/img/gno/shgn/3s-hd-ph.svg',
            "3_hd_nop_y_h_noyagp" : '/img/gno/shgn/3s-h-y-hd.svg',
            "3_hd_nop_noy_h_noyagp" : '/img/gno/shgn/3s-h-hd.svg',
            "3_hd_nop_noy_h_yagp" : '/img/gno/shgn/3s-h-yagp-hd.svg',
            "2_nohd_nop_noy_noh_noyagp" : '/img/gno/shgn/2s.svg',
            "2_nohd_p_noy_h_noyagp" : '/img/gno/shgn/2s-ph.svg',
            "2_nohd_nop_y_h_noyagp" : '/img/gno/shgn/2s-h-y.svg',
            "2_nohd_nop_noy_h_noyagp" : '/img/gno/shgn/2s-h.svg',
            "2_nohd_nop_noy_h_yagp" : '/img/gno/shgn/2s-h-yagp.svg',
            "2_hd_nop_noy_noh_noyagp" : '/img/gno/shgn/2s-hd.svg',
            "2_hd_p_noy_h_noyagp" : '/img/gno/shgn/2s-hd-ph.svg',
            "2_hd_nop_y_h_noyagp" : '/img/gno/shgn/2s-h-y-hd.svg',
            "2_hd_nop_noy_h_noyagp": '/img/gno/shgn/2s-h-hd.svg',
            "2_hd_nop_noy_h_yagp" : '/img/gno/shgn/2s-h-yagp-hd.svg',
            "1_nohd_nop_noy_noh_noyagp" : '/img/gno/shgn/1s.svg',
            "1_nohd_p_noy_noh_noyagp" : '/img/gno/shgn/1s-ph.svg',
            "1_nohd_nop_y_h_noyagp" : '/img/gno/shgn/1s-h-y.svg',
            "1_nohd_nop_noy_h_noyagp" : '/img/gno/shgn/1s-h.svg',
            "1_nohd_nop_noy_h_yagp" : '/img/gno/shgn/1s-h-yagp.svg'
          }
        }
    },
  computed: {
    ...pgnoMapGetters([
      'shgnSettings'
    ]),
    ...pgnoMapState([
      "curveSettings"
    ]),
    ...pgnoMapGetters([
      "shgnSettings",
    ]),
  },
  methods: {
      checkStup() {
        this.stup = this.shgnSettings.stupColumns
        this.komponovka = JSON.parse(JSON.stringify([...this.shgnSettings.komponovka]))

        this.hd = this.shgnSettings.heavyDown ? "hd" : "nohd"
        this.yagp = this.curveSettings.mechanicalSeparation ? "yagp" : "noyagp"
        this.paker = this.komponovka.includes('paker') ? "p" : "nop"
        this.yakor = this.komponovka.includes('yakor') ? "y" : "noy"
        this.hvostovik = this.komponovka.includes('hvostovik') ? "h" : "noh"

        this.imgName = this.stup + "_" + this.hd + "_" + this.paker + "_" + this.yakor + "_" + this.hvostovik + "_" + this.yagp
        this.shgnImg = this.shgnDict[this.imgName]
    }
  },
  mounted() {
      this.checkStup()
  }
}
</script>