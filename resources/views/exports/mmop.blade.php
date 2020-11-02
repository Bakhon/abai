<table>
    <thead>
    <tr>
        <th>gdis_pbuf</th>
        <th>drill_year</th>
        <th>repairs_text</th>
        <th>block2</th>
        <th>prs_count</th>
        <th>perf_intr</th>
        <th>gu</th>
        <th>tap</th>
        <th>zu</th>
        <th>liquid_val</th>
        <th>work_day</th>
        <th>liq_cumm</th>
        <th>bsw_cumm_avg</th>
        <th>tm_liquid</th>
        <th>field</th>
        <th>gdis_pzatr</th>
        <th>bsw_avg</th>
        <th>liq_avg</th>
        <th>gdis_pzab</th>
        <th>gdis_date</th>
        <th>uwi</th>
        <th>oil_cumm_avg</th>
        <th>gdis_conclusion</th>
        <th>grzs</th>
        <th>liq_cumm_avg</th>
        <th>tm_oil</th>
        <th>gdis_hdyn</th>
        <th>gdis_pmaxload</th>
        <th>bsws</th>
        <th>oil_cumm</th>
        <th>tm_bsw</th>
        <th>cndg</th>
        <th>oil_avg</th>
        <th>ngdu</th>
        <th>oil</th>
        <th>work_day_cumm</th>
    </tr>
    </thead>
    <tbody>
    @foreach($mmop as $item)
        <tr>
            <td>{{ $item['gdis_pbuf'] }}</td>
            <td>{{ $item['drill_year'] }}</td>
            <td>{{ $item['repairs_text'] }}</td>
            <td>{{ $item['block2'] }}</td>
            <td>{{ $item['prs_count'] }}</td>
            <td>{{ $item['perf_intr'] }}</td>
            <td>{{ $item['gu'] }}</td>
            <td>{{ $item['tap'] }}</td>
            <td>{{ $item['zu'] }}</td>
            <td>{{ $item['liquid_val'] }}</td>
            <td>{{ $item['work_day'] }}</td>
            <td>{{ $item['liq_cumm'] }}</td>
            <td>{{ $item['bsw_cumm_avg'] }}</td>
            <td>{{ $item['tm_liquid'] }}</td>
            <td>{{ $item['field'] }}</td>
            <td>{{ $item['gdis_pzatr'] }}</td>
            <td>{{ $item['bsw_avg'] }}</td>
            <td>{{ $item['liq_avg'] }}</td>
            <td>{{ $item['gdis_pzab'] }}</td>
            <td>{{ $item['gdis_date'] }}</td>
            <td>{{ $item['uwi'] }}</td>
            <td>{{ $item['oil_cumm_avg'] }}</td>
            <td>{{ $item['gdis_conclusion'] }}</td>
            <td>{{ $item['grzs'] }}</td>
            <td>{{ $item['liq_cumm_avg'] }}</td>
            <td>{{ $item['tm_oil'] }}</td>
            <td>{{ $item['gdis_hdyn'] }}</td>
            <td>{{ $item['gdis_pmaxload'] }}</td>
            <td>{{ $item['bsws'] }}</td>
            <td>{{ $item['oil_cumm'] }}</td>
            <td>{{ $item['tm_bsw'] }}</td>
            <td>{{ $item['cndg'] }}</td>
            <td>{{ $item['oil_avg'] }}</td>
            <td>{{ $item['ngdu'] }}</td>
            <td>{{ $item['oil'] }}</td>
            <td>{{ $item['work_day_cumm'] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
