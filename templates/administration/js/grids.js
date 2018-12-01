$(document).ready(function(){
    $("body").on("click", "tr.grid-link-edit", function(){
		route = $(this).attr('data-target')+'/'+$(this).attr('data-code');
		document.location = route;
	});
	
	/***** LA NAVIGATION *****/
	$("body").on("click", "button.page-next-pagination", function(){
		curentPage = parseInt($(".page-select-pagination").val())+1;
		$(".page-select-pagination").val(curentPage);
		$("form.page-grid-table-search").submit();
	});
	$("body").on("click", "button.page-past-pagination", function(){
		curentPage = parseInt($(".page-select-pagination").val())-1;
		$(".page-select-pagination").val(curentPage);
		$("form.page-grid-table-search").submit();
	});
	$("body").on("click", "button.search", function(){
		$(".page-select-pagination").val(1);
		$("form.page-grid-table-search").submit();
	});
	$("body").on("change", "select#page-select-by-page", function(){
		$(".page-select-pagination").val(1);
		$("form.page-grid-table-search").submit();
	});
	$("body").on("click", "button#filter-reset", function(){
		$("table.page-grid-table input.fields-filter").val('');
		$("input.page-select-pagination").val(1);
		$("form.page-grid-table-search").submit();
	});
	
});
