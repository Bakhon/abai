<template>
  <div class="row">

        <div class="col-md-3">
                <div class="bg-dark">
                <h1>Дело скважины</h1>
                </div>
         </div>

    <div class="col-md-4 bg-dark">
        <div class="row">
            <div class="col">
            <select class ="transparent-select" id="">
                <option>Дело скважины</option>
                <option>Option 2</option>
            </select>
            </div>
        </div>
            <div class="col">
                <div class="row">
                    <div class="dropdown small-select">
                            <button class="btn btn-secondary select-button" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="button1-vc-inner">
                                        <div class="icon-all dropdown-icon-1"> </div>
                                        <div class="txt5">Фонд <div class="icon-pointer"> </div>
                                        </div>
                                        
                                </div>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div>

                    <div class="dropdown small-select">
                            <button class="btn btn-secondary select-button" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="button1-vc-inner">
                                        <div class="icon-all dropdown-icon-2"> </div>
                                        <div class="txt5">График замеров <div class="icon-pointer"></div></div>
                                </div>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div>
                    <div class="dropdown small-select">
                            <button class="btn btn-secondary select-button" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="button1-vc-inner">
                                        <div class="icon-all dropdown-icon-3"> </div>
                                        <div class="txt5">Эксплуатационные показатели <div class="icon-pointer"></div></div>
                                </div>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div>
             </div>
            </div>
    </div>
        <div class="col-md-2">
                <div class="bg-dark">
                <h1>Поиск скважины</h1>
                </div>
         </div>

        <div class="col-md-3">
                <div class="bg-dark">
                <h1>Паспорт скважины</h1>
                </div>
         </div>
    </div>
</template>
<style scoped lang="scss">
    .txt5{
        display: flex;
        padding-left: 5px;
        font-size: 12px;
    }
    .dropdown{
        position:relative;
    }
    .small-select{
        margin-right: 0.25em;
    }
    .transparent-select{
        padding: 10px 0;
        color: white;
        background: none;
        border: none;
    }
    .dropdown-icon-1{
        background: white url(/img/bd/fond.svg) 50% 50% no-repeat;
    }
    .dropdown-icon-2{
        background: white url(/img/bd/donat-chart.svg) 50% 50% no-repeat;
    }
    .dropdown-icon-3{
        background: white url(/img/bd/chart.svg) 50% 50% no-repeat;
    }
    .icon-all{
        float: left;
        height: 20px;
        width: 20px;
        border-radius: 15px;
        //margin-left: -30px;
    }
    .button1-vc-inner{
        display: inline-block;
    }
    .btn:not(:disabled):not(.disabled){
        width: 100%;
    }
    .select-button{
    background: #656A8A;
    width: 100%;
    overflow: hidden;
    border-radius: 10px;
    cursor: pointer;
    }
    .icon-pointer{
        margin-left: 10px;
        width: 10px;
        height: 10px;
        white-space: nowrap;
        background:url(/img/bd/pointer.svg) 50% 100% no-repeat;
    }
    .dropdown-toggle{
        white-space: initial;
    }
    .dropdown-toggle::after{
        float: right;
        content: none url(/img/bd/pointer.svg) 50% 50% no-repeat;
    }
    .col{
        display: flex;
    }
</style>