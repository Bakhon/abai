export default {
  methods: {
    restrictChars(event) {
      if (event.charCode === 0 || /\d/.test(String.fromCharCode(event.charCode))) {
        return true;
      } else {
        event.preventDefault();
      }
    }
  }
}