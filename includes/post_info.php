<?php
$query = new ZigZagGuestPost();
if(!isset($_GET['post_id']) or empty($_GET['post_id'])){echo 'نوشته نامعتبر است';return false;}
$result=$query->GetPostList('row','id',intval($_GET['post_id']));if(count($result)==0) {echo 'اطلاعاتی برای این نوشته پیدا نشد';return false;}

if(isset($_GET['newaction']) and $_GET['newaction']=='delete' and isset($_GET['post_id']))
{
	$plan=$query->GetPostList('row','id',intval($_GET['post_id']));
	if($GLOBALS['wpdb']->delete($query->tblGpost, array('id' =>$plan['id']))){
	echo '<div id="message" class="updated notice is-dismissible below-h2"> <p><strong>حذف مشخصات با موفقیت انجام شد</strong></p></div>';
	wp_redirect('?page=zigzagadv-order&alert=حذف+مشخصات+با+موفقیت+انجام+شد');
	exit;
	}
}

if(isset($_POST['hide']) and $_POST['hide']=="hide")// درج وضعیت سفارش
{
	$post_type=$_POST['post_types'];
	$post_id = wp_insert_post(array (
		'post_type' => wp_strip_all_tags($post_type),
		'post_title' => wp_strip_all_tags($_POST['utitle']),
		'post_content' => wp_strip_all_tags($_POST['uinfo']),
		'post_category'=>array(intval($_POST['cat'])),
		'post_status' => 'publish',
		'post_author'=>intval($_POST['author_id']),
		'comment_status' => 'closed',   // if you prefer
		'ping_status' => 'closed',       // if you prefer
	));
	if($post_id)
	{
		$categories =get_terms(array('taxonomy' => $post_type.'-cat','hide_empty' => false,'include'=>intval($_POST['cat'])));
		wp_set_object_terms($post_id,array($categories[0]->slug), $post_type.'-cat' ); 
		//----------------
		if($GLOBALS['wpdb']->delete($query->tblGpost, array('id' =>$result['id']))){
			echo '<div id="message" class="updated notice is-dismissible below-h2"> <p><strong>حذف مشخصات با موفقیت انجام شد</strong></p></div>';
			wp_redirect('?page=zigzagpost-post&alert=ثبت+پست+جدید+با+موفقیت+انجام+شد');
			exit;
		}
		else
		echo '<div id="message" class="updated notice is-dismissible below-h2">متاسفانه ثبت اطلاعات انجام نشد
			<button type="button" class="notice-dismiss"><span class="screen-reader-text">بستن این اعلان.</span></button></div>';
	}
}
$user=get_user_by('id',$res['author_id']);
?>
<div class="wrap">
<h2>توضیحات نوشته</h2>
<form method="post">
<input type="hidden" name="hide" value="hide">
<input type="hidden" name="post_types" value="<?php echo $result[post_type];?>">
<table class="wp-list-table widefat fixed striped posts mehrtable"  cellspacing="0">
  <thead>
      <tr>
          <th width="200">کد نوشته</th>
          <th>نام و خانوادگی</th>
          <th>دسته بندی</th>
          <th>تاریخ ثبت</th>
      </tr>
  </thead>
  <tbody>
      <tr>
          <th><?php echo $result[id];?></th>
          <th><select name="author_id"><?php foreach(get_users(array('fields'=>array('id','user_login'))) as $user){echo '<option value="'.esc_html($user->id).'" '.($result['author_id']==$user->id?'selected':'').'>'.esc_html($user->user_login).'</option>';};?></select></th>
          <th><?php wp_dropdown_categories("hierarchical=1&show_option_all=".'.انتخاب کنید.&hide_empty=0'.(($result['post_type']!="" and $result['post_type']!='post')?'&taxonomy='.$result[post_type].'-cat':'').'&child_of=0&name=site[cat]');?></th>
          <th><?php echo jdate('y/m/d H:i:s',$res['created'])?></th>
      </tr>
      <tr><td colspan="1">سر تیتر آگهی: </td><th colspan="2"><input type="text" value="<?php echo wp_strip_all_tags(esc_html($result[title]));?>" name="utitle" style="width:300px;"></th></tr>
      <tr><th colspan="3">توضیحات سفارش: <textarea name="uinfo" style="width:100%;height:100px;"><?php echo nl2br($result[uinfo]);?></textarea></th></tr>
 
 </tbody>
</table><Br>
توجه:<br>
1- اطلاعات شما در دسته بندی مورد نظر ذخیره خواهد شد.<br>
2- بعد از تایید نهایی، این پست حذف خواهد شد<br>
<p class="submit">
    <input type="submit" name="submit" id="submit" class="button button-primary" value="تایید و ثبت نهایی">
    <button class="button button-warning" onclick="location.href='<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"?>&newaction=delete';return false">نادیده گرفتن و حذف پست</button>
</p>

</form>
<style>
.widefat input{padding: 5px !important;}
</style>
</div>