<footer class="bg-dark mt-5">
	<div class="container pb-5 pt-3">
		<div class="row">
			<div class="col-md-4">
				<div class="footer-card">
					<h3>Get In Touch</h3>
					<p>No dolore ipsum accusam no lorem. <br>
					123 Street, New York, USA <br>
					exampl@example.com <br>
					000 000 0000</p>
				</div>
			</div>

			<div class="col-md-4">
				<div class="footer-card">
					<h3>Important Links</h3>
					<ul>
						<li><a href="{{route('front.page','about-us')}}" title="About">About Us</a></li>
						<li><a href="{{route('front.contact')}}" title="Contact Us">Contact Us</a></li>						
						<li><a href="{{route('front.page','privacy-policy')}}" title="Privacy">Privacy Policy</a></li>
						<li><a href="{{route('front.page','terms-conditions')}}" title="Terms & Conditions">Terms & Conditions</a></li>
						<li><a href="{{route('front.page','refund-policy')}}" title="Refund Policy">Refund Policy</a></li>
					</ul>
				</div>
			</div>

			<div class="col-md-4">
				<div class="footer-card">
					<h3>My Account</h3>
					<ul>
						<li><a href="{{route('front.login')}}" title="Login">Login</a></li>
						<li><a href="{{route('front.register')}}" title="Register">Register</a></li>
						<li><a href="{{route('front.myorders')}}" title="My Orders">My Orders</a></li>						
					</ul>
				</div>
			</div>			
		</div>
	</div>
	<div class="copyright-area">
		<div class="container">
			<div class="row">
				<div class="col-12 mt-3">
					<div class="copy-right text-center">
						<p>© Copyright 2022 Amazing Shop. All Rights Reserved</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>
<script src="{{asset('public/frontend/js/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset('public/frontend/js/bootstrap.bundle.5.1.3.min.js')}}"></script>
<script src="{{asset('public/frontend/js/instantpages.5.1.0.min.js')}}"></script>
<script src="{{asset('public/frontend/js/lazyload.17.6.0.min.js')}}"></script>
<script src="{{asset('public/frontend/js/slick.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<script src="{{asset('public/frontend/js/custom.js')}}"></script>
<script>
window.onscroll = function() {myFunction()};

var navbar = document.getElementById("navbar");
var sticky = navbar.offsetTop;

function myFunction() {
  if (window.pageYOffset >= sticky) {
    navbar.classList.add("sticky")
  } else {
    navbar.classList.remove("sticky");
  }
}
$(document).ready(function () {
	setTimeout(function(){
		$(".alert").remove();
	},3000);

	$('.addToCart').on('click',function(){
		var id = $(this).data('id');
		$.ajax({
			type: "post",
			url: "{{route('front.addToCart')}}",
			data: "id="+id+"&_token={{csrf_token()}}",
			success: function (response) {
				if(response.status==true){
					Swal.fire({
					title: 'Added',
					text: response.message,
					icon: 'success',
					showCancelButton: false,
					confirmButtonColor: '#3085d6',
					confirmButtonText: 'Ok'
					}).then((result) => {
						if (result.isConfirmed) {
							window.location.href="{{route('front.cart')}}";
						}
					});
				}else{
					Swal.fire('Exist!',response.message,'warning');
				}
			}
		});
	});

	$('.whishlist').on('click',function(){
		var id = $(this).data('id');
		$.ajax({
			type: "post",
			url: "{{route('front.addWishlist')}}",
			data: "id="+id+"&_token={{csrf_token()}}",
			success: function (response) {
				if(response.status==true){
					Swal.fire({
					title: 'Added',
					text: response.message,
					icon: 'success',
					showCancelButton: false,
					confirmButtonColor: '#3085d6',
					confirmButtonText: 'Ok'
					});
				}else if(response.status==false){
					Swal.fire('Exist!',response.message,'warning');
				}else{
					window.location.href="{{route('front.login')}}";
				}
			}
		});
	});

	
});
</script>
@stack('script')
</body>
</html>