<template>
<div>
  <div class="container">  
    <div class="row">

 <div class="col-sm">
        <div class="form-group">
          <label class="text-wrap" style="color:white;" for="companySelect">Выберите компанию</label>
          <select
            style="background-color:#20274e;border-color:#20274e;color:white;"
            class="form-control"
            id="companySelect"
            @change="onChangeDzo($event)"
          >
           <option>Выберите компанию</option>
            <option value="АО ОМГ">АО 'Озенмунайгаз'</option>
            <option value="КБМ">АО 'Каражанбасмунай'</option>
            <option value="АО ЭМГ">АО 'Эмбамунайгаз'</option>
            <option value="ММГ">МАНГИСТАУМУНАЙГАЗ</option>
          </select>
        </div>
    </div>

      <div class="col-sm">
        <div class="form-group">
          <label class="text-wrap" style="color:white;" for="companySelect">НГДУ</label>
          <select
            style="background-color:#20274e;border-color:#20274e;color:white;"
            class="form-control"
            id="companySelect"
            @change="onChangeNgdu($event)"
          >
           <option>НГДУ</option>
            <option value="НГДУ-1">НГДУ-1 </option>
            <option value="НГДУ-2">НГДУ-2 </option>
            <option value="НГДУ-3">НГДУ-3 </option>
            <option value="НГДУ-4">НГДУ-4 </option>
            <option value="НГДУ-Жылыоймунайгаз">НГДУ-Жылыоймунайгаз	</option>
            <option value="НГДУ-Жайкмунайгаз">НГДУ-Жайкмунайгаз	</option>
            <option value="НГДУ-Доссормунайгаз">НГДУ-Доссормунайгаз	</option>
            <option value="ПУ-ЖЕТЫБАЙМУНАЙГАЗ">ПУ-ЖЕТЫБАЙМУНАЙГАЗ	</option>
            <option value="НГДУ-Кайнармунайгаз">НГДУ-Кайнармунайгаз	</option>
            <option value="Цех-1">Цех-1	</option>
            <option value="Цех-2">Цех-2	</option>
          </select>
        </div>
    </div>

     <div class="col-sm">
        <div class="form-group">
          <label class="text-wrap" style="color:white;" for="companySelect">БЛОК</label>
          <select
            style="background-color:#20274e;border-color:#20274e;color:white;"
            class="form-control"
            id="companySelect"
            @change="onChangeBlock($event)"
          >
           <option>Блок</option>
            <option value="HUM">HUM</option>
            <option value="PARS">PARS</option>
            <option value="SZ">SZ</option>
            <option value="Восточный Парсмурун">Восточный Парсмурун</option>
            <option value="Восточный кар">Восточный кар</option>
            <option value="Западная переклиналь">Западная переклиналь</option>
            <option value="Западный Кар">Западный Кар</option>
          </select>
        </div>
    </div>

    <div class="col-sm">
        <div class="form-group">
          <label class="text-wrap" style="color:white;" for="companySelect">Горизонт</label>
          <select
            style="background-color:#20274e;border-color:#20274e;color:white;"
            class="form-control"
            id="companySelect"
            @change="onChangeHorizon($event)"
          >
           <option value=''> Горизонт </option>
            <option value="13">13</option>
            <option value="14">14</option>
            <option value="15">15</option>
            <option value="16">16</option>
            <option value="17">17</option>
            <option value="18">18</option>
            <option value="19">19</option>
            <option value="20">20</option>
            <option value="21">21</option>
            <option value="22">22</option>
            <option value="23">23</option>
            <option value="24">24</option>
            <option value="25">25</option>
                
          </select>
        </div>
    </div>

<div class="col-sm">
        <div class="form-group">
          <label class="text-wrap" style="color:white;" for="companySelect">ЦДНГ</label>
          <select
            style="background-color:#20274e;border-color:#20274e;color:white;"
            class="form-control"
            id="companySelect"
            @change="onChangeCGDN($event)"
          >
           <option value=''> ЦДНГ </option>
            <option value="ЦДНГ-1">ЦДНГ-1</option>
            <option value="ЦДНГ-2">ЦДНГ-2</option>
            <option value="ЦДНГ-3">ЦДНГ-3</option>
            <option value="ЦДНГ-4">ЦДНГ-4</option>
            <option value="ЦДНГ-5">ЦДНГ-5</option>
            <option value="ЦДНГ-6">ЦДНГ-6</option>
            <option value="ЦДНГ-7">ЦДНГ-7</option>
            <option value="ЦДНГ-8">ЦДНГ-8</option>
            <option value="ЦДНГ-9">ЦДНГ-9</option>
            <option value="ЦДНГ-10">ЦДНГ-10</option>
            <option value="ЦДНГ-11">ЦДНГ-11</option>
            <option value="ЦДНГ-12">ЦДНГ-12</option>
            <option value="ЦДНГ-13">ЦДНГ-13</option>
            <option value="НГДУ-Жылыоймунайгаз	">НГДУ-Жылыоймунайгаз</option>
                
          </select>
        </div>
    </div>

<div class="col-sm">
        <div class="form-group">
          <label class="text-wrap" style="color:white;" for="companySelect">ЗУ</label>
          <select
            style="background-color:#20274e;border-color:#20274e;color:white;"
            class="form-control"
            id="companySelect"
            @change="onChangeZU($event)"
          >
            <option value=''> ЗУ </option>
            <option value="СП-76">СП-76</option>
            <option value="ЗУ-62б">ЗУ-62б</option>
            <option value="ЗУ-100">ЗУ-100</option>
            <option value="ЗУ-100а">ЗУ-100а</option>
            <option value="ЗУ-100б">ЗУ-100б</option>
            <option value="ЗУ-100в">ЗУ-100в</option>
            <option value="ЗУ-100г">ЗУ-100г</option>
            <option value="ЗУ-101а">ЗУ-101а</option>
            <option value="ЗУ-101б">ЗУ-101б</option>
            <option value="ЗУ-101в">ЗУ-101в</option>
            <option value="ЗУ-102а">ЗУ-102а</option>
            <option value="ЗУ-102б">ЗУ-102б</option>
            <option value="ЗУ-102в">ЗУ-102в</option>
            <option value="ЗУ-102г">ЗУ-102г</option>
            <option value="ЗУ-102д">ЗУ-102д</option>
            <option value="ЗУ-102е">ЗУ-102е</option>
            <option value="ЗУ-102ж">ЗУ-102ж</option>
            <option value="ЗУ-103">ЗУ-103</option>
            <option value="ЗУ-103а">ЗУ-103а</option>
            <option value="ЗУ-103б">ЗУ-103б</option>
            <option value="ЗУ-103в">ЗУ-103в</option>
            <option value="ЗУ-103г">ЗУ-103г</option>
            <option value="ЗУ-103д">ЗУ-103д</option>
            <option value="ЗУ-104а">ЗУ-104а</option>
            <option value="ЗУ-105">ЗУ-105</option>
            <option value="ЗУ-105а">ЗУ-105а</option>
            <option value="ЗУ-105б">ЗУ-105б</option>
            <option value="ЗУ-107а">ЗУ-107а</option>
            <option value="ЗУ-107б">ЗУ-107б</option>
            <option value="ЗУ-107в">ЗУ-107в</option>
            <option value="ЗУ-107г">ЗУ-107г</option>
            <option value="ЗУ-107д">ЗУ-107д</option>
            <option value="ЗУ-107е">ЗУ-107е</option>
            <option value="ЗУ-109">ЗУ-109</option>
            <option value="ЗУ-109а">ЗУ-109а</option>
            <option value="ЗУ-109б">ЗУ-109б</option>
            <option value="ЗУ-10а">ЗУ-10а</option>
            <option value="ЗУ-10в">ЗУ-10в</option>
            <option value="ЗУ-110а">ЗУ-110а</option>
            <option value="ЗУ-110б">ЗУ-110б</option>
            <option value="ЗУ-11а-1">ЗУ-11а-1</option>
            <option value="ЗУ-11а-2">ЗУ-11а-2</option>
            <option value="ЗУ-11б-1">ЗУ-11б-1</option>
            <option value="ЗУ-11б-2">ЗУ-11б-2</option>
            <option value="ЗУ-112">ЗУ-112</option>
            <option value="ЗУ-112а">ЗУ-112а</option>
            <option value="ЗУ-112б">ЗУ-112б</option>
            <option value="ЗУ-112в">ЗУ-112в</option>
            <option value="ЗУ-112г">ЗУ-112г</option>
            <option value="ЗУ-12а-1">ЗУ-12а-1</option>
            <option value="ЗУ-12а-2">ЗУ-12а-2</option>
            <option value="ЗУ-12б">ЗУ-12б</option>
            <option value="ЗУ-12в">ЗУ-12в</option>
            <option value="ЗУ-12г">ЗУ-12г</option>
            <option value="ЗУ-13-2">ЗУ-13-2</option>
            <option value="ЗУ-13б">ЗУ-13б</option> 
            <option value="ЗУ-15а-1">ЗУ-15а-1</option>
            <option value="ЗУ-15а-2">ЗУ-15а-2</option>
            <option value="ЗУ-15б-1">ЗУ-15б-1</option>
            <option value="ЗУ-15б-2">ЗУ-15б-2</option>
            <option value="ЗУ-15в">ЗУ-15в</option>
            <option value="ЗУ-16а">ЗУ-16а</option>
            <option value="ЗУ-16б">ЗУ-16б</option>
            <option value="ЗУ-16в">ЗУ-16в</option>
            <option value="ЗУ-16г">ЗУ-16г</option>
            <option value="ЗУ-18а">ЗУ-18а</option>
            <option value="ЗУ-18б">ЗУ-18б</option>
            <option value="ЗУ-18в">ЗУ-18в</option>
            <option value="ЗУ-18г">ЗУ-18г</option>
            <option value="ЗУ-1а">ЗУ-1а</option>
            <option value="ЗУ-1в">ЗУ-1в</option>
            <option value="ЗУ-1г">ЗУ-1г</option>
            <option value="ЗУ-1д(б)">ЗУ-1д(б)</option>
            <option value="ЗУ-1е">ЗУ-1е</option>
            <option value="ЗУ-1ж">ЗУ-1ж</option>
            <option value="ЗУ-20а">ЗУ-20а</option>
            <option value="ЗУ-20б">ЗУ-20б</option>
            <option value="ЗУ-20в">ЗУ-20в</option>
            <option value="ЗУ-21">ЗУ-21</option>
            <option value="ЗУ-21б">ЗУ-21б</option>
            <option value="ЗУ-22">ЗУ-22</option>
            <option value="ЗУ-22а">ЗУ-22а</option>
            <option value="ЗУ-22б">ЗУ-22б</option>
            <option value="ЗУ-22в">ЗУ-22в</option>
            <option value="ЗУ-23а">ЗУ-23а</option>
            <option value="ЗУ-23б">ЗУ-23б</option>
            <option value="ЗУ-23в">ЗУ-23в</option>
            <option value="ЗУ-24а">ЗУ-24а</option>
            <option value="ЗУ-24б">ЗУ-24б</option>
            <option value="ЗУ-24в">ЗУ-24в</option>
            <option value="ЗУ-24г">ЗУ-24г</option>
            <option value="ЗУ-24д">ЗУ-24д</option>
            <option value="ЗУ-27а">ЗУ-27а</option>
            <option value="ЗУ-27б">ЗУ-27б</option>
            <option value="ЗУ-27в">ЗУ-27в</option>
            <option value="ЗУ-27г">ЗУ-27г</option>
            <option value="ЗУ-28а">ЗУ-28а</option>
            <option value="ЗУ-28б">ЗУ-28б</option>
            <option value="ЗУ-28в">ЗУ-28в</option>
            <option value="ЗУ-28г">ЗУ-28г</option>
            <option value="ЗУ-2а-1">ЗУ-2а-1</option>
            <option value="ЗУ-2а-2">ЗУ-2а-2</option>
            <option value="ЗУ-2б">ЗУ-2б</option>
            <option value="ЗУ-2в">ЗУ-2в</option>
            <option value="ЗУ-30а">ЗУ-30а</option>
            <option value="ЗУ-30б">ЗУ-30б</option>
            <option value="ЗУ-30в">ЗУ-30в</option>
            <option value="ЗУ-30г">ЗУ-30г</option>
            <option value="ЗУ-30д">ЗУ-30д</option>
            <option value="ЗУ-30е">ЗУ-30е</option>
            <option value="ЗУ-30ж">ЗУ-30ж</option>
            <option value="ЗУ-31">ЗУ-31</option>
            <option value="ЗУ-31а">ЗУ-31а</option>
            <option value="ЗУ-31б">ЗУ-31б</option>
            <option value="ЗУ-34а">ЗУ-34а</option>
            <option value="ЗУ-34б">ЗУ-34б</option>
            <option value="ЗУ-34в">ЗУ-34в</option>
            <option value="ЗУ-34г">ЗУ-34г</option>
            <option value="ЗУ-34д">ЗУ-34д</option>
            <option value="ЗУ-38">ЗУ-38</option>
            <option value="ЗУ-38а">ЗУ-38а</option>
            <option value="ЗУ-38в">ЗУ-38в</option>
            <option value="ЗУ-3а">ЗУ-3а</option>
            <option value="ЗУ-3б-1">ЗУ-3б-1</option>
            <option value="ЗУ-3б-2">ЗУ-3б-2</option>
            <option value="ЗУ-3в">ЗУ-3в</option>
            <option value="ЗУ-40а">ЗУ-40а</option>
            <option value="ЗУ-40б">ЗУ-40б</option>
            <option value="ЗУ-40в">ЗУ-40в</option>
            <option value="ЗУ-41а">ЗУ-41а</option>
            <option value="ЗУ-41б">ЗУ-41б</option>
            <option value="ЗУ-41в">ЗУ-41в</option>
            <option value="ЗУ-41г">ЗУ-41г</option>
            <option value="ЗУ-41д">ЗУ-41д</option>
            <option value="ЗУ-41е">ЗУ-41е</option>
            <option value="ЗУ-41ж">ЗУ-41ж</option> 
            <option value="ЗУ-42">ЗУ-42</option>
            <option value="ЗУ-42а">ЗУ-42а</option>
            <option value="ЗУ-42б">ЗУ-42б</option> 
            <option value="ЗУ-43">ЗУ-43</option>
            <option value="ЗУ-43а">ЗУ-43а</option>
            <option value="ЗУ-43б">ЗУ-43б</option> 
            <option value="ЗУ-43г">ЗУ-43г</option>
            <option value="ЗУ-43д">ЗУ-43д</option> 
            <option value="ЗУ-45">ЗУ-45</option>
            <option value="ЗУ-45а">ЗУ-45а</option>
            <option value="ЗУ-45б">ЗУ-45б</option>
            <option value="ЗУ-45в">ЗУ-45в</option>
            <option value="ЗУ-45г">ЗУ-45г</option>
            <option value="ЗУ-45д">ЗУ-45д</option>
            <option value="ЗУ-46">ЗУ-46</option>
            <option value="ЗУ-46а">ЗУ-46а</option>
            <option value="ЗУ-46б">ЗУ-46б</option>
            <option value="ЗУ-47а">ЗУ-47а</option>
            <option value="ЗУ-47б">ЗУ-47б</option>
            <option value="ЗУ-47в">ЗУ-47в</option>
            <option value="ЗУ-47д">ЗУ-47д</option>
            <option value="ЗУ-48а">ЗУ-48а</option>
            <option value="ЗУ-49а">ЗУ-49а</option>
            <option value="ЗУ-49б">ЗУ-49б</option>
            <option value="ЗУ-49в">ЗУ-49а</option>
            <option value="ЗУ-4а">ЗУ-4а</option>
            <option value="ЗУ-4б">ЗУ-4б</option>
            <option value="ЗУ-4в">ЗУ-4в</option>
            <option value="ЗУ-5">ЗУ-5</option>
            <option value="ЗУ-51">ЗУ-51</option>
            <option value="ЗУ-51а">ЗУ-51а</option>
            <option value="ЗУ-51б">ЗУ-51б</option>
            <option value="ЗУ-52">ЗУ-5</option>
            <option value="ЗУ-52а">ЗУ-52а</option>
            <option value="ЗУ-52б">ЗУ-52б</option>
            <option value="ЗУ-52в">ЗУ-52в</option>
            <option value="ЗУ-54а">ЗУ-54а</option>
            <option value="ЗУ-54б">ЗУ-54б</option>
            <option value="ЗУ-54в">ЗУ-54в</option>
            <option value="ЗУ-54г">ЗУ-54г</option>
            <option value="ЗУ-54д">ЗУ-54д</option>
            <option value="ЗУ-55а">ЗУ-55а</option>
            <option value="ЗУ-55б">ЗУ-55б</option>
            <option value="ЗУ-57а">ЗУ-57а</option>
            <option value="ЗУ-57б">ЗУ-57б</option>
            <option value="ЗУ-57в">ЗУ-57в</option>
            <option value="ЗУ-57г">ЗУ-57г</option>
            <option value="ЗУ-58">ЗУ-55</option>
            <option value="ЗУ-58а">ЗУ-58а</option>
            <option value="ЗУ-58б">ЗУ-58б</option>
            <option value="ЗУ-5а">ЗУ-5а</option>
            <option value="ЗУ-5б">ЗУ-5б</option>
            <option value="ЗУ-5в">ЗУ-5в</option>
            <option value="ЗУ-5г">ЗУ-5г</option>
            <option value="ЗУ-5д">ЗУ-5д</option>
            <option value="ЗУ-6">ЗУ-6</option>
            <option value="ЗУ-60">ЗУ-60</option>
            <option value="ЗУ-60б">ЗУ-60б</option>
            <option value="ЗУ-60б">ЗУ-60б</option>
            <option value="ЗУ-61а-1">ЗУ-61а-1</option>
            <option value="ЗУ-61а-2">ЗУ-61а-2</option>
            <option value="ЗУ-61б">ЗУ-61б</option>
            <option value="ЗУ-61в">ЗУ-61бв</option>
            <option value="ЗУ-61г">ЗУ-61вг</option>
            <option value="ЗУ-62а-1">ЗУ-62а-1</option>
            <option value="ЗУ-62а-2">ЗУ-62а-2</option>
            <option value="ЗУ-65а-1">ЗУ-65а-1</option>
            <option value="ЗУ-65а-2">ЗУ-65а-2</option>
            <option value="ЗУ-65б">ЗУ-65б</option>
            <option value="ЗУ-65в">ЗУ-65в</option>
            <option value="ЗУ-65г">ЗУ-65г</option>
            <option value="ЗУ-68а">ЗУ-68а</option>
            <option value="ЗУ-68б">ЗУ-68б</option>
            <option value="ЗУ-68в">ЗУ-68в</option>
            <option value="ЗУ-68г">ЗУ-68г</option>
            <option value="ЗУ-69а">ЗУ-69а</option>
            <option value="ЗУ-69б">ЗУ-69б</option>
            <option value="ЗУ-69в">ЗУ-69в</option>
            <option value="ЗУ-6а">ЗУ-6а</option>
            <option value="ЗУ-6б">ЗУ-6б</option>
            <option value="ЗУ-73">ЗУ-73</option>
            <option value="ЗУ-73а">ЗУ-73а</option>
            <option value="ЗУ-73б">ЗУ-73б</option>
            <option value="ЗУ-74а-1">ЗУ-74а-1</option>
            <option value="ЗУ-74а-2">ЗУ-774а-2</option>
            <option value="ЗУ-74б">ЗУ-74б</option>
            <option value="ЗУ-76а">ЗУ-76а</option>
            <option value="ЗУ-76б">ЗУ-76а</option>
            <option value="ЗУ-76в">ЗУ-76б</option>
            <option value="ЗУ-76г">ЗУ-76в</option>
            <option value="ЗУ-77а">ЗУ-77а</option>
            <option value="ЗУ-77б">ЗУ-77а</option>
            <option value="ЗУ-77в">ЗУ-77б</option>
            <option value="ЗУ-7а">ЗУ-7а</option>
            <option value="ЗУ-7б">ЗУ-7б</option>
            <option value="ЗУ-7в">ЗУ-7в</option>
            <option value="ЗУ-7г">ЗУ-7г</option>
            <option value="ЗУ-80а">ЗУ-80а</option>
            <option value="ЗУ-80б">ЗУ-80б</option>
            <option value="ЗУ-80в">ЗУ-80в</option>
            <option value="ЗУ-80г">ЗУ-80г</option>
            <option value="ЗУ-80д">ЗУ-80д</option>
            <option value="ЗУ-81а">ЗУ-81а</option>
            <option value="ЗУ-81б">ЗУ-81б</option>
            <option value="ЗУ-81в">ЗУ-81в</option>
            <option value="ЗУ-82-1">ЗУ-82-2</option>
            <option value="ЗУ-82-2">ЗУ-82-2</option>
            <option value="ЗУ-83а">ЗУ-83а</option>         
            <option value="ЗУ-83а1">ЗУ-83а1</option>
            <option value="ЗУ-83б">ЗУ-83б</option>
            <option value="ЗУ-83в">ЗУ-83в</option>
            <option value="ЗУ-83г">ЗУ-83г</option>
            <option value="ЗУ-83д">ЗУ-83д</option>
            <option value="ЗУ-84а">ЗУ-84а</option>         
            <option value="ЗУ-84а1">ЗУ-84а1</option>
            <option value="ЗУ-84б">ЗУ-84б</option>
            <option value="ЗУ-84в">ЗУ-84в</option>
            <option value="ЗУ-84г">ЗУ-84г</option>
            <option value="ЗУ-84д">ЗУ-84д</option>
            <option value="ЗУ-85а">ЗУ-85а</option>
            <option value="ЗУ-85б">ЗУ-85б</option>
            <option value="ЗУ-85в">ЗУ-85в</option>
            <option value="ЗУ-85г">ЗУ-85г</option>
            <option value="ЗУ-85д">ЗУ-85д</option>
            <option value="ЗУ-87а">ЗУ-87а</option>
            <option value="ЗУ-87б">ЗУ-87б</option>
            <option value="ЗУ-87в">ЗУ-87в</option>
            <option value="ЗУ-87г">ЗУ-87г</option>
            <option value="ЗУ-87д">ЗУ-87д</option>
            <option value="ЗУ-88а">ЗУ-88а</option>
            <option value="ЗУ-88б">ЗУ-88б</option>
            <option value="ЗУ-88в">ЗУ-88в</option>
            <option value="ЗУ-88г">ЗУ-88г</option>
            <option value="ЗУ-88д">ЗУ-88д</option>
            <option value="ЗУ-88е">ЗУ-88е</option>
            <option value="ЗУ-89а">ЗУ-89а</option>
            <option value="ЗУ-89б">ЗУ-89б</option>
            <option value="ЗУ-89в">ЗУ-89в</option>
            <option value="СП-79а	">СП-79а</option>

          </select>
        </div>
    </div>


    </div>
    <button :disabled='dzo==null'   @click="updateData">Сформировать отчет</button>
</div>
  <BootstrapTable
    :columns="columns"
    :data="data"
    :options="options"
  />
    
</div>
</template>
<script>
import BootstrapTable from 'bootstrap-table/dist/bootstrap-table-vue.esm.js'
import 'tableexport.jquery.plugin'
import 'bootstrap-table/dist/extensions/export/bootstrap-table-export.js'
import 'bootstrap-table/dist/bootstrap-table.min.css'

export default {
  components: {
    BootstrapTable
  },
  data () {
    return {

      exportTypes: ['json', 'excel'],
      columns: [
          [
            {
          title: 'Номер скаважины',
          rowspan: 2,
          align: 'center',
        },
        {
          title: 'ДЗО',
          rowspan: 2,
          align: 'center',
        },
        {
          title: 'НГДУ',
          rowspan: 2,
          align: 'center',
        },
        {
          title: 'ЦДНГ',
          rowspan: 2,
          align: 'center',
        },
        {
          title: 'ЗУ/ГЗУ',
          rowspan: 2,
          align: 'center',
        },
        {
          title: 'Горизонт',
          rowspan: 2,
          align: 'center',
        },
        {
          title: 'Блок',
          rowspan: 2,
          align: 'center',
        },
        {
          title: 'Дата проведения мероприятия',
          rowspan: 2,
          align: 'center',
        },
        {
          title: 'Дата запуска',
          rowspan: 2,
          align: 'center',
        },
        {
          title: 'Вид мероприятия',
          rowspan: 2,
          align: 'center',
        },
        {
          title: 'Подрядчик',
          rowspan: 2,
          align: 'center',
        },
        {
          title: 'Жидкость после ГТМ',
          rowspan: 2,
          align: 'center',
        },
        {
          title: 'Нефть после ГТМ',
          rowspan: 2,
          align: 'center',
        },
            {
          title: 'Январь 2020',
          colspan: 9,
          align: 'left',
        },
        {
          title: 'Февраль 2020',
          colspan: 9,
          align: 'left',
        },
         {
          title: 'Март 2020',
          colspan: 9,
          align: 'left',
        },
         {
          title: 'Апрель 2020',
          colspan: 9,
          align: 'left',
        },
        {
          title: 'Май 2020',
          colspan: 9,
          align: 'left',
        },
            {
          title: 'Июнь 2020',
          colspan: 9,
          align: 'left',
        },
         {
          title: 'Июль 2020',
          colspan: 9,
          align: 'left',
        },
        {
          title: 'Август 2020',
          colspan: 9,
          align: 'left',
        },
         {
          title: 'Сентябрь 2020',
          colspan: 9,
          align: 'left',
        },
        {
          title: 'Total',
          colspan: 9,
          align: 'left',
        }
        ],
        [
         {
          align: 'center',
          title: 'Календарные дни',
        },
        {
          align: 'center',
          title: 'Доп добыча Qн, т',
        },
        {
          align: 'center',
          title: 'Hдин',
        },
        {
          align: 'center',
          title: 'Pзаб',
        },
        {
          align: 'center',
          title: 'Жидкость',
        },
        {
          align: 'center',
          title: '% Обв',
        },
        {
          align: 'center',
          title: 'Нефть',
        },
        {
          align: 'center',
          title: 'Отработанные дни',
        },
        {
          align: 'center',
          title: 'Коэффициент эксплуатации',
        },
           {
          align: 'center',
          title: 'Календарные дни',
        },
        {
          align: 'center',
          title: 'Доп добыча Qн, т',
        },
        {
          align: 'center',
          title: 'Hдин',
        },
        {
          align: 'center',
          title: 'Pзаб',
        },
        {
          align: 'center',
          title: 'Жидкость',
        },
        {
          align: 'center',
          title: '% Обв',
        },
        {
          align: 'center',
          title: 'Нефть',
        },
        {
          align: 'center',
          title: 'Отработанные дни',
        },
        {
          align: 'center',
          title: 'Коэффициент эксплуатации',
        },
         {
          align: 'center',
          title: 'Календарные дни',
        },
        {
          align: 'center',
          title: 'Доп добыча Qн, т',
        },
        {
          align: 'center',
          title: 'Hдин',
        },
        {
          align: 'center',
          title: 'Pзаб',
        },
        {
          align: 'center',
          title: 'Жидкость',
        },
        {
          align: 'center',
          title: '% Обв',
        },
        {
          align: 'center',
          title: 'Нефть',
        },
        {
          align: 'center',
          title: 'Отработанные дни',
        },
        {
          align: 'center',
          title: 'Коэффициент эксплуатации',
        },
         {
          align: 'center',
          title: 'Календарные дни',
        },
        {
          align: 'center',
          title: 'Доп добыча Qн, т',
        },
        {
          align: 'center',
          title: 'Hдин',
        },
        {
          align: 'center',
          title: 'Pзаб',
        },
        {
          align: 'center',
          title: 'Жидкость',
        },
        {
          align: 'center',
          title: '% Обв',
        },
        {
          align: 'center',
          title: 'Нефть',
        },
        {
          align: 'center',
          title: 'Отработанные дни',
        },
        {
          align: 'center',
          title: 'Коэффициент эксплуатации',
        },
         {
          align: 'center',
          title: 'Календарные дни',
        },
        {
          align: 'center',
          title: 'Доп добыча Qн, т',
        },
        {
          align: 'center',
          title: 'Hдин',
        },
        {
          align: 'center',
          title: 'Pзаб',
        },
        {
          align: 'center',
          title: 'Жидкость',
        },
        {
          align: 'center',
          title: '% Обв',
        },
        {
          align: 'center',
          title: 'Нефть',
        },
        {
          align: 'center',
          title: 'Отработанные дни',
        },
        {
          align: 'center',
          title: 'Коэффициент эксплуатации',
        },
         {
          align: 'center',
          title: 'Календарные дни',
        },
        {
          align: 'center',
          title: 'Доп добыча Qн, т',
        },
        {
          align: 'center',
          title: 'Hдин',
        },
        {
          align: 'center',
          title: 'Pзаб',
        },
        {
          align: 'center',
          title: 'Жидкость',
        },
        {
          align: 'center',
          title: '% Обв',
        },
        {
          align: 'center',
          title: 'Нефть',
        },
        {
          align: 'center',
          title: 'Отработанные дни',
        },
        {
          align: 'center',
          title: 'Время работы',
        },
         {
          align: 'center',
          title: 'Коэффициент эксплуатации',
        },
        {
          align: 'center',
          title: 'Доп добыча Qн, т',
        },
        {
          align: 'center',
          title: 'Hдин',
        },
        {
          align: 'center',
          title: 'Pзаб',
        },
        {
          align: 'center',
          title: 'Жидкость',
        },
        {
          align: 'center',
          title: '% Обв',
        },
        {
          align: 'center',
          title: 'Нефть',
        },
        {
          align: 'center',
          title: 'Отработанные дни',
        },
        {
          align: 'center',
          title: 'Коэффициент эксплуатации',
        },
         {
          align: 'center',
          title: 'Календарные дни',
        },
        {
          align: 'center',
          title: 'Доп добыча Qн, т',
        },
        {
          align: 'center',
          title: 'Hдин',
        },
        {
          align: 'center',
          title: 'Pзаб',
        },
        {
          align: 'center',
          title: 'Жидкость',
        },
        {
          align: 'center',
          title: '% Обв',
        },
        {
          align: 'center',
          title: 'Нефть',
        },
        {
          align: 'center',
          title: 'Отработанные дни',
        },
        {
          align: 'center',
          title: 'Коэффициент эксплуатации',
        },
         {
          align: 'center',
          title: 'Календарные дни',
        },
        {
          align: 'center',
          title: 'Доп добыча Qн, т',
        },
        {
          align: 'center',
          title: 'Hдин',
        },
        {
          align: 'center',
          title: 'Pзаб',
        },
        {
          align: 'center',
          title: 'Жидкость',
        },
        {
          align: 'center',
          title: '% Обв',
        },
        {
          align: 'center',
          title: 'Нефть',
        },
        {
          align: 'center',
          title: 'Отработанные дни',
        },
        {
          align: 'center',
          title: 'Коэффициент эксплуатации',
        },
     {
          align: 'center',
          title: 'Календарные дни',
        },
        {
          align: 'center',
          title: 'Доп добыча Qн, т',
        },
        {
          align: 'center',
          title: 'Hдин',
        },
        {
          align: 'center',
          title: 'Pзаб',
        },
        {
          align: 'center',
          title: 'Жидкость',
        },
        {
          align: 'center',
          title: '% Обв',
        },
        {
          align: 'center',
          title: 'Нефть',
        },
        {
          align: 'center',
          title: 'Отработанные дни',
        },
        {
          align: 'center',
          title: 'Коэффициент эксплуатации',
        }
        ]
      ],
      data: [
        {
          id: 1,
          name: 'Item 1',
          price: '$1'
        }
      ],
     options: {
        search: true,
        pagination: true,
        showColumns: true,
        showExport: true,      
        exportTypes: ['excel', 'csv', 'doc'],
        exportDataType: 'all',
        locale: 'ru-RU',
        filterControl: true,
        showSearchClearButton: true,


      },
      dzo: null,
      ngdu: null,
      block: null,
      horizon: null,
      tseh: null,
      zu: null,
    }
  },
  methods: {
    // dayClicked(day) {
    //   this.date = day.id;
    //   var dt = this.date.split('-');
     

    // },
    updateData(){
      let uri = '/ru/gtm1';
      this.axios.post("/ru/gtm1", {
        dzo: this.dzo,
         ngdu: this.ngdu,
         block: this.block,
         horizon: this.horizon,
         tseh: this.tseh,
         zu: this.zu,          
        })
        .then((response) => {
          let data = response.data;
          if (data) {
            this.data = data.wellsList1;
            // this.data = test1; 
          } else {
            console.log("No data");
          }
        }); 
         },
     onChangeDzo(event) {
        this.dzo = event.target.value;

    },
     onChangeNgdu(event) {
        this.ngdu = event.target.value;

    },
     onChangeBlock(event) {
        this.block = event.target.value;

    },
    onChangeHorizon(event) {
        this.horizon = event.target.value;

    },
    onChangeCGDN(event) {
        this.tseh = event.target.value;

    },
    onChangeZU(event) {
        this.zu = event.target.value;
        
    
    },
    beforeCreate: function(){
      this.updateData()
      console.log('data'); 

    },
  }, 
}
</script>