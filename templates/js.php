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
    footer.css('margin-top', $(document).height() - ($('#header').height() + $('#main').height()  ) - footer.height() - 27);
</script>
