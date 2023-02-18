@if(session()->has('success'))
    <div class="container">
        <div class="alert alert-success">
            <strong>Success!</strong> {{ session('success') }}
        </div>
    </div>
@endif

@if(session()->has('error'))
    <div class="container">
        <div class="alert alert-danger">
            <strong>Error!</strong> {{ session('error') }}
        </div>
    </div>
@endif
