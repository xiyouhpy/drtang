<?php
	include_once("conn.php");
	include_once("BloodCmp.php")
	function Register($phonenum, $password)
	{
		if(mysql_query("INSERT INTO account(phonenum, password) VALUES (".$phonenum.", ".$password.")") == 1)
			return 1;
		else
			return 0;
	}
	
	function Login($phonenum, $password)
	{
		$result = mysql_query("SELECT * FROM account WHERE phonenum = ".$phonenum);
		$row = mysql_fetch_array($result);
		if ($password == $row["password"])
			return 1;
		else
			return 0;
	}
	
	function AddGuardian($phonenum, $guardiantel)
	{
		if(mysql_query("INSERT INTO guardian(phonenum, guardiantel) VALUES (".$phonenum.", ".$guardiantel.")") == 1)
			return 1;
		else
			return 0;
	}

	function DelGuardian($phonenum, $guardiantel)
	{
		if(mysql_query("DELETE FROM guardian WHERE phonenum = ".$phonenum." AND guardiantel = ".$guardiantel) == 1)
			return 1;
		else
			return 0;
	}

	function GetGuardian($phonenum)
	{
		$result = mysql_query("SELECT * FROM guardian WHERE phonenum = ".$phonenum);
		$row = mysql_fetch_array($result);
		$guardian = "{\"guardian\":[ ".$row["guardiantel"];
		while($row = mysql_fetch_array($result))
		{
			$guardian .= ", ".$row["guardiantel"];
		}
		$guardian .= "]}";
		return $guardian;
	}

	function AddRecord($phonenum, $value, $food, $sport, $medicine)
	{
		if(mysql_query("INSERT INTO record(phonenum, value, food, sport, medicine) VALUES ('".$phonenum."', '".$value."', '".$food."', '".$sport."', '".$medicine."')") == 1)
                        return RecordJudge($phonenum, $value);
                else
                        return 0;
	}

	function GetRecord($phonenum, $starttime, $endtime)
	{
		$result = mysql_query("SELECT * FROM record WHERE phonenum = '".$phonenum."' AND time >= '".$starttime."' AND time <= '".$endtime."'");
		$row = mysql_fetch_array($result);
		if(!($row)) return 0;
		$record = "{\"record\":[{\"time\":\"".$row["time"]."\", \"value\":".$row["value"].", \"food\":\"".$row["food"]."\", \"sport\":\"".$row["sport"]."\", \"medicine\":\"".$row["medicine"]."\"}";
		while($row = mysql_fetch_array($result))
		{
			$record .= ",{\"time\":\"".$row["time"]."\", \"value\":".$row["value"].", \"food\":\"".$row["food"]."\", \"sport\":\"".$row["sport"]."\", \"medicine\":\"".$row["medicine"]."\"}";
		}
		$record .= "]}";
		return $record;
	}
	
	function RecordJudge($phonenum, $value)
	{
		$BData = new BloodCmp($phonenum, $value);
		$BData->Blood_cmp();
	}
	
?>
