<template>

<div class="flex-container">
	{{ inDevelopNotify() }}
	<div class="flex__item__block__1">
		<div class="title__block">Число качаний</div>
			
			<div class="flex__item__block__first__block">
				<div class="block__text">Минимум</div>
				<input class="square2 block__1__input" type="text">

				<div class="block__text__1">Максимум</div>
				<input class="square2 block__2__input" type="text">
			</div>

		
	</div>

	<div class="flex__item__block__1">
		<div class="title__block">Длина кода</div>
		
			<div class="flex__item__block__second__block">
				<div class="block__text__2">Минимум</div>
				<input class="square2 block__3__input" type="text">

				<div class="block__text__3">Максимум</div>
				<input class="square2 block__4__input" type="text">
			</div>

	</div>
	
	<div class="flex__item__block__2">
		<div class="title__block">К под</div>
			<div class="flex__item__block__first__block">
				<div class="block__text">Минимум</div>
				<input class="square2 block__1__input" type="text">

				<div class="block__text__1">Максимум</div>
				<input class="square2 block__2__input" type="text">
			</div>
	</div>

	<div class="flex__item__block__2">
		<div class="title__block">Диаметр насосов, мм</div>
		<div class="flex__item__block__second__block">
				 	<div class="form__checkbox block__checkbox__1">
						<label for="checkbox1" class="checkbox__block__label__1">27</label>
                        <input class="checkbox__block__1" type="checkbox" />
            		</div>

					<div class="form__checkbox block__checkbox__2">
						<label for="checkbox1" class="checkbox__block__label__1">32</label>
                        <input class="checkbox__block__1" type="checkbox" />
            		</div>

					<div class="form__checkbox block__checkbox__3">
						<label for="checkbox1" class="checkbox__block__label__1">38</label>
                        <input class="checkbox__block__1" type="checkbox" />
            		</div>

					<div class="form__checkbox block__checkbox__4">
						<label for="checkbox1" class="checkbox__block__label__1">44</label>
                        <input class="checkbox__block__1" type="checkbox" />
            		</div>

					<div class="form__checkbox block__checkbox__5">
						<label for="checkbox1" class="checkbox__block__label__1">50</label>
                        <input class="checkbox__block__1" type="checkbox" />
            		</div>

					<div class="form__checkbox block__checkbox__6">
						<label for="checkbox1" class="checkbox__block__label__1">57</label>
                        <input class="checkbox__block__1" type="checkbox" />
            		</div>

					<div class="form__checkbox block__checkbox__7">
						<label for="checkbox1" class="checkbox__block__label__1">60</label>
                        <input class="checkbox__block__1" type="checkbox" />
            		</div>

					<div class="form__checkbox block__checkbox__8">
						<label for="checkbox1" class="checkbox__block__label__1">70</label>
                        <input class="checkbox__block__1" type="checkbox" />
            		</div>

					<div class="form__checkbox block__checkbox__9">
						<label for="checkbox1" class="checkbox__block__label__1">95	</label>
                        <input class="checkbox__block__1" type="checkbox" />
            		</div>
			</div>
	</div>

	<div class="flex__item__block__3">
		<div class="title__block__3__1">Группа посадки</div>
		<div class="title__block__3__2">Конструкция колонны штанг</div>
		<div class="title__block__3__3">Диаметры штанг, мм</div>

			<div class="flex__item__block__third__block">
				<label for="" class="block__third__block__radio">1
					<input value="bhp" class="third__block__radio" type="radio" name="set2" />
				</label>

				<label for="" class="block__third__block__radio__1">2
					<input value="bhp" class="third__block__radio" type="radio" name="set2" />
				</label>

				<label for="" class="block__third__block__radio__2">3
					<input value="bhp" class="third__block__radio" type="radio" name="set2" />
				</label>

				<label for="" class="block__third__block__radio__3">4
					<input value="bhp" class="third__block__radio" type="radio" name="set2" />
				</label>

				<label for="" class="block__third__block__radio__4">5
					<input value="bhp" class="third__block__radio" type="radio" name="set2" />
				</label>

				<label for="" class="block__third__block__radio__5">Расчет
					<input value="bhp" class="third__block__radio" type="radio" name="set2" />
				</label>	
			</div>

			<div class="flex__item__block__third__block__1">
				<label for="" class="block__third__block__1__radio">1 ступ
					<input value="bhp" class="third__block__radio" type="radio" name="set2" />
				</label>

				<label for="" class="block__third__block__1__radio__1">2 ступ
					<input value="bhp" class="third__block__radio" type="radio" name="set2" />
				</label>

				<label for="" class="block__third__block__1__radio__2">3 ступ
					<input value="bhp" class="third__block__radio" type="radio" name="set2" />
				</label>

				<label for="" class="block__third__block__1__radio__3">Тяж низ
					<input value="bhp" class="third__block__radio" type="radio" name="set2" />
				</label>
			</div>

			<div class="flex__item__block__third__block__2">
					<div class="form__checkbox block__checkbox__1">
						<label for="checkbox1" class="checkbox__block__label__1">27</label>
                        <input class="checkbox__block__1" type="checkbox" />
            		</div>

					<div class="form__checkbox block__checkbox__2">
						<label for="checkbox1" class="checkbox__block__label__1">32</label>
                        <input class="checkbox__block__1" type="checkbox" />
            		</div>

					<div class="form__checkbox block__checkbox__3">
						<label for="checkbox1" class="checkbox__block__label__1">38</label>
                        <input class="checkbox__block__1" type="checkbox" />
            		</div>

					<div class="form__checkbox block__checkbox__4">
						<label for="checkbox1" class="checkbox__block__label__1">44</label>
                        <input class="checkbox__block__1" type="checkbox" />
            		</div>

					<div class="form__checkbox block__checkbox__5">
						<label for="checkbox1" class="checkbox__block__label__1">50</label>
                        <input class="checkbox__block__1" type="checkbox" />
            		</div>

					<div class="form__checkbox block__checkbox__6">
						<label for="checkbox1" class="checkbox__block__label__1">57</label>
                        <input class="checkbox__block__1" type="checkbox" />
            		</div>
			</div>
	</div>

	<div class="flex__item__block__4">
		<div class="title__block__4__1">Марки стали штанг</div>
		<div class="flex__item__block__fourth__block">

					<div class="form__checkbox__1 block__1__checkbox__1">
						<label for="checkbox1" class="checkbox__block__label__1">40</label>
                        <input class="checkbox__block__1" type="checkbox" />
            		</div>

					<div class="form__checkbox__1 block__1__checkbox__2">
						<label for="checkbox1" class="checkbox__block__label__1">20H2М</label>
                        <input class="checkbox__block__1" type="checkbox" />
            		</div>

					<div class="form__checkbox__1 block__1__checkbox__3">
						<label for="checkbox1" class="checkbox__block__label__1">30XM(A)</label>
                        <input class="checkbox__block__1" type="checkbox" />
            		</div>

					<div class="form__checkbox__1 block__1__checkbox__4">
						<label for="checkbox1" class="checkbox__block__label__1">15H3MA</label>
                        <input class="checkbox__block__1" type="checkbox" />
            		</div>

					<div class="form__checkbox__1 block__1__checkbox__5">
						<label for="checkbox1" class="checkbox__block__label__1">15X2HMФ</label>
                        <input class="checkbox__block__1" type="checkbox" />
            		</div>

					<div class="form__checkbox__1 block__1__checkbox__6">
						<label for="checkbox1" class="checkbox__block__label__1">15X2ГМФ</label>
                        <input class="checkbox__block__1" type="checkbox" />
            		</div>

					<div class="form__checkbox__1 block__1__checkbox__7">
						<label for="checkbox1" class="checkbox__block__label__1">14X3ГМЮ</label>
                        <input class="checkbox__block__1" type="checkbox" />
            		</div>

					<div class="form__checkbox__1 block__1__checkbox__8">
						<label for="checkbox1" class="checkbox__block__label__1">АЦ28ХГН3ФТ</label>
                        <input class="checkbox__block__1" type="checkbox" />
            		</div>

		</div>
	</div>	

	<div class="flex__item__block__5">
		<div class="title__block__5__1">Коррозионность добываемой продукции</div>
		<div class="title__block__5__2">Подбор глубины спуска в окне Инклинометрия</div>

		<div class="flex__item__block__fifth__block">
			<label for="" class="block__fourth__block__radio">Некоррозионная
			<input value="bhp" class="third__block__radio" type="radio" name="set2" />
			</label>

			<label for="" class="block__fourth__block__radio__1">Среднекоррозионная
			<input value="bhp" class="third__block__radio" type="radio" name="set2" />
			</label>

			<label for="" class="block__fourth__block__radio__2">Высококоррозионная
			<input value="bhp" class="third__block__radio" type="radio" name="set2" />
			</label>
		</div>
		<div class="flex__item__block__fifth__block__1">
			<div class="block__text__4">Минимум</div>
			<input class="square2 block__5__input" type="text">
		</div>	
	</div>

	<div class="flex__item__block__6">
		<div class="title__block__6__1">Потенциальный режим</div>

			<div class="flex__item__block__sixth__block">
				<div class="block__text__5">Давление на приеме насоса минимальное</div>
			<input class="square2 block__6__input" type="text">

			<div class="block__text__6">Газосодержание в насосе максимальное</div>
			<input class="square2 block__7__input" type="text">
			</div>
	</div>
	<notifications position="top"></notifications>
</div>

</template>

<script>
import NotifyPlugin from "vue-easy-notify";

Vue.use(NotifyPlugin);
export default {
	data: function()  {
		return {

		}
	},
	methods: {
		inDevelopNotify() {
      		setTimeout(this.inDeveloping, 1000)
    	},
		inDeveloping() {
			this.$notify({
          	message: this.trans('в разработке'),
          	type: 'error',
          	size: 'sm',
          	timeout: 8000
        })
		}
	}
}
</script>

<style scoped>
.flex-container {
  padding: 0;
  margin: 0;
  height: 520px;
  list-style: none;
  display: -webkit-box;
  display: -moz-box;
  display: -ms-flexbox;
  display: -webkit-flex;
  display: flex;
  flex-wrap: wrap;
  justify-content: space-around;
}

.flex__item__block__1 {
  background-color: #272953;
  padding: 5px;
  width: 490px;
  height: 80px;
  margin-top: 10px;
  position: relative;
  left: 0px;
  line-height: 10px;
  color: white;
  font-weight: bold;
  font-size: 1em;
  text-align: center;
}

.flex__item__block__2 {
  background-color: #272953;
  padding: 5px;
  width: 490px;
  height: 80px;
  margin-top: 10px;
  position: relative;
  top: -5px;
  left: 0px;
  line-height: 10px;
  color: white;
  font-weight: bold;
  font-size: 1em;
  text-align: center;
}

.flex__item__block__3 {
  background-color: #272953;
  padding: 5px;
  width: 980px;
  height: 80px;
  margin-top: 10px;
  position: relative;
  top: -10px;
  left: 0px;
  line-height: 10px;
  color: white;
  font-weight: bold;
  font-size: 1em;
  text-align: center;
}

.flex__item__block__4 {
  background-color: #272953;
  padding: 5px;
  width: 980px;
  height: 80px;
  margin-top: 10px;
  position: relative;
  top: -15px;
  left: 0px;
  line-height: 10px;
  color: white;
  font-weight: bold;
  font-size: 1em;
  text-align: center;
}

.flex__item__block__5 {
  background-color: #272953;
  padding: 5px;
  width: 980px;
  height: 80px;
  margin-top: 10px;
  position: relative;
  top: -20px;
  left: 0px;
  line-height: 10px;
  color: white;
  font-weight: bold;
  font-size: 1em;
  text-align: center;
}

.flex__item__block__6 {
  background-color: #272953;
  padding: 5px;
  width: 980px;
  height: 80px;
  margin-top: 10px;
  position: relative;
  top: -23px;
  left: 0px;
  line-height: 10px;
  color: white;
  font-weight: bold;
  font-size: 1em;
  text-align: center;
}

.title__block {
	position: relative;
	height: 20px;
	left: 10px;
	text-align: left;
}

.title__block__3__1 {
	text-align: left;
	position: relative;
	height: 20px;
	left: 10px;
	width: 150px;
}

.title__block__3__2 {
	text-align: left;
	position: relative;
	height: 20px;
	left: 420px;
	width: 200px;
	top: -20px;
}

.title__block__3__3 {
	text-align: left;
	position: relative;
	height: 20px;
	left: 750px;
	width: 200px;
	top: -40px;
}

.title__block__4__1 {
	text-align: left;
	position: relative;
	height: 20px;
	left: 10px;
	width: 200px;
	top: 0px;
}

.title__block__5__1 {
	text-align: left;
	position: relative;
	height: 20px;
	left: 10px;
	width: 300px;
	top: 0px;
}

.title__block__5__2 {
	text-align: left;
	position: relative;
	height: 20px;
	left: 570px;
	width: 350px;
	top: -20px;
}

.title__block__6__1 {
	text-align: left;
	position: relative;
	height: 20px;
	left: 10px;
	width: 300px;
	top: 0px;
}

.flex__item__block__first__block {
	height: 42px;
	width: 480px;
	background-color: #2b2e5e;
}

.flex__item__block__second__block {
	height: 42px;
	width: 480px;
	background-color: #2b2e5e;
	position: relative;
}

.flex__item__block__third__block {
	height: 42px;
	width: 330px;
	background-color: #2b2e5e;
	position: relative;
	top: -40px;
}

.flex__item__block__third__block__1 {
	height: 42px;
	width: 310px;
	background-color: #2b2e5e;
	position: relative;
	top: -82px;
	left: 340px;
}

.flex__item__block__third__block__2 {
	height: 42px;
	width: 310px;
	background-color: #2b2e5e;
	position: relative;
	top: -124px;
	left: 660px;
}


.flex__item__block__fourth__block {
	height: 42px;
	width: 780px;
	background-color: #2b2e5e;
	position: relative;
	top: 0px;
	left: 0px;
}

.flex__item__block__fifth__block {
	height: 42px;
	width: 550px;
	background-color: #2b2e5e;
	position: relative;
	top: -20px;
	left: 0px;
}

.flex__item__block__fifth__block__1 {
	height: 42px;
	width: 230px;
	background-color: #2b2e5e;
	position: relative;
	top: -62px;
	left: 560px;
}

.flex__item__block__sixth__block {
	height: 42px;
	width: 940px;
	background-color: #2b2e5e;
	position: relative;
	top: 0px;
	left: 0px;
}


.block__third__block__radio {
	display: block;
	width: 50px;
	height: 20px;
	position: relative;
	top: 15px;
}

.block__third__block__radio__1 {
	display: block;
	width: 50px;
	height: 20px;
	position: relative;
	top: -13px;
	left: 45px;
}

.block__third__block__radio__2 {
	display: block;
	width: 50px;
	height: 20px;
	position: relative;
	top: -41px;
	left: 95px;
}

.block__third__block__radio__3 {
	display: block;
	width: 50px;
	height: 20px;
	position: relative;
	top: -69px;
	left: 140px;
}

.block__third__block__radio__4 {
	display: block;
	width: 50px;
	height: 20px;
	position: relative;
	top: -97px;
	left: 190px;
}

.block__third__block__radio__5 {
	display: block;
	width: 70px;
	height: 20px;
	position: relative;
	top: -125px;
	left: 250px;
}

.block__third__block__1__radio {
	display: block;
	width: 70px;
	height: 20px;
	position: relative;
	top: 15px;
	left: 5px;
}

.block__third__block__1__radio__1 {
	display: block;
	width: 70px;
	height: 20px;
	position: relative;
	top: -12px;
	left: 80px;
}

.block__third__block__1__radio__2 {
	display: block;
	width: 70px;
	height: 20px;
	position: relative;
	top: -40px;
	left: 155px;
}

.block__third__block__1__radio__3 {
	display: block;
	width: 70px;
	height: 20px;
	position: relative;
	top: -68px;
	left: 235px;
}

.block__fourth__block__radio {
	display: block;
	width: 150px;
	height: 20px;
	position: relative;
	top: 15px;
}

.block__fourth__block__radio__1 {
	display: block;
	width: 170px;
	height: 20px;
	position: relative;
	top: -15px;
	left: 160px;
}

.block__fourth__block__radio__2 {
	display: block;
	width: 170px;
	height: 20px;
	position: relative;
	top: -42px;
	left: 350px;
}

.third__block__radio {
	padding-top: 10px;
}

.block__text {
	width: 50px;
	height: 20px;
	position: relative;
	left: 10px;
	top: 15px;
}

.block__text__1 {
	width: 50px;
	height: 20px;
	position: relative;
	left: 250px;
	top: -25px;
}


.block__1__input {
	width: 130px;
	height: 22px;
	position: relative;
	right: 80px;
	top: -10px;
	border: 1px solid rgba(34, 36, 82, 1);
	background-color: #323370;
}

.block__2__input {
	width: 130px;
	height: 22px;
	position: relative;
	right: -165px;
	top: -50px;
	border: 1px solid rgba(34, 36, 82, 1);
	background-color: #323370;
}

.block__3__input {
	width: 130px;
	height: 22px;
	position: relative;
	right: 80px;
	top: -7px;
	border: 1px solid rgba(34, 36, 82, 1);
	background-color: #323370;
}

.block__4__input {
	width: 130px;
	height: 22px;
	position: relative;
	right: -165px;
	top: -50px;
	border: 1px solid rgba(34, 36, 82, 1);
	background-color: #323370;
}

.block__5__input {
	width: 130px;
	height: 22px;
	position: relative;
	right: -40px;
	top: -8px;
	border: 1px solid rgba(34, 36, 82, 1);
	background-color: #323370;
}

.block__6__input {
	width: 130px;
	height: 22px;
	position: relative;
	right: 85px;
	top: -10px;
	border: 1px solid rgba(34, 36, 82, 1);
	background-color: #323370;
}

.block__7__input {
	width: 130px;
	height: 22px;
	position: relative;
	right: -400px;
	top: -52px;
	border: 1px solid rgba(34, 36, 82, 1);
	background-color: #323370;
}

.block__text__2 {
	width: 50px;
	height: 20px;
	position: relative;
	left: 10px;
	top: 18px;
}

.block__text__3 {
	width: 50px;
	height: 20px;
	position: relative;
	left: 250px;
	top: -22px;
}

.block__text__4 {
	width: 50px;
	height: 20px;
	position: relative;
	left: 8px;
	top: 18px;
}

.block__text__5 {
	width: 300px;
	height: 20px;
	position: relative;
	left: 5px;
	top: 15px;
}

.block__text__6 {
	width: 300px;
	height: 20px;
	position: relative;
	left: 495px;
	top: -27px;
}

.form__checkbox {
	height: 20px;
	width: 50px;
}

.form__checkbox__1 {
	height: 20px;
	width: 90px;
}

.block__checkbox__1 {
	position: relative;
	left: 10px;
	top: 15px;
}

.block__checkbox__2 {
	position: relative;
	left: 60px;
	top: -5px;
}

.block__checkbox__3 {
	position: relative;
	top: -25px;
	left: 110px;
}

.block__checkbox__4 {
	position: relative;
	top: -45px;
	left: 160px;
}

.block__checkbox__5 {
	position: relative;
	top: -65px;
	left: 210px;
}

 .block__checkbox__6 {
	position: relative;
	top: -85px;
	left: 260px;
}

.block__checkbox__7 {
	position: relative;
	top: -105px;
	left: 310px;
} 

.block__checkbox__8 {
	position: relative;
	top: -125px;
	left: 360px;
} 

.block__checkbox__9 {
	position: relative;
	top: -145px;
	left: 410px;
}

.block__1__checkbox__1 {
	position: relative;
	top: 15px;
	left: 0px;
}

.block__1__checkbox__2 {
	position: relative;
	top: -5px;
	left: 70px;
}

.block__1__checkbox__3 {
	position: relative;
	top: -25px;
	left: 160px;
}

.block__1__checkbox__4 {
	position: relative;
	top: -45px;
	left: 255px;
}


.block__1__checkbox__5 {
	position: relative;
	top: -65px;
	left: 355px;
}

.block__1__checkbox__6 {
	position: relative;
	top: -85px;
	left: 455px;
}

.block__1__checkbox__7 {
	position: relative;
	top: -105px;
	left: 555px;
}

.block__1__checkbox__8 {
	position: relative;
	top: -125px;
	left: 655px;
	width: 120px;
}


.checkbox__block__1 {

}

.checkbox__block__label__1 {
	position: relative;
	top: -2px;
	margin-right: 5px;
}

.square2 {
	border: 1px solid rgba(34, 36, 82, 1);
}


</style>