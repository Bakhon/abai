<template>
    <div>
        <modal
                class="modal-bign-wrapper"
                name="modalCorporateManager"
                draggable=".modal-bign-header"
                :width="700"
                :height="260"
                style="background: transparent;"
                :adaptive="true"
        >
            <div class="modal-bign modal-bign-container">
                <div class="modal-bign-header">
                    <div class="modal-bign-title modal_header">Генеральный директор</div>
                    <div class="btn-toolbar">
                        <button type="button" class="modal-bign-button" @click="$modal.hide('modalCorporateManager')">
                            {{trans('pgno.zakrit')}}
                        </button>
                    </div>
                </div>
                <div class="edit-block row mt-2">
                    <div class="p-1 col-12 d-flex">
                        <div class="col-4 text-left pt-2">Аватар</div>
                        <img ref="avatar" width="40px" class="col-1" v-if="manager.avatar" :src="'/img/kpd-tree/managers/' + manager.avatar">
                        <img ref="avatarEmpty" width="40px" class="col-1" v-else src="">
                        <input type="file" class="form-control-file col-7" @change="selectFile">
                    </div>
                    <div class="p-1 col-12 d-flex">
                        <div class="col-4 text-left pt-2">Имя</div>
                        <input class="input_kpd p-2 col-7" type="text" v-model="manager.name">
                    </div>
                    <div class="p-1 col-12 d-flex">
                        <div class="col-4 text-left pt-2">Должность</div>
                        <input class="input_kpd p-2 col-7" type="text" v-model="manager.title">
                    </div>
                </div>
                <div class="d-flex justify-content-center mt-3">
                    <button type="button" class="modal-button_save mr-2" @click="store">
                        {{trans('kpd_tree.save')}}
                    </button>
                </div>
            </div>
        </modal>
    </div>
</template>

<script>
import {globalloadingMutations} from '@store/helpers';

export default {
    data: function () {
        return {
            manager: {
                'name': '',
                'title': '',
                'avatar': null,
                'img': ''
            }
        };
    },
    methods: {
        selectFile(event) {
            this.manager.img = event.target.files[0];
            let reader = new FileReader();
            reader.onload = (event) => {
                if (this.$refs.avatar) {
                    this.$refs.avatar.src = event.target.result;
                } else {
                    this.$refs.avatarEmpty.src = event.target.result;
                }
            };
            reader.readAsDataURL(event.target.files[0]);
        },
        async store() {
            this.SET_LOADING(true);
            let uri = this.localeUrl("/store-kpd-corporate-manager");
            let formData = new FormData();
            if (!this.manager.img) {
                formData.append("avatar", this.manager.avatar);
            } else {
                formData.append("avatar", this.manager.img);
            }
            formData.append('name', this.manager.name);
            formData.append('title', this.manager.title);
            await this.axios.post(uri, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                }
            }).then((response) => {
                if (response.status !== 200) {
                    this.showToast('Проверьте вложенный файл и данные.','Ошибка!','danger');
                    return;
                }
                this.showToast('Данные успешно сохранены/обновлены.','Успешно','success');
                this.SET_LOADING(false);
            });
        },
        ...globalloadingMutations([
            'SET_LOADING'
        ]),
    },
    watch: {
        corporateManager: function () {
            _.forEach(Object.keys(this.manager), (key) => {
                this.manager[key] = this.corporateManager[key];
            });
        },
    },
    props: ['corporateManager'],
}


</script>
<style scoped lang="scss">
.modal_header {
    margin: 0 auto;
}
.modal-button_save {
    border: none;
    outline: none;
    background: #2d995b;
    color: white;
    font-weight: normal;
    font-size: 16px;
    width: 100px;
    border-radius: 8px;
}
.modal-button_delete {
    border: none;
    outline: none;
    background: #C82333;
    color: white;
    font-weight: normal;
    font-size: 16px;
    width: 100px;
    border-radius: 8px;
}
.edit-block {

}
.status__red {
    color: #C82333;
}
.input_kpd {
    background: #1A1D46;
    color: white;
    border-radius: 5px;
    border: none;
    width: 100%;
}
.indicator-growth {
    background: url(/img/visualcenter3/green-arrow.svg) no-repeat;
    height: 15px;
    width: 15px;
    background-size: contain;
    float: left;
    margin-top: 5px;
    margin-right: 5px;
    overflow: hidden;
}

.indicator-fall {
    background: url(/img/visualcenter3/red-arrow.svg) no-repeat;
    height: 15px;
    width: 15px;
    background-size: contain;
    float: left;
    margin-top: 5px;
    margin-right: 5px;
    overflow: hidden;
}
.polarity_selected {
    filter: brightness(150%);
}
.polarity_not-selected {
    filter: brightness(50%);
}
</style>