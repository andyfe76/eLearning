<?php

// This file contains the "language" for the K-Lore feedback system
// SEE: en_defs.inc.php for the variable definitions associated with this language.
// FEEDBACK TYPES:
// Errors, Help, Warnings, Feedback, and Info
// FUNCTIONS INCLUDE: print_feedback($feedback),print_help($help), print_popup_help($help),
//  print_infos($infos), print_warnings($warnings)
//
// Feedback can be added using the 5 feedback functions,
//
// -using Text messaged: print_feedback("This is simple text feedback");
//   **this method is not recommended as it makes it more difficult to translate K-Lore
//
// -using an array of messages: print_errors($errors); - where $errors is defined
//  as an array variable $errors[]=AT_ERROR_SIMPLE_EXAMPLE1; $errors[]=AT_ERROR_SIMPLE_EXAMPLE2; ...
//  multiple messages of the same type are grouped together and displayed in a single feedback box.
//
// -using a second array with search and replace characters
//   (e.g. $errors[]=array(AT_ERROR_SIMPLE_EXAMPLE, "some text", $a_variable)
//   the second and third arguments would replace the %1 and %2 strings. )
//
// //////////////////////////////
// Translate this file to create additional feedback languages


/////////////////////////////////////
// WARNINGS
$_warning[AT_WARNING_RAM_SIZE] ='In functie de marimea memoriei RAM a computerului dvs, si in functie de marimea sectiunilor pe care doriti sa le imprimati, procesarea continutului si transformarea sa in format imprimabil poate dura cateva minute.';
$_warning[AT_WARNING_THREAD_DELETE]='Sunteti sigur ca vreti sa stergeti acest fir de discutie?';
$_warning[AT_WARNING_DELETE_FORUM]='Sunteti sigur ca vreti sa stergeti <b>%1</b>? Toate mesajele postate pe acest forum vor fi sterse.';
$_warning[AT_WARNING_CONFIRM_FILE_DELETE]='Sunteti sigur ca vreti sa stergeti fisierul <strong>%1</strong>?';
$_warning[AT_WARNING_CONFIRM_DIR_DELETE]='Sunteti sigur ca vreti sa stegeti directorul <strong>%1</strong>?';
$_warning[AT_WARNING_SURE_DELETE_COURSE1]='Sunteti sigur ca vreti sa <b>Stergeti</b> cursul <strong><em>%1</em></strong>?';
$_warning[AT_WARNING_SURE_DELETE_COURSE2]='Sunteti <b>sigur sigur</b> ca vreti sa <b>Stergeti</b> cursul <strong><em>%1</em></strong>?. Cursurile sterse pot fi recuperate doar de catre Administratorul K-Lore.';
$_warning[AT_WARNING_SURE_DELETE_USER]='Sunteti sigur ca vreti sa stergeti utilizatorul <b>%1</b>?<br />';
$_warning[AT_WARNING_SUB_CONTENT_DELETE]='Aceasta pagina are sub-sectiuni. Daca stergeti aceasta pagina se vor sterge de asemenea si toate paginile din sub-ierarhia ei.<br />';
$_warning[AT_WARNING_GLOSSARY_REMAINS]='Definitiile termenilor de glosar existenti in acest continut nu vor fi stersi.<br />';
$_warning[AT_WARNING_GLOSSARY_REMAINS2]='Elementele de glosar existente in aceste continut nu vor fi sterse.<br />';
$_warning[AT_WARNING_GLOSSARY_DELETE]='Sunteti sigur ca vreti sa stergeti acest element de glosar?<br />';
$_warning[AT_WARNING_DELETE_CONTENT]='Sunteti sigur ca vreti sa stergeti aceasta pagina?<br />';
$_warning[AT_WARNING_DELETE_NEWS]='Sunteti sigur ca vreti sa stergeti %1?<br />';
$_warning[AT_WARNING_SAVE_YOUR_WORK]='Salvati continutul inainte de a deschide sau inchide Managerul de Fisiere.';
$_warning[AT_WARNING_DELETE_THREAD]='Sunteti sigur ca vreti sa stergeti acest <strong>fir de discutie</strong>. Odata sters, mesajele asociate nu pot fi recuperate.';
$_warning[AT_WARNING_DELETE_MESSAGE]='Sunteti sigur ca vreti sa stergeti acest <strong>mesaj</strong>. Odata sters, nu mai poate fi recuparat.';
$_warning[AT_WARNING_LINK_WINDOWS]='Linkurile se deschid intr-o fereastra browser noua.';
$_warning[AT_WARNING_AUTO_LOGIN]='Atentie: alte persoane ce utilizeaza acest computer, daca pot intra pe computer fara parola, vor putea accesa cursurile, si vor aparea logate pe contul dvs K-Lore. Auto-Login <strong>nu trebuie</strong> activat atunci cand lucrati pe un computer non-personal.';
$_warning[AT_WARNING_SAVE_TEMPLATE]='Modelul dvs nu este inca salvat. Cand il salvati veti pierde antetul precedent asociat. Apasati "Cancel" pentru a reveni la antetul salvat anterior.';
$_warning[AT_WARNING_EXPERIMENTAL11]='Instrument in faza de testare!';
$_warning[AT_WARNING_DELETE_TRACKING]='Sunteti sigur ca vreti sa stergeti datele monitor inregistrate pentru acest curs? Puteti alege sa <a href="%1?csv=1">salvati o copie</a> a acestora inainte de stergere.';
$_warning[AT_WARNING_DELETE_TEST]='Sunteti sigur ca vreti sa stergeti testul <strong><em>%1</em></strong>? Toate intrebarile si toate rezultatele vor fi sterse.';
$_warning[AT_WARNING_DELETE_RESULTS]='Sunteti sigur ca vreti sa stergeti rezultatele pentru utilizatorul <strong><em>%1</em></strong>?';
$_warning[AT_WARNING_DELETE_QUESTION]='Sunteti sigur ca vreti sa stergeti aceasta intrebare? Stergerea este ireversibila.';
$_warning[AT_WARNING_REMOVE_COURSE]='Sunteti sigur ca vreti sa stergeti <strong>%1</strong> din lista de cursuri la care sunteti inscris?';
$_warning[AT_WARNING_DELETE_USER]='Sunteti sigur ca vreti sa stergeti utilizatorul <b>%1</b>?';
$_warning[AT_WARNING_DELETE_CATEGORY]='Sunteti sigur ca vreti sa stergeti aceasta categorie, impreuna cu toate linkurile asociate?';
$_warning[AT_WARNING_DELETE_USER_GROUP1] = 'Sunteti sigur ca vreti sa stergeti acest grup impreuna cu toti utilizatorii asociati?';
$_warning[AT_WARNING_DELETE_USER_GROUP2] = 'Chiar sunteti sigur ca vreti sa <b>STERGETI<b> acest grup impreuna cu TOTI UTILIZATORII asociati?';
/////////////////////////////////////
// INFORMATION
$_infos[AT_INFOS_REQUEST_ACCOUNT]='Nu aveti drepturi de creare curs.';
$_infos[AT_INFOS_PRIVATE_ENROL]='The course you are trying to access is <b>private</b>. Enrollment in this course requires instructor approval.<br />';
$_infos[AT_INFOS_CHOOSE_NUMBERS]='Toate campurile sunt obligatorii de completat. Info: numerele sunt cea mai buna alegere pentru campurile <code>value</code>.';
$_infos[AT_INFOS_NO_MORE_FIELDS]='Nu exista optiuni suplimentare. Click "urmator" pentru a continua.';
$_infos[AT_INFOS_USE_SQLBELOW]='Utilizati expresia SQL de mai jos pentru a creea tabela in baza de date.';
$_infos[AT_INFOS_NO_POSTS_FOUND]='Nu exista mesaje in acest forum.';
$_infos[AT_INFOS_INBOX_EMPTY]='Nu exista mesaje in Inbox.';
$_infos[AT_INFOS_APPROVAL_PENDING]='Cererea dvs a fost inaintata. Veti fi notificat cand cererea a fost aprobata.<br /><br />Va puteti intoarce la <a href="users/index.php">Pagina Principala</a>.';
$_infos[AT_INFOS_ACCOUNT_PENDING]='Your instructor account request has been made. You will be notifed by email when your request has been approved.';
$_infos[AT_INFOS_NO_ENROLLMENTS]='Nu exista studenti inscrisi la acest curs.';
$_infos[AT_INFOS_GLOSSARY_REMAINS]='Stergerea unui element de glosar din continutul paginii <strong>NU</strong> va sterge termenul de glosar, care poate fi in continuare gasit prin click pe glosar.';

$_infos[AT_INFOS_NO_TERMS]='Nu au fost gasiti termeni de glosar pentru "%1". Selectati "Toate" pentru a afisa intregul glosar.';
$_infos[AT_INFOS_TRACKING_OFFST]='Monitorizarea nu este activata pentru acest curs.';
$_infos[AT_INFOS_TRACKING_OFFIN]='Monitorizarea nu este activata pentru acest curs. Contactati Administratorul K-Lore sau unul dintre Traineri pentru a activa monitorizarea.';
$_infos[AT_INFOS_TRACKING_NO_INST]='Date monitor nu sunt colectate pentru utilizatorii Trainer si Administrator. Alegeti un alt utilizator.';
$_infos[AT_INFOS_TRACKING_NO_INST1]='Date monitor nu sunt colectate pentru utilizatorii Trainer si Administrator. Vezi <a href="tools/course_tracker.php">Monitorizare Curs</a> pentru raport asupra activitatii la curs.';
$_infos[AT_INFOS_NO_CONTENT]='Acest curs nu are inca un continut.';
$_infos[AT_INFOS_NO_PERMISSION]='Nu aveti drepturi de acces la aceasta pagina.';
$_infos[AT_INFOS_NOT_RELEASED] ='Acest continut nu a fost inca publicat. %1';
$_infos[AT_INFOS_NO_PAGE_CONTENT] ='Nu exista continut pe aceasta pagina.';

?>
