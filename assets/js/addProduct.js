
var myEditor;
ClassicEditor
  .create(document.querySelector('#prd_desc'))
  .then(editor => {
    myEditor = editor;
  })
  .catch(err => {
    console.error(err.stack);
  });

$(document).ready(function () {

  // Start Function
  getCategory();
  getBrand();

  // Handler Function
  $("#add_cate").click(function (e) {
    e.preventDefault();
    addCategory();
  });

  $("#add_brd").click(function (e) {
    e.preventDefault();
    addBrand();
  });

  $(document).on('click', '.catedel', function (e) {
    e.preventDefault();
    var id = $(this).data('id');
    console.log(id);
    $("#deleteCateBTN").data('id', id);
  })

  $(document).on('click', '.brddel', function (e) {
    e.preventDefault();
    var id = $(this).data('id');
    console.log(id);
    $("#deleteBrandBTN").data('id', id);
  })


  $("#deleteBrandBTN").click(function (e) {
    deleteBrand($(this).data('id'));
  });

  $("#deleteCateBTN").click(function (e) {
    deleteCategory($(this).data('id'));
  });

  $("#add_prd").click(function (e) {
    e.preventDefault();
    addProduct();
  });

  // Init Function
  function getCategory() {
    $.ajax({
      type: "GET",
      url: "cate_get.php",
      success: function (response) {
        var data = JSON.parse(response);
        $("#add_category tbody").html('');
        $("#prd_category").html('<option value="0"></option>');
        $.each(data, function (key, value) {
          $("#add_category tbody").append(
            `
                <tr>
                  <th scope="row">${key + 1}</th>
                  <td scope="row">${value.cate_name}</td>
                  <td scope="row">
                    <button data-toggle="modal" data-target="#deleteCate" data-id="${value.id}"
                      class="btn btn-warning mt mb-1 catedel">Xoá
                    </button>
                  </td>
                </tr>
              `
          )
          $("#prd_category").append(
            `
               <option value="${value.cate_slug}">${value.cate_name}</option>
              `
          )
        })
      }
    });
  }

  function getBrand() {
    $.ajax({
      type: "GET",
      url: "brd_get.php",
      success: function (response) {
        var data = JSON.parse(response);
        $("#add_brand tbody").html("");
        $("#prd_brand").html('<option value="0"></option>');
        $.each(data, function (key, value) {
          $("#add_brand tbody").append(
            `
                <tr>
                  <th scope="row">${key + 1}</th>
                  <td scope="row">${value.brd_name}</td>
                  <td scope="row">
                    <button data-toggle="modal" data-target="#deleteBrand" data-id="${value.id}"
                      class="btn btn-warning mt mb-1 brddel">Xoá
                    </button>
                  </td>
                </tr>
             `
          )
          $("#prd_brand").append(
            `
                <option value="${value.brd_slug}">${value.brd_name}</option>
              `
          )
        })
      }
    });
  }

  function addCategory() {
    var cateValue = $("#prd_add_cate").val();

    $.ajax({
      type: "POST",
      url: "cate_add.php",
      data: {
        "cateValue": cateValue,
      },
      success: function (response) {
        var data = JSON.parse(response);
        $(".cate_notif").remove();
        if (data.err.hasOwnProperty("error")) {
          Toast.fire({
            icon: 'error',
            title: data.err.error
          })
        }
        if (data.stt == true) {
          $("#prd_add_cate").val("");
          Toast.fire({
            icon: 'success',
            title: 'Thêm thành công !'
          })
          getCategory();
        }
      }
    });
  }

  function addBrand() {
    var brandValue = $("#prd_add_brand").val();

    $.ajax({
      type: "POST",
      url: "brd_add.php",
      data: {
        "brandValue": brandValue,
      },
      success: function (response) {
        var data = JSON.parse(response);
        $(".brd_notif").remove();
        if (data.err.hasOwnProperty("error")) {
          Toast.fire({
            icon: 'error',
            title: data.err.error
          })
        }
        if (data.stt == true) {
          $("#prd_add_brand").val("");
          Toast.fire({
            icon: 'success',
            title: 'Thêm thành công !'
          })
          getBrand();
        }
      }
    });
  }

  function deleteCategory(id) {
    $.ajax({
      type: "POST",
      url: "cate_del.php",
      data: {
        "id": id,
      },
      success: function (response) {
        $('#deleteCate').modal('hide');
        Swal.fire({
          icon: 'success',
          title: 'Xóa thành công !',
          showConfirmButton: false,
          timerProgressBar: true,
          timer: 1000
        }).then(function () {
          $("#add_category").load(location.href + " #add_category", function () {
            getCategory();
          });
        })
      }
    });
  }

  function deleteBrand(id) {
    $.ajax({
      type: "POST",
      url: "brd_del.php",
      data: {
        "id": id,
      },
      success: function (response) {
        $('#deleteBrand').modal('hide');
        Swal.fire({
          icon: 'success',
          title: 'Xóa thành công !',
          showConfirmButton: false,
          timerProgressBar: true,
          timer: 1000
        }).then(function () {
          $("#add_brand").load(location.href + " #add_brand", function () {
            getBrand();
          });
        })
      }
    });
  }

  function addProduct() {
    var form = new FormData(document.getElementById("add_prdForm"));
    form.append("prd_desc", myEditor.getData());
    $.ajax({
      type: "POST",
      url: "prd_add-process.php",
      data: form,
      contentType: false,
      processData: false,
      success: function (response) {
        var data = JSON.parse(response);
        console.log(data);
        $("#brand").removeClass("text-danger")
        $("#cate").removeClass("text-danger")
        $("#desc").removeClass("text-danger")
        $("#img1").removeClass("text-danger")
        $("#img2").removeClass("text-danger")
        $("#img3").removeClass("text-danger")
        $("#img4").removeClass("text-danger")
        $("#name").removeClass("text-danger")
        $("#price").removeClass("text-danger")
        $(".prd_err").remove()
        if (data.err.hasOwnProperty('brand')) {
          $("#brand").addClass('text-danger').after(`<span class="prd_err text-danger"> ${data.err.brand}</span>`)
        }
        if (data.err.hasOwnProperty('cate')) {
          $("#cate").addClass('text-danger').after(`<span class="prd_err text-danger"> ${data.err.cate}</span>`)
        }
        if (data.err.hasOwnProperty('desc')) {
          $("#desc").addClass('text-danger').after(`<span class="prd_err text-danger"> ${data.err.desc}</span>`)
        }
        if (data.err.hasOwnProperty('img1')) {
          $("#img1").addClass('text-danger').after(`<span class="prd_err text-danger"> ${data.err.img1}</span>`)
        }
        if (data.err.hasOwnProperty('img2')) {
          $("#img2").addClass('text-danger').after(`<span class="prd_err text-danger"> ${data.err.img2}</span>`)
        }
        if (data.err.hasOwnProperty('img3')) {
          $("#img3").addClass('text-danger').after(`<span class="prd_err text-danger"> ${data.err.img3}</span>`)
        }
        if (data.err.hasOwnProperty('img4')) {
          $("#img4").addClass('text-danger').after(`<span class="prd_err text-danger"> ${data.err.img4}</span>`)
        }
        if (data.err.hasOwnProperty('name')) {
          $("#name").addClass('text-danger').after(`<span class="prd_err text-danger"> ${data.err.name}</span>`)
        }
        if (data.err.hasOwnProperty('price')) {
          $("#price").addClass('text-danger').after(`<span class="prd_err text-danger"> ${data.err.price}</span>`)
        }
        Toast.fire({
          icon: 'error',
          title: 'Thêm thất bại !'
        })
        if (data.stt === true) {
          Toast.fire({
            icon: 'success',
            title: 'Thêm thành công !'
          }).then(function () {
            location.reload();
          })
        }
      },
    });
  }
});

const imgFile1 = document.getElementById('prd_stImg');
const previewContainer1 = document.getElementById('img_preview1');
const imgPreview1 = document.getElementById("img_preview-img1");

previewContainer1.style.display = "none";

imgFile1.addEventListener('change', function () {
  const file = this.files[0];
  if (file) {
    const reader = new FileReader();
    previewContainer1.style.display = "block";
    imgPreview1.style.display = "block";
    reader.addEventListener('load', function () {
      imgPreview1.setAttribute('src', this.result);
    })
    reader.readAsDataURL(file);
  }
})

const imgFile2 = document.getElementById('prd_ndImg');
const previewContainer2 = document.getElementById('img_preview2');
const imgPreview2 = document.getElementById("img_preview-img2");

previewContainer2.style.display = "none";

imgFile2.addEventListener('change', function () {
  const file = this.files[0];
  if (file) {
    const reader = new FileReader();
    previewContainer2.style.display = "block";
    imgPreview2.style.display = "block";
    reader.addEventListener('load', function () {
      imgPreview2.setAttribute('src', this.result);
    })
    reader.readAsDataURL(file);
  }
})


const imgFile3 = document.getElementById('prd_rdImg');
const previewContainer3 = document.getElementById('img_preview3');
const imgPreview3 = document.getElementById("img_preview-img3");

previewContainer3.style.display = "none";

imgFile3.addEventListener('change', function () {
  const file = this.files[0];
  if (file) {
    const reader = new FileReader();
    previewContainer3.style.display = "block";
    imgPreview3.style.display = "block";
    reader.addEventListener('load', function () {
      imgPreview3.setAttribute('src', this.result);
    })
    reader.readAsDataURL(file);
  }
})


const imgFile4 = document.getElementById('prd_thImg');
const previewContainer4 = document.getElementById('img_preview4');
const imgPreview4 = document.getElementById("img_preview-img4");

previewContainer4.style.display = "none";

imgFile4.addEventListener('change', function () {
  const file = this.files[0];
  if (file) {
    const reader = new FileReader();
    previewContainer4.style.display = "block";
    imgPreview4.style.display = "block";
    reader.addEventListener('load', function () {
      imgPreview4.setAttribute('src', this.result);
    })
    reader.readAsDataURL(file);
  }
})

