@if ($errors->any())
    <div class="alert alert-danger alert-dismissible mb-3" role="alert">
        <ul style="padding-left: 20px; margin-bottom: 0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
