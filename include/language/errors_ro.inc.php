<?php

/////////////////////////
// Errors
$_errors[AT_ERROR_GENERAL] = 'Eroare de cautare.';  //call with:  print_errors(array(AT_ERROR_GENERAL, "replace"));
$_errors[AT_ERROR_UNKNOWN] = 'Eroare neidentificata.';
$_errors[AT_ERROR_NO_SUCH_COURSE] ='Identificator de curs invalid.';
$_errors[AT_ERROR_NO_TITLE] ='Titlu gol. Va rog completati campul de titlu.';
$_errors[AT_ERROR_BAD_DATE] ='Data introdusa este invalida.';
$_errors[AT_ERROR_ID_ZERO] ='Identificator de continut invalid sau lipsa.';
$_errors[AT_ERROR_PAGE_NOT_FOUND] ='Pagina de continut nu a fost gasita.';
$_errors[AT_ERROR_BAD_FILE_TYPE] ='Tip de fisier invalid. Se pot utiliza numai fisiere text sau HTML.';
$_errors[AT_ERROR_ANN_BOTH_EMPTY] ='Introducere incompleta de date. Va rugam completati cel putin unul dintre campurile: titlu sau continut.';
$_errors[AT_ERROR_ANN_ID_ZERO] ='Identificator de anunt invalid.';
$_errors[AT_ERROR_ANN_NOT_FOUND] ='Accesul interzis la editarea acestui anunt.';
$_errors[AT_ERROR_TERM_EMPTY] ='Aceste termen nu poate fi gol.';
$_errors[AT_ERROR_DEFINITION_EMPTY] ='Aceasta definitie nu poate fi goala.';
$_errors[AT_ERROR_TERM_EXISTS] ='Termenul %1 exista deja.';
$_errors[AT_ERROR_GLOS_ID_MISSING] ='Identificator de termen glosar - invalid';
$_errors[AT_ERROR_TERM_NOT_FOUND] ='Termenul de glosar nu a fost gasit.';
$_errors[AT_ERROR_FORUM_TITLE_EMPTY] ='Titlu forum invalid. Va rugam completati campul de titlu.';
$_errors[AT_ERROR_POST_ID_ZERO] ='Identificatorul de mesaj invalid.';
$_errors[AT_ERROR_POST_NOT_FOUND] ='Mesajul nu a fost gasit.';
$_errors[AT_ERROR_FORUM_NOT_FOUND] ='Forumul nu a fost gasit.';
$_errors[AT_ERROR_ACCESS_DENIED] ='Acces interzis.';
$_errors[AT_ERROR_LOGIN_TO_POST]='Trebuie sa fiti logati pentru a afisa mesaje.';
$_errors[AT_ERROR_ALREADY_SUB]='Sunteti deja inscrisi la acest fir de discutie.';
$_errors[AT_ERROR_ACCESS_INSTRUCTOR] ='Trebuie sa fiti trainer sau training manager pentru a trimite email catre administratorul K-Lore.';
$_errors[AT_ERROR_STUD_INFO_NOT_FOUND] ='Informatia despre student nu poate fi gasita.';
$_errors[AT_ERROR_ADMIN_INFO_NOT_FOUND] ='Informatia despre administrator nu poate fi gasita.';
$_errors[AT_ERROR_MSG_SUBJECT_EMPTY] ='Subiectul mesajului - invalid. Va rugam completati campul de subiect.';
$_errors[AT_ERROR_MSG_BODY_EMPTY] ='Corpul mesajului - invalid. Va rugam completati campul de corp mesaj.';
$_errors[AT_ERROR_MSG_TO_INSTRUCTOR] ='Trebuie sa fiti inscris la curs pentru a trimite email instructorului.';
$_errors[AT_ERROR_INST_INFO_NOT_FOUND] ='Informatia despre trainer nu poate fi gasita.';
$_errors[AT_ERROR_CHOOSE_ONE_SECTION] ='Trebuie sa selectati cel putin o sectiune pentru imprimare. Va rog click pe una dintre casutele de mai jos.';
$_errors[AT_ERROR_NO_COURSE_CONTENT] ='Nu exista continut asociat cu acest curs.';
$_errors[AT_ERROR_NO_DB_CONNECT] = 'Conexiune cu baza de date - invalida.<br />Cauze posibile: Nume utilizator / parola invalida; nume baza de date invalid; prea multe conexiuni la baza de date.';
$_errors[AT_ERROR_PREFS_NO_ACCESS] ='Nu aveti dreptul de modificare a preferintelor acestui curs.';
$_errors[AT_ERROR_NO_USER_PREFS] ='Nu se pot extrage preferintele de utilizator pentru acest curs.';
$_errors[AT_ERROR_INVALID_LOGIN] ='Pereche nume/parola - invalida.';
$_errors[AT_ERROR_EMAIL_NOT_FOUND] ='Nu s-a gasit nici un cont K-Lore asociata cu adresa de email furnizata.';
$_errors[AT_ERROR_EMAIL_MISSING] ='Trebuie sa introduceti o adresa de email.';
$_errors[AT_ERROR_EMAIL_INVALID] ='Adresa de email invalida.';
$_errors[AT_ERROR_EMAIL_EXISTS] ='Un cont cu adresa de email precizata exista deja. Va rog utilizati <a href="password_reminder.php">password reminder</a> pentru a primi un password nou, daca l-ati utitat.';
$_errors[AT_ERROR_LOGIN_NAME_MISSING] ='Trebuie sa introduceti un nume de login.';
$_errors[AT_ERROR_LOGIN_CHARS] ='Numele de login trebuie sa contina doar litere a-z, cifre sau underscore (_\'s).';
$_errors[AT_ERROR_LOGIN_EXISTS] ='Nume de login deja existent. Va rog alegeti alt nume de login.';
$_errors[AT_ERROR_PASSWORD_MISSING] ='Trebuie sa furnizati o parola.';
$_errors[AT_ERROR_PASSWORD_MISMATCH] ='Cele doua parole trebuie sa fie identice. Aceasta verificare se face pentru a fi sigur ca nu tastati gresit.';
$_errors[AT_ERROR_GROUP_MISSING] = 'Va rog selectati un grup in care va fi introdus noul utilizator.';
$_errors[AT_ERROR_GROUP_EXISTING] = 'Nume de grup deja existent. Va rog introduceti alt nume de grup.';
$_errors[AT_ERROR_BAD_GROUP_NAME] = 'Nume de grup invalid.';
$_errors[AT_ERROR_NO_COURSE_GROUP] = 'Nu exista nici un modul de cursuri. Va rog creati un modul inainte de a crea un nou curs.';
$_errors[AT_ERROR_DB_NOT_UPDATED]='Informatia nu poate fi introdusa in baza de date.';
$_errors[AT_ERROR_MSG_SEND_LOGIN] ='Trebuie sa fiti logati pentru a trimite mesaje.';
$_errors[AT_ERROR_NO_RECIPIENT] ='Trebuie selectat un destinatar.';
$_errors[AT_ERROR_SEND_ENROL] ='Puteti trimite mesaje doar dupa ce ati fost inscris la un curs.';
$_errors[AT_ERROR_SEND_MEMBERS] ='Puteti trimite mesaje doar celor care sunt inscrisi la acelasi curs ca si dvs.';
$_errors[AT_ERROR_FILE_ILLEGAL] =' Fisiere %1 - nepermise.';
$_errors[AT_ERROR_FILE_NOT_SAVED] ='Fisierul nu poate fi salvat.';
$_errors[AT_ERROR_FILE_TOO_BIG] ='Dimensiunea fisierului depaseste %1';
$_errors[AT_ERROR_MAX_STORAGE_EXCEEDED] ='Adaugand acest fisier se depaseste limita permisa pentru acest curs.';
$_errors[AT_ERROR_FILE_NOT_SELECTED] ='Nu ati selectat nici un fisier pentru upload.';
$_errors[AT_ERROR_FOLDER_NOT_CREATED] ='Folderul nu poate fi creat.';
$_errors[AT_ERROR_DIR_NOT_OPENED] ='Nu se poate deschide directorul.';
$_errors[AT_ERROR_DIR_NOT_DELETED] ='Nu se poate sterge directorul.';
$_errors[AT_ERROR_DIR_NOT_EMPTY] ='Directorul nu este gol si de aceea nu se poate sterge.';
$_errors[AT_ERROR_DIR_NO_PERMISSION] ='Nu se poate sterge directorul. Acces interzis sau directorul nu este gol.';
$_errors[AT_ERROR_NOT_RELEASED] ='Aceasta pagina nu a fost inca publicata. %1';
$_errors[AT_ERROR_UNSUPPORTED_FILE]='Tip de fisier invalid. Utilizati doar fisiere text sau HTML.';
$_errors[AT_ERROR_CSS_ONLY]='Tip de fisier invalid. Utilizati numai fisiere de stylesheet (i.e. stylesheet.css).';
$_errors[AT_ERROR_RESULT_NOT_FOUND]='Rezultat - negasit.';
$_errors[AT_ERROR_SUPPLY_TITLE]='Trebuie sa furnizati un nume de curs.';
$_errors[AT_ERROR_CREATE_NOPERM]='Nu aveti dreptul de a crea cursuri.';
$_errors[AT_ERROR_NO_STUDENTS]='Nu exista studenti inscrisi la acest curs.';
$_errors[AT_ERROR_ALREADY_OWNED]='Sunteti creatorul acestui curs si de aceea nu va puteti inscrie.';
$_errors[AT_ERROR_ALREADY_ENROLED]='Ati cerut deja sa va inscrieti la acest curs si nu ati primit inca aprobare de la instructorul cursului. Veti fi notificat atunci cand inscrierea dvs a fost aprobata.';
$_errors[AT_ERROR_LOGIN_ENROL]='Trebuie sa va logati in sistem pentru a accesa cursurile.';
$_errors[AT_ERROR_REMOVE_COURSE]='Eroare neidentificata - la incercarea de a sterge cursul.';
$_errors[AT_ERROR_DESC_REQUIRED]='Trebuie sa furnizati o descriere a cursului, inainte ca cererea dvs de instructor sa fie procesata.';
$_errors[AT_ERROR_START_DATE_INVALID]='Data de start este invalida.';
$_errors[AT_ERROR_END_DATE_INVALID]='Data de sfarsit este invlida.';
$_errors[AT_ERRORS_QUESTION_EMPTY]='Intrebare goala. Va rog completati corpul intrebarii.';
$_errors[AT_ERROR_QUESTION_NOT_FOUND]='Intrebarea selectata nu a fost gasita.';
$_errors[AT_ERROR_TEST_NOT_FOUND]='Testul selectat nu a fost gasit.';
$_errors[AT_ERROR_FIELD_TITLE_EMPTY]='[Camp Nr: %1] "Titlul" pentru campul nr. %2 este necompletat.';
$_errors[AT_ERROR_FIELD_SIZE_EMPTY]='[Camp Nr: %1] Dimensiunea campului trebuie precizata pentru campurile de tip "Drop Down Select".';
$_errors[AT_ERROR_FIELD_SIZE_EMPTY_MULTI]='[Camp Nr: %1] Dimensiunea campului trebuie precizata pentru campurile de tip "Multiple Drop Down Select".';
$_errors[AT_ERROR_FIELD_TYPE_EMPTY]='[Camp Nr: %1] Tipul campului trebuie precizat.';
$_errors[AT_ERROR_SIZE_TEXTAREA_BOTH]='[Camp Nr: %1] Dimensiune 1 si Dimensiune 2 trebuie ambele precizate pentru "Text Area".';
$_errors[AT_ERROR_OPTION_MISSING]='[Camp Nr. %1, Option No. %2] Nu este furnizata nici o varianta.';
$_errors[AT_ERROR_VALUE_MISSING]='[Camp Nr. %1, Option No. %2] Nu este furnizata nici o valoare pentru varianta.';
$_errors[AT_ERROR_TEST_EMAIL_MISSING]='Nu ati completat o adresa de email catre care sa fie trimise datele din acest formular.';
$_errors[AT_ERROR_TEST_EMAIL_INVALID]='Adresa de email invalida.';
$_errors[AT_ERROR_TEST_THANKYOU]='Nu ati completat o adresa URL de mesaj final (multumiri), catre care sa fie trimis utilizatorul dupa completarea formularului.';
$_errors[AT_ERROR_TEST_HOSTUSER_MISSING]='Nu ati introdus numele computerului (hostname), numele utilizator sau numele bazei de date.';
$_errors[AT_ERROR_TEST_TABLENAME_MISSING]='Nu ati introdus numele tabelei ce va fi creata.';
$_errors[AT_ERROR_TEST_COLNAME_MISSING]='Coloana %1 pentru campul "%2" nu a fost introdus.';
$_errors[AT_ERROR_TEST_COL_NOSPACE]='<li>Coloana %1 pentru campul "%2" nu poate contine spatii.';
$_errors[AT_ERROR_CHOOSE_YESNO]='Va rog selectati da sau nu - daca doriti sau nu sa introduceti datele intr-o tabela in baza de date.';
$_errors[AT_ERROR_DB_NOT_CONNECTED]='Nu se poate stabili o conexiune la baza de date cu informatiile furnizate.';
$_errors[AT_ERROR_DB_NOT_ACCESSED]='Nu se poate stabili o conexiune la baza de date cu informatiile furnizate.';
$_errors[AT_ERROR_TABLE_NOT_CREATED]='Nu se poate creea tabela in baza de date.';
$_errors[AT_ERROR_NOT_OWNER]='Cursul nu poate fi accesat (nu exista sau nu aveti drepturi).';
$_errors[AT_ERROR_CSV_FAILED]='Nu se poate creea  fisier CSV %1.';
$_errors[AT_ERROR_EXPORTDIR_FAILED]='Nu se poate creea director de export.';
$_errors[AT_ERRORS_TARFILE_FAILED]='Nu se poate creea arhiva <tar>.';
$_errors[AT_ERROR_TARGZFILE_FAILED]='Nu se poate creea arhiva <tar.gz>.';
$_errors[AT_ERROR_IMPORTDIR_FAILED]='Nu se poate creea director de import.';
$_errors[AT_ERROR_IMPORTFILE_EMPTY]='Fisierul de import nu poate fi gol.';
$_errors[AT_ERROR_NO_QUESTIONS]='Acest test nu contine nici o intrebare.';
$_errors[AT_ERROR_NODELETE_USER]='Nu se poate sterge acest utilizator deoarece este creatorul unor cursuri existente. Stergeti cursurile intai.';
$_errors[AT_ERRORS_TRACKING_NOT_DELETED]='Informatiile de monitorizare a cursului nu pot fi sterse. Cauze posibile: nu exista date monitor inregistrate pentru acest curs sau nu aveti drepturi.';
$_errors[AT_ERROR_CPREFS_NOT_FOUND]='Nu au fost gasite setari de preferinte pentru acest curs.';
$_errors[AT_ERROR_THEME_NOT_FOUND] = 'Tema vizuala nu a fost gasita.';
$_errors[AT_ERROR_CANNOT_OPEN_DIR] = 'Nu se poate deschide directorul de continut.';

$_errors[AT_ERROR_NO_SPACE_LEFT] = 'Spatiu limitat - nu exista suficient spatiu alocat acestui curs pentru a extrage aceasta arhiva.';

$_errors[AT_ERROR_CANNOT_OVERWRITE_FILE] = 'Nu se poate suprascrie fisierul.';

$_errors[AT_ERROR_LINK_CAT_NOT_EMPTY] = 'Categoria de linkuri nu poate fi stearsa deoarece contine subcategorii.';

$_errors[AT_ERROR_NO_CONTENT_SPACE] = 'Spatiu insuficient pentru a importa continutul.';

$_errors[AT_ERROR_INVALID_MIN_GRADE] = 'Nota minima invalida. Trebuie sa precizati nota minima cu care se poate finaliza acest curs.';
$_errors[AT_ERROR_MANDATORY_FIELDS] = 'Va rog completati toate campurile obligatorii.';
$_errors[AT_ERROR_NOT_ENROLLED] = 'Utilizatorul selectat nu este inscris la acest curs.';

$_errors[AT_ERROR_MAX_STUD_REACHED] = 'La acest curs au fost deja inscrisi un numar maxim de studenti. Va rog contactati instructorul cursului pentru marirea numarului maxim de studenti inscrisi.';

// translation
$_errors[AT_ERROR_USER_ALREADY_LOGGEDIN] = 'Utilizator deja logat.';
$_errors[AT_ERROR_SQL_BAD_DEFINITION] = 'SQL invalid. Va rog redefiniti conditiile.';
$_errors[AT_ERROR_USER_LICENSES_LIMIT] = 'Numarul maxim de utilizatori a fost atins. Pentru licente aditionale va rugam contactati: <a href=""></a>';
$_errors[AT_ERROR_FIRST_NAME_MISSING] = 'Lipseste numele utilizatorului.';
$_errors[AT_ERROR_LAST_NAME_MISSING] = 'Lipseste prenumele utilizatorului';
$_errors[AT_ERROR_NO_REPORT_COLUMNS] = 'Nu au fost definite capetele de tabel pentru acest raport.';
?>
