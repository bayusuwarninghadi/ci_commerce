<div class="content container shadow white">
    <div class="pad1">
        <div class="fleft banner right" style="width: 50%">
            <div class="pad1">
                <h1>Contact Us</h1>
            </div>
            <hr>
            <div class="pad1">
                <?=$store->s_body?>
            </div>
        </div>
        <form action="/contact" class="fleft" id="loginForm" method="post" style="width: 40%">
            <div class="field">
                <div class="label">Name</div>
                <input type="text" value="<?=@$loggedUser->s_name?>" name="s_name">
            </div>
            <div class="field">
                <div class="label">Email</div>
                <input type="text" value="<?=@$loggedUser->s_email?>" name="s_email">
            </div>
            <div class="field">
                <div class="label">Message</div>
                <textarea class="ckeditor" name="s_message"></textarea>
            </div>
            <input type="submit" value="Send">

            <div class="clear"></div>
        </form>
        <div class="clear"></div>
    </div>
</div>