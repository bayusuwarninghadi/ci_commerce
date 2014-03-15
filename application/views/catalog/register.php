<div class="content container shadow white">
    <div class="pad1">

        <div class="fleft pad1">
            <img src="/images/register.jpg" alt="" style="margin-top: 17px;">
        </div>
        <form action="/register" class="fleft" id="loginForm" method="post" autocomplete="off">
            <h1>Register</h1>
            <input type="text" name="s_name" placeholder="Full Name" value="<?=$s_name?>">
            <input type="text" name="s_email" placeholder="Email" value="<?=$s_email?>">
            <input type="password" name="s_password" placeholder="Password">
            <input type="text" name="s_phone" class="numeric" placeholder="Phone Number ex : 08123456789" value="<?=$s_phone?>">
            <textarea name="s_address" placeholder="Address"><?=$s_address?></textarea>
            <input type="text" name="s_bank" placeholder="Bank Account eg: BCA" value="<?=$s_bank?>">
            <input type="text" name="s_bank_name" placeholder="Bank Account Name eg : Tono Budiarto" value="<?=$s_bank_name?>">
            <input type="text" name="i_rek" class="numeric" placeholder="Bank Account Number" value="<?=$i_rek?>">
            <div>
                <input name="agreement" type="checkbox" checked="checked" value="1">I am agree with <a href="/page/29">privacy policy</a> and <a href="/page/30">term
                of service</a></div>
            <input type="submit" value="Sign Up">

            <div class="clear"></div>
        </form>
        <div class="clear"></div>
    </div>
</div>
