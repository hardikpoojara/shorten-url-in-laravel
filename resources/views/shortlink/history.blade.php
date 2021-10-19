@extends('_master.master')
@section('title','History for '.$code)
@section('content')
    <div class="card">
        {{--<div class="card-header">
            History for {{$code}}
        </div>--}}
        <div class="card-header container-fluid">
            <div class="row">
                <div class="col-md-10">
                    <h3 class="w-75 p-0">Code</h3>
                </div>
                <div class="col-md-2 float-right">
                    <a href="{{route('home')}}" class="btn btn-primary">Back to List</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>IP Address</th>
                    <th>Time</th>
                </tr>
                </thead>
                <tbody>
                @foreach($history as $row)
                    <tr>
                        <td>{{ $row->id }}</td>
                        <td>{{{$row->ip_address}}}</td>
                        <td>{{ $row->created_at }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {!! $history->links() !!}
            </div>
        </div>
    </div>
@endsection
