<!-- Sidebar -->
<div id="sidebar-container" class="sidebar-expanded d-none d-md-block">
    <div>
        <visual-center-menu></visual-center-menu>
    </div>
    <div class="left-price-oil">
        <div class="left-price-oil2">Цена за нефть <div class="price-border ">43.1 $</div>
        </div>
        <hr class="hr-visualcenter">
        <visual-center-chart-area-oil></visual-center-chart-area-oil>
        <hr class="hr-visualcenter">
        <ul class="oil-string-all">
            <li class="oil-string one">Нефть Brent</li>
            <li class="oil-string two">41,65</li>
            <li class="oil-string three">+0,60</li>
            <li class="oil-string three">+1,46%</li>
        </ul>
        <hr class="hr-visualcenter">
        <ul class="oil-string-all">
            <li class="oil-string one">Нефть WTI</li>
            <li class="oil-string two">41,65</li>
            <li class="oil-string three">+0,60</li>
            <li class="oil-string three">+1,46%</li>
        </ul>
        <hr class="hr-visualcenter">
        <ul class="oil-string-all">
            <li class="oil-string one">Нефть Urals</li>
            <li class="oil-string two">41,65</li>
            <li class="oil-string three">+0,60</li>
            <li class="oil-string three">+1,46%</li>
        </ul>
        <hr class="hr-visualcenter">
    </div>
    <div class="assets3"></div>
    <div class="left-price-oil">
        <div class="left-price-oil2">

            <? function getRates(){
$url = "http://www.nationalbank.kz/rss/rates_all.xml";
$dataObj = simplexml_load_file($url);
    if ($dataObj){
    foreach ($dataObj->channel->item as $item){
        if ($item->title=='USD'){
        return $item->description;    
        /*echo "title: ".$item->title."<br>";
        echo "pubDate: ".$item->pubDate."<br>";
        echo "quant: ".$item->quant."<br>";
        echo "index: ".$item->index."<br>";
        echo "change: ".$item->change."<br>";*/
    }
    }
}
}
?>
            Курс доллара <div class="price-border "><?= getRates() ?> &#8376;</div>
        </div>
        <ul class="oil-string-all">
            <li class="oil-string one2 width-price">1 казахстанский тенге равно</li>
            <li class="oil-string two2">1</li>
            <li class="oil-string three2">Тенге</li>
        </ul>
        <ul class="oil-string-all">
            <li class="oil-string one2-2 width-price">Доллар США</li>
            <li class="oil-string two2"> <?= round('1' / getRates(), 4); ?>
                <!--0,0025-->
            </li>
            <li class="oil-string three2">Доллар</li>
        </ul>
        <visual-center-chart-area-usd></visual-center-chart-area-usd>
    </div>
</div><!-- sidebar-container END -->