
	  setInterval( function(){ UpdateGraphs() }, 1000 * 20);
      UpdateGraphs();

      function UpdateGraphs(){

          $.get("https://hedra-account-system.herokuapp.com/request?type=retrieve&retrievetype=basic&token="+Cookies.get("token")+"&user="+Cookies.get("user"), function (data) {
            if( !(JSON.parse("["+data+"]") == false) ){
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
	  