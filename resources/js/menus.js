import $ from "jquery";

// header auth menu dropdown
$(document).click(function (e) {
    if ($("#user-menu-btn").is(e.target)) {
        $("#user-menu-dropdown").toggle();
    } else if (
        !$("#user-menu-dropdown").is(e.target) &&
        $("#user-menu-dropdown").has(e.target).length === 0
    ) {
        $("#user-menu-dropdown").hide();
    }
});

//auth menu dropdown switch
$("#switch-menu-auth").click(function (e) {
    if (e.which === 1) {
        if ($("#tosignup").is(e.target)) {
            $("#tosignup, #signin, #request-pass").hide();
            $("#tosignin, #signup, #toreqpass").show();

            $("#tosignin").css("display", "block");
        }
        if ($("#tosignin").is(e.target)) {
            $("#tosignin, #signup, #request-pass").hide();
            $("#tosignup, #signin, #toreqpass").show();
        }
        if ($("#toreqpass").is(e.target)) {
            $("#signin, #signup, #toreqpass").hide();
            $("#request-pass, #tosignup, #tosignin").show();

            $("#tosignin").css("display", "block");
        }
    }
});
