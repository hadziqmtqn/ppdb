@component('mail::message')
    {!! nl2br(e($data['message'])) !!}
@endcomponent