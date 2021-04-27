import { isString } from "lodash";

export default {
    data() {
        return {
            page: 1,
            pageSize: 20,
            pageCount: 0,
            allItems: [],
            pageData: [],
        }
    },
    methods: {
        pageChangeHandler(page) {
            this.pageData = this.allItems[page - 1] || this.allItems[0]
        },
        setupPagination(allItems) {
            this.allItems = _.chunk(allItems, this.pageSize)
            this.pageCount = _.size(allItems, this.allItems)
            this.pageData = this.allItems[this.page - 1] || this.allItems[0]
        }
    }

}