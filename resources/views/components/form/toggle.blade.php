<div class="{{ $formGroupClass ?? 'mb-3' }}">
    <div class="form-label">{{ isset($label) ? $label : '' }}</div>

    <label class="form-check form-switch {{ isset($label) ? 'mt-3' : '' }} pb-2">
        <input class="form-check-input @error($name) is-invalid @enderror" id="{{ $name }}"
            name="{{ $name }}" type="checkbox" {{ $attributes }}>

        <span class="form-check-label">
            {{ isset($description) ? $description : '' }}
        </span>

        @error($name)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </label>
</div>
