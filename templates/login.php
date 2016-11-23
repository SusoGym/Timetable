<?php namespace timetable;
include "header.php";
?>

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

<?php include "js.php"; ?>