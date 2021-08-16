@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <a href="{{ route('eco_refs_list') }}"
               class="btn btn-info">
                {{ __('economic_reference.return_menu') }}
            </a>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header ecorefs-header">
                        <a class="btn btn-success" href="{{ route('ecorefsbranchid.create') }}">+</a>
                        <div class="ecorefs-title">{{__('economic_reference.branch')}}</div>
                    </div>
                    <div class="card-body">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <p>{{ $message }}</p>
                            </div>
                        @endif
                        <table class="table table-bordered">
                            <tr>
                                <th>#</th>
                                <th>Филиал:</th>
                                <th width="220px">{{__('app.action')}}</th>
                            </tr>
                            @foreach ($ecorefsbranchid as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        <form action="{{ route('ecorefsbranchid.destroy',$item->id) }}" method="POST">
                                            <a class="btn btn-primary" href="{{ route('ecorefsbranchid.edit',$item->id) }}">{{__('app.edit')}}</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger mt-2">{{__('app.delete')}}</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        {!! $ecorefsbranchid->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    @import "../../css/ecorefs.css";
</style>