<?php
require_once __DIR__ . '/../config.php';

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
    <title>Validation de formulaire</title>
  </head>
  <body>
    <div class="container">
      
    
    <h1 class="my-3">Connexion</h1>
    <form action="App/Controller/login.php" method="post">

      <div class="form-floating mb-3">
        <input type="text" class="form-control" id="login" name="login"  required placeholder="ddd">
        <label for="login">Login </label>
      </div>

      <div class="form-floating mb-3">
        <input type="password" class="form-control" id="password" name="password" required  placeholder="eeee">
        <label for="password">Password </label>
      </div>

      <input type="submit" value="Connexion">

    </form>
    </div>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
