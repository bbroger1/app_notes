@if (session('success'))
    <div class="position-fixed top-0 end-0 p-3">
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif

@if (session('error'))
    <div class="position-fixed top-0 end-0 p-3">
        <div class="alert alert-error alert-dismissible fade show" role="alert" id="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif

@if (session('warning'))
    <div class="position-fixed top-0 end-0 p-3">
        <div class="alert alert-warning alert-dismissible fade show" role="alert" id="alert">
            {{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif
