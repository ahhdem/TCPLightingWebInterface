<?php
/*
 *
 * PHP API TEST CALLS
 *
 */
 
	include "include.php";
	
	$URL = "https://".LIGTHING_URL.":".LIGHTING_PORT.API_PATH;
	
	

	echo '<h3>GWAccountGetExtras</h3>';
	$CMD = "cmd=AccountGetExtras&data=<gip><version>1</version><token>".TOKEN."</token></gip>";
	$result = getCurlReturn($CMD);
	$array = xmlToArray($result);
	pa( $array );
	
	echo '<h3>GWGatewayGetInfo</h3>';
	$CMD = "cmd=GatewayGetInfo&data=<gip><version>1</version><token>".TOKEN."</token></gip>";
	$result = getCurlReturn($CMD);
	$array = xmlToArray($result);
	pa( $array );
	
	/*
	echo '<h3>GWRoomGetInfoAll</h3>';
	$CMD = "cmd=RoomGetInfoAll&data=<gip><version>1</version><token>".TOKEN."</token><fields>name,power,product,class,image,imageurl,control,other</fields></gip>";
	$result = getCurlReturn($CMD);
	$array = xmlToArray($result);
	pa( $array );
	*/
	
	echo '<h3>GWRoomGetList</h3>';
	$CMD = "cmd=RoomGetList&data=<gip><version>1</version><token>".TOKEN."</token></gip>";
	$result = getCurlReturn($CMD);
	$array = xmlToArray($result);
	pa( $array );
	
	echo '<h3>GWSceneGetList</h3>';
	$CMD = "cmd=SceneGetList&data=<gip><version>1</version><token>".TOKEN."</token><bigicon>1</bigicon></gip>";
	$result = getCurlReturn($CMD);
	$array = xmlToArray($result);
	pa( $array );
	
	echo '<h3>GWSceneGetListDetails</h3>';
	$CMD = "cmd=SceneGetListDetails&data=<gip><version>1</version><token>".TOKEN."</token><bigicon>1</bigicon></gip>";
	$result = getCurlReturn($CMD);
	$array = xmlToArray($result);
	pa( $array );




	
	
	//Get State of System Data
	$CMD = "cmd=GWRBatch&data=<gwrcmds><gwrcmd><gcmd>RoomGetCarousel</gcmd><gdata><gip><version>1</version><token>".TOKEN."</token><fields>name,image,imageurl,control,power,product,class,realtype,status</fields></gip></gdata></gwrcmd></gwrcmds>&fmt=xml";
	
	$result = getCurlReturn($CMD);
	
	$array = xmlToArray($result);


	$DATA = $array["gwrcmd"]["gdata"]["gip"]["room"];

	$ROOMS = array();
	$DEVICES = array();
	
	foreach($DATA as $room){
		$deviceCount = 0;
		if( ! is_array($room["device"]) ){

		}else{
			$device = (array)$room["device"];
			if( isset($device["did"]) ){
				//item is singular device
				$room['device']["roomID"] = $room["rid"];
				$room['device']["roomName"] = $room["name"];
				$DEVICES[] = $room["device"];
				$deviceCount++;
			}else{
				for( $x = 0; $x < sizeof($device); $x++ ){
					if( isset($device[$x]) && is_array($device[$x]) && ! empty($device[$x]) ){
						$device[$x]["roomID"] = $room["rid"];
						$device[$x]["roomName"] = $room["name"];
						$DEVICES[] = $device[$x];
						$deviceCount++;
					}
				}
			}
		}
		
		$room["deviceCount"] = $deviceCount;
		unset($room["device"]);
		$ROOMS[] = $room;
	}
	
	echo "<p>Found ".sizeof($ROOMS)." rooms and ".sizeof($DEVICES)." devices.</p>";
	
	foreach($ROOMS as $room){
		echo "<h4>Room - ".$room["name"]."</h4>";
		pa($room);
	}
	
	foreach( $DEVICES as $device){
		echo "<h4>Device - ".(isset($device["name"]) ? $device["name"] : "unknown")."</h4>";
		pa( $device);
	}
	
	echo "<h2>API Command Test:</h2>";
	echo "<pre>".print_r($array,true)."</pre>";
	
	
	echo '<h3>UserGetListDefaultRooms</h3>';
	
	$CMD = "cmd=GWRBatch&data=<gwrcmds><gwrcmd><gcmd>UserGetListDefaultRooms</gcmd><gdata><gip><version>1</version><token>".TOKEN."</token><fields>name,image,imageurl,control,power,product,class,realtype,status</fields></gip></gdata></gwrcmd></gwrcmds>&fmt=xml";
	
	$result = getCurlReturn($CMD);
	$array = xmlToArray($result);
	
	pa( $array );
	
	
	echo '<h3>UserGetListDefaultColors</h3>';
	
	$CMD = "cmd=GWRBatch&data=<gwrcmds><gwrcmd><gcmd>UserGetListDefaultColors</gcmd><gdata><gip><version>1</version><token>".TOKEN."</token><fields>name,image,imageurl,control,power,product,class,realtype,status</fields></gip></gdata></gwrcmd></gwrcmds>&fmt=xml";
	
	$result = getCurlReturn($CMD);
	$array = xmlToArray($result);
	
	pa( $array );
	
	
	
	echo '<h3>SceneGetList</h3>';
	
	$CMD = "cmd=GWRBatch&data=<gwrcmds><gwrcmd><gcmd>SceneGetList</gcmd><gdata><gip><version>1</version><token>".TOKEN."</token><fields>bigicon,detail,imageurl</fields><islocal>1</islocal></gip></gdata></gwrcmd></gwrcmds>&fmt=xml";
	
	$result = getCurlReturn($CMD);
	$array = xmlToArray($result);
	
	pa( $array );
	
	echo pa( getDevices() );
	
	
	
	
	
	
	
	

?>