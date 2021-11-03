<template>
    <div>
        <div class="d-grid">
            <div class="tkrs-indicator-item flex-fill d-inline-block p-2" >
                <div class="big-number-block-first">
                    <div class="bigNumber"><span class="units">14</span><a class="bigNumberText">{{trans('tkrs.brigad')}}</a>
                        
                    </div>
                    <div class="title">
                        <img src="/img/tkrs/total_amount.svg" 
                            alt=""
                        >
                        {{trans('tkrs.total_amount')}}
                    </div>
                </div>
                <div class="vert-line">
                </div>
                <div class="big-number-block-second">
                    <div class="contractors-block">
                        <div class="contractors-list-big-number">{{trans('tkrs.сontractors')}}</div>
                        <div class="const-name-notify"><div class="contractors-name-big-number">1.ТОО "Жанрос Дриллинг"<a class="green-notify">10</a></div></div>
                        <div class="const-name-notify"><div class="contractors-name-big-number">2.ТОО "Frac Jet"<a class="green-notify">4</a></div></div>
                    </div>
                    <div class="contractors-list-big-number">{{trans('tkrs.formation_date')}} 15.08.2021</div>
                </div>
            
            </div>
            <div class="tkrs-indicator-item children flex-fill d-inline-block p-2" >
                <div class="big-number-block-first">
                    <div class="bigNumber"><span class="units">14</span><a class="bigNumberText">{{trans('tkrs.brigad')}}</a>
                        
                    </div>
                    <div class="title">
                        <img src="/img/tkrs/in_work.svg" 
                            alt=""
                        >
                        {{trans('tkrs.in_work')}}
                    </div>
                </div>
                <div class="vert-line">
                </div>
                <div class="big-number-block-second">
                    <div class="contractors-block">
                        <div class="contractors-list-big-number">{{trans('tkrs.сontractors')}}</div>
                        <div class="const-name-notify"><div class="contractors-name-big-number">1.ТОО "Жанрос Дриллинг"<a class="green-notify">10</a></div></div>
                        <div class="const-name-notify"><div class="contractors-name-big-number">2.ТОО "Frac Jet"<a class="green-notify">4</a></div></div>
                    </div>
                    <div class="contractors-list-big-number">{{trans('tkrs.formation_date')}} 15.08.2021</div>
                </div>
            
            </div>
            <div class="tkrs-indicator-item children flex-fill d-inline-block p-2" >
                <div class="big-number-block-first">
                    <div class="bigNumber"><span class="units">14</span><a class="bigNumberText">{{trans('tkrs.brigad')}}</a>
                        
                    </div>
                    <div class="title">
                        <img src="/img/tkrs/in_idle.svg" 
                            alt=""
                        >

                        {{trans('tkrs.in_idle')}}
                    </div>
                </div>
                <div class="vert-line">
                </div>
                <div class="big-number-block-second">
                    <div class="contractors-block">
                        <div class="contractors-list-big-number">{{trans('tkrs.сontractors')}}</div>
                        <div class="const-name-notify"><div class="contractors-name-big-number">1.ТОО "Жанрос Дриллинг"<a class="green-notify">10</a></div></div>
                        <div class="const-name-notify"><div class="contractors-name-big-number">2.ТОО "Frac Jet"<a class="green-notify">4</a></div></div>
                    </div>
                    <div class="contractors-list-big-number">{{trans('tkrs.formation_date')}} 15.08.2021</div>
                </div>
            
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        
    },
    data: function () {
        return {};
    },
}
</script>
<style scoped>
.tkrs-indicator-item {
    background: #20274F;
    display: flex !important;
    
}
.children {
    margin-left: 10px;
}
.units {
    color: white;
    font-size: 3rem;
    font-weight: 700;
    margin: 0;
}
.bigNumberText {
    color: #82BAFF;
    margin-left: 10px;
    
}
.title {
    margin-left: 4px;
    width: 101%;
}
.d-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
}
.vert-line {
    border-right: 1px solid #545580;
    margin-left: 6%;
}
.big-number-block-second {
    margin-left: 1%;
}
.contractors-list-big-number {
    color: #999DC0;
    font-size: 14px;
}
.contractors-name-big-number {
    color:#fff;
    font-size: 17px;
}
.contractors-block {
    background: #292A59;
    width: 95%;
}
.green-notify {
    background: #009847
;
    color: #fff;
        margin-left: 4px;
}
.const-name-notify {
    display: flex;
}
</style>