@extends('layouts.app')

@section('content')

    <!-- Kartu Summary (Income, Expense, Balance) -->
    <livewire:dashboard />

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-8">
        
        <!-- Kolom Kiri (Chart & List) -->
        <div class="lg:col-span-2 space-y-8">
            <livewire:report />
            <livewire:transaction-list />
        </div>

        <!-- Kolom Kanan (Form Input) -->
        <div class="lg:col-span-1">
            <div class="sticky top-24">
                <livewire:transaction-form />
            </div>
        </div>
    </div>

@endsection