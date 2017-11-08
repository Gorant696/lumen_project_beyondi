<html>


    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../css/bootstrap.css" type="text/css">
        <link rel="stylesheet" href="../css/mycss.css" type="text/css">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->

    </head>


    <body>
        <div class="container-fluid">
  
            @foreach ($decoded->signed_as as $decode)
            {{$decode}}<br>
            
            @endforeach
        </div> <!--containerfluid-->
    </body>


</html>



