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

    map.createMap('/kz.json', "kz", true, {
      kz: [
        ['fill', 'none'],
        ['stroke', 'white'],
        ['stroke-width','3px']
      ]
    });
    map.createMap('/balkhash.json', false, true, {
      balkhash: [
        ['fill', 'none'],
        ['stroke', 'yellow']
      ]
    });
    map.createMap('/torgai.json', false, true, {
      torgai: [
        ['fill', 'none'],
        ['stroke', 'yellow']
      ]
    });
    map.createMap('/ustyrt.json', false, true, {
      ustyrt: [
        ['fill', 'none'],
        ['stroke', 'yellow']
      ]
    });
    map.createMap('/alakol.json', false, true, {
      alakol: [
        ['fill', 'none'],
        ['stroke', 'yellow']
      ]
    });
    map.createMap('/aral.json', false, true, {
      aral: [
        ['fill', 'none'],
        ['stroke', 'yellow']
      ]
    });
    map.createMap('/mangyshlak.json', false, true, {
      mangyshlak: [
        ['fill', 'none'],
        ['stroke', 'yellow']
      ]
    });
    map.createMap('/precaspian.json', false, true, {
      precaspian: [
        ['fill', 'none'],
        ['stroke', 'yellow']
      ]
    });
    map.createMap('/preertis.json', false, true, {
      preertis: [
        ['fill', 'none'],
        ['stroke', 'yellow']
      ]
    });
    map.createMap('/storgay.json', false, true, {
      storgay: [
        ['fill', 'none'],
        ['stroke', 'yellow']
      ]
    });
    map.createMap('/zaisan.json', false, true, {
      zaisan: [
        ['fill', 'none'],
        ['stroke', 'yellow']
      ]
    });
    map.createMap('/Ili.json', false, true, {
      Ili: [
        ['fill', 'none'],
        ['stroke', 'yellow']
      ]
    });
    map.createMap('/norkz.json', false, true, {
      norkz: [
        ['fill', 'none'],
        ['stroke', 'yellow']
      ]
    });
    map.createMap('/syrdaria.json', false, true, {
      syrdaria: [
        ['fill', 'none'],
        ['stroke', 'yellow']
      ]
    });
    map.createMap('/teniz.json', false, true, {
      teniz: [
        ['fill', 'none'],
        ['stroke', 'yellow']
      ]
    });
    map.createMap('/borderbasin.json', false, true, {
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