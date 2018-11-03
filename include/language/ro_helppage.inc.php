<?php

?>
<h3><br>
Instructiuni de navigare</h3>
<blockquote>
  <p>Aici afli despre structura aplicatiei, functionalitatile butoanelor si modalitatea
    de navigare.</p>
  <p>Aplicatia este organizata in ferestre, fiecare dintre ele prezentand diferite
    informatii. In aceste ferestre gasesti structuri arborescente [de ex cursurile],
    butoane si link-uri.</p>
  <p>Instructiunile vor fi prezentate in aceeasi ordine in care tu, probabil,
    vei accesa pentru prima data aplicatia.</p>
  <p>Recomandare: la prima accesare deschide in paralel si fereastra de Ajutor</p>
  <p><font color="#0000CC"><strong>Pentru a vizualiza corect continutul cursurilor
    puteti instala <a href="http://www.macromedia.com/shockwave/download/" target="_blank">Macromedia Flash Player</a></strong></font></p>
  <blockquote>
    <p><strong><a href="<?echo "$PHP_SELF?exp=1";?>">1.	Home sau Bine ati venit
          la eLearning!</a></strong>
     
      <?if ($_GET['exp']==1) {?>
      <br>
      Informatii
    de baza pentru navigarea in aplicatie.</p>
    <blockquote>
      <p><strong>1.1	User-ul tau</strong><br>
        Aflat in stinga sus, sub logo, acest link iti ofera informatii despre
                      profilul tau<br>
                      <br>
        <strong>1.2	Schimbarea parolei de acces (pasi de urmat)</strong><br>
&#8226; Click pe User<br>
&#8226; Click pe Profil<br>
&#8226; Click pe Parola<br>
&#8226; Introdu noua ta parola in cele doua campuri<br>
&#8226; Click pe Trimite</p>
      <p><strong>1.3	Inbox</strong><br>
        Aplicatia ofera fiecarui utilizator functionalitatea de `mesagerie`. Ce poti
                    face cu aceasta utilitate?<br>
&#8226; Poti citi mesajele trimise catre tine<br>
&#8226; Poti trimite mesaje catre alti utilizatori ai aplicatiei eLearning [inclusiv
                traineri]</p>
      <p><strong>1.4	Logout</strong><br>
        Apasa acest buton pentru a iesi din aplicatie. Butonul are acelasi efect ca
                inchiderea interfetei de nevigare [ex: Internet Explorer]</p>
    </blockquote>
  </blockquote>
</blockquote>

<blockquote>
  <blockquote><?}?>
    <p><strong><a href="<?echo "$PHP_SELF?exp=2";?>">
                 
  2.	Cursuri la care esti
                      inscris</a></strong>
      <?if ($_GET['exp']==2) {?>
    </p>
    <p>      <br>
      Sub aceasta sectiune vei gasi fiecare curs la care esti inscris. Pentru a accesa
            cursul dorit, click pe link-ul aferent cursului.<br>
      Odata cu accesarea cursului vor aparea butoane si link-uri noi.</p>
    <blockquote>
      <p><strong>2.1 Start Curs</strong><br>
        Acest buton te va aduce intotdeauna la pagina de pornire a cursului</p>
      <p><strong>2.2 Deschide Meniuri/Inchide Meniuri</strong><br>
        Butonul va deschide/inchide un set de butoane care te vor ghida pe timpul parcurgerii
                    cursului.</p>
      <p><strong>2.3 Capitole</strong><br>
        Butonul deschide posibilitatea parcurgerii cursului pe capitole. Aplicatia
                    va afisa doar structura arborescenta a fiecarui capitol</p>
      <p><strong>2.4 Curs</strong><br>
        Butonul desfasoara cursul intreg sub forma arborescenta. Foloseste butoanele
                    `+` si `-` pentru exinde/restringe capitolele/subcapitolele cursului.<br>
        Poti naviga intre capitolele si subcapitolele cursului prin click pe link-ul
                  aferent.<br>
        Pentru a putea accesa fiecare capitol trebuie neaparat sa rezolvi testul de
                  la finalul capitolelor.</p>
      <p><strong>2.5 Feedback</strong><br>
        Formular prin care ne poti trimite evaluarile si recomandarile tale referitoare
                    la curs si aplicatie</p>
      <p><strong>2.6 Glosar</strong><br>
        Definitii, termeni, informatii suplimentare ce apar in cadrul cursului<br>
        <strong>2.7 Harta Site-ului</strong><br>
        Link-ul iti va afisa in fereastra din dreapta intreaga structura arborescenta
                  a cursului si a aplicatiei eLearning</p>
      <p><strong>2.8 Subiecte conexe</strong><br>
        Butonul iti va afisa notiuni si informatii legate de cursul in desfasurare</p>
      <p><strong>2.9 Useri Online</strong><br>
        Butonu iti va desfasura lista userilor ce acceseaza in acelasi timp cu tine
                    aplicatia.<br>
        Poti trimite si de aici un mesaj unui user prin click pe link-ul/user-ul dorit</p>
      <p><strong>2.10 Instrumente</strong><br>
        O fereastra de unde poti accesa diferite functionalitati ale aplicatiei eLearning</p>
      <blockquote>
        <p><strong>2.10.1 Preferinte</strong><br>
          Modifica modul de aranjare a meniurilor si aspectul aplicatiei eLearning<br>
          <br>
          <strong>2.10.2 Harta cursului</strong><br>
          Afiseaza structura detaliata a cursului si a instrumentelor aferente<br>
          <br>
          <strong>2.10.3 Glosar</strong><br>
          Definitii, termeni, informatii suplimentare ce apar in cadrul cursului<br>
          <br>
          <strong>2.10.4 Convertor pentru imprimare</strong> <br>
          Aici puteti selecta sectiuni din curs pentru a fi prelucrate in format
            compatibil cu imprimanta.<br>
            <br>
            <strong>2.10.5 Teste </strong><br>
          Afiseaza testele si rezultatele obtinute de
          dvs</p>
      </blockquote>
    </blockquote>
    <p><br>
      <strong><a href="<?echo "$PHP_SELF?exp=3";?>">
      <?}?>
      </a></strong>        </p>
    <p>  <strong><a href="<?echo "$PHP_SELF?exp=3";?>">
      3. Imprima/Salveaza cursul</a>
            
</strong></p>
    <p>
      <?if ($_GET['exp']==3) {?>
    </p>
    <blockquote>
      <p>	<strong>3.1 Instrumente - Convertor pentru imprimare (pasi de urmat)</strong><br>
&#8226; Click pe `Convertor pentru imprimare`<br>
&#8226; Bifeaza sectiunile dorite din curs <br>
&#8226; Click pe `Afiseaza continutul selectat`<br>
&#8226; Click pe `Imprima pagina`<br>
        <br>
        Te poti intoarce oricand la convertorul pentru imprimare prin click pe
        `Compilator de imprimare`</p>
      <p><strong>3.2 Versiune printabila</strong><br>
        Aceasta optiune iti da posibilitatea de a imprima pagina in curs de vizualizare.</p>
      <p><strong>3.3 Descarca PDF </strong><br>
        Foloseste aceasta optiune pentru a descarca/salva cursul integral. Aceasta
                varianta<br>
          iti da posibilitatea consultarii cursului dupa absolvire 
      si/sau  cand nu esti conectat la retea.</p>
      <p align="left">  Salvarea in format PDF al cursului se facea astfel :
        din orice capitol al cursului se da clik-dreapta pe link-ul <a href="../tools/<? echo str_replace(' ','_',$_SESSION['course_title']).'.pdf'; ?>">Descarca
              PDF</a> ,
              se alege si se da clik-stanga pe comanda <strong>Save Target As</strong>, se alege locatia
              de memorie din propiul PC unde dorim sa salvam formatul PDF al cursului
          si se apasa butonul <strong>Save</strong>. </p>
      <p align="left"><font color="#FF0000">Este eficient a se efectua salvarea cursului in format
        PDF (Acrobat Reader) pe calculatorul folosit de cursant (local). Cursantul
        poate parcurge cursul (mai putin testele) si de pe masina locala (PC-ul
        folosit) fara a mai fi nevoie sa fie conectat la aplicatie (nu mai acceseaza
        Internetul) si nu mai este nevoie sa tipareasca cursul (economie de hartie).
        Poate accesa aplicatia pentru a da testele, pentru a verifica mesajele,
      chat, etc. </font></p>
    </blockquote>
    <p><strong><a href="<?echo "$PHP_SELF?exp=4";?>">
      <?}?>
      </a></strong> </p>
    <p><strong><a href="<?echo "$PHP_SELF?exp=4";?>">
      4. Reguli de testare</a></strong>
      <?if ($_GET['exp']==4) {?>
      <br>
      <br>
      Fiecare curs contine un set de teste intermediare si un test final.</p>
    <blockquote>
      <p>Fiecare dintre aceste teste au un timp de rezolvare [ex: 10 minute la un
              test intermediar sau 30 de minute la testul final] si un numar maxim 
              de incercari. Informatiile exacte despre aceste elemente sunt prezentate
          la inceputul fiecarui test.</p>
      <p>Atat testele intermediare cat si cel final trebuie `absolvite` cu un procent
          de 70% raspunsuri corecte.</p>
      <p><font color="#FF0000"><strong>ATENTIE! Dupa ce ai absolvit cu succes un
                          curs [prin reusita la testul final], nu vei mai avea posibilitatea de
                          a vizualiza cursul. De aceea, iti recomandam
                      sa imprimi/salvezi continutul inainte de rezolvarea testului final [vezi
          </strong><a href="<?echo "$PHP_SELF?exp=3";?>">punctul 3</a><strong> din `Ajutor`].</strong></font></p>
    </blockquote>
    <p>    </p><?}?>
	<p><strong><a href="<?echo "$PHP_SELF?exp=5";?>">
      5. Interbari frecvente</a></strong>
      <?if ($_GET['exp']==5) {?>
      <br>
      <br>
    <blockquote>
      <p><strong>5.1 Cum se pot vizualiza rezultatele testelor
            date ?</strong></p>
      <blockquote>
        <p>Rezultatele testelor sunt afisate automat de
              aplicatie dupa finalizarea testului si apsarea butonului <strong><br>
              Trimite
          rezultate</strong>,
              pentru fiecare test in parte-inmomentul parcurgerii cursului.</p>
        <p>Se acceseaza
              butonul <a href="../tools/?g=15"><img border=1 width=32 height=23
src="../images/course/c_tools.jpg" > Instrumente</a> din
              caseta de instrumente se acceseaza link-ul <a href="../tools/my_tests.php?g=28">Teste</a>, se
              va deschide caseta de informatii teste unde pot fi vizualizate: titlu
              test, data in care a fost dat, nota, etc. Se pot vedea rezultatele selectate prin accesare link <strong>Vezi rezultatele</strong></p>
      </blockquote>
      <p></p>
      <strong>5.2 Cum se poate schimba parola de acces in aplicatie
              ?
              </p>
      </strong>
      <blockquote>
        <p> </span>Parola poate fi
              schimbata oricand de utilizator  prin accesarea link-ului <a href="../users/edit.php"><? echo $_SESSION['login'] ?></a>            aflat
              in partea de sus-drepata in orice ecran al aplicatiei. Se va deschide
              sectiunea Raport utilizator, unde pe langa testele si notele
              aferente
              poate accesa link-ul <a href="../users/edit.php?show_profile=1&member=<? echo $_SESSION['login'] ?>">Profil</a> </p>
        <p style="text-autospace:none">La accesarea link-ului
              Profil se deschide caseta cu Informatii despre
              cont</p>
        <p> In caseta de informatii
              despre cont se acceseaza link-ul <a href="change_profile.php">Parola</a>.</span><span
lang=IT>, se va deschide caseta de schimbare parola, unde se introduce de 2
              ori parola noua si se apsa butonul <strong>Trimite</strong>.</span></p>
      </blockquote>
      <p><strong>5.3 Cum se poate trimite mail intern in aplicatie
              ?</strong></p>
      <blockquote>
        <p> Se acceseaza butonul <a href="/inbox.php?g=21"><img
src="images/menu/inbox.gif"  border="1" ></a> , apare
              caseta e-mail  ,
              se acceseaza link-ul <a href="send_message.php">Mesaj nou</a>,
              se alege din fereastra ‘La’ persoana dorita, se scrie subiectul
              si corpul mesajului si se apasa butonul Trimite mesaj.</p>
        <p> Se recomanda Agentilor
                de vanzare Dealer care sunt programati la cursuri in aplicatia
                e-Learning sa :</span></p>
        <p>parcurga cursurile
              si testele programate in perioada de valabilitate a numelui de utilizator
              si parolei</p>
        <p><span lang=IT
style='font-family:"Courier New";'>o </span><span lang=IT>respecte confidentialitatea
                informatiilor si confidentialitatea parolelor de acces;</span></p>
        <p><span lang=IT
style='font-family:"Courier New";'>o </span><span lang=IT>anunte DCM-ul coordonator
                sau echipa de Sales Training (<a href="mailto:name@mail.com">name@mail.com</a>)
                in cazurile in care pierde accesul, accesul in aplicatie nu mai este
                confidential, etc.</span></p>
      </blockquote>
    </blockquote>
    <p><br>
      <?}?>
    </p>
  </blockquote>
</blockquote>
<h3>&nbsp;</h3>
<h3>Contacts</h3>
<p>
  <?php if ($_SESSION['is_admin']) { ?>
</p>
<blockquote>
  <blockquote>
    <p>For Instructors Only:</p>
    <p><a href="help/contact_admin.php"><strong>K-Lore System Administrator Contact
          Form</strong></a><strong> </strong> </p>
  </blockquote>
</blockquote>
<?php } else {?>
<blockquote>
  <blockquote>
    <p>
            
    <a href="help/contact_instructor.php?g=18"><strong>Course Instructor
          Contact Form                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       </strong></a></p>
  </blockquote>
</blockquote>
  </p>
  </li>
</ul>
  <?} ?>