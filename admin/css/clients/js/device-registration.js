var bits;
var length;
var i;
var timer;
var id;

var msg;
var bit;
var clock;

var baud = 15;

$(function() {
	msg = document.getElementById("msg");
	bit = document.getElementById("bit");
	clock = document.getElementById("clock");
	
	$("#btn-start").click(function(e) {
		e.preventDefault();
		$("#btn-done").hide();
		getBits();
	});
});
	
function getBits()
{
	msg.innerHTML = "Requesting registration from server ...";
	
	$.ajax({
		type: "GET",
		url: "devices/get_reg_string/" + device_id,
		success: function(data){
			if (data.status == 'ok') {
				bits = data.data.reg_string.substr(0, 192);
				id = ''; //data.data.reg_string.substr(192);
				OTSend(bits, baud, false, id);
			} else {
				msg.innerHTML += " ERROR: " + data.errors[0];	
			}
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			msg.innerHTML += " ERROR";
		}
	});
}


function OTSend(data, baud, repeat, id)
{
	msg.innerHTML += " <span class='text-success'>OK</span><br>Sending registration string to device ...";
	
	clearInterval(timer);

	var index = 0;
	var stage = 0;
	var toggle = 0;
	if (index < data.length)
	{
		timer = setInterval(function ()
		{
			OTSendBit(data[index] != 0, toggle == 0)
			if (stage != 0)
			{
				if (++index >= data.length)
				{
					if (repeat)
					{
						index = 0;
					}
					else
					{
						msg.innerHTML += " <span class='text-success'>OK</span><br><br><span class='text-success'><strong>Transmission complete</strong></span>";
						if(id.length > 0)
						{
							msg.innerHTML += "<br>Device ID: " + id;
						}
						clearInterval(timer);
						$("#btn-done").show();
					}
				}
				stage = 0;
			}
			else
			{
				stage = 1;
				toggle = !toggle;
			}
		}, 500 / baud);
	}
}

function OTSendBit(bitDatum, clockDatum)
{
	bit.style.backgroundColor = (bitDatum & 1) ? 'white' : 'silver';
	clock.style.backgroundColor = (clockDatum & 1) ? 'white' : 'silver';
}