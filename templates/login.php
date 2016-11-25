<?php namespace timetable; ?>
<!DOCTYPE html>
<html>
<?php
    include "header.php";
?>
<body class="red">
<div class="row hide-on-small-only">
    <div class="col s12  center-align" style="margin-top: 2.5%">
        <h3 class="white-text">Vertretungsplan</h3>
        <img src="http://www.suso.schulen.konstanz.de/suso_img/suso2.png">
    </div>
</div>
<div class=" row valign-wrapper" style="height: 100%">
    <div class="col card small hoverable s8 pull-s1 m6 pull-m3 l4 pull-l4 white">
        <form action="" method="post">
            <div class="card-content red-text">
                <div class=" center-align">
                    <span class="card-title red-text">Mit Novell Daten anmelden</span></div>
                <div class="row">
                    <div class="input-field col s12">
                        <i class="material-icons prefix">person</i>
                        <input id="username" type="text" name="usr" required>
                        <label for="username">Benutzername</label>
                    </div>
                    <div class="input-field col s12">
                        <i class="material-icons prefix">vpn_key</i>
                        <input id="password" type="password" name="pwd" required>
                        <label for="password">Passwort</label>
                    </div>
                </div>
            </div>
            <div class="card-action right-align">
                <button type="submit" class="btn-flat red-text waves-effect waves-teal"
                >Submit<i class="material-icons right">send</i></button>
            </div>
        </form>
    </div>
</div>

<?php include "js.php"; ?>

</body>
</html>

