$(document).ready(function()
{	
	hideDietTypes();

	$('.error').hide();
	var id =$('#appointmentnumber').text();  
  
	 $(".dietClicker").click(function () {
        hideDietTypes();
        $('.'+$(this).attr('id')).show();
    });
	$("#foodlisthider, #herblisthider, #vitaminlisthider").click(function(){
		var thisclass=$(this).attr('class');
		$('.'+thisclass).hide();
	});

	 $(".pathClicker").click(function(){
	 	var emptycounter=0;
	 	$('#description').val("Change diet ");
		if ($("input[name='foods[]']:checked").length>0){
			appendList("'foods[]'", "eat" );
		}
        else{
            emptycounter++;
        }
		if ($("input[name='avoidfoods[]']:checked").length>0){
			appendList("'avoidfoods[]'", "avoid" );
		}
        else{
            emptycounter++;
        }
        if ($("input[name='herbs[]']:checked").length>0){
			appendList("'herbs[]'", "eat" );
		}
        else{
            emptycounter++;
        }
        if ($("input[name='avoidherbs[]']:checked").length>0){
			appendList("'avoidherbs[]'", "avoid" );
		}
        else{
            emptycounter++;
        }
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
       	if(emptycounter==6){
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



function hideDietTypes(){
	$('.foodlist').hide();
	$('.herblist').hide();
	$('.vitaminlist').hide();
}
