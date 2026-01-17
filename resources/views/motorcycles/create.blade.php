@extends('layouts.admin')

@section('title', 'Add Motorcycle')
@section('page-title', 'New Motorcycle')

@section('content')

@if ($errors->any())
    <div class="alert alert-danger fade show" id="successAlert">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<form method="POST" action="{{ route('motorcycles.store') }}"  enctype="multipart/form-data">
    @csrf

    {{-- PAGE HEADER --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-0">New Motorcycle</h4>
            <small class="text-muted">Add new Motorcycle</small>
        </div>
        <a href="{{ route('motorcycles.index') }}" class="btn btn-dark rounded-pill px-4">
            ← Back
        </a>
    </div>

    {{-- MOTORCYCLE INFORMATION --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <h6 class="fw-bold mb-3">
                <i class="fa fa-info-circle text-warning me-2"></i>
                Motorcycle Information
            </h6>

            <div class="row g-3">
                @foreach ([
                    'name'        => 'Motorcycle Name *',
                    'slug'        => 'Slug *',
                    'code'        => 'Code',
                    'quantity'    => 'Quantity',
                    'sort_order'  => 'Sorting Order'
                ] as $name => $label)
                    <div class="col-12 col-sm-6 col-lg-3">
                        <label class="form-label">{{ $label }}</label>
                        <input type="text" name="{{ $name }}" class="form-control">
                    </div>
                @endforeach

                {{-- BRAND --}}
                <div class="col-md-6">
                    <label class="form-label text-capitalize">Brand*</label>
                    <select name="brand_id" class="form-select">
                        <option value="">Select Brand</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}"
                                {{ old('brand_id', $motorcycle->brand_id ?? '') == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- STATUS --}}
                <div class="col-12 col-sm-6 col-lg-3">
                    <label class="form-label d-block">Status</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status" value="featured" checked>
                        <label class="form-check-label">Featured</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status" value="unfeatured">
                        <label class="form-check-label">Unfeatured</label>
                    </div>
                </div>

                {{-- VISIBILITY --}}
                <div class="col-12 col-sm-6 col-lg-3">
                    <label class="form-label d-block">Visibility</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="visibility" value="show" checked>
                        <label class="form-check-label">Show</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="visibility" value="hide">
                        <label class="form-check-label">Hide</label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- PRICING DETAILS --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <h6 class="fw-bold mb-3">
                <i class="fa fa-tag text-warning me-2"></i>
                Pricing Detail
            </h6>

            {{-- <div class="row g-3">
                @foreach ([
                    'monday',
                    'tuesday',
                    'wednesday',
                    'thursday',
                    'friday',
                    'saturday',
                    'sunday',
                    'holiday'
                ] as $day)
                    <div class="col-12 col-md-6 col-lg-4">
                        <label class="form-label text-capitalize">{{ $day }} Price *</label>
                        <input type="number" name="{{ $day }}_price" class="form-control">
                    </div>
                @endforeach
            </div> --}}

            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label text-capitalize">Base Price *</label>
                    <input type="number" step="0.01" name="base_price"
                        class="form-control" value="">
                </div>
                <div class="col-md-4">
                    <label class="form-label text-capitalize">Extra Price *</label>
                    <input type="number" step="0.01" name="extra_price"
                        class="form-control" value="">
                </div>
            </div>
        </div>
    </div>

    {{-- DESCRIPTION --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <h6 class="fw-bold mb-3">
                <i class="fa fa-align-left text-warning me-2"></i>
                Description
            </h6>
            <textarea id="description" name="description" class="form-control"></textarea>
        </div>
    </div>

    {{-- IMAGE --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <h6 class="fw-bold mb-3">
                <i class="fa fa-image text-warning me-2"></i>
                Image
            </h6>

            <input type="file" name="image" id="imageInput" class="form-control" accept="image/*">

            <div id="imagePreview" class="mt-3 d-none" style="max-width: 200px;">
                <img id="previewImg" class="img-thumbnail w-100">
                <button type="button"
                        class="btn btn-sm btn-danger mt-2 w-100"
                        onclick="removeImage()">
                    Remove
                </button>
            </div>
        </div>
    </div>

    {{-- SUBMIT --}}
    <div class="text-end">
        <a href="{{ route('motorcycles.index') }}" class="btn btn-dark w-md-auto px-5 rounded-pill shadow">Cancel</a>
        <button type="submit"
                class="btn inline-block btn-warning w-md-auto px-5 rounded-pill shadow">
            Save Motorcycle
        </button>
    </div>

</form>

@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>

<script>
    // CKEditor
    ClassicEditor
        .create(document.querySelector('#description'))
        .catch(error => console.error(error));

    // Image Preview
    const input = document.getElementById('imageInput');
    const previewBox = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');

    input.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        previewImg.src = URL.createObjectURL(file);
        previewBox.classList.remove('d-none');
    });

    function removeImage() {
        input.value = '';
        previewBox.classList.add('d-none');
        previewImg.src = '';
    }

    setTimeout(function () {
        const alert = document.getElementById('successAlert');
        if (alert) {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }
    }, 3000); 
</script>
@endpush
<style>
.ck-editor__editable {
    height: 300px;
    overflow-y: auto;
}

</style>
