<x-layouts-ladmin>
    <x-slot name="header">
        {{ Ladmin::getNavigation('navigation')->render() }}
        <hr>
        <details>
            <summary>{{ __('user name') }}
            </summary>
            {{ Ladmin::getNavigation('dropdown')->render() }}
        </details>
        <hr>
    </x-slot>
    <x-slot name="content">
        @isset($content)
            {{ $content }}
        @endisset
    </x-slot>
    <x-slot name="footer">
    </x-slot>
</x-layouts-ladmin>
