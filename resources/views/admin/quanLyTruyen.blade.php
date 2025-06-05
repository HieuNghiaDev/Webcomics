@extends('layouts.admin')

@section('title', 'Quản lý truyện')

@section('page-title', 'Quản lý truyện')

@section('page-actions')
<a href="{{ route('truyen.them') }}" class="btn btn-primary">
    <i class="fas fa-plus-circle me-1"></i> Thêm truyện
</a>
@endsection

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <!-- Tìm kiếm và lọc -->
        <form action="{{ route('truyen') }}" method="GET" class="mb-4">
            <div class="row g-2">
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="Tìm kiếm theo tên..." value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <!-- Bảng truyện -->
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Ảnh bìa</th>
                        <th scope="col">Tên truyện</th>
                        <th scope="col">Tác giả</th>
                        <th scope="col">Thể loại</th>
                        <th scope="col">Lượt xem</th>
                        <th scope="col">Tình trạng</th>
                        <th scope="col">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($truyen as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>
                            <img src="{{ asset('assets/img/cover_img/' . $item->anh_bia) }}" alt="{{ $item->ten_truyen }}" class="img-thumbnail" style="width: 60px; height: 80px; object-fit: cover;">
                        </td>
                        <td>{{ $item->ten_truyen }}</td>
                        <td>{{ $item->tac_gia }}</td>
                        <td>
                            @foreach($item->theLoai as $tl)
                                <span class="badge bg-secondary">{{ $tl->ten_the_loai }}</span>
                            @endforeach
                        </td>
                        <td>{{ $item->luot_xem }}</td>
                        <td>
                            @if ($item->tinh_trang == 1)
                                <span class="badge bg-success">Hoàn thành</span>
                            @else
                                <span class="badge bg-warning">Đang cập nhật</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('truyen.sua', $item->id) }}" class="btn btn-info">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('truyen.xoa', $item->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa truyện này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">
                            <i class="fas fa-book fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Không tìm thấy truyện nào.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Phân trang -->
        <div class="d-flex justify-content-center mt-4">
            {{ $truyen->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection