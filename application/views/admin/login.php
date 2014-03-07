<style type="text/css">
    #loginForm {width: 250px;  border-top: 3px solid red; }
    #loginForm input[type="text"],#loginForm input[type="password"] { width: 250px}
</style>
<div class="content">
    <div style="width: 250px; margin: 100px auto">
        <form action="/admin/login" class="shadow pad1 box" id="loginForm" method="post">
            <h2 class="logo">FLOWLACE ADMIN</h2>
            <input type="text" name="s_email" placeholder="Username">
            <input type="password" name="s_password" placeholder="Password">
            <input type="submit" value="Sign In">
            <div class="clear"></div>
        </form>
    </div>
</div>