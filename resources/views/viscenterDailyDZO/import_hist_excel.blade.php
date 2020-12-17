<!DOCTYPE html>
<html>
<head>
    <title>Import Excel File in Laravel</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<br />
    <div class="container">
    <h3 align="center">Импорт суточных данных из Excel в базу данных MySQL</h3>
<br />
    @if(count($errors) > 0)
    <div class="alert alert-danger">
        Upload Validation Error<br><br>
        <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
    @endif

    @if($message = Session::get('success'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
    @endif

    <!-- <form method="post" enctype="multipart/form-data" action="{{ url('/import_excel/import') }}"> -->
    <form method="post" enctype="multipart/form-data" action="{{ route('import_h') }}">
    {{ csrf_field() }}
    <div class="form-group">
        <table class="table">
            <tr>
            <td width="40%" align="right"><label>Выберите Excel файл</label></td>
            <td width="30">
            <input type="file" name="select_file" />
            </td>
            <td width="30%" align="left">
            <input type="submit" name="upload" class="btn btn-primary" value="Загрузить">
            </td>
            </tr>
            <tr>
            <td width="40%" align="right"></td>
            <td width="30"><span class="text-muted">.xls, .xslx</span></td>
            <td width="30%" align="left"></td>
            </tr>
        </table>
    </div>
    </form>

    <br />
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Оперативная информация по ДЗО для АО "НК  'КазМунайГаз'"</h3>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <tr>
                <th>Дата</th>
                <th>ДЗО</th>
                <th>1</th>
                <th>2</th>
                <th>3</th>
                <th>4</th>
                <th>5</th>
                <th>6</th>
                <th>7</th>
                <th>8</th>
                <th>9</th>
                <th>10</th>
                <th>11</th>
                <th>12</th>
                <th>13</th>
                <th>14</th>
                <th>15</th>
                <th>16</th>
                </tr>
                @foreach($data as $row)
                    <tr>
                    <td>{{ $row->date }}</td>
                    <td>{{ $row->dzo }}</td>
                    <td>{{ $row->oil_plan }}</td>
                    <td>{{ $row->oil_fact }}</td>
                    <td>{{ $row->oil_dlv_plan }}</td>
                    <td>{{ $row->oil_dlv_fact }}</td>
                    <td>{{ $row->gas_plan }}</td>
                    <td>{{ $row->gas_fact }}</td>
                    <td>{{ $row->liq_plan }}</td>
                    <td>{{ $row->liq_fact }}</td>
                    <td>{{ $row->prod_wells_work }}</td>
                    <td>{{ $row->prod_wells_idle }}</td>
                    <td>{{ $row->inj_wells_work }}</td>
                    <td>{{ $row->inj_wells_idle }}</td>
                    <td>{{ $row->gk_plan }}</td>
                    <td>{{ $row->gk_fact }}</td>
                    <td>{{ $row->otm_burenie_prohodka_plan }}</td>
                    <td>{{ $row->otm_burenie_prohodka_fact }}</td>
                    </tr>
                @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>