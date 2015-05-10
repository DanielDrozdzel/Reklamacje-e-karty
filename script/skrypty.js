$(function() {
	


$(document).on('click','a',function(e){  //żądanie ajax na kliknięcie wybranej reklamacji z tabeli lub po zapisaniu albo po zmianie w tekscie

   $('#wyniki').empty();
	  $.ajax({
            type: 'POST',
            url: "app/controller.php",
			data: $(this).attr('href'),
            success:function(data){
				$("#wyniki").append(data);
            }
        });
	e.preventDefault();  
	
});


$("#logout").click(function() {
	document.location.href = "log.php";
});

	
$(document).on('submit', "#form_zmien", function(event) //żądanie ajax po zatwierdzeniu zmian w formularzu zmian reklamacji
	{ 
	event.preventDefault();
	$("#wyniki").empty();
    $.ajax(
    {
        url : "app/controller.php",
        type: "POST",
        data : $(this).serialize() + '&sprawdz=zmien',
        success: function(response) {
			$("#wyniki").append(response);
		}
	}
  );
});



	
$("#form_rek").submit(function(e)  //żądanie ajax głownego formularza dla zapisania lub znalezienie reklamacji
	{ 
	e.preventDefault();
	
	$("#wyniki").empty();
    $.ajax(
    {
        url : "app/controller.php",
        type: "POST",
        data : $('#form_rek').serialize() + '&sprawdz=' +$("input[type=submit]:focus").attr('value') , // do serializowanych danych dołącza artybut wartości wybranego (focus) przycisku
        success: function(response) {
			$("#wyniki").append(response);
			
		}
	}
  );
  $('#form_rek').trigger("reset"); //reset wartości w formularzu reklamacji

});

$("#rek_id").blur(function() { //wstepna walidacja numeru ID
	var id=$(this).val();
	if(isNaN(id) && id !== "") {
		$(this).css('border', '1px solid red');
		alert("Błąd: ID jest liczbą");
	} else {
		$(this).css('border', '1px solid black');
	}
});


 $('#data').Zebra_DatePicker({
	 format: 'd-m-Y'
 });

$(document).on("blur", ".Kwota", function() { //wstepna walidacja kwoty
	var kwota = $(this).val();
	var regEx = /\d{1,2},\d{2}/;
	var check = kwota.match(regEx);
	if(!check && kwota !== "") {
		$(this).css('border', '1px solid red');
		alert("Błąd: Kwota jest liczbą rzeczywistą, nie większą niż 100, z dwoma miejscami po przecinku");
		$(this).val('');
	} else {
		$(this).css('border', '1px solid black');
	}
});



$(document).on("blur", ".Karta", function() { //wstepna walidacja numeru karty
var ekarta = $(this).val();
var regEx = /\d{11}/;
var check = ekarta.match(regEx);
if(!check && ekarta !== "" ) {	
		$(this).css('border', '1px solid red');
		alert("Błąd: eKarta musi posiadać 11 cyfr");
		$(this).val('');
} else {
	$(this).css('border', '1px solid black');
}
});


});