<template>
  <div class="row">
    <div class="col-md-6 bg-dark">
        <div class="row">
            <div class="col">
            <select class ="transparent-select" id="">
                <option>Дело скважины</option>
                <option>Option 2</option>
            </select>
            </div>
        </div>
            <div class="row">
            <div class="col">
            <select id ="" class="form-control small-select">
                <option>Фонд</option>
                <option>Option 2</option>
            </select >
            <select id ="" class="form-control small-select">
                <option>График замеров</option>
                <option>Option 2</option>
            </select>
            <select id ="" class="form-control small-select">
                <option>Эксплуатационные показатели</option>
                <option>Option 2</option>
            </select>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="bg-dark">
         <h1>О, получилось!</h1>
        </div>
    </div>
        <div class="col-md-4">
        <div class="bg-dark">
         <h1>О, получилось!</h1>
        </div>
    </div>
  </div>
</template>
<style>
    .small-select{
        width:30%;
        margin: 10px;
        padding: 10px;
    }
    .transparent-select{
        color: white;
        background: none;

    }
</style>