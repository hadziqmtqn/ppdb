@extends('layouts.master')
@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light"><a href="{{ route('dashboard') }}">Dashboard</a> /</span>
        <span class="text-muted fw-light"><a href="{{ route('conversation.index') }}">Kirim Pesan</a> /</span>
        Detail {{ $title }}
    </h4>

    <div class="card mb-4 overflow-hidden" style="max-height: 800px">
        <div class="card-header">
            <h5 class="card-title m-0">{{ $conversation->subject }}</h5>
        </div>
        <div class="card-body" style="padding-left: 2.5rem" id="vertical-scroll">
            <ul class="timeline mb-0">
                <li class="timeline-item ps-4 {{ $conversation->messages->isNotEmpty() ? 'border-left-dashed' : 'border-transparent' }}">
                    <div class="timeline-indicator-advanced border-0 shadow-none avatar">
                        <img src="{{ asset('materialize/assets/img/avatars/1.png') }}" alt="Avatar" class="rounded-circle">
                    </div>
                    <div class="timeline-event ps-1 pt-0">
                        <div class="card shadow-none bg-transparent border border-opacity-25 mb-3">
                            <h6 class="card-header fw-bold border-bottom pt-2 pb-2">
                                {{ ucwords(strtolower(optional($conversation->admin)->name)) ?? ucwords(strtolower(optional($conversation->user)->name)) }}
                                <span class="text-muted fw-normal">on {{ \Carbon\Carbon::parse($conversation->created_at)->isoFormat('DD MMM Y HH:mm') }}</span>
                            </h6>
                            <div class="card-body pb-2 messages">
                                {!! $conversation->message !!}
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
            <ul class="timeline mb-0" id="messages">
                {{--looping pesan--}}
                {{--<li class="timeline-item ps-4 border-transparent">
                    <div class="timeline-indicator-advanced border-0 shadow-none avatar">
                        <img src="{{ asset('materialize/assets/img/avatars/1.png') }}" alt="Avatar" class="rounded-circle">
                    </div>
                    <div class="timeline-event ps-1 pt-0">
                        <div class="card shadow-none bg-transparent border border-opacity-25 mb-3">
                            <h6 class="card-header fw-bold border-bottom pt-2 pb-2">
                                User test
                                <span class="text-muted fw-normal">on 2020</span>
                            </h6>
                            <div class="card-body">
                                <p class="card-text">Some quick example text to build on the card title and make up.</p>
                            </div>
                        </div>
                    </div>
                </li>--}}
            </ul>
        </div>
    </div>

    <div class="card card- mb-4">
        <div class="card-header">
            <h5 class="card-title m-0">Balas Pesan</h5>
        </div>
        <form onsubmit="return false" id="replyMessage" data-conversation="{{ $conversation->slug }}">
            <div class="card-body">
                <div>
                    <label for="description">Pesan</label>
                    <div class="quill-editor"></div>
                    <textarea name="message" id="description" class="d-none" placeholder="Pesan"></textarea>
                </div>
            </div>
            <div class="card-footer">
                <button type="button" class="btn btn-primary waves-effect waves-light" id="btnReplyMessage">Balas Pesan <i class="mdi mdi-send ms-2"></i></button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('materialize/js/quill-message-editor.js') }}"></script>
    <script src="{{ asset('js/message/message/reply-message.js') }}"></script>
@endsection