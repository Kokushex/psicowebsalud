<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css?family=Maven+Pro:400,900" rel="stylesheet">

    <link href="{{asset('assets/css/page/500error.css')}}" rel="stylesheet">


    <title>Error 500</title>
</head>

<body class="loading">
    <h1 class="titulo">500</h1>
    <h2>No es posible conectarse al servidor.</h2>
    <div id="centrado">
    <a style="background-color:#4b4ef8 " href="{{url('/')}}">Volver al Inicio</a>
    </div>
    
    <div class="gears">
        <div class="gear one">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>
        <div class="gear two">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>
        <div class="gear three">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>
    </div>
   
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <script type="text/javascript">
    $(function() {
        setTimeout(function() {
            $('body').removeClass('loading');
        }, 1000);
    });
    </script>
</body>
</html>