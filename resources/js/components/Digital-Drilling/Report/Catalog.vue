<template>
    <div class="catalog-page">
        <div class="catalog-body">
            <div class="catalog-names">
                <div class="header-name">
                    Каталоги
                </div>
                <div class="defaultScroll">
                    <div class="names-body">
                        <div class="name" v-for="(catalog, i ) in catalogs" :class="{active: i==currentCatalogIndex}" @click="changeCurrentCatalog(i)">
                            {{ catalog.table_name_ru }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="catalog-list" v-if="catalogs.length>0">
                <div class="header-name">
                    <button class="add" @click="addCatalog">
                        <img src="/img/digital-drilling/cat-add.svg" alt="">
                    </button>
                </div>
                <div class="defaultScroll">
                    <div class="catalog-table">
                        <table class="table defaultTable">
                            <tbody>
                                <tr>
                                    <th>ID</th>
                                    <th>Название</th>
                                    <th v-if="catalogs[currentCatalogIndex].table_name == 'company'">БИН</th>
                                    <th>Операций</th>
                                </tr>
                                <tr v-for="data in catalogData">
                                    <td>{{data.id}}</td>
                                    <td class="table-text-name">{{data.name_ru}}</td>
                                    <td v-if="catalogs[currentCatalogIndex].table_name == 'company'">{{data.bin}}</td>
                                    <td class="operations-td">
                                        <div class="operations">
                                            <button @click="editCatalog(data)">
                                                <img src="/img/digital-drilling/cat-edit.svg" alt="">
                                                <span>Изменить</span>
                                            </button>
                                            <button class="delete" @click="deleteCatalog(data)">
                                                <img src="/img/digital-drilling/cat-delete.svg" alt="">
                                                <span>Удалить</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="catalog-add" v-if="catalogModal">
            <div class="catalog-add-inner">
                <div class="catalog-add-form">
                    <div class="catalog-add-header">
                        <div class="catalog-add-title">
                            {{catalogs[currentCatalogIndex].table_name_ru}}
                        </div>
                        <div class="catalog-add-close" @click="catalogModal=false">
                            Закрыть
                        </div>
                    </div>
                    <div class="catalog-add-content">
                        <input type="text" v-model="bin" :class="{error: this.bin.toString().length !=12}" v-if="catalogs[currentCatalogIndex].table_name == 'company'" placeholder="BIN">
                        <input type="text"
                               v-model="catalogForAction.name_ru"
                               :class="{error: !error.text && !catalogForAction.name_ru }"
                               placeholder="Название"
                        >
                        <button @click="upload">{{trans('app.save')}}</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="catalog-add" v-if="catalogModalEdit">
            <div class="catalog-add-inner">
                <div class="catalog-add-form">
                    <div class="catalog-add-header">
                        <div class="catalog-add-title">
                            {{catalogs[currentCatalogIndex].table_name_ru}}
                        </div>
                        <div class="catalog-add-close" @click="catalogModalEdit=false">
                            Закрыть
                        </div>
                    </div>
                    <div class="catalog-add-content">
                        <input type="text" v-model="bin" :class="{error: this.bin.toString().length !=12}" v-if="catalogs[currentCatalogIndex].table_name == 'company'" placeholder="BIN">
                        <input type="text"
                               v-model="catalogForAction.name_ru"
                               :class="{error: !error.text && !catalogForAction.name_ru }"
                               placeholder="Название"
                        >
                        <button @click="edit">{{trans('app.save')}}</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="catalog-add" v-if="catalogModalDelete">
            <div class="catalog-add-inner">
                <div class="catalog-add-form">
                    <div class="catalog-add-header">
                        <div class="catalog-add-title">
                            {{catalogs[currentCatalogIndex].table_name_ru}}
                        </div>
                        <div class="catalog-add-close" @click="catalogModalDelete=false">
                            Закрыть
                        </div>
                    </div>
                    <div class="catalog-add-content">
                        <span class="text-center">
                            Вы точно хотите удалить? </span>
                        <button @click="deleteCatalogFrom">удалить</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="catalog-add" v-if="catalogModalError">
            <div class="catalog-add-inner">
                <div class="catalog-add-form">
                    <div class="catalog-add-header">
                        <div class="catalog-add-title">
                            {{catalogs[currentCatalogIndex].table_name_ru}}
                        </div>
                        <div class="catalog-add-close" @click="catalogModalError=false">
                            Закрыть
                        </div>
                    </div>
                    <div class="catalog-add-content">
                        <span class="text-center">Ошибка!</span>
                        <span class="text-center">Вы не можете удалить, попробуйте изменить.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Catalog",
        data(){
            return{
                catalogs: [],
                currentCatalogIndex: 0,
                currentCatalog: 0,
                catalogData: [],
                catalogModal: false,
                catalogModalEdit: false,
                catalogModalDelete: false,
                catalogModalError: false,
                catalogForAction: {
                    id: null,
                    name_ru: null
                },
                error: {
                    text: null
                },
                bin: "",
            }
        },
        mounted(){
            this.getCatalogs()
        },
        methods:{
            addCatalog(){
                this.catalogForAction = {
                    id: null,
                    name_ru: null
                },
                this.bin = ""
                this.catalogModal = true
            },
            editCatalog(catalog){
                if (this.catalogs[this.currentCatalogIndex].table_name == 'company'){
                    if (catalog.bin){
                        this.bin = catalog.bin
                    }
                }
                Object.assign(this.catalogForAction, catalog);
                this.catalogModalEdit = true
            },
            deleteCatalog(catalog){
                Object.assign(this.catalogForAction, catalog);
                this.catalogModalDelete = true
            },
            edit(){
                if (this.catalogs[this.currentCatalogIndex].table_name == 'company'){
                    this.catalogForAction.bin = this.bin
                }
               if (this.catalogForAction.name_ru != "" && this.bin.toString().length ==12){
                   this.axios.put(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/dictionary/' +
                       this.catalogs[this.currentCatalogIndex].table_name + '/', this.catalogForAction).then((response) => {
                       let data = response.data;
                       console.log(data)
                       this.getCatalogData()
                   }).catch((e)=>{
                       console.log(e)
                   });
                   this.catalogModalEdit = false
                   this.catalogForAction = {
                       id: null,
                       name_ru: null
                   }
                   this.bin = ""
               } else{
                    this.error.text = 'ERROR'
               }
            },
            upload(){
                if (this.catalogs[this.currentCatalogIndex].table_name == 'company'){
                    this.catalogForAction.bin = this.bin
                }
                if (this.catalogForAction.name_ru != "" && this.bin.toString().length ==12){
                    this.axios.post(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/dictionary/' +
                        this.catalogs[this.currentCatalogIndex].table_name + '/', this.catalogForAction).then((response) => {
                        let data = response.data;
                        console.log(data)
                        this.getCatalogData()
                    }).catch((e)=>{
                        console.log(e)
                    });
                    this.catalogModal = false
                    this.catalogForAction = {
                        id: null,
                        name_ru: null
                    }
                    this.bin = ""
                } else{
                    this.error.text = 'ERROR'
                }
            },
            deleteCatalogFrom(){
                this.axios.delete(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/dictionary/' +
                    this.catalogs[this.currentCatalogIndex].table_name + '/'+ this.catalogForAction.id).then((response) => {
                    let data = response.data;
                    console.log(data)
                    this.getCatalogData()
                }).catch((e)=>{
                    console.log(e)
                    this.catalogModalError = true
                });
                this.catalogModalDelete = false
                this.catalogForAction = {
                    id: null,
                    name_ru: null
                }
                this.bin = ""
            },
            changeCurrentCatalog(index){
                this.currentCatalogIndex = index
                this.getCatalogData()
            },
            getCatalogData(){
                let url = process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/dictionary/' +
                    this.catalogs[this.currentCatalogIndex].table_name + '/'
                if (this.catalogs[this.currentCatalogIndex].table_name == 'company'){
                    url = process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/updating_dictionaries/' +
                        this.catalogs[this.currentCatalogIndex].table_name + '/'
                }
                this.axios.get(url).then((response) => {
                    let data = response.data;
                    this.catalogData = data
                }).catch((e)=>{
                    console.log(e)
                });

            },
            async getCatalogs(){
                try{
                    await this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/dictionaries/').then((response) => {
                        let data = response.data;
                        if (data) {
                            this.catalogs =  data
                            this.getCatalogData()
                        } else {
                            console.log('No data');
                        }
                    });
                }
                catch (e) {
                    console.log(e)
                }
            },
        },
    }
</script>

<style scoped>
.catalog-page *{
    box-sizing: border-box;
}
.defaultScroll{
   height: calc(100vh - 155px);
    overflow-y: scroll;
    overflow-x: hidden;
}
.catalog-page{
    width: calc(100% - 24px);
    font-size: 18px;
    line-height: 22px;

    color: #FFFFFF;
}
.catalog-body{
    width: 100%;
    display: flex;
    justify-content: space-between;
}
.catalog-names{
    background: #272953;
    flex: 0 0 300px;
}
.header-name{
    background: #323370;
    padding: 13px;
}
.names-body{
    padding: 8px;
}
.name{
    background: #3A4280;
    border-radius: 5px;
    padding: 13px;
    margin-bottom: 8px;
    cursor: pointer;
}
.name:hover{
    background: #3366ffad;
}
.name.active{
    background: #3366FF;
}
.name:last-child{
    margin-bottom: 0;
}
.catalog-list{
    width: calc(100% - 310px);
}
.catalog-list .header-name{
    border: 1px solid #545580;
    padding: 8px;
}
.catalog-list .defaultScroll{
    border: 3px solid #272953;
    padding: 6px;
}
.add{
    margin-left: auto;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 0px;
    background-color: transparent;
    width: 30px;
    height: 30px;
    transition: ease-in-out hover 2s;
}
.add:hover{
    background-color: #837e7e8f;
    border-radius: 50%;
}
.catalog-table{
    background: #272953;
    min-height: 100%;
}
td{
    text-align: center!important;
    background: #2B2E5E;
    border: 0.5px solid #454D7D;
    padding: 10px!important;
}
.table-text-name{
    width: 60% !important;
}
.operations-td{
    max-width: 500px;
}
.operations{
    max-width: 490px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
}
.operations button.delete{
    background: rgba(237, 85, 100, 0.4);
    border: 0.5px solid #ED5564;
}
.operations button{
    background: #334296;
    border: 0.5px solid #3366FF;
    box-sizing: border-box;
    padding: 8px 15px;
    min-width: 100px;
    flex: 0 0 48%;
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
}
.operations button:hover{
    background: #3366FF;
}
.operations button.delete:hover{
    background: #C63E4B;
}
.operations button span{
    margin-left: 5px;
}
.catalog-add{
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    z-index: 20000;
    background: rgba(0, 0, 0, 0.5);
}
.catalog-add-inner{
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}
.catalog-add-form{
    min-width: 300px;
    width: max-content;
    min-height: 200px;
    height: auto;
    background: #272953;
    border: 2px solid #656A8A;
    border-radius: 8px;
    padding: 20px 14px;
}
.catalog-add-header{
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 30px;
    font-weight: bold;
    font-size: 18px;
    line-height: 22px;
    color: #FFFFFF;
}
.catalog-add-title{
    width: 206px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.catalog-add-close{
    flex: 0 0 90px;
    height: 25px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #656A8A;
    border-radius: 6px;
    font-size: 16px;
    line-height: 19px;
    cursor: pointer;
}
.catalog-add-content input{
    display: block;
    width: 100%;
    margin-bottom: 30px;
    background: #1F2142;
    border: 1px solid #454FA1;
    border-radius: 4px;
    padding: 7px;
    color: #ffffff;
}
.catalog-add-content span{
    display: block;
    margin-bottom: 20px;
}
.catalog-add-content input.error{
    border-color: red;
}
.catalog-add-content input:focus{
    outline: none;
}
.catalog-add-content.flex{
    display: flex;
}
.catalog-add-content.flex .catalog-add-close{
    background-color: rgba(101, 106, 138, 1);;
}
.catalog-add-content.flex button{
    width: 45%;
    padding: 0!important;
    height: 30px!important;
}
.m-height{
    min-height: 140px;
}
.catalog-add-content button{
    background: rgba(46, 80, 233, 0.5);
    border: 0;
    margin: 0 auto;
    display: block;
    padding: 8px 40px;
    border-radius: 6px;
    color: #ffffff;
}
</style>