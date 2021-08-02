<template>
  <div>
       <img class="podborgnoimg"
        :src="shgnImg"
        alt="podbor-gno"/>
  </div>
</template>

<script>
export default {
    data: function () {
        return {
          shgnImg: null,
          stup: null,
          heavyDown:  null,
          komponovka:  null,
          mechSep: null,
          mydata: [],
        }
    },
  methods: {
      checkStup() {
        this.stup = this.$store.getters.stupColumns
        this.heavyDown = this.$store.getters.heavyDown
        this.mechSep = this.$store.getters.mechSep
        this.komponovka = JSON.parse(JSON.stringify([...this.$store.getters.komponovka]))
        if(this.stup == '3' && this.komponovka.length <= 0 && this.heavyDown == false) {
          this.shgnImg = require('../images/shgn/3s.svg')
        } else if(this.stup == '3' && this.komponovka.includes('paker') && this.heavyDown == false) {
          this.shgnImg = require('../images/shgn/3s-p.svg')
        } else if(this.stup == '3' && this.komponovka.includes('paker', 'yakor') && this.heavyDown == false) {
          this.shgnImg = require('../images/shgn/3s-h-y.svg')
        } else if(this.stup == '3' && this.komponovka.includes('hvostovik') && this.heavyDown == false) {
          this.shgnImg = require('../images/shgn/3s-h.svg')
        } else if(this.stup === '3' && this.mechSep == true && this.heavyDown == false) {
          this.shgnImg = require('../images/shgn/3s-h-yagp.svg')
        } else if(this.stup == '3' && this.heavyDown == true && this.komponovka.length <= 0) {
          this.shgnImg = require('../images/shgn/3s-hd.svg')
        } else if(this.stup == '3' && this.heavyDown == true && this.komponovka.includes('paker', 'hvostovik')) {
          this.shgnImg = require('../images/shgn/3-ph-hd.svg')
        } else if(this.stup == '3' && this.heavyDown == true && this.komponovka.includes('paker', 'yakor')) {
          this.shgnImg = require('../images/shgn/3s-h-y-hd.svg')
        } else if(this.stup == '3' && this.heavyDown == true && this.komponovka.includes('hvostovik')) {
          this.shgnImg = require('../images/shgn/3s-h-hd.svg')
        } else if(this.stup == '3' && this.heavyDown == true && this.komponovka.includes('hvostovik') && this.mechSep == true)  {
          this.shgnImg = require('../images/shgn/3s-h-yagp-hd.svg')
        }
        else if(this.stup == '2' && this.komponovka.length <= 0 && this.heavyDown == false) {
          this.shgnImg = require('../images/shgn/2s.svg')
        } else if(this.stup == '2' && this.komponovka.includes('paker', 'hvostovik') && this.heavyDown == false) {
          this.shgnImg = require('../images/shgn/2s-ph.svg')
        } else if(this.stup == '2' && this.komponovka.includes('yakor', 'hvostovik') && this.heavyDown == false) {
          this.shgnImg = require('../images/shgn/2s-h-y.svg')
        } else if(this.stup == '2' && this.komponovka.includes('hvostovik') && this.heavyDown == false) {
          this.shgnImg = require('../images/shgn/2s-h.svg')
        } else if(this.stup == '2' && this.heavyDown == false && this.komponovka.includes('hvostovik') && this.mechSep == true) {
          this.shgnImg = require('../images/shgn/2s-h-yagp.svg')
        }
        else if(this.stup == '2' && this.komponovka.length <= 0 && this.heavyDown == true) {
          this.shgnImg = require('../images/shgn/2s-hd.svg')
        } else if(this.stup == '2' && this.komponovka.includes('paker', 'hvostovik') && this.heavyDown == true) {
          this.shgnImg = require('../images/shgn/2s-ph-hd.svg')
        } else if(this.stup == '2' && this.komponovka.includes('yakor', 'hvostovik') && this.heavyDown == true) {
          this.shgnImg = require('../images/shgn/2s-h-y-hd.svg')
        } else if(this.stup == '2' && this.komponovka.includes('hvostovik') && this.heavyDown == true) {
          this.shgnImg = require('../images/shgn/2s-h-hd.svg')
        } else if(this.stup == '2' && this.heavyDown == true && this.komponovka.includes('hvostovik')  && this.mechSep == true) {
          this.shgnImg = require('../images/shgn/2s-h-yagp-hd.svg')
        }
        else if(this.stup == '1' && this.komponovka.length <= 0 && this.heavyDown == false) {
          this.shgnImg = require('../images/shgn/1s.svg')
        } else if(this.stup == '1' && this.komponovka.includes('paker', 'hvostovik') && this.heavyDown == false) {
          this.shgnImg = require('../images/shgn/1s-ph.svg')
        } else if(this.stup == '1' && this.komponovka.includes('yakor', 'hvostovik') && this.heavyDown == false) {
          this.shgnImg = require('../images/shgn/1s-h-y.svg')
        } else if(this.stup == '1' && this.komponovka.includes('hvostovik') && this.heavyDown == false) {
          this.shgnImg = require('../images/shgn/1s-h.svg')
        } else if(this.stup == '1' && this.heavyDown == false && this.komponovka.includes('hvostovik') && this.mechSep == true) {
          this.shgnImg = require('../images/shgn/1s-h-yagp.svg')
        }
    }
  },
  mounted() {
      this.checkStup()
  }
}
</script>
<style>

</style>