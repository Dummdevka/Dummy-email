// wait for the DOM to be loaded 
jQuery(document).ready(function($) { 
    
    $.get( ajaxurl + '?action=get_default')
    .done( function (data) {
        let template = JSON.parse( data );
        $('#subject').val(template.subject);
        $('#body').val(template.message);
    });
    // body.val( template );
    // bind 'myForm' and provide a simple callback function 
    $('#admin_email').ajaxForm({ 
        success: function (res) {
            console.log(res);
        }
    });
    //Insert replacements
    $('.replacement').click( function (e) {
        //Email body textarea
        let body = $('#body');
        //Adjust the value
        let replacement = '[' + $(this).data("value") + ']';
        //Insert the value
        body.val(body.val() + replacement);
    })
    //Insert styling
    $('.styling').click( function (e) {
        //Email body textarea
        let body = $('#body');
        //Adjust the value
        let replacement = '[' + $(this).data("value") + ']' + $(this).html() + '[/' + $(this).data("value") + ']';
        //Insert the value
        body.val(body.val() + replacement);
    })
}); 

