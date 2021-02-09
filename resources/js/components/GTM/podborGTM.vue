<template>
    <div class="row mx-0 mt-lg-3">
        <div class="bg-dark col-12 col-md-4 col-lg-2 p-0">
            <div class="block-header text-center">
                Соседние скважины
            </div>
            <div class="bg-dark table-responsive near-wells-table-block">
                <table class="table table-striped table-borderless text-center text-white near-wells">
                    <tbody>
                    <tr>
                        <td class="align-middle text-left pl-3">Соседние скважины</td>
                        <td class="align-middle">Расстояние,м</td>
                        <td class="align-middle">Горизонты</td>
                    </tr>
                    <tr><td colspan="3" class="text-center near-wells-big">Добывающие</td></tr>
                    <tr class="near-wells-table-item" v-for="item in nearWellsData">
                        <td class="text-left p-2 pl-3">{{ item.name }}</td>
                        <td>{{ item.distance }}</td>
                        <td>{{ item.horizons }}</td>
                    </tr>
                    <tr><td colspan="3" class="text-center near-wells-big">Нагнетательные</td></tr>
                    <tr class="near-wells-table-item" v-for="item in nearWellsData">
                        <td class="text-left p-2 pl-3">{{ item.name }}</td>
                        <td>{{ item.distance }}</td>
                        <td>{{ item.horizons }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="d-none d-lg-block col-lg-5 p-0 pl-2 gtm-map-block">
            <div class="bg-dark text-center h-100">
                <div class="block-header">
                    Карты
                </div>
                <div class="bg-dark p-3">
                    <img src="/img/GTM/map.svg" class="gtm-map-img">
                </div>
            </div>
        </div>
        <div class="col-12 col-md-8 col-lg-5 p-0 pl-md-2 pt-2 pt-md-0">
            <div class="bg-dark h-100">
                <div class="block-header text-center">
                    Таблица данных скважин
                </div>
                <div class="bg-dark">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data: function () {
        return {
            nearWellsData: [
                {name: 'Jet_2596', distance: '', horizons: ''},
                {name: 'Jet_3303', distance: '', horizons: ''},
                {name: 'Jet_2875', distance: '', horizons: ''},
                {name: 'Jet_1300', distance: '', horizons: ''},
                {name: 'Jet_4937', distance: '', horizons: ''},
                {name: 'Jet_3309', distance: '', horizons: ''},
                {name: 'Jet_0299', distance: '', horizons: ''},
                {name: 'Jet_0239', distance: '', horizons: ''},
                {name: 'Jet_4717', distance: '', horizons: ''},
            ]
        };
    }
}
</script>