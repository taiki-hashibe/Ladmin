<x-ladmin-layouts-auth>
    <x-slot name="content">
        <h2>{{ __(Ladmin::currentRoute()->getTableName()) }}</h2>
        <table>
            <thead>
                <th>
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                </th>
            </thead>
            <tbody>
                @foreach ($fields as $field)
                    {{ $field->render(Ladmin::currentItem()) }}
                @endforeach
            </tbody>
        </table>
        @if (Ladmin::hasEdit())
            <a
                href="{{ route(Ladmin::getEditRouteName(), [
                    'primaryKey' => Ladmin::currentItemPrimaryKey(),
                ]) }}">{{ __('Edit') }}</a>
        @endif
    </x-slot>
</x-ladmin-layouts-auth>
