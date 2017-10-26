
	  setInterval( function(){ UpdateGraphs() }, 1000 * 20);
      UpdateGraphs();

      function UpdateGraphs(){

		$(document).ready(function () {
			if(!testMode){
				  $.get("https://hedra-account-system.herokuapp.com/request?type=retrieve&retrievetype=basic&token="+Cookies.get("token")+"&user="+Cookies.get("user"), function (data) {
					if( !(JSON.parse("["+data+"]") == false) ){
					  LoadData(data);
					  LoadPlaytimeGraph(data);
						}
				  });
			}else{
				var d = new Date();
				var d2 = new Date();
				 d2.setDate( d.getDate() -1 );
				
				var data = ' "192.168.1.34", "Canada", "21.1", "'+d2.toString()+'", "4", "155.180.1.21", "Germany", "42.53", "'+d.toString()+'", "4", "146.118.1.76", "Canada", "8.3", "'+d.toString()+'", "4", "127.128.1.34", "Canada", "5.3", "'+d2.toString()+'", "4", "165.168.1.32", "Germany", "42.53", "'+d.toString()+'", "4",  "11.168.1.32", "Argentina", "33", "'+d2.toString()+'", "4" , "162.168.1.34", "Germany", "11", "'+d.toString()+'", "4", "109.168.1.34", "Canada", "9.56", "", "4", "192.168.3.55", "Canada", "42.53", "'+d+'", "4", "192.168.1.34", "Germany", "42.53", "'+d2.toString()+'", "4", "137.122.1.39", "Argentina", "76", "'+d2.toString()+'", "4" , "180.168.2.88", "Argentina", "2.53", "'+d2.toString()+'", "4"';
				LoadData(data);
				LoadPlaytimeGraph(data);	
			}
		});
      }

      function LoadData(data){
        var users = JSON.parse('[' + data + ']');
		
        var totalTime = 0, yesterdayTime = 0, totalPlayers = 0, yesterdayPlayers = 0, totalPlays = 0, yesterdayPlays = 0;
		
          for(i = 5; i < users.length; i+=5){
  			var d = new Date(users[i+3]);
  			var today = new Date();
  			var ONE_HOUR = 60 * 60 * 1000;
  			
  			var IsToday = (today-d) < ONE_HOUR * 24.0;
  			var IsYesterday = (today-d) > ONE_HOUR * 24.0 * 7 && (today-d) < ONE_HOUR * 8 * 24.0;
			
  			if(IsToday){
              	totalTime += parseFloat(users[i+2]);
  				totalPlayers++;
				totalPlays += parseFloat(users[i+4]);
  			}
  			if(IsYesterday){
  				yesterdayTime += parseFloat(users[i+2]);
  				yesterdayPlayers++;
				yesterdayPlays += parseFloat(users[i+4]);
  			}
  		}
 
		//document.getElementById("text-6").innerHTML = "";
  		document.getElementById("text-4").innerHTML = "";
  		document.getElementById("text-3").innerHTML = "";
  		document.getElementById("text-2").innerHTML = "";
		document.getElementById("text-1").innerHTML = "";
  		
  		totalTime = totalTime.toFixed(2);
  		yesterdayTime = yesterdayTime.toFixed(2);
		
		var playsChange = Math.round( (totalPlays / yesterdayPlays - 1) * 100.0);
  		document.getElementById("text-1").innerHTML += (playsChange > 0) ? "▲" : "▼";
  		playsChange =  Math.abs(playsChange);
     	document.getElementById("data-1").innerHTML = totalPlays;
  		document.getElementById("text-1").innerHTML += playsChange + "%";
  		
  		var timeChange = Math.round( (totalTime / yesterdayTime - 1) * 100.0);
  		document.getElementById("text-2").innerHTML += (timeChange > 0) ? "▲" : "▼";
  		timeChange =  Math.abs(timeChange);
        document.getElementById("data-2").innerHTML = totalTime;
  		document.getElementById("text-2").innerHTML += timeChange + "%";
  		
  		var playChange = Math.round( (totalPlayers / yesterdayPlayers - 1) * 100.0);
  		document.getElementById("text-3").innerHTML += (playChange > 0) ? "▲" : "▼";
  		playChange =  Math.abs(playChange);
     	document.getElementById("data-3").innerHTML = totalPlayers;
  		document.getElementById("text-3").innerHTML += playChange + "%";

  		var todaySession = (totalTime / totalPlayers).toFixed(2), yesterdaySession = (yesterdayTime / yesterdayPlayers).toFixed(2);
  		var sessionChange = Math.round( (todaySession / yesterdaySession - 1) * 100.0);
  		document.getElementById("text-4").innerHTML += (sessionChange > 0) ? "▲" : "▼";
  		sessionChange =  Math.abs(sessionChange);
      document.getElementById("data-4").innerHTML = todaySession;
  		document.getElementById("text-4").innerHTML += sessionChange + "%";
  		
  		Update();

        var tableBody = document.getElementById("userTable");
        tableBody.innerHTML = '<thead>'+
                        '<tr>'+
                          '<th>#</th>'+
                          '<th>IP</th>'+
                          '<th>Location</th>'+
                          '<th>Playtime</th>'+
                        '</tr>'+
                      '</thead>';
        tableBody.innerHTML += "<tbody>";
        for(i = 5; i < 60; i+=5){
          var num = i / 5 - 1	; 
          tableBody.innerHTML +=
          '<tr>'
          +'<th scope="row">' +num+ '</th>'
          +'<td>'+users[i+0]+'</td>'
          +'<td>'+users[i+1]+'</td>'
          +'<td>'+users[i+2]+'</td>'
          +'</tr>'
        }
        tableBody.innerHTML += "</tbody>";
		document.getElementById("graph1").style = "bottom:315px;";
		document.getElementById("graph0").style = "bottom:320px;";
      }
	  