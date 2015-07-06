/**
 * 37wan充值中心
 */
 var sel_game_id = {};
var g_form_data = {pay_type_id:0,game_id:0,server_id:0,pay_for:'game',pay_user:'',actor_id:0,phone:'',umpay_type:'',pay_money:0,bank:''};
var g_username_checking = 0;//帐号检测阻塞变量，防止同时多个
/*手机号码验证*/
function checkMobile(mobile){
	 var reg=/^13[0-9]{1}[0-9]{8}$|14[57]{1}[0-9]{8}$|15[012356789]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$/;   //130--139。至少7位
	 return reg.test(mobile);
}

/*移动手机号码验证*/
function checkYdMobile(mobile){
	 var reg=/^13[^0-3]{1}[0-9]{8}$|14[^5]{1}[0-9]{8}$|15[^356]{1}[0-9]{8}$|18[^1069]{1}[0-9]{8}$/;   //移动
	 return reg.test(mobile);
}

function setCookie(name,value)//两个参数，一个是cookie的名子，一个是值
{
    var exp = new Date();    //new Date("December 31, 9998");
    exp.setTime(exp.getTime()-1);
    document.cookie = name + "="+ escape (value); //+ ";expires=" + exp.toGMTString()
}

function getCookie(name)//取cookies函数        
{
    var arr = document.cookie.match(new RegExp("(^| )"+name+"=([^;]*)(;|$)"));
    if(arr != null) return unescape(arr[2]); return null;
}

function fullbg(){
	if($("#fullbg").size()==0)
	{
		$("body").prepend('<div class="loading" id="loading">订单生成中，<br/>如果长时间未能响应，请[<a href="">点此刷新</a>]</div>'+
				'<div class="fullbg" id="fullbg"></div>');
	}
	$("#fullbg").show();
	fullbgresize();
}

function fullbgresize(){

	var bH2 = $(window).height() + $(window).scrollTop();
	var bW2 = $(window).width() + $(window).scrollLeft();
	$("#fullbg").css({width:bW2,height:bH2});
}

function fullbghide()
{
	$("#fullbg").hide();
}

/*function show_floatdiv(id)
{
	fullbg();
	$("#"+id).floatdiv().show();	
}*/

function close_floatdiv(o)
{
	$(o).hide();
	fullbghide();
}

function common_alert(title, cnt)
{
	$("#alert_common .alert_jump_top").html(title+'<a class="alert_confirm_close"></a>');
	$("#alert_common .alert_con").html(cnt);	
	show_floatdiv('alert_common');
}

/*微信支付弹窗*/
function wechat_alert(title, cnt)
{
	$("#alert_wechat .alert_jump_top").html(title+'<a class="wechat_confirm_close"></a>');
	$("#alert_wechat .alert_con").html(cnt);	
	show_floatdiv('alert_wechat');
}
/*收缩展开*/
function toggleMorePayType() {
	var evt = $(".left_li_nosept span");
	if ( $(evt).attr("var") == "0" ) {
		$("#left_menu").find(".left_li_state_hide").css({"display":"block"});
		$(".left_li_nosept").remove();
		//$(evt).html("收起更多方式").attr("var","1");
	} else {
		$("#left_menu").find(".left_li_state_hide").css({"display":"none"});
		$(evt).html("更多支付方式").attr("var","0");
	}
}

function select_pay_type(type_id)
{
	var left_id = '';
	var layout = arr_pay_type[type_id+""]['LAYOUT'];	
	if(typeof(layout.shen_zhou_tab)!='undefined' && layout.shen_zhou_tab)//神州支付的三个选项
	{
		for(var k in arr_pay_type)
		{
			var layout2 = arr_pay_type[k]['LAYOUT'];
			if(typeof(layout2.shen_zhou_tab)!='undefined' && layout2.shen_zhou_tab && arr_pay_type[k].LEFT_SHOW)
			{
				left_id = k;
				break;
			}
		}
	}
	else
	{
		left_id = type_id;
	}
	var o = $("#li_pay_type_"+left_id);	
	if(o.size()>0)//有在左侧的
	{
		$(".left_li_state_on").removeClass('left_li_state_on');
		$("#li_pay_type_"+left_id).addClass('left_li_state_on');		
	}
    show_game(type_id);
	show_pay_type_cnt(type_id);
	//充值返利-不支持游戏币、骏网、人工充值方式
	if(type_id==100000||type_id==23||type_id==13){
		$('#main_rebate').hide();
	}else{
		$('#main_rebate').show();
	}
}

// 不同的渠道显示不同的游戏
function show_game(type_id){
   // alert(type_id);
    var pay_type = arr_pay_type[type_id+''];
    if(!(pay_type.PAY_GAME==undefined || pay_type.PAY_GAME=='')){ // 游戏基地             
        var g188_game = pay_type.PAY_GAME.split(','); 
        //　所有拼音隐藏  
        $("#select_game div div.alert_pinyin").css('display','none');
        //所有游戏拼音tab隐藏
        $("#select_game div.alert_select_title ul li.alert_game").css('display','none');
        $("#select_game div.alert_select_title ul li.his_game").css('display','block');
        $("#select_game div div.alert_pinyin_list a").each(function(){
            flag = true;
            for(v in g188_game){                       
               if($(this).attr('val')==(g188_game[v]+'')){
                 flag = false;                   
               }      
            }
            if(flag){
                 $(this).css('display','none');
            }else{                
                $(this).parent().prev('div.alert_pinyin').css('display','block');               
                var tab = $(this).parent().parent().attr("id");                
                var tabId = tab.substr(9,1);        
                $("#game_tab_"+tabId).css('display','block');
                if(g188_first_game_tab==0){
                    g188_first_game_tab = tabId;
                }            
            }            
        });       
        $("#game_cnt_9999 a").each(function(){  //最近玩过的游戏
            flag = true;
            for(v in g188_game){                       
               if($(this).attr('val')==(g188_game[v]+'')){
                 flag = false;                   
               }      
            }
            if(flag){
               $(this).css('display','none'); 
            }  
        });          
    }else{
        $("#select_game div div.alert_pinyin_list a").each(function(){
          $(this).css('display','block');                  
        });  
        $("#game_cnt_9999 a").css('display','block');
        $("#select_game div.alert_select_title ul li.alert_game").css('display','block');     
        $("#select_game div div.alert_pinyin").css('display','block');
    }    
}

function login_alert()
{
	common_alert('登录', '该支付方式需要登录后才能充值。<br/><div class="bnt"><a class="alert_confirm_link_a" onclick="login();">马上登录</a></div>');
}

//充值方式内容显示
function show_pay_type_cnt(type_id)
{
	$(".float_div").hide();
	type_id = parseInt(type_id);
	var pay_type = arr_pay_type[type_id+''];
	var layout = pay_type['LAYOUT'];
	if(!layout)
	{
		layout = {
			shen_zhou_tab:false,
			pay_to_where:true,
			game_server:true,
			cnt_url:''
			};
		//return false;
	}
	if(pay_type.IS_MAINTAIN)//维护
	{
		$(".main").hide();	
		var pay_html = '';
		var count = 0;
		$(".left_li").each(function(i,e){//json的for方法顺序错乱，不好把握，各浏览器不兼容
			var id = $(this).attr('id');
			var mtype_id = id.replace('li_pay_type_','');
			var mpay_type = arr_pay_type[mtype_id];
			if(!mpay_type.IS_MAINTAIN)
			{
				count++;
				if(count<=3)
				{
					pay_html+="<a class=\"main_maintenance_button_a\" onclick=\"select_pay_type('"+mpay_type.ID+"');\">"+mpay_type.NAME+"</a>";
				}
			}
		});
		$(".main2").html('			<div class="main_maintenance">'+
				'<div class="main_maintenance_notice">抱歉～(>_<)系统维护中！</div>'+
				'<div class="main_maintenance_more">建议您尝试以下充值方式:</div>'+
			'	<div class="main_maintenance_button">'+pay_html+'</div>'+
			'</div>').show();		
		return ;
	}
	
	g_form_data.pay_type_id = type_id;
	setCookie('pay_typeid',type_id);
	
	
	//充值帐号
	$(".change_user").show();
	if(typeof(layout.pay_self_only)!='undefined' && layout.pay_self_only)
	{
		if(!g_logined_username)
		{
			login_alert();
		}
		else
		{
			$(".change_user").hide();
			if(g_form_data.pay_user!=g_logined_username)
			{
				set_pay_user(g_logined_username);//只能为当前登陆的帐号充			
			}
		}
	}
	if(type_id==100000)
	{
		$("#paltform_coin_balance").show();			
	}
	else
	{
		$("#paltform_coin_balance").hide();//平台币余额		
	}
	
	//人工汇款
	if(typeof(layout.cnt_url)!='undefined' && layout.cnt_url)
	{
		$(".main").hide();	
		$(".main2").html('').show();
		get_url_cnt(layout.cnt_url);
		return ;
	}
	else
	{
		$(".main2").hide();	
		$(".main").show();		
	}

	//神州支付的三个选项
	if(typeof(layout.shen_zhou_tab)!='undefined' && layout.shen_zhou_tab)
	{
		$(".main_shenzhou_state_on").removeClass('main_shenzhou_state_on');
		$("#shen_zhou_tab_"+type_id).addClass('main_shenzhou_state_on');		
		$("#main_shenzhou").show();
	}
	else
	{
		$("#main_shenzhou").hide();		
	}
	
	//充到哪里
	if(typeof(layout.pay_to_where)=='undefined' || layout.pay_to_where==true)//默认打开
	{
		$("#main_payFor").show();	
		if(g_form_data.pay_for=='platform')
		{
			$("#main_ptNotice").show();			
		}
	}
	else
	{
		$("#main_payFor").hide();
		$("#main_ptNotice").hide();
		select_pay_for('game');
	}
	
	//移动支付消费类型
	if(typeof(layout.umpay)=='undefined' || !layout.umpay)
	{
		$("#umpay").hide();
	}
	else
	{
		select_umpay_type('times');//默认按次消费
		$("#umpay").show();		
	}	
	//手机号码
	if(typeof(layout.mobile_phone)=='undefined' || !layout.mobile_phone)
	{
		$("#main_mobile_phone").hide();
	}
	else
	{
		$("#main_mobile_phone").show();		
	}		
	//168固话充值说明
	if(typeof(layout.desc_168_phone)=='undefined' || !layout.desc_168_phone)
	{
		$("#desc_168_phone").hide();
	}
	else
	{
		$("#desc_168_phone").show();		
	}		
	//金额列表
	var html_pay_money= '';
	g_form_data.pay_money = 0;//重置金额
	if(pay_type)
	{
		var money_unit = '元';
		if(!(typeof(layout.money_unit)=='undefined' || !layout.money_unit))
		{
			money_unit = layout.money_unit;
		}
		$("#money_unit").html(money_unit);
		for(var i=0;i<pay_type.CARDS.length;i++)
		{
			var money = pay_type.CARDS[i];
			var money_text = money;
			var check = '';
			if(type_id*1==29)//电信固话手机充值
			{
				money_text = money * 3/2;
			}
			if(type_id*1==41&&g_form_data.pay_money==0&&money==10){//MO9默认选择10元
				g_form_data.pay_money = money;
				check = ' on ';
			}
			if(g_form_data.pay_money==0 && (money==100 || i==pay_type.CARDS.length-1))//选中100块 或最后一个
			{
				g_form_data.pay_money = money;
				check = ' on ';
			}
			html_pay_money += '<a class="main_money_a'+check+'" val="'+money+'" id="money_'+i+'" onclick="select_money('+i+');">'+money_text+money_unit+'</a>';
		}
	}
	$("#main_money_list").html(html_pay_money);
	$("#other_money").val('');
	$("#money_9999").removeClass('on');	
	//天宏一卡通
	if(typeof(layout.tian_hong_card)=='undefined' || !layout.tian_hong_card)
	{
		$("#tianhongcard").hide();
	}
	else
	{
		$("#tianhongcard").show();		
	}			
	//其他金额
	if(typeof(pay_type.CAN_INPUT )=='undefined' || !pay_type.CAN_INPUT )
	{
		$("#main_other_money").hide();		
	}
	else
	{
		$("#main_other_money").show();		
	}	

	//银行列表
	if(typeof(layout.bank)=='undefined' || !layout.bank)
	{
		$("#main_bank").hide();		
	}
	else
	{
	    g_form_data.bank = false;
        $("#main_bank a").removeClass("on"); 
		$("#main_bank").show();
        $(".main_bank div").hide();
        $('.pay_way_bank'+type_id).show();	
      	
	}
	//说明文字
	if(layout.desc)
	{
		$('.main_explain').html(layout.desc).show();
	}
	else
	{
		$('.main_explain').hide();	
	}
	if(layout.help_url)
	{
		$('.main_more_help a').attr('href', layout.help_url);
		$('.main_more_help').show();
	}
	else
	{
		$('.main_more_help').hide();	
	}	
	//展开左侧菜单
	if($("#li_pay_type_"+type_id).size()>0 && $("#li_pay_type_"+type_id).is(":visible")==false)
	{
		toggleMorePayType();
	}
    //重置游戏相关参数
    if(type_id==34 && !(pay_type.PAY_GAME==undefined || pay_type.PAY_GAME=='')){ // 游戏基地
        var g188_game = pay_type.PAY_GAME.split(',');      
        flag = false;        
        for(v in g188_game){
            if(g_form_data.game_id==g188_game[v]){
                flag = true;               
            }
        }           
        if(g_form_data.game_id && g_form_data.game_id!=undefined && !flag){   
            alert("此游戏不支持该充值方式");
            $("#main_select_game").html("请选择充值的游戏");
            $("#main_select_server").html('请选择游戏服务器');
            $("#main_select_game").click();    
            select_game_tab(g188_first_game_tab);  
			
        }else{
            select_game(g_form_data.game_id,g_form_data.server_id, g_form_data.actor_id);
        }        
        if(g_form_data.game_id==0 || g_form_data.game_id==undefined){
            if(!g_username){
                select_game_tab(g188_first_game_tab);
            }else{
                select_game_tab(9999);
            }
        }                     
    }else{
        var temp = g_form_data.game_id;
        g_form_data.game_id = 0;
        select_game(temp,g_form_data.server_id, g_form_data.actor_id);
    } 
	
	
	/*if(type_id==25)
	{
		$(".main .notice").show();
	}
	else
	{
		$(".main .notice").hide();
	}*/
}
/*url读内容*/
function get_url_cnt(url)
{
	$.ajax({
		type:'get',
		url:url,
		dataType:'html',
		success:function(html)
		{
			$(".main2").html($.trim(html));//一定要trim，不然在ie9以下都会出面插入内容空白的问题
		}
	})
}
/**
显示角色列表
*/
function show_role_input()
{
	var game = null;
	try{
		game = g_game_data[g_form_data.game_id];
	}catch(e){}
	if(game && game.role_select && game.role_select!='0')
	{
		$(".main_user_role").show();
	}
	else
	{
		$(".main_user_role").hide();	
	}
}
/*支付到游戏还是平台*/
function select_pay_for(type)
{
	g_form_data.pay_for = type;
	var o = $("#pay_for_"+type);
	$(".main_payFor_a").removeClass("on");
	o.addClass("on");
	if(type=="game"){
		var game = null;
		try{
			game = g_game_data[g_form_data.game_id];
		}catch(e){}
		//显示元宝名		
		if(game && game.coin_name)
		{
			$("#coin_name").html(game.coin_name);
		}
		else
		{
			$("#coin_name").html('元宝');
		}
		$("#main_select").show();//游戏服选择
		show_role_input();		//角色列表
		$("#main_ptNotice").hide();//平台币提示

	}else{
		$("#coin_name").html('游戏币');
		$("#main_ptNotice").show();
		$("#main_select").hide();
		$(".main_user_role").hide();//隐藏角色列表		
	}
	//计算游戏币
	calculate_coin_num();
}
/*获取游戏列表并显示*/
function get_server(s_game_id,server_id,actor_id)
{
	g_form_data.server_id = 0;//清空数据
	if(g_my_game){//读取最近玩过的游戏
		$("#server_cnt_9999").html('');	
		for(var i=0;i<g_my_game.length;i++){
			var d= g_my_game[i];
			if(d.id==s_game_id){
				if(d.servers){
					var html = '';
					for(var j=0;j<d.servers.length;j++){
						html+='<a val="'+d.servers[j].id+'" onclick="select_server(\''+d.servers[j].id+'\',-9999);" >'+d.servers[j].name+'</a>';
					}
					$("#server_cnt_9999").html(html);	
				}
				break;
			}
		}		
	}
	$("#select_server .st").remove();
	$("#select_server .sl").remove();	
	$("#main_select_server").removeClass("main_select_on").html("选择游戏服务器");
	$.ajax({
		type:'get',
		url:'/controller/game.php?action=server_list_tab&gameid='+s_game_id,
		dataType:'json',
		success:function(json){
			//重新清理标签
			$("#select_server .st").remove();
			$("#select_server .sl").remove();	
			$("#main_select_server").removeClass("main_select_on").html("选择游戏服务器");
			
			var tab_html = server_html = '';
			var tab_count = json.data.length;
			for(var i=0;i<tab_count;i++){ 
				var tab_data = json.data[i];
				tab_html+='<li class="alert_server st" id="server_tab_'+i+'" onclick="select_server_tab('+i+');">'+json.data[i].title+'</li>';
				var server_count = json.data[i].server_list.length;
				var html = '',
					aHtml =[];
				for(var j=0;j<server_count;j++){
					var d = json.data[i].server_list[j];
					aHtml.push('<a val="'+d.id+'" onclick="select_server(\''+d.id+'\',-9999);" id="server_'+d.id+'">'+d.name+'</a>');
				}
				server_html+='<div class="alert_list server_list sl" id="server_cnt_'+i+'">'+aHtml.join('')+'</div>';
			}
			var key_default_id = 0;
			var key_default_name = 0;
			var key_tes = {};
			var iikey = 1;
			var htmlll = '';
			var last_key = '';
			var last_id = '';
			var li_page = 1;
			for(var key in json.msg){
			    iikey++;
			    if(key == '-1'){
			        key_default_id = key_tes[json.msg[key]['name']];
			        key_default_name = json.msg[key]['name'];
			    } else{
    			    htmlll += '<li data-opt="'+iikey+'">'+key+'</li>';
    			    sel_game_id[iikey] = json.msg[key];
    			    key_tes[key] = iikey;
    			    last_key = key;
    			    last_id = iikey;
			    }
            }
            li_page = Math.ceil( (iikey-1) / 10 );
        	$( "#alert_option_bg" ).css( "left", 543 - (( li_page - 1 ) * 78 ));
        	$( "#alert_option_dom" ).css( "width", 78 * li_page );

            $( "#alert_server_fastin").val("");
        	//select框下拉列表 data-opt为对应的赋值
        	$( "#alert_option_dom" ).html(htmlll);
        	//select框的默认值
        	if(key_default_id > 0){
        	    $( "#alert_select_con" ).html(key_default_name).attr( "data-areaType", key_default_id);
        	}else{
        	    $( "#alert_select_con" ).html(last_key).attr( "data-areaType", last_id);
            }

			$(".alert_server_sort").append(tab_html);
			$("#select_server").append(server_html);
			if(server_id && server_id>0)
			{
				select_server(server_id,0);
			}
			else if($("#server_cnt_9999").html()=='')
			{
				select_server_tab(0);
			}
			else
			{
				select_server_tab(9999);
			}
			get_role_list(actor_id);			
		}
	});

}
/*选择游戏Tab页*/
function select_game_tab(tab_index)
{
	var o = $("#game_tab_"+tab_index);
	o.addClass("on").siblings(".alert_game").removeClass("on");
	$("#game_cnt_"+tab_index).show().siblings(".game_list").hide();
}
/*选择游戏*/
function select_game(game_id,server_id, actor_id)
{
	//if(!game_id)return;
	//保存数据
	if(game_id && g_form_data.game_id != game_id)
	{
		var game = null;
		try{
			game = g_game_data[game_id];
		}catch(e){
			return false;
		}
		g_form_data.game_id = game_id;	
		var o = $("#game_"+game_id);
		$(".game_list a").removeClass("on");
		$(".game_list a[val='"+game_id+"']").addClass("on");
		$("#main_select_game").addClass("main_select_on").html(o.text());//"<span class='select_on'></span>"+
		if(game && game.coin_name){//显示元宝名		
			$("#coin_name").html(game.coin_name);
		}else{
			$("#coin_name").html('元宝');
		}
		//角色选择
		$("#user_role_list").html('');
		show_role_input();
		//获取游戏列表
		get_server(game_id, server_id, actor_id);
		if(g_form_data.pay_type_id==30)//移动充值 消费类型处理
		{		 
			if(game && game.month_card_content)
			{			
				$("#umpay_gift_cnt").html(game.month_card_content.join("<br>"));
			}
			else
			{
				$("#umpay_gift_cnt").html('该游戏暂不支持包月消费');
			}
		}
		//切到对应tab
		var parent_id = o.parent().parent().attr('id');
		var arr = parent_id.split('_');
		if(arr&&arr.length==3)
		{
			select_game_tab(arr[2]);
		}
	}
	select_umpay_type(g_form_data.umpay_type);		
	//计算游戏币
	calculate_coin_num();
	
	
	
}
function select_server_tab(tab_index)
{
	var o = $("#server_tab_"+tab_index);
	o.addClass("on").siblings(".alert_server").removeClass("on");
	$("#server_cnt_"+tab_index).show().siblings(".server_list").hide();
}
/*选择游戏服，并关闭浮框 flag表人工点击 不切换tab*/
function select_server(server_id,flag)
{
	var o = $("#server_"+server_id);
	if(o.size()<1)
	{
		return false;
	}
	g_form_data.server_id = server_id;	
	//选中服
	$(".server_list a").removeClass("on");
	$('.server_list a[val="'+server_id+'"]').addClass("on");	
	$("#server_id").val(server_id);
	$("#alert_arrow").hide();
	$("#select_game").hide();
	$("#select_server").hide();
	$("#main_select_server").addClass("main_select_on").html($(o).text());
	//获取角色列表
	get_role_list();	
}
/*获取角色*/
function get_role_list(actor_id)
{
	g_form_data.actor_id ='';
	var game_id = g_form_data.game_id;
	var server_id = g_form_data.server_id;	
	var pay_user = g_form_data.pay_user;	
	//显示角色
	var game = null;
	try{
		game = g_game_data[game_id];
	}catch(e){}

	if(server_id && pay_user && game && game.role_select)
	{
		$("#user_role_list").html('');	
		$("#user_role").val('请选择角色');
		$("#user_role").attr('val','');		
		$.ajax({
			type:'get',
			url:'/controller/actor.php?gameid='+game_id+'&serverid='+server_id+'&username='+pay_user,
			dataType:'json',
			success:function(json){
				var html = "";
		        var only_actor_id = 0;
				for(var i=0;i<json.data.length;i++)
				{
					var d = json.data[i];
				    only_actor_id = d.id;
					html+='<a id="actor_'+d.id+'" val="'+d.id+'" title="'+d.name+'" onclick="select_actor(\''+d.id+'\');">'+d.name+'</a>';
				}
				$("#user_role_list").html(html);
				if(actor_id > 0){
				    select_actor(actor_id);
				}else if(json.data.length == 1){
				    select_actor(only_actor_id);
				}
			}
		});
	
	}
}
/*检查充值帐号*/
function check_user(username)
{
	if(username)
	{
		if(g_username_checking){
			return false;
		}
		g_username_checking = 1;
		g_form_data.pay_user = username;//预存 用于刚开始获取角色列表
		$.ajax({
			type:'get',
			url:'/controller/user.php?action=check_user&user_name='+username,
			dataType:'json',
			success:function(json){
	
				if(json.code!=1)
				{
					g_form_data.pay_user = '';
					alert('帐号['+username+']不存在');
					$(".main_user_input").show();
					$(".main_user_account").hide();	
					//$("#username").focus();
				}
				else
				{
					g_form_data.pay_user = username;
					var show_text = username;
					if(show_text.length>20)
					{
						show_text = show_text.substr(0,20)+'..';
					}	
					$("#username").val(username);	
					$("#login_account").html(show_text);
					$(".main_user_input").hide();
					$(".main_user_account").show();
					//获取角色列表
					get_role_list();					
				}
				g_username_checking = 0;
			},
			error:function (XMLHttpRequest, textStatus, errorThrown){
				alert('检测帐号失败，网络异常，请重试！');
				g_username_checking = 0;
			}
		});	
	}
}
//设置支付帐号
function set_pay_user(username)
{
	if(username){
		check_user(username);
	}else{
		$(".main_user_input").show();
		$(".main_user_account").hide();	
	}
	//充值返利
	if(username!=g_logined_username){
		$('#main_rebate').hide();
	}else{
		$('#main_rebate').show();
	}
}
//选择角色
function select_actor(actor_id)
{
	//保存数据
	var actor = $('#actor_'+actor_id).attr("title");
	if(!actor)
	{
		actor = '请选择角色';
		actor_id = '';
	}
	g_form_data.actor_id = actor_id;	
	$("#user_role").val(actor);
	$("#user_role_list").hide();
}
//移动支付类型选择
function select_umpay_type(type)
{
	if(g_form_data.pay_type_id!=30)//移动充值 消费类型处理
	{
		return false;
	}
	var game = null;
	try{
		game = g_game_data[g_form_data.game_id];
	}catch(e){}
	if(!game || !game.month_card_content)
	{
		type = 'times';
		$("#umpay_type").hide();
	}
	else
	{
		//$("#umpay_type").show();	
	}
	g_form_data.umpay_type = type;		
	var o = $("#umpay_type_"+type);

	o.addClass('on');
	o.siblings(".on").removeClass('on');
	
	if(type=='times')
	{
		$("#main_money").show();
		$("#umpay_gift").hide();		
	}
	else
	{
		$("#umpay_gift").show();
		$("#main_money").hide();	
	}
}

//选择金额 -1表输入金额
function select_money(index)
{
	var money = 0;
	$(".main_money .on,.main_other_money .on").removeClass('on');
	if(index==-1){
		money = $("#other_money").val();
		$("#money_9999").addClass('on');		
	}else{
		//money = $("#other_money").val();	
		var o = $("#money_"+index);
		money = o.attr('val');
		o.addClass("on");	
		$("#other_money").val("");
	}
	g_form_data.pay_money = money;
	
	calculate_coin_num();
}
//计算元宝数
function calculate_coin_num()
{
	var money_convert = 10;
	var coin = 0,factor=1,coin_rate = 0,exchange_rate = 10;
	
	var pay_type = arr_pay_type[g_form_data.pay_type_id+''];
	var layout = pay_type['LAYOUT'];
	//兑换比例
	if((typeof(layout.no_exchange_rate)=='undefined' || !layout.no_exchange_rate ) && g_form_data.game_id)
	{
		$(".proportion").show();		
	}
	else
	{
		$(".proportion").hide();		
	}	
	try{
		factor = arr_pay_type[g_form_data.pay_type_id+'']['FACTOR'];
		if(g_form_data.pay_for=='platform')//充值到平台币
		{
			coin_rate = 10;//平台币充值比例 1：10				
		}
		else if(g_form_data.game_id)
		{
			var game = g_game_data[g_form_data.game_id+''];
			coin_rate = game['coin_rate'];	
			if(g_form_data.pay_type_id==23 || g_form_data.pay_type_id==3 || g_form_data.pay_type_id==45)//骏网
			{
				if(game.not_float_paymoney)
				{
					factor = 0.8;
				}			
			}
		}
	}catch(e){}
	exchange_rate = factor * coin_rate;
	$("#exchange_rate").html(exchange_rate);
	coin = parseInt(g_form_data.pay_money * exchange_rate,10);
	$("#money_convert").html(coin);
	//充值返利-金额选择实时计算提示
//rebate_count_tip($('.rebate_itme_a_on'),g_form_data.pay_money,g_form_data.pay_type_id,false);//tip
	
	//非充值到37游戏币&&非37游戏币充值,获取[选择金额]旁边的返利提示
	if(!(g_form_data.pay_for === 'platform') && !(g_form_data.pay_type_id === 100000)){
		getRedEvnTip(factor,g_form_data.pay_money);
	}else{
		$("#red_env_tip").hide();
	}
	//检查渠道ID，并且充值金额大于100文显示使用红包
	var mainRedEnv = $("#main_red_envelopes"),
		mainRedEnvLen = mainRedEnv.length;
	if(+g_form_data.pay_money >= 100 && checkChannel(g_form_data.pay_type_id) && mainRedEnvLen){
		mainRedEnv.show();
	}else{
		mainRedEnv.hide();
		
	}
	
	
	
}
/*选择银行*/
function select_bank(key)
{
	if($('#bank_'+g_form_data.pay_type_id+'_'+key).size()==0)
	{
		return false;
	}
	
/*	if(key=='CCB')
	{
		common_alert('支付宝网上银行', '<div style=" font-size: 14px;margin-top:40px;">支付宝网上银行-建设银行正在维护，如需继续使用<br/>建设银行卡充值的用户请选择<a class="a" onclick="close_floatdiv($(\'#alert_common\').parent());select_pay_type(1);"><span style="color:#2956AF;text-decoration:underline;">易宝网上银行</span></a>。</div>');//
		return false;
	}*/ 
	g_form_data.bank = key;
	$("#main_bank a").removeClass("on");
	$('#bank_'+g_form_data.pay_type_id+'_'+key).addClass("on");
}
/*支付宝快捷支付*/
function alipay_fast_submit()
{
	var order_id = $("#confirm_order_id_input").val();
	$.ajax({
		 type: "GET",
		 url: "/alipay_fast/agent/dut_agent.php",
		 dataType: "html",
		 data: "order_id="+order_id+"&f_token="+g_f_token,
		 success: function(data){
			if (data == 'SUCCESS'){
				alert("请您按照短信提示回复短信，即可完成充值。");
			} else if (data == 'SYS_BUSY'){
				alert("系统繁忙，请稍候再试。");
			} else if (data == 'ALIPAY_BUSY'){
				alert("支付宝系统繁忙，请稍候再试。");
			} else if (data == 'NO_SIGN'){
				alert("您还未完成签约，请回复短信完成签约。");
			} else {
				alert("系统异常，请稍候再试。");
			}
			close_floatdiv($("#alert_confirm").parent());
		 } 
	});
}

var g188_send_msg = {
    limit_time:60,
    time:60,
    falg:true,
    terval:false,
    code_confirm:true,
    g188_send_msg_again:function(){
        if(g188_send_msg.falg){
            g188_send_msg.falg= false;
            g188_send_msg.terval = setInterval("g188_send_msg.start()",1000);
        }
    },
    start:function(){
        g188_send_msg.time--;
        $("#send_msg_again").val(g188_send_msg.time+"秒后重新发送");   
        if(g188_send_msg.time<=0){
            clearInterval(g188_send_msg.terval);
            g188_send_msg.falg= true;   
            $("#send_msg_again").val("重新发送");  
            g188_send_msg.time = g188_send_msg.limit_time; 
        }              
    },
    //短信支付（游戏基地） 确认
    g188_fast_submit:function(){
    	var order_id = $("#confirm_order_id_input").val();
        $("#alert_confirm").hide();
        common_alert('短信验证','<div class="g188_code_box"><span style="" id="g188_tip"><img src="static/image/loading.gif" style=""><font style="">正在发送短信，请稍候</font></span><input type="button" value="60秒后重新发送" id="send_msg_again"><br />请输入短信验证码：<input type="text" style="" value="" class="main_input_input" id="g188_code"><a href="#" class="alert_confirm_link_a" id="g188_code_confirm" style="">确认</a></div>'); 
        g188_send_msg.g188_send_msg_again();
        //return ;
    	$.ajax({
    		 type: "GET",
    		 url: "/g188_pt/g188.php",
    		 dataType: "json",
    		 data: "order_id="+order_id+"&action=purchase&f_token="+g_f_token,
    		 success: function(data){
    			if (data.code == '1'){		
                    $("#g188_tip").html("<font>验证码已发送，请查看手机</font>");
                    $("#send_msg_again").click(function(){
                        if(g188_send_msg.falg){
                            g188_send_msg.g188_fast_submit();
                        }
                    });
                    $("#g188_code_confirm").click(function(){
                        if(!g188_send_msg.code_confirm){
                            alert("正在发送，请稍候");
                            return;
                        }  
                        
                        var code = $("#g188_code").val();
                        var reg = /^[\d]{6}$/;
                        if(code=='' || code==undefined || !reg.test(code)){
                            alert("请输入正确的短信验证码");
                            $("#g188_code").val('');
                            return false;
                        }                   
                        g188_send_msg.code_confirm = false;
                        $("#g188_code").attr('disabled','disabled');
                        $.ajax({
                            type:"GET",
                            url:"/g188_pt/g188.php",
                            dataType:"json",
                            data: "order_id="+order_id+"&action=confirm&verifycode="+code+"&f_token="+g_f_token,
                            success: function(data){
                                g188_send_msg.code_confirm = true;
                                $("#g188_code").removeAttr('disabled');
                                if (data.code == '1'){
                                    window.location.href=$(".alert_jump_link .pay_result").attr('href');
                                }else{
                                    if(data.code==-2){
                                        alert(data.msg+"["+data.data+"xxx"+data.msgCode+"]");
                                    }else{
                                        alert(data.msg);
                                    }  
                                }
                            }
                        });
                                            
                    });          		
    			} else {
    			     
                    close_floatdiv($("#alert_common").parent());
                    if(data.code==-2){
    				    alert(data.msg+"["+data.data+"xxx"+data.msgCode+"]");
                    }else{
                        alert(data.msg); 
                    }
    			}           
    			close_floatdiv($("#alert_confirm").parent());
    		 } 
    	});    
    }
};

/*微信扫码支付*/
function wechat_submit()
{
	var order_id = $("#confirm_order_id_input").val();
    $("#alert_confirm").hide();
	show_floatdiv("loading");
	$.ajax({
		 type: "GET",
		 url: "/controller/paygate.php",
		 dataType: "html",
		 data: "action=go_pay&order_id="+order_id+"&f_token="+g_f_token,
		 success: function(data){
			close_floatdiv($("#loading").parent());
			if (data.match("^\{(.+:.+,*){1,}\}$")){
                res = JSON.parse(data);
                if(typeof(res) === 'string'){
                    res = JSON.parse(res);
                }

                if(res.status === 500){
                    _content = res.msg;
                    $('body').popUpWin({
                        content:res.msg
                    });
                }else{
                    new QRCode({
                        qrUrl:res.code_url,
                        qrImgUrl:res.code_img_url,
                        statusUrl:res.code_status
                    });
                }
            }
		 } 
	});
}

 
/*确认订单提交*/
function confirm_submit(){
	if($("#platform_pass").is(":visible"))//输入平台币密码
	{
		var p_code = $("#platform_pass").val();
		if(!p_code){
			alert('请你输入37游戏币密码');
			$("#platform_pass").focus();
			return false;
		}
		if ( p_code.length < 6 || p_code.length > 20 ||p_code.match(/^[A-Za-z_]+$/g) ||p_code.match(/^[0-9]+$/g)) {
			alert("您输入的37游戏币支付密码不符合规则！");
			return false;
		}else{
			$("#p_code").val(hex_md5(p_code.toLocaleLowerCase()));
		}
	}
	var form_data = $("#alert_confirm").data('form_data');
	if(form_data.pay_type_id==32)//支付宝快捷支付
	{
		alipay_fast_submit();
		return ;
	}
	if(form_data.pay_type_id==34)//短信支付（游戏基地）
	{
		g188_send_msg.g188_fast_submit();
		return ;
	}    
	if(form_data.pay_type_id==44)//微信支付
	{
        wechat_submit();
		return ;
	}    
	$("#payform").submit();
	$("#alert_confirm").hide();
	show_floatdiv("alert_jump");
	var pay_type = arr_pay_type[g_form_data.pay_type_id+''];
	if(typeof(pay_type.LAYOUT.help_url )=='undefined')
	{
		$(".alert_jump_link .pay_error").hide();
	}
	else
	{
		$(".alert_jump_link .pay_error").attr('href', pay_type.LAYOUT.help_url);
		$(".alert_jump_link .pay_error").show();		
	}
}
/*支付宝快捷支付验证*/
function alipay_fast_query_sign()
{
	if(!g_logined_username)
	{
		login_alert();
	}
	else
	{
		$.ajax({
			 type: "GET",
			 url: "/alipay_fast/customer_sign/query_sign.php",
			 dataType: "html",
			 data: {login_account:g_logined_username},//
			 success: function(data){
				 //data=1;
				if (data == "1"){
					create_order();
				} else {
					common_alert('支付宝快充', '支付宝快充是一种安全，快捷的充值方式，将指定的37游戏帐号和支付宝帐号或者银行卡进行绑定，充值时只需回复手机验证码即可完成充值。<br/><div class="bnt"><a href="/alipay_fast/customer_sign/dut_customer_sign.php?login_account='+g_logined_username+'" class="alert_confirm_link_a" target="_blank">立即免费绑定</a></div>');
					return;			
				}
			 } 
		});			
	}
}

//充值返利-返利劵统计提示公共函数
function rebate_count_tip(obj,pay_money,pay_type_id,is_click){
	if(pay_type_id==22){//美元
		pay_money*=6;
	}
	pay_money*=arr_pay_type[pay_type_id+'']['FACTOR'];//费率
	var rebate_ratio=obj.attr('val');
	var input_ratio=$('#rebate_ratio').val();
	if(rebate_ratio==100&&pay_money<2000){
		alert('需至少充值2000元才能使用');
		if(!is_click){
			iniRebateRatio();
		}
		return false;
	}else if(rebate_ratio==500&&pay_money<10000){
		alert('需至少充值10000元才能使用');
		if(!is_click){
			iniRebateRatio();
		}
		return false;
	}else if(rebate_ratio==1000&&pay_money<20000){
		alert('需至少充值20000元才能使用');
		if(!is_click){
			iniRebateRatio();
		}
		return false;
	}
	$('#rebate_ratio').val(rebate_ratio);
	$('.rebate_itme_a').removeClass('rebate_itme_a_on');
	obj.addClass('rebate_itme_a_on');
	var rate_ptb=0;
	if(rebate_ratio>1){
		rate_ptb=rebate_ratio*10;//现金卷
	}else{
		rate_ptb=rebate_ratio*pay_money*10;
		rate_ptb=parseInt(rate_ptb);
	}
	if(rate_ptb<=0){
		rebate_tip='';
		iniRebateRatio();
	}
	var rebate_tar=$('.rebate_itme_a_on').next('span.rebate_tip');
	$('.rebate_tip').hide();
	//var rebate_tip='使用该券后，本笔充值将获得'+rate_ptb+'个37游戏币返利。';
    if($("#pay_for_game").hasClass("on"))
    	var rebate_tip='使用该券后，返利金额将发放到游戏中。';
    else
        var rebate_tip='使用该券后，返利金额将发放到游戏币中。';
	rebate_tar.show().html(rebate_tip);
}

function getRedEvnTip(scale,val){
	var redEnvTip = $("#red_env_tip"),
		n = scale*val,
		str0 = '2015年3月7日当天充值，可获',
		str1 = '',
		str2 ='返利 <a href="http://bbs.37.com/thread-1076377-1-1.html" target="_blank">查看详情</a>';
	if(redEnvTip.length === 0){
		return;
	}
	if(n<100){
		redEnvTip.hide();
		return;
	}else if((n >= 100)&&(n<1000)){
		str1 = "7%";
	}else if((n >= 1000)&&(n<5000)){
		str1 = "13%";
	}else if((n >= 5000)&&(n<20000)){
		str1 = "17%";
	}else if(n >= 20000){
		str1 = "21%";
	}else{
		redEnvTip.hide();
		return;
	}
	
	redEnvTip.html(str0 + str1 + str2).show();
}

function checkChannel(n){
	var channelId = [25,1,7,35,43,44,32],
		//channelId = [25,1,7,35,43,44,32,19,17,12,31,20,10,24],
		len = channelId.length,
		flag = false,
		i;
	for (i=0;i<len;i++){
		if(+n === channelId[i]){
			flag = true;
			break;
		}
	}
		
	return flag;
}

function showRedEnvTip(ul,o){
	var rebateRatio = $("#rebate_ratio");
	ul.find(".rebate_tip").hide();
	ul.find("a").removeClass("rebate_itme_a_on");
	o.addClass("rebate_itme_a_on");
	o.next().show();
	rebateRatio.val(o.attr("val"));
}

//充值返利-初始化返利劵选择
function iniRebateRatio(){
	$('#rebate_ratio').val(0);
	$('.more_rebate').hide();
	$('.rebate_br').show();
	$('.rebate_itme_a').show();
	$('.rebate_itme_a').removeClass('rebate_itme_a_on');
	$('.rebate_no_use').addClass('rebate_itme_a_on');
	$('.rebate_tip').hide();
}

//提交数据 生成订单
function create_order()
{
	var game_id = g_form_data.game_id,server_id=g_form_data.server_id,phone='';
	if(g_form_data.pay_for=='game')
	{
		if(!g_form_data.game_id)
		{
			alert('请选择游戏');	
			$("#main_select_game").click();
			return;
		}
		if(!g_form_data.server_id)
		{
			alert('请选择游戏服务器');	
			$("#main_select_server").click();
			return;		
		}
	}
	else
	{
		game_id = 100000;
		server_id = 100000;		
	}
	if($(".main_user_input").is(":visible")==true)
	{
		alert('请先确定充值帐号');
		//$("#username").focus(); safri重复弹提示
		return;
	}
	if($(".main_user_role").is(":visible")==true && !g_form_data.actor_id)
	{
		alert('请选择角色');
		$("#username").focus();
		return;
	}	
	//移动手机话费支付
	if($("#mobile_phone").is(":visible")==true)
	{
		phone = $("#mobile_phone").val();
		if(!phone)
		{
			alert('请输入手机号码');	
			$("#mobile_phone").focus();			
			return;			
		}
		if(!checkMobile(phone))
		{
			alert('请确认手机号码正确');	
			$("#mobile_phone").focus();			
			return;	
		}
        if((g_form_data.pay_type_id==34 || g_form_data.pay_type_id==30) && !checkYdMobile(phone)){
 			alert('请输入正确的移动手机号码');	
			$("#mobile_phone").focus();			
			return;	           
        }
	}		
	var pay_money = g_form_data.pay_money;
	if(pay_money<=0)
	{
		alert('请输入充值金额');	
		return;
	}	
	if(g_form_data.pay_type_id==30 && g_form_data.umpay_type=='month')//移动手机话费支付包月30元
	{
		pay_money = 30;
	}
	else if(g_form_data.pay_type_id==100000)//平台币
	{
		if(pay_money%10!=0)
		{
			alert('充值的37游戏币必须为10的倍数!');
			return;
		}
		else if(pay_money<100)
		{
			alert('充值的金额不能少于100游戏币!');
			return;			
		}
		else if(g_platform_coin<100)
		{
			alert('您的帐户余额不足，请选择其他充值方式！');
			return;
		}
	}
	else if(pay_money<10 && $("#main_money_list a[val='"+pay_money+"']").size()==0)
	{
		alert('充值的金额不能少于10元!');
		return;
	}
	else if(g_form_data.pay_type_id==32 && pay_money>5000)
	{
		alert('充值金额超出支付宝快充范围[10-5000元]，请重新提交。');
		return;
	}
	else if(g_form_data.pay_type_id==41&&pay_money>2000)
	{
		alert('MO9的充值金额不能大于2000元!');
		return;
	}
	//银行
	if($(".main_bank").is(":visible")==true && !g_form_data.bank && g_form_data.bank!='undefined')
	{
		alert('请选择银行');
		return;
	}
	if($("#tianhongcard").is(":visible")==true)//天宏一卡通
	{
		var card_no = $("#tianhongcardno").val();
		var card_pwd = $("#tianhongcardpwd").val();	
			var regTianhongcardno = /^[A-Za-z0-9]+$/;
			var regTianhongcardpwd = /^[0-9]+$/;
			if (!regTianhongcardno.test(card_no)){
				alert("请输入正确的卡序列号！");
				$("#tianhongcardno").focus();
				return false;
			}
			if (!regTianhongcardpwd.test(card_pwd)){
				alert("请输入正确的卡密码！");
				$("#tianhongcardpwd").focus();
				return false;
			}	
		$("#th_cardno").val(card_no);
		$("#th_cardpwd").val(card_pwd);		
	}
	//缓存页面信息
	var form_data = g_form_data;//缓存数据
	var game_name = $("#main_select_game").html();
	var server_name = $("#main_select_server").html();
	var money_unit = $("#money_unit").html();
	var coin_name = $("#coin_name").html();
	var coin = $("#money_convert").html();
	var rebate_ratio=$('#rebate_ratio').val();
	show_floatdiv("loading");
	$.ajax({
		type:'post',
		url:'/controller/order.php',
		data:{
			action:'create_order',
			user_name:g_form_data.pay_user,
			game_id:game_id,
			server_id:server_id,
			money:pay_money,
			pay_type:g_form_data.pay_type_id,
			pay_bank:g_form_data.bank,
			actor:g_form_data.actor_id,	
			phone:phone,
			pay_for:g_form_data.pay_for,
			f_token:g_f_token,
			umpay_type:g_form_data.umpay_type,
			rebate_ratio:rebate_ratio
		},
		dataType:'json',
		success:function(json){
			var rebate_ratio = $("#rebate_ratio");
			close_floatdiv($("#loading").parent());
			if(json.code==1)//生成订单成功
			{	
				var pay_type = arr_pay_type[form_data.pay_type_id],
					red_money = rebate_ratio.length?+rebate_ratio.val():0,
					real_money = +form_data.pay_money - red_money,
					real_money = real_money>=0?real_money:0;
					
				$("#alert_confirm").data('form_data',form_data);//保存表单数据
				$("#confirm_order_id_input").val(json.data.order_id);
				var pay_type = arr_pay_type[form_data.pay_type_id];
				$("#confirm_pay_type_name").html(pay_type.NAME);
				$("#confirm_order_id").html(json.data.order_id);	
				$("#confirm_username").html(form_data.pay_user);					
				$("#confirm_money").html(real_money + money_unit);						
				$("#confirm_coin").html(coin+coin_name);
				$(".alert_jump_link .pay_result").attr('href',json.data.complete_url);//查看结果url
				if(g_form_data.pay_for=='game')
				{
					$("#confirm_game_server").html(game_name+' '+server_name);			
				}
				else
				{
					$("#confirm_game_server").html('37游戏币');	
				}
				//平台币密码确认
				if(form_data.pay_type_id==100000)
				{
					$("#platform_pass").val('');//清空平台币密码				
					$("#confirm_platform_coin").show();
				}
				else
				{
					$("#confirm_platform_coin").hide();
				}
				show_floatdiv("alert_confirm");
			}
			else if(json.code==13)
			{
				login_alert();
			}
			else if(json.msg)
			{
				alert(json.msg);
			}
			else
			{
				alert('未知错误['+json.code+']');
			}
		},
		error:function()
		{
			close_floatdiv($("#loading").parent());
			alert('网络异常，请刷新页面重试');
		}
	});
}

$(function(){
	$(".main_payFor_a").click(function(){
		select_pay_for($(this).attr("val"));
	});

	//展开选择游戏
	$("#main_select_game").click(function(){
		$("#alert_arrow").show().removeClass("arrow_server");
		$("#select_game").show();
		$("#select_server").hide();
	});
	//展开选择服
	$("#main_select_server").click(function(){
		$("#alert_arrow").show().addClass("arrow_server");
		$("#select_game").hide();
		$("#select_server").show();
	});
	//关闭选择游戏或服的浮框
	$(".alert_select_close").click(function(){
		$("#alert_arrow").hide();
		$("#select_game").hide();
		$("#select_server").hide();
	});
	//切换不同类型的游戏tab
	$(".alert_game").click(function(){
		var tab_id = $(this).attr('id');
		var arr = tab_id.split('_');
		select_game_tab(arr[2]);
	});
	//选择游戏，并显示选中游戏的服
	$(".game_list a").click(function(){
		var game_id = $(this).attr("val");
		$("#alert_arrow").show().addClass("arrow_server");
		$("#select_game").hide();
		$("#select_server").show();
		//$("#main_select_game").addClass("main_select_on").html("<span class='select_on'></span>"+$(this).text());
		
		select_game(game_id,-9999,-9999);
		//get_server($(this).attr('val'));
	});
	//更换帐号名
	$("#change_user").click(function(){
		$(".main_user_account").hide();
		$(".main_user_input").show();
	});
	//确定帐号名
	$("#define_user").click(function(){
		var username = $("#username").val();		
		if(!username)
		{
			alert('请输入充值帐号');
			return;
		}
		set_pay_user(username);
	});
	$("#username").blur(function(){
		var username = $("#username").val();		
		set_pay_user(username);
	});	
	//用户角色选择
	$("#user_role,#change_role").click(function(event){
		$("#user_role_list").show();
		event=event||window.event;
		event.stopPropagation();
	});
	$(document).click(function(e){
		$("#user_role_list").hide();

	});
	//神州行tab
	$(".main_shenzhou_a").click(function(){
		show_pay_type_cnt($(this).attr('val'));
	});
	
	
	//其他金额a标签
	$("#money_9999").click(function(){
		select_money(-1);
	
	});
	//其他金额输入框
/*	$("#other_money").focus(function(){
		select_money(-1);
	});	*/
	
	$("#other_money").change(function(){
		var o = $(this);
		var v = o.val();
		v = parseInt(v.replace(/[^0-9]/ig,''));
		if(isNaN(v)){
			o.val('');
			return
		};
		o.val(v);
		select_money(-1);
	});		
	
	$("#mobile_phone").mouseup(function(){//鼠标复制
		$(this).keyup();
	});		
	$("#mobile_phone").keyup(function(){
		var o = $(this);
		var v = o.val();
		v = v.replace(/[^0-9]/ig,'');
		o.val(v);
	});		
	//选择银行
	$(".main_bank a").click(function(){
		select_bank($(this).attr('val'));
	});
	$("#more_bank").click(function(){
		$(".hide").show();
		//$("#main_close_bank").show();
		$("#main_more_bank").hide();
	});
	//充值返利-切换劵返利实时统计提示
	/*$('.rebate_itme_a').click(function(){
		var obj=$(this);
		rebate_count_tip(obj,g_form_data.pay_money,g_form_data.pay_type_id,true);
	});*/
	
	var redEnvUl = $("#red_env_li");
	redEnvUl.delegate("a","click",function(){
		showRedEnvTip(redEnvUl,$(this));
	});
	
	
	//充值返利-更多返利劵
	$('.more_rebate').click(function(){
		var obj=$(this);
		obj.hide();
		$('.rebate_itme_a').show();
		$('.rebate_br').show();
	});
	$("#close_bank").click(function(){
		$(".hide").hide();
		$("#main_close_bank").hide();
		$("#main_more_bank").show();
	});
	//提交充值 生成订单
	$(".main_confirm a").click(function(){
		if(g_form_data.pay_type_id==32)
		{
			alipay_fast_query_sign();
		}
		else
		{
			create_order();			
		}

	});
	
	$("#confirm_submit").click(function(){
		confirm_submit();
	});	
	
	//浮动层关闭按钮
	$(".alert_confirm_close").live('click',function(){
		close_floatdiv($(this).parent().parent().parent());
	});
	//微信浮动层关闭按钮
	$(".wechat_confirm_close").live('click',function(){
		close_floatdiv($(this).parent().parent().parent());
	    show_floatdiv("alert_jump");
	});
	/*$( document )
    .on( "click", function( e ) {
        if ( e.target.id !== "alert_option_dom" && e.target.id !== "alert_select_con" && e.target.id !== "alert_select_btn" ){
            $( "#alert_option_bg" ).hide();
        }
    })
    .on( "click.select", "#alert_select_con, #alert_select_btn", function() {
        $( "#alert_option_bg" ).toggle();
    })
    .on( "mouseenter.option", "#alert_option_dom li", function() {
        $( "#alert_option_dom" ).find( "li" ).removeClass( "focus" );
        $( this ).addClass( "focus" );
    })
    .on( "mouseleave.option", "#alert_option_dom li", function() {
        $( "#alert_option_dom" ).find( "li" ).removeClass( "focus" );
    })
    .on( "click.option", "#alert_option_dom li", function() {
        $( "#alert_select_con" ).html( $( this ).html() ).attr( "data-areaType", $( this ).attr( "data-opt" ) );
        $( "#alert_option_bg" ).toggle();
    })
	//取值
    .on( "click.getvalue", "#alert_btn_fastin", function() {
		var alert_value = $( "#alert_select_con" ).attr( "data-areaType" ),
		    ipu_value = $( "#alert_server_fastin").val(); 
	    if(!ipu_value){
	        ipu_value = 0;
	    }
		var id = sel_game_id[alert_value][ipu_value];
		if(sel_game_id[alert_value][0]){
		    id = sel_game_id[alert_value][0];
		}
		if(id ){ 
		    select_server(id,0);
		}else{
		    alert('该区服不存在！');
		    $( "#alert_server_fastin").val("").focus();
		}
    });*/

	$(window).scroll(fullbgresize);
	$(window).resize(fullbgresize);	
});




