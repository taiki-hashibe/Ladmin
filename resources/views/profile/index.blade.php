<x-layouts-auth>

    <x-slot name="content">
        <form method="post" action="{{ Ladmin::route()->profile()->update()->url }}" class="mt-6 space-y-6">
            @csrf

            @include('ladmin::fields.edit.default', [
                'label' => 'username',
                'name' => 'name',
                'value' => auth()->user()->name,
            ])

            @include('ladmin::fields.edit.default', [
                'label' => 'email',
                'name' => 'email',
                'value' => auth()->user()->email,
            ])

            <button>{{ __('Save') }}</button>
        </form>
        <hr>
        <form method="post" action="{{ Ladmin::route()->profile()->passwordChange()->url }}">
            @csrf
            @include('ladmin::fields.edit.default', [
                'label' => 'current password',
                'name' => 'current_password',
            ])
            @include('ladmin::fields.edit.default', [
                'label' => 'new password',
                'name' => 'password',
            ])
            @include('ladmin::fields.edit.default', [
                'label' => 'new password confirmation',
                'name' => 'password_confirmation',
            ])
            <div class="flex items-center gap-4">
                <button>{{ __('Save') }}</button>

                @if (session('status') === 'password-updated')
                    <p>{{ __('Saved.') }}</p>
                @endif
            </div>
        </form>
        <hr>
        <form method="post" action="{{ Ladmin::route()->profile()->destroy()->url }}">
            @csrf
            <button>{{ __('Delete Account') }}</button>
            </div>
        </form>
    </x-slot>
</x-layouts-auth>
