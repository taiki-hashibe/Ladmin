<x-ladmin-layouts-auth>
    <x-slot name="content">
        <h2>{{ __(Ladmin::currentRoute()->getTableName()) }}</h2>
        <form
            action="{{ route(Ladmin::getUpdateRouteName(), [
                'primaryKey' => Ladmin::currentItemPrimaryKey(),
            ]) }}"
            method="POST">
            @csrf
            @foreach ($fields as $field)
                {{ $field->render(Ladmin::currentItem()) }}
            @endforeach
            <button>{{ __('Submit') }}</button>
        </form>
        @if (Ladmin::hasDestroy())
            <form
                action="{{ route(Ladmin::getDestroyRouteName(), [
                    'primaryKey' => Ladmin::currentItemPrimaryKey(),
                ]) }}"
                method="POST">
                @csrf
                <button>{{ __('Delete') }}</button>
            </form>
        @endif
    </x-slot>
</x-ladmin-layouts-auth>
