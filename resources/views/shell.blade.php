@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span id="is_connected">Connected to: </span>
                    <select id="connections">
                        <option value="0">Select a Connection</option>
                        @foreach(App\Services\ShellService::getConnections() as $name => $id)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="card-body no-margin">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <livewire:shell  :connect="$connect"/>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
