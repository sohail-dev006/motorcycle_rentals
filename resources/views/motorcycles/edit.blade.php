@extends('layouts.admin')

@section('title', 'Edit Motorcycle')
@section('page-title', 'Edit Motorcycle')

@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST"
      action="{{ route('motorcycles.update', $motorcycle->id) }}"
      enctype="multipart/form-data">
    @csrf
    @method('PUT')

    {{-- PAGE HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">Edit Motorcycle</h4>
            <small class="text-muted">Update Motorcycle details</small>
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
                {{-- NAME --}}
                <div class="col-12 col-sm-6 col-lg-3">
                    <label class="form-label">Motorcycle Name *</label>
                    <input type="text"
                           name="name"
                           class="form-control"
                           value="{{ old('name', $motorcycle->name) }}">
                </div>



                <div class="col-12 col-sm-6 col-lg-3">
                    <label class="form-label">Slug *</label>
                    <input type="text"
                           name="slug"
                           id="motorcycleSlug"
                           class="form-control"
                           value="{{ old('slug', $motorcycle->slug) }}">
                </div>

                {{-- CODE --}}
                <div class="col-12 col-sm-6 col-lg-3">
                    <label class="form-label">Code</label>
                    <input type="text"
                           name="code"
                           class="form-control"
                           value="{{ old('code', $motorcycle->code) }}">
                </div>

                {{-- QUANTITY --}}
                <div class="col-12 col-sm-6 col-lg-3">
                    <label class="form-label">Quantity</label>
                    <input type="number"
                           name="quantity"
                           min="0"
                           class="form-control"
                           value="{{ old('quantity', $motorcycle->quantity) }}">
                </div>

                {{-- Brands --}}
                
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


                {{-- SORT ORDER --}}
                <div class="col-12 col-sm-6 col-lg-3">
                    <label class="form-label">Sort Order</label>
                    <input type="number"
                           name="sort_order"
                           min="0"
                           class="form-control"
                           value="{{ old('sort_order', $motorcycle->sort_order) }}">
                </div>

                {{-- STATUS --}}
                <div class="col-12 col-sm-6 col-lg-3">
                    <label class="form-label d-block">Status</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input"
                               type="radio"
                               name="status"
                               value="featured"
                               {{ old('status', $motorcycle->status) == 'featured' ? 'checked' : '' }}>
                        <label class="form-check-label">Featured</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input"
                               type="radio"
                               name="status"
                               value="unfeatured"
                               {{ old('status', $motorcycle->status) == 'unfeatured' ? 'checked' : '' }}>
                        <label class="form-check-label">Unfeatured</label>
                    </div>
                </div>

                {{-- VISIBILITY --}}
                <div class="col-12 col-sm-6 col-lg-3">
                    <label class="form-label d-block">Visibility</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input"
                               type="radio"
                               name="visibility"
                               value="show"
                               {{ old('visibility', $motorcycle->visibility) == 'show' ? 'checked' : '' }}>
                        <label class="form-check-label">Show</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input"
                               type="radio"
                               name="visibility"
                               value="hide"
                               {{ old('visibility', $motorcycle->visibility) == 'hide' ? 'checked' : '' }}>
                        <label class="form-check-label">Hide</label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- PRICING --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <h6 class="fw-bold mb-3">
                <i class="fa fa-tag text-warning me-2"></i>
                Pricing Detail
            </h6>

            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Base Price *</label>
                    <input type="number"
                           step="0.01"
                           name="base_price"
                           class="form-control"
                           value="{{ old('base_price', $motorcycle->base_price) }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Extra Price *</label>
                    <input type="number"
                           step="0.01"
                           name="extra_price"
                           class="form-control"
                           value="{{ old('extra_price', $motorcycle->extra_price) }}">
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

            <textarea id="description"
                      name="description"
                      class="form-control">
                {{ old('description', $motorcycle->description) }}
            </textarea>
        </div>
    </div>

    {{-- IMAGE --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <h6 class="fw-bold mb-3">
                <i class="fa fa-image text-warning me-2"></i>
                Image
            </h6>

            <input type="file"
                   name="image"
                   id="imageInput"
                   class="form-control"
                   accept="image/*">

            @if($motorcycle->image)
                <div class="mt-3" style="max-width: 200px;">
                    <img src="{{ asset('storage/'.$motorcycle->image) }}"
                         class="img-thumbnail w-100">
                </div>
            @endif

            <div id="imagePreview" class="mt-3 d-none" style="max-width: 200px;">
                <img id="previewImg" class="img-thumbnail w-100">
            </div>
        </div>
    </div>

    {{-- SUBMIT --}}
    <div class="text-end">
        <a href="{{ route('motorcycles.index') }}"
           class="btn btn-dark px-5 rounded-pill">
            Cancel
        </a>
        <button type="submit"
                class="btn btn-warning px-5 rounded-pill">
            Update Motorcycle
        </button>
    </div>

</form>

@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>

<script>
    ClassicEditor
        .create(document.querySelector('#description'))
        .catch(error => console.error(error));

    const input = document.getElementById('imageInput');
    const previewBox = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');

    input.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        previewImg.src = URL.createObjectURL(file);
        previewBox.classList.remove('d-none');
    });
</script>
@endpush
<style>
.ck-editor__editable {
    height: 300px;
    overflow-y: auto;
}
</style>