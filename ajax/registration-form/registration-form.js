jQuery(document).ready(function ($) {
    $("#custom-registration-form").submit(function () {
        var form = $(this);
        var formData = form.serialize();

        $.ajax({
            type: "post",
            url: customRegistrationAjax.ajaxurl,
            data:
                formData +
                "&action=custom_registration&nonce=" +
                customRegistrationAjax.nonce,
            success: function (response) {
                var data = $.parseJSON(response);
                if (data.success) {
                    alert("Registration successful!");
                } else {
                    alert("Error: " + data.error);
                }
            },
        });

        return false;
    });
});
