<template>
    <div class="map-constructor" >
        <ul class="right-click-menu" ref="right" id="right-click-menu" tabindex="-1" v-if="viewMenu" @blur="closeMenu" :style="{ top:top, left:left }">
            <li>Вставить фигуру</li>
            <li>Текст</li>
            <li>Копировать</li>
            <li>Удалить</li>
            <li>Легенда</li>
            <li class="d-flex justify-content-between align-items-center" @click="openRightMap">Настройки <i class="fas fa-caret-right text-dark"></i></li>
            <div v-if="rightMap">
                <ul class="right-click-menu right-click-menu--dropdown">
                    <li>Значок</li>
                    <li>Линия</li>
                    <li>Цвет</li>
                    <li>Палитра</li>
                    <li>Текст</li>
                    <li>Размеры</li>
                </ul>
            </div>

        </ul>
        <ul class="right-click-menu" ref="rightLayers" id="right-click-menu-layers" tabindex="-1" v-if="viewMenuLayers" @blur="closeMenuLayers" :style="{ top:top, left:left }">
            <li>Переименовать</li>
            <li>Копировать</li>
            <li>Удалить</li>
            <li>Легенда</li>
            <li class="d-flex justify-content-between align-items-center" @click="openRightLayers">Настройки <i class="fas fa-caret-right text-dark"></i></li>
            <div v-if="rightLayers">
                <ul class="right-click-menu right-click-menu--dropdown">
                    <li>Значок</li>
                    <li>Линия</li>
                    <li>Цвет</li>
                    <li>Палитра</li>
                    <li>Текст</li>
                    <li>Размеры</li>
                    <li>Название карты</li>
                    <li>Подписи контура</li>
                    <li>Легенда и подпись</li>
                </ul>
            </div>
            <li>Информация</li>
        </ul>
        <div class="top-menu">
            <div class="col-lg-3 px-1">
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body">
                                <p class="mb-4">Тип данных, карта, контур, полигон...</p>
                                <p>Формат</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary">Импорт</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body">
                                <p class="mb-4">Тип данных, карта, контур, полигон...</p>
                                <p>Формат</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary">Экспорт</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade modal-printer" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModalLabel3" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span class="text-white" aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-5 printer-left">
                                            <img src="/img/map-constructor/a4.png" alt="" class="img-fluid">
                                            <div class="d-flex align-items-center mt-2">
                                                <i class="fas fa-angle-left"></i>
                                                <span class="mx-3 printer-left-text">1 из 1</span>
                                                <i class="fas fa-angle-right"></i>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-12">
                                                    <label for="all-pages7">
                                                        <input id="all-pages7" type="checkbox" class="mt-1" aria-label="all pages">
                                                        <span class="ml-1">Добавить рамку для печати</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="row my-2">
                                                <div class="col-6">
                                                    <span>Расположение:</span>
                                                </div>
                                                <div class="col-6">
                                                    <div class="dropdown">
                                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton15" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Книжное
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton15">
                                                            <a class="dropdown-item" href="#">Книжное</a>
                                                            <a class="dropdown-item" href="#">Альбомное</a>
                                                            <a class="dropdown-item" href="#">Something else here</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <span>Формат:</span>
                                                </div>
                                                <div class="col-6">
                                                    <div class="dropdown">
                                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton16" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            а4
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton16">
                                                            <a class="dropdown-item" href="#">а4</a>
                                                            <a class="dropdown-item" href="#">а3</a>
                                                            <a class="dropdown-item" href="#">а2</a>
                                                            <a class="dropdown-item" href="#">а1</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-7 printer-right printer-right--bottom">
                                            <div class="row">
                                                <div class="col-3">
                                                    <p>Принтер:</p>
                                                </div>
                                                <div class="col-9">
                                                    <div class="dropdown">
                                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fas fa-exclamation-triangle mr-2"></i>  Принтер не найден
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <a class="dropdown-item" href="#">Canon MF320</a>
                                                            <a class="dropdown-item" href="#">Hp JVR415</a>
                                                            <a class="dropdown-item" href="#">Something else here</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-3">
                                                    <p class="text-right">Установки:</p>
                                                </div>
                                                <div class="col-9">
                                                    <div class="dropdown">
                                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Последняя установка
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                                            <a class="dropdown-item" href="#">last update</a>
                                                            <a class="dropdown-item" href="#">previous update</a>
                                                            <a class="dropdown-item" href="#">Something else here</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-3">
                                                    <p class="text-right"> Копии:</p>
                                                </div>
                                                <div class="col-9">
                                                    <input type="number" class="form-control number-xl" aria-label="Copies" value="1">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-3">
                                                    <p class="text-right">Копии:</p>
                                                </div>
                                                <div class="col-9">
                                                    <label for="all-pages">
                                                        <input id="all-pages" type="checkbox" class="mt-1" aria-label="all pages">
                                                        <span class="ml-1">Все страницы</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-3">
                                                </div>
                                                <div class="col-9">
                                                    <div class="d-flex align-items-center">
                                                        <input type="checkbox" class="mt-1" aria-label="all pages">
                                                        <span class="mx-2">С:</span>
                                                        <input type="number" class="form-control number-s" aria-label="Copies" value="1">
                                                        <span class="mx-2">до:</span>
                                                        <input type="number" class="form-control number-s" aria-label="Copies" value="1">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="gray-border"></div>
                                            <div class="row">
                                                <div class="col-3">
                                                    <p>Окна на страницу:</p>
                                                </div>
                                                <div class="col-9">
                                                    <div class="dropdown">
                                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Последняя установка
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                                            <a class="dropdown-item" href="#">Canon MF320</a>
                                                            <a class="dropdown-item" href="#">Hp JVR415</a>
                                                            <a class="dropdown-item" href="#">Something else here</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-3">
                                                    <p class="text-right">Двусторонняя:</p>
                                                </div>
                                                <div class="col-9">
                                                    <div class="dropdown">
                                                        <button class="btn btn-secondary dropdown-toggle disabled" type="button" id="dropdownMenuButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Выкл.
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton4">
                                                            <a class="dropdown-item" href="#">last update</a>
                                                            <a class="dropdown-item" href="#">previous update</a>
                                                            <a class="dropdown-item" href="#">Something else here</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-3">
                                                    <p class="text-right">Копии:</p>
                                                </div>
                                                <div class="col-9">
                                                    <label for="all-pages1">
                                                        <input id="all-pages1" type="checkbox" class="mt-1" aria-label="all pages">
                                                        <span class="ml-1">Обратная ориентация страницы</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-3">
                                                    <p class="text-right">Копии:</p>
                                                </div>
                                                <div class="col-9">
                                                    <label for="all-pages2">
                                                        <input id="all-pages2" type="checkbox" class="mt-1" aria-label="all pages">
                                                        <span class="ml-1">Перевернуть по горизонтали</span>
                                                    </label>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary">Печать</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade modal-printer modal-map" id="exampleModal4" tabindex="-1" aria-labelledby="exampleModalLabel4" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span class="text-white" aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body printer-right">
                                <b-card no-body>
                                    <b-tabs card>
                                        <b-tab title="Данные" active>
                                            <div class="row">
                                                <div class="col-4">
                                                    <p>Выбор данных:</p>
                                                </div>
                                                <div class="col-8">
                                                    <div class="dropdown">
                                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            данные
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton5">
                                                            <a class="dropdown-item" href="#">данные</a>
                                                            <a class="dropdown-item" href="#">данные</a>
                                                            <a class="dropdown-item" href="#">Something else here</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-4">
                                                    <p>Фильтр:</p>
                                                </div>
                                                <div class="col-8">
                                                    <div class="dropdown">
                                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton6" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            фильтр
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton6">
                                                            <a class="dropdown-item" href="#">фильтр</a>
                                                            <a class="dropdown-item" href="#">фильтр</a>
                                                            <a class="dropdown-item" href="#">фильтр</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </b-tab>
                                        <b-tab title="Метод">
                                            <div class="row">
                                                <div class="col-4">
                                                    <p>Метод</p>
                                                </div>
                                                <div class="col-8">
                                                    <div class="dropdown">
                                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton7" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Кригинг, Метод Шепарда, Метод
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton7">
                                                            <a class="dropdown-item" href="#">Кригинг</a>
                                                            <a class="dropdown-item" href="#">Метод Шепарда</a>
                                                            <a class="dropdown-item" href="#">Something else here</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-4">
                                                    <p>Размеры ячейки:</p>
                                                </div>
                                                <div class="col-8">
                                                    <div class="d-flex align-items-center">
                                                        <input type="checkbox" class="mt-1" aria-label="all pages">
                                                        <span class="mx-2">X</span>
                                                        <input type="number" class="form-control number-s" aria-label="Copies" placeholder="0000">
                                                        <span class="mx-2">Y</span>
                                                        <input type="number" class="form-control number-s" aria-label="Copies" placeholder="0000">
                                                    </div>
                                                </div>
                                            </div>
                                        </b-tab>
                                        <b-tab title="Тренд">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label for="all-pages3">
                                                        <input id="all-pages3" type="checkbox" class="mt-1" aria-label="all pages">
                                                        <span class="ml-1">Использовать тренд</span>
                                                    </label>
                                                </div>
                                                <div class="col-6">
                                                    <div class="dropdown">
                                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton8" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            .....
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton8">
                                                            <a class="dropdown-item" href="#">.....</a>
                                                            <a class="dropdown-item" href="#">.....</a>
                                                            <a class="dropdown-item" href="#">Something else here</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <label for="all-pages4">
                                                        <input id="all-pages4" type="checkbox" class="mt-1" aria-label="all pages">
                                                        <span class="ml-1">Загрузить границу</span>
                                                    </label>
                                                </div>
                                                <div class="col-6">
                                                    <div class="dropdown">
                                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton9" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            .....
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton9">
                                                            <a class="dropdown-item" href="#">.....</a>
                                                            <a class="dropdown-item" href="#">.....</a>
                                                            <a class="dropdown-item" href="#">Something else here</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <label for="all-pages5">
                                                        <input id="all-pages5" type="checkbox" class="mt-1" aria-label="all pages">
                                                        <span class="ml-1">Учитывать разлом</span>
                                                    </label>
                                                </div>
                                                <div class="col-6">
                                                </div>
                                            </div>
                                        </b-tab>
                                    </b-tabs>
                                </b-card>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary">Применить</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade modal-printer modal-map modal-report" id="exampleModal5" tabindex="-1" aria-labelledby="exampleModalLabel5" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span class="text-white" aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body printer-right">
                                <div class="row align-items-center">
                                    <div class="col-5">
                                        <div class="row">
                                            <div class="col-4">
                                                <p>Выбрать карту:</p>
                                            </div>
                                            <div class="col-8">
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton10" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Карты текущих/накопленных отборов
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton10">
                                                        <a class="dropdown-item" href="#">Карты текущих/накопленных отборов</a>
                                                        <a class="dropdown-item" href="#">Карты изобар</a>
                                                        <a class="dropdown-item" href="#">Карта kh</a>
                                                        <a class="dropdown-item" href="#">Карта перфорированных толщин</a>
                                                        <a class="dropdown-item" href="#">Карта по сетке Вороного</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">
                                                <p>Отчет по скважинам:</p>
                                            </div>
                                            <div class="col-8">
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton11" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Выбор скв
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton11">
                                                        <a class="dropdown-item" href="#">Выбор скв</a>
                                                        <a class="dropdown-item" href="#">МЭР</a>
                                                        <a class="dropdown-item" href="#">ГДИС (Рпл)</a>
                                                        <a class="dropdown-item" href="#">Данные РИГИС</a>
                                                        <a class="dropdown-item" href="#">…</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">
                                                <p>Формат отчета:</p>
                                            </div>
                                            <div class="col-8">
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton12" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        pdf
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton12">
                                                        <a class="dropdown-item" href="#">doc</a>
                                                        <a class="dropdown-item" href="#">excel</a>
                                                        <a class="dropdown-item" href="#">...</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-7">
                                        <div class="report-right">
                                            <h4>Окно предпросмотра карт</h4>
                                            <div class="report-right--map"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary">Применить</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade modal-printer modal-map" id="exampleModal6" tabindex="-1" aria-labelledby="exampleModalLabel6" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span class="text-white" aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body printer-right py-5">
                                <div class="row">
                                    <div class="col-4">
                                        <p>Выбор данных:</p>
                                    </div>
                                    <div class="col-8">
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton13" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                данные
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton13">
                                                <a class="dropdown-item" href="#">данные</a>
                                                <a class="dropdown-item" href="#">данные</a>
                                                <a class="dropdown-item" href="#">Something else here</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <p>Фильтр:</p>
                                    </div>
                                    <div class="col-8">
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton14" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                фильтр
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton14">
                                                <a class="dropdown-item" href="#">фильтр</a>
                                                <a class="dropdown-item" href="#">фильтр</a>
                                                <a class="dropdown-item" href="#">фильтр</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <p>Выбрать дату</p>
                                    </div>
                                    <div class="col-8">
                                        <b-form-datepicker id="example-datepicker" v-model="date1" class="mb-2 dropdown-toggle"></b-form-datepicker>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary">Построить</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade modal-printer modal-map" id="exampleModal7" tabindex="-1" aria-labelledby="exampleModalLabel7" aria-hidden="true" ref="gridModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span class="text-white" aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body d-flex align-items-center justify-content-around py-5">
                                <div class="grid" @click="oneSquare">
                                    <div class="d-flex">
                                        <i class="fas fa-square"></i>
                                        <i class="far fa-square"></i>
                                    </div>
                                    <div class="d-flex">
                                        <i class="far fa-square"></i>
                                        <i class="far fa-square"></i>
                                    </div>
                                </div>
                                <div class="grid" @click="twoSquare">
                                    <div class="d-flex">
                                        <i class="fas fa-square"></i>
                                        <i class="fas fa-square"></i>
                                    </div>
                                    <div class="d-flex">
                                        <i class="far fa-square"></i>
                                        <i class="far fa-square"></i>
                                    </div>
                                </div>
                                <div class="grid" @click="threeSquare">
                                    <div class="d-flex">
                                        <i class="fas fa-square"></i>
                                        <i class="fas fa-square"></i>
                                    </div>
                                    <div class="d-flex">
                                        <i class="fas fa-square"></i>
                                        <i class="far fa-square"></i>
                                    </div>
                                </div>
                                <div class="grid" @click="fourSquare">
                                    <div class="d-flex">
                                        <i class="fas fa-square"></i>
                                        <i class="fas fa-square"></i>
                                    </div>
                                    <div class="d-flex">
                                        <i class="fas fa-square"></i>
                                        <i class="fas fa-square"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <b-dropdown
                        block
                        class="w-100 map-dropdown"
                >
                    <template slot="button-content">
                        <i class="far fa-file mr-2"></i>
                        <span>Файл</span>
                    </template>
                    <b-dropdown-item href="#" @click="addFile">Новое</b-dropdown-item>
                        <label for="file-upload" class="dropdown-item">Открыть
                            <input type="file" name="myfile" id="file-upload" />
                        </label>
                    <b-dropdown-item href="#">Сохранить</b-dropdown-item>
                    <b-dropdown-item data-toggle="modal" data-target="#exampleModal">Импорт</b-dropdown-item>
<!--                        <b-modal :body-bg-variant="bodyBgVariant" ref="my-modal" hide-header hide-footer centered title="BootstrapVue">-->
<!--                            <p class="my-4">Тип данных, карта, контур, полигон...</p>-->
<!--                            <p class="my-4">Формат</p>-->
<!--                            <div class="modal-footer">\-->
<!--                                <button type="button" class="btn btn-primary">Импорт</button>-->
<!--                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>-->
<!--                            </div>-->
<!--                        </b-modal>-->
                    <!-- Modal -->
                    <b-dropdown-item data-toggle="modal" data-target="#exampleModal2">Экспорт</b-dropdown-item>
                    <b-dropdown-item data-toggle="modal" data-target="#exampleModal3">Печать</b-dropdown-item>
                </b-dropdown>
            </div>
            <div class="col-lg-3 px-1">
                <b-dropdown
                        block
                        class=" w-100 map-dropdown"
                >
                    <template slot="button-content">
                        <i class="far fa-map mr-2"></i>
                        <span>Карта</span>
                    </template>
                    <b-dropdown-item data-toggle="modal" data-target="#exampleModal6">Построить карту текущих отборов</b-dropdown-item>
                    <b-dropdown-item data-toggle="modal" data-target="#exampleModal6">Построить карту накопленных отборов</b-dropdown-item>
                    <b-dropdown-item data-toggle="modal" data-target="#exampleModal4">Построить карту</b-dropdown-item>
                    <b-dropdown-item href="#">Калькулятор</b-dropdown-item>
                </b-dropdown>
            </div>
            <div class="col-lg-3 px-1">
                <b-dropdown
                        block
                        class=" w-100 map-dropdown"
                >
                    <template slot="button-content">
                        <i class="fas fa-bars mr-2"></i>
                        <span>Дополнительно</span>
                    </template>
                    <b-dropdown-item href="#">Диаграмма Вороного</b-dropdown-item>
                    <b-dropdown-item href="#">Линии тока</b-dropdown-item>
                    <b-dropdown-item href="#">Подсчет запасов</b-dropdown-item>
                    <b-dropdown-item href="#">Элементы заводнения</b-dropdown-item>
                </b-dropdown>
            </div>
            <div class="col-lg-3 px-1">
                <div class="map-dropdown" data-toggle="modal" data-target="#exampleModal5">
                    <div class="dropdown-toggle">
                        <i class="fas fa-file-invoice mr-2"></i>
                        <span class="text-white">Отчет</span>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-lg-12 px-1 py-3">
            <div class="dashboard">
                <div class="tools">
                    <div class="left-tools">
                        <div class="tool">
                            <div class="box">
                                <i class="fas fa-plus"></i>
                                <i class="fas fa-chevron-down"></i>
                            </div>
                            <span>Добавить</span>
                        </div>
                        <div class="tool">
                            <div class="box">
                                <i class="fas fa-location-arrow"></i>
                            </div>
                            <span>Курсор</span>
                        </div>
                        <div class="tool">
                            <div class="box">
                                <i class="far fa-hand-paper"></i>
                            </div>
                            <span>Рука</span>
                        </div>
                        <div class="tool">
                            <div class="box">
                                <i class="far fa-copy"></i>
                            </div>
                            <span>Копировать</span>
                        </div>
                        <div class="tool">
                            <div class="box">
                                <i class="fas fa-ruler"></i>
                            </div>
                            <span>Линейка</span>
                        </div>
                        <div class="tool">
                            <div class="box">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <span>Справка</span>
                        </div>
                        <div class="tool">
                            <div class="box">
                                <i class="fas fa-cut"></i>
                            </div>
                            <span>Ножницы</span>
                        </div>
                        <div class="tool">
                            <div class="box">
                                <i class="fas fa-draw-polygon"></i>
                            </div>
                            <span>Ред. Полигона</span>
                        </div>
                        <div class="tool">
                            <div class="box">
                                <i class="far fa-circle"></i>
                            </div>
                            <span>Фиктивная точка</span>
                        </div>
                    </div>
                    <div class="right-tools">
                        <div class="tool">
                            <div class="box">
                                <i class="far fa-calendar-alt"></i>
                            </div>
                            <span>Выбор даты</span>
                        </div>
                        <div class="tool">
                            <div class="box">
                                <i class="fas fa-chart-pie"></i>
                            </div>
                            <span>Выбор КНО</span>
                        </div>
                        <div class="tool">
                            <div class="box">
                                <i class="fas fa-chart-pie"></i>
                            </div>
                            <span>Выбор КТО</span>
                        </div>
                    </div>
                </div>
                <div class="main">
                    <div class="layers"  @contextmenu="openMenuLayers">
                        <div class="form-group has-search m-0">
                            <span class="fa fa-search form-control-feedback"></span>
                            <input type="text" class="form-control" placeholder="Поиск">
                        </div>
                        <div class="layers-info" @click="showFiles">
                            <i id="arrow" class="fas fa-caret-right ml-2"></i>
                            <i class="fas fa-vector-square ml-2"></i>
                            <span class="ml-2">Info</span>
                        </div>
                        <div id="files" class="files">
                            <template v-for="file in files">
                                <div class="single-file">
                                    <i class="fas fa-file"></i>
                                    <span class="ml-2 text-white">File</span>
                                </div>
                            </template>

                        </div>
                    </div>
                    <div class="main-map" @contextmenu="openMenu">
                        <i data-toggle="modal" data-target="#exampleModal7" class="fas fa-th-large"></i>
                        <div :style="gridStyle" class="card-list">
                            <div v-for="(card, index) in cards" class="card-item">
                                <div :style="[cards.length === 1 ? {'height': '100vh'} : {'height': '350px'}]" :class="{ disabled: loading,  }" :id="'map'+index" :key="index" class="map-ol"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Map from "ol/Map";
    import View from "ol/View";
    import { defaults as defaultControls, ScaleLine } from "ol/control";
    import {Tile as TileLayer, Vector as VectorLayer} from 'ol/layer';
    import {OSM, Vector as VectorSource} from 'ol/source';
    import Stamen from 'ol/source/Stamen';
    import {Fill, Stroke, Style } from 'ol/style';
    import Text from 'ol/style/Text';
    import Feature from 'ol/Feature';
    import Point from 'ol/geom/Point';
    import Select from 'ol/interaction/Select';
    import Chart from 'ol-ext/style/Chart'
     export default {
        data() {
            return {
                files: [],
                viewMenu: false,
                viewMenuLayers: false,
                rightLayers: false,
                rightMap: false,
                top: '0px',
                left: '0px',
                windHeight: window.innerHeight,
                windWidth: window.innerWidth,
                date1: null,
                cards: [1],
                numberOfColumns: 1,
                loading: false
            }
        },
        computed: {
            gridStyle() {
                return {
                    gridTemplateColumns: `repeat(${this.numberOfColumns}, minmax(200px, 1fr))`
                }
            },
        },
        async mounted() {
            await this.initiateMap();
        },
        methods: {
            initiateMap() {
                let layer = new TileLayer({ source: new Stamen({ layer: 'watercolor' }) });

                // The map
                let map = new Map({
                    target: 'map0',
                    view: new View({
                        zoom: 6,
                        center: [166326, 5992663]
                    }),
                    layers: [layer]
                });

                // Style function
                let styleCache={};

                function getFeatureStyle (feature, sel) {
                    let k = $("#graph").val()+"-"+ $("#color").val()+"-"+(sel?"1-":"")+feature.get("data");
                    let style = styleCache[k];
                    if (!style) {
                        let radius = 15;
                        // area proportional to data size: s=PI*r^2
                        radius = 8* Math.sqrt (feature.get("sum") / Math.PI);
                        let data = feature.get("data");
                        radius *= (sel?1.2:1);
                        // Create chart style

                        style = [ new Style({
                            image: new Chart  ({
                                type: "pie",
                                radius: radius,
                                data: data,
                                rotateWithView: true,
                                stroke: new Stroke({
                                    color: "#fff",
                                    width: 2
                                }),
                            })
                        })];

                        // Show values on select
                        if (sel){
                            console.log(sel)
                            let sum = feature.get("sum");

                            let s = 0;
                            for (let i=0; i<data.length; i++) {
                                let d = data[i];
                                let a = (2*s+d)/sum * Math.PI - Math.PI/2;
                                let v = Math.round(d/sum*1000);
                                if (v>0) {
                                    style.push(new Style({
                                        text: new Text({
                                            text: (v/10)+"%", /* d.toString() */
                                            offsetX: Math.cos(a)*(radius+3),
                                            offsetY: Math.sin(a)*(radius+3),
                                            textAlign: (a < Math.PI/2 ? "left":"right"),
                                            textBaseline: "middle",
                                            stroke: new Stroke({ color:"#fff", width:2.5 }),
                                            fill: new Fill({color:"#333"})
                                        })
                                    }));
                                }
                                s += d;
                            }
                        }
                    }
                    styleCache[k] = style;
                    return style;
                }

                // 30 random features with data: array of 4 values
                let ext = map.getView().calculateExtent(map.getSize());
                let features=[];
                for (let i=0; i<30; ++i){
                    let n, nb=0, data=[];
                    for (let k=0; k<4; k++) {
                        n = Math.round(8*Math.random());
                        data.push(n);
                        nb += n;
                    }
                    features[i] = new Feature({
                        geometry: new Point([ext[0]+(ext[2]-ext[0])*Math.random(), ext[1]+(ext[3]-ext[1])*Math.random()]),
                        data: data,
                        sum: nb
                    });
                }

                let vector = new VectorLayer({
                    name: 'Vecteur',
                    source: new VectorSource({ features: features }),
                    // y ordering
                    // renderOrder: ordering.yOrdering(),
                    style: function(f) { return getFeatureStyle(f); }
                })

                map.addLayer(vector);

                // Control Select
                let select = new Select({
                    style: function(f) { return getFeatureStyle(f, true); }
                });
                map.addInteraction(select);
            },
            async  initiateMap2() {
                if(this.loading) {
                    return
                }
                this.loading = true;
                let layer = new TileLayer({ source: new Stamen({ layer: 'watercolor' }) });

                // The map
                let map = new Map({
                    target: 'map1',
                    view: await new View({
                        zoom: 6,
                        center: [166326, 5992663]
                    }),
                    layers: [layer]
                });

                // Style function
                let styleCache={};

                function getFeatureStyle (feature, sel) {
                    let k = $("#graph").val()+"-"+ $("#color").val()+"-"+(sel?"1-":"")+feature.get("data");
                    let style = styleCache[k];
                    if (!style) {
                        let radius = 15;
                        // area proportional to data size: s=PI*r^2
                        radius = 8* Math.sqrt (feature.get("sum") / Math.PI);
                        let data = feature.get("data");
                        radius *= (sel?1.2:1);
                        // Create chart style

                        style = [ new Style({
                            image: new Chart  ({
                                type: "pie",
                                radius: radius,
                                data: data,
                                rotateWithView: true,
                                stroke: new Stroke({
                                    color: "#fff",
                                    width: 2
                                }),
                            })
                        })];

                        // Show values on select
                        if (sel){
                            console.log(sel)
                            let sum = feature.get("sum");

                            let s = 0;
                            for (let i=0; i<data.length; i++) {
                                let d = data[i];
                                let a = (2*s+d)/sum * Math.PI - Math.PI/2;
                                let v = Math.round(d/sum*1000);
                                if (v>0) {
                                    style.push(new Style({
                                        text: new Text({
                                            text: (v/10)+"%", /* d.toString() */
                                            offsetX: Math.cos(a)*(radius+3),
                                            offsetY: Math.sin(a)*(radius+3),
                                            textAlign: (a < Math.PI/2 ? "left":"right"),
                                            textBaseline: "middle",
                                            stroke: new Stroke({ color:"#fff", width:2.5 }),
                                            fill: new Fill({color:"#333"})
                                        })
                                    }));
                                }
                                s += d;
                            }
                        }
                    }
                    styleCache[k] = style;
                    return style;
                }

                // 30 random features with data: array of 4 values
                let ext = map.getView().calculateExtent(map.getSize());
                let features=[];
                for (let i=0; i<30; ++i){
                    let n, nb=0, data=[];
                    for (let k=0; k<4; k++) {
                        n = Math.round(8*Math.random());
                        data.push(n);
                        nb += n;
                    }
                    features[i] = new Feature({
                        geometry: new Point([ext[0]+(ext[2]-ext[0])*Math.random(), ext[1]+(ext[3]-ext[1])*Math.random()]),
                        data: data,
                        sum: nb
                    });
                }

                let vector = new VectorLayer({
                    name: 'Vecteur',
                    source: new VectorSource({ features: features }),
                    // y ordering
                    // renderOrder: ordering.yOrdering(),
                    style: function(f) { return getFeatureStyle(f); }
                })

                map.addLayer(vector);

                // Control Select
                let select = new Select({
                    style: function(f) { return getFeatureStyle(f, true); }
                });
                map.addInteraction(select);

                this.loading = false;
            },
            async  initiateMap3() {
                if(this.loading) {
                    return
                }
                this.loading = true;
                let layer = new TileLayer({ source: new Stamen({ layer: 'watercolor' }) });

                // The map
                let map = new Map({
                    target: 'map2',
                    view: await new View({
                        zoom: 6,
                        center: [166326, 5992663]
                    }),
                    layers: [layer]
                });

                // Style function
                let styleCache={};

                function getFeatureStyle (feature, sel) {
                    let k = $("#graph").val()+"-"+ $("#color").val()+"-"+(sel?"1-":"")+feature.get("data");
                    let style = styleCache[k];
                    if (!style) {
                        let radius = 15;
                        // area proportional to data size: s=PI*r^2
                        radius = 8* Math.sqrt (feature.get("sum") / Math.PI);
                        let data = feature.get("data");
                        radius *= (sel?1.2:1);
                        // Create chart style

                        style = [ new Style({
                            image: new Chart  ({
                                type: "pie",
                                radius: radius,
                                data: data,
                                rotateWithView: true,
                                stroke: new Stroke({
                                    color: "#fff",
                                    width: 2
                                }),
                            })
                        })];

                        // Show values on select
                        if (sel){
                            console.log(sel)
                            let sum = feature.get("sum");

                            let s = 0;
                            for (let i=0; i<data.length; i++) {
                                let d = data[i];
                                let a = (2*s+d)/sum * Math.PI - Math.PI/2;
                                let v = Math.round(d/sum*1000);
                                if (v>0) {
                                    style.push(new Style({
                                        text: new Text({
                                            text: (v/10)+"%", /* d.toString() */
                                            offsetX: Math.cos(a)*(radius+3),
                                            offsetY: Math.sin(a)*(radius+3),
                                            textAlign: (a < Math.PI/2 ? "left":"right"),
                                            textBaseline: "middle",
                                            stroke: new Stroke({ color:"#fff", width:2.5 }),
                                            fill: new Fill({color:"#333"})
                                        })
                                    }));
                                }
                                s += d;
                            }
                        }
                    }
                    styleCache[k] = style;
                    return style;
                }

                // 30 random features with data: array of 4 values
                let ext = map.getView().calculateExtent(map.getSize());
                let features=[];
                for (let i=0; i<30; ++i){
                    let n, nb=0, data=[];
                    for (let k=0; k<4; k++) {
                        n = Math.round(8*Math.random());
                        data.push(n);
                        nb += n;
                    }
                    features[i] = new Feature({
                        geometry: new Point([ext[0]+(ext[2]-ext[0])*Math.random(), ext[1]+(ext[3]-ext[1])*Math.random()]),
                        data: data,
                        sum: nb
                    });
                }

                let vector = new VectorLayer({
                    name: 'Vecteur',
                    source: new VectorSource({ features: features }),
                    // y ordering
                    // renderOrder: ordering.yOrdering(),
                    style: function(f) { return getFeatureStyle(f); }
                })

                map.addLayer(vector);

                // Control Select
                let select = new Select({
                    style: function(f) { return getFeatureStyle(f, true); }
                });
                map.addInteraction(select);

                this.loading = false;
            },
            async  initiateMap4() {
                if(this.loading) {
                    return
                }
                this.loading = true;
                let layer = new TileLayer({ source: new Stamen({ layer: 'watercolor' }) });

                // The map
                let map = new Map({
                    target: 'map3',
                    view: await new View({
                        zoom: 6,
                        center: [166326, 5992663]
                    }),
                    layers: [layer]
                });

                // Style function
                let styleCache={};

                function getFeatureStyle (feature, sel) {
                    let k = $("#graph").val()+"-"+ $("#color").val()+"-"+(sel?"1-":"")+feature.get("data");
                    let style = styleCache[k];
                    if (!style) {
                        let radius = 15;
                        // area proportional to data size: s=PI*r^2
                        radius = 8* Math.sqrt (feature.get("sum") / Math.PI);
                        let data = feature.get("data");
                        radius *= (sel?1.2:1);
                        // Create chart style

                        style = [ new Style({
                            image: new Chart  ({
                                type: "pie",
                                radius: radius,
                                data: data,
                                rotateWithView: true,
                                stroke: new Stroke({
                                    color: "#fff",
                                    width: 2
                                }),
                            })
                        })];

                        // Show values on select
                        if (sel){
                            console.log(sel)
                            let sum = feature.get("sum");

                            let s = 0;
                            for (let i=0; i<data.length; i++) {
                                let d = data[i];
                                let a = (2*s+d)/sum * Math.PI - Math.PI/2;
                                let v = Math.round(d/sum*1000);
                                if (v>0) {
                                    style.push(new Style({
                                        text: new Text({
                                            text: (v/10)+"%", /* d.toString() */
                                            offsetX: Math.cos(a)*(radius+3),
                                            offsetY: Math.sin(a)*(radius+3),
                                            textAlign: (a < Math.PI/2 ? "left":"right"),
                                            textBaseline: "middle",
                                            stroke: new Stroke({ color:"#fff", width:2.5 }),
                                            fill: new Fill({color:"#333"})
                                        })
                                    }));
                                }
                                s += d;
                            }
                        }
                    }
                    styleCache[k] = style;
                    return style;
                }

                // 30 random features with data: array of 4 values
                let ext = map.getView().calculateExtent(map.getSize());
                let features=[];
                for (let i=0; i<30; ++i){
                    let n, nb=0, data=[];
                    for (let k=0; k<4; k++) {
                        n = Math.round(8*Math.random());
                        data.push(n);
                        nb += n;
                    }
                    features[i] = new Feature({
                        geometry: new Point([ext[0]+(ext[2]-ext[0])*Math.random(), ext[1]+(ext[3]-ext[1])*Math.random()]),
                        data: data,
                        sum: nb
                    });
                }

                let vector = new VectorLayer({
                    name: 'Vecteur',
                    source: new VectorSource({ features: features }),
                    // y ordering
                    // renderOrder: ordering.yOrdering(),
                    style: function(f) { return getFeatureStyle(f); }
                })

                map.addLayer(vector);

                // Control Select
                let select = new Select({
                    style: function(f) { return getFeatureStyle(f, true); }
                });
                map.addInteraction(select);

                this.loading = false;
            },
            oneSquare() {
                // this.numberOfColumns = 1;
                this.cards = [1];
            },
            twoSquare() {
                // event.preventDefault();

                if (this.cards.length === 1) {
                    this.cards = [1, 2];
                    this.initiateMap2();
                }
                else {
                    this.cards = [1, 2];
                }

            },
            threeSquare() {
                if (this.cards.length === 1) {
                    this.initiateMap2().then(()=>{
                        this.initiateMap3()
                    });
                }
                if (this.cards.length === 2) {
                    this.initiateMap3();
                }
                else {
                    this.cards = [1, 2, 3];
                }
                this.cards = [1, 2, 3];
            },
            fourSquare() {
                if (this.cards.length === 1) {
                    this.initiateMap2().then(()=>{
                        this.initiateMap3().then(()=>{
                            this.initiateMap4();
                        })
                    });
                }
                if (this.cards.length === 2) {
                    this.initiateMap3().then(()=>{
                        this.initiateMap4();
                    })
                }
                if (this.cards.length === 3) {
                        this.initiateMap4();
                }
                else {
                    this.cards = [1, 2, 3, 4];
                }
                this.cards = [1, 2, 3, 4];
            },
            setMenu(top, left) {
               let largestHeight = this.windHeight - this.$refs.right.offsetHeight - 25;
               let largestWidth = this.windWidth - this.$refs.right.offsetWidth - 25;

                if (top > largestHeight) top = largestHeight;

                if (left > largestWidth) left = largestWidth;

                this.top = `${top}px`;
                this.left = `${left}px`;
            },
            setMenuLayers(top, left) {
                let largestHeight = this.windHeight - this.$refs.rightLayers.offsetHeight - 25;
                let largestWidth = this.windWidth - this.$refs.rightLayers.offsetWidth - 25;

                if (top > largestHeight) top = largestHeight;

                if (left > largestWidth) left = largestWidth;

                this.top = `${top}px`;
                this.left = `${left}px`;
            },

            closeMenu() {
                this.viewMenu = false;
            },
            closeMenuLayers() {
                this.viewMenuLayers = false;
            },
            openMenu(e) {
                this.viewMenu = true;
                Vue.nextTick(() => {
                    this.$refs.right.focus();
                    this.setMenu(e.y, e.x);
                });
                e.preventDefault();
            },
            openMenuLayers(e) {
                this.viewMenuLayers = true;
                Vue.nextTick(() => {
                    this.$refs.rightLayers.focus();
                    this.setMenuLayers(e.y, e.x);
                });
                e.preventDefault();
            },
            openRightLayers(){
              this.rightLayers = !this.rightLayers;
            },
            openRightMap(){
                this.rightMap = !this.rightMap;
            },
            showModal() {
                this.$refs['my-modal'].show()
            },
            hideModal() {
                this.$refs['my-modal'].hide()
            },
            showFiles() {
                let more = document.getElementById(`files`);
                let arrow = document.getElementById(`arrow`);
                if (more.style.display === "block") {
                    more.style.display = "none";
                    arrow.classList.remove('rotate90')
                } else {
                    more.style.display = "block";
                    arrow.classList.add('rotate90')
                }
            },
            addFile(){
                this.files += 1;
                if (this.files === 1) {
                    this.showFiles();
                }
            },
        }
    }
</script>
