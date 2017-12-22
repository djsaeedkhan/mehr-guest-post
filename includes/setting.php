<?php
$query = new ZigZagGuestPost();

if(isset($_POST["upsetting"]))
{
	if(isset($_POST["site"])){
		update_option($query->pre."site", $_POST[ 'site' ] );
		echo '<div id="message" class="updated notice is-dismissible below-h2"> <p><strong>تنظیمات به روز رسانی شد</strong></p></div>';
	}
}
$site=get_option($query->pre."site");
?>

<div class="wrap">
<h2>تنظیمات</h2>

<form method="post">
<!---------------------------------------------------------------------------------------------------------------->
<table class="form-table">
<tr valign="top"><th scope="row"><label for="blogname">عنوان برگه درج پُست</label></th>
<td><input type="text" name="site[title]" value="<?php echo ($site['title']!=""?$site['title']:'');?>" style="width:300px;">
</td></tr></table>
<!---------------------------------------------------------------------------------------------------------------->
<table class="form-table">
<tr valign="top"><th scope="row"><label for="blogname">توضیحات برگه درج پُست</label></th>
<td><textarea name="site[info]" style="width:90%;height:120px"><?php echo ($site['info']!=""?$site['info']:'');?></textarea>
</td></tr></table>
<!---------------------------------------------------------------------------------------------------------------->
<table class="form-table">
<tr valign="top"><th scope="row"><label for="blogname">صفحه قوانین و مقررات</label></th>
<td><?php wp_dropdown_pages("hierarchical=1&show_option_all=.....انتخاب کنید....&hide_empty=0&child_of=0&name=site[f3]&selected=".$site['f3']);?>
انتخاب برگه نمایش قوانین و مقررات</td></tr></table>
<!---------------------------------------------------------------------------------------------------------------->
<table class="form-table">
<tr valign="top"><th scope="row"><label for="blogname">صفحه درج پُست</label></th>
<td><?php wp_dropdown_pages("hierarchical=2&show_option_all=".'.....انتخاب کنید....&hide_empty=0&child_of=0&name=site[f4]&selected='.$site['f4']);?>
انتخاب برگه نمایش صفحه درج پُست جدید</td></tr></table>
<!---------------------------------------------------------------------------------------------------------------->
<table class="form-table" ><tbody><tr valign="top"><th scope="row"><label for="blogname">دسته بندی درج پُست</label></th><td>
<?php 
global $wp_post_types; 
$PostType=array_keys($wp_post_types);
$ptype=array();
if(isset($site['ptype'])) foreach($site['ptype'] as $f) $ptype[]=$f;
$PostType= array_diff($PostType, array('attachment', 'revision','nav_menu_item'));
foreach($PostType as $pt){?>
<tr><td><input type="checkbox" value="<?php echo $pt;?>" <?php echo (in_array($pt,$ptype)?'checked':'');?> name="site[ptype][]"/><?php echo $pt;?></td>
<td><input type="text" name="site[ptname][<?php echo $pt;?>]"  value="<?php echo (isset($site['ptname'][$pt])?$site['ptname'][$pt]:'');?>"></td></tr>
<?php } ?></td></tr></tbody></table>
<!---------------------------------------------------------------------------------------------------------------->
<table class="form-table">
<tr valign="top"><th scope="row"><label for="blogname">ثبت پست مهمان</label></th>
<td>
<select name="site[guest]">
	<option value="0" <?php echo($site['guest']=="0"?'selected':''); ?>>همه (مهمان و اعضا)</option>
	<option value="1" <?php echo($site['guest']=="1"?'selected':''); ?>>فقط اعضا</option>
</select>
</td></tr>
</table>
<!---------------------------------------------------------------------------------------------------------------->
<table class="form-table">
<tr valign="top"><th scope="row"><label for="blogname">امکان ثبت پُست جدید</label></th>
<td>
<select name="site[enable]">
	<option value="0" <?php echo($site['enable']=="0"?'selected':''); ?>>غیرفعال</option>
	<option value="1" <?php echo($site['enable']=="1"?'selected':''); ?>>فعال</option>
</select>
</td></tr>
</table>
<!---------------------------------------------------------------------------------------------------------------->
<input type="hidden" name="upsetting" value="upsetting" />
<?php submit_button();?>
</form>
</div>