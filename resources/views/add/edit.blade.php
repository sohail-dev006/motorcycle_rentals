@extends('layouts.admin')

@section('title', 'Edit Add On')
{{-- @section('page-title', 'Edit Add On') --}}

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


<form method="POST"
      action="{{ route('add.update', ['add' => $addon->id]) }}"
      enctype="multipart/form-data">
    @csrf
    @method('PUT')



    {{-- PAGE HEADER --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-0">Edit Add On</h4>
            <small class="text-muted">Edit Add On</small>
        </div>
    </div>

    {{-- MOTORCYCLE INFORMATION --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <h6 class="fw-bold mb-3">
                <i class="fa fa-info-circle text-warning me-2"></i>
                Add On Information
            </h6>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label text-capitalize">Add On Name*</label>
                    <input type="text" name="name"
                        class="form-control"
                        value="{{ old('name', $addon->name) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label text-capitalize">Price *</label>
                    <input type="number" step="0.01" name="price"
                        class="form-control"
                        value="{{ old('price', $addon->price) }}">
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
                {{ old('description', $addon->description) }}
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

            @if($addon->image)
                <div class="mt-3" style="max-width: 200px;">
                    <img src="{{ asset('storage/'.$addon->image) }}"
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
        
        <a href="{{ route('add.index') }}" class="btn btn-dark w-md-auto px-5 rounded-pill shadow">Cancel</a>
        <button type="submit"
                class="btn inline-block btn-warning w-md-auto px-5 rounded-pill shadow">
            Update Sub-Product
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