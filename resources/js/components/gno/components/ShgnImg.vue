<template>
  <div>
       <img class="podborgnoimg"
        :src="shngImg"
        alt="podbor-gno"/>
  </div>
</template>

<script>
export default {
    data: function () {
        return {
          shngImg: null,
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
        console.log(this.komponovka)
        console.log(this.komponovka.includes('hvostovik'))

        if(this.stup == '3' && this.komponovka.length <= 0 && this.heavyDown == false) {
          console.log('3')
        } else if(this.stup == '3' && this.komponovka.includes('paker') && this.heavyDown == false) {
          console.log('3 i hvostovik s pakerom')
        } else if(this.stup == '3' && this.komponovka.includes('paker', 'yakor') && this.heavyDown == false) {
          console.log('3 i paker s yakorem')
        } else if(this.stup == '3' && this.komponovka.includes('hvostovik') && this.heavyDown == false) {
          console.log('3 i hvostovik')
        } else if(this.stup === '3' && this.mechSep == true && this.heavyDown == false) {
          console.log('3 i mech sep ')

        } else if(this.stup == '3' && this.heavyDown == true && this.komponovka.length <= 0) {
          console.log('3 i tyzh niz')
        } else if(this.stup == '3' && this.heavyDown == true && this.komponovka.includes('paker', 'hvostovik')) {
          console.log('3 i pakerhvostovik')
        } else if(this.stup == '3' && this.heavyDown == true && this.komponovka.includes('paker', 'yakor')) {
          console.log('3 i pakerhvostovik')
        } else if(this.stup == '3' && this.heavyDown == true && this.komponovka.includes('hvostovik')) {
          console.log('3 i pakerhvostovik')
        } else if(this.stup == '3' && this.heavyDown == true && this.komponovka == ['hvostovik'] && 'yagp') {
          console.log('3 i pakerhvostovik')
        }
        //    2 stup
        else if(this.stup == '2' && this.komponovka.length <= 0 && this.heavyDown == false) {
          console.log('2')
        } else if(this.stup == '2' && this.komponovka.includes('paker', 'hvostovik') && this.heavyDown == false) {
          console.log('2 i pakerhvostovik')
        } else if(this.stup == '2' && this.komponovka.includes('yakor', 'hvostovik') && this.heavyDown == false) {
          console.log('2 i yakor hvostovik')
        } else if(this.stup == '2' && this.komponovka.includes('hvostovik') && this.heavyDown == false) {
          console.log('2 i hvostovik')
        // } else if(this.stup == '2' && this.heavyDown == null && this.komponovka == ['hvostovik'] && 'yagp') {
        //   console.log('3 i pakerhvostovik')
        }
        //      2 sup тяж низ
        else if(this.stup == '2' && this.komponovka.length <= 0 && this.heavyDown == true) {
          console.log('2 тяж')
        } else if(this.stup == '2' && this.komponovka.includes('paker', 'hvostovik') && this.heavyDown == true) {
          console.log('2 i pakerhvostovik тяж')
        } else if(this.stup == '2' && this.komponovka.includes('yakor', 'hvostovik') && this.heavyDown == true) {
          console.log('2 i yakor hvostovik тяж')
        } else if(this.stup == '2' && this.komponovka.includes('hvostovik') && this.heavyDown == true) {
          console.log('2 i hvostovik')
        // } else if(this.stup == '2' && this.heavyDown == true && this.komponovka == ['hvostovik'] && 'yagp') {
        //   console.log('3 i pakerhvostovik')
        }
        //    1 stup
        else if(this.stup == '1' && this.komponovka.length <= 0 && this.heavyDown == null) {
          console.log('1')
        } else if(this.stup == '1' && this.komponovka.includes('paker', 'hvostovik') && this.heavyDown == false) {
          console.log('1 paker hvostovik')
        } else if(this.stup == '1' && this.komponovka.includes('yakor', 'hvostovik') && this.heavyDown == false) {
          console.log('1 paker hvostovik')
        } else if(this.stup == '1' && this.komponovka.includes('hvostovik') && this.heavyDown == false) {
          console.log('1 paker hvostovik')
        // } else if(this.stup == '1' && this.heavyDown == null && this.komponovka == ['hvostovik'] && 'yagp') {
        //   console.log('3 i pakerhvostovik')
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