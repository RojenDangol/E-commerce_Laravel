<ul class="account-nav">
    <li>
        <a
            href="{{route('user.index')}}"
            class="menu-link menu-link_us-s {{ Route::is('user.index') ? 'menu-link_active' : '' }}"
            >Dashboard</a
        >
    </li>
    <li>
        <a
            href="{{route('user.orders')}}"
            class="menu-link menu-link_us-s {{ Route::is('user.orders') ? 'menu-link_active' : '' }}"
            >Orders</a
        >
    </li>
    <li>
        <a
            href="{{route('user.address')}}"
            class="menu-link menu-link_us-s {{ Route::is('user.address') ? 'menu-link_active' : '' }}"
            >Addresses</a
        >
    </li>
    <li>
        <a
            href="{{route('user.account.detail')}}"
            class="menu-link menu-link_us-s {{ Route::is('user.account.detail') ? 'menu-link_active' : '' }}"
            >Account Details</a
        >
    </li>
    <li>
        <a
            href="{{route('wishlist.index')}}"
            class="menu-link menu-link_us-s {{ Route::is('wishlist.index') ? 'menu-link_active' : '' }}"
            >Wishlist</a
        >
    </li>
    

    <li>
        <form action="{{route('logout')}}" id="logout-form" method="POST">
            @csrf
            <a
                href="{{route('logout')}}"
                class="menu-link menu-link_us-s"
                onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                >Logout</a
            >
        </form>
    </li>
</ul>