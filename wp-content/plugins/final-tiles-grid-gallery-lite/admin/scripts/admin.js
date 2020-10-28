jQuery(function () {
    var $ = jQuery;

    $(".fs-modal").on("click", 'input', function () {
        if($(this).val() == "2" || $(this).val() == "7") {
            $(this).parents(".reason").find('input[type="text"], .message').hide();
            $(this).parents(".reason").addClass("other-plugin").find(".reason-input").prepend("<p class='photoblocks-tip'>👉 Maybe <a href='plugin-install.php?s=photoblocks&tab=search&type=term'>PhotoBlocks</a> could be the right gallery for you!</p>");
        }
    });

    // Copy shortcode functionality
    $('.copy-ftg-shortcode').click(function (e) {
        e.preventDefault();
        var gallery_shortcode = $(this).parent().find('input');
        gallery_shortcode.focus();
        gallery_shortcode.select();
        document.execCommand("copy");
        $(this).next('span').text('Copied');
        $('.copy-ftg-shortcode').not($(this)).parent().find('span').text('Shortcode copied');

    });
});