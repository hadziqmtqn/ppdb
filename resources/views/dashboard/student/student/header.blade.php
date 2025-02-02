<div class="d-flex flex-column flex-sm-row align-items-center justify-content-sm-between mb-4 text-center text-sm-start gap-2">
    <div class="mb-2 mb-sm-0">
        <h4 class="mb-1">No. Registrasi: {{ optional($user->student)->registration_number }}</h4>
        <p class="mb-0">Tgl. Registrasi: {{ Carbon\Carbon::parse(optional($user->student)->created_at)->isoFormat('DD MMM Y') }}</p>
    </div>
    <a href="{{ route('student-registration.index', $user->username) }}" class="btn btn-outline-warning delete-customer waves-effect">Edit</a>
</div>