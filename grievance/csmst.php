<?php
$conn= mysqli_connect("127.0.0.1", "municipa_csms", "ipDa6sS!cQuv", 'municipa_csms') or die(mysqli_connect_error());
$sql ="select * from grievance_origin_mst";
$rs = mysqli_query($conn,$sql);
?>
<table border='1'>
    <?php
while($row = mysqli_fetch_assoc($rs))
{
    ?>
    <tr>
        <td><?php echo $row['grievance_origin_id']?></td>
        <td><?php echo $row['grievance_origin_desc']?></td>
        
    </tr>
    <?php
}
?>
</table>