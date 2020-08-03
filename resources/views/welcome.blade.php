@extends('layouts.app')
@section('content')
	 <div class="col p-4" id="app">
        <div class="level1-content row">
            <div class=" col-md-12 col-lg-12 row">
                <div class="level1-tab active"  tabindex="-1">Общие данные</div>
                <div class="level1-tab"  tabindex="-1">Аналитика</div>				        
            <div class="main col-md-7 col-lg-7 row">
                <div class="col-sm-12 col-md-4 col-lg-4">
                    <div class="digitOil row">
                        <div class="okei okei-left">тыс.тонн</div>
                        <div class="digit-oil-icon"><img src="{{ asset('img/level1/digit-oil-icon.svg') }}" alt=""></div>
                        <img src="{{ asset('img/level1/oil.svg') }}" alt="" class="digit-oil-icon-middle">
                        <div class="digit-oil-description">
                            <div class="digit-oil-name">Нефть</div>
                            <div class="digit-oil-value">136</div>
                        </div>
                        <div class="digit-oil-additional">
                            <div class="digit-oil-additional-icon"><img src="{{ asset('img/level1/arrow_up.svg') }}" alt=""></div>
                            <div class="digit-oil-additional-value">+0,3%</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 col-lg-4">
                   <!-- <div class="col-md-12 col-lg-12 row">
                        <div class="col-md-2 col-lg-2">
                            <img src="{{ asset('img/level1/date_left_arrow.svg') }}" alt="">
                        </div>
                        <div class="col-md-8 col-lg-8">
                            <div class="time">{{date("h:i")}}</div>
                            <div class="date">{{date("d F Y")}}</div>
                        </div>
                        <div class="col-md-2 col-lg-2">
                            <img src="{{ asset('img/level1/date_right_arrow.svg') }}" alt="">
                        </div>
                    </div>-->
					
					<div class="col-md-12 col-lg-12 row">                   
                        <div class="timer-welcome">
						     <div class="left-arrow">
                            <!--<img src="{{ asset('img/level1/date_left_arrow.svg') }}" alt="">-->
                        </div>
						<div class="timer">
                            <div class="time">{{date("h:i")}}</div>
                            <div class="date">{{date("d F Y")}}</div>
							</div>
							      <div class="right-arrow">
                            <!--<img src="{{ asset('img/level1/date_right_arrow.svg') }}" alt="">-->
							                        </div>
                        </div>
                  
						                   </div>
                    <div class="col-md-12 col-lg-12 row">
                        <div class="title">Казахстан</div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 col-lg-4">
                    <div class="digitGaz  row">
                        <div class="okei okei-right">млрд.м3</div>
                        <div class="digit-gaz-additional">
                            <div class="digit-gaz-additional-icon"><img src="{{ asset('img/level1/arrow_down.svg') }}" alt=""></div>
                            <div class="digit-gaz-additional-value">-0,1%</div>
                        </div>
                        <div class="digit-gaz-description">
                            <div class="digit-gaz-name">Газ</div>
                            <div class="digit-gaz-value">0.64</div>
                        </div>
                        <div class="digit-gaz-icon"><img src="{{ asset('img/level1/digit-gaz-icon.svg') }}" alt=""></div>
                        <img src="{{ asset('img/level1/gaz.svg') }}" alt="" class="digit-gaz-icon-middle">
                    </div>
                </div>

                <div class="col-md-2 col-lg-2 indicator">
                    <div class="indicator-icon">
                        <img src="{{ asset('img/level1/oil.svg') }}" alt="">
                    </div>
                    <div class="indicator-name">Запасы нефти и конденсата</div>
                    <div class="indicator-value">668,2</div>
                    <div class="indicator-okei">тыс.тонн</div>
                </div>
                <div class="col-md-2 col-lg-2" style="height: 135px;"></div>
                <div class="col-md-2 col-lg-2" style="height: 135px;"></div>
                <div class="col-md-2 col-lg-2" style="height: 135px;"></div>
                <div class="col-md-2 col-lg-2" style="height: 135px;"></div>
                <div class="col-md-2 col-lg-2 indicator">
                    <div class="indicator-icon">
                        <img src="{{ asset('img/level1/gaz.svg') }}" alt="">
                    </div>
                    <div class="indicator-name">Запасы природного газа</div>
                    <div class="indicator-value">414,3</div>
                    <div class="indicator-okei">млрд.м3</div>
                </div>
			

                <div class="col-md-12 col-lg-12">
				<div class="map">
					<div class="nur-sultan">Нур-Султан
				<div class="square"> </div></div>
                   <!-- <img src="{{ asset('img/level1/map_kz.svg') }}" class="map" alt="">-->
				   
				   <div class="org-name1 rectangle"> ТОО «Казахтуркмунай»
				   <div class="icon1 icon"></div>
					<div class="square-small">&#10003;</div>
				   </div>
				   
				   <div class="org-name2 rectangle">ТОО «Казахойл Актобе»
				   <div class="icon2 icon"></div>
				   <div class="square-small">&#10003;</div>
				   
				   </div>
				   
				   <div class="org-name3 rectangle">АО «ЭмбаМунайГаз»
				   <div class="icon3 icon"></div>
				   <div class="square-small">&#10003;</div>
				   
				   </div>
				   
				   <div class="org-name4 rectangle">АО «Каражанбасмунай»
				   <div class="icon4 icon"></div>
				   <div class="square-small">&#10003;</div>
				  
				   </div>
				   
				   <div class="org-name5 rectangle"> АО «Мангистаумунайгаз»
				   <div class="icon5 icon"></div>
				  <div class="square-small">&#10003;</div>
			   </div>
				   
				   <div class="org-name6 rectangle">  АО «ОзенМунайГаз»
				   <div class="icon6 icon"></div>
				   <div class="square-small">&#10003;</div>
				
				   </div>
				   
				   <div class="org-name7 rectangle">  ТОО «КазГерМунай»
				   <div class="icon7 icon"></div>
				   <div class="square-small">&#10003;</div>
				   
					</div>
				
				</div></div>
				
				
				
				
				
				
				<div class = "footer-chart">
				<div class="point"></div>
						Добыча нефти и конденсата (тыс. тонн)
				<div id="container">
		<welcome-chart-bar-bottom1></welcome-chart-bar-bottom1>
		</div></div>
				
				
				<div class = "footer-chart">
				<div class="point"></div>
				Добыча природного и попутного газа (млн. м3) 
				<div id="container">
		<welcome-chart-bar-bottom2></welcome-chart-bar-bottom2>
		</div></div>
				
				
            </div>
            <div class="right-bar col-md-5 col-lg-5">
                <div>
                    <div class="right-tab col-md-3 col-lg-3"  tabindex="-1">День</div>
                    <div class="right-tab col-md-3 col-lg-3"  tabindex="-1">Месяц</div>
                    <div class="right-tab col-md-3 col-lg-3"  tabindex="-1">Квартал</div>
                    <div class="right-tab col-md-3 col-lg-3"  tabindex="-1">Год</div>
                </div>
                <div class="info-panel">
                <!--    <div class="d-flex flex-row">
                        <div class="col-md-6">-->
						<div class="right-side">
						<div class="circle1 circle" >
						<div class="point"></div>
						Добыча нефти и конденсата
						<!--<div class="drop icon"> </div>-->
						<welcome-chart-donut-right1></welcome-chart-donut-right1>
						<div class="org-name11 rectangle2"> «КазГерМунай»: 10,9 тыс. тонн</div>
						</div>
						<div class="circle2 circle">
						<div class="point"></div>
						Добыча природного газа										
						<welcome-chart-donut-right2></welcome-chart-donut-right2>
						<div class="org-name22 rectangle2">ЭмбаМунайГаз: 0,02 млрд. м3 </div>	
						</div>
						</div>
						
										
									
				
			<div class="right-side">
					<div class="indent-top"><charttide></charttide></div>
					
				
	</div>
								<div class="right-side">
						<div class="circle3 circle">
						<div class="point"></div>							
						Нефтяной фонд скважин
						<welcome-chart-donut-right3></welcome-chart-donut-right3>
						<div class="org-name33 rectangle2"> «Казахойл Актобе»: 1 601 ед.</div>
						</div>
						<div class="circle4 circle"> 
						<div class="point"></div>
						Нагнетальный фонд скважин
						<welcome-chart-donut-right4></welcome-chart-donut-right4>
						<div class="org-name44 rectangle2"> «Мангистаумунайгаз»: 1 183 ед.</div>
						</div>
						</div>
						<!--<doughnut-component></doughnut-component>-->
						

	
                </div>
				
					
            <!--</div>
        </div>-->
		

@endsection

<style>
    .p-4{
        background-color: #0F1430;
    }
    .level1-tab{
        width: 390px;
        height: 25px;
        background-color: #0F254A;
        color: #41638A;
        display: inline-block;
        text-align: center;
        margin-left: 0px !important;
        margin-right: -4px !important;
    }
    .level1-tab:focus {
        background-color: #15509D;
        color: #FFFFFF;
        border: none;
    }
    .main{
        height: 897px;
        background-color: #0F1430;
        background-image: url({{ asset('img/level1/grid.svg') }});
        border: 1px solid #0D2B4D;
        margin-left: 0px !important;
        padding-top: 20px;
    }
    .right-bar{
        height: 918px;
        margin-left: 10px !important;
    }
    .right-tab{
        height: 25px;
        display: inline-block;
        background: #0F254A;
        text-align: center;
        color: #41638A;
        margin-left: 0px !important;
        margin-right: -4px !important;
    }
    .right-tab:focus{
        background: #15509D;
        color: #FFFFFF;
        border: none;
    }
    .info-panel{
        height: 870px;
        background: #20274F;
    }
    .indicator{
        background-image: url("{{ asset('img/level1/oil_reserve.svg') }}");
        background-repeat: no-repeat;
        color: #FFFFFF;
        font-size: 11px;
        line-height: 13px;
        text-align: center;
        width: 135px;
        height: 135px;
    }
    .title{
        width: 225px;
        height: 40px;
        background-image: url("{{ asset('img/level1/title.svg') }}");
        background-repeat: no-repeat;
        color: #FFFFFF;
        text-align: center;
        vertical-align: middle;
        line-height: 40px;
        margin: auto;
    }
    .time{
        font-size: 18px;
        color: #FFFFFF;
        text-align: center;
        vertical-align: middle;
    }
    .date{
        font-size: 12px;
        color: #FFFFFF;
        text-align: center;
        vertical-align: middle;
    }
    .digitOil{
        width: 270px;
        height: 77px;
        background-image: url("{{ asset('img/level1/digitOil.svg') }}");
        background-repeat: no-repeat;
        margin-top:10px;
        color:#FFFFFF;
    }
    .digitGaz{
        width: 270px;
        height: 77px;
        background-image: url("{{ asset('img/level1/digitGaz.svg') }}");
        background-repeat: no-repeat;
        margin-top:10px;
        color:#FFFFFF;
    }
    .okei{
        font-size: 11px;
        line-height: 13px;
        color: #FFFFFF;
    }
    .okei-left {
        margin-left: 220px;
    }
    .okei-right {
        margin-left: 5px;
    }

    /* oil */
    .digit-oil-icon{
        width: 77.63px;
        height: 80px;
        position: absolute;
        margin-left:12.73px;
    }
    .digit-oil-name{
        width: 48px;
        height: 19px;
        margin-left:110px;
        font-size: 16px;
        margin-top: -5px;
    }
    .digit-oil-value{
        width: 51px;
        height: 35px;
        margin-left:110px;
        font-size: 30px;
        margin-top: -5px;
    }
    .digit-oil-additional-icon{
        width: 13.55px;
        height: 10px;
        margin-left:197.73px;
        margin-top: -25px;
    }
    .digit-oil-additional-value{
        width: 13.55px;
        height: 10px;
        margin-left:217.73px;
        margin-top: -15px;
    }
    .digit-oil-icon-middle{
        width: 27.08px;
        height: 35px;
        position: absolute;
        margin-left:38.73px;
        margin-top:23px;
    }

    /* gaz */
    .digit-gaz-additional-value{
        width: 13.55px;
        height: 10px;
        margin-top: 40px;
        margin-left: -35px;
        position: absolute;
    }
    .digit-gaz-additional-icon{
        width: 13.55px;
        height: 10px;
        margin-top: 45px;
        margin-left: 4px;
        position: absolute;
    }
    .digit-gaz-name{
        width: 48px;
        height: 19px;
        font-size: 16px;
        margin-top: 20px;
        margin-left: 45px;
        position: absolute;
    }
    .digit-gaz-value{
        width: 51px;
        height: 35px;
        font-size: 30px;
        margin-left: 45px;
        margin-top: 30px;
        position: absolute;
    }
    .digit-gaz-icon{
        width: 77.63px;
        height: 80px;
        position: absolute;
        margin-left:180px;
    }
    .digit-gaz-icon-middle{
        width: 27.08px;
        height: 35px;
        position: absolute;
        margin-left:206px;
        margin-top:23px;
    }
    .indicator-icon{
        width: 15.47px;
        height: 20px;
        margin-top: 20px;
        margin-left: 45.5px;
    }
    .indicator-name{
        width: 86px;
        height: 26px;
        font-size: 11px;
        text-align: center;
        margin-left: 11px;
        margin-top: 3px;
    }
    .indicator-value{
        width: 51px;
        height: 23px;
        font-size: 20px;
        text-align: center;
        margin-left: 28px;
        margin-top: 6px;
    }
    .indicator-okei{
        width: 47px;
        height: 17px;
        font-size: 11px;
        text-align: center;
        margin-left: 28px;
        margin-top: 4px;
    }
</style>
		
