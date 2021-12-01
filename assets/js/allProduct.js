$(document).ready(function () {
  var targetData = null;
  var perPage = 18;
  var currentPage = 1;
  var currentBrand = 'all';
  var currentCategory = 'all';

  getData(currentBrand, currentCategory);


  $(".brand-item").click(function (e) {
    e.preventDefault();
    $(".brand-item").removeClass('active');
    $(this).addClass('active');
    currentBrand = $(this).data("slug");
    getData(currentBrand, currentCategory)
  });

  $(".cate-item").click(function (e) {
    e.preventDefault();
    $(".cate-item").removeClass('active');
    $(this).addClass('active');
    currentCategory = $(this).data("slug");
    getData(currentBrand, currentCategory)
  });

  $(document).on('click', '.page-link.page-num', function () {
    $(".page-link.page-num").removeClass("act");
    $(this).addClass("act");
    renderData($(this).data('num'))
  })

  function getData(currentBrand, currentCategory) {
    $.ajax({
      type: "GET",
      url: "prd_process.php",
      data: {
        "currentBrand": currentBrand,
        "currentCategory": currentCategory,
      },
      success: function (response) {
        var data = JSON.parse(response);
        if (data.length == 0) {
          $("#product_show .row").html(`<p class="col-12 mt-4 text-center">Chưa có sản phẩm</p>`);
        } else {
          $("#product_show .row").html("");
          targetData = data;
          renderPagination()
          renderData(currentPage)
        }
      }
    });
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
    $("#product_show .row").html("")
    for (let i = start; i <= end; i++) {
      $("#product_show .row").append(
        `
          <div class="col-6 col-lg-4 mt-3 ">
            <div class="card">
              <a class="d-block" href="./prd_detail.php?target=${targetData[i].prd_id}" style="position: relative;width: 100%;padding-top:75%;">
                <img style=" position:absolute;top: 0;left: 0;bottom: 0;right: 0;height: 100%; width: 100%;object-fit:cover;" class="card-img-top d-block img-fluid" src="./data/upload/img/${targetData[i].prd_id}" alt="prd_image">
               </a>
            <div class="card-body pl-1 pr-1 pt-0 pb-1">
              <a class="d-block " style=" height:38px;width:100%;" href="prd_detail.php?target=${targetData[i].prd_id}">
                <h6 class="card-title mt-2 mb-0 text-overfl-2line">${targetData[i].prd_name}</h6>
              </a>
            <div class=" mb-1 mt-1">
              ${(targetData[i].prd_priceSaled) == 0
          ?
          ` <span class="text-danger" style="font-weight:600;font-size:15px;">${vndfm.format(targetData[i].prd_price)}</span>`
          :
          ` <span class="text-danger" style="font-weight:600;font-size:15px;">${vndfm.format(targetData[i].prd_priceSaled)}</span>
            <span class="text-muted" style="font-size:13px;"><del>${vndfm.format(targetData[i].prd_price)}</del></span>
          `
        }
            </div>
            <div class="d-flex flex-column pt-1 ">
              <a href="prd_detail.php?target=${targetData[i].prd_id}" class="btn btn-primary">Chi tiết</a>
            </div>
              </div>
            </div>
          </div>
          `
      )
    }
  }
})