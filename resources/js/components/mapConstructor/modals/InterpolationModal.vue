<template>
    <div class="h-100 p-3">
        <ul class="nav nav-tabs">
            <li class="nav-item active">
                <a class="nav-link active" data-toggle="tab" href="#data">Данные</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" data-toggle="tab" href="#method">Метод</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" data-toggle="tab" href="#trend">Тренд</a>
            </li>
        </ul>
        <div class="tab-content">
            <div id="data" class="tab-pane fade show active">
                <div class="input-group mt-4 pl-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Выбор данных:</span>
                    </div>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="inputGroupFile01" ref="file"
                               aria-describedby="inputGroupFileAddon01" @change="fileChangeHandler()">
                        <label class="custom-file-label text-right" for="inputGroupFile01">{{ dataFileName }}</label>
                    </div>
                </div>
            </div>
            <div id="method" class="tab-pane fade">
                <div class="input-group mt-4 pl-2">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="methodType">Метод:</label>
                    </div>
                    <select class="custom-select text-right" id="methodType"
                            v-model="methodType" @change="changeMethodType">
                        <option value="delaunay">Делоне</option>
                        <option value="rbf">RBF</option>
                        <option value="universal_kriging">Кригинг (Ordinary)</option>
                        <option value="ordinary_kriging">Кригинг (Universal)</option>
                    </select>
                </div>
                <div v-if="isVariogramModelShow" class="input-group mt-2 pl-2">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="variogramModel">Модель вариограммы для Кригинга:</label>
                    </div>
                    <select class="custom-select text-right" id="variogramModel" v-model="variogramModel">
                        <option value="linear">Линейная</option>
                        <option value="power">Силовая</option>
                        <option value="gaussian">Гауса</option>
                        <option value="spherical">Сферическая</option>
                        <option value="exponential">Экспоненциальная</option>
                    </select>
                </div>
                <div class="input-group mt-2 pl-2">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="shape_x">Размеры ячейки:</label>
                    </div>
                    <input type="number" class="form-control" id="shape_x" placeholder="X" v-model="shapeX">
                    <input type="number" class="form-control" id="shape_y" placeholder="Y" v-model="shapeY">
                </div>
                <div class="input-group mt-2">
                    <div class="form-group col-md-10 pl-2 mb-1">
                        <select id="inputState" class="form-control" v-model="selectedFilterType">
                            <option value="0">{{ trans('map_constructor.isolines_count') }}</option>
                            <option value="1">{{ trans('map_constructor.interval') }}</option>
                        </select>
                    </div>
                    <div class="form-group col-md-2 p-0 mb-1">
                        <input type="number" class="form-control" id="inputZip" v-model="selectedFilterValue">
                    </div>
                </div>
            </div>
            <div id="trend" class="tab-pane fade">
                <div class="input-group mt-4 pl-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input type="checkbox" @change="trendFileDisabled = !trendFileDisabled">
                        </div>
                    </div>
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="useTrend">Использовать тренд:</span>
                    </div>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="trendFile" ref="trendFile"
                               aria-describedby="trendFile" :disabled="trendFileDisabled"
                               @change="trendFileChangeHandler()">
                        <label class="custom-file-label text-right"
                               :class="{'disabled': trendFileDisabled}"
                               for="trendFile">{{ trendFileName }}</label>
                    </div>
                </div>
                <div class="input-group mt-2 pl-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input type="checkbox" @change="lineFileDisabled = !lineFileDisabled">
                        </div>
                    </div>
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="useLineFile">Загрузить границу:</span>
                    </div>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="lineFile" ref="lineFile"
                               aria-describedby="lineFile" multiple
                               :disabled="lineFileDisabled"
                               @change="lineFileChangeHandler()">
                        <label class="custom-file-label text-right"
                               :class="{'disabled': lineFileDisabled}"
                               for="lineFile">{{ lineFileNames }}</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-1 d-flex flex-row-reverse w-100">
            <button type="button" class="btn btn-secondary" @click="$emit('close')"> {{
                    trans('map_constructor.cancel')
                }}
            </button>
            <button type="button" class="btn btn-primary mr-1" @click="buildMapHandler">
                {{ trans('map_constructor.apply') }}
            </button>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        buildMap: Function,
    },
    data: function () {
        return {
            dataFileName: 'Выберите файл',
            dataFile: null,
            lineFileNames: 'Выберите файл',
            lineFileType: null,
            lineFilesData: null,
            lineFileDisabled: true,
            trendFileName: 'Выберите файл',
            trendFileData: null,
            trendFileDisabled: true,
            methodType: 'delaunay',
            isVariogramModelShow: false,
            variogramModel: 'linear',
            selectedFilterType: 0,
            selectedFilterValue: 10,
            shapeX: 10,
            shapeY: 10,
        }
    },
    methods: {
        fileChangeHandler() {
            this.dataFile = this.$refs.file.files[0];
            this.dataFileName = this.dataFile.name;
        },
        lineFileChangeHandler() {
            const extensions = ['shp', 'txt'];
            let fileNames = [];
            let fileType = '';
            this.lineFilesData = this.$refs.lineFile.files;
            this.lineFilesData.forEach(item => {
                fileNames.push(item.name);
                if (fileType === '') {
                    extensions.forEach(extension => {
                            if (item.name.indexOf(extension) !== -1) {
                                fileType = extension;
                            }
                        }
                    )
                }
            })
            this.lineFileNames = fileNames.join(', ');
            this.lineFileType = fileType;
        },
        trendFileChangeHandler() {
            this.trendFileData = this.$refs.trendFile.files[0];
            this.trendFileName = this.trendFileData.name;
        },
        buildMapHandler() {
            this.buildMap();
        },
        changeMethodType() {
            this.isVariogramModelShow = this.methodType === 'universal_kriging'
                || this.methodType === 'ordinary_kriging';
        },
    }
}
</script>
<style scoped>
.card {
    background-color: rgb(70, 73, 142);
}

.nav-link {
    color: #fff;
    border-top-color: rgb(51, 57, 117);
    border-right-color: rgb(51, 57, 117);
    border-left-color: rgb(51, 57, 117);
    border-bottom-color: white;
}

.nav-link.active {
    color: #fff;
    background-color: rgb(51, 57, 117);
    border-bottom-color: rgb(51, 57, 117);
}

.custom-file-label::after {
    content: none;
}

.input-group-text {
    color: #fff;
    background-color: rgb(51, 57, 117);
}

.custom-file-label.disabled {
    color: rgb(51, 57, 117);
    background-color: rgb(51, 57, 117);
}
</style>