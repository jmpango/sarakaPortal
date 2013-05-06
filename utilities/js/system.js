$(document).ready(function() {
	
	$("#btnEdit").click(function(){
		var numberSelected = $(":checked", "table.recordTable tbody tr").length;
		if( numberSelected > 0){
			if(numberSelected == 1){
				var url = $(this).attr("href");
				url += "/"+$(":checked", "table.recordTable tbody tr").attr("value");
				window.location = url;
			}else{
				alert("please select only one Item and try again.");
			}
		}else{
			alert("please select only one Item and try again.");
		}
		
		return false;
	});
	
	$('#btnDelete').click(function(){
		if($(":checked", "table.recordTable tbody tr").length > 0){
			if(window.confirm("Do you want to delete the selected Items(s) with all their attached information? ")){
				var ids=$("input[name=selectedItem]:checked").map(
					     function () {return this.value;}).get().join(",");
				var href = $(this).attr("href");
				href = href + "/" + ids;
				$(this).attr("href", href);

				return true;
			}
		}else{
			alert("please select an Item and try again");
		}
		
		return false;
	});	
	
	$('.more').click(function() {
		var id = $(this).attr('id');
		$("#more_dv_"+id).css('visibility','visible');
		$("#more_dv_"+id).mouseover(function() { $("#more_dv_"+id).css('visibility','visible'); });
		$("#more_dv_"+id).mouseout(function() {$("#more_dv_"+id).css('visibility','hidden');});
		});
	
	$("#btnDetailed").click(function(){
		var numberSelected = $(":checked", "table.recordTable tbody tr").length;
		if( numberSelected > 0){
			if(numberSelected == 1){
				var url = $(this).attr("href");
				url += "/"+$(":checked", "table.recordTable tbody tr").attr("value");
				window.location = url;
			}else{
				alert("please select one buddy and try again.");
			}
		}else{
			alert("please select only one buddy and try again.");
		}
		
		return false;
	});
	
});
