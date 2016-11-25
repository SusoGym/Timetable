<?php namespace timetable; ?>
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/js/materialize.min.js"></script>
<script type="application/javascript">

    function updateFontSize(obj) {
        var mq = window.matchMedia("only screen and (max-width: 600px)");
        if (!mq.matches)
            return;

        var size = obj.text().length;

        if (size <= 9)
            return;
        var fSize = 23 - size;
        obj.css("font-size", fSize + "px");
    }

    $('.bestfit').each(function () {
        updateFontSize($(this))
    });

</script>
<script type="application/javascript">
    var footer = $('#footer');
    var magic = 27;
    if(window.matchMedia("only screen and (min-width: 601px)").matches)
        magic = 28;

    footer.css('margin-top', $(document).height() - ($('#header').height() + $('#main').height()  ) - footer.height() - magic);
</script>
<script type="application/javascript">
    function displayPhpToast() {
        <?php
        $data = View::getInstance()->getDataForView();
        if (isset($data['notifications']))
        {
            foreach ($data['notifications'] as $notification)
            {
                if (!isset($notification['message']) || !isset($notification['duration']))
                    continue;

                $msg = $notification['message'];
                $duration = $notification['duration'];

                echo "Materialize.toast('$msg', $duration);";

            }
        }
        ?>
    }

    $(document).ready(function () {
        displayPhpToast();
    });
</script>