
	$.get("https://hedra-account-system.herokuapp.com/request?type=retrieve&retrievetype=crashes", function (crashdata){
		
		LoadCrashData(JSON.parse("["+crashdata+"]"));
	});

function LoadCrashData(crashes){
//cross data
//ip -country - log -version - date
  
var tableBody = document.getElementById("userTable");
tableBody.innerHTML += "<tbody>"
for(i = 0; i < crashes.length; i+=5){
  var num = i / 5+1; 
  tableBody.innerHTML +=
  '<tr>'
	+'<th scope="row">' +num+ '</th>'
	+'<td>'+crashes[i+0]+'</td>'
	+'<td>'+crashes[i+1]+'</td>'
	+'<td>'+crashes[i+2]+'</td>'
	+'<td>'+new Date(crashes[i+3])+'</td>'
	+'<td>'+new Date(crashes[i+4])+'</td>'
	+'<td><center><button class="btn btn-default" aria-label="More"  style="width:30px;height:30px;font-weight:bold;"><span style="font-weight:bold;">...</span></button></center></td>'
  +'</tr>'
}
tableBody.innerHTML += "</tbody>";
}