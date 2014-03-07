<div class="admin-menu fright">
    <div class="menu">
        <a class="link transition" href="/admin" title="dashboard">
            <div class="icon-dashboard"></div>
            <div class="smaller">Dashboard</div>
        </a>
    </div>
    <div class="menu">
        <div class="link">
            <div class="icon-cloud"></div>
            <div class="smaller">Catalog</div>
        </div>
        <div class="sub">
            <div class="menu">
                <a class="link transition" href="/admin/category" title="Category">
                    <div class="icon-list-alt"></div>
                    <div class="smaller">Category</div>
                </a>
            </div>
            <div class="menu">
                <a class="link transition" href="/admin/product" title="product">
                    <div class="icon-pencil"></div>
                    <div class="smaller">Product</div>
                </a>
            </div>
            <div class="menu">
                <a class="link transition" href="/admin/slider" title="slider">
                    <div class="icon-picture"></div>
                    <div class="smaller">Slider</div>
                </a>
            </div>
            <div class="menu">
                <a class="link transition" href="/admin/article" title="article">
                    <div class="icon-flag"></div>
                    <div class="smaller">Article</div>
                </a>
            </div>
            <div class="menu">
                <a class="link transition" href="/admin/pages" title="Pages">
                    <div class="icon-edit-sign"></div>
                    <div class="smaller">Pages</div>
                </a>
            </div>
        </div>
    </div>
    <div class="menu">
        <a class="link transition" href="/admin/checkout" title="checkout">
            <div class="icon-dollar"></div>
            <div class="smaller">Checkout</div>
        </a>
    </div>
    <div class="menu">
        <a class="link transition" href="/admin/email" title="Email">
            <div class="icon-envelope"></div>
            <div class="smaller">Email</div>
        </a>
    </div>
    <div class="menu">
        <a class="link transition" href="/admin/user" title="User">
            <div class="icon-user-md"></div>
            <div class="smaller">Users</div>
        </a>
    </div>
    <?  if ($isAdminLogin == 1) { ?>
    <div class="menu">
        <a class="link transition" href="/admin/admin" title="Admin">
            <div class="icon-user"></div>
            <div class="smaller">Admin</div>
        </a>
    </div>
    <div class="menu">
        <a class="link transition" href="/admin/setting" title="setting">
            <div class="icon-gear"></div>
            <div class="smaller">Setting</div>
        </a>
    </div>
    <? } ?>
    <div class="menu">
        <a class="link transition" href="/admin/logout" title="Logout">
            <div class="icon-signout"></div>
            <div class="smaller">Signout</div>
        </a>
    </div>

</div>