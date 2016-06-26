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

	var first = getUrlVars()["projects_id"];
	var $currmems = $('#memheader');
	var $name = $('#name');
	var memberjson;

	$.ajax({
	  url: "/projects/mems",
	  type: "get", //send it through get method
	  data:{projects_id:first},
	  success: function(response) {
	  	memberjson = JSON.parse(response);
	    $.each(JSON.parse(response), function(i, member){
	    	$currmems.append(' <li id= '+member.person_id+'> '+ member.firstname +' '+member.lastname+' <a href="javascript:;" id ='+member.person_id+' > Remove</a> </li> ');
	    	});

	  }
	});

});