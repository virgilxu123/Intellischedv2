<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://kit.fontawesome.com/1b65260656.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.2/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.3/components/logins/login-3/assets/css/login-3.css">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
        <style>
            *{
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: "Poppins", sans-serif;
            }
            body{
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                background: url('{{ asset("admin-assets/image/NEMSU2.png") }}') no-repeat;
                background-size: cover;
                background-position: center;
            }
            body::after {
                content: "";
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.7); /* Adjust the last value (0.5) for opacity */
                z-index: 1; /* Ensure the overlay appears above the background image */
            }
            .wrapper{
                width: 420px;
                background: transparent;
                border: 2px solid rgba(255, 255, 255, .2);
                backdrop-filter: blur(9px);
                color: #fff;
                border-radius: 12px;
                padding: 30px 40px;
                z-index: 2;
            }
            .wrapper h1{
                font-size: 36px;
                text-align: center;
            }
            .wrapper .input-box{
                position: relative;
                width: 100%;
                height: 50px;
                
                margin: 30px 0;
            }
            .input-box input{
                width: 100%;
                height: 100%;
                background: transparent;
                border: none;
                outline: none;
                border: 2px solid rgba(255, 255, 255, .2);
                border-radius: 40px;
                font-size: 16px;
                color: #fff;
                padding: 20px 45px 20px 20px;
            }
            .input-box input::placeholder{
                color: #fff;
            }
            .input-box i{
                position: absolute;
                right: 20px;
                top: 30%;
                transform: translate(-50%);
                font-size: 20px;

            }
            .wrapper .remember-forgot{
                display: flex;
                justify-content: space-between;
                font-size: 14.5px;
                margin: -15px 0 15px;
            }
            .remember-forgot label input{
                accent-color: #fff;
                margin-right: 3px;

            }
            .remember-forgot a{
                color: #fff;
                text-decoration: none;

            }
            .remember-forgot a:hover{
                text-decoration: underline;
            }
            .wrapper .btn{
                width: 100%;
                height: 45px;
                background: #fff;
                border: none;
                outline: none;
                border-radius: 40px;
                box-shadow: 0 0 10px rgba(0, 0, 0, .1);
                cursor: pointer;
                font-size: 16px;
                color: #333;
                font-weight: 600;
            }
            .wrapper .register-link{
                font-size: 14.5px;
                text-align: center;
                margin: 20px 0 15px;

            }
            .register-link p a{
                color: #fff;
                text-decoration: none;
                font-weight: 600;
            }
            .register-link p a:hover{
                text-decoration: underline;
            }
        </style>
    </head>
    <body>
        <div class="wrapper animate__animated animate__pulse">
            <form action="{{route('login')}}" method="POST">
                @csrf   
                <h1>Intellisched</h1>
                <div class="input-box">
                    <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com" required>
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box">
                    <input type="password" class="form-control" name="password" id="password" value="" placeholder="Password" required>
                    <i class='bx bxs-lock-alt' ></i>
                </div>
                <div class="remember-forgot">
                    <label><input type="checkbox">Remember Me</label>
                    <a href="#">Forgot Password</a>
                </div>
                <button type="submit" class="btn">Login</button>
            </form>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

    </body>
</html>
