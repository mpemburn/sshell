@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Create or Edit Scripts') }} <br>Multiple commands must be separated with semicolons.</div>
                <div class="card-body no-margin">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <livewire:script-edit />
                </div>

            </div>
        </div>
    </div>
    </div>
@endsection
