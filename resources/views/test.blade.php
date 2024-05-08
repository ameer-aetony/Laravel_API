<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
</head>
<body>
    <form method="post" action="{{ route('route.log') }}">
        @csrf <!-- {{ csrf_field() }} -->
        @method('POST')

        <h1 class="h3 mb-3 fw-normal">Login</h1>



        <div class="form-group form-floating mb-3">
            <input type="text" class="form-control" name="email" value="{{ old('email') }}" placeholder="email"  autofocus>
            <label for="floatingName">Email or Username</label>

        </div>

        <div class="form-group form-floating mb-3">
            <input type="password" class="form-control" name="password" value="{{ old('password') }}" placeholder="Password" >
            <label for="floatingPassword">Password</label>

        </div>

        <button class="w-100 btn btn-lg btn-primary" type="submit">Login</button>
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="list-unstyled">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

    </form>
</body>
</html>
