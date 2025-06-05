@extends('layouts.author')

@section('title', 'Chi tiết truyện')

@section('header', 'Chi tiết truyện')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ $comic->ten_truyen }}</h5>
            <div>
                <a href="{{ route('author.editComic', $comic->id) }}" class="btn btn-primary">
                    <i class="fas fa-edit me-1"></i> Chỉnh sửa
                </a>
                <a href="{{ route('author.dashboard') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Quay lại
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="text-center mb-4">
                    <h5>Ảnh bìa</h5>
                     <img src="{{ asset('assets/img/cover_img/' . $comic->anh_bia) }}" alt="{{ $comic->ten_truyen }}" class="img-fluid rounded">
                </div>
                
                <div class="text-center">
                    <h5>Ảnh banner</h5>
                    <img src="{{ asset('assets/img/anh_banner/' . $comic->anh_banner) }}" alt="{{ $comic->ten_truyen }}" class="img-fluid rounded">
                </div>
            </div>
            
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Thông tin truyện</h5>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <th style="width: 150px;">ID:</th>
                                <td>{{ $comic->id }}</td>
                            </tr>
                            <tr>
                                <th>Tên truyện:</th>
                                <td>{{ $comic->ten_truyen }}</td>
                            </tr>
                            <tr>
                                <th>Tác giả:</th>
                                <td>{{ $comic->tac_gia }}</td>
                            </tr>
                            <tr>
                                <th>Tình trạng:</th>
                                <td>
                                    @if($comic->tinh_trang == '0')
                                        <span class="badge bg-primary">Đang tiến hành</span>
                                    @else
                                        <span class="badge bg-success">Hoàn thành</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Ngày đăng:</th>
                                <td>{{ date('d/m/Y H:i', strtotime($comic->ngay_dang)) }}</td>
                            </tr>
                            <tr>
                                <th>Cập nhật:</th>
                                <td>{{ date('d/m/Y H:i', strtotime($comic->ngay_update)) }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Mô tả</h5>
                    </div>
                    <div class="card-body">
                        <p style="white-space: pre-line;">{{ $comic->mo_ta }}</p>
                    </div>
                </div>
                
                <div class="card mt-4">
                    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Danh sách chương</h5>
                        <a href="#" class="btn btn-light btn-sm">
                            <i class="fas fa-plus me-1"></i> Thêm chương mới
                        </a>
                    </div>
                    <div class="card-body">
                        <p class="text-center">Chưa có chương nào cho truyện này.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection