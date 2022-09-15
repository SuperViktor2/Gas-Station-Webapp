
function fja() {
    var x = document.getElementById("opcija").value;
    if (x === 'upload') {
      document.getElementById("azuriranje").style.display = 'none';
  	} else {
      document.getElementById("azuriranje").style.display = 'block';
      }
 }

 function fja2() {
    var x = document.getElementById("opcija").value;
    if (x === 'dodjeli') {
      document.getElementById("azuriranje2").style.display = 'block';
  	} else {
      document.getElementById("azuriranje2").style.display = 'none';
      }
 }