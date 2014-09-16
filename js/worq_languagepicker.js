/* test adding languages to form */
$(function () {
    $('#addlanguage').click(function (e) {
        /* test adding dropdown to form */
        /* @psa todo add correct variables to js */
        var langdat = {'none': 'Sprache','deutsch': 'Deutsch', 'france': 'Franzoesisch', 'italian': 'Italienisch'}  ;
        var writtendat = {'none': 'schriftlich','diploma1': 'Diplom1', 'diploma2': 'Diplom2', 'diploma3': 'Diplom3'}  ;
        var oraldat = {'none': 'm&uuml;ndlich','fair': 'ok', 'good': 'gut', 'mothertongue': 'Muttersprache'}  ;

        var lang = $('<select />');
        var written = $('<select />');
        var oral = $('<select />');

        for(var val in langdat)
        {
            $('<option />', {value: val, text: langdat[val]}).appendTo(lang);
        }
        for(var val in writtendat)
        {
            $('<option />', {value: val, text: writtendat[val]}).appendTo(written);
        }
        for(var val in oraldat)
        {
            $('<option />', {value: val, text: oraldat[val]}).appendTo(oral);
        }

        lang.appendTo('#languages');
        written.appendTo('#languages');
        oral.appendTo('#languages');

    });
    /* end test adding languages to form */


    /* listen to all selectboxes*/
    $('select').on('change', function() {
        //$('filterfields').each(console.log($(this).val()));
        $( "#filterfields" ).each(function( index ) {
            console.log( index + ": " + $( this ).text() );
        });

    }); // take care of select tags


    $('input').on('change keypress', function() {
        form_modified = true;
    });
});