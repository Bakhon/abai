export default {
  data: function () {
    return {
      data: [],
    }
  },
  methods: {
    getDZOName(dzo) {
      let fullCompanyName;
      switch (dzo) {
        case "ЭМГ":
          fullCompanyName = 'АО "ЭмбаМунайГаз"';
          break;
        case "ПКИ":
          fullCompanyName = 'АО "ЭмбаМунайГаз"';
          break;
        case "АМГ":
          fullCompanyName = 'АО "ЭмбаМунайГаз"';
          break;
        case "ТШ":
          fullCompanyName = 'АО "ЭмбаМунайГаз"';
          break;
        case "НКО":
          fullCompanyName = 'АО "ЭмбаМунайГаз"';
          break;
        case "КПО":
          fullCompanyName = 'АО "ЭмбаМунайГаз"';
          break;
        default:
          fullCompanyName = dzo;
          break;
      }

      return fullCompanyName;
    },
    getDZOdata(date) {
      let uri = "/ru/getdzocalcs";
      this.axios.get(uri, {params: {'date': date}}).then((response) => {
        let data = response.data;
        if (data) {
          let dzoData = [];
          data.forEach((item) => {
            dzoData.push({
              fullCompanyName: this.getDZOName(item.dzo),
            });
          });
          console.log(dzoData);
          this.data = data;
        } else {
          console.log("No data");
        }
      })
    }
  },
  async mounted() {
    let date = '01.05.2020';
    this.getDZOdata(date);
  }
}