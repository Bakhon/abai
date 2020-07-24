<template>
<div class="right-side">
	<div class="circle1 circle" >
						<div class="point"></div>
						Добыча нефти и конденсата
						<canvas id="chart-area1" ></canvas>
						<div class="org-name11 rectangle2"> «КазГерМунай»: 10,9 тыс. тонн</div>
						</div>
						
	<div class="circle2 circle">
						<div class="point"></div>
						Добыча природного газа										
						<canvas id="chart-area2"  ></canvas>
						<div class="org-name22 rectangle2">ЭмбаМунайГаз: 0,02 млрд. м3 </div>	
						</div>
						</div>
</template>


<script>


  		
		var config = {
			type: 'doughnut',
			data: {
				datasets: [{
					data: [
						'1',
						'2',
						'3',
						'7',
						'5',
						'6',
						'4',
					],
					backgroundColor: [
					'#FF9769',
              '#F7BB2E',
              '#00A0E3',
              '#A3A0FB',
              '#E06765',
              '#3B86FF',
              '#13B062',
					],
					label: 'Dataset 1'
				}],
				labels: [
'ТОО «Казахтуркмунай»',
'ТОО «Казахойл Актобе»',
'АО «ЭмбаМунайГаз»',
'ТОО «КазГерМунай»',
'АО «Мангистаумунайгаз»',
'АО «ОзенМунайГаз»',
'АО «Каражанбасмунай»',

				]
			},
			options: {
						aspectRatio: true,
	responsive:false,
    legend: {
        display: false
    },
    tooltips: {
        callbacks: {
         /*  label: function(tooltipItem) {
                  return tooltipItem.yLabel;
           }*/
        }
    }
}
		};
		
		
						
		
		var config2 = {
			type: 'doughnut',
			data: {
				datasets: [{
					data: [
						'1',
						'2',
						'3',
						'4',
						'5',
						'6',
						'7',
					],
					backgroundColor: [
			'#FF9769',
              '#F7BB2E',
              '#00A0E3',
              '#A3A0FB',
              '#E06765',
              '#3B86FF',
              '#13B062',
					],
					label: 'Dataset 1'
				}],
				labels: [
'ТОО «Казахтуркмунай»',
'ТОО «Казахойл Актобе»',
'АО «ЭмбаМунайГаз»',
'АО «Каражанбасмунай»',
'АО «Мангистаумунайгаз»',
'АО «ОзенМунайГаз»',
'ТОО «КазГерМунай»',
				]
			},
			options: {
	aspectRatio: true,
	responsive:false,
    legend: {
        display: false
    },
    tooltips: {
        callbacks: {
         /*  label: function(tooltipItem) {
                  return tooltipItem.yLabel;
           }*/
        }
    }
}
		};
		
		
		window.onload = function() {
			var ctx = document.getElementById('chart-area1').getContext('2d');
			window.myPie = new Chart(ctx, config);
			
			var ctx = document.getElementById('chart-area2').getContext('2d');
			window.myPie = new Chart(ctx, config);
			
			var ctx = document.getElementById('chart-area3').getContext('2d');
			window.myPie = new Chart(ctx, config2);
			
			var ctx = document.getElementById('chart-area4').getContext('2d');
			window.myPie = new Chart(ctx, config2);
						}
	
</script>