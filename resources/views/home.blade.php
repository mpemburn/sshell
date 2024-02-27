@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Connected to: ') }}{{ $connection }}</div>

                <div class="card-body no-margin">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <livewire:shell />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
