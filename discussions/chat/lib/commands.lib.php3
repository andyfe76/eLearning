<?php
if (eregi("^\/(show|last)([[:space:]]([[:digit:]]+))?$", $M, $Cmd))
{
	include("./lib/commands/show.cmd.php3");
}
elseif (eregi("^\/refresh([[:space:]]([[:digit:]]*))?$", $M, $Cmd))
{
	include("./lib/commands/refresh.cmd.php3");
}
elseif (eregi("^\/order$", $M))
{
	include("./lib/commands/order.cmd.php3");
}
elseif (eregi("^\/timestamp$", $M))
{
	include("./lib/commands/timestamp.cmd.php3");
}
elseif (C_VERSION > 0 && eregi("^\/join[[:space:]]((0|1)[[:space:]])?#(.{1,30})$", $M, $Cmd))
{
	include("./lib/commands/join.cmd.php3");
}
elseif (eregi("^\/(quit|exit|bye)([[:space:]](.+))?$", $M, $Cmd))
{
	include("./lib/commands/quit.cmd.php3");
}
elseif (eregi("^\/ignore([[:space:]]\\-)?([[:space:]](.+))?$", $M, $Cmd))
{
	include("./lib/commands/ignore.cmd.php3");
}
elseif (eregi("^\/!$", $M, $Cmd) && (isset ($M0) && $M0 != ""))
{
	include("./lib/commands/history.cmd.php3");
}
elseif (eregi("^\/kick[[:space:]](.{1,30})$", $M, $Cmd))
{
	include("./lib/commands/kick.cmd.php3");
}
elseif (eregi("^\/(msg|to)[[:space:]]([^[:space:]]{1,30})[[:space:]](.+)$", $M, $Cmd))
{
	include("./lib/commands/priv_msg.cmd.php3");
}
elseif (eregi("^\/whois[[:space:]](.{1,30})$", $M, $Cmd))
{
	include("./lib/commands/whois.cmd.php3");
}
elseif (eregi("^\/profile$", $M))
{
	include("./lib/commands/profile.cmd.php3");
}
elseif (eregi("^\/notify$", $M))
{
	include("./lib/commands/notify.cmd.php3");
}
elseif (eregi("^\/promote[[:space:]](.{1,30})$", $M, $Cmd))
{
	include("./lib/commands/promote.cmd.php3");
}
elseif (eregi("^\/(help|\?)$", $M, $Cmd))
{
	include("./lib/commands/help.cmd.php3");
}
elseif (eregi("^\/clear$", $M, $Cmd))
{
	include("./lib/commands/clear.cmd.php3");
}
elseif (C_SAVE != "0" && eregi("^\/save([[:space:]]([[:digit:]]*))?$", $M, $Cmd) && ($Cmd[2] == "" OR $Cmd[2] > 0))
{
	include("./lib/commands/save.cmd.php3");
}
elseif (eregi("^\/announce[[:space:]](.*)?$", $M, $Cmd))
{
	include("./lib/commands/announce.cmd.php3");
}
elseif (eregi("^\/invite([[:space:]](.+))+$", $M, $Cmd))
{
	include("./lib/commands/invite.cmd.php3");
}
elseif (C_BANISH != "0" && eregi("^\/ban[[:space:]](\*[[:space:]])?(.{1,30})$", $M, $Cmd))
{
	include("./lib/commands/banish.cmd.php3");
}
elseif (eregi("^\/me[[:space:]](.*)?$", $M, $Cmd))
{
	include("./lib/commands/me.cmd.php3");
};
?>