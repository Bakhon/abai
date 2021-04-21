<table style="width: 100%;">
    <thead>
    <tr>
        @foreach(\App\Exports\EconomicDataExport::COLUMNS as $column)
            <th style="border: 1px solid black; height: 20px">
                {{$column}}
            </th>
        @endforeach
    </tr>
    </thead>

    <tbody>
    @foreach($data as $item)
        <tr>
            @foreach(\App\Exports\EconomicDataExport::COLUMNS as $column)
                <th style="border: 1px solid black; height: 20px">
                    {{$item[$column] ?? null}}
                </th>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>
