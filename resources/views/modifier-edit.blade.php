@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Create or Edit Modifiers') }}</div>
                <div class="card-body no-margin">
                    <livewire:modifier-edit />
                </div>
            </div>
        </div>
    </div>
@endsection
