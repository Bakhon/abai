<table>
    <thead>
    <tr>
        <th></th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach($mmop as $item)
        <tr>
            <td>{{ $item }}</td>
            <td>{{ $item }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
