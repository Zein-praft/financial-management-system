<!-- Kartu Stats (Income, Expense, Balance) -->
<livewire:dashboard-stats />

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Kiri: Chart & List -->
    <div class="lg:col-span-2 space-y-8">
        <!-- CHART -->
        <livewire:dashboard-chart />
        
        <!-- LIST -->
        <livewire:transaction-list />
    </div>

    <!-- Kanan: Form -->
    <div class="lg:col-span-1">
        <div class="sticky top-24">
            <livewire:transaction-form />
        </div>
    </div>
</div>