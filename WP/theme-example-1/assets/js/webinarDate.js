(function web(){$=jQuery;$(document).ready(function(){formatDate();});})();function formatAMPM(date){var hours=date.getHours();var minutes=date.getMinutes();var ampm=hours>=12?'PM':'AM';hours=hours%12;hours=hours||12;minutes=minutes<10?'0'+minutes:minutes;var strTime=hours+':'+minutes+' '+ampm;return strTime;}function formatDate(){$.each($('.webinar-date'),function(index,element){if(!element.innerHTML){return;}var monthNames=["January","February","March","April","May","June","July","August","September","October","November","December"];var date=new Date(element.innerHTML);var elementDate=monthNames[date.getMonth()]+" "+date.getDate()+", "+formatAMPM(date);$(element).text(elementDate);$(element).css('opacity',1);});}