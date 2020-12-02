@extends('layouts.app')
@section('content')
<div class=" p-4" id="app">
        <!-- <h2 class="subtitle">Big data</h2> -->
    <div class="">
        <div class="row">
            <div class="col-10">
                <div class="bg-dark">
                        <!-- <button  type="button" class="btn report-btn">Отчеты</button>
                        <button disabled onclick="document.location='{{url('/')}}/ru/mzdn'" type="button" class="btn report-btn">Ввод данных</button>
                        <button disabled onclick="document.location='{{url('/')}}/ru/mzdn'" type="button" class="btn report-btn">Конструктор отчётов</button>      -->
                        <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                                <span class="input-group-text" style="font-size: 14px;">Поиск</span>
                            </div>
                            <input type="text" class="form-control fix-rounded-right" required>
                            <div class="invalid-feedback">
                                No data.
                            </div>
                        </div>
                </div>
                <div class="level1-content row">       
                    <div class="col-md-12 col-lg-12" style="padding: 10px;">
                    </div>
                    <div class="center-content">
                        <div class="col-md-12 row">
                            <div class="col btn-clk">
                                <div class="btn-blocks">
                                    <svg  style="height:180;" width="40" height="38" viewBox="0 0 40 38"  xmlns="http://www.w3.org/2000/svg">
                                        <path  fill-rule="evenodd" clip-rule="evenodd" d="M20.0007 30.0735L32.3607 37.4194L29.0808 23.5739L40 14.258L25.6199 13.0578L20.0007 0L14.3794 13.0578L0 14.258L10.9192 23.5739L7.64 37.4194L20.0007 30.0735Z" />
                                    </svg>
                                </div>
                                <div class="col-md-12 btn-blocks-txt">Избранное</div>
                            </div>
                            <div class="col btn-clk">
                                <div class="btn-blocks">
                                    <svg style="height:180;" width="40" height="33" viewBox="0 0 40 33"  xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0 32.7037L39.987 32.7273L40 15.4461C37.343 15.6576 33.9012 15.4922 31.1638 15.478C29.1134 15.4679 29.07 15.6333 28.6808 17.4077C28.3698 18.8216 27.6436 18.2098 27.5545 20.6766C27.4262 24.2433 25.3607 26.4406 23.0124 29.1725C21.5905 30.8269 18.5943 31.0139 16.9006 29.07C14.4415 26.2501 12.5607 24.2155 12.4129 20.5212C12.3194 18.219 11.5562 18.725 11.2801 17.2668C10.9453 15.4922 10.5735 15.4679 8.64924 15.4797C5.95532 15.4966 2.61347 15.6467 0 15.4487V32.7037ZM24.1592 21.326C23.7374 20.8512 16.6058 18.5623 15.9688 18.5312C16.2057 19.9239 16.2036 17.6 16.3166 21.0155C16.3623 22.4259 18.3061 23.7314 19.5911 25.8593L20.4108 25.8475C20.9043 25.0681 21.561 24.2953 22.1872 23.5234C22.5481 23.0761 22.7655 22.8294 23.1264 22.3833C23.3069 22.1582 23.4656 21.9334 23.6439 21.7791C24.1875 21.305 23.8874 21.9174 24.1592 21.326ZM15.8656 2.38026C16.6766 2.81899 21.3926 4.30911 22.9842 4.87632C23.0364 4.89555 23.4256 5.02817 23.4603 5.03232C24.2387 5.1313 24.0517 5.02904 23.9082 4.70174C23.8952 4.67246 23.8321 4.57764 23.8147 4.53744C23.5647 3.93505 23.6539 3.5835 23.6604 2.89787C23.6669 1.933 23.6539 0.968141 23.6691 0.00327739L16.3092 0C16.3635 3.04142 16.2353 1.35509 15.8656 2.38026ZM24.163 11.3341C23.0215 10.9718 16.7727 8.71218 16.0617 8.729C15.9856 9.68884 16.0117 8.73403 16.1769 9.27698L16.2596 9.50924C16.4357 10.2283 16.4205 11.3518 16.0748 11.9769C16.0617 12.0029 16.016 12.1086 16.0052 12.0842C15.9943 12.059 15.9486 12.1506 15.9312 12.1908C16.577 12.6918 23.3759 14.9897 24.063 14.8464C24.1 14.1332 23.6564 14.7885 23.6477 13.1557C23.6369 11.3317 23.9804 12.0676 24.163 11.3341ZM16.3205 6.42208C16.1856 7.62445 16.2596 6.26608 15.8813 7.22264C16.3422 7.70507 23.1085 9.92998 24.0695 10.039L23.8239 9.48032C23.8086 9.43837 23.7869 9.40145 23.7695 9.35709L23.6499 8.18401C23.6456 6.51603 23.7891 7.21412 24.1522 6.58246C23.7173 6.13935 16.8271 3.84212 15.9639 3.82617C16.2052 5.11921 16.3226 3.08199 16.3205 6.42208ZM24.1235 16.3597C23.5364 15.9257 16.7658 13.6646 16.0135 13.6562C16.07 14.6899 16.0809 13.6285 16.2744 14.4752C16.7049 16.3671 15.8656 17.139 15.8656 17.139C16.3396 17.4519 23.1907 19.8046 23.9974 19.88C24.0387 18.8439 24.0083 19.8103 23.8104 19.27C23.5995 18.687 23.6495 18.6466 23.6495 17.9588C23.6495 17.6206 23.6212 17.2179 23.7365 16.926C23.9278 16.4468 24.0061 16.7363 24.1235 16.3597Z" />
                                    </svg>
                                </div>
                                <div class="col-md-12 btn-blocks-txt">Бурение</div>
                            </div>
                            <div class="col btn-clk">
                                <div class="btn-blocks">
                                    <svg style="height:180;" width="40" height="43" viewBox="0 0 40 43"  xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M39.0188 36.8928H36.9765V27.8142C36.9765 27.5773 36.7529 27.382 36.48 27.382H34.1812V20.4453L34.4235 20.5326C34.5506 20.5761 34.6777 20.5997 34.8024 20.5997C35.1882 20.5997 35.56 20.398 35.7153 20.0639L37.1224 17.0868C37.2188 16.8723 37.2188 16.6345 37.1224 16.424C37.0235 16.2134 36.8259 16.0417 36.5859 15.9545L15.2306 8.20323C16.0118 6.89592 16.7129 5.56826 17.3153 4.25267C17.52 3.80886 17.2753 3.31019 16.7765 3.1286L8.34353 0.0661289C7.84235 -0.115463 7.26824 0.0897737 7.05176 0.524601C4.96235 4.81565 3.61412 9.59331 2.81412 15.566C2.76471 15.9509 3.01176 16.3205 3.41882 16.4666L7.03529 17.7803C7.44471 17.9293 7.91294 17.8203 8.18588 17.5162C9.75765 15.7729 11.1106 14.135 12.3294 12.5097L16.5929 14.0615L16.3835 15.3345L15.7482 19.1988L12.8353 36.8928H6.01412H0.988235C0.444706 36.8928 0 37.2825 0 37.7618V41.696C0 42.1718 0.444706 42.5605 0.988235 42.5605H39.0188C39.56 42.5605 40 42.1718 40 41.696V37.7618C40 37.2825 39.56 36.8928 39.0188 36.8928ZM32.203 27.3825H29.9065C29.6312 27.3825 29.4077 27.5778 29.4077 27.8147V36.8933H27.163L24.2524 19.1992L23.8406 16.6922L32.203 19.7284V27.3825ZM22.4487 21.5146L18.9781 19.2454L21.7381 17.198L22.4487 21.5146ZM21.2985 23.1264L16.8937 25.5833L17.6843 20.7676L21.2985 23.1264ZM22.9354 24.4621L23.9989 30.9041L18.2812 27.0571L22.9354 24.4621ZM18.6938 36.8918L24.3879 33.2801L24.9832 36.8918H18.6938ZM20.6367 15.5291L18.2531 17.2952L18.6602 14.8082L20.6367 15.5291ZM16.4517 28.2215L22.3764 32.2101L15.0281 36.8816L16.4517 28.2215Z" />
                                    </svg>
                                </div>
                                <div class="col-md-12 btn-blocks-txt">Разработка</div>
                            </div>
                            <div class="col btn-clk">
                                <div class="btn-blocks">
                                    <svg style="height:180;" width="40" height="43" viewBox="0 0 40 43"  xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M39.0188 36.8928H36.9765V27.8142C36.9765 27.5773 36.7529 27.382 36.48 27.382H34.1812V20.4453L34.4235 20.5326C34.5506 20.5761 34.6777 20.5997 34.8024 20.5997C35.1882 20.5997 35.56 20.398 35.7153 20.0639L37.1224 17.0868C37.2188 16.8723 37.2188 16.6345 37.1224 16.424C37.0235 16.2134 36.8259 16.0417 36.5859 15.9545L15.2306 8.20323C16.0118 6.89592 16.7129 5.56826 17.3153 4.25267C17.52 3.80886 17.2753 3.31019 16.7765 3.1286L8.34353 0.0661289C7.84235 -0.115463 7.26824 0.0897737 7.05176 0.524601C4.96235 4.81565 3.61412 9.59331 2.81412 15.566C2.76471 15.9509 3.01176 16.3205 3.41882 16.4666L7.03529 17.7803C7.44471 17.9293 7.91294 17.8203 8.18588 17.5162C9.75765 15.7729 11.1106 14.135 12.3294 12.5097L16.5929 14.0615L16.3835 15.3345L15.7482 19.1988L12.8353 36.8928H6.01412H0.988235C0.444706 36.8928 0 37.2825 0 37.7618V41.696C0 42.1718 0.444706 42.5605 0.988235 42.5605H39.0188C39.56 42.5605 40 42.1718 40 41.696V37.7618C40 37.2825 39.56 36.8928 39.0188 36.8928ZM32.203 27.3825H29.9065C29.6312 27.3825 29.4077 27.5778 29.4077 27.8147V36.8933H27.163L24.2524 19.1992L23.8406 16.6922L32.203 19.7284V27.3825ZM22.4487 21.5146L18.9781 19.2454L21.7381 17.198L22.4487 21.5146ZM21.2985 23.1264L16.8937 25.5833L17.6843 20.7676L21.2985 23.1264ZM22.9354 24.4621L23.9989 30.9041L18.2812 27.0571L22.9354 24.4621ZM18.6938 36.8918L24.3879 33.2801L24.9832 36.8918H18.6938ZM20.6367 15.5291L18.2531 17.2952L18.6602 14.8082L20.6367 15.5291ZM16.4517 28.2215L22.3764 32.2101L15.0281 36.8816L16.4517 28.2215Z" />
                                    </svg>
                                </div>
                                <div class="col-md-12 btn-blocks-txt">Добыча</div>
                            </div>
                            <div class="col btn-clk">
                                <div class="btn-blocks">
                                    <svg style="height:180;" width="40" height="35" viewBox="0 0 40 35"  xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M37.3407 9.97748C35.8726 9.97748 34.6814 11.1703 34.6814 12.6412V13.071H23.7701V9.96996C23.7701 9.55102 23.4377 9.21754 23.0194 9.21754H21.9141V5.76691H28.2825C29.8615 5.76691 31.1385 4.4714 31.1385 2.8861C31.1385 1.29579 29.8615 0 28.2825 0H11.7175C10.1413 0 8.86704 1.29579 8.86704 2.8861C8.86704 4.4714 10.1413 5.76691 11.7175 5.76691H18.0914V9.21754H16.9806C16.5679 9.21754 16.2355 9.55102 16.2355 9.96996V13.071H5.29363V12.6412C5.29363 11.1703 4.13019 9.97748 2.65928 9.97748C1.19391 9.97748 0 11.1703 0 12.6412V31.9631C0 33.4329 1.19391 34.6249 2.65928 34.6249C4.13019 34.6249 5.29363 33.4329 5.29363 31.9631V31.5325H34.6814V31.9631C34.6814 33.4329 35.8726 34.6249 37.3407 34.6249C38.8089 34.6249 40 33.4329 40 31.9631V12.6412C40 11.1703 38.8089 9.97748 37.3407 9.97748Z" />
                                    </svg>
                                </div>
                                <div class="col-md-12 btn-blocks-txt">Обустройство</div>
                            </div>
                        </div>
                        <div class="line"></div>
                        <div id="dobycha" class="col-md-12 col-lg-12 row" >
                            <button onclick="document.location='{{url('/')}}/ru/mzdn'" type="button" class="col-md-2 col-lg-2 btn report-btn">Отчёт по месячной замерной добычи нефти</button>
                            <button onclick="document.location='{{url('/')}}/ru/gtm'" type="button" class="col-md-2 col-lg-2 btn report-btn">Анализ эффективности ГТМ</button> 
                            <button disabled onclick="document.location='{{url('/')}}/ru/constructor'" type="button" class="col-md-2 col-lg-2 btn report-btn">Месячный экс рапорт</button> 
                            <button disabled onclick="document.location='{{url('/')}}/ru/constructor'" type="button" class="col-md-2 col-lg-2 btn report-btn">Расшифровка фонда скважин</button> 
                            <button disabled onclick="document.location='{{url('/')}}/ru/constructor'" type="button" class="col-md-2 col-lg-2 btn report-btn">Расшифровка фонда скважин по блокам</button> 
                            <button disabled onclick="document.location='{{url('/')}}/ru/constructor'" type="button" class="col-md-2 col-lg-2 btn report-btn">Расшифровка фонда скважин по месторождениям</button> 
                            <button disabled onclick="document.location='{{url('/')}}/ru/constructor'" type="button" class="col-md-2 col-lg-2 btn report-btn">Ревизия фонда скважин</button> 
                            <button disabled onclick="document.location='{{url('/')}}/ru/constructor'" type="button" class="col-md-2 col-lg-2 btn report-btn">Ревизия фонда скважин по месторождениям</button> 
                            <button disabled onclick="document.location='{{url('/')}}/ru/constructor'" type="button" class="col-md-2 col-lg-2 btn report-btn">Расшифровка бездействующего фонда скважин</button> 
                            <button disabled onclick="document.location='{{url('/')}}/ru/constructor'" type="button" class="col-md-2 col-lg-2 btn report-btn">Отчет по месячной замерной закаче воды</button> 
                            <button disabled onclick="document.location='{{url('/')}}/ru/constructor'" type="button" class="col-md-2 col-lg-2 btn report-btn">Ежедневная динамика показателей добычи по скважинам</button> 
                            <button disabled onclick="document.location='{{url('/')}}/ru/constructor'" type="button" class="col-md-2 col-lg-2 btn report-btn">Ежедневная динамика показателей закачки по скважинам</button>        
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-2 bg-dark">
                <div class="bg-dark" style="height: 100%;">
                    <div class="right-title">Форма отчета</div>

                </div>
            </div>
        </div>
    </div>    
</div>

@endsection
<style>
.p-4{
        background-color: #0F1430;
    }
.main{
    background-color: #0F1430;
    background-image: url({{ asset('img/level1/grid.svg') }});
    border: 1px solid #0D2B4D;
    margin-left: 0px !important;
    padding-top: 20px;
    }
.title, .subtitle {
    color:white;
    }
.top{
    display: none;
    }
    /* Change values to match the radius of your form control */
.fix-rounded-right {
  border-top-right-radius: .2rem !important;
  border-bottom-right-radius: .2rem !important;
}
.input-group, .input-group-sm{
    padding: 15px;
}
.form-control, .fix-rounded-right{
    border-top-right-radius: 20px!important;
    border-bottom-right-radius: 20px!important;
    height: 40!important;
    background: #393D75!important;
    border: none!important;
}
.input-group-text{
    padding-left: 40px!important;
    padding-right: 40px!important;
    color: white!important;
    background: #656A8A!important;
    border: none!important;
    border-radius: 20px!important;
}
.input-group-prepend{
    
    background: #393d75;
    border-top-left-radius: 20px!important;
    border-bottom-left-radius: 20px!important;

}
.right-title{
    font-size: 20px;
    padding-top: 15px;
}
.line{
    /* Line 1 */
border: 2px solid #333975;
transform: rotate(180deg);
margin-top: 50px;
margin-bottom: 50px;
}
.center-content{
    background:#272953;
}
.btn-blocks{
    background: #1F2142;
    fill:#393D75!important;
    margin: 25px;
    text-align: center;
    height: 180px;
    border-radius: 20px;
    margin-bottom: 10px;
}
.btn-blocks:hover{
    background: #334296;
    fill:#FEFEFE!important;
}
.btn-blocks-icon{
    fill: #393D75;
}
.btn-blocks-icon:hover{
    fill: #FEFEFE;
}

.btn-blocks-txt{
    text-align: center;
    font-size: 20px;
}
.btn-clk{
    cursor: pointer;
}
</style>


