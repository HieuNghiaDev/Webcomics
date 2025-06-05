@extends('layouts.author')

@section('title', 'Chỉnh sửa truyện')

@section('header', 'Chỉnh sửa truyện')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Chỉnh sửa truyện: {{ $comic->ten_truyen }}</h5>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('author.editComic', $comic->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group mb-3">
                        <label for="ten_truyen" class="form-label">Tên truyện <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="ten_truyen" name="ten_truyen" value="{{ old('ten_truyen', $comic->ten_truyen) }}" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="tac_gia" class="form-label">Tác giả <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="tac_gia" name="tac_gia" value="{{ old('tac_gia', $comic->tac_gia) }}" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="mo_ta" class="form-label">Mô tả <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="mo_ta" name="mo_ta" rows="5" required>{{ old('mo_ta', $comic->mo_ta) }}</textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="tinh_trang" class="form-label">Tình trạng <span class="text-danger">*</span></label>
                        <select class="form-select" id="tinh_trang" name="tinh_trang" required>
                            <option value="0" {{ old('tinh_trang', $comic->tinh_trang) == 'Đang tiến hành' ? 'selected' : '' }}>Đang cập nhật</option>
                            <option value="1" {{ old('tinh_trang', $comic->tinh_trang) == 'Hoàn thành' ? 'selected' : '' }}>Hoàn thành</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label for="anh_bia" class="form-label">Ảnh bìa <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="anh_bia" name="anh_bia" required 
                               onchange="previewImage(this, 'preview_anh_bia')">
                        <div class="mt-2">
                            <img id="preview_anh_bia" src="{{ asset('images/placeholder.png') }}" alt="Preview" 
                                 class="img-thumbnail" style="max-height: 200px; max-width: 100%;">
                        </div>
                        <small class="form-text text-muted">Định dạng: jpeg, png, jpg, gif. Tối đa 2MB.</small>
                    </div>

                    <div class="form-group mb-3">
                        <label for="anh_banner" class="form-label">Ảnh banner <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="anh_banner" name="anh_banner" required 
                               onchange="previewImage(this, 'preview_anh_banner')">
                        <div class="mt-2">
                            <img id="preview_anh_banner" src="{{ asset('images/placeholder.png') }}" alt="Preview" 
                                 class="img-thumbnail" style="max-height: 200px; max-width: 100%;">
                        </div>
                        <small class="form-text text-muted">Định dạng: jpeg, png, jpg, gif. Tối đa 2MB.</small>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('author.dashboard') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Quay lại
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save me-1"></i> Cập nhật truyện
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function previewImage(input, previewId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById(previewId).src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection