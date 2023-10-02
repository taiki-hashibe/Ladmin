<div>
    <label for="{{ $name }}">{{ $label }}</label>
    <input type="datetime-local" name="{{ $name }}"
        value="{{ old($name, isset($value) ? $value : '') }}">
    @error($name)
        <span style="color:red">{{ $message }}</span>
    @enderror
</div>
