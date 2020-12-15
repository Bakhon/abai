<template>
    <div class="row history">
        <template v-if="history && history.length">
            <div class="col-3 history__list">
                <div
                    class="history__list-item"
                    :class="{'history__list-item_active': selectedItem && selectedItem.id === historyItem.id}"
                    v-for="(historyItem, index) in history"
                    :key="`history_${index}`"
                    @click="showHistoryItem(index)"
                >
                    <p><b>{{ historyItem.user }}</b></p>
                    <p>{{ historyItem.updated_at }}</p>
                </div>
            </div>
            <div class="col-9">
                <table class="table table-bordered history__fields" v-if="selectedItem">
                    <tr>
                        <th><b>Наименование</b></th>
                        <th>
                            <p><b>{{ previousUser }}</b></p>
                            <span>{{ previousDate }}</span>
                        </th>
                        <th>
                            <p><b>{{ selectedItem.user }}</b></p>
                            <span>{{ selectedItem.created_at }}</span>
                        </th>
                    </tr>
                    <tr v-for="(row, index) in selectedItem.payload" :key="index" :class="{'changed': row.changed}">
                        <td>{{ row.name }}</td>
                        <td>{{ row.old }}</td>
                        <td>{{ row.new }}</td>
                    </tr>
                </table>
            </div>
        </template>
        <template v-else>
            <p class="w-100 text-center mb-0">Запись не редактировалась</p>
        </template>
    </div>
</template>

<script>
export default {
    props: [
        'history'
    ],
    data: function () {
        return {
            selectedIndex: null,
            selectedItem: null,
            previousUser: null,
            previousDate: null
        }
    },
    mounted() {
        if (this.history.length > 0) {
            this.showHistoryItem(0)
        }
    },
    methods: {
        showHistoryItem(index) {

            this.selectedIndex = index
            this.selectedItem = this.history[index]

            if (typeof this.history[index + 1] !== 'undefined') {
                this.previousDate = this.history[index + 1].updated_at
                this.previousUser = this.history[index + 1].user
            } else {
                this.previousDate = this.previousUser = ''
            }

        }
    }
}
</script>
<style lang="scss">
.history {
    background: #20274e;
    color: #fff;

    margin: 0 0 20px;
    padding: 20px 10px;

    &__list {
        max-height: calc(100vh - 270px);
        overflow-y: auto;

        &-item {
            border: 1px solid #ccc;
            border-radius: 10px;
            margin-bottom: 5px;
            padding: 5px 20px;

            &_active {
                background: #15509d;
                border-color: transparent;
            }

            p {
                margin: 0;
            }
        }
    }

    &__fields {
        tr {
            color: #ccc;

            th {
                color: #fff;
                font-weight: normal;

                p {
                    margin: 0;
                }
            }

            &.changed {
                color: #fff;
                font-weight: bold;
            }
        }
    }
}
</style>
