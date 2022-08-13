<button class="jsButtonConfirmation {{ $button->btnClass }} {{ $button->btnIcon }}" type="button" data-type="{{ $button->btnStyle }}"
    data-message="{{ $button->btnMessage }}" data-action="{{ $button->btnAction }}">
    <span class="{{ $button->btnIcon && $button->btnText ? 'ml-2' : null }}">
        {{ $button->btnText }}
    </span>
</button>
