<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên mật khẩu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: #f8f9fa;
            background-image: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            height: 100vh;
        }
        .password-container {
            max-width: 450px;
            margin: 0 auto;
            padding-top: 10%;
        }
        .password-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        .password-card-header {
            background: #ffffff;
            border-radius: 10px 10px 0 0;
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid #f2f2f2;
        }
        .password-card-body {
            padding: 30px;
        }
        .form-control {
            height: 50px;
            border-radius: 8px;
        }
        .btn-reset {
            height: 50px;
            background-color: #4e73df;
            border-color: #4e73df;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-reset:hover {
            background-color: #3a5bbc;
            border-color: #3a5bbc;
        }
        .password-footer {
            text-align: center;
            margin-top: 25px;
        }
        .password-footer a {
            color: #4e73df;
            text-decoration: none;
        }
        .password-footer a:hover {
            text-decoration: underline;
        }
        .brand-logo {
            width: 80px;
            height: 80px;
            margin: 0 auto 15px;
            background-color: #4e73df;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .brand-logo i {
            font-size: 40px;
            color: white;
        }
        .input-group-text {
            background-color: #f8f9fa;
            border-right: none;
        }
        .form-control.with-icon {
            border-left: none;
        }
    </style>
</head>
<body>
    <div class="container password-container">
        <div class="card password-card">
            <div class="password-card-header">
                <div class="brand-logo">
                    <i class="fas fa-key"></i>
                </div>
                <h3>Quên mật khẩu</h3>
                <p class="text-muted">Nhập email của bạn để đặt lại mật khẩu</p>
            </div>
            
            <div class="password-card-body">
                @if(session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                
                <form action="#" method="post">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="email" class="form-label">Địa chỉ Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" class="form-control with-icon @error('email') is-invalid @enderror" 
                                id="email" name="email" placeholder="Nhập địa chỉ email" 
                                value="{{ old('email') }}" required autofocus>
                        </div>
                        @error('email')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary btn-reset">
                            <i class="fas fa-paper-plane me-2"></i> Gửi liên kết đặt lại mật khẩu
                        </button>
                    </div>
                </form>
                
                <div class="password-footer">
                    <p><a href="{{ route('login') }}"><i class="fas fa-arrow-left me-1"></i> Quay lại đăng nhập</a></p>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-4 text-muted">
            <small>&copy; {{ date('Y') }} HieuNghiaDev. Tất cả các quyền được bảo lưu.</small>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>