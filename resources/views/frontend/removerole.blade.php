<html>


    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../css/bootstrap.css" type="text/css">
        <link rel="stylesheet" href="../css/mycss.css" type="text/css">


        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">


    </head>


    <body>

        <div class="container">

            <form method="POST" action="/removerolefromuser/{{$ids}}">

                <h2 style="text-align: center">Remove role from user</h2><br>
                
                    <div class="form-group">
                    <label for="role">Select role</label>
                    <select class="form-control" id="role" name="role">
                        <option value="admin">admin</option>
                        <option value="moderator">moderator</option>
                        <option value="employee">employee</option>
                      
                    </select>
                </div>
       
                <button type="submit" class="btn btn-primary">Register</button>
            </form>
        </div>
    </body>


</html>



