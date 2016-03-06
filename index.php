<?php session_start(); ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Vertretungsplan</title>
    <link rel="stylesheet" href="http://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/css/materialize.min.css">
    <link rel="stylesheet" href="style.css">
  </head>
  <body class="red container">
    <div class="row">
      <div class="col s12 m8 l4 offset-m2 offset-l4 card" style="margin-top: 100px;">
        <div class="card-content">
          <span class="card-title red-text">Anmelden</span>
          <form action="login.php" method="post">
            <div class="input-field">
              <i class="material-icons prefix">person</i>
              <input id="username" type="text" name="usr" required>
              <label for="username">Benutzername</label>
            </div>
            <div class="input-field">
              <i class="material-icons prefix">vpn_key</i>
              <input id="password" type="password" name="pwd" required>
              <label for="password">Passwort</label>
            </div>
            <input type="submit" class="btn-flat red-text right" style="margin-bottom: 20px;" value="go">
          </form>
        </div>
      </div>
    </div>
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/js/materialize.min.js"></script>
  </body>
</html>
