<label class="form-check @isset($inline) form-check-inline @endisset">
    <input class="form-check-input @error($name) is-invalid @enderror" id="{{ $name }}" name="{{ $name }}"
        {{ $attributes }}>

    <span class="form-check-label">{{ $description }}</span>

    @error($name)
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</label>
