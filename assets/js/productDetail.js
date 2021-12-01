

$(document).ready(function () {
  $("#addSubmit").click(function (e) {
    e.preventDefault();
    addToCart();
  });

  function addToCart() {
    var form = new FormData(document.getElementById("addToCartForm"));
    $.ajax({
      type: "POST",
      url: "./add_cart.php",
      data: form,
      contentType: false,
      processData: false,
      success: function (response) {
        $('#inputQuantity').modal('hide')
        Toast.fire({
          icon: 'success',
          title: 'Thêm thành công !'
        }).then(() => {
          location.reload()
        })
      }
    });
  }
});


let numUp = document.getElementById('numUp');
let numDn = document.getElementById('numDn');
let numIn = document.getElementById('numIn');

if (numUp != null && numDn != null) {
  numUp.onclick = () => {
    if (+numIn.value < +numIn.max) {
      numIn.value = +numIn.value + 1;
    }
  }
  numDn.onclick = () => {
    if (+numIn.value > +numIn.min) {
      numIn.value = +numIn.value - 1;
    }
  }
}


let mainImg = document.getElementById("bigImg");
let relImg = document.querySelectorAll("#relative_img img");
let currentSrc = mainImg.getAttribute('src');

relImg.forEach(function (value) {
  value.addEventListener('click', function () {
    currentSrc = this.getAttribute('src')
    mainImg.src = currentSrc;
    mainImg.background = `"url('${currentSrc}')"`;
  })
})
