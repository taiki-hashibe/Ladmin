<x-layouts-auth>
    <x-slot name="content">
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
</x-layouts-auth>
