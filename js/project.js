var Xtreme_startup_calls = Xtreme_startup_calls || [];
Xtreme_startup_calls.push(function () {
    //
    list_length();
    //
    $('#navi_toggler').click(function () {
        $('#navigation ul').toggleClass('active');
    });
    //
    function plain_to_hashes() {
        var input = $.trim($('.plain_to_hashes .input').val());
        if (input.length) {
            $.post('ajax/encode.php', {
                secret: '7sd8f32jkMA!',
                input: input
            }, function (response) {
                if (response.match(/\{.*\}/)) {
                    var hashes = JSON.parse(response);
                    console.log(hashes);
                    $$.foreach(['base64', 'md5', 'sha1'], function (hashmethod) {
                        $('.plain_to_hashes [data-output="plain-to-' + hashmethod + '"] span').text(hashes[hashmethod]);
                    });
                }
            });
        }
    }
    $('.plain_to_hashes .input').keyup(function (e) {
        if (e.originalEvent.keyCode == 13) {
            plain_to_hashes();
        }
    });
    $('.plain_to_hashes .submit').click(plain_to_hashes);
    //
    function hash_to_plain() {
        var input = $.trim($('.hash_to_plain .input').val());
        if (input.length) {
            $.post('ajax/decode.php', {
                secret: '7sd8f32jkMA!',
                input: input
            }, function (response) {
                if (response.match(/\{.*\}/)) {
                    var hash = JSON.parse(response);
                    $('.hash_to_plain [data-output="decrypted"] div').text(hash.algorithm);
                    $('.hash_to_plain [data-output="decrypted"] span').text(hash.plain);
                } else {
                    $('.hash_to_plain [data-output="decrypted"] div').text('Result');
                    $('.hash_to_plain [data-output="decrypted"] span').text('Could not decrypt it.');
                }
            });
        }
    }
    $('.hash_to_plain .input').keyup(function (e) {
        if (e.originalEvent.keyCode == 13) {
            hash_to_plain();
        }
    });
    $('.hash_to_plain .submit').click(hash_to_plain);
});
