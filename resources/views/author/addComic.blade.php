@extends('layouts.author')

@section('title', 'Thêm truyện mới')

@section('header', 'Thêm truyện mới')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Thông tin truyện mới</h5>
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

        <form action="{{ route('author.addComic') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <!-- Cột trái: Thông tin truyện -->
                <div class="col-md-8">
                    <!-- Tên truyện -->
                    <div class="mb-3">
                        <label for="ten_truyen" class="form-label">Tên truyện</label>
                        <input type="text" 
                            class="form-control @error('ten_truyen') is-invalid @enderror" 
                            id="ten_truyen" 
                            name="ten_truyen" 
                            value="{{ old('ten_truyen') }}" 
                            required>
                        @error('ten_truyen')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tác giả -->
                    <div class="mb-3">
                        <label for="tac_gia" class="form-label">Tác giả</label>
                        <input type="text" 
                            class="form-control @error('tac_gia') is-invalid @enderror" 
                            id="tac_gia" 
                            name="tac_gia" 
                            value="{{ old('tac_gia') }}" 
                            required>
                        @error('tac_gia')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Thể loại -->
                    <div class="mb-3">
                        <label for="the_loai" class="form-label">Thể loại</label>
                        <select class="form-select @error('the_loai') is-invalid @enderror" 
                                id="the_loai" 
                                name="the_loai[]" 
                                multiple 
                                required>
                            @foreach($theLoai as $tl)
                                <option value="{{ $tl->id }}" 
                                    {{ (old('the_loai') && in_array($tl->id, old('the_loai'))) ? 'selected' : '' }}>
                                    {{ $tl->ten_the_loai }}
                                </option>
                            @endforeach
                        </select>
                        @error('the_loai')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Giữ phím Ctrl để chọn nhiều thể loại.</div>
                    </div>

                    <!-- Tình trạng -->
                    <div class="mb-3">
                        <label for="tinh_trang" class="form-label">Tình trạng</label>
                        <select class="form-select @error('tinh_trang') is-invalid @enderror" 
                                id="tinh_trang" 
                                name="tinh_trang" 
                                required>
                            <option value="0" {{ old('tinh_trang') == '0' ? 'selected' : '' }}>Đang cập nhật</option>
                            <option value="1" {{ old('tinh_trang') == '1' ? 'selected' : '' }}>Hoàn thành</option>
                        </select>
                        @error('tinh_trang')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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

            <div class="mb-4">
                <label for="mo_ta" class="form-label">Mô tả</label>
                <textarea class="form-control @error('mo_ta') is-invalid @enderror" 
                        id="mo_ta" 
                        name="mo_ta" 
                        rows="6" 
                        required>{{ old('mo_ta') }}</textarea>
                @error('mo_ta')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Tạo truyện
                </button>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('author.dashboard') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Quay lại
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save me-1"></i> Lưu truyện
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