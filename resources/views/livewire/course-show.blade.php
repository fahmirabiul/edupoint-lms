<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <!-- Success Message -->
                @if (session()->has('message'))
                    <div class="mb-4 p-4 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-200 rounded-md">
                        {{ session('message') }}
                    </div>
                @endif

                <!-- Error Message -->
                @if (session()->has('error'))
                    <div class="mb-4 p-4 bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-200 rounded-md">
                        {{ session('error') }}
                    </div>
                @endif

                <h1 class="text-3xl font-bold mb-4">{{ $course->title }}</h1>

                <div class="mb-6">
                    <span class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">
                        @if ($course->price > 0)
                            Rp {{ number_format($course->price, 0, ',', '.') }}
                        @else
                            <span class="text-green-600 dark:text-green-400">Free</span>
                        @endif
                    </span>
                </div>

                <div class="prose dark:prose-invert max-w-none">
                    <p>{{ $course->description }}</p>
                </div>

                <div class="mt-8">
                    @if ($isEnrolled)
                        <button disabled
                            class="bg-gray-400 cursor-not-allowed text-white px-6 py-3 rounded-md font-medium">
                            Already Enrolled
                        </button>
                    @else
                        <div class="mb-4 max-w-xs">
                            <label for="payment_method"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Select Payment Method
                            </label>
                            <select wire:model="paymentMethod" id="payment_method"
                                class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2.5">
                                <option value="manual">Manual Transfer</option>
                                <option value="midtrans">Midtrans Payment</option>
                            </select>
                        </div>

                        <button wire:click="enroll" wire:loading.attr="disabled"
                            class="bg-indigo-600 hover:bg-indigo-700 disabled:bg-gray-400 text-white px-6 py-3 rounded-md font-medium transition-colors duration-200">
                            <span wire:loading.remove>Enroll Now</span>
                            <span wire:loading>Processing Payment...</span>
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
