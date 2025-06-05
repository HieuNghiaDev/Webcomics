@extends('layouts.app')

@section('title', 'Truyện Mới Cập Nhật - 3M Online')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/navall.css') }}">
@endsection

@section('content')
<div class="container-fluid container-xl py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/"><i class="fas fa-home"></i> Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Mới Cập Nhật</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="section-title">
                <h2><i class="fas fa-calendar-alt text-primary me-2"></i>Truyện Mới Cập Nhật</h2>
                <p class="text-muted">Những truyện tranh mới được cập nhật gần đây</p>
            </div>
        </div>
    </div>

    <div class="row updated-manga">
        @foreach($truyenMoi as $truyen)
            <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4">
                <div class="manga-card">
                    <a href="{{ route('truyen.show', $truyen->id) }}" class="manga-card-image">
                        <img src="{{ asset('assets/img/cover_img/' . $truyen->anh_bia) }}" alt="{{ $truyen->ten_truyen }}">
                        <div class="manga-card-stats">
                            <span class="update-time"><i class="fas fa-clock"></i> {{ $truyen->ngay_update ? \Carbon\Carbon::parse($truyen->ngay_update)->diffForHumans() : 'Chưa cập nhật' }}</span>
                        </div>
                    </a>
                    <div class="manga-card-info">
                        <h3 class="manga-card-title">
                            <a href="{{ route('truyen.show', $truyen->id) }}">{{ $truyen->ten_truyen }}</a>
                        </h3>
                        <div class="manga-card-meta">
                            @if($truyen->tinh_trang == 1)
                                <span class="badge bg-success">Hoàn thành</span>
                            @else
                                <span class="badge bg-warning text-dark">Đang cập nhật</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $truyenMoi->links() }}
    </div>
</div>
@endsection