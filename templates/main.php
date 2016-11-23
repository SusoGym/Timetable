<?php namespace timetable; ?>
<!DOCTYPE html>
<html>
<?php
    include "header.php";
?>
<body class="grey lighten-2">
<!-- HEADER -->
<header class="navbar" id="header">
    <nav>
        <div class="nav-wrapper red">
            <a class="brand-logo center">Vertretungsplan</a>
            <ul id="nav-mobile" class="right" style="white-space:nowrap;">
                <li>
                    <a href="?type=logout" title="Logout">
                        <i class="material-icons right">power_settings_new</i>
                    </a>
                </li>
            </ul>
    </nav>
</header>
<!-- BODY -->
<div class="container" id="main">
    <?php
        /**
         * @var string $date
         * @var  Lesson $lesson
         */
        foreach (View::getInstance()->getDataForView()['lessons'] as $date => $lessons)
        {
            $_GET['lessons']['currentLessons'] = $lessons;
            ?>
            <div class="hoverable card white">
                <div class="card-content">
                        <span class="card-title red-text"><i
                                class="material-icons">date_range</i>&nbsp;&nbsp;<?php echo $date; ?>:</span>
                    <?php include "main_table.php"; ?>
                </div>
            </div>
        <?php } ?>
</div>
<!-- FOOTER -->
<footer id="footer" class="page-footer grey darken-3">
    <div class="footer-copyright">
        <div class="container">
            © <?php echo date("Y"); ?> Jasper Krauter, Kai Berszin
            <a class="grey-text text-lighten-4 right" href="http://intranet.suso.schulen.konstanz.de/gpuntis/">Zur
                offiziellen Version</a>
        </div>
    </div>
</footer>

<?php include "js.php"; ?>

</body>
</html>
