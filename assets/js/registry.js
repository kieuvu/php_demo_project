$(document).ready(function () {
  $("#reg_submit").click(function (e) {
    e.preventDefault();
    var userAccount = $("#account").val();
    var userPass = $("#password").val();
    var userRePass = $("#rePass").val();
    $.ajax({
      type: "POST",
      url: "registry_process.php",
      data: {
        "userAccount": userAccount,
        "userPass": userPass,
        "userRePass": userRePass,
      },
      success: function (response) {
        var data = JSON.parse(response);
        $('.acc_err').remove();
        $('.pass_err').remove();
        if (data.err.hasOwnProperty('userAccount')) {
          $("#userAccount").after(`
            <span class="text-danger acc_err"> ${data.err.userAccount}</span>
          `)
        }
        if (data.err.hasOwnProperty('userPass')) {
          $("#userPassword").after(`
            <span class="text-danger pass_err"> ${data.err.userPass}</span>
          `)
        }
        if (data.stt == true) {
          $("#account").val("");
          $("#password").val("");
          $("#rePass").val("");
          $('#regSucc').modal('show');
        }
      }
    });
  });
})