import moment from "moment";

const showToast = {
    methods: {
        showToast(message, title, variant, delay = 5000) {
            const h = this.$createElement

            const vNodesMsg = h(
                'div',
                {},
                [
                    h('div',
                        {
                            class: {
                                '__img': true,
                                [variant]: true
                            }
                        },
                        [
                            h('img', {
                                attrs: {
                                    src: '/img/icons/well_icon.svg'
                                }
                            })
                        ]
                    ),

                    h('div', {
                            class: ['__body']
                        },
                        [
                            h('p', {
                                class: ['__title']
                            }, title),
                            h('p', {
                                class: ['__message']
                            }, message),
                        ]
                    )
                ]
            );

            const vNodesTitle = h(
                'div',
                {class: ['__time']},
                moment().format("DD MMMM YYYY, dddd, H:mm")
            )

            this.$bvToast.toast([vNodesMsg], {
                toastClass: 'customToast',
                title: [vNodesTitle],
                solid: true,
                variant: variant,
                autoHideDelay: delay,
            })
        }
    }
}

export default showToast;