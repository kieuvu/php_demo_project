$(document).ready(function () {
  var currentCate = 'all';
  var currentBrand = 'all';
  var perPage = 10;
  var currentPage = 1;
  var targetData;

  getCategory();
  getBrand();
  getProduct(currentCate, currentBrand);


  $("#admin_getCate").on('change', function () {
    currentCate = $("#admin_getCate").val();
    getProduct(currentCate, currentBrand)
  })

  $("#admin_getBrand").on('change', function () {
    currentBrand = $("#admin_getBrand").val();
    getProduct(currentCate, currentBrand)
  })

  function getCategory() {
    $.ajax({
      type: "GET",
      url: "cate_get.php",
      success: function (response) {
        var data = JSON.parse(response);
        $("#admin_getCate").html('<option value="all">Tất cả</option>');
        $.each(data, function (key, value) {
          $("#admin_getCate").append(
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
        $("#admin_getBrand").html('<option value="all">Tất cả</option>');
        $.each(data, function (key, value) {
          $("#admin_getBrand").append(
            `
             <option value="${value.brd_slug}">${value.brd_name}</option>
          `
          )
        })
      }
    });
  }

  $(document).on('click', '.page-link.page-num', function () {
    $(".page-link.page-num").removeClass("act");
    $(this).addClass("act");
    renderData($(this).data('num'))
  })

  function getProduct(currentCate, currentBrand) {
    $.ajax({
      type: "GET",
      url: "prd_process.php",
      data: {
        "currentCategory": currentCate,
        "currentBrand": currentBrand,
      },
      success: function (response) {
        var rs = JSON.parse(response);
        $(".not_found").remove();
        $("#prbmngTable table tbody").html("");
        if (rs.length == 0) {
          $("#prbmngTable").append(`<p class="col-12 pt-2 text-center not_found">Chưa có sản phẩm</p>`);
        } else {
          $("#prbmngTable table tbody").html("");
          targetData = rs;
          renderPagination()
          renderData(currentPage)
        }
      }
    })
  }

  function renderPagination() {
    var pagiLength = Math.ceil(targetData.length / perPage);
    $("#pagi .pagination").html("")
    for (let i = 1; i <= pagiLength; i++) {
      $("#pagi .pagination").append(`
        <li class="page-item"><a data-num="${i}" class="page-link page-num" href="#">${i}</a></li>
      `)
    }
    $(".page-item .page-num:first").addClass("act");
  }

  function renderData(currentPage) {
    console.log(currentPage);
    var start = (currentPage - 1) * perPage;
    var end = start + perPage - 1;
    console.log(start, end);
    $("#prbmngTable table tbody").html("")
    for (let i = start; i <= end; i++) {
      $("#prbmngTable table tbody").append(
        `
          <tr>
            <th scope="row">${i + 1}</th>
            <td style="max-width:20%"><a class="font-weight-bold" href="./prd_detail.php?target=${targetData[i].prd_id}">${targetData[i].prd_name}</a></td>
            <td>
              <div>
                ${(targetData[i].prd_priceSaled) == 0
          ?
          ` <span class="text-danger d-block" style="font-weight:600;font-size:15px;">${vndfm.format(targetData[i].prd_price)}</span>`
          :
          ` <span class="text-danger d-block" style="font-weight:600;font-size:15px;">${vndfm.format(targetData[i].prd_priceSaled)}</span>
                  <span class="text-muted d-block" style="font-size:12px;"><del>${vndfm.format(targetData[i].prd_price)}</del></span>
                `
        }
              </div>
            </td>
            <td>${targetData[i].prd_quantity}</td>
            <td>${targetData[i].prd_cate}</td>
            <td>${targetData[i].prd_brand}</td>
            <td>
              <img class="d-block" src="./data/upload/img/${targetData[i].prd_id}" alt="" style="object-fit:cover;" width="100px" height="100px">
            </td>
            <td>
              <a href="prd_edit.php?target=${targetData[i].prd_id}" class="btn btn-info mb-1">Sửa</a>
              <button data-toggle="modal" data-target="#deleteBTN" data-id=${targetData[i].prd_id} class="btn btn-warning mt mb-1 delbtn">Xoá</button>
            </td>
          </tr>
          `
      )
    }
  }

  $(document).on('click', '.delbtn', function (e) {
    e.preventDefault();
    var id = $(this).data('id');
    console.log(id);
    $("#deleteAcceptBTN").data('id', id);
  })

  $("#deleteAcceptBTN").click(function (e) {
    e.preventDefault();
    deleteProduct($(this).data('id'));
  });

  function deleteProduct(id) {
    $.ajax({
      type: "POST",
      url: "prd_del.php",
      data: {
        "target": id,
      },
      success: function (response) {
        console.log(response);
        $('#deleteBTN').modal('hide');
        Swal.fire({
          icon: 'success',
          title: 'Xóa thành công !',
          showConfirmButton: false,
          timerProgressBar: true,
          timer: 1000
        }).then(function () {
          $("#prbmngTable").load(location.href + " #prbmngTable", function () {
            getProduct(currentCate, currentBrand);
          });
        })
      }
    });
    console.log(id);
  }
});