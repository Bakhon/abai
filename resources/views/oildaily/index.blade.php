@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>
                    <div class="card-body">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <p>{{ $message }}</p>
                            </div>
                        @endif
                        <table class="table table-bordered">
                            <tr>
                                <th>No</th>
                                <th>Date</th>
                                <th>Liquid</th>
                                <th width="280px">Action</th>
                            </tr>
                            @foreach ($oildaily as $item)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $item->date }}</td>
                                    <td>{{ $item->liquid }}</td>
                                    <td>
                                        <form action="{{ route('oildaily.destroy',$item->id) }}" method="POST">
                                            <a class="btn btn-info" href="{{ route('oildaily.show',$item->id) }}">Show</a>
                                            <a class="btn btn-primary" href="{{ route('oildaily.edit',$item->id) }}">Edit</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        {!! $oildaily->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
