@extends('layouts.app')

@section('title', 'Truyện Hot - 3M Online')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/navall.css') }}">
@endsection

@section('content')
<div class="container-fluid container-xl py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/"><i class="fas fa-home"></i> Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Truyện Hot</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="section-title">
                <h2><i class="fas fa-fire text-danger me-2"></i>Truyện Hot</h2>
                <p class="text-muted">Những truyện tranh được nhiều người đọc nhất</p>
            </div>
        </div>
    </div>

    <div class="row hot-manga">
        @foreach($truyenHot as $truyen)
            <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4">
                <div class="manga-card">
                    <a href="{{ route('truyen.show', $truyen->id) }}" class="manga-card-image">
                        <img src="{{ asset('assets/img/cover_img/' . $truyen->anh_bia) }}" alt="{{ $truyen->ten_truyen }}">
                        <div class="manga-card-stats">
                            <span class="views"><i class="fas fa-eye"></i> {{ number_format($truyen->luot_xem) }}</span>
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
        {{ $truyenHot->links() }}
    </div>
</div>
@endsection