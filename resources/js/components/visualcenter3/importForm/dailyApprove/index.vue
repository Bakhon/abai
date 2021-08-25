<template>
    <div class="page-wrapper">
        <div class="block-container row">
            <div class="col-12 header-title p-2">
                {{trans('visualcenter.dailyApprove.title')}}
            </div>
        </div>
        <div class="content-container">
            <div class="block-container row mt-10px">
                <div class="col-12 header-title row m-0 table-header">
                    <span class="col-3 p-2">{{trans('visualcenter.dailyApprove.toApprove')}}</span>
                    <span class="col-9 p-2">{{trans('visualcenter.dailyApprove.changeList')}}</span>
                </div>
                <div class="col-4 menu-block">
                    <div class="header-title row m-0 mt-3">
                        <div
                                v-for="(item,index) in compared"
                                :class="[item.selected ? 'selected-company' : '',
                                    item.isProcessed ? 'processed-company' : '',
                                    'col-12 row approve-list p-2 mt-1']"
                                @click="selectCompany(item.dzoName,index)"
                        >
                            <span class="col-1 right-arrow mt-2 ml-4"></span>
                            <span class="col-3">
                                {{item.date}}
                            </span>
                            <span class="col-6">
                                {{dzoCompanies[item.dzoName]}}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-8 details-block">
                    <div class="header-title row m-0 mt-3">
                        <div
                                class="row change-list"
                                v-if="Object.keys(currentDzo).length > 0"
                        >
                            <span class="col-2 column-title">{{trans('visualcenter.importForm.executor')}}: </span>
                            <span class="column-parameter col-4">{{currentDzo.userName}}</span>
                            <div v-if="!currentDzo.isProcessed" class="col-6 row justify-content-end">
                                <span clas="col-4">{{approvers.firstMaster.name}}</span>
                                <span
                                        class="col-4 menu__button m-1 ml-5 button_approve"
                                        :class="[currentDzo.isFirstMasterApproved !== null ? currentDzo.isFirstMasterApproved ? 'button_approved' : 'button_disabled' : '']"
                                        @click="approve(approvers.firstMaster)"
                                >
                                    {{trans(currentDzo.firstMasterApproveTranslation)}}</span>
                                <span
                                        class="col-3 menu__button m-1 button_decline"
                                        @click="decline"
                                        :class="[currentDzo.isFirstMasterApproved !== null ? !currentDzo.isFirstMasterApproved ? 'button_disabled' : 'button_disabled' : '']"
                                >
                                    {{trans('visualcenter.dailyApprove.cancel')}}
                                </span>
                            </div>
                            <div v-else class="col-4 row">
                                {{currentStatus}}
                            </div>
                            <span class="col-2 column-title">{{trans('visualcenter.importForm.reason')}}: </span>
                            <span class="column-parameter col-4">{{currentDzo.reason}}</span>
                            <div v-if="!currentDzo.isProcessed" class="col-6 row justify-content-end">
                                <span clas="col-4">{{approvers.secondMaster.name}}</span>
                                <span
                                        class="col-4 menu__button m-1 ml-5 button_approve"
                                        :class="[currentDzo.isSecondMasterApproved !== null ? currentDzo.isSecondMasterApproved ? 'button_approved' : 'button_disabled' : '']"
                                        @click="approve(approvers.secondMaster)"
                                >
                                    {{trans(currentDzo.secondMasterApproveTranslation)}}</span>
                                <span
                                        class="col-3 menu__button m-1 button_decline"
                                        :class="[currentDzo.isSecondMasterApproved !== null ? !currentDzo.isSecondMasterApproved ? 'button_approved' : 'button_disabled' : '']"
                                        @click="decline"
                                >
                                    {{trans('visualcenter.dailyApprove.cancel')}}</span>
                            </div>
                            <div v-if="!currentDzo.isProcessed" class="col-6"></div>
                            <div v-if="!currentDzo.isProcessed" class="col-6 row justify-content-end">
                                <span clas="col-4">{{approvers.mainMaster.name}}</span>
                                <span class="col-4 menu__button m-1 ml-5 button_approve" @click="approve(approvers.mainMaster)">{{trans('visualcenter.dailyApprove.approve')}}</span>
                                <span class="col-3 menu__button m-1 button_decline" @click="decline">{{trans('visualcenter.dailyApprove.cancel')}}</span>
                            </div>
                            <span class="col-12 header-title p-2">{{trans('visualcenter.dailyApprove.plannedChanges')}}</span>
                            <div class="col-12 row p-1 m-0 table_header">
                                <span class="col-3">{{trans('visualcenter.dailyApprove.dzo')}}/{{trans('visualcenter.dailyApprove.field')}}</span>
                                <span class="col-5">{{trans('visualcenter.dailyApprove.param')}}</span>
                                <span class="col-2">{{trans('visualcenter.dailyApprove.current')}}</span>
                                <span class="col-2">{{trans('visualcenter.dailyApprove.new')}}</span>
                            </div>
                            <div
                                    v-for="(item, name) in currentDzo.difference"
                                    class="row col-12 m-0 mt-1 p-1 difference-list"
                                    v-if="name !== 'import_field'"
                            >
                                <div class="col-12 row p-0 m-0">
                                    <span class="col-3 table_body">{{trans('visualcenter.dailyApprove.dzo')}}</span>
                                    <span class="col-5 table_body">{{names[name]}}</span>
                                    <span class="col-2 table_body">{{item.actualDetail}}</span>
                                    <span class="col-2 table_body">{{item.currentDetail}}</span>
                                </div>
                            </div>
                            <div
                                    v-if="Object.keys(currentDzo.difference.import_field).length > 0"
                                    v-for="(value, fieldName) in currentDzo.difference.import_field"
                                    class="col-12 p-0"
                            >
                                <div
                                        v-if="Object.keys(value).length > 0"
                                        v-for="(fieldValue, field) in value"
                                        class="col-12 row m-0 mt-1 p-1 difference-list"
                                >
                                    <span class="col-3 table_body">{{fieldName}}</span>
                                    <span class="col-5 table_body">{{names[field]}}</span>
                                    <span class="col-2 table_body child-actual">{{fieldValue.actualDetail}}</span>
                                    <span class="col-2 table_body child-current">{{fieldValue.currentDetail}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script src="./index.js"></script>

<style scoped lang="scss">
    .content-container {
        min-height: 878px;
        background: #272953;
    }
    .page-wrapper {
        font-family: HarmoniaSansProCyr-Regular, Harmonia-sans;
        position: relative;
        min-height: calc(100vh - 78px);
        color: white;
        text-align: center;
    }
    .block-container {
        background: #272953;
        flex-wrap: wrap;
        margin: 0;
    }
    .header-title {
        font-weight: bold;
        font-size: 20px;
        text-align: center;
    }
    .approve-list {

    }
    .approve-list:hover {
        background: #2E50E9;
        margin-left: 2px;
    }
    .selected-company {
        background: #2E50E9;
    }
    .right-arrow {
        background: url(/img/visualcenter3/right-arrow.png) no-repeat;
    }
    .change-list {
        text-align: left;
    }
    .column-title {
        font-size: 17px;
        font-weight: bold;
    }
    .column-parameter {
        font-size: 15px;
        font-weight: 100;
    }
    .table-header {
        border-bottom: 2px solid #808080;
    }
    .menu-block {
        min-height: 820px;
        border-right: 2px solid #808080;
    }
    .details-block {
        min-height: 820px;
    }
    .table_body {
        text-align: center;
        font-size: 15px;
        font-weight: 100;
    }
    .table_header {
        font-size: 17px;
        font-weight: bold;
        text-align: center;
        background: #333975;
    }
    .difference-list {
        color: black;
        &:nth-child(even) {
            background: #e6e6e6;
        }
        &:nth-child(odd){
            background: white;
        }
    }
    .child-actual {
        margin-left: -25px;
    }
    .child-current {
        margin-left: 15px;
    }
    .menu__button {
        font-weight: 500;
        cursor: pointer;
        border-radius: 8px;
        text-align: center;
        font-size: 15px;
    }
    .button_approve {
        background: #00b353;
    }
    .button_decline {
        background: #E31E24;
    }
    .processed-company {
        background: #00b353;
    }
    .button_disabled {
        pointer-events: none;
        visibility: hidden;
    }
    .button_approved {
        pointer-events: none;
        opacity: 0.4;
    }
</style>
