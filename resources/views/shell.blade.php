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
                    <?php App\Services\ShellService::setConnection($_REQUEST['connect'] ?? ''); ?>
                </div>

                <div class="card-body no-margin">
                    @if(App\Services\ShellService::connectionExists())
                        <livewire:shell/>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
