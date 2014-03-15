<div class="user-profile box shadow">
    <?if ($loggedUser->s_image) { ?>
    <div class="fleft mar3 circle img-container" style="background-image:url(/images/user/thumbs/<?=$loggedUser->s_image?>)"></div>
    <? } ?>
    <div class="fleft user-desc pad1">
        <div class="uppercase bold"><?=$loggedUser->s_name ?></div>
        <div class="row">
            <div style="display:inline-block; width: 20px"><i class="icon-user"></i>
            </div><?= $loggedUser->s_email ?>
        </div>
        <div class="row">
            <div style="display:inline-block; width: 20px"><i class="icon-calendar"></i>
            </div><?= $loggedUser->dt_created ?>
        </div>
        <a class="button" href="/profile">Edit &nbsp<i class="icon-pencil"></i></a>
        <a class="button" href="/confirmation">Confirmation &nbsp<i class="icon-dollar"></i></a>
        <a class="button" href="/transaction">All transaction &nbsp<i class="icon-list"></i></a>
        <a class="button mobile" href="/logout">Logout</a>
    </div>
    <div class="clear"></div>
</div>
