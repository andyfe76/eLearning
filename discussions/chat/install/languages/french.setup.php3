<?php
// Translation into french language for setup process
// By Loïc Chapeaux <loic-info@netcourrier.com>

// extra header for charset
$S_Charset = "iso-8859-1";
$S_FontSize = "10";

// Settings for setup.php3 file
define("S_MAIN_1","Les tables seront créées/mises à jour sur un serveur local.");
define("S_MAIN_2","Etape 1 achevée : les tables ont été créées/mises à jour.");
define("S_MAIN_3","Etape 1 ignorée conformément à votre choix.");
define("S_MAIN_4","Certaines réponses sont manquantes ou invalides.");
define("S_MAIN_5","Au moins l'un des délais avant effacement des données est manquant.");
define("S_MAIN_6","Il vous faut définir au moins un salon par défaut.");
define("S_MAIN_7","Un nom de salon ne peut contenir d'anti-slash (\\).");
define("S_MAIN_8","Le décalage entre l'heure serveur et votre fuseau horaire est manquant.");
define("S_MAIN_9","Le nombre de messages à afficher par défaut et/ou le délai entre deux rafraîchissements est(sont) manquants.");
define("S_MAIN_11","Etape 2 achevée : vos choix concernant le fonctionnement du chat ont été enregistrés.");
define("S_MAIN_12","Vous devez choisir un pseudo.");
define("S_MAIN_13","Votre pseudo ne peu contenir ni espace, ni virgule, ni anti-slash (\\).");
define("S_MAIN_14","Vous devez choisir un mot de passe.");
define("S_MAIN_15","Le pseudo <I>%s</I> est déjà réservé et vous n'avez pas entré le mot de passe qui lui est associé.");
define("S_MAIN_16","Etape 3 achevée : votre profil a été enregistré comme celui de l'administrateur.");
define("S_MAIN_17","Etape 4 ignorée conformément à votre choix.");
define("S_MAIN_18","- Installation");

// Settings for setup0.php3 file
define("S_SETUP0_1","Ce script a pour but de faciliter l'installation de %s sur votre site.");
define("S_SETUP0_2","Mais tout cela peut aussi être fait manuellement. Dans le cas où vous préfèreriez cette méthode, il vous faudrait&nbsp;:");
define("S_SETUP0_3","Créer les tables nécessaires à %s en vous aidant des \"dump files\" situées dans le sous-répertoire <I>'chat/install/database'</I>&nbsp;;");
define("S_SETUP0_4","Compléter le fichier <I>config.lib.php3</I> situé dans le sous-répertoire <I>'chat/config'</I> afin de définir les paramètres de %s&nbsp;;");
define("S_SETUP0_5","Créer le profil de l'administrateur dans la table des utilisateurs enregistrés (c_reg_users)&nbsp;: votre pseudo dans la colonne <I>username</I>, le MD5 hash de votre mot de passe dans la colonne <I>password</I> et le mot 'admin' (sans quotes) dans la colonne <I>perms</I>. Vous pouvez bien sûr compléter le reste de l'enregistrement mais ce n'est pas obligatoire ;");
define("S_SETUP0_5m","Renseigner trois variables au début du script 'chat/admin/mail4admin.lib.php3'.");
define("S_SETUP0_6","Pour poursuivre l'installation avec ce script cliquez sur le bouton ci-dessous.");
define("S_SETUP0_7"," Continuer ");
define("S_SETUP0_8","Avant de mettre à jour une ancienne version de %s il est conseillé de vider la table contenant les messages (à l'aide du script 'chat/admin.php3' de cette ancienne version par exemple).");

// Settings for setup1.php3 file
define("S_SETUP1_1","Première étape : Configuration des tables");
define("S_SETUP1_2","Paramètres d'accès à la base");
define("S_SETUP1_3","Sélectionnez votre type de serveur SQL :");
define("S_SETUP1_4","\"Hostname\" de votre serveur SQL :");
define("S_SETUP1_5","Nom de la base sur ce serveur :");
define("S_SETUP1_6","(elle doit exister)");
define("S_SETUP1_7","Votre login pour accéder à cette base :");
define("S_SETUP1_8","Votre mot de passe pour accéder à cette base :");
define("S_SETUP1_9","Création/mise à jour des tables");
define("S_SETUP1_10","Que voulez-vous faire ?");
define("S_SETUP1_11","Créer les tables nécessaires à %s");
define("S_SETUP1_12","Mettre à jour des tables créées pour les versions 0.12.0 et 0.12.1");
define("S_SETUP1_13","Ne rien faire, les tables sont déjà à jour (pour les version 0.13.4 et 0.14.?)");
define("S_SETUP1_14","Noms des tables<SUP>*</SUP> dans lesquelles seront stockés...");
define("S_SETUP1_15","les messages :");
define("S_SETUP1_16","les profils des utilisateurs enregistrés :");
define("S_SETUP1_17","les utilisateurs connectés :");
define("S_SETUP1_18","<SUP>*</SUP>Les noms des tables que vous entrez doivent (ne doivent pas) correspondre à des tables existantes<BR>si vous avez choisi de les mettre à jour (de les créer).<BR>Tous ces champs doivent impérativement être complétés, même si vous choisissez de ne rien faire<BR>faire par le script : les noms des tables seront nécessaires pour créer le profil de l'administrateur<BR>un peu plus tard.");
define("S_SETUP1_19","OK");
define("S_SETUP1_20","Mettre à jour des tables créées pour les versions 0.13.0 à 0.13.3");
define("S_SETUP1_21","les utilisateurs bannis :");

// Settings for setup2.php3 file
define("S_SETUP2_1","Deuxième étape : configuration avancée du chat");
define("S_SETUP2_2","Dépoussiérage des tables");
define("S_SETUP2_3","Délai en heure au bout duquel les messages seront effacés :");
define("S_SETUP2_4","Délai en minutes au bout duquel les utilisateurs inactifs&nbsp;&nbsp;&nbsp;<BR>seront déconnectés :");
define("S_SETUP2_5","Nombre de jours avant que les utilisateurs enregistrés&nbsp;&nbsp;&nbsp;<BR>inactifs voient leur profil détruit (0 pour jamais) :");
define("S_SETUP2_6","Salons par défaut à créer");
define("S_SETUP2_7","Séparez-les avec une virgule sans espace (,).");
define("S_SETUP2_8","Paramètres linguistiques");
define("S_SETUP2_9","Version multilingue ?");
define("S_SETUP2_10","Langue par défaut :");
define("S_SETUP2_11","Sécurisation et restrictions");
define("S_SETUP2_12","Mettre un lien vers le script d'administration sur la page d'accueil ?");
define("S_SETUP2_13","Permettre aux utilisateurs d'effacer leur profil ?");
define("S_SETUP2_15","Un utilisateur aura accès...");
define("S_SETUP2_16","... au premier des salons par défaut seulement");
define("S_SETUP2_17","... à tous les salons par défaut mais ne pourra en créer un");
define("S_SETUP2_18","... à tous les salons par défaut et pourra de plus en créer");
define("S_SETUP2_19","Options concernant les messages");
define("S_SETUP2_20","Utiliser des smilies graphiques (voir 'chat/lib/smilies.lib.php3') ?");
define("S_SETUP2_21","Tenir compte des tags gras, italique et souligné dans les messages ?");
define("S_SETUP2_22","Afficher les tags HTML en clair lorsqu'ils sont sans effet ?");
define("S_SETUP2_23","Affichage par défaut");
define("S_SETUP2_24","Ecart en heures pleines entre le temps serveur et votre fuseau horaire :");
define("S_SETUP2_25","Ordre d'affichage des messages par défaut :");
define("S_SETUP2_26","le dernier en haut de la page");
define("S_SETUP2_27","le dernier en bas de la page");
define("S_SETUP2_28","Nombre de messages à afficher par défaut :");
define("S_SETUP2_29","Délai de rafraîchissement du cadre contenant les messages par défaut :");
define("S_SETUP2_30","Par défaut, afficher l'heure d'émission des messages.");
define("S_SETUP2_31","Par défaut, afficher les notifications d'entrée/sortie d'utilisateurs.");
define("S_SETUP2_36","Interdire certains mots (voir 'chat/lib/swearing.lib.php3') ?");
define("S_SETUP2_41","Nombre maximal de messages qu'un utilisateur pourra sauvegarder dans un fichier HTML (0 pour aucun -la commande save devient indisponible-, '*' pour tous les messages disponibles, ou bien une valeur quelconque pour limiter la charge du serveur) ?");
define("S_SETUP2_42","Activer la fonctionnalité qui permet de bannir un utiliseur ?<BR>0 pour non, sinon un nombre strictement positif pour définir le nombre<BR>de jour de bannissement (2000000 pour indiquer qu'il n'a pas de terme,<BR>0.01 pour ~1/4 d'heure....)");
define("S_SETUP2_43","Enregistrement des utilisateurs");
define("S_SETUP2_14","Enregistrement des utilisateurs requis ?");
define("S_SETUP2_44","Choisir l'option qui consiste à générer un mot de passe et à l'envoyer à l'adresse e-mail spécifiée par l'utilisateur ?<BR>Cette option fait appel à la fonction <I>'mail()'</I> de PHP, assurez-vous d'y avoir accès auprès du gestionnaire de votre serveur PHP avant de la retenir.<BR>De plus son utilisation nécessite de votre part la définition de 4 paramètres au début du script 'chat/lib/mail_validation.lib.php3'.");
define("S_SETUP2_45","La configuration de votre serveur PHP ne semble pas permettre l'utilisation de la fonction <I>mail()</I>. En conséquence vous ne pouvez choisir l'option qui consiste à générer un mot de passe et à l'envoyer à l'adresse e-mail spécifiée par l'utilisateur.");
define("S_SETUP2_46","publics :");
define("S_SETUP2_47","privés :");
define("S_SETUP2_48","Envoyer un message d'accueil à un utilisateur entrant sur le chat (voir 'chat/lib/welcome.lib.php3') ?");

// Settings for setup3.php3 file
define("S_SETUP3_1","Un administrateur existe déjà et il ne peut y en avoir<BR>qu'un. Si vous modifiez les champs ci-dessous, le profil<BR>existant sera mis à jour.");
define("S_SETUP3_2","Troisième étape: Enregistrement du profil de l'administrateur");
define("S_SETUP3_3","Les champs suivis d'une <SPAN CLASS=error>*</SPAN> doivent être renseignés.");
define("S_SETUP3_4","login (pseudo) :");
define("S_SETUP3_5","mot de passe :");
define("S_SETUP3_6","prénom :");
define("S_SETUP3_7","nom :");
define("S_SETUP3_8","langues parlées :");
define("S_SETUP3_9","site web :");
define("S_SETUP3_10","addresse e-mail :");
define("S_SETUP3_11","e-mail visible via la commande /whois");
define("S_SETUP3_12","Ignorer >>");
define("S_SETUP3_13","Au même titre que n'importe quel utilisateur, vous pourrez<BR> modifier ce profil plus tard en cliquant sur le lien idoine<BR>situé sur la page d'accueil de %s.");
define("S_SETUP3_14", "sexe");
define("S_SETUP3_15", "masculin");
define("S_SETUP3_16", "féminin");

// Settings for setup4.php3 file
define("S_SETUP4_1","Quatrième étape : Le fichier de configuration");
define("S_SETUP4_2","Voici votre fichier de configuration personnalisé.<BR><BR>Il vous suffit maintenant de copier entièrement le contenu de la boite ci-dessous dans votre éditeur de texte préféré (NotePad, Vi...), de compléter le mot de passe pour l'accès à la base (ligne 7), et d'enregistrer ce fichier sous le nom <I>config.lib.php3</I>.<BR><BR>Assurez-vous qu'il n'y a <B>ni ligne vide ni espace, ni avant le tag php ouvrant ni après le tag php fermant</B>, puis transférez le fichier de configuration sur votre serveur dans le répertoire <I>config</I> (écrasez le fichier existant) et sécurisez son accès (cf. le fichier <I>install.txt</I> dans le sous-répertoire <I>docs</I> pour des informations plus complètes).<BR><BR>Enfin n'oubliez pas de lire l'<A HREF=\"#warn\">avertissement</A> plus bas.");
define("S_SETUP4_3","Selectionner tout");
define("S_SETUP4_4","Une fois tout ceci fait, %s sera presque prêt à l'emploi.<BR>");
define("S_SETUP4_4m","Il ne vous restera qu'à renseigner trois variables au début du script<BR><I>'chat/admin/mail4admin.lib.php3'</I>... et à vous lancer dans quelque<BR>passionnante discussion.");
define("S_SETUP4_5","Après vous être assuré du bon fonctionnement de %s, il vous est<BR>conseillé de détruire le fichier <I>setup.php3</I> ainsi que tout le sous-répertoire<BR><I>'chat/install'</I> de votre serveur.");
?>