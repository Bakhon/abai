<template>

	<div class="flex-container">
		{{ inDevelopNotify() }}
		<div class="flex__item__block__1">
			<div class="title__block">Число качаний</div>

			<div class="flex__item__block__first__block">
				<div class="block__text">Минимум</div>
				<input v-model="spmMin" @change="onChangeSpmMin"  class="square2 block__1__input" type="text">

				<div class="block__text__1">Максимум</div>
				<input v-model="spmMax" @change="onChangeSpmMax"  class="square2 block__2__input" type="text">
			</div>

		</div>

		<div class="flex__item__block__1">
			<div class="title__block__2">Длина хода</div>

			<div class="flex__item__block__second__block">
				<div class="block__text__2">Минимум</div>
				<input v-model="lenMin" @change="onChangeLenMin"  class="square2 block__3__input" type="text">

				<div class="block__text__3">Максимум</div>
				<input v-model="lenMax" @change="onChangeLenMax"  class="square2 block__4__input" type="text">
			</div>

		</div>

		<div class="flex__item__block__2">
			<div class="title__block__1">К под</div>
			<div class="flex__item__block__first__block__1">
				
				<div class="block__text__4">Минимум</div>
				<input class="square2 block__1__input__1" type="text" value="0,6" >

			</div>
		</div>

		<div class="flex__item__block__1__2">
			<div class="title__block__4">Диаметр насосов, мм</div>
				<div class="flex__item__block__second__block__4">
					<div>

					</div>
					<div class="form__checkbox block__checkbox__1">
						<label class="checkbox__block__label__1">27</label>
						<input class="checkbox__block__1" v-model="pump27" @change="onChangePump27" type="checkbox" />
					</div>			

					<div class="form__checkbox block__checkbox__2">
						<label class="checkbox__block__label__1">32</label>
						<input class="checkbox__block__1" v-model="pump32" @change="onChangePump32" type="checkbox" />
					</div>

					<div class="form__checkbox block__checkbox__3">
						<label class="checkbox__block__label__1">38</label>
						<input class="checkbox__block__1" v-model="pump38" @change="onChangePump38" type="checkbox" />
					</div>

					<div class="form__checkbox block__checkbox__4">
						<label class="checkbox__block__label__1">44</label>
						<input class="checkbox__block__1" v-model="pump44" @change="onChangePump44" type="checkbox" />
					</div>

					<div class="form__checkbox block__checkbox__5">
						<label class="checkbox__block__label__1">50</label>
						<input class="checkbox__block__1" v-model="pump50" @change="onChangePump50" type="checkbox" />
					</div>

					<div class="form__checkbox block__checkbox__6">
						<label class="checkbox__block__label__1">57</label>
						<input class="checkbox__block__1" v-model="pump57" @change="onChangePump57" type="checkbox" />
					</div>

					<div class="form__checkbox block__checkbox__7">
						<label class="checkbox__block__label__1">60</label>
						<input class="checkbox__block__1" v-model="pump60" @change="onChangePump60" type="checkbox" />
					</div>

					<div class="form__checkbox block__checkbox__8">
						<label class="checkbox__block__label__1">70</label>
						<input class="checkbox__block__1" v-model="pump70" @change="onChangePump70" type="checkbox" />
					</div>

					<div class="form__checkbox block__checkbox__9">
						<label class="checkbox__block__label__1">95 </label>
						<input class="checkbox__block__1" v-model="pump95" @change="onChangePump95" type="checkbox" />
					</div>
				</div>
		</div>

		<div class="flex__item__block__1__1">
			<div class="title__block__3__1__1">Группа посадки<svg style="padding-left: 4px;" @click="onClick()" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path fill-rule="evenodd" clip-rule="evenodd" d="M12 15.9998C14.2092 15.9998 16 14.209 16 11.9998V4C16 1.79086 14.2092 -7.25981e-06 12 0L4.00035 2.62892e-05C1.79129 3.35488e-05 0.000467376 1.79078 0.000366244 3.99984L4.28319e-09 11.9997C-0.00010113 14.2089 1.79079 15.9998 4 15.9998H12ZM9.96388 4.21331C9.96388 4.83186 9.41469 5.3333 8.73722 5.3333C8.05976 5.3333 7.51057 4.83186 7.51057 4.21331C7.51057 3.59476 8.05976 3.09332 8.73722 3.09332C9.41469 3.09332 9.96388 3.59476 9.96388 4.21331ZM5.60064 7.36004L5.72864 6.8214L6.60376 6.50669L6.9106 6.42998C7.06133 6.3923 7.21494 6.3673 7.36984 6.35523L7.41538 6.35168C7.54958 6.34122 7.68445 6.34271 7.81839 6.35613L7.85353 6.35965C7.94465 6.36878 8.03495 6.38481 8.12364 6.40762L8.18305 6.4229C8.30295 6.45373 8.41808 6.50078 8.52526 6.56274L8.55485 6.57985C8.65442 6.63741 8.74468 6.70975 8.82254 6.79439L8.8313 6.80391C8.91016 6.88963 8.97434 6.98778 9.02125 7.0944C9.05215 7.16462 9.07532 7.23799 9.09037 7.31322L9.09378 7.33027C9.11191 7.42093 9.11967 7.51336 9.11689 7.60578L9.11251 7.75195C9.10756 7.91693 9.08628 8.08102 9.04897 8.24181L8.9504 8.66669L8.75307 9.33335L8.44907 10.4L8.33707 10.9333L8.31512 11.2011C8.31199 11.2394 8.31319 11.2778 8.31869 11.3158L8.32229 11.3407C8.3477 11.516 8.46981 11.662 8.63788 11.718C8.66837 11.7282 8.69982 11.7352 8.73174 11.7389L8.82514 11.7498C8.9437 11.7637 9.06356 11.7621 9.18171 11.7451L9.25563 11.7344C9.35953 11.7195 9.46205 11.6962 9.5622 11.6648L9.81973 11.584L9.67039 12.1333L8.73707 12.4693L8.46883 12.5326C8.30138 12.5721 8.13053 12.5955 7.95863 12.6026L7.93826 12.6034C7.77785 12.61 7.61717 12.6011 7.45847 12.5768L7.36839 12.563C7.28545 12.5503 7.20378 12.5305 7.12429 12.5037L7.08161 12.4893C6.90742 12.4305 6.74837 12.3339 6.61586 12.2065L6.60737 12.1983C6.56238 12.1551 6.52112 12.1081 6.48404 12.0578C6.35347 11.881 6.27843 11.6694 6.26845 11.4499L6.26357 11.3423C6.25926 11.2477 6.26417 11.1528 6.27823 11.0591L6.33709 10.6667L6.87042 8.80003L7.02509 8.13737L7.056 7.87718C7.06732 7.7819 7.0635 7.68544 7.04469 7.59136L7.02946 7.51521C7.02302 7.48303 7.01214 7.4519 6.99713 7.42271C6.95049 7.33203 6.86703 7.26586 6.76811 7.24113L6.66762 7.21601C6.62518 7.2054 6.58168 7.1996 6.53794 7.19872L6.33709 7.19471C6.15985 7.20887 5.98467 7.24231 5.81466 7.29443L5.60064 7.36004Z" fill="white"/>
			</svg></div>

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

				<label for="" class="block__third__block__radio__5">Подбор
					<input value="bhp" class="third__block__radio" type="radio" name="set2" />
				</label>
			</div>
		</div>

		<div class="flex__item__block__1__2">
			<div class="title__block__4">Применение в компоновке</div>
			<div class="flex__item__block__second__block__4__1">
				<div class="form__checkbox block__checkbox__1">
					<div class="block__checkbox__text">
						<input type="checkbox" />
						<label for="checkbox1">Якорь-трубодержатель</label>
					</div>
						
					<div class="block__checkbox__1__text">
						<input type="checkbox" />
						<label for="checkbox1">Пакер с хвостовиком</label>
					</div>
						
					<div class="block__checkbox__2__text">
						<input type="checkbox" />
						<label for="checkbox1">Хвостовик</label>
					</div>
							
					</div>

			</div>
		</div>

		

		<div class="flex__item__block__3">
			<div class="title__block__3__1">Конструкция колонны штанг<svg style="padding-left: 4px;" @click="onClick()" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path fill-rule="evenodd" clip-rule="evenodd" d="M12 15.9998C14.2092 15.9998 16 14.209 16 11.9998V4C16 1.79086 14.2092 -7.25981e-06 12 0L4.00035 2.62892e-05C1.79129 3.35488e-05 0.000467376 1.79078 0.000366244 3.99984L4.28319e-09 11.9997C-0.00010113 14.2089 1.79079 15.9998 4 15.9998H12ZM9.96388 4.21331C9.96388 4.83186 9.41469 5.3333 8.73722 5.3333C8.05976 5.3333 7.51057 4.83186 7.51057 4.21331C7.51057 3.59476 8.05976 3.09332 8.73722 3.09332C9.41469 3.09332 9.96388 3.59476 9.96388 4.21331ZM5.60064 7.36004L5.72864 6.8214L6.60376 6.50669L6.9106 6.42998C7.06133 6.3923 7.21494 6.3673 7.36984 6.35523L7.41538 6.35168C7.54958 6.34122 7.68445 6.34271 7.81839 6.35613L7.85353 6.35965C7.94465 6.36878 8.03495 6.38481 8.12364 6.40762L8.18305 6.4229C8.30295 6.45373 8.41808 6.50078 8.52526 6.56274L8.55485 6.57985C8.65442 6.63741 8.74468 6.70975 8.82254 6.79439L8.8313 6.80391C8.91016 6.88963 8.97434 6.98778 9.02125 7.0944C9.05215 7.16462 9.07532 7.23799 9.09037 7.31322L9.09378 7.33027C9.11191 7.42093 9.11967 7.51336 9.11689 7.60578L9.11251 7.75195C9.10756 7.91693 9.08628 8.08102 9.04897 8.24181L8.9504 8.66669L8.75307 9.33335L8.44907 10.4L8.33707 10.9333L8.31512 11.2011C8.31199 11.2394 8.31319 11.2778 8.31869 11.3158L8.32229 11.3407C8.3477 11.516 8.46981 11.662 8.63788 11.718C8.66837 11.7282 8.69982 11.7352 8.73174 11.7389L8.82514 11.7498C8.9437 11.7637 9.06356 11.7621 9.18171 11.7451L9.25563 11.7344C9.35953 11.7195 9.46205 11.6962 9.5622 11.6648L9.81973 11.584L9.67039 12.1333L8.73707 12.4693L8.46883 12.5326C8.30138 12.5721 8.13053 12.5955 7.95863 12.6026L7.93826 12.6034C7.77785 12.61 7.61717 12.6011 7.45847 12.5768L7.36839 12.563C7.28545 12.5503 7.20378 12.5305 7.12429 12.5037L7.08161 12.4893C6.90742 12.4305 6.74837 12.3339 6.61586 12.2065L6.60737 12.1983C6.56238 12.1551 6.52112 12.1081 6.48404 12.0578C6.35347 11.881 6.27843 11.6694 6.26845 11.4499L6.26357 11.3423C6.25926 11.2477 6.26417 11.1528 6.27823 11.0591L6.33709 10.6667L6.87042 8.80003L7.02509 8.13737L7.056 7.87718C7.06732 7.7819 7.0635 7.68544 7.04469 7.59136L7.02946 7.51521C7.02302 7.48303 7.01214 7.4519 6.99713 7.42271C6.95049 7.33203 6.86703 7.26586 6.76811 7.24113L6.66762 7.21601C6.62518 7.2054 6.58168 7.1996 6.53794 7.19872L6.33709 7.19471C6.15985 7.20887 5.98467 7.24231 5.81466 7.29443L5.60064 7.36004Z" fill="white"/>
			</svg></div>
			<div class="title__block__3__2">Диаметры штанг, мм</div>
			<div class="title__block__3__3">Марки стали штанг</div>

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
					<input value="bhp" class="third__block__radio" type="checkbox" name="set2" />
				</label>
			</div>

			<div class="flex__item__block__third__block__2">
				<div class="form__checkbox block__checkbox__1">
					<label for="checkbox1" class="checkbox__block__label__1">13</label>
					<input class="checkbox__block__1" type="checkbox" />
				</div>

				<div class="form__checkbox block__checkbox__2">
					<label for="checkbox1" class="checkbox__block__label__1">16</label>
					<input class="checkbox__block__1" type="checkbox" />
				</div>

				<div class="form__checkbox block__checkbox__3">
					<label for="checkbox1" class="checkbox__block__label__1">19</label>
					<input class="checkbox__block__1" type="checkbox" />
				</div>

				<div class="form__checkbox block__checkbox__4">
					<label for="checkbox1" class="checkbox__block__label__1">22</label>
					<input class="checkbox__block__1" type="checkbox" />
				</div>

				<div class="form__checkbox block__checkbox__5">
					<label for="checkbox1" class="checkbox__block__label__1">25</label>
					<input class="checkbox__block__1" type="checkbox" />
				</div>

				<div class="form__checkbox block__checkbox__6">
					<label for="checkbox1" class="checkbox__block__label__1">29</label>
					<input class="checkbox__block__1" type="checkbox" />
				</div>
			</div>
		</div>

		<div class="flex__item__block__4">
			<div class="title__block__4__1">Коррозионность добываемой продукции</div>
			<div class="flex__item__block__fourth__block">
				<select class="input-box-gno podbor long__box" v-model="markShtang">
                  <option v-for="(mark, index) in markShtang" :value="mark.mValue" :key="index">
                  {{mark.tempValue}}
                  </option>
                </select>

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

					<label for="" class="block__fourth__block__radio__3">Присутствие H2S
						<input value="bhp" class="third__block__radio" type="radio" name="set2" />
					</label>
				</div>
			
			</div> 

		</div>

		<div class="flex__item__block__5">
			<div class="title__block__5__1">Потенциальный режим</div>
			<!-- <div class="title__block__5__2">Подбор глубины спуска в окне Инклинометрия</div> -->

				<div class="flex__item__block__sixth__block">
					<div class="block__text__5">Давление на приеме насоса минимальное</div>
					<input class="square2 block__6__input" type="text">

					<div class="block__text__6">Газосодержание в насосе максимальное</div>
					<input class="square2 block__7__input" type="text">
				</div>

			
		</div>

		<div class="flex__item__block__6">
			<div class="title__block__6__1">Подбор глубины спуска в окне Инклинометрия</div>

	
				<div class="flex__item__block__fifth__block__1">
					<div class="block__text__4__end">Длина полки</div>
					<input class="square2 block__5__input" type="text">
				</div>

				<button type="button" class="submit_button" @click="onSubmitParams()">
                        {{trans('pgno.primenit_korrektirovki')}}
                </button>
				
			
		</div>
		<notifications position="top"></notifications>

		<modal name="modalTable" :draggable="true" :width="1000" :height="550"
			:adaptive="true">
			<div class="modal-bign modal-bign-container">
				<div class="modal-bign-header">
					<div class="modal-bign-title">

					</div>

					<button type="button" class="modal-bign-button" @click="closeModal('modalTable')">
						{{trans('pgno.zakrit')}}
					</button>
				</div>

				<div>

					<div class="nno-modal-button-wrapper">
						<div class="nno-modal-buttons-container">
							<div class="title__table__1">Таблица 8 - Группы посадок сопряжения “плунжер-цилиндр”</div>
							<table class="table__1">
									<tr style="color: white;">
										<th class="table__th__1">Группа посадки, мм</th>
										<th class="table__th__1">Минимальный зазор, мм</th>
										<th class="table__th__1" style="width: 60%;">Максимальный зазор с учетом допуска на изготовление цилиндра и плунжера, мм	</th>
									</tr>
									<tr>
										<td class="table__td__1">1</td>
										<td class="table__td__1">0.00</td>
										<td class="table__td__1">0.063</td>
									</tr>
									<tr class="highlight__tr__1">
										<td class="table__td__1">2</td>
										<td class="table__td__1">0,025</td>
										<td class="table__td__1">0,088</td>
									</tr>
									<tr>
										<td class="table__td__1">3</td>
										<td class="table__td__1">0,050</td>
										<td class="table__td__1">0,113</td>
									</tr>
									<tr class="highlight__tr__1">
										<td class="table__td__1">4</td>
										<td class="table__td__1">0,075</td>
										<td class="table__td__1">0,138</td>
									</tr>

									<tr>
										<td class="table__td__1">5</td>
										<td class="table__td__1">0,100</td>
										<td class="table__td__1">0,163</td>
									</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
		</modal>
	</div>



</template>

<script>
import { mapGetters, mapState } from 'vuex';
import NotifyPlugin from "vue-easy-notify";

Vue.use(NotifyPlugin);
export default {
	data: function()  {
		return {
			pump27: false,
			pump32: false,
			pump38: false,
			pump44: false,
			pump50: false,
			pump57: false,
			pump60: false,
			pump70: false,
			pump95: false,
			lenMin: 2,
			lenMax: 3,
			spmMin: 3,
			spmMax: 8,
			closeModal: false,
			pumpCheckboxes: [
				{
					id: 1,
					value: 27
				},
				{
					id: 2,
					value: 32
				},
				{
					id: 3,
					value: 38
				},
				{
					id: 4,
					value: 44
				},
				{
					id: 5,
					value: 50
				},

				],
			markShtang: [
        		{
          		mValue: 1,
          		tempValue: "40 (Н)",
        		},
        		{
          		mValue: 2,
          		tempValue: "40 (НсУ)",
        		},
        		{
          		mValue: 3,
          		tempValue: "14Х3ГМЮ (НВО)",
        		},
        		{
          		mValue: 4,
          		tempValue: "15НЗМА (Н)",
        		},
        		{
          		mValue: 5,
          		tempValue: "15НЗМА (НсУ)",
        		},
        		{
          		mValue: 6,
          		tempValue: "15Х2ГМФ (НВО)",
        		},
				{
          		mValue: 7,
          		tempValue: "15Х2НМФ (НВО)",
        		},
				{
          		mValue: 8,
          		tempValue: "20Н2М (Н)",
        		},
				{
          		mValue: 9,
          		tempValue: "20Н2М (НсУ)",
        		},
				{
          		mValue: 10,
          		tempValue: "30ХМ(А) (НсУ)",
        		},
				{
          		mValue: 11,
          		tempValue: "АЦ28ХГНЗФТ (О)",
        		},
				],
				}
	},
	computed: {
		// spmMin: {
		// 	get() {
		// 		return this.$store.state.spmMin
		// 	},
		// },
		// spmMax: {
		// 	get() {
		// 		return this.$store.state.spmMax
		// 	},
		// 	set(spmMax) {
		// 		this.$store.commit("UPDATE_SPM_MAX", spmMax)
		// 	}
		// },
		// lenMin: {
		// 	get() {
		// 		return this.$store.state.lenMin
		// 	},
		// 	set(lenMin) {
		// 		this.$store.commit("UPDATE_LEN_MIN", lenMin)
		// 	}
		// },
		// lenMax: {
		// 	get() {
		// 		return this.$store.state.lenMax
		// 	},
		// 	set(lenMax) {
		// 		this.$store.commit("UPDATE_LEN_MAX", lenMax)
		// 	}
		// },
		// ...mapState(["spmMin", "spmMax", "lenMin", "lenMax"]),
      	// ...mapGetters(["myVal"])
	},
	methods: {
		onChangeSpmMin(event) {
			this.$store.commit("UPDATE_SPM_MIN", event.target.value)
		},
		onChangeSpmMax(event) {
			this.$store.commit("UPDATE_SPM_MAX", event.target.value)
		},
		onChangeLenMin(event) {
			this.$store.commit("UPDATE_LEN_MIN", event.target.value)
		},
		onChangeLenMax(event) {
			this.$store.commit("UPDATE_LEN_MAX", event.target.value)
		},

		onChangePump27(event) {
			this.$store.commit("UPDATE_PUMP_27", event.target.checked)
		},
		onChangePump32(event) {
			this.$store.commit("UPDATE_PUMP_32", event.target.checked)
		},
		onChangePump38(event) {
			this.$store.commit("UPDATE_PUMP_38", event.target.checked)
		},
		onChangePump44(event) {
			this.$store.commit("UPDATE_PUMP_44", event.target.checked)
		},
		onChangePump50(event) {
			this.$store.commit("UPDATE_PUMP_50", event.target.checked)
		},
		onChangePump57(event) {
			this.$store.commit("UPDATE_PUMP_57", event.target.checked)
		},
		onChangePump60(event) {
			this.$store.commit("UPDATE_PUMP_60", event.target.checked)
		},
		onChangePump70(event) {
			this.$store.commit("UPDATE_PUMP_70", event.target.checked)
		},
		onChangePump95(event) {
			this.$store.commit("UPDATE_PUMP_95", event.target.checked)
		},

		onClick() {
			this.$modal.show('modalTable')
			this.closeModal = true;
			this.$emit('myEvent', this.closeModal);
      		this.$modal.hide('modalTable')
		},
		onSubmitParams() {
			this.$emit('on-submit-params');
			this.$modal.show('tabs');
		},
		inDevelopNotify() {
      		setTimeout(this.inDeveloping, 1000)
    	},
		inDeveloping() {
			this.$notify({
          	message: this.trans('Находится в разработке'),
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
  justify-content: left;
}

.flex__item__block__1 {
  background-color: #272953;
  padding: 5px;
  width: 360px;
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

.flex__item__block__1__1 {
  background-color: #272953;
  padding: 5px;
  width: 360px;
  height: 80px;
  margin-top: 10px;
  position: relative;
  left: 0px;
  color: white;
  font-weight: bold;
  font-size: 1em;
  text-align: center;
}

.flex__item__block__1__2 {
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
  width: 180px;
  height: 80px;
  margin-top: 10px;
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
	height: 20px;
	text-align: left;
}

.title__block__1 {
	height: 20px;
	text-align: left;
	position: relative;
	left: 65px;
}

.title__block__2 {
	height: 20px;
	text-align: left;
	position: relative;
	left: 130px;
}

.title__block__3__1 {
	text-align: left;
	height: 20px;
	width: 220px;
}

.title__block__3__1__ {
	text-align: left;
	height: 20px;
	width: 220px;
	position: relative;
	left: 90px;
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
	left: 680px;
	width: 200px;
	top: -40px;
}

.title__block__4__1 {
	text-align: left;
	height: 20px;
	width: 290px;
}

.title__block__5__1 {
	text-align: left;
	height: 20px;
	width: 300px;
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
	height: 20px;
	width: 400px;
}

.flex__item__block__first__block {
	height: 42px;
	width: 350px;
	background-color: #2b2e5e;
}

.flex__item__block__first__block__1 {
	height: 42px;
	width: 180px;
	background-color: #2b2e5e;
}

.flex__item__block__second__block {
	height: 42px;
	width: 350px;
	background-color: #2b2e5e;
}

.flex__item__block__third__block {
	height: 42px;
	width: 330px;
	background-color: #2b2e5e;
}

.flex__item__block__third__block__1 {
	height: 42px;
	width: 310px;
	background-color: #2b2e5e;
	margin-top: -40px;
}

.flex__item__block__third__block__2 {
	height: 42px;
	width: 310px;
	background-color: #2b2e5e;
	position: relative;
	top: -42px;
	left: 330px;
}


.flex__item__block__fourth__block {
	height: 42px;
	width: 170px;
	background-color: #2b2e5e;
	position: relative;
	top: -85px;
	left: 660px;
}

.flex__item__block__second__block__4 {
	height: 42px;
	width: 470px;
	background-color: #2b2e5e;
}

.flex__item__block__second__block__4__1 {
	height: 42px;
	width: 550px;
	background-color: #2b2e5e;
}

.title__block__4 {
	height: 20px;
	text-align: left;
}

.flex__item__block__fifth__block {
	height: 42px;
	width: 680px;
	background-color: #2b2e5e;
	position: relative;
	top: 85px;
	left: -660px;
}

.flex__item__block__fifth__block__1 {
	height: 42px;
	width: 360px;
	background-color: #2b2e5e;
	position: relative;
	top: 0px;
	left: 0px;
}

.flex__item__block__sixth__block {
	height: 42px;
	width: 940px;
	background-color: #2b2e5e;
	position: relative;
	top: 0px;
	left: 0px;
}

.flex__item__block__sixth__block__1 {
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

.block__fourth__block__radio__3 {
	display: block;
	width: 170px;
	height: 20px;
	position: relative;
	top: -70px;
	left: 520px;
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
	left: 180px;
	top: -27px;
}


.block__text__4 {
	width: 90px;
	height: 20px;
	position: relative;
	left: 180px;
	top: -25px;
}


.block__1__input {
	width: 80px;
	height: 22px;
	position: relative;
	right: 50px;
	top: -10px;
	border: 1px solid rgba(34, 36, 82, 1);
	background-color: #323370;
}

.block__1__input__1 {
	width: 80px;
	height: 22px;
	position: relative;
	right: -35px;
	top: -10px;
	border: 1px solid rgba(34, 36, 82, 1);
	background-color: #323370;
}

.block__2__input {
	width: 80px;
	height: 22px;
	position: relative;
	right: -130px;
	top: -52px;
	border: 1px solid rgba(34, 36, 82, 1);
	background-color: #323370;
}

.block__3__input {
	width: 80px;
	height: 22px;
	position: relative;
	right: 50px;
	top: -10px;
	border: 1px solid rgba(34, 36, 82, 1);
	background-color: #323370;
}

.block__4__input {
	width: 80px;
	height: 22px;
	position: relative;
	right: -130px;
	top: -52px;
	border: 1px solid rgba(34, 36, 82, 1);
	background-color: #323370;
}

.block__5__input {
	width: 230px;
	height: 22px;
	position: relative;
	right: -50px;
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
	top: 15px;
}

.block__text__3 {
	width: 50px;
	height: 20px;
	position: relative;
	left: 180px;
	top: -27px;
}

.block__text__4 {
	width: 50px;
	height: 20px;
	position: relative;
	left: 8px;
	top: 15px;
}

.block__text__4__end {
	width: 90px;
	height: 20px;
	position: relative;
	left: 8px;
	top: 15px;	
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

.block__checkbox__text {
	width: 200px;
	height: 20px;
}

.block__checkbox__1__text {
	width: 200px;
	height: 20px;
	position: relative;
	left: 210px;
	bottom: 20px;
}

.block__checkbox__2__text {
	width: 200px;
	height: 20px;
	position: relative;
	left: 380px;
	bottom: 40px;
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


.checkbox__block__label__text__1 {
	position: relative;
	width: 200px;
	top: -13px;
	margin-right: 5px;
	left: 15px;
}

.checkbox__block__label__text__2 {
	position: relative;
	width: 200px;
	top: -13px;
	margin-right: 5px;
	left: 15px;
}

.checkbox__block__label__text__3 {
	position: relative;
	width: 200px;
	top: -13px;
	margin-right: 5px;
	left: 15px;
}

.square2 {
	border: 1px solid rgba(34, 36, 82, 1);
}

.input-box-gno {
    background: #494AA5;
    border: 1px solid #272953;
    outline: none;
    width: 100%;
    height: 22px;
    color: white;
    box-sizing: border-box;
    border-radius: 2px;
    line-height: 25px !important;
    padding-right: 5px;
    padding-left: 5px;
}

.input-box-gno:focus {
    background: #5657c7;
}

.input-box-gno:disabled {
    color: #928f8f;
    background: #353e70;
}

.input-box-gno.podbor {
    width: 150px;
    margin-bottom: 10px;
	position: absolute;
	left: 10px;
	bottom: -1px;
}

.submit_button {
    width: 350px;
    height: 50px;
    background: #293688;
    border-radius: 8px;
    cursor: pointer;
    color: #ffffff;
    font-weight: bold;
    font-size: 14px;
    text-align: center;
    outline: none !important;
    box-shadow: none;
    border: none;
    margin-left: 10px;
    line-height: 14px;
    vertical-align: middle;
	position: absolute;
	right: 150px;
	top: 15px;
}

.submit_button:hover {
    background: #222d74;
}

.submit_button:active {
    outline: none !important;
    background: #1a225e;
}


/* Таблица #1*/

.table__1 {
	text-align: left;
	border-collapse: separate;
	width: 900px;
	height: 400px;
}

.table__th__1 {
	font-size: 15px;
	width: 20%;
	vertical-align: middle;
	border-top: 0px;
	text-align: center;
	background: #323f8a;
}

.table__td__1 {
	width: 20%;
	vertical-align: middle;
	background: #383d6d;
}

.highlight__tr__1 > .table__td__1 {
	background-color: #2b2e5e;
}

.title__table__1 {
	font-size: 20px;
	text-align: left;
	margin-bottom: 20px;
	margin-top: -10px;
}




</style>