$(function (){
	function getUrlVars(){
	    var vars = [], hash;
	    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
	    for(var i = 0; i < hashes.length; i++)
	    {
	        hash = hashes[i].split('=');
	        vars.push(hash[0]);
	        vars[hash[0]] = hash[1];
	    }
	    return vars;
	}

	var first = getUrlVars()["project_id"];
	var $currmems = $('#memheader');
	var $name = $('#name');
	var memberjson;

	$.ajax({
	  url: "/projects/mems",
	  type: "get",
	  data:{project_id:first},
	  success: function(response) {
	  	memberjson = JSON.parse(response);
	    $.each(JSON.parse(response), function(i, member){
	    	$currmems.append(' <li id= '+member.user_id+'> '+ member.firstname +' '+member.lastname+' <a href="javascript:;" id ='+member.person_id+' > Remove</a> </li> ');
	    	});

	  }
	});

	$('#add').on('click', function(){

		var member = {
			name: $name.val(),
			project_id: first,
		};

		$('#name option:selected').remove();

		$.ajax({
			url: "/projects/mems/add",
			type: "post",
			data: member,
			success: function(newMember){
				memberjson=JSON.parse(newMember);
				 $.each(JSON.parse(newMember), function(i, newMember){
		    	$currmems.append(' <li id= '+newMember.user_id+'> '+ newMember.firstname +' '+newMember.lastname+' <a href="javascript:;" id ='+newMember.user_id+' > Remove</a> </li> ');

		    	});


			},

		});

	});

	$(document).on('click',"a", function(){   
		var member = {
			name: $(this).attr("id"),
		};
		
		$.ajax({
			url:"/projects/mems/remove",
			type: "post",
			data: member,
			success: function(delMember){
				console.log('success');
				$.each(JSON.parse(delMember), function(i, delMember){
				$name.append(' <option value= '+delMember.user_id+'> '+delMember.firstname+' '+delMember.lastname+' </option>');
				$('#' + delMember.user_id).remove();

				});

			},



		});



	});

});