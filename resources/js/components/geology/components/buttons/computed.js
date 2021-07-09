export default {
    computed: {
        isActive(){
            if(this.hasCheckActive){
                return this.$urlLink(this.href) === this.$currentPageUrl;
            }
        },
        classes() {
            return {
                'a-btn': true,
                [this.color]: this.color,
                [this.align]: this.align,
                [this.size]: this.size,
            }
        }
    }
}
