<template>

	<div class="flex-container">
		<div class="flex__item__block__1">
			<div class="title__block">{{trans('pgno.chislo_kachanii')}}</div>
				<div class="title__block__min__1">
					<span>{{trans('pgno.minimum')}}</span>
					<input v-model="spmMin" @change="onChangeSpmMin"  class="square2 block__1__input" type="text">
				</div>
				<div class="title__block__max__1">
					<span>{{trans('pgno.maximum')}}</span>
					<input v-model="spmMax" @change="onChangeSpmMax"  class="square2 block__2__input" type="text">
				</div>
		</div>

		<div class="flex__item__block__1">
			<div class="title__block">{{trans('pgno.dlina_hoda')}}</div>
				<div class="title__block__min__1">
					<span>{{trans('pgno.minimum')}}</span>
					<input v-model="strokeLenMin" @change="onChangeLenMin"  class="square2 block__1__input" type="text">
				</div>
				<div class="title__block__max__1">
					<span>{{trans('pgno.maximum')}}</span>
					<input v-model="strokeLenMax" @change="onChangeLenMax"  class="square2 block__2__input" type="text">
				</div>
			</div>

		<div class="flex__item__block__1">
			<div class="title__block">{{trans('pgno.kpod')}}</div>
			<div class="title__block__max" style="display: flex; flex-direction: column;">
				<div class="block1">
					<div class="title__block__kpod">
						<input class="checkbox__block__1" v-model="kPodMode" type="radio" v-bind:value="true" @change="setKpodMode()"/>
						<label class="label-kpod">{{trans('pgno.calc_min_value')}}</label>
						<input type="text" class="input-box-gno podbor-kpod-block-3" v-model="kpodMin" :disabled="!kPodMode">
					</div>			
				</div>

				<div class="block2">
					<div class="title__block__kpod">
						<input class="checkbox__block__1" v-model="kPodMode" type="radio" v-bind:value="false" @change="setKpodMode()"/>
						<label class="label-kpod">{{trans('pgno.use_value')}}</label>
						<input type="text" class="input-box-gno podbor-kpod-block-3" v-model="kpodCalced" :disabled="true">
					</div>	
				</div>
				
				<div class="block3">
					<div class="title__block__kpod" style="display: flex; flex-direction: row; ">
						<div class="asd" style="width: 55px; text-align: center;">Ø</div>
						<div class="asd" style="width: 80px; text-align: center;">Длина хода</div>
						<div class="asd" style="width: 95px; text-align: center;">Число качаний</div>
						<div class="asd">Qж</div>
					</div>
				</div>
				<div class="block4">
					<div class="title__block__pump__1__flex">

					<select class="input-box-gno k-pod" v-model="pumpTypeKpod" @change="calKpod()">
						<option v-for="dm in diametersShgn" :key="dm.value" :value="dm.pumpType">
							{{dm.value}}
						</option>
					</select>
					<input type="text" class="input-box-gno podbor-kpod-block-1" v-model="strokeLenDevKpod" @change="calKpod()">
					<input type="text" class="input-box-gno podbor-kpod-block-2" v-model="spmKpod" @change="calKpod()">
					<input type="text" class="input-box-gno podbor-kpod-block-3" v-model="qLInputKpod" @change="calKpod()">

				</div>
				</div>

			</div>
		</div>
		<div class="flex__item__block__1">
			<div class="title__block"><span>{{trans('pgno.diametr_nasosov')}}, {{trans('measurements.mm')}}</span></div>
				<div class="title__block__pump">
					<div class="title__block__pump_list">

						<div class="title__block__pump__1">
							<input class="checkbox__block__1" v-model="dmPumps" value="27" type="checkbox"/>
							<label class="checkbox__block__label__1">27</label>
						</div>

						<div class="title__block__pump__1">
							<input class="checkbox__block__1" v-model="dmPumps" value="32" type="checkbox"/>
							<label class="checkbox__block__label__1">32</label>
						</div>

						<div class="title__block__pump__1">
							<input class="checkbox__block__1" v-model="dmPumps" value="38" type="checkbox"/>
							<label class="checkbox__block__label__1">38</label>
						</div>

					</div>

					<div class="title__block__pump_list__2">

						<div class="title__block__pump__1">
							<input class="checkbox__block__1" v-model="dmPumps" value="44" type="checkbox"/>
							<label class="checkbox__block__label__1">44</label>
						</div>

						<div class="title__block__pump__1">
							<input class="checkbox__block__1" v-model="dmPumps" value="50" type="checkbox"/>
							<label class="checkbox__block__label__1">50</label>
						</div>

						<div class="title__block__pump__1">
							<input class="checkbox__block__1" v-model="dmPumps" value="57" type="checkbox"/>
							<label class="checkbox__block__label__1">57</label>
						</div>

					</div>

					<div class="title__block__pump_list__3">

						<div class="title__block__pump__1">
							<input class="checkbox__block__1" v-model="dmPumps" value="60" type="checkbox"/>
							<label class="checkbox__block__label__1">60</label>
						</div>

						<div class="title__block__pump__1">
							<input class="checkbox__block__1" v-model="dmPumps" value="70" type="checkbox"/>
							<label class="checkbox__block__label__1">70</label>
						</div>

						<div class="title__block__pump__1">
							<input class="checkbox__block__1" v-model="dmPumps" value="95" type="checkbox"/>
							<label class="checkbox__block__label__1">95</label>
						</div>

						</div>
					</div>

				
				</div>

		<div class="flex__item__block__1">

			<div class="title__block"><u>{{trans('pgno.group_posadka')}}</u><svg style="padding-left: 4px;" @click="onClick()" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path fill-rule="evenodd" clip-rule="evenodd" d="M12 15.9998C14.2092 15.9998 16 14.209 16 11.9998V4C16 1.79086 14.2092 -7.25981e-06 12 0L4.00035 2.62892e-05C1.79129 3.35488e-05 0.000467376 1.79078 0.000366244 3.99984L4.28319e-09 11.9997C-0.00010113 14.2089 1.79079 15.9998 4 15.9998H12ZM9.96388 4.21331C9.96388 4.83186 9.41469 5.3333 8.73722 5.3333C8.05976 5.3333 7.51057 4.83186 7.51057 4.21331C7.51057 3.59476 8.05976 3.09332 8.73722 3.09332C9.41469 3.09332 9.96388 3.59476 9.96388 4.21331ZM5.60064 7.36004L5.72864 6.8214L6.60376 6.50669L6.9106 6.42998C7.06133 6.3923 7.21494 6.3673 7.36984 6.35523L7.41538 6.35168C7.54958 6.34122 7.68445 6.34271 7.81839 6.35613L7.85353 6.35965C7.94465 6.36878 8.03495 6.38481 8.12364 6.40762L8.18305 6.4229C8.30295 6.45373 8.41808 6.50078 8.52526 6.56274L8.55485 6.57985C8.65442 6.63741 8.74468 6.70975 8.82254 6.79439L8.8313 6.80391C8.91016 6.88963 8.97434 6.98778 9.02125 7.0944C9.05215 7.16462 9.07532 7.23799 9.09037 7.31322L9.09378 7.33027C9.11191 7.42093 9.11967 7.51336 9.11689 7.60578L9.11251 7.75195C9.10756 7.91693 9.08628 8.08102 9.04897 8.24181L8.9504 8.66669L8.75307 9.33335L8.44907 10.4L8.33707 10.9333L8.31512 11.2011C8.31199 11.2394 8.31319 11.2778 8.31869 11.3158L8.32229 11.3407C8.3477 11.516 8.46981 11.662 8.63788 11.718C8.66837 11.7282 8.69982 11.7352 8.73174 11.7389L8.82514 11.7498C8.9437 11.7637 9.06356 11.7621 9.18171 11.7451L9.25563 11.7344C9.35953 11.7195 9.46205 11.6962 9.5622 11.6648L9.81973 11.584L9.67039 12.1333L8.73707 12.4693L8.46883 12.5326C8.30138 12.5721 8.13053 12.5955 7.95863 12.6026L7.93826 12.6034C7.77785 12.61 7.61717 12.6011 7.45847 12.5768L7.36839 12.563C7.28545 12.5503 7.20378 12.5305 7.12429 12.5037L7.08161 12.4893C6.90742 12.4305 6.74837 12.3339 6.61586 12.2065L6.60737 12.1983C6.56238 12.1551 6.52112 12.1081 6.48404 12.0578C6.35347 11.881 6.27843 11.6694 6.26845 11.4499L6.26357 11.3423C6.25926 11.2477 6.26417 11.1528 6.27823 11.0591L6.33709 10.6667L6.87042 8.80003L7.02509 8.13737L7.056 7.87718C7.06732 7.7819 7.0635 7.68544 7.04469 7.59136L7.02946 7.51521C7.02302 7.48303 7.01214 7.4519 6.99713 7.42271C6.95049 7.33203 6.86703 7.26586 6.76811 7.24113L6.66762 7.21601C6.62518 7.2054 6.58168 7.1996 6.53794 7.19872L6.33709 7.19471C6.15985 7.20887 5.98467 7.24231 5.81466 7.29443L5.60064 7.36004Z" fill="white"/>
				</svg>
			</div>

				<div class="title__block__pump">
					<div class="title__block__pump_list">

						<div class="title__block__pump__1">
							<input value="1" @change="onChangeGroupPosad" class="checkbox__block__1" v-model="groupPosad" name="posad1" type="radio" />
							<label class="checkbox__block__label__1">1</label>
						</div>

						<div class="title__block__pump__1">
							<input value="2" @change="onChangeGroupPosad" class="checkbox__block__1" v-model="groupPosad" name="posad1" type="radio" />
							<label class="checkbox__block__label__1">2</label>
						</div>

						<div class="title__block__pump__1">
							<input value="3" @change="onChangeGroupPosad" class="checkbox__block__1" v-model="groupPosad" name="posad1" type="radio" />
							<label class="checkbox__block__label__1">3</label>
						</div>

					</div>

					<div class="title__block__pump_list__2">

					<div class="title__block__pump__1">
						<input value="4" @change="onChangeGroupPosad" class="checkbox__block__1" v-model="groupPosad" name="posad1" type="radio" />
						<label class="checkbox__block__label__1">4</label>
					</div>

					<div class="title__block__pump__1">
						<input value="5" @change="onChangeGroupPosad" class="checkbox__block__1" v-model="groupPosad" name="posad1" type="radio" />
						<label class="checkbox__block__label__1">5</label>
					</div>

					<div class="title__block__pump__1__text">
						<input value="podbor" @change="onChangeGroupPosad" class="checkbox__block__1" v-model="groupPosad" name="posad1" type="radio" />
						<label class="checkbox__block__label__1">{{trans('pgno.podbor')}}</label>
					</div>

					</div>
				</div>

			</div>

			<div class="flex__item__block__1">
				<div class="title__block">{{trans('pgno.prim_komponovka')}}</div>
					<div class="title__block__pump">
						<div class="block__dm__pump__1">
              <b-form-checkbox-group v-model="selectedKomponovka">
                <b-form-checkbox v-for="k in komponovkaTypes" :key="k.id" :value="k.value" :disabled="isDisabled(k)">
                  {{ k.name }}
                </b-form-checkbox>
              </b-form-checkbox-group>

              {{ selectedKomponovka }}

<!--							<input type="checkbox" v-for="k in komponovkaTypes" :key="k.id" :value="k.name " v-model="selectedKomponovka"/>-->
<!--							<label>{{trans('pgno.yakor_truboderzhatel')}}</label>-->
						</div>
						
					
<!--						<div class="block__dm__pump__2">-->
<!--							<input type="checkbox" v-model="komponovka" value="paker" :disabled="komponovka == 'hvostovik' && mechSep == true" />-->
<!--							<label for="checkbox1">{{trans('pgno.paker')}}</label>-->
<!--						</div>-->

<!--						<div class="block__dm__pump__3">-->
<!--							<input type="checkbox" v-model="komponovka" value="hvostovik" />-->
<!--							<label for="checkbox1">{{trans('pgno.hvostovik')}}</label>-->
<!--						</div>-->

				</div>
			</div>

			<div class="flex__item__block__1">
					<div class="title__block">{{trans('pgno.kon_kolony_shtang')}}</div>
					<div class="title__block__pump">
						<div class="title__block__pump_list">

							<div class="title__block__pump__1">
								<input value="1" @change="onChangeStupColumns" class="checkbox__block__1" v-model="stupColumns" name="stup" type="radio" />
								<label class="checkbox__block__label__1">1 {{trans('pgno.stup')}}</label>
							</div>

							<div class="title__block__pump__1">
								<input value="2" @change="onChangeStupColumns" class="checkbox__block__1" v-model="stupColumns" name="stup" type="radio" />
								<label class="checkbox__block__label__1">2 {{trans('pgno.stup')}}</label>
							</div>

							<div class="title__block__pump__1">
								<input value="3" @change="onChangeStupColumns" class="checkbox__block__1" v-model="stupColumns" name="stup" type="radio" :disabled="true"/>
								<label class="checkbox__block__label__1">3 {{trans('pgno.stup')}}</label>
							</div>

						</div>
						<div class="title__block__pump_list__2">
							<div class="title__block__pump__1__heavy__down">
								<input class="checkbox__block__1" v-model="heavyDown" name="stup" type="checkbox" />
								<label class="checkbox__block__label__1">{{trans('pgno.heavy_down')}}</label>
							</div>
						</div>
					</div>
			</div>

			<div class="flex__item__block__1">
				<div class="title__block">{{trans('pgno.dm_shtang')}}, {{trans('measurements.mm')}}</div>
					<div class="title__block__pump">
						<div class="title__block__pump__list">
							<div class="title__block__pump_list">
								<div class="title__block__pump__1">
									<input class="checkbox__block__1" v-model="dmRods" value="13" type="checkbox"/>
									<label class="checkbox__block__label__1">13</label>
								</div>

								<div class="title__block__pump__1">
									<input class="checkbox__block__1" v-model="dmRods" value="16" type="checkbox"/>
									<label class="checkbox__block__label__1">16</label>
								</div>

								<div class="title__block__pump__1">
									<input class="checkbox__block__1" v-model="dmRods" value="19" type="checkbox"/>
									<label class="checkbox__block__label__1">19</label>
								</div>
							</div>

							<div class="title__block__pump_list__2">
								<div class="title__block__pump__1">
									<input class="checkbox__block__1" v-model="dmRods" value="22" type="checkbox"/>
									<label class="checkbox__block__label__1">22</label>
								</div>

								<div class="title__block__pump__1">
									<input class="checkbox__block__1" v-model="dmRods" value="25" type="checkbox"/>
									<label class="checkbox__block__label__1">25</label>
								</div>

								<div class="title__block__pump__1">
									<input class="checkbox__block__1" v-model="dmRods" value="29" type="checkbox"/>
									<label class="checkbox__block__label__1">29</label>
								</div>
							</div>
						</div>
					</div>
			</div>

			<div class="flex__item__block__1">
				<div class="title__block"><u>{{trans('pgno.marki_stali_shtang')}}</u>
					<svg style="padding-left: 4px;" @click="onClickI1()" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path fill-rule="evenodd" clip-rule="evenod" d="M12 15.9998C14.2092 15.9998 16 14.209 16 11.9998V4C16 1.79086 14.2092 -7.25981e-06 12 0L4.00035 2.62892e-05C1.79129 3.35488e-05 0.000467376 1.79078 0.000366244 3.99984L4.28319e-09 11.9997C-0.00010113 14.2089 1.79079 15.9998 4 15.9998H12ZM9.96388 4.21331C9.96388 4.83186 9.41469 5.3333 8.73722 5.3333C8.05976 5.3333 7.51057 4.83186 7.51057 4.21331C7.51057 3.59476 8.05976 3.09332 8.73722 3.09332C9.41469 3.09332 9.96388 3.59476 9.96388 4.21331ZM5.60064 7.36004L5.72864 6.8214L6.60376 6.50669L6.9106 6.42998C7.06133 6.3923 7.21494 6.3673 7.36984 6.35523L7.41538 6.35168C7.54958 6.34122 7.68445 6.34271 7.81839 6.35613L7.85353 6.35965C7.94465 6.36878 8.03495 6.38481 8.12364 6.40762L8.18305 6.4229C8.30295 6.45373 8.41808 6.50078 8.52526 6.56274L8.55485 6.57985C8.65442 6.63741 8.74468 6.70975 8.82254 6.79439L8.8313 6.80391C8.91016 6.88963 8.97434 6.98778 9.02125 7.0944C9.05215 7.16462 9.07532 7.23799 9.09037 7.31322L9.09378 7.33027C9.11191 7.42093 9.11967 7.51336 9.11689 7.60578L9.11251 7.75195C9.10756 7.91693 9.08628 8.08102 9.04897 8.24181L8.9504 8.66669L8.75307 9.33335L8.44907 10.4L8.33707 10.9333L8.31512 11.2011C8.31199 11.2394 8.31319 11.2778 8.31869 11.3158L8.32229 11.3407C8.3477 11.516 8.46981 11.662 8.63788 11.718C8.66837 11.7282 8.69982 11.7352 8.73174 11.7389L8.82514 11.7498C8.9437 11.7637 9.06356 11.7621 9.18171 11.7451L9.25563 11.7344C9.35953 11.7195 9.46205 11.6962 9.5622 11.6648L9.81973 11.584L9.67039 12.1333L8.73707 12.4693L8.46883 12.5326C8.30138 12.5721 8.13053 12.5955 7.95863 12.6026L7.93826 12.6034C7.77785 12.61 7.61717 12.6011 7.45847 12.5768L7.36839 12.563C7.28545 12.5503 7.20378 12.5305 7.12429 12.5037L7.08161 12.4893C6.90742 12.4305 6.74837 12.3339 6.61586 12.2065L6.60737 12.1983C6.56238 12.1551 6.52112 12.1081 6.48404 12.0578C6.35347 11.881 6.27843 11.6694 6.26845 11.4499L6.26357 11.3423C6.25926 11.2477 6.26417 11.1528 6.27823 11.0591L6.33709 10.6667L6.87042 8.80003L7.02509 8.13737L7.056 7.87718C7.06732 7.7819 7.0635 7.68544 7.04469 7.59136L7.02946 7.51521C7.02302 7.48303 7.01214 7.4519 6.99713 7.42271C6.95049 7.33203 6.86703 7.26586 6.76811 7.24113L6.66762 7.21601C6.62518 7.2054 6.58168 7.1996 6.53794 7.19872L6.33709 7.19471C6.15985 7.20887 5.98467 7.24231 5.81466 7.29443L5.60064 7.36004Z" fill="white"/>
					</svg>
				</div>
				<div class="title__block__pump kpod-multiselect" style="display: flex;">

					<div v-if="markShtang.length > 0" class="title-multi-select">Выбрано {{ markShtang.length }} опции</div>
					<div v-else class="title-multi-select">Выберите опции</div>
					
					<b-dropdown ref="dropdown" toggle-class="drop-filter-custom">
						<b-dropdown-form class="li-multiselect">
							
								<template class="li-multiselect">
									<div style="color: black;">
										<b-form-group v-slot="{ ariaDescribedby }" class="li-multiselect">
										<b-form-checkbox-group
											style="color: black;"
											id="checkbox-group-1"
											v-model="markShtang"
											:options="markShtangs"
											:aria-describedby="ariaDescribedby"
											name="flavour-1"
										></b-form-checkbox-group>
										</b-form-group>
									</div>
								</template>

						</b-dropdown-form>
					</b-dropdown>
		
				</div>
			</div>

			<div class="flex__item__block__1__koroz">
				<div class="title__block__koroz">
					<u>{{trans('pgno.korozinost_dob_prod')}}</u>
					<svg style="padding-left: 4px;" @click="onClickI2()" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path fill-rule="evenodd" clip-rule="evenod" d="M12 15.9998C14.2092 15.9998 16 14.209 16 11.9998V4C16 1.79086 14.2092 -7.25981e-06 12 0L4.00035 2.62892e-05C1.79129 3.35488e-05 0.000467376 1.79078 0.000366244 3.99984L4.28319e-09 11.9997C-0.00010113 14.2089 1.79079 15.9998 4 15.9998H12ZM9.96388 4.21331C9.96388 4.83186 9.41469 5.3333 8.73722 5.3333C8.05976 5.3333 7.51057 4.83186 7.51057 4.21331C7.51057 3.59476 8.05976 3.09332 8.73722 3.09332C9.41469 3.09332 9.96388 3.59476 9.96388 4.21331ZM5.60064 7.36004L5.72864 6.8214L6.60376 6.50669L6.9106 6.42998C7.06133 6.3923 7.21494 6.3673 7.36984 6.35523L7.41538 6.35168C7.54958 6.34122 7.68445 6.34271 7.81839 6.35613L7.85353 6.35965C7.94465 6.36878 8.03495 6.38481 8.12364 6.40762L8.18305 6.4229C8.30295 6.45373 8.41808 6.50078 8.52526 6.56274L8.55485 6.57985C8.65442 6.63741 8.74468 6.70975 8.82254 6.79439L8.8313 6.80391C8.91016 6.88963 8.97434 6.98778 9.02125 7.0944C9.05215 7.16462 9.07532 7.23799 9.09037 7.31322L9.09378 7.33027C9.11191 7.42093 9.11967 7.51336 9.11689 7.60578L9.11251 7.75195C9.10756 7.91693 9.08628 8.08102 9.04897 8.24181L8.9504 8.66669L8.75307 9.33335L8.44907 10.4L8.33707 10.9333L8.31512 11.2011C8.31199 11.2394 8.31319 11.2778 8.31869 11.3158L8.32229 11.3407C8.3477 11.516 8.46981 11.662 8.63788 11.718C8.66837 11.7282 8.69982 11.7352 8.73174 11.7389L8.82514 11.7498C8.9437 11.7637 9.06356 11.7621 9.18171 11.7451L9.25563 11.7344C9.35953 11.7195 9.46205 11.6962 9.5622 11.6648L9.81973 11.584L9.67039 12.1333L8.73707 12.4693L8.46883 12.5326C8.30138 12.5721 8.13053 12.5955 7.95863 12.6026L7.93826 12.6034C7.77785 12.61 7.61717 12.6011 7.45847 12.5768L7.36839 12.563C7.28545 12.5503 7.20378 12.5305 7.12429 12.5037L7.08161 12.4893C6.90742 12.4305 6.74837 12.3339 6.61586 12.2065L6.60737 12.1983C6.56238 12.1551 6.52112 12.1081 6.48404 12.0578C6.35347 11.881 6.27843 11.6694 6.26845 11.4499L6.26357 11.3423C6.25926 11.2477 6.26417 11.1528 6.27823 11.0591L6.33709 10.6667L6.87042 8.80003L7.02509 8.13737L7.056 7.87718C7.06732 7.7819 7.0635 7.68544 7.04469 7.59136L7.02946 7.51521C7.02302 7.48303 7.01214 7.4519 6.99713 7.42271C6.95049 7.33203 6.86703 7.26586 6.76811 7.24113L6.66762 7.21601C6.62518 7.2054 6.58168 7.1996 6.53794 7.19872L6.33709 7.19471C6.15985 7.20887 5.98467 7.24231 5.81466 7.29443L5.60064 7.36004Z" fill="white"/>
					</svg>

				</div>
				<div class="title__block__koroz__checkbox">
					<input class="checkbox__block__1" value="antiCorrosion" type="radio" name="korprod1" v-model="corrosion" @change="onChangeCorrosion"/>
					<label class="checkbox__block__label__1">{{trans('pgno.nekorozionnaya')}}</label>
				</div>

				<div class="title__block__koroz__checkbox__2">
					<input class="checkbox__block__1" value="mediumCorrosion"  type="radio" name="korprod1" v-model="corrosion" @change="onChangeCorrosion"/>
					<label for="" class="checkbox__block__label__1">{{trans('pgno.srenekorozionnaya')}}</label>
				</div>

				<div class="title__block__koroz__checkbox__3">
					<input class="checkbox__block__1" value="highCorrosion"  type="radio" name="korprod1" v-model="corrosion" @change="onChangeCorrosion"/>
					<label for="" class="checkbox__block__label__1">{{trans('pgno.visokorozionnaya')}}</label>
				</div>

				<div class="title__block__koroz__checkbox__4">
					<input v-model="h2s" class="checkbox__block__1" type="checkbox" name="korprod1" />
					<label for="" class="checkbox__block__label__1">{{trans('pgno.h2s')}}</label>
				</div>


			</div>

			<div class="flex__item__block__1__koroz">
				<div class="title__block__koroz">{{trans('pgno.pot_rezhim')}}</div>
				<div class="flex__item__block__sixth__block">
					<div class="block__text__5">{{trans('pgno.dav_nasos_minim')}}</div>
					<input v-model="pintakeMin" class="square2 block__6__input" type="text" @change="onChangePintakeMin">

					<div class="block__text__6">{{trans('pgno.gs_nasos_maks')}}</div>
					<input v-model="gasMax" class="square2 block__7__input" type="text" @change="onChangeGasMax">
				</div>
				
			</div>

		<div class="flex__item__block__1_incl" >
			<div class="title__block">{{trans('pgno.podbor_glubiny_spuska')}}</div>
			<div class="title__block__min__1"><span>{{trans('pgno.dlina_polki')}}</span>
			<input v-model="inclStep" @change="onChangeInclStep"  class="square2 block__1__input" type="text"></div>
		</div>


				<button type="button" class="submit_button" @click="onSubmitParams()">
                        {{trans('pgno.primenit_default')}}
                </button>

				<button type="button" class="submit_button" @click="onSubmitParams()">
                        {{trans('pgno.primenit_korrektirovki')}}
                </button>

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
							<div class="title__table__1">{{trans('pgno.tablica8')}}</div>
							<table class="table__1">
									<tr style="color: white;">
										<th class="table__th__1">{{trans('pgno.group_posadka')}}, {{trans('measurements.mm')}}</th>
										<th class="table__th__1">{{trans('pgno.min_zazor')}}, {{trans('measurements.mm')}}</th>
										<th class="table__th__1" style="width: 60%;">{{trans('pgno.max_zazor')}}, {{trans('measurements.mm')}}	</th>
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

		<modal name="modalTable3" :draggable="true" :width="900" :height="640"
			:adaptive="true">
			<div class="modal-bign modal-bign-container">
				<div class="modal-bign-header">
					<div class="modal-bign-title"></div>
					<button type="button" class="modal-bign-button" @click="closeModal('modalTable3')">
						{{trans('pgno.zakrit')}}
					</button>
				</div>
				<div>
					<div class="nno-modal-button-wrapper">
						<div class="svg__image">
							<img :src="svgTableN1"/>
						</div>
					</div>
				</div>
			</div>
		</modal>

		<modal name="modalTable2" :draggable="true" :width="1050" :height="650"
			:adaptive="true">
			<div class="modal-bign modal-bign-container">
				<div class="modal-bign-header">
					<div class="modal-bign-title"></div>
					<button type="button" class="modal-bign-button" @click="closeModal('modalTable2')">
						{{trans('pgno.zakrit')}}
					</button>
				</div>
				<div>
					<div class="nno-modal-button-wrapper" style="overflow: auto;">
						<div class="svg__image">
							<img :src="svgTableN2"/>
						</div>
					</div>
				</div>
			</div>
		</modal>
	</div>



</template>
<script src="./js/Shgn"></script>

<style scoped>
.title-multi-select {
	width: auto;
	position: relative;
    right: 5px;
}

.dropdown-menu.show {
    width: 176px;
    display: flex;
    flex-direction: column;
}

.kpod-multiselect {
	display: flex;
	flex-direction: row;
    justify-content: left;
	padding-block: 30px;
}

.li-multiselect {
	background: #333975;
	width: 131px;
	height: 215px;
	margin: 0;
}

.nno-modal-buttons-container {
	margin-left: 35px;
	width: 100%;
	height: 100%;
} 

.svg__image {
	width: 100%;
	height: 100%;
}

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
  justify-content: center;
}

.flex__item__block__1 {
  background-color: #272953;
  padding: 5px;
  width: 302px;
  height: 130px;
  margin-top: 10px;
  position: relative;
  left: 0px;
  color: white;
  font-weight: bold;
  font-size: 1em;
  text-align: center;
}

.flex__item__block__1_incl {
  background-color: #272953;
  padding: 5px;
  width: 342px;
  height: 130px;
  margin-top: 10px;
  position: relative;
  left: 0px;
  color: white;
  font-weight: bold;
  font-size: 1em;
  text-align: center;
}

.flex__item__block__1__koroz {
  background-color: #272953;
  padding: 5px;
  width: 896px;
  height: 80px;
  margin-top: 10px;
  position: relative;
  left: 0px;
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
height: 32px;
text-align: left;
background: #323370;
padding-left: 5px;
padding-top: 5px;
}

.title__block__koroz {
height: 32px;
width: 896px;
text-align: left;
background: #323370;
padding-left: 5px;
padding-top: 5px;
}

.title__block__koroz__checkbox {
height: 32px;
width: 896px;
text-align: left;
background: #2b2e5e;
padding-left: 5px;
padding-top: 5px;
}

.title__block__koroz__checkbox__2 {
width: 250px;
position: relative;
left: 150px;
bottom: 25px;
}

.title__block__koroz__checkbox__3 {
width: 250px;
position: relative;
left: 370px;
bottom: 55px;
}

.title__block__koroz__checkbox__4 {
width: 250px;
position: relative;
left: 600px;
bottom: 85px;
}

.title__block__min__1 {
height: 45px;
text-align: left;
background: #2b2e5e;
padding-top: 10px;
padding-left: 5px;
}

.kpod-input-text {
width: 80px;
text-align: center;
margin-top: 10px;
}

.title__block__max {
height: 90px;
text-align: left;
background: #2b2e5e;
padding-top: 3px;
padding-left: 5px;
}

.title__block__pump {
height: 90px;
text-align: left;
background: #2b2e5e;
padding-left: 20px;
}

.title__block__kpod {
height: 20px;
width: auto;
text-align: left;
background: #2b2e5e;
padding-right: 5px;
font-size: 12px;
padding-block: 2px;
}

.title__block__pump__1 {
height: 29px;
width: 65px;
text-align: left;
background: #2b2e5e;
padding-right: 5px;
}

.title__block__pump__1__flex {
display: flex;
width: 65px;
text-align: left;
background: #2b2e5e;
padding-right: 5px;
}

.title__block__pump__1__heavy__down {
height: 29px;
width: 85px;
text-align: left;
background: #2b2e5e;
padding-right: 5px;
}

.title__block__pump__1__text {
height: 20px;
width: 85px;
text-align: left;
background: #2b2e5e;
padding-right: 5px;
}

.title__block__max__1 {
height: 45px;
text-align: left;
background: #2b2e5e;
padding-top: 10px;
padding-left: 5px;
}

.title__block__pump_list {
height: 60px;
width: 30px;
padding-top: 2px;
}

.title__block__pump_list__2 {
height: 60px;
width: 30px;
position: absolute;
left: 120px;
bottom: 30px;
}

.title__block__pump_list__3 {
height: 60px;
width: 30px;
position: absolute;
left: 220px;
bottom: 30px;
}

.block__dm__pump__1 {
height: 30px;
}

.block__dm__pump__2 {
height: 30px;
}

.block__dm__pump__3{
height: 18px;
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
width: 305px;
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
top: 45px;
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
height: 32px;
width: 896px;
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
width: 75px;
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
width: 171px;
height: 20px;
position: relative;
top: -13px;
left: 160px;
}

.block__fourth__block__radio__2 {
display: block;
width: 170px;
height: 20px;
position: relative;
top: -40px;
left: 350px;
}

.block__fourth__block__radio__3 {
display: block;
width: 170px;
height: 20px;
position: relative;
top: -68px;
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
width: 180px;
height: 22px;
border: 1px solid rgba(34, 36, 82, 1);
background-color: #323370;
position: relative;
left: 30px;
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
width: 180px;
height: 22px;
border: 1px solid rgba(34, 36, 82, 1);
background-color: #323370;
position: relative;
left: 22px;
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
right: 55px;
top: -14px;
border: 1px solid rgba(34, 36, 82, 1);
background-color: #323370;
}

.block__7__input {
width: 110px;
height: 22px;
position: relative;
right: -380px;
top: -55px;
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
	top: 15px;	
top: 15px;
	top: 15px;	
top: 15px;
	top: 15px;	
top: 15px;
	top: 15px;	
top: 15px;
	top: 15px;	
top: 15px;
	top: 15px;	
top: 15px;
	top: 15px;	
top: 15px;
	top: 15px;	
top: 15px;
	top: 15px;	
top: 15px;
	top: 15px;	
top: 15px;
	top: 15px;	
top: 15px;
	top: 15px;	
top: 15px;
	top: 15px;	
top: 15px;
	top: 15px;	
top: 15px;
	top: 15px;	
top: 15px;
}

.block__text__5 {
width: 300px;
height: 20px;
position: relative;
left: 5px;
top: 5px;
}

.block__text__6 {
width: 300px;
height: 20px;
position: relative;
left: 475px;
top: -37px;
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

.block__checkbox__6__spec {
position: relative;
top: -83px;
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
top: -143px;
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
margin-left: 0;
}

.table-border-gno-right {
border-right-color: #3b4172;
border-right-style: solid;
border-right-width: 1px;
padding-top: 2px;
}

.small-input-box {
width: 60px;
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

.input-box-gno-block-3 {
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
margin-inline: 50px;
margin-top: 30px;
}

.kpod-input-label-box {
width: 160px;
}
.block1 {
width: auto;
}

.block2 {
width: auto;
}

.block3 {
width: auto;
}

.block4 {
width: auto;
}

.label-kpod {
width: 200px;
}

.input-box-gno.k-pod {
width: 50px;
margin-right: 5px;
}

.input-box-gno.podbor-kpod-block-1 {
width: 80px;
margin-inline: 0px;
margin-top: 0px;
margin-right: 5px;
}

.input-box-gno.podbor-kpod-block-2 {
width: 85px;
margin-inline: 0px;
margin-top: 0px;
margin-right: 5px;
}

.input-box-gno.podbor-kpod-block-3 {
width: 50px;
margin-inline: 0px;
margin-top: 0px;
}

.input-box-gno.podbor-kpod-select-block {
width: 100px;
margin-inline: 0px;
margin-top: 0px;
}

.submit_button {
width: 250px;
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
margin-left: 30px;
margin-top: 30px;
vertical-align: middle;
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