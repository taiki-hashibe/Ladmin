<div>
    <label for="{{ $name }}">{{ $label }}</label>
    <textarea name="{{ $name }}" value="{{ old($name, isset($value) ? $value : '') }}"></textarea>
    @error($name)
        <span style="color:red">{{ $message }}</span>
    @enderror
</div>
