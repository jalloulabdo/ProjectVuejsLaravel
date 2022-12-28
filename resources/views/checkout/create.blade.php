<x-app-layout>
    <x-slot name="header">
        Paiement
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Remove py-8 -->
            <div class="mx-auto container py-8">
                <stripe-checkout></stripe-checkout>
            </div>
        </div>
    </div>
</x-app-layout>