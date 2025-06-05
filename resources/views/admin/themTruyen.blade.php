@extends('layouts.admin')

@section('title', 'Thêm truyện mới')

@section('page-title', 'Thêm truyện mới')

@section('page-actions')
<a href="{{ route('truyen') }}" class="btn btn-secondary">
    <i class="fas fa-arrow-left me-1"></i> Quay lại
</a>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('truyen.luu') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="ten_truyen" class="form-label">Tên truyện</label>
                                <input type="text" class="form-control @error('ten_truyen') is-invalid @enderror" id="ten_truyen" name="ten_truyen" value="{{ old('ten_truyen') }}" required>
                                @error('ten_truyen')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="tac_gia" class="form-label">Tác giả</label>
                                <input type="text" class="form-control @error('tac_gia') is-invalid @enderror" id="tac_gia" name="tac_gia" value="{{ old('tac_gia') }}" required>
                                @error('tac_gia')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="the_loai" class="form-label">Thể loại</label>
                                <select class="form-select @error('the_loai') is-invalid @enderror" id="the_loai" name="the_loai[]" multiple required>
                                    @foreach($theLoai as $tl)
                                        <option value="{{ $tl->id }}" {{ (old('the_loai') && in_array($tl->id, old('the_loai'))) ? 'selected' : '' }}>{{ $tl->ten_the_loai }}</option>
                                    @endforeach
                                </select>
                                @error('the_loai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Giữ phím Ctrl để chọn nhiều thể loại.</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="tinh_trang" class="form-label">Tình trạng</label>
                                <select class="form-select @error('tinh_trang') is-invalid @enderror" id="tinh_trang" name="tinh_trang" required>
                                    <option value="0" {{ old('tinh_trang') == '0' ? 'selected' : '' }}>Đang cập nhật</option>
                                    <option value="1" {{ old('tinh_trang') == '1' ? 'selected' : '' }}>Hoàn thành</option>
                                </select>
                                @error('tinh_trang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="anh_bia" class="form-label">Ảnh bìa</label>
                                <input type="file" class="form-control @error('anh_bia') is-invalid @enderror" id="anh_bia" name="anh_bia" accept="image/*" required>
                                @error('anh_bia')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="text-center mt-3">
                                <div class="cover-preview mb-3">
                                    <img id="previewImage" src="https://via.placeholder.com/250x350?text=Ảnh+bìa" alt="Preview" class="img-thumbnail" style="max-width: 100%; height: 350px; object-fit: cover;">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="mo_ta" class="form-label">Mô tả</label>
                        <textarea class="form-control @error('mo_ta') is-invalid @enderror" id="mo_ta" name="mo_ta" rows="6" required>{{ old('mo_ta') }}</textarea>
                        @error('mo_ta')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Tạo truyện
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    // Preview ảnh bìa
    document.getElementById('anh_bia').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('previewImage').src = event.target.result;
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
@endsection