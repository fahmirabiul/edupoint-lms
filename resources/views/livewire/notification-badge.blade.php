<div wire:poll.5s="updateCount">
    @if ($unreadCount > 0)
        <span
            class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-500 rounded-full">
            {{ $unreadCount }}
        </span>
    @endif
</div>
