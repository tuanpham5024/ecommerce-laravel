@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li style="margin-left: -30px;text-align: start">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(Session::has('error'))

@endif

@if(Session::has('success'))
    <div class="alert alert-success">
        {{ Session::get('success') }}
    </div>
@endif
