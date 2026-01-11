<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        <livewire:layout.navigation />

        @if (isset($header))
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <main>
            {{ $slot }}
        </main>
    </div>

    <!-- Toast Notification - WORKING VERSION -->
    <template x-teleport="body">
        <div x-data="{
            show: false,
            title: '',
            message: '',
            init() {
                console.log('Toast Alpine component initialized');
        
                window.addEventListener('show-toast', (event) => {
                    console.log('Toast received event:', event.detail);
                    this.show = true;
                    this.title = event.detail.title || 'Notification';
                    this.message = event.detail.message || '';
        
                    // Dispatch Livewire event to update badge
                    Livewire.dispatch('notification-received');
        
                    setTimeout(() => {
                        this.show = false;
                    }, 5000);
                });
            }
        }" x-show="show" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-x-full"
            x-transition:enter-end="opacity-100 transform translate-x-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform translate-x-0"
            x-transition:leave-end="opacity-0 transform translate-x-full"
            class="fixed bottom-5 right-5 z-[9999] bg-white border-l-4 border-green-500 shadow-2xl p-4 rounded-lg w-80 max-w-sm"
            style="display: none;">

            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-3 flex-1">
                    <p class="text-sm font-bold text-gray-900" x-text="title"></p>
                    <p class="text-xs text-gray-600 mt-1" x-text="message"></p>
                </div>
                <button @click="show = false" class="ml-auto flex-shrink-0 text-gray-400 hover:text-gray-600">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </template>

    <script>
        document.addEventListener('livewire:init', () => {
            console.log('✅ Livewire initialized');

            Livewire.on('show-toast', (data) => {
                console.log('✅ Livewire caught show-toast:', data);
            });
        });

        window.addEventListener('show-toast', (e) => {
            console.log('✅ Window caught show-toast:', e.detail);
        });

        window.testToast = function() {
            console.log('🧪 Testing toast...');
            window.dispatchEvent(new CustomEvent('show-toast', {
                detail: {
                    title: 'Manual Test',
                    message: 'This is a test notification from console'
                }
            }));
        };

        console.log('💡 Run testToast() in console to test');
    </script>
</body>

</html>
