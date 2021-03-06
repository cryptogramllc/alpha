var flightFinder = {


   // initialize javascript 
   initialize: function(){
       $$('body').on('click, touchstart', 'button, a, input, span', function(event){ 
       	   var elem = $$(this);
           var $FUNCTION = elem.attr('data-function');
			if($FUNCTION != undefined){

				   event.preventDefault(); 
			       var $function = $FUNCTION.split(",");           
			       //for each function in DOM element data-function
			       $$.each($function, function(i,v){
			                var functionCall = v; 
			                console.log(functionCall);
       				        flightFinder[functionCall](elem);
			       });	             
			   }
       
       });

       //set screen height
       flightFinder.windowResize();
       $$(window).resize(function(){ flightFinder.windowResize(); });
   },
  
  
  
  
  
  
  
   //resize height....  
   windowResize: function(){
     
       var height = ($$(window).height() - 60);
       $$('section').css('height', height + 'px');

   },








   // universal ajax call....
   ajax: function(postData){
         
        var resultpage  = postData.resultPage;
        console.log(postData);
        $$.ajax({
           url: 'server.php',
           type: 'POST',
           dataType: 'json',
           data : postData,
           error: function(x, y, z){
               console.log(y);
               console.log(x.status);
               console.log(z);

           },
           success: function(data){
                   console.log(data);

                if(resultpage != undefined){    
                  $$(".slideOut").load(resultpage + '.html', function(){
                      var functionCall = $$(".slideOut .page").attr('load-function');
                      console.log(functionCall);
                      eval("flightFinder." + functionCall)(data);
                  });

                }
           } 
        }).done(function(){  $$(".slideOut").addClass('slide');  });
   }, 
   
   
    




    // compute 
   compute: function(elem){
			var value = elem.val();
			var buttonVal = elem.parent().find('.buttonVal');
			var result = eval(buttonVal.html());
         	var calc = eval(result + value);	
			calc < 0 ? calc = 0 : calc; 
			buttonVal.html(calc);
   },









    // side panel 
   sidePanel: function(elem){
   	   var page = elem.attr('href');
   	   $$(".slideOut").load(page).addClass('slide');      
   },









    // close panel
   closePanel: function(){
   	        console.log('back');
   	       $$('.slideOut').removeClass('slide');     
   },
   
   
   
   
   
   
   
   
   
   // child field populater... 
   childField: function(elem){
  	 var buttonVal = elem.parent().find('.buttonVal');
     var result = eval(buttonVal.html());
     console.log(result);
	   $$('.child-ages div').empty();
     for(var i = 0; i < result; i++){
     
      var input = '<select id="child'+  (i < 9 ? '0' : '') + (i+1) +'" name="child'+ (i+1) +'Age" tabindex="8">' +
	                    '<option value="-1" selected="selected">--</option>' +
						          '<option value="0">&lt;1</option>' +
	                    '<option value="1">1</option>' +
	                    '<option value="2">2</option>' +
	                    '<option value="3">3</option>' +
	                    '<option value="4">4</option>' +
	                    '<option value="5">5</option>' +
	                    '<option value="6">6</option>' +
	                    '<option value="7">7</option>' +
	                    '<option value="8">8</option>' +
	                    '<option value="9">9</option>' +
	                    '<option value="10">10</option>' +
	                    '<option value="11">11</option>' +
	                    '<option value="12">12</option>' +
	                    '<option value="13">13</option>' +
	                    '<option value="14">14</option>' +
	                    '<option value="15">15</option>' +
	                    '<option value="16">16</option>' +
	                    '<option value="17">17</option>' +
                  '</select>';
      $$('.child-ages div').append(input); 
     }
   },
   
    
    
  
  
  
  
   //submit form 
   submitForm: function(elem){
      
      var resultPage = elem.parent().attr('data-action');
      var functionType = elem.parent().attr('data-type');
      var departDate = $$("input#depart").val();
      var returnDate = $$("input#return").val();
      var flyFrom = $$("#fly-from").val();
      var flyTo = $$("#fly-to").val();
      var functionType = 'flightFinder'; 
      var data = {departDate : departDate, returnDate: returnDate, resultPage:resultPage, flyFrom:flyFrom, flyTo:flyTo, functionType:functionType}; 

      console.log(data);
      flightFinder.ajax(data);


   },
   
   
   
   
  
  
  
  
   //flight finder
   flightFinderResults: function(data){
      
      console.log(data);
      $$('.page .calendar.outbound').load('calendar.html');
      $$('.page .calendar.inbound').load('calendar.html', function(){
         flightFinder.calendarLoad(data);
      });
      $$('.depart-info').append('<div class="content">' + data.flyTo + ' To ' + data.flyFrom + '</div>');
      $$('.arrive-info').append('<div class="content">' + data.flyFrom + ' To ' + data.flyTo + '</div>');
      $$('.seat-info').append('<div class="content"> Economy </div>');

     // $$('.arrive-info').append('<div class="content">' + data.flyFrom + ' To ' + data.flyTo + '</div>');



   },



  
  
  
  
  
   //calendar view... 
   calendarLoad: function(data){
        var calendarOutbound = $$('.page .calendar.outbound');
        calendarOutbound.find('tr.month').append('<h4>' + data.depart_month[0].MONTH + '</h4>');
        var Outday = 0;
        var departCount = data.depart_month.length;
        $.each(data.depart_month, function(i,v){    
            var week  = i/7;  
             if(week % 1 == 0){
                  // console.log(week);
                  calendarOutbound.find('tbody').append('<tr>');
                   for(j = 0; j < 7; j++){
                      var currentDay = Outday++;
                      if(currentDay < departCount){
                        var type = data.depart_month[currentDay].TYPE;
                        var cabin = data.depart_month[currentDay].CABIN;
                        if(data.depart_month[currentDay].OUT == 0){
                          type = 'unavail';
                        }
                            calendarOutbound.find('tbody tr').eq(week).append('<td class="'+ type +'" data-type="'+ cabin +'"><a href="">'+ (currentDay+1) +'<span class="visuallyhidden"> ('+ type +' day)</span></a></td>');
                      }
                   }  
             }
        });

        var calendarInbound = $$('.page .calendar.inbound');
        calendarInbound.find('tr.month').append('<h4>' + data.return_month[0].MONTH + '</h4>');
        var Inday = 0;
        var returnCount = data.return_month.length;
        $.each(data.return_month, function(i,v){    
            var week  = i/7;  
             if(week % 1 == 0){
                  // console.log(week);
                  calendarInbound.find('tbody').append('<tr>');
                   for(j = 0; j < 7; j++){
                      var currentDay = Inday++;
                      if(currentDay < returnCount){
                        var type = data.return_month[currentDay].TYPE;
                        if(data.return_month[currentDay].IN == 0){
                          type = 'unavail';
                        }
                            calendarInbound.find('tbody tr').eq(week).append('<td class="'+ type +'"><a href="">'+ (currentDay+1) +'<span class="visuallyhidden"> ('+ type +' day)</span></a></td>');
                      }
                   }  
             }
        });




     
   }

   

}



