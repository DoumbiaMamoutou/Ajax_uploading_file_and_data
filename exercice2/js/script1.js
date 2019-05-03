$(function () {
    
    $('#contact-form').submit(function(e){
        e.preventDefault();
        var postdata = $('#contact-form').serialize();
       

        $.ajax({
            type: "POST",
            url: "index.php",
            data: postdata,
            dataType: "json",
            processData: false,
            contentType: false,
            success: function(result) {
                console.log(result);
                if (result) {
                    $('#contact-form').append("<p>Félicitation</p>");
                    $('#contact-form').reset();
                }
                else {
                    errors.css('color', 'red').html('<p>Erreur</p>');
                }
            }
        });
    });
})

