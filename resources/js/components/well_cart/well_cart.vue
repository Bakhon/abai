<template>
  <div class="row">

        <div class="col-md-3">
                <div class="bg-dark">
                    <div class="row">
                        <div class="col">
                        <div class="well-deal">
                            <div class="icon-ierarchy"></div>
                            <h2>Дело скважины</h2>
                         </div>
                     </div>

                        <div class="directory">
                            <div class="row">
                                <div class="col">
                                    <img src="/img/bd/pointer-solid.svg" class="pointer">
                                    <div class="border-pointer-solid"></div>
                                    <img src="/img/bd/folder.svg" class="full-size-icon">
                                        <h3>КПД Заместителя председателя Правления по розведке и добыче
                                        <span class="names">(Марабаев Ж. Н.)</span>
                                    </h3>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="file">
                                        <img src="/img/bd/file.svg" class="full-size-icon">
                                        <h3>Прирост извлекаемых запасов нефти и конденсата</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                    <div class="row">
                        <div class="col">
                            <div class="heading">
                                <p>Поиск скважины</p>                                
                            </div>           
                            <div class="sheare-icon"></div>     
                        </div>
                    </div>
                <div class="row">
                    <div class="col">
                        <form class="search-form">
                            <input type="text" placeholder="Номер скважины" class="search-input">
                        </form>
                    </div>
                </div>
            </div>
         </div>

        <div class="col-md-3">
                <div class="bg-dark">
                    <div class="row">
                        <div class="col">
                            <div class="heading">
                                <p>Паспорт скважины</p>                                
                            </div>           
                            <div class="sheare-icon"></div>   
                        </div>
                    </div>
                    <div class="col">
                        <div class="row">
                            <div class="icon-all pointer-large-icon">
                                <img src="/img/bd/pointer-large.svg">
                            </div>
                            <div class="file-icon-large">
                            </div>
                            <div class="icon-all pointer-large-icon"><img src="/img/bd/pointer-large.svg"></div>
                        </div>
                    </div>
                </div>
         </div>       
    </div>
</template>




<style scoped lang="scss">
    .well-deal{
        width: 100%;
        display: flex;
        padding: 10px 25px;
        h2{
            font-size: 20px;
            line-height: 24px;
            margin: 0px;
            padding: 10px 5px;
        }
        .icon-ierarchy{
            width: 10px;
            height: 100%;
            background: url(/img/bd/ierarhy.svg) 50% 50% no-repeat;
            padding: 0 15px 0 10px;
        }
    }
    .directory{
        display:block;
        border-top: 1px solid #555BA6;
        width: 100%;
        padding: 10px;
        margin: 10px 40px 10px 25px;
        col{
            display:flex;
        }
        h3{
            font-size: 14px;
            font-weight: 700;
            line-height: 17px;
        }
        .names{
                color: #999DC0;
        }
        .icon-directory{
            width: 10px;
            height: 100%;
            background: url(/img/bd/folder.svg) no-repeat;
            padding: 0 15px 0 10px;
        }
        .border-pointer-solid{
            width: 10px;
            height: 100%;
            padding: 0 15px 0 10px;
            margin-top: 2px;
            border-top: 1px dashed #555BA6;
            border-left: 1px dashed #555BA6;
            border-bottom: 1px dashed #555BA6;
        }
        .pointer{
            position: absolute;
            width: 10px;
            margin-bottom: auto;
            }
        .file{
            padding-left: 35px;
            display: flex;
        }
    }
    .search-form{
        width: 100%;
        padding: 5px 10px;
        .search-input{
        background: url("/img/bd/search.svg");
        background-color: #272953;
        border: 1px solid #272953;
        background-size: contain;
        background-repeat: no-repeat;
        text-indent: 20px;
        width: 100%;
        &::placeholder{
            color:white;
            font-family: Roboto;
            font-size: 14px;
        }
    }
    }
    .heading{
        font-family: Roboto;
        color: white;
        font-size: 16px;
        line-height: 18px;
        font-weight: 700;
        display: flex;
        padding: 5px 10px;
        p{
            margin: 0px;
        }
    }
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
        &:focus{
            color:white;
            background: #20274f;
        }
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
    .file-icon{
        background: url(/img/bd/file.svg) 50% 50% no-repeat;
    }
    .pointer-large-icon{
        margin-top: auto;
        margin-bottom: auto;
     //   background: url(/img/bd/pointer-large.svg) 50% 50% no-repeat;
    }
    .file-icon-large{
        margin-left: 35px;
        margin-right: 35px;
        background: url(/img/bd/file-large.svg) no-repeat;
        height: 150px;
        width: 120px;

    }
    .full-size-icon{
        width: 20px;
        margin-bottom: auto;
        padding-right: 5px;
    }
    .icon-all{
        float: left;
        height: 20px;
        width: 20px;
        border-radius: 15px;
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

    .col{
        display: flex;
    }
    .sheare-icon{
        background: url("/img/bd/share.svg") no-repeat;
        width: 10px;
        padding: 10px;
        margin-left: auto;
        margin-top: auto;
        margin-bottom: auto;
    }
    .bg-dark{
        padding-bottom: 20px;
    }
</style>