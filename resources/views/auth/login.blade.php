<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            display: flex;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            width: 55%;
            height: 520px;
        }

        .left {
            background-color: #E2F5E2;
            padding: 20px;
            width: 50%;
        }

        .left h2 {
            font-size: 16px;
            color: #34A853;
            margin-bottom: 20px;
            /* padding-top: 18%; */
            padding-top: 8%;
            text-align: center;
        }

        .left p {
            font-size: 15px;
            color: #000000;
            line-height: 1.2rem;
        }

        .right {
            /* padding: 20px; */
            padding: 20px 20px 0 0px;
            width: 50%;
        }

        .right h2 {
            font-size: 20px;
            color: #333;
            margin-bottom: 20px;
        }

        .right form {
            display: flex;
            flex-direction: column;
        }

        .right form label {
            margin-bottom: 5px;
            font-size: 16px;
        }

        .right form input {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .right .remember {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .right .remember input {
            margin-right: 5px;
        }

        button {
            padding: 10px;
            background-color: #34A853;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #2c8c39;
        }

        .support {
            margin-top: 20px;
            display: flex;
            align-items: stretch;
            position: relative;
            /* width: fit-content;
            padding-left: 10px; */
        }

        .support::before {
            content: "";
            position: absolute;
            left: 0;
            bottom: 0%;
            width: 100%;
            height: 2px;
            background-color: #34A853;
            transform: translateY(-50%);
        }

        .support button {
            background-color: #34A853;
            color: white;
            padding: 10px 20px;
            border: none;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            position: relative;
            z-index: 1;
            clip-path: polygon(0 0, 90% 0, 100% 100%, 0% 100%);
        }

        .support button:hover {
            background-color: #2c8c39;
        }

        .footer {
            font-size: 14px;
            color: #777;
            /* margin-top: 20px; */
            margin: 10px 0px 10px 20px;
            line-height: 1.2rem;
        }

        .footer-left a {
            color: #000000;
            text-decoration: none;
        }

        .footer-left a:hover {
            text-decoration: underline;
        }

        .divider {
            height: 2px;
            background-color: #34A853;
            margin: 5px 0;
        }

        .logo {
            /* flex: 1; */
            display: flex;
            justify-content: center;
        }

        .logo-img {
            width: 130px;
            height: auto;
        }

        @media screen and (min-width: 770px) and (max-width: 1280px) {
            .container {
                width: 75%;
            }

            .left,
            .right {
                width: 50%;
            }

            .left h2,
            .right h2 {
                font-size: 15px;
                margin: 0 0 0 -10px;
                padding-top: 7%;
            }

            .left p {
                font-size: 12px;
            }

            .right form label {
                font-size: 15px;
            }

            .right form input {
                padding: 12px;
            }

            button {
                font-size: 16px;
            }

            .footer-left {
                text-align: center;
                padding: 10px 0;
            }

            .logo-img {
                width: 120px;
            }

            .support button {
                font-size: 15px;
            }
        }

        @media screen and (max-width: 769px) {
            .container {
                flex-direction: column;
                width: 90%;
                height: auto;
            }

            .left,
            .right {
                width: 100%;
                padding: 20px;
            }

            .left h2 {
                padding-top: 10%;

            }

            .left h2,
            .right h2 {
                font-size: 15px;
                margin: 0 0 0 -10px;
                /* padding-top: 10%; */
            }

            .left p {
                font-size: 14px;
                display: none;
            }

            .right form label,
            .right form input {
                font-size: 14px;
            }

            button {
                font-size: 14px;
                padding: 8px;
            }

            .footer-left {
                text-align: center;
                padding: 10px 0;
                display: none;
            }

            .logo-img {
                width: 150px;
            }

            .support button {
                /* width: 100%; */
            }
        }
    </style>
</head>

<body style="overflow: hidden; height: 100vh; background: url('/imgs/cs_img.jpg') no-repeat center center fixed;
    background-size: cover; display: flex; justify-content: center; align-items: center; position: relative;">
    <div class="container">
        <div class="left">
            <div class="d-flex" style="display: flex;">
                <div class="logo">
                    <img src="/imgs/lohogo_xl.png" alt="Xuan Loc Rubber Logo" class="logo-img">
                </div>
                <h2 class="align-items-center">{{ $postLogin->name ?? '' }}</h2>
            </div>
            <p style="text-align: justify;">
                {{ $postLogin->desc ?? '' }}
            </p>
            <div class="footer-left" style="padding: 35px 0 0 0; line-height: 1.2rem;">
                <div class="divider"></div>
                <p style="color: #34A853"><strong> {{ $postLogin->company_name ?? '' }}</strong></p>
                <p>{{ $postLogin->commune_name ?? '' }}</p>
                <a href="{{ $postLogin->link ?? '#' }}" target="_blank">
                    {{ $postLogin->link ?? '' }}
                </a>
            </div>
        </div>
        <div class="right">
            <h2 style="text-align: center;">Đăng Nhập</h2>
            <form method="POST" action="/login" id="form-log" style="margin: 25px;">
                @csrf
                <label class="form-lable" for="username">Tên Đăng Nhập</label>
                <input class="form-control @error('email') is-invalid @enderror" type="email" name="email"
                    placeholder="Email" value="{{ old('email') }}">
                <label for="password">Mật Khẩu</label>
                <input class="form-control @error('password') is-invalid @enderror" type="password" name="password"
                    placeholder="Mật khẩu">
                <div class="remember">
                    <a href="{{ route('forgotIndex') }}">
                        <small>Quên mật khẩu?</small>
                    </a>
                </div>
                @error('email')
                <div class="invalid-feedback" style="color: red; padding-top:20px">{{ $message }}</div>
                @enderror
                <button type="submit">Đăng nhập</button>
            </form>
            <div class="support">
                <button>Hỗ trợ kỹ thuật</button>
            </div>
            <div class="footer">
                <p>{!! nl2br(e($postLogin->support ?? '')) !!}</p>
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('status'))
        Swal.fire({
            icon: 'success',
            title: 'Thành công!',
            text: '{{ session('status') }}',
        });
    @endif

    @if ($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Lỗi!',
            text: '{{ $errors->first() }}',
        });
    @endif
</script>
<script>
    axios.post('/api/login', { email, password })
    .then(response => {
        const { token, redirectOptions } = response.data;

        localStorage.setItem('token', token);

        if (redirectOptions) {
            const choice = window.confirm('Bạn muốn vào trang Quản lý Admin hay Truy xuất?');

            if (choice) {
                window.location.href = redirectOptions.admin;
            } else {
                window.location.href = redirectOptions.user;
            }
        }
    })
    .catch(error => {
        console.log('Đăng nhập thất bại:', error.response.data.error);
    });

</script>

</html>