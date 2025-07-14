@if (isset($label))
    @php
        $for_id = preg_replace('/[^A-Za-z0-9\-]/', '', strip_tags(Str::lower($label)));
    @endphp
    <label for="{{ $for_id ?? "" }}">{!! __($label) !!}</label>
@endif

@if(isset($type) && $type === "textarea")
    <textarea placeholder="{{ $placeholder ?? __('Type Here')."..." }}" name="{{ $name ?? "" }}"
        class="form--control {{ $class ?? "" }} @error($name ?? false) is-invalid @enderror"
        rows="3" {{-- Ini otomatis jadi sekitar 60-72px --}}
        {{ $attribute ?? "" }}
        @isset($required) required @endisset
        @isset($id) id="{{ $id }}" @endisset
        @isset($data_limit) data-limit="{{ $data_limit }}" @endisset>{{ $value ?? "" }}</textarea>
@else
    <input type="{{ $type ?? "text" }}" placeholder="{{ $placeholder ?? __('Type Here')."..." }}"
        name="{{ $name ?? "" }}" class="form--control {{ $class ?? "" }} @error($name ?? false) is-invalid @enderror"
        {{ $attribute ?? "" }} value="{{ $value ?? "" }}"
        @isset($required) required @endisset
        @isset($id) id="{{ $id }}" @endisset
        @isset($data_limit) data-limit="{{ $data_limit }}" @endisset>
@endif

@isset($eye_button)
    {!! $eye_button !!}
@endisset

@isset($errorMessage)
@else
    @error($name ?? false)
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
@endisset



{{-- BACKUP CODE --}}
{{-- @if (isset($label))
    @php
        $for_id = preg_replace('/[^A-Za-z0-9\-]/', '', strip_tags(Str::lower($label)));
    @endphp
    <label for="{{ $for_id ?? "" }}">{!! __($label) !!}</label>
@endif

<input type="{{ $type ?? "text" }}" placeholder="{{ $placeholder ?? __('Type Here')."..." }}" name="{{ $name ?? "" }}" class="form--control {{ $class ?? "" }} @error($name ?? false) is-invalid @enderror" {{ $attribute ?? "" }} value="{{ $value ?? "" }}" @isset($data_limit)
    data-limit = {{ $data_limit }}
@endisset @isset($required)
    required
@endisset @isset($id)
    id = {{ $id }}
@endisset>
@isset($eye_button)
    {!! $eye_button !!}
@endisset
@isset($errorMessage)

@else
    @error($name ?? false)
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
@endisset --}}
