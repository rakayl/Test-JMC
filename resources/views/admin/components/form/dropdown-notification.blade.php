@if (isset($label))
    <label for="{{ $name ?? '' }}">{!! __($label) !!}</label>
@endif

<select name="{{ $name ?? '' }}" id="{{ $id ?? '' }}" class="form--control {{ $class ?? '' }}" {{ $attribute ?? '' }}>
    @foreach($options ?? [] as $key => $value)
        <option value="{{ $key }}" {{ isset($selected) && $selected == $key ? 'selected' : '' }}>
            {{ $value }}
        </option>
    @endforeach
</select>

@error($name ?? false)
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
@enderror
