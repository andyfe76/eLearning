aa=0;sst=20000;tms=0;sn=1;if(document.images){nyt=new Image();nyt.src='pics/sndf.gif'}
if(typeof document.layers!='object'){document.write('<link rel="stylesheet" type="text/css" href="incl/stl.css">')}

function fc(){document.forms[0].entry.focus()}
function tu(){setTimeout("document.forms[0].entry.value='';fc()",200)}
function sp(m){a=document.forms[0].entry;a.value=a.value+m}
function rd(m){rnd();p=tms;parent.a.location=m+'.php?u='+p+'&q='+aa;fc()}
function sd(q){if(sn==1){q.src='pics/sndf.gif';sn=0}else{q.src='pics/sndn.gif';sn=1}fc()}

function ow(m){p=tms;rnd()
wp=parent.a.location.toString();wp=wp.split('?')
parent.a.location=wp[0]+'?nyc='+m+'&u='+p+'&q='+aa
parent.b.location='insert.php?nyc='+m+'&q='+aa
parent.c.location='non.php?nyc='+m+'&q='+aa}

function bd(m){p=tms;rnd()
wp=parent.a.location.toString();wp=wp.split('?')
parent.a.location=wp[0]+'?wik='+m+'&u='+p+'&q='+aa;fc()}

function fg(g){
document.a.src='pics/of.gif'
document.b.src='pics/of.gif'
document.c.src='pics/of.gif'
document.d.src='pics/of.gif'
document.e.src='pics/of.gif'
sst=g;rd('main');fc()}

function rnd(){aa=Math.round(99999999*Math.random())}