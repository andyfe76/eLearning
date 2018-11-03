<?php
//////////////////////////////////////
// HELP

$_help[AT_HELP_HIDE_HELP]='Puteti <strong><em>ascunde Ajutorul</em></strong> deselectindu-l din <a href="tools/preferences.php">setari preferinte</a> ale optiunilor de afisare.';
$_help[AT_HELP_NO_HELP] ='Nu exista ajutor disponibil in acest moment.';
$_help[AT_HELP_ENABLE_EDITOR] ='Folositi legatura<strong><em><a href="%1enable=PREF_EDIT">Activeaza editor</a></em></strong> [ <img src="images/pen.gif" alt="Enable Editor Icon" /> ] de la inceputul paginii pentru a edita acest continut.';
$_help[AT_HELP_DISABLE_EDITOR] ='Folositi legatura <strong><em><a href="?disable=PREF_EDIT">Dezactiveaza editor</a></em></strong> [ <img src="images/pen2.gif" alt="Disable Editor Icon" /> ] de la inceputul paginii pentru a ascunde instrumentele de editare.';
/*
//where are these being used?  delete these if they're not missed
$_help[AT_HELP_EDIT_CONTENT]='Folositi "<strong><em><a href="editor/edit_content.php?cid=$cid">Editati continutul paginii</a></em></strong>" pentru a adauga sau modifica continutul acestei pagini.  Si Instrumente sunt disponibile prin aceasta legatura pentru formatarea si rearanjarea continutului si pentru managementul fisierelor.<br />';
$_help[AT_HELP_DELETE_CONTENT]='Folositi "<strong><em><a href="editor/delete_content.php?cid=$cid">Stergeti continutul paginii</a></strong></em>" pentru a sterge pagina curenta din Curs. Toate sub-paginile trebuiesc sterse inainte.<br />';
$_help[AT_HELP_SUB_CONTENT]='Folositi "<strong><em><a href="editor/add_new_content.php?pid=$cid">Adaugati subcapitole in aceasta pagina </a></strong></em>" pentru a crea pagini pentru subcapitole. Acesta va adauga o pagina numerotata in meniu sub subiectul curent. Nu exista limita pentru numarul de subcapitole pe care le puteti adauga, desi 4 sau 5 nivele este de obicei suficient.<br />';
*/
$_help[AT_HELP_BROWSER_PRINT_BUTTON] = 'Folositi butonul de Print al programului de navigare pentru a imprima aceasta pagina.';
$_help[AT_HELP_EDIT_STYLES]='<ol>
<li>Acest instrument creeaza/editeaza un fisier in directorul cu continutul Cursului tau numit "stylesheet.css".</li>
<li>Cautati pe Internet tutoriale Style Sheet pentru a invata mai multe despre crearea si editarea fisierelor CSS (<a href="http://www.htmlhelp.com/reference/css/">Pagini in cascada</a>).</li>
<li>Fiti sigur ca utilizati culori relaxante pentru internet. (urmariti <a href="http://www.visibone.com/colourlab/">VisiBone Color Lab</a>).</li>
<li>Porniti prin incarcarea stilului de pagina standard al K-Lore apasind pe legatura urmatoare. <strong><em>WARNING</em></strong> aceasta va sterge orice stil de pagina de curs anterior. </li>
<li>Editati Stilul de pagina standard </li>
<li>Incarcati fisierele legate de stilul de pagina de curs in continutul directorului dumneavoastra folosind managerul de fisiere K-Lore.</li>
<li>Faceti legaturi cu imaginile personale de fundal inlocuind locatia standard a imaginii (e.g "../../images/cellpic1.gif") cu o locatie din directorul personal (e.g. "content/241/images/myimage.gif", unde 241 este numarul de identificare al Cursului dumneavoastra)
<li>Stergeti fisierul stylesheet.css (folosind managerul de fisiere),sau goliti zona Stilurile Cursului si salvati, pentru a afisa stilul standard K-Lore.</li>
</ol>';
$_help[AT_HELP_EDIT_STYLES_MINI]='Incarcati un stil de formatare existent de pe hard-disk-ul local , pentru a fi copiat in zona de text. E preferabil sa porniti cu formatarea standard K-Lore, apoi sa ii editati atributele pentru a va crea stilul propriu. ';  //'
$_help[AT_HELP_ADD_ANNOUNCEMENT]='Sinteti pe pagina de anunturi a Cursului. Apasati pe <strong><em><a href="editor/add_news.php">Adauga un anunt </a></em></strong> de mai jos pentru a adauga un continut acestei pagini. Aceasta este prima pagina a Cursului, prin care studentii acceseaza Cursul tau.<br />';
$_help[AT_HELP_ADD_ANNOUNCEMENT2]='Sinteti pe pagina de anunturi a Cursului. Apasati pe <strong><em><a href="editor/add_news.php"> Adauga un anunt</a></em></strong> de mai jos pentru a adauga un continut acestei pagini. Aceasta este prima pagina a Cursului, prin care studentii acceseaza Cursul tau. </a>.<br />';
$_help[AT_HELP_ADD_TOP_PAGE]='Puteti adauga pagini cu subcapitole in Curs apasind pe <strong><em><a href="editor/add_new_content.php">Adauga Capitol</a></em></strong>. Aceasta va adauga o pagina in meniu. Observati ca "Adauga Capitol" apare si in meniul global, deci se pot adauga pagini principale si de acolo.<br />';
$_help[AT_HELP_CREATE_LINKS]='Creeaza categorii in care se pot sorta legaturi introducind numele subiectului in cimpul"<strong><em>Categorie noua</em></strong>" de mai jos.';
$_help[AT_HELP_CREATE_LINKS1]='Pentru a adauga o noua legatura, selectati categoria unde ar trebui sa fie, apoi apasati "<strong><em>Sugerati o noua legatura</em></strong>".';
$_help[AT_HELP_CREATE_FORUMS]='Apasati pe "<strong><em><a href="editor/add_forum.php">Forum nou</a></em></strong>" pentru a adauga o noua tema de discutii in Cursaul tau.';
$_help[AT_HELP_FILE_LINKING] = 'Pentru a face legatura cu fisierele de Curs folositi <code>CONTENT_DIR</code> ,calea catre continutul directorului. De exemplu, daca doriti sa incarcati o imagine cu denumirea MyImage.gif va trebui sa ii faceti o legatura catre ea in HTML folosind <code>CONTENT_DIR</code>/MyImage.gif ca fiind calea catre imagine. <code>CONTENT_DIR</code> va fi automat inlocuita cu calea corecta catre acel fisier cind pagina este accesata. Daca incarcati imaginea catre un director numit MyFolder atunci incarcati aceeasi imagine , apoi calea de utilizare va deveni <code>CONTENT_DIR</code>/MyFolder/MyImage.gif <br />';
$_help[AT_HELP_FILE_EXPORTABLE] ='Folosind <code>CONTENT_DIR</code> va fi posibil sa importati si sa exportati foarte usor materialul Cursului fara sa fiti nevoit sa schimbati calea catre fisiere. Daca nu intentionati sa mutati Cursul, puteti apasa cu butonul din dreapta al mouse-ului pe un fisier si sa copiati locatia respectiva in HTML.';
$_help[AT_HELP_EMBED_GLOSSARY]='Pentru a fixa o definitie in continut folositi  [?] pentru a arata inceputul termenului si [/?] pentru a arata sfirsitul termenului. Daca termenul nu exista in Glosar, vi se fa cere o definitie pentru el. ';
$_help[AT_HELP_CONTENT_PATH]='Cind faceti trimiteri la fisiere din continut, folositi <code>CONTENT_DIR/</code> ca fiind calea radacina a fisierelor incarcate, urmata de numele unui subdirector (daca este necesar), apoi urmata de numele fisierului asupra caruia se face trimiterea. (e.g. src="<code>CONTENT_DIR</code>/images/logo.gif" sau href="<code>CONTENT_DIR</code>/week1/outline.html").';
$_help[AT_HELP_FORUM_STICKY]='Apasati pe iconita "sticky" [<img src="images/forum/sticky.gif" height="18" width="16" alt="sticky icon"/>] pentru a fixa un mesaj in capul listei mesajelor. Mai multe mesaje "fixate" sint ordonate dupa data ultimei interventii.';
$_help[AT_HELP_FORUM_LOCK]='Apasati pe iconita "lock" [<img src="images/lock.gif" height="18" width="16" alt="lock icon"/>] pentru a restrictiona interventii catre un mesaj, sau pentru a ascunde un mesaj fata de citire sau afisare.';
$_help[AT_HELP_TRACKING]='Selectati din meniul de mai jos studentul, the student who\'s navigation tendencies si apasati calea care doriti sa o vedeti.';//'
$_help[AT_HELP_TRACKING1]='Selectati o pagina din meniul de mai jos  pentru a ii observa statisticile.';
$_help[AT_HELP_NOT_RELEASED] = 'Aceasta pagina va deveni disponibila studentilor incepind cu data selectata.';
$_help[AT_HELP_FORMATTING] = 'Continutul textului va fi afisat asa cum apare in zona de editare. Folositi HTML sau codurile listate mai jos, pentru a adauga formatari, legaturi, grafice, etc, continutului.';
$_help[AT_HELP_PASTE_FILE] = 'Copierea dintr-un fisier va insera continutul fisierului in cimpul de text de mai jos. Creati continutul intr-un editor HTML, apoi importati pagina aici. ';
$_help[AT_HELP_PASTE_FILE1] ='Puteti copia continut in zona de text fara a altera continutul existent. Salvarea va duce la stergerea oricarui continut anterior.';
$_help[AT_HELP_ADD_CODES] ='Discutia si Legatura catre Conceptul de Invatare vor introduce iconite care au trimiteri catre Forumuri si Baza de date a legaturilor. Cind introduceti imagini folosind codul imaginii, nu uitati sa introduceti un scurt text cu descrierea imaginii in a doua jumatate a codului deschis intitulat "alt text".';
$_help[AT_HELP_ADD_CODES1] ='Folositi codurile afisate mai jos pentru a aplica formatarile de baza continutului, sau pentru a insera legaturi sau imagini. Folositi HTML pentru a utiliza formatari mai detaliate.';
$_help[AT_HELP_INSERT]='Localizati aceasta pagina dintre celelalte pagini ale Cursului. Mutati aceasta pagina in interiorul acestei sectiuni, sau in alta sectiune.';
$_help[AT_HELP_RELATED]='Selectati alte subiecte in Cursul legat de acesta. Subiectele apar in meniul "Subiecte conexe" cind aceasta pagina este afisata.';
$_help[AT_HELP_ANNOUNCEMENT]='Anunturile vor aparea pe pagina de start a cursului. Trebuie sa completati cel putin un camp de inregistrare. ';
$_help[AT_HELP_FILEMANAGER]='Upload files here to link to your content pages. Click on "Open File Manager frame", to have it open while editing your content.';
$_help[AT_HELP_FILEMANAGER1]='Right click on a file then select "copy link location" (or what ever your browser calls this function), to copy the file\'s path, then paste that path into your content.';
$_help[AT_HELP_FILEMANAGER2]='You might first create a number of <strong><em>folders</em></strong>, in which to sort your course files. You might create different directories for images, sound files, assignment downloads, or perhaps directories for each lesson.<br /><br />';
$_help[AT_HELP_FILEMANAGER3]='Assuming you know a little HTML, you can <strong><em>link to files</em></strong> in your course directory using a path something like href="CONTENT_DIR/assignments/week1intro.doc". You may also link to files using full URLs, but <strong><em>using CONTENT_DIR makes your course portable</em></strong> if you decide later you want to move it.<br /><br />';
$_help[AT_HELP_FILEMANAGER4]='To <strong><em>find the path</em></strong> to a course file, right click on its link in the File Manager and choose "Save Link Location" (systems vary in terminology used). This copies the link to the clipboard, which you might then choose to paste into your course content to create a link (using right-click then paste, or Ctrl-v).<br /><br />';

  
$_help[AT_HELP_CUSTOM_HEADER]='Introduceti continut HTML pentru a creea un antet personalizat al acestui curs. Sau, puteti da click pe "Incarca Model cadru" si apoi sa modificati textele din acest model, pentru a obtine un antet tip "cadru".';
$_help[AT_HELP_CREATE_HEADER]='Pentru a creea un antet personalizat al acestui curs, introduceti continut HTML in zona de text de mai jos. ';
$_help[AT_HELP_EDIT_STYLES]='Creati un stil vizual personalizat pentru acest curs. Puteti incarca fisierul de stil predefinit si sa il modificati, apoi salvati pentru a observa rezultatul. Fisierul stylesheet al cursului este utilizat atunci cand utilizatorul nu a selectat un stil propriu (fortat). ';
$_help[AT_HELP_DEMO_HELP]='This is a demo Context Sensitive Help. Hover over it with a mouse pointer, or click on it, to display the accompanying help.';
$_help[AT_HELP_DEMO_HELP2]='This is a demo Help Box. When the Help Box preference is disabled, the Help Icon becomes clickable, so Help Boxes can be opened and close.';
$_help[AT_HELP_ADD_RESOURCE]='URL, Title, Description, and Your Name, are required fields.';
$_help[AT_HELP_ADD_RESOURCE1]='Use appropriate keywords in your description to aid resource searches. ';
$_help[AT_HELP_ADD_RESOURCE_MINI]='Keep your description brief. Mention what content could be found on the site and what it is about. Do not praise the site by using words like "best" or "greatest" in your description. Try to use appropriate keywords to aid searching.';
$_help[AT_HELP_ADD_FORUM_MINI]='Provide a descriptive title that signifies the main topic of discussion. Describe the topics, and the types of discussion that should take place in this forum.';

$_help[AT_HELP_GLOSSARY_MINI]='Cuvinte si fraze pot fi adaugate glosarului. Daca exista si termeni asociati, puteti sa inregistrati aceasta asociere cu ajutorul meniului selectie de mai jos. Termenii de glosar sunt afisati intr-o fereastra mouseover, la fel ca si aceasta fereastra de help contextual, sau pe o pagina separata, atunci cand utilizatorul a dat click pe un termen de glosar din pagina de curs.';
$_help[AT_HELP_GLOSSARY_MENU]='In acest meniu vor aparea termenii de glosar existenti pe pagina curenta de curs. ';
$_help[AT_HELP_USERS_MENU]='Lista cu persoanele active (online) in K-Lore LMS si inscrisi la acest curs.';
$_help[AT_HELP_RELATED_MENU]='Afiseaza alte subiecte conexe cu informatia prezentata in pagina curenta de curs. ';
$_help[AT_HELP_GLOBAL_MENU]='Afiseaza structura globala (totala) a cursului. Puteti tasta <strong><em>Alt-7</em></strong> pentru a deschide/inchide rapid acest meniu.';
$_help[AT_HELP_LOCAL_MENU]='Afiseaza subiectele din capitolul curent selectat. La intrarea in curs, trebuie selectat intai un capitol din meniul global al cursului. ';
$_help[AT_HELP_MAIN_MENU]='Ascunde meniurile pentru a eficientiza spatiul de lucru. Puteti afisa/ascunde aceste meniuri si cu ajutorul tastaturii, apasand Alt-6.';
$_help[AT_HELP_ADD_MC_QUESTION]='Creati doua sau mai multe alegeri pentru aceasta intrebare si selectati care dintre aceste alegeri sunt raspunsuri corecte. Creati un mesaj feedback ce va fi afisat atunci cand rezultatele testului sunt afisate studentilor.';
$_help[AT_HELP_ADD_TF_QUESTION]='Scrieti o intrebare careia i se poate raspunde cu "adevarat" sau "fals". Creati un mesaj feedback ce va fi afisat atunci cand rezultatele testului sunt afisate studentilor. ';
$_help[AT_HELP_ADD_OPEN_QUESTION]='Creati o intrebare deschisa. Puteti alege dimensiunea raspunsului din meniul selectiv de mai jos". ';
$_help[AT_HELP_ADD_TEST]='Puteti modifica perioada in care se poate da acest test. Initial aceasta perioada este aceeasi cu perioada de valabilitate a cursului din care face parte acest test.';
$_help[AT_HELP_GLOBAL_WEIGHT]='Nota maxima a testului offline. Aceasta nota va fi utilizata pentru a calcula rezultatele finale ale studentului, pentru intreg cursul.';
$_help[AT_HELP_TEST_DURATION]='Timpul alocat pentru a raspunde la toate intrebarile din test. ';
$_help[AT_HELP_TEST_RETRIES]='Numarul maxim de incercari permise de a da testul. Valoarea initiala este de 1 = testul se poate da o singura data. Daca testul este trecut, studentul nu mai are voie la o alta incercare, indiferent de numarul maxim de incercari permise. ';
$_help[AT_HELP_POSITION_OPTIONS]='You might choose to locate the menus on the left if you are left handed. <br>Previous/Next location indicates the positioning of the ordered navigation bar.<br>The Table of Contents appears on content pages as a collapsible list of sub pages associated with the current topic.';
$_help[AT_HELP_DISPLAY_OPTIONS]='Sectiunile de curs pot fi numerotate incremental (ex. 1.2.6). Aceste numere pot aparea inaintea numelui sectiunii, in meniuri si pe paginile de capitol.<br><br>Elementele de <strong><em>ajutor K-Lore</em></strong> apar ca zone principale pe pagina, cu informatii referitoare la utilizarea sistemului K-Lore. Odata ce v-ati obisnuit cu interfata si functiile acesteia, puteti ascunde aceste elemente de ajutor.<br><br><strong>Mini-help</strong> sunt ferestre precum aceasta, si apar doar la indicarea cu mouse-ul.';
$_help[AT_HELP_TEXTICON_OPTIONS]='You might choose to turn off icons if you are using a screen reader. If you prefer to view a graphic display, turn icons on. To reduce clutter, display icons without a text label.';
$_help[AT_HELP_MENU_OPTIONS]='Configurati modul de afisare al meniurilor K-Lore. Alegeti meniurile frecvent utilizate si eliminati-le pe celelalte. Puneti primul meniul cel mai des folosit.';

$_help[AT_HELP_THEME_OPTIONS]='Choose the colours and fonts that are easiest for you to view. Choose the <strong><em>Course Default Colours</em></strong>, Set Preferences for the current session, then save those settings to <em>This Course Only</em> so this course gets displayed with its own custom look-and-feel (if one has been created by the instructor)';
$_help[AT_HELP_PREFERENCES]='You might choose from the Preset preferences below, then adjust those settings in the <strong><em>Personal Preferences</em></strong> table.<br /><br />';
$_help[AT_HELP_PREFERENCES1]='The Preset <strong><em>Accessibility</em></strong> settings will strip away all non-essential navigation elements, optimizing K-Lore for use with various assistive technologies.<br /><br />';
$_help[AT_HELP_PREFERENCES2]='Preferintele sunt prima data setate pentru sesiunea curenta de lucru (internet explorer). Trebuie sa salvati setarile curente daca doriti ca ele sa ramana valabile si la sesiuni viitoare. In fereastra de feedback ce apare dupa ce dati click pe "Seteaza preferinte", alegeti sa salvati aceste setari pentru cursul curent sau pentru toate cursurile. ';
$_help[AT_HELP_ADD_TEST1]='Click pe <strong><em><a href="tools/tests/add_test.php">Adauga Test</a></em></strong> pentru a creea un nou test.';
$_help[AT_HELP_ADD_QUESTIONS]='Click pe <strong><em>Intrebari</em></strong> pentru a adauga noi intrebari la acest test. ';
$_help[AT_HELP_ADD_QUESTIONS2]='Alegeti dintre linkurile <strong></em>Adauga Intrebari</em></strong> de mai jos, pentru a adauga o intrebare. Click pe <strong><em>Editeaza</em></strong> pentru a modifica o intrebare existenta. ';
$_help[AT_HELP_PREVEIW_QUESTIONS]='Intoaceti-va la <a href="tools/tests/">Test Manager</a> si click pe <strong><em>Previzualizare</em></strong> asociat testului <strong><em> %1.</em></strong>';
$_help[AT_HELP_MARK_RESULTS]='Testele sunt notate automat pentru cele care nu contin intrebari deschise. Testele ce contin intrebari deschise vor fi notate manual de catre trainer.';
$_help[AT_HELP_NETSCAPE4]='<strong style="color:#FF0000"><em>IMPORTANT</em></strong>: Utilizati o versiune veche de <strong><em>Mozilla/Netscape</em></strong>. K-Lore LMS nu garanteaza functionalitate completa in acest browser.';
$_help[AT_HELP_CONTROL_CENTER1]='Pe aceasta pagina sunt prezentate cursurile la care sunteti inscris, iar daca sunteti trainer, puteti vedea de asemenea si cursurile pe care le-ati initiat dvs. <br>Selectati <strong>Management Cursuri</strong> pentru un management global al tuturor cursurilor, sau <strong> Management Useri</strong> pentru administrarea utilizatorilor inscrisi in K-Lore LMS. De asemenea puteti accesa <strong>Rapoarte</strong>, pentru a crea liste de utilizatori cu anumite conditii (grupurile dinamice pot fi create din sectiunea Rapoarte).';
$_help[AT_HELP_CONTROL_CENTER2]='Selectati <strong><em>Creeaza un curs nou</em></strong>. Se va crea astfel un cadru initial al cursului, in care puteti apoi adauga anunturi specifice, continut de curs, teste, termeni de glosar si puteti sa interactionati cu utilizatorii prezenti la acel curs (chat room). ';
$_help[AT_HELP_CONTROL_CENTER3]='Administratorii pot accesa numai sectiunile globale de management cursuri si utilizatori, precum si sectiunea de raportari. Administratorul poate vizualiza orice curs prin click pe numele cursului direct din sectiunea de Management Cursuri. Inscrierea unui administrator la un curs nu este permisa. ';
$_help[AT_HELP_CONTROL_PROFILE]='Puteti vizualiza informatii despre profilul dvs prin click pe <strong><em>Editeaza Profil</em></strong> din meniul din stanga.';
$_help[AT_HELP_IMPORT_EXPORT]='Continutul cursului poate fi exportat pentru a creea copii de siguranta (backup) si pentru a importa acest continut in alt curs sau pe alt server K-Lore.';
$_help[AT_HELP_IMPORT_EXPORT1]='Importati un intreg curs in interiorul cursului curent. Importul poate dura cateva minute, in functie de dimensiunea fisierului importat.';
$_help[AT_HELP_COURSE_EMAIL]='Trimite un email (text) catre toti studentii inscrisi la acest curs. Util pentru a anunta capitole noi, teste noi sau atentionarea studentilor cu privire la termene limita. ';
$_help[AT_HELP_ENROLMENT]='Selectati un utilizator pentru a afisa informaiile de cont K-Lore ale acestuia. ';
$_help[AT_HELP_ENROLMENT2]='Select Approve, or Disapprove, to change a user\'s enrolment status. Click "remove" to take the user off the enrolment list.';
$_help[AT_HELP_PRINT_COMPILER]='Selectati din lista de mai jos sectiunile pe care doriti sa le imprimati. Click "Imprima continului selectat" si apoi puteti utiliza functia print a browserului internet. Continutul se va imprima fara sectiunea de meniuri. ';
$_help[AT_HELP_PRINT_COMPILER2]='Daca utilizati un browser internet compatibil modern, elementele de navigatie K-Lore (meniuri, etc) vor fi ascunse in mod automat inainte de imprimarea continutului. Puteti verifica acest lucru cu ajutorul functiei Print Preview din browserul dvs.';
$_help[AT_HELP_NUMBER_QUESTIONS]='For example if you build a test with 12 questions and you want only 5 questions to be displayed at random choice.';
$_help[AT_HELP_MIN_GRADE] = 'Nota minima de trecere a testului.';
$_help[AT_HELP_SPECIAL_INSTRUCTIONS] = 'Puteti adauga instructiuni speciale, ce vor aparea inainte ca studentul sa inceapa testul.';
$_help[AT_HELP_COURSE_START_DATE] = 'Data la care doriti sa inceapa cursul. Neselectat, lasa posibilitatea de vizualizare a cursului imediat ce acesta a fost creat.';
$_help[AT_HELP_COURSE_END_DATE] = 'Data de la care incepand, studentii nu vor mai avea drept de vizualizare a acestui curs, chiar daca sunt inca inscrisi. Daca lasati nesetata aceasta optiune, cursul va fi disponibil pentru o perioada nedeterminata.';
$_help[AT_HELP_COURSE_PERIOD] = 'Numarul de zile disponibile pentru a finaliza cursul. Incepand de la momentul in care studentul acceseaza prima data cursul, el va avea doar un numar de zile disponibil pentru a finaliza toate testele.';
?>
