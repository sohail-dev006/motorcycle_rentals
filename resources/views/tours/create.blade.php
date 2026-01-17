@extends('layouts.admin')

@section('title', 'Add New Tour')
@section('page-title', 'New Tour')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body">
        <h4 class="mb-3">Tour Information</h4>

        <form action="{{ route('tours.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row g-3">
                <div class="col-12 col-sm-6 col-lg-4">
                    <label for="name" class="form-label">Tour Name*</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>

                <div class="col-12 col-sm-6 col-lg-4">
                    <label for="slug" class="form-label">Slug *</label>
                    <input type="text" name="slug" class="form-control" value="{{ old('slug') }}" required>
                </div>

                <div class="col-12 col-sm-6 col-lg-4">
                    <label for="status" class="form-label">Status*</label>
                    <select name="status" class="form-control" required>
                        <option value="featured" {{ old('status') == 'featured' ? 'selected' : '' }}>Featured</option>
                        <option value="unfeatured" {{ old('status') == 'unfeatured' ? 'selected' : '' }}>Unfeatured</option>
                    </select>
                </div>

                <div class="col-12 col-sm-6 col-lg-4">
                    <label class="form-label">Group Tour Price*</label>
                    <input type="number" name="group_price" class="form-control" step="0.01" value="{{ old('group_price', 0) }}" required>
                </div>

                <div class="col-12 col-sm-6 col-lg-4">
                    <label class="form-label">Private Tour Price*</label>
                    <input type="number" name="private_price" class="form-control" step="0.01" value="{{ old('private_price', 0) }}" required>
                </div>

                <div class="col-12 col-sm-6 col-lg-4">
                    <label class="form-label">Passenger Price*</label>
                    <input type="number" name="passenger_price" class="form-control" step="0.01" value="{{ old('passenger_price', 0) }}" required>
                </div>
            </div>

            {{-- DESCRIPTION --}}
            <div class="card shadow-sm border-0 my-4">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">
                        <i class="fa fa-align-left text-warning me-2"></i>
                        Description
                    </h6>
                    <textarea id="description" name="description" class="form-control">{{ old('description') }}</textarea>
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

            <div class="text-end">
                <a href="{{ route('tours.index') }}" class="btn btn-dark w-md-auto px-5 rounded-pill shadow">Cancel</a>
                <button type="submit" class="btn inline-block btn-warning w-md-auto px-5 rounded-pill shadow">
                    Add Tour
                </button>
            </div>
        </form>
    </div>
</div>
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
