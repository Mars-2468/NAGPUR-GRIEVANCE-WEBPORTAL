<?php
$conn= mysqli_connect('localhost','municipalservce_ulbcsms','FUSIA8iiBjGm','municipalservce_ulbcms');
mysqli_query($conn,'SET character_set_results=utf8');
	mysqli_query($conn,'SET names=utf8');
	mysqli_query($conn,'SET character_set_client=utf8');
	mysqli_query($conn,'SET character_set_connection=utf8');
	mysqli_query($conn,'SET character_set_results=utf8');
	mysqli_query($conn,'SET collation_connection=utf8_general_ci');
	echo phpinfo();
/*$sql ="select * from ulbmst";
$rs = mysqli_query($conn,$sql);
while($row = mysqli_fetch_assoc($rs))
{
    $sql ="insert into ulbmst2 (distid,ulbid,ulbname,ulb_type,ulb_grade,ulbtelugu) values('".$row['distid']."','".$row['ulbid']."','".$row['ulbname']."','".$row['ulb_type']."','".$row['ulb_grade']."','".$row['ulbnametelugu']."')";
    echo $sql;
    mysqli_query($conn,$sql);
}
/*$sql ="select widget_id from widget_mst where ulbid='056'";
$rs = mysqli_query($conn,$sql);
while($row = mysqli_fetch_assoc($rs))
{
    $sql ="update  widget_mst set widget_admin_code='".$row['widget_id']."' where widget_id='".$row['widget_id']."'";
    mysqli_query($conn,$sql);
}*/
/*$sql ="select site_controller,page_id from custom_menus where ulbid='007'";
$rs = mysqli_query($conn,$sql);
while($row = mysqli_fetch_assoc($rs))
{
    $site_controller=$row['site_controller'];
    $arr=explode("/",$site_controller);
    $sql ="update custom_menus set controller='".$arr[1]."' where ulbid='007' and page_id='".$row['page_id']."'";
    mysqli_query($conn,$sql);
}*/

/*$sql ="select * from custom_menus";
$rs = mysqli_query($conn,$sql);
while($row = mysqli_fetch_assoc($rs))
{
    $sql ="update custom_menus set meta_desc ='".$row['page_title']."' where page_id='".$row['page_id']."'";
    mysqli_query($conn,$sql);
}*/



/*$conn= mysqli_connect('localhost','municipalservce_ulbcsms','FUSIA8iiBjGm','municipalservce_ulbcms');
$sql ="select * from custom_menus";
$rs = mysqli_query($conn,$sql);
while($row = mysqli_fetch_assoc($rs))
{
     $sql ="update custom_menus set hover_title ='".$row['page_name']."' where page_id='".$row['page_id']."'";
    mysqli_query($conn,$sql);
}*/


/*$sql ="select * from widget_mst where ulbid='056'";
$rs = mysqli_query($conn,$sql);
while($row = mysqli_fetch_assoc($rs))
{
    $sql ="insert into widget_permissions (
        user_id,
        widget_id,
        is_edit_permission,
        is_delete_permission,
        author
        ) values (
            'Sircilla',
            '".$row['widget_id']."',
            '1',
            '1',
            'superadmin'
            )";
            
            echo $sql;
            mysqli_query($conn,$sql);
}*/

/*$sql ="select * from layout_widget_map";
$rs = mysqli_query($conn,$sql);
while($row = mysqli_fetch_assoc($rs))
{
    $sql ="update widget_mst set widget_name='".$row['menu_name']."' where widget_id='".$row['widget_id']."'";
    mysqli_query($conn,$sql);
    
}*/

?>