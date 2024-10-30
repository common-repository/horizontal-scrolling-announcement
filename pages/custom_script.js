jQuery(document).ready(function()
{
	jQuery('#hsa_text_color').wpColorPicker({
		change: function (event, ui) {
        var element = event.target;
        var color = ui.color.toString();
		jQuery("#hsa_preview").css('color',color);
		jQuery("#maina").css('color',color);		
		
		
       
	}
  });
	

	
	
	jQuery('#hsa_back_color').wpColorPicker({
		change: function (event, ui) {
        var element = event.target;
        var color = ui.color.toString();
		jQuery("#hsa_preview").css('background-color',color);	
       
	}
  });
	
	
	jQuery('#hsa_button_color').wpColorPicker({
		change: function (event, ui) {
        var element = event.target;
        var color = ui.color.toString();
		jQuery(".abutton").css('background-color',color)
       
	}
	});
	jQuery('#hsa_button_text_color').wpColorPicker({
		change: function (event, ui) {
        var element = event.target;
        var color = ui.color.toString();
		jQuery(".abutton").css('color',color)
		
	}
	});

	var hsa_preview="";
	
	
	jQuery("#hsa_text,#hsa_link,#hsa_call_action_text,#hsa_call_action_link").keyup(function()
	{
		innerData();
	
	});
	
	jQuery('[name="hsa_target"],[name="hsa_call_action_position"]').change(function()
	{	
		innerData();
	});


	jQuery('#hsa_font_size').keyup(function()
	{
		jQuery("#hsa_preview").css('font-size',jQuery(this).val()+'px')
	
	});
	
	jQuery('#hsa_append_class').keyup(function()
	{
		jQuery("#hsa_preview").attr('class',jQuery(this).val())
	
	});

	jQuery("#hsa_textbold").change(function()
	{
		if(jQuery(this).is(":checked"))
		{
			jQuery("#hsa_preview").css('font-weight','600');
		}
		else
		{
			jQuery("#hsa_preview").css('font-weight','');

		}


	})
	
	jQuery("#hsa_custom_css").keyup(function()
    {

		var currentVal=jQuery(this).val().split(";");

		for(var i in currentVal)
		{
			var cssData=currentVal[i].split(":");
			console.log(cssData);
			if(cssData[0]!="" && cssData[1]!="")
				jQuery("#hsa_preview").css(cssData[0],cssData[1]);
			
		}





	});
	
	
	
	function innerData()
	{
		var innerhtml="";
		var link=jQuery("#hsa_link").val();
		var target=jQuery('[name="hsa_target"]').val();
			var left_button_html="";
			var right_button_html="";
		if(link!="")
		{	
			var hsa_text_color=jQuery('[name="hsa_text_color"]').val();
			innerhtml='<a id="maina" target="'+target+'" href="'+link+'" style="text-decoration:none;color:'+hsa_text_color+'">'
		}	
	
		var hsa_text=jQuery("#hsa_text").val().trim();
		
		if(hsa_text=="")
			hsa_text="Demo Announcement Text - This is a Preview of your Announcement";
			
		innerhtml+=hsa_text
		
		if(link!="")
			innerhtml+='</a>'
	
		var button_html=buttonData();
		
		if(button_html!="")
		{
			var button_position=jQuery('[name="hsa_call_action_position"]').val()
		
			if(button_position=="before")
			{
				left_button_html=button_html;
			}
			else
			{
				right_button_html=button_html;
			}
		}
		
		innerhtml=left_button_html+innerhtml+right_button_html;
		
	
		jQuery("#hsa_preview").html(innerhtml);
	}
	
	function buttonData()
	{
		var button_html="";
		var button_text=jQuery("#hsa_call_action_text").val();
	
		if(button_text!="")
		{
			
			var button_link=jQuery("#hsa_call_action_link").val();
			var button_postion=jQuery("#hsa_call_action_position").val();
			var button_color=jQuery("#hsa_button_color").val();
			var button_text_color=jQuery("#hsa_button_text_color").val();
			
			var button_css="";
			
			if(button_color!="")
				button_css+='background-color:'+button_color+';';
			
			console.log(button_text_color);
			if(button_text_color!="")
				button_css+='color:'+button_text_color+';';	
			
			if(button_color!="")
					button_css+='background-color:'+button_color+';';
			
				
			
	
			button_html='<a class="abutton" style="'+button_css+'" href="'+button_link + '">'+button_text+'</a>';
	
		}
		
		
		return button_html;
		
		
	}
	
	
	
	
	
	
	jQuery('[name="hsa_text_alignment"]').change(function()
	{
		jQuery("#hsa_preview").css('text-align',jQuery(this).val());
	
	});
	
	jQuery('[name="hsa_position"]').change(function()
	{
		jQuery("#hsa_preview").css('position',jQuery(this).val());
	
	});
	
	jQuery('[name="hsa_fixed_position"]').change(function()
	{
		var currentVal=jQuery(this).val();
		if(currentVal=="top")
		{
			jQuery("#hsa_preview").css('bottom','');
			jQuery("#hsa_preview").css('top','0px');
		}
		else
		{
			jQuery("#hsa_preview").css('top','');
			jQuery("#hsa_preview").css('bottom','0px');	
		}
	});
	
	
	
	
	function AddCss()
	{
		var hsa_text_alignment=jQuery('[name="hsa_text_alignment"]').val();
		var hsa_text_color=jQuery('[name="hsa_text_color"]').val();
		var hsa_back_color=jQuery('[name="hsa_back_color"]').val();
		var hsa_position=jQuery('[name="hsa_position"]').val();
		var hsa_location=jQuery('[name="hsa_fixed_position"]').val();
		var hsa_font_size=jQuery('[name="hsa_font_size"]').val();
		
		if(jQuery("#hsa_textbold").is(":checked"))
		{
			jQuery("#hsa_preview").css('font-weight','600');
		}
		
		
		
		jQuery("#hsa_preview").css({'text-align':hsa_text_alignment,'color':hsa_text_color,'background-color':hsa_back_color,'position':hsa_position,'font-size':hsa_font_size+'px'})
		
		if(hsa_location=="top")
			jQuery("#hsa_preview").css('top','0px');
		else
			jQuery("#hsa_preview").css('bottom','0px');
			
		if(jQuery("#hsa_append_class").val()!="")
		{
			jQuery("#hsa_preview").addClass(jQuery("#hsa_append_class").val());
		}
			
		
	}
	
	setTimeout(function()
	{
		AddCss();
		innerData();
	},3000);
	
	
});	

jQuery(document).on('ready', function($){
    postboxes.save_state = function(){
        return;
    };
    postboxes.save_order = function(){
        return;
    };
    postboxes.add_postbox_toggles();
});