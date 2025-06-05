@extends('layouts.app')

@section('title', 'Bảng Xếp Hạng - 3M Online')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/bxh.css') }}">
@endsection

@section('content')
<div class="container-fluid container-xl py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/"><i class="fas fa-home"></i> Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Bảng xếp hạng</li>
        </ol>
    </nav>

    <div class="ranking-container">
        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="section-title">
                    <h2><i class="fas fa-trophy text-warning me-2"></i>Bảng Xếp Hạng</h2>
                    <p class="text-muted">Khám phá những truyện được yêu thích nhất trên 3M Online</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="ranking-list">
                    @foreach($truyenTopView as $index => $truyen)
                        <div class="ranking-item">
                            <div class="row align-items-center">
                                <div class="col-md-1 col-2">
                                    <div class="rank-number {{ $index < 3 ? 'top-rank top-' . ($index+1) : '' }}">
                                        {{ ($truyenTopView->currentPage() - 1) * $truyenTopView->perPage() + $index + 1 }}
                                    </div>
                                </div>
                                <div class="col-md-2 col-4">
                                    <a href="{{ route('truyen.show', $truyen->id) }}" class="rank-image-wrapper">
                                        <img src="{{ asset('assets/img/cover_img/' . $truyen->anh_bia) }}" 
                                            alt="{{ $truyen->ten_truyen }}" class="rank-image">
                                    </a>
                                </div>
                                <div class="col-md-7 col-6">
                                    <div class="rank-info">
                                        <h3 class="rank-title">
                                            <a href="{{ route('truyen.show', $truyen->id) }}">{{ $truyen->ten_truyen }}</a>
                                        </h3>
                                        <div class="rank-meta">
                                            <span class="author"><i class="fas fa-user me-1"></i>{{ $truyen->tac_gia }}</span>
                                            <span class="category">
                                                <i class="fas fa-tag me-1"></i>
                                                @foreach($truyen->theLoai->take(3) as $index => $theLoai)
                                                    {{ $index > 0 ? ', ' : '' }}
                                                    <a href="{{ route('the-loai.show', $theLoai->id) }}">{{ $theLoai->ten_the_loai }}</a>
                                                @endforeach
                                                @if($truyen->theLoai->count() > 3)
                                                    <span class="more-categories">+{{ $truyen->theLoai->count() - 3 }}</span>
                                                @endif
                                            </span>
                                        </div>
                                        <div class="rank-stats">
                                            <span class="views"><i class="fas fa-eye me-1"></i>{{ number_format($truyen->luot_xem) }}</span>
                                            <span class="rating"><i class="fas fa-star me-1"></i>{{ number_format($truyen->rating, 1) }}</span>
                                            <span class="status">
                                                @if($truyen->tinh_trang == 1)
                                                    <span class="badge bg-success">Hoàn thành</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">Đang cập nhật</span>
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 d-none d-md-block">
                                    <div class="rank-actions">
                                        <a href="{{ route('truyen.show', $truyen->id) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-book-open me-1"></i>Đọc ngay
                                        </a>
                                        <a href="#" class="btn btn-outline-secondary btn-sm mt-2">
                                            <i class="fas fa-bookmark me-1"></i>Theo dõi
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $truyenTopView->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
