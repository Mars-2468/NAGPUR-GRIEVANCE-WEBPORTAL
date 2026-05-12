<?php
$conn= mysqli_connect('localhost','municipalservce_ulbcsms','FUSIA8iiBjGm','municipalservce_ulbcms');
$ulbid='998';
$sql ="delete from menu_type_mst where ulbid='".$ulbid."'";
mysqli_query($conn,$sql);

$sql ="delete from custom_menus where ulbid='".$ulbid."'";
mysqli_query($conn,$sql);

$sql ="delete from custom_page_layouts where ulbid='".$ulbid."'";
mysqli_query($conn,$sql);

$sql ="delete from users where ulbid='".$ulbid."'";
mysqli_query($conn,$sql);

$sql ="delete from ulbmst where ulbid='".$ulbid."'";
mysqli_query($conn,$sql);

$sql ="delete from menuwidgets where ulbid='".$ulbid."'";
mysqli_query($conn,$sql);

$sql ="delete from image_text_widgets where ulbid='".$ulbid."'";
mysqli_query($conn,$sql);

$sql ="delete from textwidgets where ulbid='".$ulbid."'";
mysqli_query($conn,$sql);

$sql ="delete from photogallery_widgets where ulbid='".$ulbid."'";
mysqli_query($conn,$sql);

$sql ="delete from tabswidget where ulbid='".$ulbid."'";
mysqli_query($conn,$sql);

$sql ="delete from postwidget where ulbid='".$ulbid."'";
mysqli_query($conn,$sql);

$sql ="delete from pagewidget where ulbid='".$ulbid."'";
mysqli_query($conn,$sql);

$sql ="delete from pagewidget where ulbid='".$ulbid."'";
mysqli_query($conn,$sql);

$sql ="delete from layout_widget_map where ulbid='".$ulbid."'";
mysqli_query($conn,$sql);

$sql ="delete from site_main_menu where ulbid='".$ulbid."'";
mysqli_query($conn,$sql);
$sql ="delete from site_sub_menus where ulbid='".$ulbid."'";
mysqli_query($conn,$sql);

$sql ="delete from site_sub_sub_menus where ulbid='".$ulbid."'";
mysqli_query($conn,$sql);

$sql ="delete from widget_mst where ulbid='".$ulbid."'";
mysqli_query($conn,$sql);

$sql ="delete from site_main_menu where ulbid='".$ulbid."'"; 
mysqli_query($conn,$sql);





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