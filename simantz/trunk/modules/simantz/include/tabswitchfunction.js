	$(function(){
            //type support: notab(tabSwitch('destroy'))  ,slide,scroll,table,toggle (fade,show,toggle,noeffect)
                $('.SlideTab').tabSwitch('create', {type: 'toggle', toggle:'fade', height: 600, width: 950});
		$('.tabSelect').click(function(e){
			$('.SlideTab').tabSwitch('moveTo',{index: parseInt($(this).attr("rel"))});
			e.preventDefault();
		});
		$('.Nav').click(function(e){
                        $('.SlideTab').tabSwitch('moveStep',{step: parseInt($(this).attr('rel'))});
			e.preventDefault();
		});
	});

        function changetabstyle(value,tabcount){
            for(i=0;i<=tabcount;i++){
                   jQuery("#tab"+i).removeClass('switchtabselected');
            }
             jQuery("#tab"+value).addClass('switchtabselected');
    }