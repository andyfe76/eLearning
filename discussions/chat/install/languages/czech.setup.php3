<?php
// Translation into Czech for setup process
// By Martin Dvorak <jezek2@penguin.cz>

// extra header for charset
$S_Charset = "iso-8859-2";
$S_FontSize = "10";

// Settings for setup.php3 file
define("S_MAIN_1","Tabulky budou vytvo�eny/updatov�ny na lok�ln�m serveru.");
define("S_MAIN_2","Krok 1 hotov: tabulky byly vytvo�eny/updatov�ny.");
define("S_MAIN_3","Krok 1 byl u�ivatelem zru�en.");
define("S_MAIN_4","Nalezeno chyb�j�c� nebo �patn� nastaven�.");
define("S_MAIN_5","Chyb� alespo� jedno z zpo�d�n� pro �i�t�n� datab�ze.");
define("S_MAIN_6","Je vy�adov�na alespo� jedna defaultn� m�stnost.");
define("S_MAIN_7","Jm�no m�stnosti nem��e obsahovat zp�tn� lom�tka (\\).");
define("S_MAIN_8","Chyb� nastaven� �asov�ho p�sma.");
define("S_MAIN_9","Chyb� defaultn� po�et zobrazovan�ch zpr�v a/nebo defaultn� zpo�d�n� mezi ka�d�m obnoven�m zpr�v.");
define("S_MAIN_11","Krok 2 hotov: nastaven� pro vylad�n� chatu bylo registrov�no.");
define("S_MAIN_12","Mus�te napsat va�e p�ihla�ovac� jm�no.");
define("S_MAIN_13","Va�e jm�no nem��e obsahovat mezery, ��rky ani zp�tn� lom�tka (\\).");
define("S_MAIN_14","Mus�te napsat va�e heslo.");
define("S_MAIN_15","P�ezd�vka <I>%s</I> je u� registrov�na a vy jste napsal �patn� heslo.");
define("S_MAIN_16","Krok 3 hotov: v� profil administr�tora byl registrov�n.");
define("S_MAIN_17","Krok 3 byl u�ivatelem zru�en.");
define("S_MAIN_18","- Instalace");

// Settings for setup0.php3 file
define("S_SETUP0_1","Tento skript v�m slou�� k velmi lehk� a rychl� instalaci skriptu %s.");
define("S_SETUP0_2","M��ete jej samoz�ejm� nainstalovat i ru�n�, jestli chcete. Pokud preferujete tuto cesti, mus�to ud�lat toto:");
define("S_SETUP0_3","Vytvo�it tabulky pro %s pou�it�m \"dump\" soubor�, je� naleznete v adres��i <I>'chat/install/database'</I>;");
define("S_SETUP0_4","Upravit soubor <I>config.lib.php3</I> um�st�n� v adres��i <I>'chat/config'</I> pro nastaven� konfigurace;");
define("S_SETUP0_5","Manu�ln� p�idat vy�adovan� informace o administr�torovi do tabulky pro regisrovan� u�ivatele (c_reg_users): va�e p�ezd�vka ve sloupci <I>username</I>, va�e heslo v MD5 hash form� ve sloupci <I>password</I> a slovo 'admin' (bez uvozovek) ve sloupe�ku <I>perms</I>. Jestli chcete, m��ete kdykoli p�idat dal�� informace do ostatn�ch sloupe�k�, ale nen� to pot�eba;");
define("S_SETUP0_5m","Sets three variables at the top of the 'chat/admin/mail4admin.lib.php3' script.");
define("S_SETUP0_6","Pro zah�jen� automatick� instalace, klikn�te pros�m na spodn� tla��tko.");
define("S_SETUP0_7"," Nainstalovat ");
define("S_SETUP0_8","Before updating from an older version of %s you'd better clean the messages table (using the 'chat/admin.php3' script of this old version for example).");

// Settings for setup1.php3 file
define("S_SETUP1_1","Prvn� krok: Konfigurace tabulek");
define("S_SETUP1_2","Nastaven� datab�ze");
define("S_SETUP1_3","Vyberte si v� SQL server:");
define("S_SETUP1_4","Adresa (hostname) va�eho SQL serveru:");
define("S_SETUP1_5","Logick� jm�no datab�ze na tomto serveru:");
define("S_SETUP1_6","(mus� existovat)");
define("S_SETUP1_7","P�ihla�ovac� jm�no do datab�ze:");
define("S_SETUP1_8","P�ihla�ovac� heslo do datab�ze:");
define("S_SETUP1_9","Vytv��en�/Updatov�n� tabulek");
define("S_SETUP1_10","Co chcete, aby tento skript ud�lal?");
define("S_SETUP1_11","Vytvo�it tabulky pro %s");
//define("S_SETUP1_12","Updatovat u� existuj�c� (jen z verz� 0.12.0 a 0.12.1)");
define("S_SETUP1_12","Update existing ones created for 0.12.0 or 0.12.1 releases");
//define("S_SETUP1_13","Neud�lat nic, tabulky jsou u� hotovy (nap�. z verz� 0.13.?)");
define("S_SETUP1_13","Do nothing, tables are already up to date (for 0.13.4 and 0.14.? releases)");
define("S_SETUP1_14","Jm�na tabulek<SUP>*</SUP>, kde...");
define("S_SETUP1_15","budou ukl�d�ny zpr�vy:");
define("S_SETUP1_16","budou ulo�eny profily registerovan�ch u�ivatel�:");
define("S_SETUP1_17","budou ulo�eny jm�na neregistrovan�ch u�ivatel�:");
define("S_SETUP1_18","<SUP>*</SUP>Jm�na, je� nap�ete, mus� b�t shodn� s existuj�c�my tabulky, pokud jste zvolili jejich <BR><B>updatov�n�</B>. Pokud chcete <B>vytvo�it nov� tabulky</B>, jm�na se <B>musej� li�it</B><BR>od u� existuj�c�ch tabulek!<BR>V�echny pol��ka musej� b�t vypln�na, ikdy� nechcete ��dn� tabulky vytvo�it,<BR>proto�e informace budou pot�eba pozd�ji p�i vytv��en� profilu administr�tora.");
define("S_SETUP1_19","OK");
define("S_SETUP1_20","Update existing ones created for 0.13.0 to 0.13.3 releases");
define("S_SETUP1_21","banished users will be stored:");

// Settings for setup2.php3 file
define("S_SETUP2_1","Druh� krok: Vyla�ov�n� nastaven�");
define("S_SETUP2_2","Nastaven� pro �i�t�n� zpr�v a jmen u�ivatel�");
define("S_SETUP2_3","Za kolik hodin mazat zpr�vy:");
define("S_SETUP2_4","Za kolik minut mazat neaktivn� u�ivatele:");
define("S_SETUP2_5","Za kolik dn� mazat neaktivn� u�ivatele, kte�� byly smaz�ni&nbsp;&nbsp;&nbsp;<BR>z tabulky s registrovan�mi u�ivateli (0 = nikdy):");
define("S_SETUP2_6","Defaultn� m�stnosti");
define("S_SETUP2_7","M�stnosti jsou odd�leny ��rkou (,) bez mezer.");
define("S_SETUP2_8","Nastaven� jazyka");
define("S_SETUP2_9","Povolit v�ce jazyk�/znakov�ch sad?");
define("S_SETUP2_10","Defaultn� jazyk:");
define("S_SETUP2_11","Nastaven� bezpe�nosti a omezen�");
define("S_SETUP2_12","Zobrazit odkaz pro administraci u�ivatel� na prvn� str�nce chatu?");
define("S_SETUP2_13","Zobrazit odkaz, je� umo��uje u�ivatel�m mazat jejich vlastn� porfily?");
define("S_SETUP2_15","U�ivatel� mohou p�istupovat...");
define("S_SETUP2_16","...jen do prvn� defaultn� m�stnosti");
define("S_SETUP2_17","...do v�ech defaultn�ch m�stnost�, ale bez mo�nosti vytv��et vlasn�");
define("S_SETUP2_18","...do v�ech m�stnost� a vytv��et nov�");
define("S_SETUP2_19","Vylep�en� zpr�v");
define("S_SETUP2_20","Pou��vat grafick� smail�ky (viz 'chat/lib/smilies.lib.php3')?");
define("S_SETUP2_21","Nechat ��inek tag� pro tu�n�, sklon�n� a podtr�en� text ve zpr�v�ch?");
define("S_SETUP2_22","Zobrazovat neplatn� HTML tagy?");
define("S_SETUP2_23","Defaultn� zobrazen�");
define("S_SETUP2_24","Posun �asu v hodin�ch mezi �asem serveru a va�� zem�:");
define("S_SETUP2_25","Defaultn� po�ad� zpr�v:");
define("S_SETUP2_26","posledn� naho�e");
define("S_SETUP2_27","posledn� dole");
define("S_SETUP2_28","Defaultn� po�et zobrazovan�ch zpr�v:");
define("S_SETUP2_29","Defaultn� prodleva mezi obnovov�n�m zpr�v (v sekund�ch):");
define("S_SETUP2_30","Zobrazovat defaultn� �as u zpr�v.");
define("S_SETUP2_31","Zobrazovat defaultn� notifikace, kdy� u�ivatel vstoup�/odejde.");
define("S_SETUP2_36","Zak�zat �patn� slova (viz 'chat/lib/swearing.lib.php3')?");
define("S_SETUP2_41","Maximum number of messages that an user is allowed to export to an HTML file (0 for none -save command is disabled-, '*' for all available messages, or an integer to limit server charge)?");
define("S_SETUP2_42","Enable the banishment feature?<BR>0 for no, else a positive number to define the number of banishment<BR>day(s) (2000000 for no end, 0.02 for ~half an hour....))");
define("S_SETUP2_43","Registration of users");
define("S_SETUP2_14","Vy�adovat registraci u�ivatel�?");
define("S_SETUP2_44","Generate a password and send it to the e-mail address the user enter in?<BR>This option require the <I>'mail()'</I> PHP function to be enabled, ensure you can use it with the administrator of your PHP server.<BR>Moreover, to have it running you must define 4 settings in the 'chat/lib/mail_validation.lib.php3' script.");
define("S_SETUP2_45","Your PHP configuration seems not to allow the use of the <I>'mail()'</I> function. So you can't choose to generate a password and send it to the user by e-mail.");
define("S_SETUP2_46","ve�ejnou:");
define("S_SETUP2_47","soukromou:");
define("S_SETUP2_48","Send a welcome message to an user logging into the chat (see 'chat/lib/welcome.lib.php3') ?");

// Settings for setup3.php3 file
define("S_SETUP3_1","Profil administr�tora je u� definov�n a v chatu m��e b�t<BR>pouze jeden administr�tor. Modifikujte, pros�m, spodn� pol��ka<BR>pro updatov�n� existuj�c�hi profilu.");
define("S_SETUP3_2","T�et� krok: Registrace administr�tora");
define("S_SETUP3_3","Pol��ka s <SPAN CLASS=error>*</SPAN> jsou vy�adov�na.");
define("S_SETUP3_4","jm�no (p�ezd�vka):");
define("S_SETUP3_5","heslo:");
define("S_SETUP3_6","k�estn� jmen�:");
define("S_SETUP3_7","p��jmen�:");
define("S_SETUP3_8","ovl�dan� jazyky:");
define("S_SETUP3_9","domovsk� str�nka:");
define("S_SETUP3_10","e-mailov� adresa:");
define("S_SETUP3_11","zobrazovat e-mail pomoc� p��kazu /whois");
define("S_SETUP3_12","Vynechat >>");
define("S_SETUP3_13","V� profil m��ete upravit kdykoli po instalaci kliknut�m na odkaz<BR>pro editaci profilu na prvn� stran� chatu.");
define("S_SETUP3_14", "gender");
define("S_SETUP3_15", "male");
define("S_SETUP3_16", "female");

// Settings for setup4.php3 file
define("S_SETUP4_1","�tvrt� krok: Konfigura�n� soubor");
define("S_SETUP4_2","Tady je konfigura�n� soubor vytvo�en� podle v�mi zadan�ch �daj�.<BR><BR>Okop�rujte cel� obsah v�etn� prvn� a posledn� �adky, a vlo�te jej do va�eho obl�ben�ho textov�ho editoru (notepad �i vi). Pot� *mus�te* vyplnit heslo do datab�ze na 7. ��dce a ulo�it soubor jako <I>config.lib.php3</I>.<BR><BR>D�kladn� zkontrolujte jestli <B>nen� ��dn� pr�zdn� ��dka ani mezera, ani p�ed otev�rac�m tagem PHP k�du ani po ukon�ovac�m</B>, pot� nahrajte konfigura�n� soubor na v� server do adres��e <I>config</I> (p�eps�n�m u� existuj�c�ho souboru) a st�e�te jej (viz soubor <I>install.txt</I> v adres��i <I>docs</I> pro v�ce informac�).<BR><BR>Nezapome�te se pod�vat na <A HREF=\"#warn\">varovnou zpr�vu</A> dole.");
define("S_SETUP4_3","Ozna�it v�e");
//define("S_SETUP4_4","Jakmile ud�l�te v�echny v��e uveden� kroky, %s bude pln� p�ipraven.");
define("S_SETUP4_4","Once you have completed the steps above, %s is near ready to run.<BR>");
define("S_SETUP4_4m"," Just sets manually three variables at the top of the <I>'chat/admin/mail4admin.lib.php3'</I><BR>script... and have some nice chat discussions.");
define("S_SETUP4_5","Po �sp�n�m rozb�hnut� %su byste m�li odstranit soubor<BR><I>setup.php3</I> a cel� adres�� <I>'chat/install'</I> z va�eho serveru.");
?>