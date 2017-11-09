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
        <div class="container" style="padding:10px;">
            
            <h2 style="text-align: center;">List of users</h2><br>
           
<table class="table">
    
  <thead class="thead-inverse" style="background-color: #269abc; color: white;">
      <tr>
      <th>Username</th>
      <th>E-mail</th>
      <th>Joined</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
      
      @foreach($decoded->users as $user)
    <tr>
      <td>{{$user->name}}</td>
      <td>{{$user->email}}</td>
      <td>{{$user->created_at}}</td>
      <td style="float:right;">
          
          <a href="edituser/{{$user->id}}"><button class="btn btn-primary">Edit</button></a>
          <a href="deleteuser/{{$user->id}}"><button class="btn btn-primary">Delete</button></a>
          <a href="addrole/{{$user->id}}"><button class="btn btn-primary">Add Role</button></a>
          <a href="removerole/{{$user->id}}"><button class="btn btn-primary">Remove role</button></a>
          
          
      </td>
    </tr>
    @endforeach
  </tbody>
</table>


        </div> <!--containerfluid-->
    </body>


</html>



