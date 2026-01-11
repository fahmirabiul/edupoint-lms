<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">Inbox</h1>

        <div class="space-y-4">
            @forelse($messages as $message)
                <div wire:click="markAsRead('{{ $message->id }}')"
                    class="p-4 cursor-pointer transition border-l-4 {{ $message->read_at ? 'bg-white border-gray-200' : 'bg-blue-50 border-blue-500 shadow-sm' }}">
                    <div class="flex justify-between items-start">
                        <h4 class="font-bold {{ $message->read_at ? 'text-gray-700' : 'text-blue-900' }}">
                            {{ $message->data['title'] ?? 'No Title' }}
                        </h4>
                        @if (!$message->read_at)
                            <span class="bg-blue-600 w-2 h-2 rounded-full"></span>
                        @endif
                    </div>

                    <p class="text-xs text-gray-500 mt-1">
                        Course: {{ $message->data['course_name'] ?? 'N/A' }} | Method:
                        {{ $message->data['payment_method'] ?? 'N/A' }}
                    </p>

                    <p class="mt-2 text-sm {{ $message->read_at ? 'text-gray-600' : 'text-gray-800' }}">
                        {{ $message->data['message'] ?? 'No message' }}
                    </p>

                    <span class="text-[10px] text-gray-400 mt-2 block italic">
                        {{ $message->created_at->diffForHumans() }}
                    </span>
                </div>
            @empty
                <div class="p-8 text-center text-gray-500">
                    <p class="mt-2">No notifications</p>
                </div>
            @endforelse

            @if ($messages->hasPages())
                <div class="mt-6">
                    {{ $messages->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
