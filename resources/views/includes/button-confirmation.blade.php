<button class="jsButtonConfirmation btn {{ $btnClass ?? null }} {{ $btnIcon ?? null }}" data-type="{{ $btnType ?? null }}"
    data-message="{{ $btnMessage ?? null }}" data-action="{{ $btnAction ?? null }}"><span
        class="{{ ($btnIcon ?? null) && ($btnText ?? null) ? 'ml-2' : null }}">{{ $btnText ?? null }}</span></button>
