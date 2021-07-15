<template>
  <div ref="mapContainer" id="mapContainer"></div>
</template>

<script>
import mapTool from "./mapTool";
const map = new mapTool("#mapContainer");

export default {
  name: "OilMapKz",
  data() {
    return {
      map: null,
    }
  },
  mounted() {
    this.map = map.createSvg({
      background: "none",
      scale: 1000,
      center: [50, 50],
      viewBox: `-100 0 800 50`,
    });

    map.createMap('/coords/kz.json', "kz", true, {
      kz: [
        ['fill', 'none'],
        ['stroke', 'white'],
        ['stroke-width','1px']
      ]
    });
    map.createMap('/coords/balkhash.json', false, true, {
      balkhash: [
        ['fill', 'transparent'],
        ['stroke', 'yellow']
      ]
    });
    map.createMap('/coords/torgai.json', false, true, {
      torgai: [
        ['fill', 'none'],
        ['stroke', 'yellow']
      ]
    });
    map.createMap('/coords/ustyrt.json', false, true, {
      ustyrt: [
        ['fill', 'none'],
        ['stroke', 'yellow']
      ]
    });
    map.createMap('/coords/alakol.json', false, true, {
      alakol: [
        ['fill', 'none'],
        ['stroke', 'yellow']
      ]
    });
    map.createMap('/coords/aral.json', false, true, {
      aral: [
        ['fill', 'none'],
        ['stroke', 'yellow']
      ]
    });
    map.createMap('/coords/mangyshlak.json', false, true, {
      mangyshlak: [
        ['fill', 'none'],
        ['stroke', 'yellow']
      ]
    });
    map.createMap('/coords/precaspian.json', false, true, {
      precaspian: [
        ['fill', 'none'],
        ['stroke', 'yellow']
      ]
    });
    map.createMap('/coords/preertis.json', false, true, {
      preertis: [
        ['fill', 'none'],
        ['stroke', 'yellow']
      ]
    });
    map.createMap('/coords/storgay.json', false, true, {
      storgay: [
        ['fill', 'none'],
        ['stroke', 'yellow']
      ]
    });
    map.createMap('/coords/zaisan.json', false, true, {
      zaisan: [
        ['fill', 'none'],
        ['stroke', 'yellow']
      ]
    });
    /*map.createMap('/coords/Ili.json', false, true, {
      Ili: [
        ['fill', 'none'],
        ['stroke', 'yellow']
      ]
    });*/
    map.createMap('/coords/norkz.json', false, true, {
      norkz: [
        ['fill', 'none'],
        ['stroke', 'yellow']
      ]
    });
    map.createMap('/coords/syrdaria.json', false, true, {
      syrdaria: [
        ['fill', 'none'],
        ['stroke', 'yellow']
      ]
    });
    map.createMap('/coords/teniz.json', false, true, {
      teniz: [
        ['fill', 'none'],
        ['stroke', 'yellow']
      ]
    });
    map.createMap('/coords/borderbasin.json', false, true, {
      borderbasin: [
        ['fill', 'none'],
        ['stroke', 'yellow']
      ]
    });
  },
}
</script>

<style lang="scss" scoped>
#mapContainer{
  &::v-deep{
    svg{
      width: 100%;
      height: 100%;
    }
  }
}
</style>