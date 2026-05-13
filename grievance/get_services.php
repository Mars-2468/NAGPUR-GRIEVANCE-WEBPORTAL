<?php

class get_services

{

	public $services;

	public $services1;

	function __construct($uid)

	{

		require_once('connection.php');

		$conn = getconnection();

		$sql2 = "select service_id,service_name,service_type,main_icon,sub_icon from services where service_id in (select service_id from users_services where user_id=? and status=?) and service_cat like '%' and status='0' order by service_type_order,service_sub_type_order";

		$status = 1;

		$query1 = $conn->prepare($sql2);

		$query1->bind_param("si", $uid, $status);


		if ($query1->execute()) {

			$rs = $query1->get_result();

			while ($row = $rs->fetch_assoc()) {

				$this->services[$row['service_type']][$row['service_id']] = $row['service_name'];

				$this->services1[$row['service_id']] = $row['service_name'];

				$this->main_icons[$row['service_type']]['main_icon'] = $row['main_icon'];
			}
		}





		$conn->close();
	}
}
