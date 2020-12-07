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
                            <div class="input-group-F">
                                <input type="text" class="form-control fix-rounded-right" placeholder= "Поиск" required>
                            </div>
                                
                            <span class="input-group-text" style="font-size: 18px">Поиск</span>
                            <div class="invalid-feedback">
                                No data.
                            </div>
                        </div>
                </div>
                <div class="level1-content row">       
                    <div class="col-md-12 col-lg-12" style="padding: 10px;">
                    </div>
                    <div class="center-content col-md-12">
                        <div class="col-md-12 row">
                            <svg width="20" height="22" viewBox="0 0 20 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M17.7777 2.20008H13.1331C12.6668 0.924038 11.4443 0 10 0C8.55567 0 7.33321 0.924038 6.86653 2.20008H2.22228C0.999815 2.20008 0 3.1899 0 4.40015V19.8003C0 21.0102 0.999815 22 2.22228 22H17.7777C18.9998 22 20 21.0102 20 19.8003V4.40015C20 3.1899 18.9998 2.20008 17.7777 2.20008ZM10 2.20008C10.6112 2.20008 11.1113 2.69518 11.1113 3.29992C11.1113 3.90505 10.6112 4.40015 10 4.40015C9.38878 4.40015 8.88867 3.90505 8.88867 3.29992C8.88867 2.69518 9.38878 2.20008 10 2.20008ZM7.77774 17.6002L3.3332 13.2001L4.89995 11.649L7.77774 14.4869L15.1001 7.23806L16.6668 8.79992L7.77774 17.6002Z" fill="#9EA4C9"/>
                            </svg>
                            <div class="contentTitle"><p> Разделы</p></div>
                            <br>
                            <br>
                            <div class="col btn-clk" onclick="myFunction('izbr')">
                                <div class="btn-blocks">
                                    <svg  style="height:180;" width="40" height="38" viewBox="0 0 40 38"  xmlns="http://www.w3.org/2000/svg">
                                        <path  fill-rule="evenodd" clip-rule="evenodd" d="M20.0007 30.0735L32.3607 37.4194L29.0808 23.5739L40 14.258L25.6199 13.0578L20.0007 0L14.3794 13.0578L0 14.258L10.9192 23.5739L7.64 37.4194L20.0007 30.0735Z" />
                                    </svg>
                                </div>
                                <div class="col-md-12 btn-blocks-txt">Избранное</div>
                            </div>
                            <div class="col btn-clk"onclick="myFunction('geo')">
                                <div class="btn-blocks">
                                    <svg style="height:180;" width="40" height="33" viewBox="0 0 40 33"  xmlns="http://www.w3.org/2000/svg">
                                        <path d="M18 0C17.4761 0 17.0526 0.423474 17.0526 0.947368V5.48621C15.5084 5.166 14.202 4.91305 13.2632 4.73684L10.4211 6.63158L8.52632 8.52632H5.68421L4.73684 12.3158L2.84211 14.2105V17.0526H0.947368C0.423474 17.0526 0 17.4761 0 18C0 27.9256 8.07442 36 18 36C27.9256 36 36 27.9256 36 18C36 8.07442 27.9256 0 18 0ZM33.8192 20.97C32.4199 28.4353 25.8651 34.1053 18 34.1053C16.3516 34.1053 14.7619 33.8514 13.2632 33.3891V30.3158C13.2632 29.7928 13.6876 29.3684 14.2105 29.3684H16.1053L19.8947 31.2632L22.7368 29.3684V26.5263L25.5789 25.5789L23.6842 22.7368H20.8421L17.0526 21.7895L13.2632 23.6842H9.47368L6.63158 26.5263H4.3579C2.96242 24.3019 2.08421 21.7213 1.92316 18.9474H18C18.5239 18.9474 18.9474 18.5239 18.9474 18V1.92221C21.1472 2.05011 23.2247 2.63084 25.1015 3.55737L23.6842 5.68421L21.7895 7.57895L23.6842 11.3684H27.4737L29.3684 13.2632V16.1053L28.4211 18L30.3158 20.8421C31.1807 20.9833 32.4 21.0808 33.8192 20.97Z" fill="#9EA4C9"/>
                                    </svg>        
                                </div>
                                <div class="col-md-12 btn-blocks-txt">Геология</div>
                            </div>
                            <div class="col btn-clk"onclick="myFunction('bur')">
                                <div class="btn-blocks">
                                    <svg style="height:180;" width="40" height="33" viewBox="0 0 40 33"  xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M1.96568 1.28937C1.5569 1.19378 1.13012 0.896317 0.720779 0.896317C0.270388 0.896317 0.000488281 1.25054 0.000488281 1.7476C0.000488281 2.41165 1.27855 2.69678 2.03089 3.05776V6.52872C1.73176 6.50398 0.386783 5.56272 0.0764022 6.67604C-0.0259336 7.04322 0.0679768 7.30747 0.338436 7.50146C0.559976 7.66003 1.72501 8.16047 2.03089 8.23188V11.6377C1.67778 11.5556 1.13237 11.1794 0.786561 11.1794C0.332235 11.1794 -0.63826 12.2584 0.87991 12.8544C1.28982 13.0152 1.68564 13.2452 2.09667 13.3408V16.8123C1.67327 16.7769 1.20434 16.3535 0.720779 16.3535C0.270388 16.3535 0.000488281 16.7083 0.000488281 17.2054C0.000488281 17.8947 1.34153 18.1843 2.03089 18.5149C2.03089 19.7812 2.03089 21.0475 2.03089 22.3138C2.03089 24.5522 1.77957 23.6379 2.97555 25.1685L4.72593 27.2169C5.0037 27.5604 6.12489 29.1258 6.61576 29.1258C7.40409 29.1258 7.26466 28.929 8.008 28.0946L10.5602 25.0796C11.0938 24.4774 11.1073 23.8516 10.3786 23.5288L5.08749 21.0913C4.89632 21.0019 4.75517 20.9586 4.58424 20.8737C4.26823 20.718 3.90892 20.5763 3.60304 20.4144V19.17C3.79928 19.2645 3.99384 19.3342 4.19176 19.4326C4.38856 19.531 4.6056 19.6165 4.82938 19.712L7.29333 20.7849C7.51038 20.8816 7.67004 20.9502 7.88821 21.0413L10.9853 22.3987C11.3778 22.5668 11.8529 22.7945 12.2482 22.9092C12.8493 23.083 13.231 22.7597 13.231 22.0517C13.231 21.436 12.2645 21.2921 11.5279 20.9384C11.5279 18.1501 12.0126 19.0058 8.38246 17.4033C8.00011 17.2346 7.62113 17.0963 7.2236 16.9248C6.80188 16.7426 6.42065 16.5947 6.02424 16.421C5.62445 16.2455 5.24097 16.1033 4.82488 15.9178C4.45715 15.7536 3.98595 15.5258 3.60304 15.4364V14.1921C4.47908 14.3962 12.1374 17.7947 12.314 17.7947C13.4177 17.7947 13.2985 16.8416 13.0477 16.5368C12.8982 16.3547 11.8062 15.8947 11.5279 15.8295C11.5279 14.1747 11.7775 13.7209 10.7143 13.3032L5.97927 11.3571C5.55812 11.1906 3.80884 10.4158 3.53725 10.3933V8.88697L10.1059 11.7501C10.4545 11.9002 12.1211 12.6857 12.3798 12.6857C13.1169 12.6857 13.6449 11.5685 12.5591 11.1305C12.3112 11.0304 11.7804 10.8071 11.5279 10.7863C11.5279 8.25154 11.9097 8.50457 9.60993 7.59536C9.1646 7.41936 8.77608 7.22425 8.37573 7.06119C7.94727 6.88688 7.60878 6.74072 7.18313 6.55123C6.57867 6.28302 3.77398 5.04204 3.53725 5.02236V3.77803C3.78297 3.79827 6.34531 4.97849 6.79346 5.17248L8.98299 6.12672C9.72408 6.43092 11.8625 7.51162 12.5108 7.51162C13.1552 7.51162 13.42 6.70642 13.0477 6.25378C12.8926 6.06429 12.5726 5.96645 12.323 5.86523C12.0919 5.77133 11.7939 5.60827 11.5279 5.54642C11.5279 2.90087 11.9024 3.85281 7.13813 1.7493C6.47632 1.45747 2.97891 -0.00448792 2.75906 1.03582e-05C1.91957 0.0163166 1.96568 0.827169 1.96568 1.28937Z" fill="#9EA4C9"/>
                                    </svg>
                                </div>
                                <div class="col-md-12 btn-blocks-txt">Бурение</div>
                            </div>
                            <div class="col btn-clk"onclick="myFunction('dev')">
                                <div class="btn-blocks">
                                    <svg style="height:180;" width="40" height="33" viewBox="0 0 40 33"  xmlns="http://www.w3.org/2000/svg">
                                        <path d="M22.999 33.9999H20.999L17.999 12.8499C17.9243 12.3568 17.4977 11.9942 16.999 11.9998H6.99902C6.49709 11.9949 6.06927 12.3629 5.99902 12.8599L2.99902 33.9999H0.999023C0.446739 33.9999 -0.000976562 34.4476 -0.000976562 34.9999C-0.000976562 35.5522 0.446739 35.9999 0.999023 35.9999H22.999C23.5513 35.9999 23.999 35.5522 23.999 34.9999C23.999 34.4476 23.5513 33.9999 22.999 33.9999ZM7.57902 15.9999L10.579 18.9999L6.57902 22.9999L7.57902 15.9999ZM8.38902 13.9999H15.589L11.999 17.5899L8.38902 13.9999ZM16.389 15.9999L17.389 22.9999L13.389 18.9999L16.389 15.9999ZM6.09902 26.3099L11.999 20.4199L17.889 26.3199L18.999 33.9999H4.99902L6.09902 26.3099Z" fill="#9EA4C9"/>
                                        <path d="M11.5792 10C11.6963 10.05 11.8219 10.0771 11.9492 10.08C12.0765 10.0771 12.2021 10.05 12.3192 10C13.687 9.48306 14.7145 8.32852 15.0692 6.91C15.7092 3.91 12.9692 0.72 12.6592 0.36C12.6213 0.336035 12.5811 0.315935 12.5392 0.3C12.4886 0.257364 12.4311 0.223559 12.3692 0.2C12.3095 0.191099 12.2489 0.191099 12.1892 0.2L11.9992 0H11.7992C11.737 0.00732566 11.6763 0.0241901 11.6192 0.05C11.5552 0.0755402 11.4947 0.109145 11.4392 0.15C11.4006 0.166106 11.3637 0.186216 11.3292 0.21C11.3292 0.21 11.3292 0.21 11.3292 0.27H11.2792C10.9592 0.63 8.27921 3.85 8.86921 6.82C9.18948 8.26373 10.2045 9.45484 11.5792 10ZM11.9992 2.66C12.6992 3.72 13.4592 5.25 13.1992 6.46C13.0317 7.09858 12.5933 7.63197 11.9992 7.92C11.4052 7.63197 10.9668 7.09858 10.7992 6.46C10.5292 5.26 11.2892 3.73 11.9992 2.66Z" fill="#9EA4C9"/>
                                    </svg>
                                </div>
                                <div class="col-md-12 btn-blocks-txt">Разработка</div>
                            </div>
                            <div class="col btn-clk" onclick="myFunction('dobycha')">
                                <div class="btn-blocks">
                                    <svg style="height:180;" width="40" height="43" viewBox="0 0 40 43"  xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M39.0188 36.8928H36.9765V27.8142C36.9765 27.5773 36.7529 27.382 36.48 27.382H34.1812V20.4453L34.4235 20.5326C34.5506 20.5761 34.6777 20.5997 34.8024 20.5997C35.1882 20.5997 35.56 20.398 35.7153 20.0639L37.1224 17.0868C37.2188 16.8723 37.2188 16.6345 37.1224 16.424C37.0235 16.2134 36.8259 16.0417 36.5859 15.9545L15.2306 8.20323C16.0118 6.89592 16.7129 5.56826 17.3153 4.25267C17.52 3.80886 17.2753 3.31019 16.7765 3.1286L8.34353 0.0661289C7.84235 -0.115463 7.26824 0.0897737 7.05176 0.524601C4.96235 4.81565 3.61412 9.59331 2.81412 15.566C2.76471 15.9509 3.01176 16.3205 3.41882 16.4666L7.03529 17.7803C7.44471 17.9293 7.91294 17.8203 8.18588 17.5162C9.75765 15.7729 11.1106 14.135 12.3294 12.5097L16.5929 14.0615L16.3835 15.3345L15.7482 19.1988L12.8353 36.8928H6.01412H0.988235C0.444706 36.8928 0 37.2825 0 37.7618V41.696C0 42.1718 0.444706 42.5605 0.988235 42.5605H39.0188C39.56 42.5605 40 42.1718 40 41.696V37.7618C40 37.2825 39.56 36.8928 39.0188 36.8928ZM32.203 27.3825H29.9065C29.6312 27.3825 29.4077 27.5778 29.4077 27.8147V36.8933H27.163L24.2524 19.1992L23.8406 16.6922L32.203 19.7284V27.3825ZM22.4487 21.5146L18.9781 19.2454L21.7381 17.198L22.4487 21.5146ZM21.2985 23.1264L16.8937 25.5833L17.6843 20.7676L21.2985 23.1264ZM22.9354 24.4621L23.9989 30.9041L18.2812 27.0571L22.9354 24.4621ZM18.6938 36.8918L24.3879 33.2801L24.9832 36.8918H18.6938ZM20.6367 15.5291L18.2531 17.2952L18.6602 14.8082L20.6367 15.5291ZM16.4517 28.2215L22.3764 32.2101L15.0281 36.8816L16.4517 28.2215Z" />
                                    </svg>
                                </div>
                                <div class="col-md-12 btn-blocks-txt">Добыча</div>
                            </div>
                            <div class="col btn-clk"onclick="myFunction('ob')">
                                <div class="btn-blocks">
                                    <svg style="height:180;" width="40" height="35" viewBox="0 0 40 35"  xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M37.3407 9.97748C35.8726 9.97748 34.6814 11.1703 34.6814 12.6412V13.071H23.7701V9.96996C23.7701 9.55102 23.4377 9.21754 23.0194 9.21754H21.9141V5.76691H28.2825C29.8615 5.76691 31.1385 4.4714 31.1385 2.8861C31.1385 1.29579 29.8615 0 28.2825 0H11.7175C10.1413 0 8.86704 1.29579 8.86704 2.8861C8.86704 4.4714 10.1413 5.76691 11.7175 5.76691H18.0914V9.21754H16.9806C16.5679 9.21754 16.2355 9.55102 16.2355 9.96996V13.071H5.29363V12.6412C5.29363 11.1703 4.13019 9.97748 2.65928 9.97748C1.19391 9.97748 0 11.1703 0 12.6412V31.9631C0 33.4329 1.19391 34.6249 2.65928 34.6249C4.13019 34.6249 5.29363 33.4329 5.29363 31.9631V31.5325H34.6814V31.9631C34.6814 33.4329 35.8726 34.6249 37.3407 34.6249C38.8089 34.6249 40 33.4329 40 31.9631V12.6412C40 11.1703 38.8089 9.97748 37.3407 9.97748Z" />
                                    </svg>
                                </div>
                                <div class="col-md-12 btn-blocks-txt">Обустройство</div>
                            </div>
                            <div class="col btn-clk"onclick="myFunction('eco')">
                                <div class="btn-blocks">
                                    <svg style="height:180;" width="40" height="35" viewBox="0 0 40 35"  xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 0V5.08513H25.4257V0H0Z" fill="#9EA4C9"/>
                                        <path d="M0 8.28809V13.3732H10.1703V32.0006H15.2554V13.3732H25.4257V8.28809H0Z" fill="#9EA4C9"/>
                                    </svg>
                                </div>
                                <div class="col-md-12 btn-blocks-txt">Экономика</div>
                            </div>
                        </div>
                        
                        {{-- <div id="noitems"  class="col-md-12 col-lg-12 row" >
                        <p class="col-md-12"> no items </p>
                        </div> --}}
                       
                       
                       

                        <!--    <div id="izbr" hidden="hidden" class="col-md-12 col-lg-12 row menu-items" >
                                <button onclick="document.location='{{url('/')}}/ru/mzdn'" type="button" class="col-md-2 col-lg-2 btn report-btn">Отчёт по месячной замерной добычи нефти</button>
                                <button onclick="document.location='{{url('/')}}/ru/gtm'" type="button" class="col-md-2 col-lg-2 btn report-btn">Анализ эффективности ГТМ</button> 
                                {{-- <button disabled onclick="document.location='{{url('/')}}/ru/constructor'" type="button" class="col-md-2 col-lg-2 btn report-btn">Ежедневная динамика показателей добычи по скважинам</button> 
                                <button disabled onclick="document.location='{{url('/')}}/ru/constructor'" type="button" class="col-md-2 col-lg-2 btn report-btn">Ежедневная динамика показателей закачки по скважинам</button>         --}}
                            </div>
                            <div id="dobycha" hidden="hidden" class="col-md-12 col-lg-12 row menu-items" >
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
                                <button onclick="document.location='{{url('/')}}/ru/dob'" type="button" class="col-md-2 col-lg-2 btn report-btn">Ежедневная динамика показателей добычи по скважинам</button> 
                                <button disabled onclick="document.location='{{url('/')}}/ru/constructor'" type="button" class="col-md-2 col-lg-2 btn report-btn">Ежедневная динамика показателей закачки по скважинам</button>        
                            </div>  -->

                    </div>
                </div>
            </div>

            <div class="reportsBut">
                <div id="izbr" hidden class="menu-items">
                <button onclick="document.location='{{url('/')}}/ru/mzdn'" type="button" class="col-md-2 col-lg-2 btn report-btn">Отчёт по месячной замерной добычи нефти</button>
                <button onclick="document.location='{{url('/')}}/ru/gtm'" type="button" class="col-md-2 col-lg-2 btn report-btn">Анализ эффективности ГТМ</button> 
                <button disabled onclick="document.location='{{url('/')}}/ru/constructor'" type="button" class="col-md-2 col-lg-2 btn report-btn" hidden>Месячный экс рапорт</button> 
                <button disabled onclick="document.location='{{url('/')}}/ru/constructor'" type="button" class="col-md-2 col-lg-2 btn report-btn" hidden>Расшифровка фонда скважин</button> 
                <button disabled onclick="document.location='{{url('/')}}/ru/constructor'" type="button" class="col-md-2 col-lg-2 btn report-btn" hidden>Расшифровка фонда скважин по блокам</button> 
                <button disabled onclick="document.location='{{url('/')}}/ru/constructor'" type="button" class="col-md-2 col-lg-2 btn report-btn" hidden>Расшифровка фонда скважин по месторождениям</button> 
                <button disabled onclick="document.location='{{url('/')}}/ru/constructor'" type="button" class="col-md-2 col-lg-2 btn report-btn" hidden>Ревизия фонда скважин</button> 
                <button disabled onclick="document.location='{{url('/')}}/ru/constructor'" type="button" class="col-md-2 col-lg-2 btn report-btn" hidden>Ревизия фонда скважин по месторождениям</button> 
                <button disabled onclick="document.location='{{url('/')}}/ru/constructor'" type="button" class="col-md-2 col-lg-2 btn report-btn" hidden>Расшифровка бездействующего фонда скважин</button> 
                <button disabled onclick="document.location='{{url('/')}}/ru/constructor'" type="button" class="col-md-2 col-lg-2 btn report-btn" hidden>Отчет по месячной замерной закаче воды</button> 
                <button disabled onclick="document.location='{{url('/')}}/ru/constructor'" type="button" class="col-md-2 col-lg-2 btn report-btn" hidden>Ежедневная динамика показателей добычи по скважинам</button> 
                <button disabled onclick="document.location='{{url('/')}}/ru/constructor'" type="button" class="col-md-2 col-lg-2 btn report-btn" hidden>Ежедневная динамика показателей закачки по скважинам</button> 
                </div>

                {{-- <div id="geo" hidden>No data</div>
                <div id="bur" hidden>No data</div>
                <div id="dev" hidden>No data</div> --}}

                <div id="dobycha" hidden class="menu-items">
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
                <button onclick="document.location='{{url('/')}}/ru/dob'" type="button" class="col-md-2 col-lg-2 btn report-btn">Ежедневная динамика показателей добычи по скважинам</button> 
                <button disabled onclick="document.location='{{url('/')}}/ru/constructor'" type="button" class="col-md-2 col-lg-2 btn report-btn">Ежедневная динамика показателей закачки по скважинам</button> 
                </div>

                {{-- <div id="ob" hidden>No data</div>
                <div id="eco" hidden>No data</div> --}}

            </div>
    
            {{-- <div class="col-2 bg-dark">
                <div class="bg-dark" style="height: 100%;">
                    <div class="right-title">Форма отчета</div>

        <button disabled onclick="document.location='{{url('/')}}/ru/constructor'" type="button" class="col-md-2 col-lg-2 btn report-btn">Анализ эффективности ГТМ</button> 

        <button onclick="document.location='{{url('/')}}/ru/gtm'" type="button" class="col-md-2 col-lg-2 btn report-btn">Анализ эффективности ГТМ</button> 

        <button disabled onclick="document.location='{{url('/')}}/ru/constructor'" type="button" class="col-md-2 col-lg-2 btn report-btn">Месячный экс рапорт</button>  --}}

@endsection

<script>
    function myFunction(data) {
        console.log(data);
      var clk = data;
      var izbr = document.getElementById("izbr");
      var dobycha = document.getElementById("dobycha");
    //   var a = document.getElementsByClassName('menu-items');
    //   var active = document.getElementsByClassName("btn-blocks");
      if (clk === "izbr" && izbr.hasAttribute("hidden") === true) {
        izbr.removeAttribute("hidden");
        dobycha.setAttribute("hidden", "hidden");
      } 
      else if (clk === "dobycha" && dobycha.hasAttribute("hidden") === true){
        dobycha.removeAttribute("hidden");
        izbr.setAttribute("hidden", "hidden");
      }
    //   else if (clk === "geo"){

    //   }
    //   else if(clk)
    //   {
    //     izbr.setAttribute("hidden", "hidden");
    //     dobycha.setAttribute("hidden", "hidden");
    //   }
    }
</script>

<style>

#app{
    bottom: 20px;
    left: 50px;
}
.row{
    top:20px;
}
.center-content {
    width: 1822px;
    height: 364px;
}
.p-4{
        background-color: #0F1430;
        position: relative;
        left: 18px;
        width: 2300px;
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
    padding: 18px 22px 16px 20px;

}
.input-group-F {
    width:91%;

}
.form-control, .fix-rounded-right {
    border-top-left-radius: 20px!important;
    border-bottom-left-radius: 20px!important;
    height: 40!important;
    background: #393D75!important;
    border: none!important;
}
.input-group-text{
    font-family: Harmonia Sans Pro Cyr;
    padding-left: 40px!important;
    padding-right: 40px!important;
    color: white!important;
    background: #3366FF!important;
    border: none!important;
    border-top-right-radius: 20px!important;
    border-bottom-right-radius: 20px!important;
}
.input-group-append{
    
    background: #393d75;
    border-top-right-radius: 20px!important;
    border-bottom-right-radius: 20px!important;

}
.right-title{
    font-size: 20px;
    padding-top: 15px;
}
/* .line{ */
    /* Line 1 */
/* border: 2px solid #333975;
transform: rotate(180deg);
margin-top: 50px;
margin-bottom: 50px;
margin-right: 50px;
margin-left: 50px;
} */
.center-content{
    background:#272953;
    left: 15px;
}
.btn-blocks{
    background: #333975;
    fill:#9EA4C9!important;
    margin: 25px;
    text-align: center;
    height: 180px;
    border-radius: 20px;
}
.btn-blocks:hover{
    background: #334296;
    fill:#FEFEFE!important;
}
/* .btn-blocks, .active{
    background: #334296;
    fill:#FEFEFE!important;
} */
.btn-blocks-icon{
    fill: #393D75;
}
.btn-blocks-icon:hover{
    fill: #FEFEFE;
}

.btn-blocks-txt{
    text-align: center;
    font-size: 20px;
    color: FFFFFF;
}
.btn-clk{
    cursor: pointer;
    top: 50px;
    right: 20px;
}
.report-btn {
    border-top-right-radius: 20px!important;
    border-bottom-right-radius: 20px!important;
    border-top-left-radius: 20px!important;
    border-bottom-left-radius: 20px!important;
    background: #1F2142;
    ju;
    
}
</style>

{{-- <script>
function myFunction2() {
  var a = document.getElementById("izbr");
  var b = document.getElementById("noitems");
  var b = document.getElementById("noitems");
//   var active = document.getElementsByClassName("btn-blocks");
  if (a.hasAttribute("hidden") === false) {
    a.setAttribute("hidden", "hidden");
    b.removeAttribute("hidden");
  } else {
    a.removeAttribute("hidden");
    // active.classList.toggle("active");
    b.setAttribute("hidden", "hidden");
  }
}
</script> --}}

<style>

.fixed-columns {
    left: 0;
    background: #20274e!important;
}
    .p-4{
        background-color: #0F1430;
    }
    .fixed-table-container{
        background: #20274e;
    }
   
    .bootstrap-table .fixed-table-container .table {

    color: white;
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
    .table-hover tbody tr:hover 
    {
    color: #d4d4d4 !important;
    background-color: rgba(0, 0, 0, 0.075);
}

.contentTitle {
    font-family: Harmonia Sans Pro Cyr;
    font-size: 20px;
    color: FFFFFF;
    padding: 25px 73px;
    display: flex;
    width: 30px;
    height: 15px;
    margin: 0;
    padding: 0;
    
}

.reportsBut {
    width: 1846.66px;
    position: absolute;
    /* left: 40px; */
    top: 520px;
    left: 30px;
    /* right: 201px; */
    background-color: #272953;
}

</style>
