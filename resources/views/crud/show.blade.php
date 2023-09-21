<x-layouts-auth>
    <x-slot name="content">
        <table>
            <thead>
                <th>
                    <tr>
                        @foreach (Ladmin::currentQuery()->getColumnNames() as $columnName)
                            <td>
                                {{ __($columnName) }}
                            </td>
                        @endforeach
                        @if (Ladmin::hasDetail())
                            <td></td>
                        @endif
                    </tr>
                </th>
            </thead>
            <tbody>
                @foreach (Ladmin::currentQuery()->paginate(24) as $item)
                    <tr>
                        @foreach ($fields as $field)
                            {{ $field->render($item) }}
                        @endforeach
                        @if (Ladmin::hasDetail())
                            <td><a
                                    href="{{ route(Ladmin::getDetailRouteName(), [
                                        'primaryKey' => Ladmin::itemPrimaryKey($item),
                                    ]) }}">{{ __('Detail') }}</a>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </x-slot>
</x-layouts-auth>
