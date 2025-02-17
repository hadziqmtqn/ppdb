@extends('layouts.master')
@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light"><a href="{{ route('dashboard') }}">Dashboard</a> /</span>
        <span class="text-muted fw-light"><a href="{{ route('conversation.index') }}">Kirim Pesan</a> /</span>
        Detail {{ $title }}
    </h4>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4 overflow-hidden" style="max-height: 800px">
                <div class="card-header">
                    <h5 class="card-title m-0">{{ $conversation->subject }}</h5>
                </div>
                <div class="card-body" style="padding-left: 2.5rem" id="vertical-scroll">
                    <ul class="timeline mb-0" id="replyMessages" data-conversation="{{ $conversation->slug }}"></ul>
                    <ul class="timeline mb-0">
                        <li class="timeline-item ps-4 border-transparent">
                            <div class="timeline-indicator-advanced border-0 shadow-none avatar">
                                <img src="{{ url('https://ui-avatars.com/api/?name='. (ucwords(strtolower(optional($conversation->admin)->name ?? optional($conversation->user)->name))) .'&color=7F9CF5&background=EBF4FF') }}" alt="Avatar" class="rounded-circle">
                            </div>
                            <div class="timeline-event ps-1 pt-0">
                                <div class="card shadow-none bg-transparent border border-opacity-25 mb-3">
                                    <div class="card-header border-bottom pt-3 pb-3 d-flex justify-content-between">
                                        <div>
                                            <h6 class="fw-bold mb-0"><span class="{{ (auth()->user()->id == $conversation->user_id) || (auth()->user()->id == $conversation->admin_id) ? 'text-primary' : '' }}">{{ ucwords(strtolower(optional($conversation->admin)->name ?? optional($conversation->user)->name)) }}</span> <span class="text-muted fw-normal">on {{ \Carbon\Carbon::parse($conversation->created_at)->isoFormat('DD MMM Y HH:mm') }}</span></h6>
                                        </div>
                                        @if($conversation->messages->isEmpty())
                                            <div id="newConversation">
                                                <span class="spinner-grow text-primary spinner-grow-sm me-1" role="status" aria-hidden="true"></span>Terbaru
                                            </div>
                                        @endif
                                    </div>
                                    <div class="card-body pb-2 messages">
                                        {!! $conversation->message !!}
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card- mb-4">
                <div class="card-header">
                    <h5 class="card-title m-0">Balas Pesan</h5>
                </div>
                <form onsubmit="return false" id="replyMessageForm" data-conversation="{{ $conversation->slug }}">
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
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('materialize/js/quill-message-editor.js') }}"></script>
    <script src="{{ asset('js/message/message/reply-message.js') }}"></script>
    <script src="{{ asset('js/message/message/messages.js') }}"></script>
    <script src="{{ asset('js/message/message/message-module.js') }}" type="module"></script>
@endsection