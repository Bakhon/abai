<template>
    <div>
        <div class="col m-0 p-0">
            <div
                :class="[
                    menuType === 'big' ? 'paegtm-main' : ''
                ]"
            >
                <div
                    class="row m-0 text-left"
                    :class="[
                        menuType === 'big' ? 'h-75' : ''
                    ]"
                >
                    <div class="col-4 p-1" v-for="menuItem in menu">
                        <div
                            class="rounded menu-item-bg"
                            :class="[
                                menuType === 'big' ? 'main-category m-1' : 'mini-category',
                                menuType !== 'big' && parentType === menuItem.parentType ? 'menu-item-active' : '',
                            ]"
                        >
                            <img
                                :src="menuItem.icon"
                                :width="[
                                    menuType === 'big' ? '48' : '24'
                                ]"
                                :height="[
                                    menuType === 'big' ? '48' : '24'
                                ]"
                            >
                            <span class="ml-2"><a href="/ru/paegtm" class="menu-item">{{ menuItem.name }}</a></span>
                        </div>
                        <div
                            class="p-0 pl-1 pr-1"
                            :class="{'d-none': menuType !== 'big'}"
                        >
                            <div class="main-menu-font text-left dark-bg mh-750 menu-border">
                                <div class="p-4 pl-5" v-for="child in menuItem.children">
                                    <a
                                        :class="[
                                            child.component ? 'cursor-pointer text-white' : 'text-not-link'
                                        ]"
                                        v-html="child.name"
                                        @click="menuClick(child.component)"
                                    ></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        menuType: String,
        parentType: String,
    },
    data: function () {
        return {
            menu: [
                {
                    name: 'Анализ эффективности ГТМ',
                    icon: '/img/GTM/aegtm_icon.svg',
                    parentType: 'aegtm',
                    children: [
                        {
                            name: 'Анализ технологических показателей<br />(количество, добыча в разрезе ГТМ/ВНС)',
                            component: {
                                name: 'child-component',
                                template: '<div><gtm-aegtm></gtm-aegtm></div>',
                                parentType: 'aegtm',
                            },
                        },
                        {
                            name: 'Анализ экономических показателей<br />(затраты, PI, и т.п. в разрезе ГТМ/ВНС)',
                            component: {
                                name: 'child-component',
                                template: '<div><gtm-aegtm-eco></gtm-aegtm-eco></div>',
                                parentType: 'aegtm',
                            },
                        },
                        {
                            name: 'Смежные графики',
                            component: null,
                        },
                        {
                            name: 'Выгрузка отчетности',
                            component: null,
                        },
                    ]
                },
                {
                    name: 'Подбор кандидатов для ГТМ',
                    icon: '/img/GTM/podbor_gtm_icon.svg',
                    parentType: 'podborGtm',
                    children: [
                        {
                            name: 'Критерии подбора',
                            component: {
                                name: 'child-component',
                                template: '<div><gtm-podbor-gtm></gtm-podbor-gtm></div>',
                                parentType: 'podborGtm',
                            },
                        },
                        {
                            name: 'Кол-во кандидатов по видам ГТМ',
                            component: null,
                        },
                        {
                            name: 'Прогноз эффективности (методика)',
                            component: null,
                        },
                        {
                            name: 'Ранжирование кандидатов',
                            component: null,
                        },
                        {
                            name: 'Программа ГТМ',
                            component: null,
                        },
                        {
                            name: 'Выгрузка отчетности',
                            component: null,
                        },
                    ]
                },
                {
                    name: 'Цифровой рейтинг новых скважин',
                    icon: '/img/GTM/new_wells_rating.svg',
                    children: [
                        {
                            name: 'Критерии подбора',
                            component: null,
                        },
                        {
                            name: 'Прогноз эффективности (методика)',
                            component: null,
                        },
                        {
                            name: 'Ранжирование кандидатов',
                            component: null,
                        },
                        {
                            name: 'Программа бурения',
                            component: null,
                        },
                        {
                            name: 'Выгрузка отчетности',
                            component: null,
                        },
                    ]
                },
            ]
        };
    },
    methods: {
        menuClick (childComponent) {
            this.$emit('menuClick', childComponent);
        }
    },
}
</script>