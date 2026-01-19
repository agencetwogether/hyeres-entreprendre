@php
    $avatar = $id ? $record->getFilamentAvatarUrl() : getFallbackAvatar();
@endphp
<img src="{{ $avatar }}" class="inline-block w-6 h-6 mr-2 rounded-full" />
