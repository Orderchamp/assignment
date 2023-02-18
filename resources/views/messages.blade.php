@if(session()->has('success'))
    <div class="container">
        <div class="alert alert-success">
            <strong>Success!</strong> {{ session('success') }}
        </div>
    </div>
@endif
