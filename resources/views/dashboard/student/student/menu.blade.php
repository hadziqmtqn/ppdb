<ul class="nav nav-pills flex-column flex-md-row mb-3">
    <li class="nav-item">
        <a class="nav-link {{ url()->current() == route('student.show', $user->username) ? 'active' : '' }} waves-effect waves-light" href="{{ route('student.show', $user->username) }}"><i class="mdi mdi-account-outline mdi-20px me-1"></i>Overview</a>
    </li>
    <li class="nav-item">
        <a class="nav-link waves-effect {{ url()->current() == route('student-security.index', $user->username) ? 'active' : '' }} waves-light" href="{{ route('student-security.index', $user->username) }}"><i class="mdi mdi-lock-open-outline mdi-20px me-1"></i>Keamanan</a>
    </li>
</ul>