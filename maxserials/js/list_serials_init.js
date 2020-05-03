$(document).ready(function(){
    
    $.getJSON("http://localhost/prj1/api/serial/read.php", function(data){
        showSerialList(data);
    });

});