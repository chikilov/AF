/*
 *  Document   : base_pages_login.js
 *  Author     : pixelcave
 *  Description: Custom JS code used in Login Page
 */

var BasePagesLogin = function() {
    // Init Login Form Validation, for more examples you can check out https://github.com/jzaefferer/jquery-validation
    $.validator.addMethod('passwordck', function (value, element) {
	    return /^(?=.*[a-zA-Z])(?=.*[!@#$%^*+=-])(?=.*[0-9]).{8,}$/.test(value);
    }, lang['password_passwordck'] );
    var initValidationLogin = function(){
        jQuery('.js-validation-register').validate({
            errorClass: 'help-block text-right animated fadeInDown',
            errorElement: 'div',
            errorPlacement: function(error, e) {
                jQuery(e).parents('.form-group > div').append(error);
            },
            highlight: function(e) {
                jQuery(e).closest('.form-group').removeClass('has-error').addClass('has-error');
                jQuery(e).closest('.help-block').remove();
            },
            success: function(e) {
                jQuery(e).closest('.form-group').removeClass('has-error');
                jQuery(e).closest('.help-block').remove();
            },
            rules: {
                'register-password': {
                    required: true,
                    minlength: 8,
                    passwordck: true
                },
                'register-password2': {
                    required: true,
                    minlength: 8,
                    equalTo : '#register-password'
                }
            },
            messages: {
                'register-password': {
                    required: lang['password_comment'],
                    minlength: lang['password_minlength'],
                    passwordck: lang['password_passwordck']
                },
                'register-password2': {
                    required: lang['password_comment'],
                    minlength: lang['password_minlength'],
                    equalTo: lang['password_not_same']
                }
            }
        });
    };

    return {
        init: function () {
            // Init Login Form Validation
            initValidationLogin();
        }
    };
}();

// Initialize when page loads
jQuery(function(){ BasePagesLogin.init(); });