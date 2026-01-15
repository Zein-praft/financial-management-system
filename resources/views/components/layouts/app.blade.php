@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <header class="mb-8">
        <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
            Dashboard Keuangan
        </h2>
    </header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Kolom Kiri: Form Input -->
        <div class="lg:col-span-1">
            <livewire:transaction-form />
        </div>

        <!-- Kolom Kanan: Dashboard Stats & List -->
        <div class="lg:col-span-2 space-y-8">
            <livewire:dashboard />
            <livewire:transaction-list />
        </div>
    </div>
</div>
@endsection