<?php
$query = new ZigZagGuestPost();
$setting=$query->setting;
global $wpdb;
/*----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
if(isset($_POST['hide']) and $_POST['hide']!=''){
	$error='';
	if($_POST['p_title']!='') $title=esc_html(sanitize_text_field($_POST['p_title']));else $error.='فیلد عنوان نباید خالی باشد<br>';
	if(strlen($title)>40) $error.='فیلد عنوان نمی تواند بیشتر از 40 حرف باشد<br>';
	
	if($_POST['p_cat']!=''){$cat=esc_html(sanitize_text_field($_POST['p_cat']));}else $error.='فیلد دسته بندی نباید خالی باشد<br>';
	if(strlen($cat)>10) $error.='فیلد دسته بندی نمی تواند بیشتر از 10 حرف باشد<br>';
	
	if($_POST['p_info']!='')$info=esc_textarea($_POST['p_info']);
	
	$author_id = sanitize_text_field($_POST['ffftitle']);

	if(strlen($error)==0)
	{
		$current_user = wp_get_current_user();
		//Save Order Data	
		if($wpdb->insert($query->tblGpost, 
			array( 'title' =>$title, 
			'post_type' =>$cat, 
			'author_id' =>($current_user->ID!=''?$current_user->ID:''), 
			'uinfo' =>$info,
			'created' => current_time('mysql')) 
		))
		echo '<div class="notes"><i class="fa fa-close"></i><span>ثبت اطلاعات با موفقیت انجام شد.</span><div class="clear"></div></div>';
	}
	else
	echo '<div class="notes"><i class="fa fa-close"></i><span>'.$error.'</span><div class="clear"></div></div>';
/*-------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
}
?>
<form action="<?php the_permalink($setting['f4']);?>" method="post">
<input type="hidden" name="hide" value="hide">
<div class="free-s text-center"  style="box-shadow: none !important;">
    <div class="head">
        <span class="k1"><?php echo ($setting['title']!=""?$setting['title']:'');?></span>
        <span class="k2"><?php echo ($setting['info']!=""?$setting['info']:'');?></span>
    </div><div class="clear"></div>

    <div class="col-sm-6 rast pull-right">
        <input type="text" placeholder="عنوان پست" name="p_title" required>
        <div class="form-group">
            <select name="p_cat" class="form-control" id="sel1" style="height:inherit">
            <?php if(count($setting['ptype'])):foreach($setting['ptype'] as $pt):echo '<option value="'.$pt.'">'.$setting['ptname'][$pt].'</option>';endforeach;endif;?>
            </select>
        </div>
        <textarea name="p_info"></textarea>
        <span class="sharayet">با کلیک روی دکمه ثبت، موافقت خود را با <a href="<?php the_permalink($setting['f3']);?>">قوانین و شرایط استفاده زیگزاگ</a> اعلام میکنید.</span>
        <input type="submit" class="sabt2" value="ارسال مطلب "><div class="clear"></div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
</form>
<?php ?>