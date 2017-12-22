<div class="wrap">
<?php
$query = new ZigZagAdv();
if(isset($_GET['action']) and $_GET['action']=='delete' and isset($_GET['id']))
{
	$res=$query->GetPlanList('Exists','id',intval($_GET['id']));
	if(count($res)==0){ echo '<div id="message" class="updated notice is-dismissible below-h2"> <p><strong>مشخصاتی برای حذف پیدا نشد</strong></p></div>';}
	else
	{
		if($GLOBALS['wpdb']->delete($query->tblPlanList, array('id' =>$res['id']))):
			echo '<div id="message" class="updated notice is-dismissible below-h2"> <p><strong>حذف مشخصات با موفقیت انجام شد</strong></p></div>';
			wp_safe_redirect('?page=zigzagadv-plan');exit;
		endif;
	}
}
$result=$query->GetPlanList('all');
?>
<h2>مدیریت پلان ها
<a href="?page=zigzagadv-plan&action=new" class="page-title-action">ثبت گزینه جدید</a></h2>
<table class="wp-list-table widefat fixed striped posts mehrtable" cellspacing="0">
    <thead>
        <tr>
            <th width="60">ردیف</th>
            <th>نام</th>
            <th>آدرس برگه</th>
			<th width="160">تاریخ ثبت</th>
        </tr>
    </thead>
    
    <tbody id="the-list">
    <?php $i=0;foreach($result as $res):$i+=1;?>
        <tr>
            <th><?php echo $i;?></th>
            <th><?php echo $res[name];?>
            <div class="row-actions"><span class="edit">
            <a href="?page=zigzagadv-plan&action=edit&id=<?php echo $res[id];?>">ویرایش</a> / 
            <a href="?page=zigzagadv-plan&action=delete&id=<?php echo $res[id];?>" onclick="return confirm('برای حذف این گزینه مطمین هستید؟');">حذف</a></div></th>
            <th><a href="<?php echo the_permalink($res['url']);?>" target="_blank"><?php echo get_the_title($res['url']);?></a></th>
            <th><?php echo @jdate('y/m/d H:i:s',$res['created']);?></th>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>
</div>

<?php if(isset($_GET['action']) and $_GET['action']=='new'):
if(isset($_POST['hide']) and $_POST['hide']=="hide")
{
	if($GLOBALS['wpdb']->insert($query->tblPlanList, array('name' =>sanitize_text_field($_POST['name']), 'url' =>intval($_POST['url']), 'created' => current_time('mysql'))))
	{wp_safe_redirect('?page=zigzagadv-plan');exit;}
}
?><div class="wrap">
<h2>ثبت پلان جدید</h2>
<form action="" method="post"><input type="hidden" name="hide" value="hide"><input type="hidden" name="list_id" value="<?php echo $result2['list_id'];?>">
<table class="wp-list-table widefat fixed striped posts mehrtable"  cellspacing="0">
  <tbody>
  <tr><td width="150">نام پلان</td><td><input type="text" name="name"></td></tr>
  <tr><td>لینک برگه توضیحات</td><td><?php wp_dropdown_pages("hierarchical=1&show_option_all=.....انتخاب کنید....&hide_empty=0&child_of=0&name=url");?></td></tr>
  </tbody>
</table>
<br><input type="submit" value="ثبت جدید" class="button" id="button">
</form>
<?php  //--------------------------------------------------------------------------------------------------------
elseif(isset($_GET['action']) and $_GET['action']=='edit'):
$result=$query->GetPlanList('row','id',intval($_GET['id']));
if(isset($_POST['hide']) and $_POST['hide']=="hide")
{
	if($GLOBALS['wpdb']->update($query->tblPlanList,
	array('name' =>sanitize_text_field($_POST['name']),'url' =>sanitize_text_field($_POST['url'])),
	array('id'=>sanitize_text_field($_POST['id']))))
	{
		wp_safe_redirect('?page=zigzagadv-plan');exit;
	}
}
?><div class="wrap">
<h2>به روز رسانی</h2>
<form action="" method="post"><input type="hidden" name="hide" value="hide">
<input type="hidden" name="id" value="<?php echo $result['id'];?>">
<table class="wp-list-table widefat fixed striped posts mehrtable"  cellspacing="0">
  <tbody>
  <tr><td width="150">نام</td><td><input type="text" name="name" value="<?php echo $result['name'];?>"></td></tr>
  <tr><td>آدرس</td><td><?php wp_dropdown_pages("hierarchical=1&show_option_all=.....انتخاب کنید....&hide_empty=0&child_of=0&name=url&selected=".$result['url']);?></td></tr>
  </tbody>
</table>
<br><input type="submit" value="ارسال" class="button" id="button">
</form>
<?php endif;?>