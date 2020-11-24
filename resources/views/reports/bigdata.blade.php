@extends('layouts.app')
@section('content')
    <div class="col p-4" id="app">
        <h2 class="subtitle">Big data</h2>
        <div class="bg-dark">
            <button  type="button" class="btn report-btn">Отчеты</button>
            <button disabled onclick="document.location='{{url('/')}}/ru/mzdn'" type="button" class="btn report-btn">Ввод данных</button>
            <button disabled onclick="document.location='{{url('/')}}/ru/mzdn'" type="button" class="btn report-btn">Конструктор отчётов</button>
            <button disabled onclick="document.location='{{url('/')}}/ru/gtm'" type="button" class="btn report-btn">Анализ эффективности ГТМ</button>
            </div>
           <div class="level1-content row">       
             
            <div class="col-md-12 col-lg-12" style="padding: 10px;">
            </div>

<div class="col-md-12 col-lg-12 row" >
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
</style>


