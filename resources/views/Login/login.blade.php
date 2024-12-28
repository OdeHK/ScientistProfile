<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.8">
    <title>Login</title>

    <!-- Liên kết Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/css/sign.css">
</head>

<body>
    <section class="gradient-custom">
        <div class="container py-2 h-100">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-12 col-lg-9 col-xl-7">
                    <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                        <div class="card-body p-4 p-md-5">
                            <div class="scrollable-form">
                                <form action="{{route('user.login')}}" method="POST">
                                    @csrf
                                    <div class="row mb-3">
                                        <div class="col d-flex align-items-center">
                                            <h3>Login</h3>
                                        </div>
                                        <div class="col">
                                            @if($errors->any())
                                                <div class="alert alert-danger">
                                                    {{$errors->first()}}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col">
                                            <div class="form-floating">
                                                <input type="email" id="email" name="email" class="form-control"
                                                    value="" placeholder="email">
                                                <label for="email">Email</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col">
                                            <div class="form-floating">
                                                <input type="password" id="password" name="password"
                                                    class="form-control" value="" placeholder="Password">
                                                <label for="password">Password</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-md-4 text-center">
                                            <a href="{{route('user.signUp')}}" class="btn btn-success w-100">Sign Up</a>
                                        </div>
                                        <div class="col-md-4 text-center">
                                            <input type="submit" class="btn btn-primary w-100" value="Login"
                                                href="{{route('user.signUp')}}">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>