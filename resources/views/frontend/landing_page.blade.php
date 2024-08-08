<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SELP | BRAC</title>
    <link rel="icon" href="{{ asset('backend/images/logo2.png') }}" type="image/x-icon" sizes="16x16" />
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Expletus+Sans&family=Gloock&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            width: 100%;
            height: 100vh;
        }

        .bg-banner-section {
            background-image: url('frontend/images/bg3.png');
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            position: relative;
            z-index: 1;
        }

        .bg-banner-section::before {
            position: absolute;
            content: '';
            width: 100%;
            height: 100vh;
            top: 0;
            left: 0;
            z-index: -1;
            background: inherit;
            filter: blur(1px);
        }

        .bg-banner-section .banner-section {
            position: absolute;
            width: 100%;
            height: 90%;
            padding-top: 5%;
            
        }

        .bg-banner-section .footer-section {
            position: absolute;
            width: 100%;
            height: 10%;
            bottom: 0;
        }


        .top-section h1 {
            font-family: 'Gloock';
            font-style: normal;
            font-weight: 700;
            font-size: 64px;
            /* line-height: 43px; */
            /* text-transform: uppercase; */
            color: #f10e7b;
            /* text-align: end; */
            padding: 10px 0;
            padding-right: 33px;
        }

        .login-icon {
            background: rgba(255, 249, 249, 0.7);
            padding-top: 10px;
            padding-bottom: 10px;
        }
    </style>
</head>

<body class="bg-banner-section">
    <section class="banner-section">
        <div class="container-fluid h-100">
            <div class="row h-100">
                <div class="col-5 h-100 d-flex flex-column justify-content-center" style="padding:25px;">
                    <div class="mb-3">
                        <img class="" width="150px;" src="{{ asset('frontend/images/logo.png') }}" alt="brac-logo">
                    </div>
                    <div class="mb-3">
                        <h1 class="mb-0 fs-2" style="color:#ec008c;font-weight: 900; letter-spacing: -1px;">Social Empowerment And Legal Protection (SELP) <br> Data Management System</h1>
                    </div>
                    <div class="">
                        <a href="{{ route('login') }}"><img src="{{ asset('frontend/images/login.png') }}" alt="" height="60px"></a>
                    </div>
                </div>
                <div class="col-7 h-100" style="padding: 0px 25px;">
                    <div class="banner-img h-100">
                        <img class="w-100 rounded shadow h-100" style="object-fit: cover;" src="{{ asset('frontend/images/login_image.png') }}" alt="banner-img">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="footer-section">
        <div class="container-fluid h-100">
            <div class="row h-100">
                <div class="d-flex justify-content-between align-ite py-3 px-4">
                    <div class="">
                        <h1 class="mb-0 fs-6 " style="color:#ec008c">© Copyright - {{ date('Y') }}<a href="https://brac.net/" target="_blank" class="text-decoration-none fw-bold" style="color:white"> BRAC</a></h1>
                    </div>
                    <div class="">
                        <h1 class="mb-0 fs-6" style="color:#ec008c">Developed by <a href="http://www.nanoit.biz/" target="_blank" class="text-decoration-none fw-bold" style="color:white">Nanosoft</a>
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>

</html>
