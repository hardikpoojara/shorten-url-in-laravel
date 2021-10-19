@extends('_master.master')
@section('title','List Links')
@section('content')
    <div class="card">
        <div class="card-header">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{route('store-link')}}">
                @csrf
                <div class="input-group mb-3">
                    <input type="text" name="link" class="form-control" placeholder="Enter URL" value="{{old('link')}}" autofocus>
                    <div class="input-group-append">
                        <button class="btn btn-success" type="submit">Generate Shorten Link</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body">

            @if (Session::has('success'))
                <div class="alert alert-success">
                    <p>{{ Session::get('success') }}</p>
                </div>
            @endif

            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Short Link</th>
                    <th>Link</th>
                    <th>Hits</th>
                </tr>
                </thead>
                <tbody>
                @foreach($links as $row)
                    <tr>
                        <td>{{ $row->id }}</td>
                        <td><a href="{{ route('go-to-page', $row->code) }}" target="_blank">{{ route('go-to-page', $row->code) }}</a></td>
                        <td>{{ $row->link }}</td>
                        <td>{{$row->history_count}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
                <div class="d-flex justify-content-center">
                    {!! $links->links() !!}
                </div>
        </div>
    </div>
@endsection
