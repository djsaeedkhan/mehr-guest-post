<?php
$query = new ZigZagGuestPost();
$result=$query->GetPostList();

if(isset($_GET['alert']))
echo '<div id="message" class="updated notice is-dismissible below-h2"><p><strong>'.$_GET['alert'].'</strong></p></div>';
?>
<div class="wrap">
<h2>مدیریت پست ها</h2>
<table class="wp-list-table widefat fixed striped posts mehrtable"  cellspacing="0">
  <thead>
      <tr>
          <th width="50">ردیف</th>
          <th>عنوان پست</th>
          <th>نام و نام خانوادگی</th>
          <th>دسته بندی</th>
          <th>تاریخ ثبت</th>
      </tr>
  </thead>
  <tbody>
  <?php $i=0;foreach($result as $res):$i+=1;$user=get_user_by('id',$res['author_id']);?>
  <tr>
      <th><?php echo $i;?></th>
      <th><?php echo $res['title'];?>
      <div class="row-actions"><span class="edit">
      <a href="?page=zigzagpost-post&post_id=<?php echo $res['id'];?>">نمایش</a> / 
      <a href="?page=zigzagpost-post&newaction=delete&post_id=<?php echo $res['id'];?>" onclick="return confirm('برای حذف این گزینه مطمین هستید؟');">حذف</a>
      </div>
      </th>
      <th><?php echo $user->first_name . ' ' . $user->last_name." ($user->user_login) ";?></th>
      <th><?php echo $res['post_type'];?></th>
      <th><?php echo jdate('y/m/d H:i:s',$res['created']);?></th>
  </tr>
  <?php endforeach;?>
  </tbody>
</table>
</div>