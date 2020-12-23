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
    <form method="post" enctype="multipart/form-data" action="{{ route('import_e') }}">
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
            <h3 class="panel-title">Экономика по ДЗО для АО "НК  'КазМунайГаз'"</h3>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <tr>
                <th>dzo</th>
                <th>date</th>
                <th>main_prc_val_plan</th>
                <th>spending_val_plan</th>
                <th>cost_val_plan</th>
                <th>rlz_spending_val_plan</th>
                <th>adm_spending_val_plan</th>
                <th>net_profit_val_plan</th>
                <th>editba_val_plan</th>
                <th>editba_margin_val_plan</th>
                <th>capital_inv_val_plan</th>
                <th>cash_flow_val_plan</th>
                <th>ud_income_val_plan</th>
                <th>ud_income_bbl_val_plan</th>
                <th>ud_spending_val_plan</th>
                <th>ud_spending_bbl_val_plan</th>
                <th>kvl_val_plan</th>
                <th>oil_val_plan</th>
                <th>main_prc_val_fact</th>
                <th>spending_val_fact</th>
                <th>cost_val_fact</th>
                <th>rlz_spending_val_fact</th>
                <th>adm_spending_val_fact</th>
                <th>net_profit_val_fact</th>
                <th>editba_val_fact</th>
                <th>editba_margin_val_fact</th>
                <th>capital_inv_val_fact</th>
                <th>cash_flow_val_fact</th>
                <th>ud_income_val_fact</th>
                <th>ud_income_bbl_val_fact</th>
                <th>ud_spending_val_fact</th>
                <th>ud_spending_bbl_val_fact</th>
                <th>kvl_val_fact</th>
                <th>oil_val_fact</th>
                <th>main_prc_plan_2020</th>
                <th>spending_plan_2020</th>
                <th>cost_plan_2020</th>
                <th>rlz_spending_plan_2020</th>
                <th>adm_spending_plan_2020</th>
                <th>net_profit_plan_2020</th>
                <th>editba_plan_2020</th>
                <th>editba_margin_plan_2020</th>
                <th>capital_inv_plan_2020</th>
                <th>cash_flow_plan_2020</th>
                <th>ud_income_plan_2020</th>
                <th>ud_income_bbl_plan_2020</th>
                <th>ud_spending_plan_2020</th>
                <th>ud_spending_bbl_plan_2020</th>
                <th>kvl_plan_2020</th>
                <th>oil_plan_2020</th>
                <th>oil_price_plan_2020</th>
                <th>kurs_plan_2020</th>
                <th>oil_price_plan</th>
                <th>oil_price_fact</th>
                <th>kurs_plan</th>
                <th>kurs_fact</th>
                <th>fine_2020</th>
                <th>rent_gtm_fact_2020</th>
                <th>ne_rent_gtm_fact_2020</th>
                <th>rent_burenie_fact_2020</th>
                <th>ne_rent_burenie_fact_2020</th>
                </tr>
                @foreach($data as $row)
                    <tr>
                    <td>{{ $row->dzo }}</td>
                    <td>{{ $row->date }}</td>
                    <td>{{ $row->main_prc_val_plan }}</td>
                    <td>{{ $row->spending_val_plan }}</td>
                    <td>{{ $row->cost_val_plan }}</td>
                    <td>{{ $row->rlz_spending_val_plan }}</td>
                    <td>{{ $row->adm_spending_val_plan }}</td>
                    <td>{{ $row->net_profit_val_plan }}</td>
                    <td>{{ $row->editba_val_plan }}</td>
                    <td>{{ $row->editba_margin_val_plan }}</td>
                    <td>{{ $row->capital_inv_val_plan }}</td>
                    <td>{{ $row->cash_flow_val_plan }}</td>
                    <td>{{ $row->ud_income_val_plan }}</td>
                    <td>{{ $row->ud_income_bbl_val_plan }}</td>
                    <td>{{ $row->ud_spending_val_plan }}</td>
                    <td>{{ $row->ud_spending_bbl_val_plan }}</td>
                    <td>{{ $row->kvl_val_plan }}</td>
                    <td>{{ $row->oil_val_plan }}</td>
                    <td>{{ $row->main_prc_val_fact }}</td>
                    <td>{{ $row->spending_val_fact }}</td>
                    <td>{{ $row->cost_val_fact }}</td>
                    <td>{{ $row->rlz_spending_val_fact }}</td>
                    <td>{{ $row->adm_spending_val_fact }}</td>
                    <td>{{ $row->net_profit_val_fact }}</td>
                    <td>{{ $row->editba_val_fact }}</td>
                    <td>{{ $row->editba_margin_val_fact }}</td>
                    <td>{{ $row->capital_inv_val_fact }}</td>
                    <td>{{ $row->cash_flow_val_fact }}</td>
                    <td>{{ $row->ud_income_val_fact }}</td>
                    <td>{{ $row->ud_income_bbl_val_fact }}</td>
                    <td>{{ $row->ud_spending_val_fact }}</td>
                    <td>{{ $row->ud_spending_bbl_val_fact }}</td>
                    <td>{{ $row->kvl_val_fact }}</td>
                    <td>{{ $row->oil_val_fact }}</td>
                    <td>{{ $row->main_prc_plan_2020 }}</td>
                    <td>{{ $row->spending_plan_2020 }}</td>
                    <td>{{ $row->cost_plan_2020 }}</td>
                    <td>{{ $row->rlz_spending_plan_2020 }}</td>
                    <td>{{ $row->adm_spending_plan_2020 }}</td>
                    <td>{{ $row->net_profit_plan_2020 }}</td>
                    <td>{{ $row->editba_plan_2020 }}</td>
                    <td>{{ $row->editba_margin_plan_2020 }}</td>
                    <td>{{ $row->capital_inv_plan_2020 }}</td>
                    <td>{{ $row->cash_flow_plan_2020 }}</td>
                    <td>{{ $row->ud_income_plan_2020 }}</td>
                    <td>{{ $row->ud_income_bbl_plan_2020 }}</td>
                    <td>{{ $row->ud_spending_plan_2020 }}</td>
                    <td>{{ $row->ud_spending_bbl_plan_2020 }}</td>
                    <td>{{ $row->kvl_plan_2020 }}</td>
                    <td>{{ $row->oil_plan_2020 }}</td>
                    <td>{{ $row->oil_price_plan_2020 }}</td>
                    <td>{{ $row->kurs_plan_2020 }}</td>
                    <td>{{ $row->oil_price_plan }}</td>
                    <td>{{ $row->oil_price_fact }}</td>
                    <td>{{ $row->kurs_plan }}</td>
                    <td>{{ $row->kurs_fact }}</td>
                    <td>{{ $row->fine_2020 }}</td>
                    <td>{{ $row->rent_gtm_fact_2020 }}</td>
                    <td>{{ $row->ne_rent_gtm_fact_2020 }}</td>
                    <td>{{ $row->rent_burenie_fact_2020 }}</td>
                    <td>{{ $row->ne_rent_burenie_fact_2020 }}</td>
                    </tr>
                @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>