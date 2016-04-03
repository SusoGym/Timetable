<?php
    session_start();
    include("func.php");
    include("readdata.php");
    initDate();
    $usr = $_SESSION["user"]["usr"];
    $pwd = $_SESSION["user"]["pwd"];
    $data = readdata($usr, $pwd);
    $data = sortData($data, 'hour');
    $data = group($data, 'class');

    ksort($data);

    $grade = get_grade($usr, $pwd);
    if (!$_SESSION["login"]) { header("Location: logout.php"); }
?>
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
  <body class="grey lighten-2">
    <div class="navbar-fixed" id="header">
      <nav>
        <div class="nav-wrapper red">
          <a class="brand-logo center">Vertretungsplan</a>
          <ul id="nav-mobile" class="right" style="white-space:nowrap;">
            <li>
                    <span class="hide-on-med-and-down"><?php

                        if(isSuperUser())
                        {
                            echo "<i title='SuperUser' class='material-icons left' style='font-size: 15px;'>adb</i> $usr, $grade";
                        }else{
                            echo "$usr, $grade";
                        }

                        ?></span>
            </li>
            <li>
                <a href="logout.php" title="Logout">
                    <i class="material-icons right">power_settings_new</i>
                </a>
            </li>
          </ul>

          <?php if(isSuperUser()): ?>
          <ul id="nav-mobile" class="left">
              <a title="Toggle show all classes" id="toggle_show_all">
                  <i class="material-icons left" id="superuser_icon"><?php if(isset($_SESSION["disp_all"])) echo "people"; else echo "person"; ?></i>
              </a>
          </ul>
          <?php endif; ?>
        </div>
      </nav>
    </div>
    <div class="container" id="main">
              <?php
              for ($i=0; $i <= 1; $i++) {
                $day = ($i == 0) ? $thisday : $thatday;
                $x = 0;
              ?>
                <div class="hoverable card white">
                    <div class="card-content">
              <span class="card-title red-text"><i class="material-icons">date_range</i>&nbsp;&nbsp;<?php echo $day["txt"]; ?>:</span>
              <?php
              $lastClass = "";
                foreach ($data as $class => $classData)
                    foreach ($classData as $key => $entry) {
                      if(date("j", $entry["date"]) == $day["day"] AND checkClassToDisplay($entry["class"], $grade)) {
                        $x++;
                        if ($x == 1) {
                  ?>
                  <table class="striped responsive-table">
                  <thead>
                    <tr>
                        <?php if(isset($_SESSION['disp_all'])) { echo "<th>Klasse</th>"; }; ?>
                        <th>Stunde</th>
                        <th>Lehrer</th>
                        <th>Fach</th>
                        <th>Raum</th>
                        <th>statt Lehrer:</th>
                        <th>statt Raum:</th>
                        <th>Kommentar</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php } ?>
                    <tr <?php if($lastClass != $class) echo "style='border-top: 2px solid gray'"; ?>>
                      <?php if(isset($_SESSION['disp_all'])) {echo "<td>" . (($entry["class"] == "") ? "&#8203;" : $entry["class"]) . "</td>";} ?>
                      <td><?php echo ($entry["hour"] == "") ? "&#8203;" : $entry["hour"] ?></td>
                      <td><?php echo ($entry["newteacher"] == "") ? "&#8203;" : $entry["newteacher"] ?></td>
                      <td><?php echo ($entry["newsubject"] == "") ? "&#8203;" : $entry["newsubject"] ?></td>
                      <td><?php echo ($entry["newroom"] == "") ? "&#8203;" : $entry["newroom"] ?></td>
                      <td><?php echo ($entry["actualteacher"] == "") ? "&#8203;" : $entry["actualteacher"] ?></td>
                      <td><?php echo ($entry["actualroom"] == "") ? "&#8203;" : $entry["actualroom"] ?></td>
                      <td><?php echo ($entry["comment"] == "") ? "&#8203;" : $entry["comment"] ?></td>
                    </tr>
                    <?php
                        }
                      }
                  if ($x >> 0) {
                ?>
              </tbody>
            </table>
            <?php } else { ?>
              <p>Leider gibt es für <?php echo $day["txt"]; ?> (noch) keine Vertretungen.</p>
            <?php } ?>
          </div>
      </div>
          <?php } ?>
    </div>
    <footer id="footer" class="page-footer grey darken-3">
      <div class="footer-copyright">
        <div class="container">
        © <?php echo date("Y"); ?> Jasper Krauter, Kai Berszin
        <a class="grey-text text-lighten-4 right" href="http://intranet.suso.schulen.konstanz.de/gpuntis/schueler/">Zur offiziellen Version</a>
        </div>
      </div>
    </footer>

    <div id='div_session_write' style="visibility: hidden"> </div>

    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/js/materialize.min.js"></script>
    <script type="application/javascript">
      $('#footer').css('margin-top',$(document).height() - ($('#header').height() + $('#main').height()  ) - $('#footer').height() - 28);
    </script>
    <script type="application/javascript">

        function toggleShowAll()
        {
            if( $('#superuser_icon').length == 0)
                return;

            var isShown = $('#superuser_icon')[0].innerText == "people";
            var url = 'setsession.php?disp_all=' + (isShown ? "-remove-" : "true");

            jQuery('#div_session_write').load(url);

            location.reload(true);

        }

        var btn = $( "#toggle_show_all" );
        if(btn.length )
        {
            btn.click(function() { toggleShowAll(); return false; } )
        }
    </script>
  </body>
</html>
