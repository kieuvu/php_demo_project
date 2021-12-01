$(document).ready(function () {
  $("#loginSubmit").click(function (e) {
    e.preventDefault();
    var userAccount = $("#account").val();
    var userPassword = $("#password").val();

    $.ajax({
      type: "POST",
      url: "login_process.php",
      data: {
        "userAccount": userAccount,
        "userPassword": userPassword
      },
      success: function (response) {
        var data = (JSON.parse(response));
        $(".acc_err").remove()
        $(".pass_err").remove()
        if (data.err.hasOwnProperty("userAccount")) {
          $("#userAccount").after(`
            <span class="text-danger acc_err"> ${data.err.userAccount}</span>
          `)
        }
        if (data.err.hasOwnProperty("userPass")) {
          $("#userPassword").after(`
            <span class="text-danger pass_err"> ${data.err.userPass}</span>
          `)
        }
        if (data.stt == true) {
          window.history.back();
        }
      }
    });

  });
})