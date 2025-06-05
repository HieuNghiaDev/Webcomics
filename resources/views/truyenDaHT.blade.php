@extends('layouts.app')

@section('title', 'Truyện Đã Hoàn Thành - 3M Online')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/navall.css') }}">
@endsection

@section('content')
<div class="container-fluid container-xl py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/"><i class="fas fa-home"></i> Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Đã Hoàn Thành</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="section-title">
                <h2><i class="fas fa-book-open text-success me-2"></i>Truyện Đã Hoàn Thành</h2>
                <p class="text-muted">Những truyện tranh đã kết thúc, đọc trọn bộ</p>
            </div>
        </div>
    </div>

    <div class="row completed-manga">
        @foreach($truyenHoanThanh as $truyen)
            <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4">
                <div class="manga-card">
                    <a href="{{ route('truyen.show', $truyen->id) }}" class="manga-card-image">
                        <img src="{{ asset('assets/img/cover_img/' . $truyen->anh_bia) }}" alt="{{ $truyen->ten_truyen }}">
                        <div class="manga-card-stats">
                            <span class="completed"><i class="fas fa-check-circle"></i> Hoàn thành</span>
                        </div>
                    </a>
                    <div class="manga-card-info">
                        <h3 class="manga-card-title">
                            <a href="{{ route('truyen.show', $truyen->id) }}">{{ $truyen->ten_truyen }}</a>
                        </h3>
                        <div class="manga-card-meta">
                            <span class="badge bg-success">Hoàn thành</span>
                            @if(isset($truyen->chapters) && $truyen->chapters->count() > 0)
                                <span class="chapters-count">{{ $truyen->chapters->count() }} chương</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $truyenHoanThanh->links() }}
    </div>
</div>
@endsection