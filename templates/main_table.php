<?php namespace timetable;
    $lessons = $_GET['lessons']['currentLessons'];
?>
<!-- TABLE FOR TABLET AND UP -->
<table class="striped hide-on-small-only">
    <thead>
    <tr>
        <th>Stunde</th>
        <th>Lehrer</th>
        <th>Fach</th>
        <th>Raum</th>
        <th>statt Lehrer:</th>
        <th>statt Fach:</th>
        <th>Kommentar</th>
    </tr>
    </thead>
    <tbody>
    <?php /** @var Lesson $lesson */
        foreach ($lessons as $lesson)
        { ?>
            <tr>
                <td><?php echo $lesson->getHour() ?></td>
                <td><?php echo $lesson->getSubTeacher() ?></td>
                <td><?php echo $lesson->getSubSubject() ?></td>
                <td><?php echo $lesson->getSubRoom() ?></td>
                <td><?php echo $lesson->getCancelledTeacher() ?></td>
                <td><?php echo $lesson->getCancelledSubject() ?></td>
                <td><?php echo $lesson->getComment() ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<!-- TABLE FOR SMALL DISPLAYS -->
<div class="collection hide-on-med-and-up">
<?php /** @var Lesson $lesson */
    foreach ($lessons as $lesson) { ?>
        <div class="collection-item">
          <div class="row hide-on-med-and-up" style="margin-bottom: 0px;">
              <div class="col s3 center-align"><span class="truncate"><?php echo $lesson->getHour() ?></span></div>
              <div class="col s3 center-align"><span class="truncate"><?php echo $lesson->getCancelledSubject() ?></span>
              </div>
              <div class="col s3 center-align"><span class="truncate"><?php echo $lesson->getSubTeacher() ?></span></div>
              <div class="col s3 center-align"><span class="truncate"><?php echo $lesson->getSubRoom() ?></span></div>
              <div class="col s12 center-align"><span class="truncate"><?php echo $lesson->getComment() ?></span></div>
          </div>
        </div>

    <?php } ?>
  </div>
