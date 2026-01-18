@extends('layouts.app')

@section('content')

    <!-- ROW 1: CARDS SUMMARY (LIVEWIRE) -->
    <livewire:dashboard-stats />

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- LEFT: CHART & LIST -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- CHART (LIVEWIRE) -->
            <livewire:dashboard-chart />
            
            <!-- LIST (LIVEWIRE) -->
            <livewire:transaction-list />
        </div>

        <!-- RIGHT: FORM (LIVEWIRE) -->
        <div class="lg:col-span-1">
            <div class="sticky top-24">
                <livewire:transaction-form />
            </div>
        </div>
    </div>

@endsection