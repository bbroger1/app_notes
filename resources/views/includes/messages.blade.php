@if (session('success'))
    <span class="row text-end">
        <span class="col-6 offset-6 col-md-3 offset-md-9">
            <span class="alert alert-success alert-dismissible fade show text-center" role="alert" id="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </span>
        </span>
    </span>
@endif

@if (session('error'))
    <span class="row text-end">
        <span class="col-6 offset-6 col-md-3 offset-md-9">
            <p class="alert alert-danger alert-dismissible fade show text-center" role="alert" id="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </p>
        </span>
    </span>
@endif


@if (session('warning'))
    <span class="row text-end">
        <span class="col-6 offset-6 col-md-3 offset-md-9">
            <p class="alert alert-warning alert-dismissible fade show text-center" role="alert" id="alert">
                {{ session('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </p>
        </span>
    </span>
@endif
