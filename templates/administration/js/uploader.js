function confirmUpload(json)
{
	console.log(json);
}

$(document).ready(function(){
	$("body").on("change", ".fileUploaderInput",function(){
		if(this.files.length > 0)
		{
			$(this).hide();
			$("#fileUploaderText").html(this.files[0].name + "<span id='fileUploadReset'><i class='fas fa-times-circle'></i></span>");
			$("#fileUploaderBtn").css("visibility", "visible");
		}
		
	});
	
	$("body").on("click", ".btn-import", function(){
		$(".page-upload").show();
	});
	
	$("body").on("click", "span#fileUploadReset", function(){
		 $(".fileUploaderInput").show();
		 $(".fileUploaderInput").replaceWith($(".fileUploaderInput").val('').clone(true));
		$("#fileUploaderText").html("Déposez votre fichier csv ici, ou cliquez ici pour le chercher sur votre disque");
		$("#fileUploaderBtn").css("visibility", "hidden");
	});
	$("body").on("click", "button#fileUploaderBtn", function(){
		file = $(".fileUploaderInput");
		script = $(this).attr("data-script");
		callback = $(this).attr("data-callback");
		
		upload(file[0].files[0], $("#entetes_zone"), script, callback);
	});
});

function upload(file, area, script, callback){
	var xhr = new XMLHttpRequest();
		
	//on affiche le calque
	$('.loader-calk').css("height", "800px");
	$('.loader-calk').show();
	$("body").css("overflow", "hidden");
	xhr.addEventListener('load', function(e){
				var json = jQuery.parseJSON(e.target.responseText);
				confirmUpload(json);
				$('.loader-calk').hide();
			}, false);
			
	xhr.open('post', script, true);
	xhr.setRequestHeader('x-file-type', file.type);
	xhr.setRequestHeader('x-file-size', file.size);
	xhr.setRequestHeader('x-file-name', file.name);
	xhr.setRequestHeader('x-file-destination', '/import');
	
	for(var i in area.data()){
		if(typeof area.data(i) !== 'object'){
			xhr.setRequestHeader('x-params-'+i, area.data(i));
		}
	}
	xhr.send(file);
}

	