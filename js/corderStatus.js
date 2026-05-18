function startOrderStatusPolling(order_id)
{
	setInterval(function(){

		var xhr = new XMLHttpRequest();
		xhr.open("GET", "../controllers/corderController.php?action=status&order_id=" + order_id, true);

		xhr.onload = function()
		{
			if(xhr.status == 200)
			{
				document.getElementById("status-badge").innerHTML = xhr.responseText;
			}
		};

		xhr.send();

	}, 3000);
}