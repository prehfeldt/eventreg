$(function() {
    $('#preview_link').click(function() {
        $('#form_description').css('display', 'none');
        $('#form_description_preview').css('display', 'block');

        $('#preview_link').css('display', 'none');
        $('#preview_back').css('display', 'inline');

        $.ajax({
            type: "POST",
            url: "/markdown/preview.json",
            data: { description: $('#form_description').val() }
        }).done(function( result ) {
            $('#form_description_preview').html(result.description);
        });
    });

    $('#preview_back').click(function() {
        $('#form_description_preview').css('display', 'none');
        $('#form_description').css('display', 'block');

        $('#preview_back').css('display', 'none');
        $('#preview_link').css('display', 'inline');
    });
});