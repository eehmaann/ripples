$(document).ready(function()
{	
	$('.error').hide();
	$('#progressionQuestion').hide();
    $("#lastCauseClicker").hide();
    $("#newCauseClicker").text('Suggest change');
	var id =$('#appointmentnumber').text();  

	 $(".pathClicker").click(function(){
	 	var emptycounter=0;
	 	$('#description').val("Change diet ");
        if ($("input[name='vitamins[]']:checked").length>0){
			appendList("'vitamins[]'", "eat" );
		}
        else{
            emptycounter++;
        }
       	if ($("input[name='avoidvitamins[]']:checked").length>0){
			appendList("'avoidvitamins[]'", "avoid" );
		}
        else{
            emptycounter++;
        }
       	if(emptycounter==2){
       		$('#description').val("");
       		$('.error').show();
       	}
       	else{
       		 $('#solution').val($('#description').val());
       		 destination ="../../../../problemsjs/"+id;
            $('#barrierform').attr('action', destination);
       	}
	});

 	function appendList(checkbox, verb){
		var listarray = [];
		$('"input[name='+checkbox +']:checked"').each(function() {
			listarray.push($(this).val());
		});
		var selection;
		selection = listarray.join(', ') ;
		$('#description').append(verb +listarray);
	}	


});