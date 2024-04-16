<ul id="account-panel" class="nav nav-pills flex-column" >
    <li class="nav-item {{($title=='my-account')?'active':''}}">
        <a href="{{route('front.account')}}"  class="nav-link font-weight-bold" role="tab" aria-controls="tab-login" aria-expanded="false"><i class="fas fa-user-alt"></i> My Profile</a>
    </li>
    <li class="nav-item {{($title=='my-address')?'active':''}}">
        <a href="{{route('front.myaddress')}}"  class="nav-link font-weight-bold" role="tab" aria-controls="tab-login" aria-expanded="false"><i class="fas fa-map-marker-alt"></i>Shipping Address</a>
    </li>
    <li class="nav-item {{($title=='my-order')?'active':''}}">
        <a href="{{route('front.myorders')}}"  class="nav-link font-weight-bold" role="tab" aria-controls="tab-register" aria-expanded="false"><i class="fas fa-shopping-bag"></i>My Orders</a>
    </li>
    <li class="nav-item {{($title=='my-wishlist')?'active':''}}">
        <a href="{{route('front.wishlist')}}"  class="nav-link font-weight-bold" role="tab" aria-controls="tab-register" aria-expanded="false"><i class="fas fa-heart"></i> Wishlist</a>
    </li>
    <li class="nav-item {{($title=='change-password')?'active':''}}">
        <a href="{{route('front.changePassword')}}"  class="nav-link font-weight-bold" role="tab" aria-controls="tab-register" aria-expanded="false"><i class="fas fa-lock"></i> Change Password</a>
    </li>
    <li class="nav-item">
        <a href="{{route('front.logout')}}" class="nav-link font-weight-bold" role="tab" aria-controls="tab-register" aria-expanded="false"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </li>
</ul>