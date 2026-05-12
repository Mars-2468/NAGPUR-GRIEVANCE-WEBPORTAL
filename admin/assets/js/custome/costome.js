


$(document).ready(function()
{
    $("#editbtn").click(function()
    {
        $("#editarea").css('display','-webkit-inline-box');
        $("#donehide").css('display','-webkit-inline-box');
        $("#editbtn").css('display','none');
    });
    
   
    $("#widgetData").click(function()
    {
        var widgetname=$("#widgetname").val();
        var widget_type=$("#widget_type").val();
        
        if(widgetname ==='')
        {
            alert('enter widget name');
            return false;
        }
        if(widget_type =='0')
        {
            alert('Select widget type');
            return false;
        }
        
        $.post('CreateWidgetController/getWidgetData',{widgetname:widgetname,widget_type:widget_type},function(data)
        {
            $("#result").html(data);
        });
        
        
    });
   
    
   
});

 
;