$(document).ready(
	function()
	{
		//实例化编辑器
    		//建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
    		var ue = UE.getEditor('editor',
    			{
    				autoHeightEnabled: false,
    				initialFrameHeight:400,
    				initialFrameWidth:900,
                                                   toolbars:[
                                                                [
                                                                'undo','redo','indent','fontfamily','fontsize','bold','italic','underline','strikethrougn',
                                                                'forecolor','backcolor','justifyleft','justifytight','justifycenter','justifyjustify',
                                                                'insertorderedlist','insertunorderedlist','link','unlink','simpleupload','insertimage',
                                                                'emotion','inserttable','insertcode','source','preview','cleardoc','spechars',
                                                                 'help','fullscreen'
                                                                ]
                                                    ]
    			}
                          );
                         // $("button[value='editor']").click(
                         //                                    function()
                         //                                    {
                         //                                            ue.focus();
                         //                                    }
                         //                            );
                       $("#postForm").submit(
                                function()
                                {
                                         if($("#blogtitle").val() == "")
                                        {
                                           layer.tips('文章标题不能为空', "#blogtitle" , {guide: 1, time: 1});
                                           $("#blogtitle").focus();
                                            return false;
                                        }
                                        else
                                        {
                                            var loadinglayer = layer.load('正在保存…');
                                        }
                                }
                        );   
                        $("button[value='return']").click(
                                function()
                                {
                                    window.location.href="index.php";
                                }
                           );    
	}
);