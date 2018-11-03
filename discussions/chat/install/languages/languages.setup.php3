<?php
if (!isset($Lang) || !file_exists("install/languages/${Lang}.setup.php3"))
{

	// Available languages
	$AvailableLanguages = array(
		"cs|czech"				=>	"czech",
		"en([-_][[:alpha:]]{2})?|english"	=>	"english",
		"fr([-_][[:alpha:]]{2})?|french"	=>	"french",
		"it|italian"			=>	"italian",
		"es[-_]ar"				=>	"argentinian spanish",
		"es([-_][[:alpha:]]{2})?|spanish"	=>	"spanish"
	);

	function Detect($Str,$From)
	{
		global $AvailableLanguages;
		global $Lang;

		$NotFound = true;
		reset($AvailableLanguages);
		while($NotFound && list($key, $name) = each($AvailableLanguages))
		{
			if (($From == 1 && eregi("^".$key."$",$Str)) || ($From == 2 && eregi("(\(|\[|;[[:space:]])".$key."(;|\]|\))",$Str)))
			{
				$Lang = $AvailableLanguages[$key];
				$NotFound = false;
			};
		};
	};

	if (!isset($HTTP_ACCEPT_LANGUAGE))
		$HTTP_ACCEPT_LANGUAGE = getenv("HTTP_ACCEPT_LANGUAGE");
	if (!isset($HTTP_USER_AGENT))
		$HTTP_USER_AGENT = getenv("HTTP_USER_AGENT");

	if ($HTTP_ACCEPT_LANGUAGE != "")
	{	
		$Accepted = explode(",", $HTTP_ACCEPT_LANGUAGE);
		Detect($Accepted[0],1);
	}
	elseif ($HTTP_USER_AGENT != "")
	{	
		Detect($HTTP_USER_AGENT,2);
	};

	//if no language detected set default one
	if (!isset($Lang)) $Lang = "english";

};
?>