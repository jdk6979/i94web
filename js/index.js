$(document).ready(
	function()
	{
            if(!document.cookie)
            {
              if(document.cookie.indexOf('isFirst') == -1)
                     {    
                          var firstVisitor = $.layer(
                              {
                                type:1,
                                title:false,
                                area: ['450px', '240px'],
                                shade: [0.5, '#000'],
                                closeBtn:false,
                                bgcolor:'#CECECE',
                                page:{dom:"#firstVisitor"}
                              }
                            );
                          $("#closeTips").click(
                                  function()
                                  {
                                    layer.close(firstVisitor);
                                  }
                              );

                          // 设置isFirst的cookie和过期时间
                          var date = new Date();
                         date.setDate(date.getDate()+180);   //180天后过期
                         document.cookie = "isFirst="+escape("第一次访问")+";expires="+date.toGMTString();
                      }
            }
	}
);
