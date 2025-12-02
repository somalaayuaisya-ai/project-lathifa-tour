@props(['user'])

<div class="flex items-center gap-3">
    <img src="{{ $user->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&color=7F9CF5&background=EBF4FF' }}" alt="{{ $user->name }}" class="w-10 h-10 rounded-full object-cover">
    <div class="flex-1">
        <div class="font-bold text-gray-900">{{ $user->name }}</div>
        <div class="text-xs text-gray-500">{{ $user->email }}</div>
    </div>
</div>
