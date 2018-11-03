<?php
// Translation into Italian for setup process
// By Bartolotta Gioachino <develoeprs@rockitalia.com> & Silvia M. Carrassi <silvia@ladysilvia.net>

// extra header for charset
$S_Charset = "iso-8859-1";
$S_FontSize = "10";

// Settings for setup.php3 file
define("S_MAIN_1","Le tabelle saranno create/aggiornate su un server locale.");
define("S_MAIN_2","Step 1 completato: Le tabelle sono state create/aggiornate.");
define("S_MAIN_3","Step 1 saltato dall'utente.");
define("S_MAIN_4","Trovati settaggi mancanti o invalidi.");
define("S_MAIN_5","Manca almeno uno dei ritardi di pulizia delle tabelle.");
define("S_MAIN_6","E' richiesta almeno un'area di Default.");
define("S_MAIN_7","Il nome dell'area non può contenere backslashes (\\).");
define("S_MAIN_8","Manca l'offset della zona oraria.");
define("S_MAIN_9","Il numero dei messaggi di default da mostrare e/o il timeout di default tra un aggiornamento e l'altro sono mancanti.");
define("S_MAIN_11","Step 2 completato: le impostazioni sono state registrate.");
define("S_MAIN_12","Dovete inserire un nome di login.");
define("S_MAIN_13","Il tuo nome non può contenere spazi, virgole o backslash (\\).");
define("S_MAIN_14","Dovete inserire la vostra password.");
define("S_MAIN_15","Il nick <I>%s</I> è già registrato e la password che avete inserito è errata.");
define("S_MAIN_16","Step 3 completato: il vostro profilo d'amministratore è stato registrato.");
define("S_MAIN_17","Step 3 saltato dall'utente.");
define("S_MAIN_18","- Setup");

// Settings for setup0.php3 file
define("S_SETUP0_1","Questo script vi permette di installare facilmente %s.");
define("S_SETUP0_2","Potete fare questo anche manualmente se lo desiderate. Se preferite farlo in questo modo dovete:");
define("S_SETUP0_3","Creare le tabelle per %s utilizzando i files dump allocati nella directory <I>'chat/install/database'</I>;");
define("S_SETUP0_4","Editate il file <I>config.lib.php3</I> allocato nella directory <I>'chat/config'</I>per definirne le impostazioni %s;");
define("S_SETUP0_5","Aggiungete manualmente le informazioni richieste per l'Admin dentro la tabella degli utenti registrati (c_reg_users): Il vostro nick nella colonna <I>username</I>, MD5 hash della password attuale nella colonna <I>password</I> e la parola 'admin' (senza apici) nella colonna <I>perms</I>. Se volete potete aggiungere informazioni supplementari nelle altre colonne ma non è obbligatorio;");
define("S_SETUP0_5m","Sets three variables at the top of the 'chat/admin/mail4admin.lib.php3' script.");
define("S_SETUP0_6","Per continuare con il setup automatizzato cliccate il pulsante sotto, grazie.");
define("S_SETUP0_7"," Vai ");
define("S_SETUP0_8","Prima di aggiornare da una versione più vecchia di %s sarebbe meglio svuotare la tabella dei messaggi (utilizzando lo script 'chat/admin.php3' della versione più vecchia per esempio.).");

// Settings for setup1.php3 file
define("S_SETUP1_1","Primo step: Configurazione tabelle");
define("S_SETUP1_2","Impostazioni Database");
define("S_SETUP1_3","Scegliete il vostro gestore DBMS:");
define("S_SETUP1_4","Nome host del vostro server SQL:");
define("S_SETUP1_5","Nome del database sul server:");
define("S_SETUP1_6","(deve esistere)");
define("S_SETUP1_7","Nome utente del database:");
define("S_SETUP1_8","Password utente del database:");
define("S_SETUP1_9","Creazione/Aggiornamento Tabelle");
define("S_SETUP1_10","Cosa vuoi che faccia questo script ?");
define("S_SETUP1_11","Crea le tabelle per %s");
define("S_SETUP1_12","Aggiorna le tabelle esistenti create per le versioni 0.12.0 o 0.12.1");
define("S_SETUP1_13","Non fare nulla le tabelle sono già aggiornate (per le versioni 0.13.4 e 0.14.?)");
define("S_SETUP1_14","Nome delle tabelle<SUP>*</SUP> dove...");
define("S_SETUP1_15","i messaggi saranno depositati:");
define("S_SETUP1_16","i profili degli utenti registrati saranno depositati:");
define("S_SETUP1_17","i dati degli utenti loggati saranno depositati:");
define("S_SETUP1_18","<SUP>*</SUP>Nomi delle tabelle che inserisci devono corrispondere alle tabelle esistenti se scegli di <b><br>aggiornarle</B>. Se vuoi <b>creare delle nuove tabelle</b> il nome <B>non deve</B> essere lo<BR>stesso di quelle esistenti!<BR>Tutti i campi devono essere completati, anche se non vuoi che lo script faccia <BR>nulla poichè tutte le informazioni saranno necessarie quando più tardi dovrai creare <br>il profilo dell'amministratore.");
define("S_SETUP1_19","OK");
define("S_SETUP1_20","Aggiorna le tabelle esistenti create per le versioni dalla 0.13.0 alla 0.13.3");
define("S_SETUP1_21","i dati degli utenti banditi (bannati) saranno depositati:");

// Settings for setup2.php3 file
define("S_SETUP2_1","Secondo step: Opzioni accurate");
define("S_SETUP2_2","Pulisci impostazioni per messaggi e nomi utente");
define("S_SETUP2_3","Numero di ore prima che i messaggi vengano cancellati:");
define("S_SETUP2_4","Numero di minuti prima che gli utenti inattivi vengano cancellati:");
define("S_SETUP2_5","Numero di giorni prima che gli utenti non attivi vengano cancellati &nbsp;&nbsp;&nbsp;<BR>dalla tabella di registrazione (0 per disabilitare):");
define("S_SETUP2_6","Aree di default da creare");
define("S_SETUP2_7","Separate da virgola (,) senza spazi.");
define("S_SETUP2_8","Impostazioni di linguaggio");
define("S_SETUP2_9","Consenti il supporto multi-languages/charset ?");
define("S_SETUP2_10","Linguaggio di Default:");
define("S_SETUP2_11","Sicurezza e restrizioni");
define("S_SETUP2_12","Mostra link per le risorse d'amministrazione nella schermata di avvio ?");
define("S_SETUP2_13","Mostra link che consente all'utente di cancellare il proprio profilo ?");
define("S_SETUP2_15","L'utente può accedere...");
define("S_SETUP2_16","...solamente alla prima area all'interno di quelle di default");
define("S_SETUP2_17","...tutte le aree definite come default ma non può creare un'area");
define("S_SETUP2_18","...tutte le aree e può crearne nuove");
define("S_SETUP2_19","Opzioni messaggi");
define("S_SETUP2_20","Usa gli smilies grafici (vedi 'chat/lib/smilies.lib.php3') ?");
define("S_SETUP2_21","Possibile utilizzo dei tag per grassetto, corsivo e sottolineato nei messaggi ?");
define("S_SETUP2_22","Mostra tags HTML scartati ?");
define("S_SETUP2_23","Impostazioni di visualizzazione di Default");
define("S_SETUP2_24","Differenza, in ore, fra l'ora del server e quella del posto in cui vi trovate.");
define("S_SETUP2_25","Ordine di default dei messaggi:");
define("S_SETUP2_26","Ultimo in cima");
define("S_SETUP2_27","Ultimo in basso");
define("S_SETUP2_28","Numero di default di messaggi da visualizzare:");
define("S_SETUP2_29","Timeout di default durante l'aggiornamento del frame dei messaggi (in secondi):");
define("S_SETUP2_30","Mostra data e ora per default.");
define("S_SETUP2_31","Mostra di default notifiche sull'arrivo/uscita degli utenti.");
define("S_SETUP2_36","Controlla per le parolacce (vedi 'chat/lib/swearing.lib.php3') ?");
define("S_SETUP2_41","Numero massimo di messaggi che a un utente è consentito esportare su un file HTML (0 per nessuno -Il comando save viene disabilitato-, '*' per tutti i messaggi disponibili, o un numero intero per limitare il carico del server)?");
define("S_SETUP2_42","Abilita l'opzione di banditura?<BR>0 per no, altrimenti un numero positivo per definire il numero dei giorni di bandita<BR> (2000000 per infinito, 0.02 per mezz'ora....))");
define("S_SETUP2_43","Registrazione degli utenti");
define("S_SETUP2_14","Richiedi registrazione?");
define("S_SETUP2_44","Genera una password e inviala all'indirizzo email che l'utente ha inserirto?<BR>Questa opzione richiede che la funzione PHP <I>'mail()'</I> sia abilitata , assicurati di poterla utilizzare chiedendo magari all'amministratore del tuo server.<BR>Inoltre per farla funzionare dovete definire 4 parametri nello script 'chat/lib/mail_validation.lib.php3'.");
define("S_SETUP2_45","La Vostra configurazione di PHP non sembra consentire l'uso della funzione <I>'mail()'</I>. Così non puoi scegliere di generare una password e mandarla all'utente via e-mail.");
define("S_SETUP2_46","pubbliche:");
define("S_SETUP2_47","private:");
define("S_SETUP2_48","Send a welcome message to an user logging into the chat (see 'chat/lib/welcome.lib.php3') ?");

// Settings for setup3.php3 file
define("S_SETUP3_1","E' stato già definito un profilo per l'Amministratore e soltanto<BR> un amministratore può esistere. Per favore modificate i campi <BR>sotto per aggiornare il profilo esistente.");
define("S_SETUP3_2","Terzo step: Registrazione Amministratore");
define("S_SETUP3_3","I campi contrassegnati con un <SPAN CLASS=error>*</SPAN> sono obbligatori.");
define("S_SETUP3_4","login (nick):");
define("S_SETUP3_5","password:");
define("S_SETUP3_6","Nome:");
define("S_SETUP3_7","Cognome:");
define("S_SETUP3_8","Lingue parlate:");
define("S_SETUP3_9","Sito web:");
define("S_SETUP3_10","Indirizzo e-mail:");
define("S_SETUP3_11","Mostra e-mail tramite il comando /whois");
define("S_SETUP3_12","Salta >>");
define("S_SETUP3_13","Potrete modificare in seguito il Vostro profilo cliccando sul link per l'editing dei profili<BR>profile nella pagina di inizio di %s.");
define("S_SETUP3_14", "Sesso");
define("S_SETUP3_15", "maschio");
define("S_SETUP3_16", "femmina");

// Settings for setup4.php3 file
define("S_SETUP4_1","Quarto step: Il file di configurazione");
define("S_SETUP4_2","Qui c'è il file di configurazione creato in base alle informazioni che avete inserito.<BR><BR>Copiatelo tutto, inclusa la prima e l'ultima linea, poi incollatele nel vostro editor di testo preferito (Notepad, Vi...). Dopo *dovete* inserire la password del database nella riga 7 e salvate il file come <I>config.lib.php3</I>.<BR><BR>Assicuratevi che non ci sia <B>nessuna linea vuota nessun carattere di spazio, niente prima del tag di apertura del php niente dopo averlo chiuso</B>, poi potrete uploadare il file di configurazione sul Vostro server nella directory <I>config</I> (rimpiazza quello esistente) e rendetelo sicuro (vedi il file <I>install.txt</I> nella directory <I>docs</I> per maggiori informazioni a riguardo).<BR><BR>Non dimenticate di guardare <A HREF=\"#warn\">il mesaggio di avviso</A> riportato sotto.");
define("S_SETUP4_3","Seleziona tutto");
//define("S_SETUP4_4","Appena avrete completato i passi sopra citati, %s è pronta a partire.");
define("S_SETUP4_4","Once you have completed the steps above, %s is near ready to run.<BR>");
define("S_SETUP4_4m"," Just sets manually three variables at the top of the <I>'chat/admin/mail4admin.lib.php3'</I><BR>script... and have some nice chat discussions.");
define("S_SETUP4_5","Dopo aver messo in funzione %s dovreste rimuovere il file <BR><I>setup.php3</I> e tutta la directory <I>'chat/install'</I> dal Vostro server.");
?>