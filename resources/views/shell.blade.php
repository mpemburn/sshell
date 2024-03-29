@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div id="connections_area">
                            <select id="connections">
                                <option value="0">Select a Connection</option>
                                @foreach(App\Services\ShellService::getConnections() as $name => $id)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                            <span id="connection_loading">
                                <img id="loading"
                                     src="https://cdnjs.cloudflare.com/ajax/libs/galleriffic/2.0.1/css/loader.gif"
                                     alt="" width="24"
                                     height="24">
                            </span>
                            <?php App\Services\ShellService::setConnection($_REQUEST['connect'] ?? ''); ?>
                        </div>
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
