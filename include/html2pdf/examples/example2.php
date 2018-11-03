<?php
/**
 * A more complex example. We convert a remote HTML file 
 * into a PDF file. Additionally, we set several options to 
 * customize the look.
 */
?>
<html>
<head>
  <title>Testing HTML_ToPDF</title>
</head>
<body>
  Creating the PDF from remote web page...<br />
  
<?php
// require the class
require_once dirname(__FILE__) . '/../HTML_ToPDF.php';

// full path to the file to be converted (this time a webpage)
// change this to your own domain
$htmlFile = 'http://www.example.com/index.html';
$defaultDomain = 'www.example.com';
$pdfFile = dirname(__FILE__) . '/test2.pdf';
// remove old one, just to make sure we are making it afresh
@unlink($pdfFile);

$pdf =& new HTML_ToPDF($htmlFile, $defaultDomain, $pdfFile);
// set that we do not want to use the page's css
$pdf->setUseCSS(false);
// give it our own css, in this case it will make it so
// the lines are double spaced
$pdf->setAdditionalCSS('
p {
  line-height: 1.8em;
  font-size: 12pt;
}');
// we want to underline links
$pdf->setUnderlineLinks(true);
// scale the page down slightly
$pdf->setScaleFactor('.9');
// make the page black and light
$pdf->setUseColor(false);
// convert the file
$result = $pdf->convert();

// check if the result was an error
if (PEAR::isError($result)) {
    die($result->getMessage());
}
else {
    echo "PDF file created successfully: $result";
    echo '<br />Click <a href="' . basename($result) . '">here</a> to view the PDF file';
}
?>
</body>
</html> 
