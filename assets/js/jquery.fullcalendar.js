var calendar = $('#calendar').fullCalendar({
    editable:true,
    header:{
     left:'prev,next today',
     center:'title',
     right:'month,agendaWeek,agendaDay'
    },
    events: 'employee/process/processEvents.php?type=loadData',
    selectable:true,
    selectHelper:true,
    displayEventTime:false,
    select: function(start, end, allDay)
    {
     var title = prompt("Enter Event Title");
     if(title)
     {
      var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
      var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
      $.ajax({
       url:"employee/process/processEvents.php",
       type:"POST",
       data:{title:title, start:start, end:end, type:'insertData'},
       success:function()
       {
        calendar.fullCalendar('refetchEvents');
        alert("Event Added Successfully");
       }
      })
     }
    },
    editable:true,
    eventResize:function(event)
    {
     var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
     var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
     var title = event.title;
     var id = event.id;
     $.ajax({
      url:"employee/process/processEvents.php",
      type:"POST",
      data:{title:title, start:start, end:end, id:id, type:'updateEvent'},
      success:function(){
       calendar.fullCalendar('refetchEvents');
       alert('Event Update');
      }
     })
    },

    eventDrop:function(event)
    {
     var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
     var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
     var title = event.title;
     var id = event.id;
     $.ajax({
      url:"employee/process/processEvents.php",
      type:"POST",
      data:{title:title, start:start, end:end, id:id, type:'updateEvent'},
      success:function()
      {
       calendar.fullCalendar('refetchEvents');
       alert("Event Updated");
      }
     });
    },

    eventClick:function(event)
    {
     if(confirm("Are you sure you want to remove it Event?"))
     {
      var id = event.id;
      $.ajax({
       url:"employee/process/processEvents.php",
       type:"POST",
       data:{id:id,type:'deleteEvent'},
       success:function()
       {
        calendar.fullCalendar('refetchEvents');
        alert("Event Removed Successfully");
       }
      })
     }
    },

   });

  var calendar = $('#calendar_teachers').fullCalendar({
    editable:true,
    header:{
     left:'prev,next today',
     center:'title',
     right:'month,agendaWeek,agendaDay'
    },
    events: 'employee/process/processEvents.php?type=loadData',
    selectable:true,
    selectHelper:true,
    displayEventTime:false,
    editable:false,
   });

  var calendar = $('#event_holidays_calender').fullCalendar({
    editable:true,
    header:{
     left:'prev,next today',
     center:'title',
     right:'month,agendaWeek,agendaDay'
    },
    events: 'employee/process/processEvents.php?type=loadEventsHolidaysData',
    selectable:true,
    selectHelper:true,
    displayEventTime:false,
    editable:false,
   });