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
        ['stroke', 'white']
      ]
    });
    map.createMap('/balkhash.json', false, true, {
      balkhash: [
        ['fill', 'none'],
        ['stroke', 'white']
      ]
    });
    map.createMap('/torgai.json', false, true, {
      torgai: [
        ['fill', 'none'],
        ['stroke', 'white']
      ]
    });
    map.createMap('/ustyrt.json', false, true, {
      ustyrt: [
        ['fill', 'none'],
        ['stroke', 'white']
      ]
    });
    map.createMap('/alakol.json', false, true, {
      alakol: [
        ['fill', 'none'],
        ['stroke', 'white']
      ]
    });
    map.createMap('/aral.json', false, true, {
      aral: [
        ['fill', 'none'],
        ['stroke', 'white']
      ]
    });
    map.createMap('/mangyshlak.json', false, true, {
      mangyshlak: [
        ['fill', 'none'],
        ['stroke', 'white']
      ]
    });
    map.createMap('/precaspian.json', false, true, {
      precaspian: [
        ['fill', 'none'],
        ['stroke', 'white']
      ]
    });
    map.createMap('/preertis.json', false, true, {
      preertis: [
        ['fill', 'none'],
        ['stroke', 'white']
      ]
    });
    map.createMap('/storgay.json', false, true, {
      storgay: [
        ['fill', 'none'],
        ['stroke', 'white']
      ]
    });
    map.createMap('/zaisan.json', false, true, {
      zaisan: [
        ['fill', 'none'],
        ['stroke', 'white']
      ]
    });
    map.createMap('/Ili.json', false, true, {
      Ili: [
        ['fill', 'none'],
        ['stroke', 'white']
      ]
    });
    map.createMap('/norkz.json', false, true, {
      norkz: [
        ['fill', 'none'],
        ['stroke', 'white']
      ]
    });
    map.createMap('/syrdaria.json', false, true, {
      syrdaria: [
        ['fill', 'none'],
        ['stroke', 'white']
      ]
    });
    map.createMap('/teniz.json', false, true, {
      teniz: [
        ['fill', 'none'],
        ['stroke', 'white']
      ]
    });
    map.createMap('/borderbasin.json', false, true, {
      borderbasin: [
        ['fill', 'none'],
        ['stroke', 'white']
      ]
    });
    map.createMap('/kozhasai_fault2_1.json', false, true, {
      kozhasai_fault2_1: [
        ['fill', 'none'],
        ['stroke', 'white']
      ]
    });
    map.createMap('/kozhasai_fault2_2.json', false, true, {
      kozhasai_fault2_2: [
        ['fill', 'none'],
        ['stroke', 'white']
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