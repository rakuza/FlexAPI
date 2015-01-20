<?php 
class core_security
{
	static function CheckSecurityLevel($isAdmin,$isAuthenicated)
	{
		if(isset($_SESSION['user_lvl']))
		{
		if( $_SESSION['user_lvl'] == "authenicated" && $isAuthenicated)
		{
			return true;
		}
		
		if( $_SESSION['user_lvl'] == "admin")
		{
			return true;
		}
		}

		core_security::SendAuthenticationFail();
		//unreachible section of code(hopefully)
		return false;
	}
	
	private static function SendAuthenticationFail()
	{
		global $_PAGE;
		header ("HTTP/1.0 403 Forbidden");
		header('Content-Type: application/json');
		echo	'{"Component":"'.$_PAGE['URL']->component.'",
				  "Identifier":"'.$_PAGE['URL']->identifier.'",
				  "Method":"'.$_PAGE['URL']->method.'",
				  "Error":{"Type":"Authenication Failure","Reason":"Not authenicated,Expired authenication or bad authenication"}}';
		exit;
	}


}