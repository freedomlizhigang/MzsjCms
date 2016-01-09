$(function(){
	$(".confirm").click(function(){
		if (!confirm("确实要删除吗?")){
			return false;
		}else{
			return true;
		}
	});
	$(".checkall").click(function(){
		$(".subcheck").prop("checked", this.checked);
	});
});
//导航高亮
function highlight_subnav(url){
    $('.left_list').find('a[href="'+url+'"]').addClass('active').closest('li').addClass('active');
}