<ul>
    @foreach ($menuItems as $menuItem)
        <li class="group relative {{ $menuItem->wrapper_class }}">
            <a target="{{ $menuItem->target }}"
                class="{{ request()->url() == $menuItem->link ? 'active' : '' }} {{ $menuItem->link_class }}"
                href="{{ $menuItem->link }}">
                {{ $menuItem->name }}
                @if ($menuItem->children->isNotEmpty())
                    <div class="transition duration-500 group-hover:rotate-180 ml-2">
                        <x-icon class="h-6 w-6" name="phosphor-caret-down" />
                    </div>
                @endif
            </a>
            @if ($menuItem->children->isNotEmpty())
                <div class="submenu">
                    @foreach ($menuItem->children as $child)
                        <a target="{{ $child->target }}"
                            class="{{ request()->url() == $child->link ? 'active' : '' }} {{ $child->link_class }}"
                            href="{{ $child->link }}">
                            {{ $child->name }}
                        </a>
                    @endforeach
                </div>
            @endif
        </li>
    @endforeach
</ul>
