<?php
// Translation into Czech for setup process
// By Martin Dvorak <jezek2@penguin.cz>

// extra header for charset
$S_Charset = "iso-8859-2";
$S_FontSize = "10";

// Settings for setup.php3 file
define("S_MAIN_1","Tabulky budou vytvoøeny/updatovány na lokálním serveru.");
define("S_MAIN_2","Krok 1 hotov: tabulky byly vytvoøeny/updatovány.");
define("S_MAIN_3","Krok 1 byl u¾ivatelem zru¹en.");
define("S_MAIN_4","Nalezeno chybìjící nebo ¹patné nastavení.");
define("S_MAIN_5","Chybí alespoò jedno z zpo¾dìní pro èi¹tìní databáze.");
define("S_MAIN_6","Je vy¾adována alespoò jedna defaultní místnost.");
define("S_MAIN_7","Jméno místnosti nemù¾e obsahovat zpìtná lomítka (\\).");
define("S_MAIN_8","Chybí nastavení èasového pásma.");
define("S_MAIN_9","Chybí defaultní poèet zobrazovaných zpráv a/nebo defaultní zpo¾dìní mezi ka¾dým obnovením zpráv.");
define("S_MAIN_11","Krok 2 hotov: nastavení pro vyladìní chatu bylo registrováno.");
define("S_MAIN_12","Musíte napsat va¹e pøihla¹ovací jméno.");
define("S_MAIN_13","Va¹e jméno nemù¾e obsahovat mezery, èárky ani zpìtná lomítka (\\).");
define("S_MAIN_14","Musíte napsat va¹e heslo.");
define("S_MAIN_15","Pøezdívka <I>%s</I> je u¾ registrována a vy jste napsal ¹patné heslo.");
define("S_MAIN_16","Krok 3 hotov: vá¹ profil administrátora byl registrován.");
define("S_MAIN_17","Krok 3 byl u¾ivatelem zru¹en.");
define("S_MAIN_18","- Instalace");

// Settings for setup0.php3 file
define("S_SETUP0_1","Tento skript vám slou¾í k velmi lehké a rychlé instalaci skriptu %s.");
define("S_SETUP0_2","Mù¾ete jej samozøejmì nainstalovat i ruènì, jestli chcete. Pokud preferujete tuto cesti, musíto udìlat toto:");
define("S_SETUP0_3","Vytvoøit tabulky pro %s pou¾itím \"dump\" souborù, je¾ naleznete v adresáøi <I>'chat/install/database'</I>;");
define("S_SETUP0_4","Upravit soubor <I>config.lib.php3</I> umístìný v adresáøi <I>'chat/config'</I> pro nastavení konfigurace;");
define("S_SETUP0_5","Manuálnì pøidat vy¾adované informace o administrátorovi do tabulky pro regisrované u¾ivatele (c_reg_users): va¹e pøezdívka ve sloupci <I>username</I>, va¹e heslo v MD5 hash formì ve sloupci <I>password</I> a slovo 'admin' (bez uvozovek) ve sloupeèku <I>perms</I>. Jestli chcete, mù¾ete kdykoli pøidat dal¹í informace do ostatních sloupeèkù, ale není to potøeba;");
define("S_SETUP0_5m","Sets three variables at the top of the 'chat/admin/mail4admin.lib.php3' script.");
define("S_SETUP0_6","Pro zahájení automatické instalace, kliknìte prosím na spodní tlaèítko.");
define("S_SETUP0_7"," Nainstalovat ");
define("S_SETUP0_8","Before updating from an older version of %s you'd better clean the messages table (using the 'chat/admin.php3' script of this old version for example).");

// Settings for setup1.php3 file
define("S_SETUP1_1","První krok: Konfigurace tabulek");
define("S_SETUP1_2","Nastavení databáze");
define("S_SETUP1_3","Vyberte si vá¹ SQL server:");
define("S_SETUP1_4","Adresa (hostname) va¹eho SQL serveru:");
define("S_SETUP1_5","Logické jméno databáze na tomto serveru:");
define("S_SETUP1_6","(musí existovat)");
define("S_SETUP1_7","Pøihla¹ovací jméno do databáze:");
define("S_SETUP1_8","Pøihla¹ovací heslo do databáze:");
define("S_SETUP1_9","Vytváøení/Updatování tabulek");
define("S_SETUP1_10","Co chcete, aby tento skript udìlal?");
define("S_SETUP1_11","Vytvoøit tabulky pro %s");
//define("S_SETUP1_12","Updatovat u¾ existující (jen z verzí 0.12.0 a 0.12.1)");
define("S_SETUP1_12","Update existing ones created for 0.12.0 or 0.12.1 releases");
//define("S_SETUP1_13","Neudìlat nic, tabulky jsou u¾ hotovy (napø. z verzí 0.13.?)");
define("S_SETUP1_13","Do nothing, tables are already up to date (for 0.13.4 and 0.14.? releases)");
define("S_SETUP1_14","Jména tabulek<SUP>*</SUP>, kde...");
define("S_SETUP1_15","budou ukládány zprávy:");
define("S_SETUP1_16","budou ulo¾eny profily registerovaných u¾ivatelù:");
define("S_SETUP1_17","budou ulo¾eny jména neregistrovaných u¾ivatelù:");
define("S_SETUP1_18","<SUP>*</SUP>Jména, je¾ napí¹ete, musí být shodná s existujícímy tabulky, pokud jste zvolili jejich <BR><B>updatování</B>. Pokud chcete <B>vytvoøit nové tabulky</B>, jména se <B>musejí li¹it</B><BR>od u¾ existujících tabulek!<BR>V¹echny políèka musejí být vyplnìna, ikdy¾ nechcete ¾ádné tabulky vytvoøit,<BR>proto¾e informace budou potøeba pozdìji pøi vytváøení profilu administrátora.");
define("S_SETUP1_19","OK");
define("S_SETUP1_20","Update existing ones created for 0.13.0 to 0.13.3 releases");
define("S_SETUP1_21","banished users will be stored:");

// Settings for setup2.php3 file
define("S_SETUP2_1","Druhý krok: Vylaïování nastavení");
define("S_SETUP2_2","Nastavení pro èi¹tìní zpráv a jmen u¾ivatelù");
define("S_SETUP2_3","Za kolik hodin mazat zprávy:");
define("S_SETUP2_4","Za kolik minut mazat neaktivní u¾ivatele:");
define("S_SETUP2_5","Za kolik dnù mazat neaktivní u¾ivatele, kteøí byly smazáni&nbsp;&nbsp;&nbsp;<BR>z tabulky s registrovanými u¾ivateli (0 = nikdy):");
define("S_SETUP2_6","Defaultní místnosti");
define("S_SETUP2_7","Místnosti jsou oddìleny èárkou (,) bez mezer.");
define("S_SETUP2_8","Nastavení jazyka");
define("S_SETUP2_9","Povolit více jazykù/znakových sad?");
define("S_SETUP2_10","Defaultní jazyk:");
define("S_SETUP2_11","Nastavení bezpeènosti a omezení");
define("S_SETUP2_12","Zobrazit odkaz pro administraci u¾ivatelù na první stránce chatu?");
define("S_SETUP2_13","Zobrazit odkaz, je¾ umo¾òuje u¾ivatelùm mazat jejich vlastní porfily?");
define("S_SETUP2_15","U¾ivatelé mohou pøistupovat...");
define("S_SETUP2_16","...jen do první defaultní místnosti");
define("S_SETUP2_17","...do v¹ech defaultních místností, ale bez mo¾nosti vytváøet vlasní");
define("S_SETUP2_18","...do v¹ech místností a vytváøet nové");
define("S_SETUP2_19","Vylep¹ení zpráv");
define("S_SETUP2_20","Pou¾ívat grafické smailíky (viz 'chat/lib/smilies.lib.php3')?");
define("S_SETUP2_21","Nechat úèinek tagù pro tuèný, sklonìný a podtr¾ený text ve zprávách?");
define("S_SETUP2_22","Zobrazovat neplatné HTML tagy?");
define("S_SETUP2_23","Defaultní zobrazení");
define("S_SETUP2_24","Posun èasu v hodinách mezi èasem serveru a va¹í zemí:");
define("S_SETUP2_25","Defaultní poøadí zpráv:");
define("S_SETUP2_26","poslední nahoøe");
define("S_SETUP2_27","poslední dole");
define("S_SETUP2_28","Defaultní poèet zobrazovaných zpráv:");
define("S_SETUP2_29","Defaultní prodleva mezi obnovováním zpráv (v sekundách):");
define("S_SETUP2_30","Zobrazovat defaultnì èas u zpráv.");
define("S_SETUP2_31","Zobrazovat defaultnì notifikace, kdy¾ u¾ivatel vstoupí/odejde.");
define("S_SETUP2_36","Zakázat ¹patné slova (viz 'chat/lib/swearing.lib.php3')?");
define("S_SETUP2_41","Maximum number of messages that an user is allowed to export to an HTML file (0 for none -save command is disabled-, '*' for all available messages, or an integer to limit server charge)?");
define("S_SETUP2_42","Enable the banishment feature?<BR>0 for no, else a positive number to define the number of banishment<BR>day(s) (2000000 for no end, 0.02 for ~half an hour....))");
define("S_SETUP2_43","Registration of users");
define("S_SETUP2_14","Vy¾adovat registraci u¾ivatelù?");
define("S_SETUP2_44","Generate a password and send it to the e-mail address the user enter in?<BR>This option require the <I>'mail()'</I> PHP function to be enabled, ensure you can use it with the administrator of your PHP server.<BR>Moreover, to have it running you must define 4 settings in the 'chat/lib/mail_validation.lib.php3' script.");
define("S_SETUP2_45","Your PHP configuration seems not to allow the use of the <I>'mail()'</I> function. So you can't choose to generate a password and send it to the user by e-mail.");
define("S_SETUP2_46","veøejnou:");
define("S_SETUP2_47","soukromou:");
define("S_SETUP2_48","Send a welcome message to an user logging into the chat (see 'chat/lib/welcome.lib.php3') ?");

// Settings for setup3.php3 file
define("S_SETUP3_1","Profil administrátora je u¾ definován a v chatu mù¾e být<BR>pouze jeden administrátor. Modifikujte, prosím, spodní políèka<BR>pro updatování existujícíhi profilu.");
define("S_SETUP3_2","Tøetí krok: Registrace administrátora");
define("S_SETUP3_3","Políèka s <SPAN CLASS=error>*</SPAN> jsou vy¾adována.");
define("S_SETUP3_4","jméno (pøezdívka):");
define("S_SETUP3_5","heslo:");
define("S_SETUP3_6","køestní jmené:");
define("S_SETUP3_7","pøíjmení:");
define("S_SETUP3_8","ovládané jazyky:");
define("S_SETUP3_9","domovská stránka:");
define("S_SETUP3_10","e-mailová adresa:");
define("S_SETUP3_11","zobrazovat e-mail pomocí pøíkazu /whois");
define("S_SETUP3_12","Vynechat >>");
define("S_SETUP3_13","Vá¹ profil mù¾ete upravit kdykoli po instalaci kliknutím na odkaz<BR>pro editaci profilu na první stranì chatu.");
define("S_SETUP3_14", "gender");
define("S_SETUP3_15", "male");
define("S_SETUP3_16", "female");

// Settings for setup4.php3 file
define("S_SETUP4_1","Ètvrtý krok: Konfiguraèní soubor");
define("S_SETUP4_2","Tady je konfiguraèní soubor vytvoøený podle vými zadaných údajù.<BR><BR>Okopírujte celý obsah vèetnì první a poslední øadky, a vlo¾te jej do va¹eho oblíbeného textového editoru (notepad èi vi). Poté *musíte* vyplnit heslo do databáze na 7. øádce a ulo¾it soubor jako <I>config.lib.php3</I>.<BR><BR>Dùkladnì zkontrolujte jestli <B>není ¾ádná prázdná øádka ani mezera, ani pøed otevíracím tagem PHP kódu ani po ukonèovacím</B>, poté nahrajte konfiguraèní soubor na vá¹ server do adresáøe <I>config</I> (pøepsáním u¾ existujícího souboru) a støe¾te jej (viz soubor <I>install.txt</I> v adresáøi <I>docs</I> pro více informací).<BR><BR>Nezapomeòte se podívat na <A HREF=\"#warn\">varovnou zprávu</A> dole.");
define("S_SETUP4_3","Oznaèit v¹e");
//define("S_SETUP4_4","Jakmile udìláte v¹echny vý¹e uvedené kroky, %s bude plnì pøipraven.");
define("S_SETUP4_4","Once you have completed the steps above, %s is near ready to run.<BR>");
define("S_SETUP4_4m"," Just sets manually three variables at the top of the <I>'chat/admin/mail4admin.lib.php3'</I><BR>script... and have some nice chat discussions.");
define("S_SETUP4_5","Po úspì¹ném rozbìhnutí %su byste mìli odstranit soubor<BR><I>setup.php3</I> a celý adresáø <I>'chat/install'</I> z va¹eho serveru.");
?>