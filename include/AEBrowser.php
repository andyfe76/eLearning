<?php
// DESCRIPTION:
//  This custom tag returns a series of variables that define the browser type, version,
//  and platform by interpreting the User Agent.
// 
// RETURNED VARIABLES:
//  All variables are stored in the array BROWSER and can be accessed via BROWSER["variable"]
// 
//  Browser Type Variables
//  ======================
//    Type         : [Navigator|Explorer|AOL|Opera|WebTV|Lynx|Other]
//    isNavigator  : [yes|no]
//    isExplorer   : [yes|no]
//    isAOL        : [yes|no]
//    isOpera      : [yes|no]
//    isWebTV      : [yes|no]
//    isLynx       : [yes|no]
//    isOtherType  : [yes|no]
// 
//  Browser Version Variables
//  =========================
//    Version        : Default is 0
//    MajorVersion   : Default is 0
//    MinorVersion   : Default is 0
//    mozillaVersion : Default is 0
// 
//  Browser Platform Variables
//  ==========================
//    Platform : [Windows|Mac|Linux|Unix|OS/2|WebTV|Other]
//    isWindows : [yes|no]
//    isMac     : [yes|no]
//    isUnix    : [yes|no]
//    isLinux   : [yes|no]
//    isOS2     : [yes|no]
//    isWebTV   : [yes|no]
//    isOtherOS : [yes|no]
//    
//  Random Variables
//  ================
//  The following variables are also included based on browser information
//    supportCSS          : [yes|no] Navigator/Explorer 4+, AOL 3+, WebTV and Opera 3.6+.     
//    supportDHTML        : [yes|no] Navigator, Explorer and AOL 4+ (all platforms).   
//    supportXML          : [yes|no] Navigator 6+, Explorer 5+, Opera 4+
//    supportJava         : [yes|no] Navigator 3+, Explorer 3+, AOL3+.
//    supportJavaScript   : [yes|no] Navigator 3+, Explorer 3+,  AOL 3+, Opera 3.5+, WebTV.
//    supportTrueDoc      : [yes|no] Navigator 4.03+ (Windows/Mac), Explorer 4+ (Windows).
// 
// =============================================================================================

// Set User Agent String
$User_Agent = getenv('HTTP_USER_AGENT');

// Initialize Array
$BROWSER["Type"]="Other";
$BROWSER["isNavigator"]=0;
$BROWSER["isExplorer"]=0;
$BROWSER["isAOL"]=0;
$BROWSER["isOpera"]=0;
$BROWSER["isWebTV"]=0;
$BROWSER["isLynx"]=0;
$BROWSER["isOtherType"]=0;
$BROWSER["Version"]=0;
$BROWSER["MajorVersion"]=0;
$BROWSER["MinorVersion"]=0;
$BROWSER["mozillaVersion"]=0;
$BROWSER["Platform"]="Other";
$BROWSER["isWindows"]=0;
$BROWSER["isMac"]=0;
$BROWSER["isUnix"]=0;
$BROWSER["isLinux"]=0;
$BROWSER["isOS2"]=0;
$BROWSER["isWebTV"]=0;
$BROWSER["isOtherOS"]=0;
$BROWSER["supportCSS"]=0;
$BROWSER["supportDHTML"]=0;
$BROWSER["supportXML"]=0;
$BROWSER["supportJava"]=0;
$BROWSER["supportJavaScript"]=0;
$BROWSER["supportTrueDoc"]=0;

// Determine Browser Type  
if ((eregi("Mozilla", $User_Agent)) &&
 (!((eregi("MSIE", $User_Agent)) ||
    (eregi("Opera", $User_Agent)) ||
    (eregi("WebTV", $User_Agent)) || 
    (eregi("compatible", $User_Agent))))) {
  $BROWSER["isNavigator"]=1;
  $BROWSER["Type"]="Navigator";
} elseif ((eregi("MSIE", $User_Agent)) &&
       (!((eregi("AOL", $User_Agent)) ||
          (eregi("WebTV", $User_Agent))))) {
  $BROWSER["isExplorer"]=1;
  $BROWSER["Type"]="Explorer";
} elseif (eregi("AOL", $User_Agent)) {	
  $BROWSER["isAOL"]=1;
  $BROWSER["Type"]="AOL";
} elseif (eregi("Opera", $User_Agent)) {	
  $BROWSER["isOpera"]=1;
  $BROWSER["Type"]="Opera";  
} elseif (eregi("WebTV", $User_Agent)) {	
  $BROWSER["isWebTV"]=1;
  $BROWSER["Type"]="WebTV";  
} elseif (eregi("Lynx", $User_Agent)) {	
  $BROWSER["isLynx"]=1;
  $BROWSER["Type"]="Lynx";  
} else {
  $BROWSER["isOtherType"]=1;	
}	


// Set Generic Mozilla Version if not Lynx    
if (!($BROWSER["isLynx"])) {
  $BROWSER["mozillaVersion"] = strtok($User_Agent, "/");
  $BROWSER["mozillaVersion"] = strtok( " ");
}	

// Determine Browser Version based on Browser type
if ($BROWSER["isNavigator"]) {
  if ($BROWSER["mozillaVersion"] >= 5) {
  	$useragents[1]="Mozilla/5.0 (Windows; N; WinNT4.0; en-US; m14) Netscape6/6.0b1";
    $BROWSER["Version"] = strtok($User_Agent, ")");	
    $BROWSER["Version"] = strtok( "/");
    $BROWSER["Version"] = strtok( "");
  } else {  		
    $BROWSER["Version"] = $BROWSER["mozillaVersion"];	
  }	
} elseif ($BROWSER["isExplorer"]) {	
  $BROWSER["Version"] = strtok($User_Agent, "(");	
  $BROWSER["Version"] = strtok( "MSIE");
  $BROWSER["Version"] = strtok( " ");
  $BROWSER["Version"] = strtok( ";");
} elseif ($BROWSER["isAOL"]) {
  $BROWSER["Version"]=strtok($User_Agent, "(");	
  $BROWSER["Version"] = strtok( "AOL");
  $BROWSER["Version"] = strtok( " ");
  $BROWSER["Version"] = strtok( ";");
} elseif ($BROWSER["isOpera"]) {
  $BROWSER["Version"]=strtok($User_Agent, ")");	
  $BROWSER["Version"] = strtok( "Opera");	
  $BROWSER["Version"] = strtok( " ");
  $BROWSER["Version"] = strtok( " ");
} elseif ($BROWSER["isWebTV"]) {
  $BROWSER["Version"]=strtok($User_Agent, " ");	
  $BROWSER["Version"] = strtok( "/");	
  $BROWSER["Version"] = strtok( " ");	
} elseif ($BROWSER["isLynx"]) {
  $BROWSER["Version"]=strtok($User_Agent, "/");	
  $BROWSER["Version"] = strtok( " ");
}	
    
// Determine Major and Minor version for browser 
$BROWSER["MajorVersion"] = strtok($BROWSER["Version"], ".");
$BROWSER["MinorVersion"] = strtok($BROWSER["Version"], ".");
$BROWSER["MinorVersion"] = strtok( "");


// Determine Platform
if (eregi("win", $User_Agent)) {
  $BROWSER["isWindows"]=1;
  $BROWSER["Platform"]="Windows";	
} elseif (eregi("mac", $User_Agent)) {
  $BROWSER["isMac"]=1;
  $BROWSER["Platform"]="Mac";	
} elseif (eregi("x11", $User_Agent)) {
  $BROWSER["isUnix"]=1;
  $BROWSER["Platform"]="Unix";	
  if (eregi("inux", $User_Agent)) {
    $BROWSER["isLinux"]=1;
    $BROWSER["Platform"]="Linux";	
  }  	
} elseif ((eregi("os/2", $User_Agent)) || (eregi("ibm-webexplorer", $User_Agent))){
  $BROWSER["isOS2"]=1;
  $BROWSER["Platform"]="OS/2";	
} elseif ($BROWSER["isWebTV"]) {
  $BROWSER["Platform"]="WebTV";	
} else {				
  $BROWSER["isOtherOS"]=1;
  $BROWSER["Platform"]="Other";
}	


// Determine CSS Support. 
// Navigator/Explorer 4+ (all platforms), AOL 3+, WebTV and Opera 3.5+.
if ( ($BROWSER["isNavigator"] && $BROWSER["Version"] >= 4) ||
     ($BROWSER["isExplorer"] && $BROWSER["Version"] >= 4) ||
     ($BROWSER["isAOL"] && $BROWSER["Version"] >= 3) ||
     ($BROWSER["isOpera"] && $BROWSER["Version"] >= 3.6) ||
     ($BROWSER["isWebTV"]) ) {
  $BROWSER["supportCSS"]=1;
}  

// Determine DHTML support
// Navigator, Explorer and AOL 4+ (all platforms).
if ( ($BROWSER["isNavigator"] && $BROWSER["Version"] >= 4) ||
     ($BROWSER["isExplorer"] && $BROWSER["Version"] >= 4) ||
     ($BROWSER["isAOL"] && $BROWSER["Version"] >= 4) ) {
  $BROWSER["supportDHTML"]=1;
}

// Determine XML support.
// Navigator 6+, Explorer 5+, Opera 4+.
if ( ($BROWSER["isNavigator"] && $BROWSER["Version"] >= 6) ||
     ($BROWSER["isExplorer"] && $BROWSER["Version"] >= 5) ||
     ($BROWSER["isOpera"] && $BROWSER["Version"] >= 4) ) {
  $BROWSER["supportXML"]=1;
}     

// Determine Java support.
// Navigator 3+, Explorer 3+, AOL3+.
if ( ($BROWSER["isNavigator"] && $BROWSER["Version"] >= 3) ||
     ($BROWSER["isExplorer"] && $BROWSER["Version"] >= 3) ||
     ($BROWSER["isAOL"] && $BROWSER["Version"] >= 3) ) {
  $BROWSER["supportJava"]=1;
}  

// Determine JavaScript support. 
// Navigator 3+, Explorer 3+, AOL 3+, Opera 3.5+, WebTV.
if ( ($BROWSER["isNavigator"] && $BROWSER["Version"] >= 3) ||
     ($BROWSER["isExplorer"] && $BROWSER["Version"] >= 3) ||
     ($BROWSER["isAOL"] && $BROWSER["Version"] >= 3) ||
     ($BROWSER["isOpera"] && $BROWSER["Version"] >= 3.5) ||
     ($BROWSER["isWebTV"]) ) {
  $BROWSER["supportJavaScript"]=1;
}

// Determine TrueDoc embedded font support
// Navigator 4.03+ (Windows/Mac), Explorer 4+ (Windows).
if ( ($BROWSER["isNavigator"] && ($BROWSER["Version"] >= 4.03) && 
     (($BROWSER["Platform"] == "Windows") || ($BROWSER["Platform"] == "Mac"))) ||
     ($BROWSER["isExplorer"] && ($BROWSER["Version"] >= 4) && ($BROWSER["Platform"] == "Windows")) ||
     ($BROWSER["isAOL"] && ($BROWSER["Version"] >= 4) && ($BROWSER["Platform"] == "Windows")) ) {
  $BROWSER["supportTrueDoc"]=1;
} 

?>
