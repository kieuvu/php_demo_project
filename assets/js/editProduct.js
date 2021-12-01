
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
  $("#edit-submit").click(function (e) {
    e.preventDefault();
    editProduct();
  });

  function editProduct() {
    var form = new FormData(document.getElementById("edit_prdForm"));
    form.append("prd_desc", myEditor.getData());
    $.ajax({
      type: "POST",
      url: "prd_edit-process.php",
      data: form,
      contentType: false,
      processData: false,
      success: function (response) {
        var data = JSON.parse(response);
        console.log(data);
        $("#brand").removeClass("text-danger")
        $("#category").removeClass("text-danger")
        $("#desc").removeClass("text-danger")
        $("#name").removeClass("text-danger")
        $("#price").removeClass("text-danger")
        $(".prd_err").remove()
        if (data.err.hasOwnProperty('brand')) {
          $("#brand").addClass('text-danger').after(`<span class="prd_err text-danger"> ${data.err.brand}</span>`)
        }
        if (data.err.hasOwnProperty('cate')) {
          $("#category").addClass('text-danger').after(`<span class="prd_err text-danger"> ${data.err.cate}</span>`)
        }
        if (data.err.hasOwnProperty('desc')) {
          $("#desc").addClass('text-danger').after(`<span class="prd_err text-danger"> ${data.err.desc}</span>`)
        }
        if (data.err.hasOwnProperty('name')) {
          $("#name").addClass('text-danger').after(`<span class="prd_err text-danger"> ${data.err.name}</span>`)
        }
        if (data.err.hasOwnProperty('price')) {
          $("#price").addClass('text-danger').after(`<span class="prd_err text-danger"> ${data.err.price}</span>`)
        }
        Toast.fire({
          icon: 'error',
          title: 'Sửa thất bại !'
        })
        if (data.stt === true) {
          Toast.fire({
            icon: 'success',
            title: 'Sửa thành công !'
          }).then(function () {
            window.location.replace("prd_manage.php");
          })
        }
      }
    });
  }
});

const imgFile1 = document.getElementById('prd_stImg');
const previewContainer1 = document.getElementById('img_preview1');
const imgPreview1 = document.getElementById("img_preview-img1");


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

