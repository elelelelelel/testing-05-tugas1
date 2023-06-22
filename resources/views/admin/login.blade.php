<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>P. Dhe JJ Coffee</title>

    <link rel="shortcut icon" href="{{url('/img/logo.png')}}" type="image/x-icon">
    
    {{-- <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script> --}}
    <!-- UIkit CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.7.4/dist/css/uikit.min.css" />
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    
    <!-- UIkit JS -->
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.7.4/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.7.4/dist/js/uikit-icons.min.js"></script>
    
    
    <link rel="stylesheet" href="{{ URL::asset('css/editgui.css'); }} ">
    <link rel="stylesheet" href="{{ URL::asset('css/style.css'); }} ">
    
</head>
<body>
    
    <div class="uk-margin-xlarge-top" style="text-align: center;">
        @if ($errors->has('email'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
        <h2 class="">Login</h2>
        <p>Please login using your account</p>
        <form action="{{ url('/authenticate') }}" style="text-align: -webkit-center" method="POST">
            @csrf
            <fieldset class="uk-fieldset uk-flex uk-flex-column" style="width: 50%; align-items: center">
                <div class="uk-margin uk-width-1-3@s">
                    <input class="uk-input" type="email" name="email" placeholder="email" required>
                </div>
                <div class="uk-margin uk-width-1-3@s">
                    <input class="uk-input" type="password" name="password" placeholder="Password" required>
                </div>
                {{-- <a href="" class="uk-margin">Forgot your password?</a> --}}
                <input type="submit" class="uk-button uk-button-primary uk-width-1-3@s" value="Sign in">
            </fieldset>
            {{-- <p>Don't have an Account? <span><a href="">Click Here!</a></span></p> --}}
        </form>
    </div>

    {{-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-W8fXfP3gkOKtndU4JGtKDvXbO53Wy8SZCQHczT5FMiiqmQfUpWbYdTil/SxwZgAN" crossorigin="anonymous"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js" integrity="sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/" crossorigin="anonymous"></script>
    
</body>
</html>