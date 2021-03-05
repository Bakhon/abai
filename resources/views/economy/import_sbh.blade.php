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
    <form method="post" enctype="multipart/form-data" action="{{ route('import_sbh') }}">
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
            <h3 class="panel-title">Все компании по субхолдингам</h3>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <tr>
                <th>№</th>
                <th>Наименование</th>
                </tr>
                @foreach($data as $row)
                    <tr>
                    <td>{{ $row->num }}</td>
                    <td>{{ $row->title }}</td>
                    </tr>
                @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>