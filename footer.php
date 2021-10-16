<!-- Back to top  -->
<div class="backToTop">
	<button id="backIcon">
		<i class='bx bx-chevrons-up'></i>
	</button>
</div>
<!-- Cart Show -->
</div>
</main>

<footer class="page-footer font-small blue-grey lighten-5 mt-5 pt-1" style="background: rgba(240,240,240,0.4)" ;>

	<div class=" container text-center text-md-left mt-5">

		<div class="row mt-3 dark-grey-text">

			<div class="col-md-3 col-lg-4 col-xl-3 mb-4">

				<h6 class="text-uppercase font-weight-bold">Kieu Vu</h6>
				<hr class="teal accent-3 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
				<p>Dev everywhere</p>

			</div>

			<div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">

				<h6 class="text-uppercase font-weight-bold">Products</h6>
				<hr class="teal accent-3 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
				<p>
					<a class="dark-grey-text" href="#!">PHP</a>
				</p>
				<p>
					<a class="dark-grey-text" href="#!">Javascript</a>
				</p>
				<p>
					<a class="dark-grey-text" href="#!">HTML/CSS</a>
				</p>
				<p>
					<a class="dark-grey-text" href="#!">Bootstrap</a>
				</p>

			</div>
			<div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">

				<h6 class="text-uppercase font-weight-bold">Useful links</h6>
				<hr class="teal accent-3 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
				<p>
					<a class="dark-grey-text" href="#!">Facebook</a>
				</p>
				<p>
					<a class="dark-grey-text" href="#!">Zalo</a>
				</p>
				<p>
					<a class="dark-grey-text" href="#!">Portfolio</a>
				</p>
				<p>
					<a class="dark-grey-text" href="#!">Help</a>
				</p>
			</div>
			<div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">

				<h6 class="text-uppercase font-weight-bold">Contact</h6>
				<hr class="teal accent-3 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
				<p>
					<i class="bx bx-home mr-3"></i> Thach That, Ha Noi
				</p>
				<p>
					<i class="bx bx-envelope mr-3"></i> kieuvu@web.com
				</p>
				<p>
					<i class="bx bx-phone mr-3"></i> (+84) 353 795 440
				</p>
				<p>
					<i class="bx bx-phone mr-3"></i> (+84) 353 795 440
				</p>
			</div>
		</div>
	</div>
	<div class="footer-copyright text-center text-black-50 py-3">© 2021 Copyright:
		<a class="dark-grey-text" href="https://mdbootstrap.com/">KieuvuPHP.org</a>
	</div>
</footer>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script>
	let cartIcon = document.getElementById('cart-view-btn');
	let expandCartMenu = document.getElementById('cart-view-content');
	let backIcon = document.getElementById('backIcon');
	let header = document.getElementById("header__main");

	backIcon.onclick = () => {
		document.body.scrollTop = 0;
		document.documentElement.scrollTop = 0;
	}


	window.addEventListener('click', function(e) {
		if (cartIcon.contains(e.target)) {
			expandCartMenu.classList.toggle('act');
		} else {
			if (expandCartMenu.contains(e.target)) {
				e.preventDefault
			} else {
				expandCartMenu.classList.remove('act');
			}
		}
	});

	window.onscroll = () => {
		if (window.pageYOffset > header.offsetTop) {
			header.classList.add("sticky");
			backIcon.style.display = "block";
		} else {
			header.classList.remove("sticky");
			backIcon.style.display = "none";
		}
	};

	alert("- Project đang trong quá trình đập đi xây lại (phiên bản mới sử dụng thêm Ajax và một số lib, framework.)\n- Phiên bản hiện tại không còn được maintain nên sẽ có một số chức năng chưa được hoàn thiện (nhất là trên giao diện mobile).\n\n--- Kiều Vũ ---")
</script>
</body>

</html>