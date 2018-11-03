<?php
// Translation into french language for setup process
// By Lo�c Chapeaux <loic-info@netcourrier.com>

// extra header for charset
$S_Charset = "iso-8859-1";
$S_FontSize = "10";

// Settings for setup.php3 file
define("S_MAIN_1","Les tables seront cr��es/mises � jour sur un serveur local.");
define("S_MAIN_2","Etape 1 achev�e : les tables ont �t� cr��es/mises � jour.");
define("S_MAIN_3","Etape 1 ignor�e conform�ment � votre choix.");
define("S_MAIN_4","Certaines r�ponses sont manquantes ou invalides.");
define("S_MAIN_5","Au moins l'un des d�lais avant effacement des donn�es est manquant.");
define("S_MAIN_6","Il vous faut d�finir au moins un salon par d�faut.");
define("S_MAIN_7","Un nom de salon ne peut contenir d'anti-slash (\\).");
define("S_MAIN_8","Le d�calage entre l'heure serveur et votre fuseau horaire est manquant.");
define("S_MAIN_9","Le nombre de messages � afficher par d�faut et/ou le d�lai entre deux rafra�chissements est(sont) manquants.");
define("S_MAIN_11","Etape 2 achev�e : vos choix concernant le fonctionnement du chat ont �t� enregistr�s.");
define("S_MAIN_12","Vous devez choisir un pseudo.");
define("S_MAIN_13","Votre pseudo ne peu contenir ni espace, ni virgule, ni anti-slash (\\).");
define("S_MAIN_14","Vous devez choisir un mot de passe.");
define("S_MAIN_15","Le pseudo <I>%s</I> est d�j� r�serv� et vous n'avez pas entr� le mot de passe qui lui est associ�.");
define("S_MAIN_16","Etape 3 achev�e : votre profil a �t� enregistr� comme celui de l'administrateur.");
define("S_MAIN_17","Etape 4 ignor�e conform�ment � votre choix.");
define("S_MAIN_18","- Installation");

// Settings for setup0.php3 file
define("S_SETUP0_1","Ce script a pour but de faciliter l'installation de %s sur votre site.");
define("S_SETUP0_2","Mais tout cela peut aussi �tre fait manuellement. Dans le cas o� vous pr�f�reriez cette m�thode, il vous faudrait&nbsp;:");
define("S_SETUP0_3","Cr�er les tables n�cessaires � %s en vous aidant des \"dump files\" situ�es dans le sous-r�pertoire <I>'chat/install/database'</I>&nbsp;;");
define("S_SETUP0_4","Compl�ter le fichier <I>config.lib.php3</I> situ� dans le sous-r�pertoire <I>'chat/config'</I> afin de d�finir les param�tres de %s&nbsp;;");
define("S_SETUP0_5","Cr�er le profil de l'administrateur dans la table des utilisateurs enregistr�s (c_reg_users)&nbsp;: votre pseudo dans la colonne <I>username</I>, le MD5 hash de votre mot de passe dans la colonne <I>password</I> et le mot 'admin' (sans quotes) dans la colonne <I>perms</I>. Vous pouvez bien s�r compl�ter le reste de l'enregistrement mais ce n'est pas obligatoire ;");
define("S_SETUP0_5m","Renseigner trois variables au d�but du script 'chat/admin/mail4admin.lib.php3'.");
define("S_SETUP0_6","Pour poursuivre l'installation avec ce script cliquez sur le bouton ci-dessous.");
define("S_SETUP0_7"," Continuer ");
define("S_SETUP0_8","Avant de mettre � jour une ancienne version de %s il est conseill� de vider la table contenant les messages (� l'aide du script 'chat/admin.php3' de cette ancienne version par exemple).");

// Settings for setup1.php3 file
define("S_SETUP1_1","Premi�re �tape : Configuration des tables");
define("S_SETUP1_2","Param�tres d'acc�s � la base");
define("S_SETUP1_3","S�lectionnez votre type de serveur SQL :");
define("S_SETUP1_4","\"Hostname\" de votre serveur SQL :");
define("S_SETUP1_5","Nom de la base sur ce serveur :");
define("S_SETUP1_6","(elle doit exister)");
define("S_SETUP1_7","Votre login pour acc�der � cette base :");
define("S_SETUP1_8","Votre mot de passe pour acc�der � cette base :");
define("S_SETUP1_9","Cr�ation/mise � jour des tables");
define("S_SETUP1_10","Que voulez-vous faire ?");
define("S_SETUP1_11","Cr�er les tables n�cessaires � %s");
define("S_SETUP1_12","Mettre � jour des tables cr��es pour les versions 0.12.0 et 0.12.1");
define("S_SETUP1_13","Ne rien faire, les tables sont d�j� � jour (pour les version 0.13.4 et 0.14.?)");
define("S_SETUP1_14","Noms des tables<SUP>*</SUP> dans lesquelles seront stock�s...");
define("S_SETUP1_15","les messages :");
define("S_SETUP1_16","les profils des utilisateurs enregistr�s :");
define("S_SETUP1_17","les utilisateurs connect�s :");
define("S_SETUP1_18","<SUP>*</SUP>Les noms des tables que vous entrez doivent (ne doivent pas) correspondre � des tables existantes<BR>si vous avez choisi de les mettre � jour (de les cr�er).<BR>Tous ces champs doivent imp�rativement �tre compl�t�s, m�me si vous choisissez de ne rien faire<BR>faire par le script : les noms des tables seront n�cessaires pour cr�er le profil de l'administrateur<BR>un peu plus tard.");
define("S_SETUP1_19","OK");
define("S_SETUP1_20","Mettre � jour des tables cr��es pour les versions 0.13.0 � 0.13.3");
define("S_SETUP1_21","les utilisateurs bannis :");

// Settings for setup2.php3 file
define("S_SETUP2_1","Deuxi�me �tape : configuration avanc�e du chat");
define("S_SETUP2_2","D�poussi�rage des tables");
define("S_SETUP2_3","D�lai en heure au bout duquel les messages seront effac�s :");
define("S_SETUP2_4","D�lai en minutes au bout duquel les utilisateurs inactifs&nbsp;&nbsp;&nbsp;<BR>seront d�connect�s :");
define("S_SETUP2_5","Nombre de jours avant que les utilisateurs enregistr�s&nbsp;&nbsp;&nbsp;<BR>inactifs voient leur profil d�truit (0 pour jamais) :");
define("S_SETUP2_6","Salons par d�faut � cr�er");
define("S_SETUP2_7","S�parez-les avec une virgule sans espace (,).");
define("S_SETUP2_8","Param�tres linguistiques");
define("S_SETUP2_9","Version multilingue ?");
define("S_SETUP2_10","Langue par d�faut :");
define("S_SETUP2_11","S�curisation et restrictions");
define("S_SETUP2_12","Mettre un lien vers le script d'administration sur la page d'accueil ?");
define("S_SETUP2_13","Permettre aux utilisateurs d'effacer leur profil ?");
define("S_SETUP2_15","Un utilisateur aura acc�s...");
define("S_SETUP2_16","... au premier des salons par d�faut seulement");
define("S_SETUP2_17","... � tous les salons par d�faut mais ne pourra en cr�er un");
define("S_SETUP2_18","... � tous les salons par d�faut et pourra de plus en cr�er");
define("S_SETUP2_19","Options concernant les messages");
define("S_SETUP2_20","Utiliser des smilies graphiques (voir 'chat/lib/smilies.lib.php3') ?");
define("S_SETUP2_21","Tenir compte des tags gras, italique et soulign� dans les messages ?");
define("S_SETUP2_22","Afficher les tags HTML en clair lorsqu'ils sont sans effet ?");
define("S_SETUP2_23","Affichage par d�faut");
define("S_SETUP2_24","Ecart en heures pleines entre le temps serveur et votre fuseau horaire :");
define("S_SETUP2_25","Ordre d'affichage des messages par d�faut :");
define("S_SETUP2_26","le dernier en haut de la page");
define("S_SETUP2_27","le dernier en bas de la page");
define("S_SETUP2_28","Nombre de messages � afficher par d�faut :");
define("S_SETUP2_29","D�lai de rafra�chissement du cadre contenant les messages par d�faut :");
define("S_SETUP2_30","Par d�faut, afficher l'heure d'�mission des messages.");
define("S_SETUP2_31","Par d�faut, afficher les notifications d'entr�e/sortie d'utilisateurs.");
define("S_SETUP2_36","Interdire certains mots (voir 'chat/lib/swearing.lib.php3') ?");
define("S_SETUP2_41","Nombre maximal de messages qu'un utilisateur pourra sauvegarder dans un fichier HTML (0 pour aucun -la commande save devient indisponible-, '*' pour tous les messages disponibles, ou bien une valeur quelconque pour limiter la charge du serveur) ?");
define("S_SETUP2_42","Activer la fonctionnalit� qui permet de bannir un utiliseur ?<BR>0 pour non, sinon un nombre strictement positif pour d�finir le nombre<BR>de jour de bannissement (2000000 pour indiquer qu'il n'a pas de terme,<BR>0.01 pour ~1/4 d'heure....)");
define("S_SETUP2_43","Enregistrement des utilisateurs");
define("S_SETUP2_14","Enregistrement des utilisateurs requis ?");
define("S_SETUP2_44","Choisir l'option qui consiste � g�n�rer un mot de passe et � l'envoyer � l'adresse e-mail sp�cifi�e par l'utilisateur ?<BR>Cette option fait appel � la fonction <I>'mail()'</I> de PHP, assurez-vous d'y avoir acc�s aupr�s du gestionnaire de votre serveur PHP avant de la retenir.<BR>De plus son utilisation n�cessite de votre part la d�finition de 4 param�tres au d�but du script 'chat/lib/mail_validation.lib.php3'.");
define("S_SETUP2_45","La configuration de votre serveur PHP ne semble pas permettre l'utilisation de la fonction <I>mail()</I>. En cons�quence vous ne pouvez choisir l'option qui consiste � g�n�rer un mot de passe et � l'envoyer � l'adresse e-mail sp�cifi�e par l'utilisateur.");
define("S_SETUP2_46","publics :");
define("S_SETUP2_47","priv�s :");
define("S_SETUP2_48","Envoyer un message d'accueil � un utilisateur entrant sur le chat (voir 'chat/lib/welcome.lib.php3') ?");

// Settings for setup3.php3 file
define("S_SETUP3_1","Un administrateur existe d�j� et il ne peut y en avoir<BR>qu'un. Si vous modifiez les champs ci-dessous, le profil<BR>existant sera mis � jour.");
define("S_SETUP3_2","Troisi�me �tape: Enregistrement du profil de l'administrateur");
define("S_SETUP3_3","Les champs suivis d'une <SPAN CLASS=error>*</SPAN> doivent �tre renseign�s.");
define("S_SETUP3_4","login (pseudo) :");
define("S_SETUP3_5","mot de passe :");
define("S_SETUP3_6","pr�nom :");
define("S_SETUP3_7","nom :");
define("S_SETUP3_8","langues parl�es :");
define("S_SETUP3_9","site web :");
define("S_SETUP3_10","addresse e-mail :");
define("S_SETUP3_11","e-mail visible via la commande /whois");
define("S_SETUP3_12","Ignorer >>");
define("S_SETUP3_13","Au m�me titre que n'importe quel utilisateur, vous pourrez<BR> modifier ce profil plus tard en cliquant sur le lien idoine<BR>situ� sur la page d'accueil de %s.");
define("S_SETUP3_14", "sexe");
define("S_SETUP3_15", "masculin");
define("S_SETUP3_16", "f�minin");

// Settings for setup4.php3 file
define("S_SETUP4_1","Quatri�me �tape : Le fichier de configuration");
define("S_SETUP4_2","Voici votre fichier de configuration personnalis�.<BR><BR>Il vous suffit maintenant de copier enti�rement le contenu de la boite ci-dessous dans votre �diteur de texte pr�f�r� (NotePad, Vi...), de compl�ter le mot de passe pour l'acc�s � la base (ligne 7), et d'enregistrer ce fichier sous le nom <I>config.lib.php3</I>.<BR><BR>Assurez-vous qu'il n'y a <B>ni ligne vide ni espace, ni avant le tag php ouvrant ni apr�s le tag php fermant</B>, puis transf�rez le fichier de configuration sur votre serveur dans le r�pertoire <I>config</I> (�crasez le fichier existant) et s�curisez son acc�s (cf. le fichier <I>install.txt</I> dans le sous-r�pertoire <I>docs</I> pour des informations plus compl�tes).<BR><BR>Enfin n'oubliez pas de lire l'<A HREF=\"#warn\">avertissement</A> plus bas.");
define("S_SETUP4_3","Selectionner tout");
define("S_SETUP4_4","Une fois tout ceci fait, %s sera presque pr�t � l'emploi.<BR>");
define("S_SETUP4_4m","Il ne vous restera qu'� renseigner trois variables au d�but du script<BR><I>'chat/admin/mail4admin.lib.php3'</I>... et � vous lancer dans quelque<BR>passionnante discussion.");
define("S_SETUP4_5","Apr�s vous �tre assur� du bon fonctionnement de %s, il vous est<BR>conseill� de d�truire le fichier <I>setup.php3</I> ainsi que tout le sous-r�pertoire<BR><I>'chat/install'</I> de votre serveur.");
?>