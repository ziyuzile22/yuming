var dialog = {
	//去2头空格
	replaceall: function(str){
		return str.replace(/^\s+|\s+$/g,"");
	},

	//错误弹出层
	error : function(message){
		layer.open({
			content: message,
			icon: 2,
			title: '错误提示',
		});
	},

	//成功弹出层
	success : function(message, url){

		layer.msg(message, {
			icon: 1,
			time: 1000
		}, function(){
			location.href= url;
		})
	},

	//确认弹出层
	confirm: function(message, url){
		layer.open({
			content: message,
			icon: 3,
			btn: ['是', '否'],
			yes: function(){
				location.href = url;
			},
		});
	},


	//函数确认层
	confirmfunction: function(message, con){
		layer.open({
			content: message,
			icon: 3,
			btn: ['是', '否'],
			yes: con,
		});
	},


	//无需跳转到指定页面的确认弹出层
	toconfirm: function(message){
		layer.open({
			content: message,
			icon: 3,
			btn: ['确定'],
		});
	},



	
}