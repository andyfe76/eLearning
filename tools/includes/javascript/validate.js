<!--

function validate(field) {
var valid = "!@#$%^&*()'"
var ok = "yes";
var temp;
for (var i=0; i<field.value.length; i++) {
temp = "" + field.value.substring(i, i+1);
if (valid.indexOf(temp) != "-1") ok = "no";
}
if (ok == "no") {
alert("You can not use the following characters in a file name:   !@#$%^&*()'   Please rename your file.");
field.focus();
field.select();
   }
}

// -->