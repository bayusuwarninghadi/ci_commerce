<style type="text/css">
    .picker { display: inline-block; margin-right: 30px;}
    .pickcolor {
        width: 12px;
        height: 12px;
        display: inline-block;
        cursor: pointer;
        text-align: center;
        border: 1px solid black;
        vertical-align: top;
        line-height: 12px;
    }
    .pickcolor.brown, .pickcolor.black, .pickcolor.green {color: #fff;}
</style>
<div class="picker row">
    <label>Color</label>
    <div id="color-picker" >
        <? $color = array('red','green','blue','yellow','orange','brown','white','black');
        foreach ($color as $col) { ?>
            <div class="pickcolor <?=$col?> <? if (in_array($col,$s_color)) echo 'selected'?>" style="background: <?=$col?>" data-name="s_color" data-value="<?=$col?>">&nbsp;</div>
        <?}?>
        <div class="clear"></div>
    </div>
</div>

<div class="picker row">
    <label>Size</label>
    <div id="size-picker">
        <? $size = array('S','M','L');
        foreach ($size as $col) { ?>
            <span><?=$col?></span>
            <div class="pickcolor <?if (in_array($col, $s_size)) echo 'selected';?>" data-name="s_size" style="background: #fff" data-value="<?=$col?>" >&nbsp;</div> &nbsp;
            <?}?>
        <div class="clear"></div>
    </div>
</div>
<script type="text/javascript">
    var toggleCheck = function (el) {
        if (el.hasClass('selected')) {
            var pickcolor = el.data('value');
            var name = el.data('name');
            el.html("&#10003;<input type='hidden' name='"+name+"[]' value='" + pickcolor + "' />");
        } else {
            el.html('');
        }
    }
    $(document).ready(function () {
        $('.pickcolor').each(function(ev){
            toggleCheck($(this));
        })
        $('.pickcolor').click(function (ev) {
            var this_ = $(ev.currentTarget);
            this_.toggleClass('selected');
            toggleCheck(this_);
        });
    });
</script>
