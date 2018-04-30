var Xtreme_startup_calls = Xtreme_startup_calls || [];
Xtreme_startup_calls.push(function() {
    //
    list_length();
    //
    $('#navi_toggler').click(function() {
        $('#navigation ul').toggleClass('active');
    });
    //
    function plain_to_hashes() {
        var input = $.trim($('.plain_to_hashes .input').val());
        if(input.length) {
            $.post('ajax/encode.php', {
                secret: '7sd8f32jkMA!',
                input: input
            }, function(response) {
                
            });
        }
    }
    $('.plain_to_hashes .input').keyup(function(e) {
        if(e.originalEvent.keyCode == 13) {
            plain_to_hashes();
        }
    });
    $('.plain_to_hashes .submit').click(plain_to_hashes);
});
