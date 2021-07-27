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
          stup: this.$store.getters.stupColumns,
          heavyDown:  this.$store.getters.heavyDown,
          komponovka:  this.$store.getters.komponovka,
        }
    },
    mounted() {
        if(this.stup === '3' && this.komponovka === null && this.heavyDown === null) {
          console.log('3')
        } else if(this.stup === '3' && this.komponovka === ['paker', 'hvostovik'] && this.heavyDown === null) {
          console.log('3 i hvostovik s pakerom')
        } else if(this.stup === '3' && this.komponovka === ['paker', 'yakor'] && this.heavyDown === null) {
          console.log('3 i paker s yakorem')
        } else if(this.stup === '3' && this.komponovka === 'hvostovik' && this.heavyDown === null) {
          console.log('3 i hvostovik')
        } else if(this.stup === '3' && 'yagp') {
          console.log('3 i hvostovik ')
        //  тяж низ
        } else if(this.stup === '3' && this.heavyDown === true && this.komponovka === null) {
          console.log('3 i tyzh niz')
        } else if(this.stup === '3' && this.heavyDown === true && this.komponovka === ['paker', 'hvostovik']) {
          console.log('3 i pakerhvostovik')
        } else if(this.stup === '3' && this.heavyDown === true && this.komponovka === ['paker', 'yakor']) {
          console.log('3 i pakerhvostovik')
        } else if(this.stup === '3' && this.heavyDown === true && this.komponovka === ['hvostovik']) {
          console.log('3 i pakerhvostovik')
        } else if(this.stup === '3' && this.heavyDown === true && this.komponovka === ['hvostovik'] && 'yagp') {
          console.log('3 i pakerhvostovik')
        }
    //    2 stup
          else if(this.stup === '2' && this.komponovka === null && this.heavyDown === null) {
          console.log('2')
        } else if(this.stup === '2' && this.komponovka === ['paker', 'hvostovik'] && this.heavyDown === null) {
          console.log('2 i pakerhvostovik')
        } else if(this.stup === '2' && this.komponovka === ['yakor', 'hvostovik'] && this.heavyDown === null) {
          console.log('2 i yakor hvostovik')
        } else if(this.stup === '2' && this.komponovka === ['hvostovik'] && this.heavyDown === null) {
          console.log('2 i hvostovik')
        } else if(this.stup === '2' && this.heavyDown === null && this.komponovka === ['hvostovik'] && 'yagp') {
          console.log('3 i pakerhvostovik')
        }
    //      2 sup тяж низ
        else if(this.stup === '2' && this.komponovka === null && this.heavyDown === true) {
          console.log('2 тяж')
        } else if(this.stup === '2' && this.komponovka === ['paker', 'hvostovik'] && this.heavyDown === true) {
          console.log('2 i pakerhvostovik тяж')
        } else if(this.stup === '2' && this.komponovka === ['yakor', 'hvostovik'] && this.heavyDown === true) {
          console.log('2 i yakor hvostovik тяж')
        } else if(this.stup === '2' && this.komponovka === ['hvostovik'] && this.heavyDown === true) {
          console.log('2 i hvostovik')
        } else if(this.stup === '2' && this.heavyDown === true && this.komponovka === ['hvostovik'] && 'yagp') {
          console.log('3 i pakerhvostovik')
        }
    //    1 stup
          else if(this.stup === '1' && this.komponovka === null && this.heavyDown === null) {
          console.log('1')
        } else if(this.stup === '1' && this.komponovka === ['paker', 'hvostovik'] && this.heavyDown === null) {
            console.log('1 paker hvostovik')
        } else if(this.stup === '1' && this.komponovka === ['yakor', 'hvostovik'] && this.heavyDown === null) {
          console.log('1 paker hvostovik')
        } else if(this.stup === '1' && this.komponovka === ['hvostovik'] && this.heavyDown === null) {
          console.log('1 paker hvostovik')
        } else if(this.stup === '1' && this.heavyDown === null && this.komponovka === ['hvostovik'] && 'yagp') {
            console.log('3 i pakerhvostovik')
        }
    }
}
</script>
<style>

</style>