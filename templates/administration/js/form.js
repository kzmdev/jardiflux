$(document).ready(function(){
    $("body").on("click", "div.page-action button.return", function(){
		url = window.location.pathname.split("/");
		url.pop();
		document.location = url.join('/');
	});
	
	 $("body").on("click", "div.page-action button#action-update", function(){
		url = window.location.pathname.split("/");
		url.pop();
		$("#page-action-callback").val(url.join('/'));
		url.push("add");
		
		$(this).closest("form").attr("action", url.join('/'));
		$(this).closest("form").submit();
	});
	
	 $("body").on("click", "div.page-action button#action-update-same", function(){
		url = window.location.pathname.split("/");
		url.pop();
		$("#page-action-callback").val(window.location.pathname);
		url.push("add");
		
		$(this).closest("form").attr("action", url.join('/'));
		$(this).closest("form").submit();
	});
	
	$("body").on("click", "button.thesaurus-add-row", function(){
		parent =  $(this).closest("div.thesaurus-list");
		clone = parent.clone();
		clone.find(".thesaurus-input").val('');
		parent.after(clone);
	});
	
	$("body").on("click", "button.thesaurus-del", function(){
		$(this).closest("div.thesaurus-list").remove();
		
	});
});