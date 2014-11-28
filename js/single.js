$(document).ready(
	function () 
	{
		$("label[for='pre']").hover(
			function()
			{
				$(this).css("background","#CC0000");
				$("a#pre").css("color","#CC0000");
			},
			function()
			{
				$(this).css("background","#999999");
				$("a#pre").css("color","#393939");
			}
		);
		$("label[for='next']").hover(
			function()
			{
				$(this).css("background","#CC0000");
				$("a#next").css("color","#CC0000");
			},
			function()
			{
				$(this).css("background","#999999");
				$("a#next").css("color","#393939");
			}
		);
		$("a#pre").hover(
			function()
			{
				$("label[for='pre']").css("background","#CC0000");
				$(this).css("color","#CC0000");
			},
			function()
			{
				$("label[for='pre']").css("background","#999999");
				$(this).css("color","#393939");
			}
		);
		$("a#next").hover(
			function()
			{
				$("label[for='next']").css("background","#CC0000");
				$(this).css("color","#CC0000");
			},
			function()
			{
				$("label[for='next']").css("background","#999999");
				$(this).css("color","#393939");
			}
		);
	}
);