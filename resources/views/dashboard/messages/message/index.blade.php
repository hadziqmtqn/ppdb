@extends('layouts.master')
@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light"><a href="{{ route('dashboard') }}">Dashboard</a> /</span>
        <span class="text-muted fw-light"><a href="{{ route('conversation.index') }}">Kirim Pesan</a> /</span>
        Detail {{ $subTitle }}
    </h4>

    <div class="d-flex flex-column flex-sm-row align-items-center justify-content-sm-between mb-4 text-center text-sm-start gap-2">
        <div class="mb-2 mb-sm-0">
            <h4 class="mb-1">{{ $conversation->subject }}</h4>
            <p class="mb-0">
                <i class="mdi mdi-account me-1"></i> <a href="{{ route('student.show', optional($conversation->user)->username) }}">{{ ucwords(strtolower(optional($conversation->user)->name)) }}</a>
                <i class="mdi mdi-calendar-month me-1"></i> {{ Carbon\Carbon::parse($conversation->created_at)->isoFormat('DD MMM Y HH:mm') }}
            </p>
        </div>
        <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modalReply">Balas Pesan <i class="mdi mdi-arrow-right ms-2"></i></button>
    </div>
    <div id="vertical-scroll" class="overflow-hidden" style="max-height: 500px">
        <div class="card shadow-none border-2 border-primary">
            <div class="card-body" style="padding-left: 2.5rem">
                <ul class="timeline mb-0" id="replyMessages" data-conversation="{{ $conversation->slug }}"></ul>
                <ul class="timeline mb-0">
                    <li class="timeline-item ps-4 border-transparent">
                        <div class="timeline-indicator-advanced border-0 shadow-none avatar">
                            <img src="{{ url('https://ui-avatars.com/api/?name='. (ucwords(strtolower(optional($conversation->admin)->name ?? optional($conversation->user)->name))) .'&color=7F9CF5&background=EBF4FF') }}" alt="Avatar" class="rounded-circle">
                        </div>
                        <div class="timeline-event ps-1 pt-0">
                            <div class="card shadow-none bg-transparent border border-opacity-25 mb-1">
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
                            <div class="d-flex justify-content-between mb-3">
                                <span class="badge bg-label-{{ $conversation->is_seen ? 'primary' : 'secondary' }}">{{ $conversation->is_seen ? 'Dibaca' : 'Belum Dibaca' }}</span>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    @include('dashboard.messages.message.modal-reply')
@endsection

@section('scripts')
    <script src="{{ url('https://hadziqmtqn.github.io/materialize/custom-scripts/js/quill-message-editor.js') }}"></script>
    <script src="{{ asset('js/message/message/reply-message.js') }}"></script>
    <script src="{{ asset('js/message/message/messages.js') }}"></script>
    <script src="{{ asset('js/message/message/message-module.js') }}" type="module"></script>
@endsection