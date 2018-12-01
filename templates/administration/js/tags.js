$(document).ready(function(){
	
	$("#input-search-tags").keyup(function(){
		txt = $(this).val();
		if(txt != "")
		{
			$(".list-tags span:not([data-search^='"+txt.toLowerCase()

+"'])").hide();
			$(".list-tags span[data-search^='"+txt.toLowerCase()+"']").show();
		}
		else
		{
			$(".list-tags span").show();
		}
	});
	
	$(".fileUploaderInput").change(function(){
		if(this.files.length > 0)
		{
			$(this).hide();
			$("#fileUploaderText").html(this.files[0].name + "<span id='fileUploadReset'><i class='fas fa-times-circle'></i></span>");
			$("#fileUploaderBtn").css("visibility", "visible");
		}
		
	});
	
	$("body").on("click", "span#fileUploadReset", function(){
		 $(".fileUploaderInput").show();
		 $(".fileUploaderInput").replaceWith($(".fileUploaderInput").val('').clone(true));
		$("#fileUploaderText").html("Déposez votre fichier csv ici, ou cliquez ici pour le chercher sur votre disque");
		$("#fileUploaderBtn").css("visibility", "hidden");
	});
	$("body").on("click", "button#fileUploaderBtn", function(){
		file = $(".fileUploaderInput");
		upload(file[0].files[0], $("#entetes_zone"));
	});
	//on supprime
	$("body").on("click", "span.label i.fa-times", function(){
	console.log( $(this).closest("td").attr("data-headers"));
		$.post("/ajax/setmapping",{
				"code" : $("#entetes_zone").attr("data-fournisseur"),
				"header" : $(this).closest("td").attr("data-headers"),
				"attributs_code" : ''
			});
			$(this).parent().remove();
	});
	
	$( ".tags_move" ).draggable({
      cancel: "a.ui-icon", // clicking an icon won't initiate dragging
      revert: "invalid", // when not dropped, the item will revert back to its initial position
		containment: "document",
      helper: "clone",
      cursor: "move",
	  appendTo: "body"
    });
	droppedInit();
});

function cloneTags(item, area)
{
	area.html('');
	span = $("<span>")
				.addClass("label")
				.addClass("label-success")
				.addClass("tags_selected")
				.attr("id", item.attr("data-search"))
				.html(item.text());
	$("<i class='fas fa-times'></i>").appendTo(span);
	span.appendTo(area);
}

function droppedInit(){
		$(".droppable").droppable({
		accept: ".tags_move",
		classes: {
			"ui-droppable-active": "ui-state-highlight"
		},
		drop: function( event, ui ) {
			cloneTags(ui.draggable, $(this));
			$.post("/ajax/setmapping",{
				"code" : $(this).closest("#entetes_zone").attr("data-fournisseur"),
				"header" : $(this).attr("data-headers"),
				"attributs_code" : ui.draggable.attr("data-code")
			});
		}
	});
}

function upload(file, area){
	var xhr = new XMLHttpRequest();
	var script = "/ajax/uploadmapping";
	
	//on affiche le calque
	$('.loader-calk').show();
	xhr.addEventListener('load', function(e){
				var json = jQuery.parseJSON(e.target.responseText);
				$("#tbl-headers tbody").html("");
				ctn = "";
				$.each(json, function(header,info){
					ctn += "<tr>";
					ctn += "	<td>" + header +"</td>";
					ctn += "	<td data-headers='"+header+"' class='droppable'>";
					ctn += ((info.attributs_code == null) ? '&nbsp;' :  "<span class='label label-success tags_selected' id='"+info.attributs_code+"'>"+info.attributs_label+"<i class='fas fa-times'></i></span>");
					ctn += "	</td>";
					ctn += "</tr>";
				});
				$("#tbl-headers tbody").html(ctn);
				$('.loader-calk').hide();
				$(".am-scroller").nanoScroller();
				droppedInit();
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