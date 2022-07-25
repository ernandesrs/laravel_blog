<div class="message-area">
    @php
        $flash = (new \App\Helpers\Message\Message())->flash();
    @endphp
    @if ($flash)
        {!! $flash->render() !!}
    @endauth
</div>
