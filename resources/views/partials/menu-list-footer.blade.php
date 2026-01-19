<ul class="flex flex-col gap-3 font-bold">
    @foreach ($menuItems as $menuItem)
        <li><a href="{{ $menuItem->link }}" target="{{ $menuItem->target }}"
                class="inline-block transition hover:scale-110 hover:text-secondary">{{ $menuItem->name }}</a></li>
    @endforeach
</ul>
