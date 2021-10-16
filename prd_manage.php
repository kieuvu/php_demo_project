<?php
include("./header.php");

if ($_SESSION['loginData']['userPerm'] != 1) {
  echo "<script>window.top.location='index.php';</script>";
}

include("./function/sqlconn.php");
?>


<div class="container">
  <div class="text-right mt-3 mb-3">
    <u><a href="./prd-add.php" class="">Thêm sản phẩm</a></a></u>
  </div>
  <table class="table table-striped">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Tên</th>
        <th scope="col">Giá</th>
        <th scope="col">Số lượng</th>
        <th scope="col">Loại</th>
        <th scope="col">Thương hiệu</th>
        <th scope="col">Ảnh</th>
        <th scope="col">Hành động</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $query = "SELECT * FROM products";
      $result = mysqli_query($conn, $query);
      if (mysqli_num_rows($result) > 0) {
        $i = 1;
        while ($row = mysqli_fetch_assoc($result)) {
      ?>
          <tr>
            <th scope="row"><?php echo $i ?></th>
            <td style="max-width:20%"><?php echo $row['prd_name'] ?></td>
            <td>
              <div>
                <?php
                if ($row['prd_priceSaled'] == 0) {
                ?>
                  <span class="text-danger d-block" style="font-weight:600;font-size:15px;">₫<?php echo number_format($row["prd_price"], '0', '3', '.') ?></span>
                <?php
                } else {
                ?>
                  <span class="text-danger d-block" style="font-weight:600;font-size:15px;">₫<?php echo number_format($row["prd_priceSaled"], '0', '3', '.') ?></span>
                  <span class="text-muted d-block" style="font-size:12px;"><del>₫<?php echo number_format($row["prd_price"], '0', '3', '.') ?></del></span>
                <?php
                }
                ?>
              </div>
            </td>
            <td><?php echo $row['prd_quantity'] ?></td>
            <td><?php echo $row['prd_cate'] ?></td>
            <td><?php echo $row['prd_brand'] ?></td>
            <td><img class="d-block" src="./data/upload/img/<?php echo $row["prd_id"] ?>" alt="" style="object-fit:cover;" width="100px" height="100px"></td>
            <td>
              <a href="prd_edit.php?target=<?php echo $row['prd_id'] ?>" class=" btn btn-info mb-1">Sửa</a>
              <a data-toggle="modal" data-target="#deleteBTN" href="" data-id=<?php echo $row['prd_id'] ?> class="btn btn-warning mt mb-1">Xoá</a>
            </td>
          </tr>
      <?php
          $i++;
        }
      }
      ?>
    </tbody>
  </table>
</div>

<div class="modal fade" id="deleteBTN" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cảnh báo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Có chắc chắn muốn xoá
      </div>
      <div class="modal-footer">
        <a id="deleteAcceptBTN" type="button" class="btn btn-danger text-white">Xoá</a>
        <button type="button" class="btn btn-primary" data-dismiss="modal">Huỷ</button>
      </div>
    </div>
  </div>
</div>
</div>
<script>
  document.addEventListener('DOMContentLoaded', function() {

    var id;
    var deleteAcceptBTN = document.getElementById('deleteAcceptBTN');

    $('#deleteBTN').on('show.bs.modal', function(event) {
      var button = $(event.relatedTarget);
      id = button.data('id');
      deleteAcceptBTN.href = "prd_del.php?target=" + id;
    });
  });
</script>

<?php
include("./footer.php");
?>