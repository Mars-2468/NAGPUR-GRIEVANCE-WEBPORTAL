<?php


		
	
        $conn= mysqli_connect("127.0.0.1", "municipa_csms", "ipDa6sS!cQuv", 'municipa_csms') or die(mysqli_connect_error());
        
        $sql ="select * from timer";
        $rs = mysqli_query($conn,$sql);
        $nr = mysqli_num_rows($rs);
        if($nr > 4)
        {
            $sql ="delete from timer";
            mysqli_query($conn,$sql);
            $sql ="insert into timer(number) values('2')";
            mysqli_query($conn,$sql);
        }
        else
        {
        $sql ="insert into timer(number) values('2')";
        mysqli_query($conn,$sql);
        }
        $sql ="select * from timer";
        $rs = mysqli_query($conn,$sql);
        $nr = mysqli_num_rows($rs);
        echo $nr;
	      
	    
	
?>