(function ($){
Drupal.behaviors.home = {
	
attach: function (context) { 

/** Home Page Animation Script ***/
jQuery.noConflict();
//$(function(){
	var baspath = Drupal.settings.basePath;
	var sectors = [{	
				   		name:'enterprise', left:1529, x:560, y:375, ix:660, iy:575, hx:530, hy:353,
						text:'<h1 class="text">Enterprise<span>Comms</span></h1>', 
						title:'<h1>Enterprise<span>Comms</span></h1>', 
					  	description:'Facilitate information transfer among remote sites for faster decision making.', url:'/enterprise-comms'},
				   { 
				   		name:'government', left:1290, x:690, y:200, ix:1100, iy:180, hx:640, hy:190,
				   		text:"<h1 class='text'>Government<span>Comms</span></h1>", 
				   		title:"<h1>Government<span>Comms</span></h1>", 
					  	description:'Secure, reliable communications for command and control.', url:'/government-comms'
					},
					{
						name:'relief', left:1026, x:100, y:200, ix:-300, iy:180, hx:165, hy:200,
						text:'<h1 class="text">Relief<span>Comms</span></h1>', 
						title:'<h1>Relief<span>Comms</span></h1>',  
						description:'Deploy communications rapidly for massive coordination efforts.', 
						url:'/relief-comms'
					},
					{
						name:'media', left:753, x:525, y:40, ix:565, iy:-200, hx:505, hy:45, text:'<h1 class="text">Media<span>Comms</span></h1>', 
						title:'<h1 >Media<span>Comms</span></h1>',  
						description:'When you need to be the first to break the news.', 
						url:'/media-comms'
					},
					{
						name:'leisure', left:256, x:400, y:210, ix:400, iy:210, hx:400, hy:210, 
						text:'<h1 class="text">Leisure<span>Comms</span></h1>', 
						title:'<h1>Leisure<span>Comms</span></h1>',  
						description:'Reliable communications for the adventurer in you.', 
						url:'/leisure-comms' 
					},
					{
						name:'marine', left:17, x:255, y:375, ix:150, iy:475, hx:275, hy:365,
						text:'<h1 class="text">Marine<span>Comms</span></h1>', 
						title:'<h1>Marine<span>Comms</span></h1>',  
						description:'Your companion for the days and weeks at sea.', 
						url:'/marine-comms'
					},
					{
						name:'energy', left:499, x:270, y:40, ix:100, iy:50, hx:290, hy:50,
						text:'<h1 class="text">Energy<span>Comms</span></h1>', 
						title:'<h1>Energy<span>Comms</span></h1>',  
						description:'Stay connected wherever the search for resources takes you.', 
						url:'/energy-comms'
					}				
									
					],
		homeNavigation =[	{name:'network', x:182, hx:955, url:'network-coverage'},					  		
					  		{name:'products', x:326, hx:1099, url:'products-list'},
							{name:'whereToBuy', x:29, hx:803, url:'where-to-buy'},
					  		{name:'MediaCenter', x:475, hx:1248, url:'content/thuraya-events-calendar'},
							{name:'MediaCenter1', x:617, hx:1393, url:'in-the-news'}
					 	],
		innerPagesNavigation = [{name:'enterprise', ref:7,  text:'EnterpriseComms', color:'#513eac', x:548, y:0, url:'#' },
								{name:'diffence', ref:1, text:"GovernmentComms", color:'#5bb85a', 	x:8, y:0, url:'#' },
								{name:'relief', text:'ReliefComms', color:'#f7b91f', x:61, y:0, url:'#' },
								{name:'media', text:'MediaComms', color:'#d72237', x:114, y:0, url:'#' },
								{name:'aviation', text:'LeisureComms', color:'#57b6f6', x:168, y:0, url:'#' },
								{name:'marine', text:'MarineComms',color:'#16acbe', x:222, y:0, url:'#' },
								{name:'energy', text:'EnergyComms', color:'#f6451b', x:275, y:0, url:'#' },
								{name: 'network', text:"Network", color:'#57b6f6', x:328, y:0, url:'network-coverage' },
								{name:'products', text:'Products', color:'#57b6f6', x:381, y:0, url:'products-list' },
								{name:'wheretobuy', text:'Where to buy', color:'#57b6f6', x:436, y:0, url:'where-to-buy' },
								{name: 'mediacenter', text:'Media Center', color:'#57b6f6', x:490, y:0, url:'media-gallery' }
								]
								
		SectorHover = {'drawlines':{'lines':[{name:'relief', height:2,  position:'left', position1:'top',  width:300, top:300, left:0, border:'top', angle:0}, {name:'energy', position:'left', position1:'top', border:'left', height:175, width:2, top:0, angle:-25, left:500}, {name:'media', height:175, position:'left',  position1:'top', width:2, top:0, left:750, border:'left', angle:25}, {name:'government', position:'right', position1:'top', width:400, border:'top',  height:2, top:300, left:0, angle:0}, {name:'leisure', position:'left', position1:'bottom', width:2, height:380, top:0, border:'left', left:620, angle:0}, {name:'enterprise', position:'left', position1:'top', width:500, height:2, top:610, border:'top', angle:42, left:642}, {name:'marine', position:'left', position1:'top', width:500, height:2, top:600, border:'top', angle:-42, left:300}]
				}, 
			'relief':{
				left:120, top:150, deg:10, ieleft:130, ietop:165, 'others':[ {name:'media', left:570, top:110, ieleft:550, ietop:80}, {name:'energy', left:350, top:80, ieleft:320, ietop:80}, {name:'government', left:660, top:260, ieleft:700, ietop:230}, {name:'enterprise', left:540, top:390, ieleft:580, ietop:370}  , {name:'marine', left:260, top:370, ieleft:260, ietop:370}, {name:'leisure', left:415, top:280, ieleft:420, ietop:260}], 'lines':[{name:'relief', angle:-12, postiion:'left', position1:'top', top:275, width:350, left:0}, {name:'energy', angle:-25, position:'left', position1:'top',  top:0, width:2, left:550}, {name:'media', angle:-10, position:"left", position1:'top', top:0, width:2, left:780}, {name:'government', angle:-5, position:'right', position1:'top',  top:0, width:400, top:280}, {name:'leisure', position:'bottom', position1:'left', angle:5,  left:620, width:2, top:330}, {name:'marine', position:'left', position1:'top', angle:-45, hangle:-50, left:620, width:2, top:330}, {name:'enterprise', position:'left', position1:'top', angle:45, hangle:45, left:620, width:2, top:330}] 
			}, 
			'energy':{
				left:320, top:30, deg:10, ieleft:290, ietop:30, 'others':[ {name:'media', left:570, top:110, ieleft:550, ietop:80}, {name:'relief', left:180, top:170, ieleft:170, ietop:230}, {name:'government', left:660, top:260, ieleft:700, ietop:230}, {name:'enterprise', left:540, top:390, ieleft:580, ietop:370}  , {name:'marine',  left:260, top:370, ieleft:260, ietop:370}, {name:'leisure', left:415, top:280, ieleft:420, ietop:260} ], 'lines':[{name:'relief', angle:-15, postiion:'left', position1:'top', top:280, width:350, left:0}, {name:'energy', angle:-10, position:'left', position1:'top',  top:0, width:2, left:550}, {name:'media', angle:-10, position:"left", position1:'top', top:0, width:2, left:780}, {name:'government', angle:-10, position:'right', position1:'top',  top:0, width:400, top:280}, {name:'leisure', position:'bottom', position1:'left', angle:5, top:0, width:2, top:330}, {name:'marine', position:'left', position1:'top', angle:-45, left:620, width:2, top:330}, {name:'enterprise', position:'left', position1:'top', angle:45, left:620, width:2, top:330}] 
			}, 
			'marine':{
				left:210, top:325, ieleft:240, ietop:330, deg:10, 'others':[ {name:'media', left:570, top:110, ieleft:550, ietop:80}, {name:'relief', left:180, top:175, ieleft:170, ietop:230}, {name:'government', left:660, top:260, ieleft:700, ietop:230}, {name:'enterprise', left:540, top:390, ieleft:580, ietop:370}  , {name:'energy', left:350, top:80, ieleft:320, ietop:80}, {name:'leisure', left:415, top:280, ieleft:420, ietop:260} ],'lines':[{name:'relief', angle:-15, postiion:'left', position1:'top', top:280, width:390, left:0}, {name:'energy', angle:-10, position:'left', position1:'top',  top:0, width:2, left:550}, {name:'media', angle:-10, position:"left", position1:'top', top:0, width:2, left:780}, {name:'government', angle:-10, position:'right', position1:'top',  top:0, width:400, top:280}, {name:'leisure', position:'bottom', position1:'left', angle:5, top:0, width:2, top:330}, {name:'marine', position:'left', position1:'top', angle:-45, left:620, width:2, top:330}, {name:'enterprise', position:'left', position1:'top', angle:45, left:620, width:2, top:330}] 
			}, 
			'media':{
				left:460, top:40, deg:-10, ieleft:500, ietop:30, 'others':[ {name:'marine', left:290, top:400, ieleft:260, ietop:370}, {name:'relief', left:160, top:260, ieleft:170, ietop:230}, {name:'government', left:660, top:190, ieleft:700, ietop:230}, {name:'enterprise', left:580, top:345, ieleft:580, ietop:370}  , {name:'energy', left:290, top:110, ieleft:320, ietop:80}, {name:'leisure', left:410, top:280, ieleft:420, ietop:260} ],'lines':[{name:'relief', angle:-15, postiion:'left', position1:'top', top:280, width:350, left:0}, {name:'energy', angle:-10, position:'left', position1:'top',  top:0, width:2, left:550}, {name:'media', angle:-10, position:"left", position1:'top', top:0, width:2, left:780}, {name:'government', angle:-10, position:'right', position1:'top',  top:0, width:400, top:280}, {name:'leisure', position:'bottom', position1:'left', angle:10, top:0, width:2, top:330}, {name:'marine', position:'left', position1:'top', angle:-45, left:620, width:2, top:330}, {name:'enterprise', position:'left', position1:'top', angle:45, left:620, width:2, top:330}] 
			}, 
			'government':{
				left:670, top:140, deg:-10, ieleft:670, ietop:175, 'others':[ {name:'marine', left:290, top:400,  ieleft:260, ietop:370}, {name:'relief', left:160, top:260,  ieleft:170, ietop:230}, {name:'media', left:530, top:80, ieleft:550, ietop:80}, {name:'enterprise', left:580, top:345, ieleft:580, ietop:370}  , {name:'energy', left:290, top:110, ieleft:320, ietop:80}, {name:'leisure',  left:410, top:280, ieleft:420, ietop:260} ],'lines':[{name:'relief', angle:5, postiion:'left', position1:'top', top:300, width:350, left:0}, {name:'energy', angle:-10, position:'left', position1:'top',  top:0, width:2, left:480}, {name:'media', angle:-10, position:"left", position1:'top', top:0, width:2, left:730}, {name:'government', angle:10, position:'right', position1:'top',  top:0, width:400, top:280}, {name:'leisure', position:'bottom', position1:'left', angle:-7, top:0, width:2, top:330}, {name:'marine', position:'left', position1:'top', angle:-45, hangle:-38, left:620, width:2, top:330}, {name:'enterprise', position:'left', position1:'top', angle:45, hangle:52, left:620, width:2, top:330}] 
			}, 
			'enterprise':{
				left:550, top:360, deg:-10, ieleft:530, ietop:350, 'others':[ {name:'marine',  left:290, top:400, ieleft:260, ietop:370}, {name:'relief',  left:160, top:260, ieleft:170, ietop:230}, {name:'media', left:530, top:80, ieleft:550, ietop:80}, {name:'government', left:660, top:190,  ieleft:700, ietop:230}  , {name:'energy', left:290, top:110, ieleft:320, ietop:80}, {name:'leisure', left:410, top:280, ieleft:420, ietop:260} ], 'lines':[{name:'relief', angle:5, postiion:'left', position1:'top', top:300, width:350, left:0}, {name:'energy', angle:-10, position:'left', position1:'top',  top:0, width:2, left:480}, {name:'media', angle:-10, position:"left", position1:'top', top:0, width:2, left:730}, {name:'government', angle:10, position:'right', position1:'top',  top:0, width:400, top:280}, {name:'leisure', position:'bottom', position1:'left', angle:-2, top:0, width:2, top:330},{name:'marine', position:'left', position1:'top', angle:-45, left:620, width:2, top:330}, {name:'enterprise', position:'left', position1:'top', angle:45, hangle:48, left:620, width:2, top:330}]
			},  
			'leisure':{
				left:380, top:210, deg:0, 'others':[ {name:'marine', left:260, top:370}, {name:'relief', left:170, top:230}, {name:'media', left:550, top:80}, {name:'government', left:700, top:230 }  , {name:'energy', left:320, top:80}, {name:'enterprise', left:580, top:370} ], 'lines':[{name:'relief', angle:-15, postiion:'left', position1:'top', top:280, width:350, left:0}, {name:'energy', angle:-10, position:'left', position1:'top',  top:0, width:2, left:550}, {name:'media', angle:-10, position:"left", position1:'top', top:0, width:2, left:780}, {name:'government', angle:-10, position:'right', position1:'top',  top:0, width:400, top:280}, {name:'leisure', position:'bottom', position1:'left', angle:10, top:0, width:2, top:330},{name:'marine', position:'left', position1:'top', angle:-45, left:620, width:2, top:330}, {name:'enterprise', position:'left', position1:'top', angle:45, left:620, width:2, top:330}] 
			}  };
		
		baspath = baspath+"sites/all/themes/thuraya/";
		//baspath = '';
		var path = baspath+"images/sprite_sect.png";
		//alert(path);
		//var path = "images/sprite_sector.png";
		var animateTimer = 2500;
		var currentScene = 'home';
		var loadAnimation = true;
		var browserVersion = '8.0';
		var hoverTimer = 500;
		var timeout;
		var mouseOutTime;
		var currentSceneOnChange;
		initialize();
		windowWidth  = $(window).width();
		
		
		
   	function initialize(){	
		//alert('initializing....'+path);
			
		imageObject = new Image();
		imageObject.src = path;
				
		// Check Image loading
		//alert('calling onload....'+imageObject.src);
		imageObject.onload = function() {
			
			// Image loading complete
			addPreloader();
			//if(imageObject.complete){
				if($.browser.version == browserVersion &&  $.browser.msie) {
					$('.lines').css({  display:'none' });
				} else {
					$('.lines').css({ opacity:0 });
				}
				// Initiate the animation
				//$(backgroundImage).load(function(){
											
				setTimeout( function(){
					$('#loader').css({
						'display':'none'				 
					});
					$.loadAnimation(); // Animation
					onHideHomePageSectors();
					setTimeout(function(){
						
						$('.connector').animate({opacity:1}, 1000);	
						if($.browser.version == browserVersion &&  $.browser.msie) {
							$('.lines').css({  display:'block' });
						}else {
							$('.lines').animate({  opacity:1},  1000, function(){}); // Background lines
						}
					},1000)
				}, 500)
				$.loadHomeNavigation();	
				// })
			//}else {
				
			//}	
			$('#home_screen').mouseleave(function(event){
												   event.stopPropagation();
												   alert("test");
				clearTimeout(timeout);									  
			})
		}
	}	
	 function addPreloader(){
		var divLoader = "<div id='loader' class='loader-anim'></div>";	
		$('#animation_container').append(divLoader);
		$('#loader').css({
			width:100,
			height:100
		})
		alignContainers('#loader', {top:true});
	}
	$.loadAnimation = function(){		
		//alert(SectorHover.drawlines.lines.length);
		$lineHTMl = '';
		$('#animation_container').css({width:$(window).width()})
		$(SectorHover.drawlines.lines).each(function(index){
			if(SectorHover.drawlines.lines[index].name == 'relief') {
				$width = $('#home_sreen').offset().left + 220;				
			$lineHTMl  +=  "<div id='"+ SectorHover.drawlines.lines[index].name + "_line' style='position:absolute; "+ SectorHover.drawlines.lines[index].position+":"+ SectorHover.drawlines.lines[index].left +"px; "+ SectorHover.drawlines.lines[index].position1+":" + SectorHover.drawlines.lines[index].top +"px; width:"+ $width +"px; border-"+ SectorHover.drawlines.lines[index].border +":1px solid #CCC; height:"+ SectorHover.drawlines.lines[index].height +"px; display:block; overflow:hidden;' data-angle='"+ SectorHover.drawlines.lines[index].angle +"' class='connector'></div>";
			}
			else if(SectorHover.drawlines.lines[index].name == 'government') {
				$width = $('#home_sreen').offset().left + 240;				
			$lineHTMl  +=  "<div id='"+ SectorHover.drawlines.lines[index].name + "_line' style='position:absolute; "+ SectorHover.drawlines.lines[index].position+":"+ SectorHover.drawlines.lines[index].left +"px; "+ SectorHover.drawlines.lines[index].position1+":" + SectorHover.drawlines.lines[index].top +"px; width:"+ $width +"px; border-"+ SectorHover.drawlines.lines[index].border +":1px solid #CCC; height:"+ SectorHover.drawlines.lines[index].height +"px; display:block; overflow:hidden;' data-angle='"+ SectorHover.drawlines.lines[index].angle +"' class='connector'></div>";
			}
			else if(SectorHover.drawlines.lines[index].name == 'leisure') {
				if($.browser.version !== browserVersion) {
				$left = Math.round($('#home_sreen').offset().left + 487);				
				$lineHTMl  +=  "<div id='"+ SectorHover.drawlines.lines[index].name + "_line' data-left="+ $left +"  style='position:absolute; "+ SectorHover.drawlines.lines[index].position+":"+ $left +"px; "+ SectorHover.drawlines.lines[index].position1+":" + SectorHover.drawlines.lines[index].top +"px; width:2px; border-"+ SectorHover.drawlines.lines[index].border +":1px solid #CCC; height:"+ SectorHover.drawlines.lines[index].height +"px; display:block; overflow:hidden; ' data-angle='"+ SectorHover.drawlines.lines[index].angle +"' class='connector'></div>";
				}
			}
			else if(SectorHover.drawlines.lines[index].name == 'energy') {
				if($.browser.version !== browserVersion) {
				$left = Math.round($('#home_sreen').offset().left + 335);				
			$lineHTMl  +=  "<div id='"+ SectorHover.drawlines.lines[index].name + "_line' data-left="+ $left +" style='position:absolute; "+ SectorHover.drawlines.lines[index].position+":"+ $left +"px;"+ SectorHover.drawlines.lines[index].position1+":" + SectorHover.drawlines.lines[index].top +"px; width:2px; border-"+ SectorHover.drawlines.lines[index].border +":1px solid #CCC; height:"+ SectorHover.drawlines.lines[index].height +"px; display:block; overflow:hidden; -webkit-transform:rotate("+ SectorHover.drawlines.lines[index].angle +"deg); -moz-transform:rotate("+ SectorHover.drawlines.lines[index].angle +"deg); -ms-transform:rotate("+ SectorHover.drawlines.lines[index].angle +"deg)' data-angle='"+ SectorHover.drawlines.lines[index].angle +"' class='connector'></div>";
				}
			}
			else if(SectorHover.drawlines.lines[index].name == 'enterprise')  {
				if($.browser.version !== browserVersion) {
				$left = Math.round($('#home_sreen').offset().left + 545);				
			$lineHTMl  +=  "<div id='"+ SectorHover.drawlines.lines[index].name + "_line' data-left="+ SectorHover.drawlines.lines[index].left +"  style='position:absolute; "+ SectorHover.drawlines.lines[index].position+":"+ $left +"px; "+ SectorHover.drawlines.lines[index].position1+":" + SectorHover.drawlines.lines[index].top +"px; width:"+ SectorHover.drawlines.lines[index].width +"px; border-"+ SectorHover.drawlines.lines[index].border +":1px solid #CCC; height:2px; display:block; overflow:hidden; -webkit-transform:rotate("+ SectorHover.drawlines.lines[index].angle +"deg); -moz-transform:rotate("+ SectorHover.drawlines.lines[index].angle +"deg); -ms-transform:rotate("+ SectorHover.drawlines.lines[index].angle +"deg);' data-angle='"+ SectorHover.drawlines.lines[index].angle +"' class='connector'></div>";
				}
			}
			else if(SectorHover.drawlines.lines[index].name == 'marine')  {
				if($.browser.version !== browserVersion) {
				$left = Math.round($('#home_sreen').offset().left - 58 );	
				
			$lineHTMl  +=  "<div id='"+ SectorHover.drawlines.lines[index].name + "_line' data-left="+ SectorHover.drawlines.lines[index].left +"  style='position:absolute; "+ SectorHover.drawlines.lines[index].position+":"+ $left +"px; "+ SectorHover.drawlines.lines[index].position1+":" + SectorHover.drawlines.lines[index].top +"px; width:"+ SectorHover.drawlines.lines[index].width +"px; border-"+ SectorHover.drawlines.lines[index].border +":1px solid #CCC; height:2px; display:block; overflow:hidden; -webkit-transform:rotate("+ SectorHover.drawlines.lines[index].angle +"deg); -ms-transform:rotate("+ SectorHover.drawlines.lines[index].angle +"deg); -moz-transform:rotate("+ SectorHover.drawlines.lines[index].angle +"deg); ' data-angle='"+ SectorHover.drawlines.lines[index].angle +"' class='connector'></div>";
				}
			}
			else {
				if($.browser.version !== browserVersion) {
				$left = Math.round($('#home_sreen').offset().left + 640);				
			$lineHTMl  +=  "<div id='"+ SectorHover.drawlines.lines[index].name + "_line' data-left="+ $left +"  style='position:absolute; "+ SectorHover.drawlines.lines[index].position+":"+ $left +"px; "+ SectorHover.drawlines.lines[index].position1+":" + SectorHover.drawlines.lines[index].top +"px; width:2px; border-"+ SectorHover.drawlines.lines[index].border +":1px solid #CCC; height:"+ SectorHover.drawlines.lines[index].height +"px; display:block; overflow:hidden; -webkit-transform:rotate("+ SectorHover.drawlines.lines[index].angle +"deg); -moz-transform:rotate("+ SectorHover.drawlines.lines[index].angle +"deg); -ms-transform:rotate("+ SectorHover.drawlines.lines[index].angle +"deg)' data-angle='"+ SectorHover.drawlines.lines[index].angle +"' class='connector'></div>";
				}
			}
			
		})
		$('#animation_container').append($lineHTMl);
		
		$('.connector').css({opacity:0});
		
		$(sectors).each(function(index){
			if($.browser.version == '8.0'){
				var divContainers = "<div data-index='" + index +"' data-left='" + sectors[index].left +"' data-x='" +sectors[index].x +"' data-y='" +sectors[index].y +"' data-scene= '"+ sectors[index].name+"'  id='"+ sectors[index].name + "'style=' overflow:hidden; background-position: -"+ sectors[index].left +"px -200px; ' class='secContainer'><img style='width:96%'  src='"+ baspath +"images/"+ sectors[index].name +"_thumb.png' /></div>";
			}else {
				var divContainers = "<div data-index='" + index +"' data-left='" + sectors[index].left +"' data-x='" +sectors[index].x +"' data-y='" +sectors[index].y +"' data-scene= '"+ sectors[index].name+"'  id='"+ sectors[index].name + "'style=' overflow:hidden; background-position: -"+ sectors[index].left +"px -200px; ' class='secContainer'><img style='width:96%'  src='"+ baspath +"images/"+ sectors[index].name +"_thumb.png' /></div>";
			}
			id  = "#" + sectors[index].name;			
		
				$('#home_sreen').append(divContainers);
				if($.browser.version == browserVersion &&  $.browser.msie) {
				$(id).css({
					left:sectors[index].ix,
					top:sectors[index].iy,
					width:200,
					height:200,
					position:'absolute',
					zIndex:1
				});
				} else {
					$(id).css({
					left:sectors[index].ix,
					top:sectors[index].iy,
					width:200,
					height:200,
					position:'absolute',
					zIndex:1,
					opacity:0
					});
				}
				
				if($.browser.version == browserVersion &&  $.browser.msie) {	
				
					$(id).animate(
					{ left:sectors[index].x, top:sectors[index].y}, 1000)
					
				}else {
					$(id).animate(
					{opacity:1, left:sectors[index].x, top:sectors[index].y},{easing: 'easeInOutElastic', duration:animateTimer})
				}
			})	
		
		if($.browser.version == '8.0'){
			$.onSectorMouseHoverIE8();
		}else {
			$.onSectorMouseHover();
		}
	},
	
	$.onRotateSectorConnectors =  function(name){		
	
		if(!$.browser.msie) {
		if(name == 'relief' || name == 'energy' || name == 'marine') {
			
			$(SectorHover.relief.lines).each(function(index){
				
				id= "#" + SectorHover.relief.lines[index].name + "_line";
				if(SectorHover.relief.lines[index].name =='relief') {					
					$(id).css({ 
						top:270,
						//width:SectorHover.relief.lines[index].width,
						'-webkit-transform':'rotate('+ SectorHover.relief.lines[index].angle+'deg)' ,
						'-moz-transform':'rotate('+ SectorHover.relief.lines[index].angle+'deg)' 
					});
				}
				if(SectorHover.relief.lines[index].name == 'government') {					
					$(id).css({ 
						top:320,
						//width:SectorHover.relief.lines[index].width,
						'-webkit-transform':'rotate('+ SectorHover.relief.lines[index].angle+'deg)' ,
						'-moz-transform':'rotate('+ SectorHover.relief.lines[index].angle+'deg)' 
					});
				}		
				if(SectorHover.relief.lines[index].name == 'marine' || SectorHover.relief.lines[index].name == 'enterprise') {					
					$(id).css({ 
						'-webkit-transform':'rotate('+ SectorHover.relief.lines[index].hangle+'deg)' ,
						'-moz-transform':'rotate('+ SectorHover.relief.lines[index].hangle+'deg)' 
					});
				}		
				else {
				
					if(SectorHover.relief.lines[index].name == 'media' ){
						$left = Math.round(parseInt($(id).data('left'))) + 10;
					} 
					else if(SectorHover.relief.lines[index].name == 'leisure' ){
						$left = Math.round(parseInt($(id).data('left')));
					} else {
						$left = Math.round(parseInt($(id).data('left'))) + 40;
					}
					$(id).css({ 
						left:$left,
						//width:SectorHover.relief.lines[index].width,
						'-webkit-transform':'rotate('+ SectorHover.relief.lines[index].angle+'deg)',
						'-moz-transform':'rotate('+ SectorHover.relief.lines[index].angle+'deg)' 
					});
				}
			})
		}
		else if(name == 'government' || name == 'enterprise' || name == 'media') {
			$(SectorHover.government.lines).each(function(index){
				id= "#" + SectorHover.government.lines[index].name + "_line";
				if(SectorHover.government.lines[index].name =='relief') {			
					
					$(id).css({ 
						top:310,
						//width:SectorHover.relief.lines[index].width,
						'-webkit-transform':'rotate('+ SectorHover.government.lines[index].angle+'deg)' ,
						'-moz-transform':'rotate('+ SectorHover.government.lines[index].angle+'deg)' 
					});
				}
				if(SectorHover.government.lines[index].name == 'government') {			
					$top = 275;
					$(id).css({ 
						top:$top,
						//width:SectorHover.relief.lines[index].width,
						'-webkit-transform':'rotate('+ SectorHover.government.lines[index].angle+'deg)' ,
						'-moz-transform':'rotate('+ SectorHover.government.lines[index].angle+'deg)' 
					});
				}
				if(SectorHover.government.lines[index].name == 'leisure') {			
					$left = Math.round(parseInt($(id).data('left'))) - 15; 
					$(id).css({ 
						left:$left,
						//width:SectorHover.relief.lines[index].width,
						'-webkit-transform':'rotate('+ SectorHover.government.lines[index].angle+'deg)',
						'-moz-transform':'rotate('+ SectorHover.government.lines[index].angle+'deg)' 
					});
				}
				if(SectorHover.government.lines[index].name == 'marine' || SectorHover.government.lines[index].name == 'enterprise') {					
					$(id).css({ 
						'-webkit-transform':'rotate('+ SectorHover.government.lines[index].hangle+'deg)' ,
						'-moz-transform':'rotate('+ SectorHover.government.lines[index].hangle+'deg)' 
					});
				}
				else {
					if(SectorHover.government.lines[index].name == 'media' ){
						$left = Math.round(parseInt($(id).data('left'))) - 40;
					} 
					else if(SectorHover.government.lines[index].name == 'leisure' ){
						$left = Math.round(parseInt($(id).data('left'))) - 10;
					} else {
						$left = Math.round(parseInt($(id).data('left'))) + 20;
					}
					$(id).css({ 
						left:$left,
						//width:SectorHover.relief.lines[index].width,
						'-webkit-transform':'rotate('+ SectorHover.government.lines[index].angle +'deg)',
						'-moz-transform':'rotate('+ SectorHover.government.lines[index].angle +'deg)' 
					});
					
				}
			})
		}
		else if(name == 'leisure') {
			
			$(SectorHover.relief.lines).each(function(index){
				id= "#" + SectorHover.relief.lines[index].name + "_line";
				if(SectorHover.relief.lines[index].name =='relief' || SectorHover.relief.lines[index].name == 'government') {					
					$(id).css({ 
						top:300,
						'-webkit-transform':'rotate('+ 0+'deg)' ,
						'-moz-transform':'rotate('+ 0 +'deg)' 
					});
				}
				if(SectorHover.relief.lines[index].name == 'marine' || SectorHover.relief.lines[index].name == 'enterprise') {					
					$left = Math.round(parseInt($(id).data('left')));
					$(id).css({ 
						'-webkit-transform':'rotate('+ SectorHover.relief.lines[index].angle+'deg)' ,
						'-moz-transform':'rotate('+ SectorHover.relief.lines[index].angle+'deg)' 
					});
				}
				else {
					$degree = Math.round(parseInt($(id).data('angle')));					
					$(id).css({ 
						'-webkit-transform':'rotate('+ $degree +'deg)',
						'-moz-transform':'rotate('+ $degree +'deg)' 
					});
				}
				})
			}
		}
	}
	$.applyRotateAngles = function(degree){
		if(!$.browser.msie) {
		//alert(degree);
			$('.lines').css( {
				'-webkit-transform' :"rotate("+ degree +"deg)",
				'-moz-transform' :"rotate("+ degree +"deg)"
			});	
		}
	}
	$.onHoverUpdateSectorTitleFontSize =function(state){
		if(!$.browser.msie) {
			setTimeout(function(){
				$(sectors).each(function(index){
					setId  = "#" + sectors[index].name;	
					if(state == 'hover')
					$(setId).find('.text').animate({top:95, 'font-size':10}, 500)
					else 
					$(setId).find('.text').animate({top:135, 'font-size':12}, 500)
				})
			}, 200)
		}
	} 
	var waitingTimer = 300;
	$.onSectorMouseHover = function(){	
		
		$('.secContainer').hover(function(event){ // Mouse Hover Effect	
				
				clearTimeout(mouseOutTime);	
				
			 	event.stopPropagation();
				currentId  = '#' +  $(this).data('scene');
				timeout =  setTimeout(function(){				
												 
				if( $(currentId).data('scene') == 'relief' ) {
					//timeout =  setTimeout(function(){				
					if(!$.browser.msie) {
						$.applyRotateAngles(SectorHover.relief.deg);
						$.onRotateSectorConnectors('relief');	
						$(currentId).animate({width:220, height:220, left:SectorHover.relief.left, top:SectorHover.relief.top}, hoverTimer);
						$(SectorHover.relief.others).each(function(index){
							id =  '#' + SectorHover.relief.others[index].name;
							$(id).animate({width:140, height:140, left:SectorHover.relief.others[index].left, top:SectorHover.relief.others[index].top}, hoverTimer, 'easeInOutSine');
						})	
					}else {
						$(currentId).animate({width:220, height:220, left:SectorHover.relief.ieleft, top:SectorHover.relief.ietop}, hoverTimer);
						$(SectorHover.relief.others).each(function(index){
						id =  '#' + SectorHover.relief.others[index].name;
						$(id).animate({width:140, height:140, left:SectorHover.relief.others[index].ieleft, top:SectorHover.relief.others[index].ietop}, hoverTimer, 'easeInOutSine');
						})	

					}
					//}, waitingTimer)
				}
				else if( $(currentId).data('scene')  == 'energy' ) {
					//timeout =  setTimeout(function(){					
					if(!$.browser.msie) {
					$.applyRotateAngles(SectorHover.energy.deg);
					$.onRotateSectorConnectors('energy');
					$(currentId).animate({width:220, height:220, left:SectorHover.energy.left, top:SectorHover.energy.top}, hoverTimer);
					$(SectorHover.energy.others).each(function(index){
						id =  '#' + SectorHover.energy.others[index].name;
						$(id).animate({width:140, height:140, left:SectorHover.energy.others[index].left, top:SectorHover.energy.others[index].top}, hoverTimer, 'easeInOutSine');	
					})
					} else {
						$(currentId).animate({width:220, height:220, left:SectorHover.energy.ieleft, top:SectorHover.energy.ietop}, hoverTimer);
						$(SectorHover.energy.others).each(function(index){
						id =  '#' + SectorHover.energy.others[index].name;
						$(id).animate({width:140, height:140, left:SectorHover.energy.others[index].ieleft, top:SectorHover.energy.others[index].ietop}, hoverTimer, 'easeInOutSine');	
						})
					}
					//},waitingTimer)
				}
				else if( $(currentId).data('scene')  == 'marine' ) {
					
					//timeout =  setTimeout(function(){
					$.applyRotateAngles(SectorHover.marine.deg);
					$.onRotateSectorConnectors('marine');
					if(!$.browser.msie) {
						$(currentId).animate({width:220, height:220, left:SectorHover.marine.left, top:SectorHover.marine.top}, hoverTimer);
						$(SectorHover.marine.others).each(function(index){
							id =  '#' + SectorHover.marine.others[index].name;					
							$(id).animate({width:140, height:140, left:SectorHover.marine.others[index].left, top:SectorHover.marine.others[index].top}, hoverTimer, 'easeInOutSine');
						})
					}else {
						$(currentId).animate({width:220, height:220, left:SectorHover.marine.ieleft, top:SectorHover.marine.ietop}, hoverTimer);
						$(SectorHover.marine.others).each(function(index){
							id =  '#' + SectorHover.marine.others[index].name;					
							$(id).animate({width:140, height:140, left:SectorHover.marine.others[index].ieleft, top:SectorHover.marine.others[index].ietop}, hoverTimer, 'easeInOutSine');
						})

					}
					//}, waitingTimer)
				}
				else if( $(currentId).data('scene')  == 'media' ) {						
					//timeout =  setTimeout(function(){
						$.applyRotateAngles(SectorHover.media.deg);
						$.onRotateSectorConnectors('media');
						if(!$.browser.msie) {
							$(currentId).animate({width:220, height:220, left:SectorHover.media.left, top:SectorHover.media.top}, hoverTimer);
							$(SectorHover.media.others).each(function(index){
								id =  '#' + SectorHover.media.others[index].name;					
								$(id).animate({width:140, height:140, left:SectorHover.media.others[index].left, top:SectorHover.media.others[index].top}, hoverTimer, 'easeInOutSine');
							})
						}else {
							$(currentId).animate({width:220, height:220, left:SectorHover.media.ieleft, top:SectorHover.media.ietop}, hoverTimer);
							$(SectorHover.media.others).each(function(index){
								id =  '#' + SectorHover.media.others[index].name;					
								$(id).animate({width:140, height:140, left:SectorHover.media.others[index].ieleft, top:SectorHover.media.others[index].ietop}, hoverTimer, 'easeInOutSine');
							})
	
						}
					//}, waitingTimer)
				}
				else if( $(currentId).data('scene')  == 'government' ) {
										
					//timeout =  setTimeout(function(){
					$.applyRotateAngles(SectorHover.government.deg);
					$.onRotateSectorConnectors('government');
					if(!$.browser.msie) {
					$(currentId).animate({width:220, height:220, left:SectorHover.government.left, top:SectorHover.government.top}, hoverTimer);
					$(SectorHover.government.others).each(function(index){
						id =  '#' + SectorHover.government.others[index].name;					
						$(id).animate({width:140, height:140, left:SectorHover.government.others[index].left, top:SectorHover.government.others[index].top}, hoverTimer, 'easeInOutSine');
					})
					}else {
					$(currentId).animate({width:220, height:220, left:SectorHover.government.ieleft, top:SectorHover.government.ietop}, hoverTimer);
					$(SectorHover.government.others).each(function(index){
						id =  '#' + SectorHover.government.others[index].name;					
						$(id).animate({width:140, height:140, left:SectorHover.government.others[index].ieleft, top:SectorHover.government.others[index].ietop}, hoverTimer, 'easeInOutSine');
					})
					}
					//}, waitingTimer)
				}
				else if( $(currentId).data('scene')  == 'enterprise' ) {
					
					//timeout =  setTimeout(function(){
					if(!$.browser.msie) {
					$.applyRotateAngles(SectorHover.enterprise.deg);					
					$.onRotateSectorConnectors('enterprise');
					$(currentId).animate({width:220, height:220, left:SectorHover.enterprise.left, top:SectorHover.enterprise.top}, hoverTimer);
					$(SectorHover.enterprise.others).each(function(index){
						id =  '#' + SectorHover.enterprise.others[index].name;					
						$(id).animate({width:140, height:140, left:SectorHover.enterprise.others[index].left, top:SectorHover.enterprise.others[index].top}, hoverTimer, 'easeInOutSine');
					})
					}else {
					$(currentId).animate({width:220, height:220, left:SectorHover.enterprise.ieleft, top:SectorHover.enterprise.ietop}, hoverTimer);
					$(SectorHover.enterprise.others).each(function(index){
						id =  '#' + SectorHover.enterprise.others[index].name;					
						$(id).animate({width:140, height:140, left:SectorHover.enterprise.others[index].ieleft, top:SectorHover.enterprise.others[index].ietop}, hoverTimer, 'easeInOutSine');
					})
					}
					//}, waitingTimer)
				}
				else if( $(currentId).data('scene')  == 'leisure' ) {
					
					
					//timeout =  setTimeout(function(){	
						$.applyRotateAngles(SectorHover.leisure.deg);
					$.onRotateSectorConnectors('leisure');
						$(currentId).animate({width:230, height:230, left:SectorHover.leisure.left, top:SectorHover.leisure.top}, hoverTimer);
						$(SectorHover.leisure.others).each(function(index){
							id =  '#' + SectorHover.leisure.others[index].name;					
							$(id).animate({width:140, height:140, left:SectorHover.leisure.others[index].left, top:SectorHover.leisure.others[index].top}, hoverTimer, 'easeInOutSine');
						})
					//}, waitingTimer)
				}else {
					return false;	
				}	
				}, waitingTimer)
				return false;
		}, function(event){ // Mouse OUt
			clearTimeout(timeout);	
			event.stopPropagation();			
			mouseOutTime = setTimeout(function(){
				
				$.applyRotateAngles(0);
			
				$(sectors).each(function(index){									
					id =  '#' + sectors[index].name;				
					$(id).animate({width:197, height:193,left:sectors[index].x, top:sectors[index].y}, 500, 'easeInOutSine');
				})						
			
				$(SectorHover.relief.lines).each(function(index){
					id= "#" + SectorHover.relief.lines[index].name + "_line";
					
					if(SectorHover.relief.lines[index].name =='relief' || SectorHover.relief.lines[index].name == 'government') {
						$top = 300; 
						$(id).css({ 
							top:$top,
							//width:SectorHover.relief.lines[index].width,
							'-webkit-transform':'rotate('+ 0+'deg)' ,
							'-moz-transform':'rotate('+ 0 +'deg)' 
						});
					}
					else if(SectorHover.relief.lines[index].name =='marine' || SectorHover.relief.lines[index].name == 'enterprise'){
						
						$(id).css({ 
							'-webkit-transform':'rotate('+ $(id).data('angle') +'deg)' ,
							'-moz-transform':'rotate('+ $(id).data('angle') +'deg)' 
						});
					}
					else {
						$left = Math.round(parseInt($(id).data('left'))); 
						$(id).css({ 
							left:$left,
							//width:SectorHover.relief.lines[index].width,
							'-webkit-transform':'rotate('+  Math.round(parseInt($(id).data('angle'))) +'deg)',
							'-moz-transform':'rotate('+  Math.round(parseInt($(id).data('angle'))) +'deg)' 
						});
					}
				})
				
				clearTimeout(timeout);	
			}, 400)
		})
	}//  end Hover Function
	
// Strart IE 8 function
$.onSectorMouseHoverIE8 = function(){	
		
		$('.secContainer').hover(function(event){ // Mouse Hover Effect	
				clearTimeout(mouseOutTime);					  
			 	event.stopPropagation();
				currentId  = '#' +  $(this).data('scene');						
				if( $(currentId).data('scene') == 'relief' ) {
					timeout =  setTimeout(function(){				
						$(currentId).animate({width:220, height:220, left:SectorHover.relief.ieleft, top:SectorHover.relief.ietop}, hoverTimer);
						$(SectorHover.relief.others).each(function(index){
						id =  '#' + SectorHover.relief.others[index].name;
						$(id).animate({width:140, height:140, left:SectorHover.relief.others[index].ieleft, top:SectorHover.relief.others[index].ietop}, hoverTimer);
						})	
					
					}, 50)
				}
				else if( $(currentId).data('scene')  == 'energy' ) {
					timeout =  setTimeout(function(){					
						$(currentId).animate({width:220, height:220, left:SectorHover.energy.ieleft, top:SectorHover.energy.ietop}, hoverTimer);
						$(SectorHover.energy.others).each(function(index){
						id =  '#' + SectorHover.energy.others[index].name;
						$(id).animate({width:140, height:140, left:SectorHover.energy.others[index].ieleft, top:SectorHover.energy.others[index].ietop}, hoverTimer);	
						})
					}, 50)
				}
				else if( $(currentId).data('scene')  == 'marine' ) {
					
					timeout =  setTimeout(function(){
						$(currentId).animate({width:220, height:220, left:SectorHover.marine.ieleft, top:SectorHover.marine.ietop}, hoverTimer);
						$(SectorHover.marine.others).each(function(index){
							id =  '#' + SectorHover.marine.others[index].name;					
							$(id).animate({width:140, height:140, left:SectorHover.marine.others[index].ieleft, top:SectorHover.marine.others[index].ietop}, hoverTimer);
							})
					}, 50)
				}
				else if( $(currentId).data('scene')  == 'media' ) {	
					timeout =  setTimeout(function(){
						$(currentId).animate({width:220, height:220, left:SectorHover.media.ieleft, top:SectorHover.media.ietop}, hoverTimer);
							$(SectorHover.media.others).each(function(index){
								id =  '#' + SectorHover.media.others[index].name;					
								$(id).animate({width:140, height:140, left:SectorHover.media.others[index].ieleft, top:SectorHover.media.others[index].ietop}, hoverTimer);
							})
					}, 50)
				}
				else if( $(currentId).data('scene')  == 'government' ) {
					timeout =  setTimeout(function(){
						$(currentId).animate({width:220, height:220, left:SectorHover.government.ieleft, top:SectorHover.government.ietop}, hoverTimer);
						$(SectorHover.government.others).each(function(index){
						id =  '#' + SectorHover.government.others[index].name;					
						$(id).animate({width:140, height:140, left:SectorHover.government.others[index].ieleft, top:SectorHover.government.others[index].ietop}, hoverTimer);
						})
					}, 50)
				}
				else if( $(currentId).data('scene')  == 'enterprise' ) {
					
					timeout =  setTimeout(function(){
						$(currentId).animate({width:220, height:220, left:SectorHover.enterprise.ieleft, top:SectorHover.enterprise.ietop}, hoverTimer);
						$(SectorHover.enterprise.others).each(function(index){
							id =  '#' + SectorHover.enterprise.others[index].name;					
							$(id).animate({width:140, height:140, left:SectorHover.enterprise.others[index].ieleft, top:SectorHover.enterprise.others[index].ietop}, hoverTimer);
						})
					}, 150)
				}
				else if( $(currentId).data('scene')  == 'leisure' ) {
					timeout =  setTimeout(function(){
						$(currentId).animate({width:230, height:230, left:SectorHover.leisure.left, top:SectorHover.leisure.top}, hoverTimer);
						$(SectorHover.leisure.others).each(function(index){
							id =  '#' + SectorHover.leisure.others[index].name;					
							$(id).animate({width:140, height:140, left:SectorHover.leisure.others[index].left, top:SectorHover.leisure.others[index].top}, hoverTimer);
						})
					}, 150)
				}else {
					return false;	
				}			
		}, function(event){ // Mouse OUt
			clearTimeout(timeout);	
			event.stopPropagation();			
			mouseOutTime = setTimeout(function(){
				$(sectors).each(function(index){									
					id =  '#' + sectors[index].name;				
					$(id).animate({width:197, height:193,left:sectors[index].x, top:sectors[index].y}, 500);
				})		
				clearTimeout(timeout);	
			}, 100)
		})
	}
// End IE 8 function
	
	$.loadHomeNavigation =  function(){
		
		var navContainer  = "<div id='homePagerContainer' class='bottomNavigation'></div>";
		$('#home_sreen').append(navContainer);
		
		$('#homePagerContainer').css({
			left:( ($('#home_sreen').width() - $('#homePagerContainer').width()) /2 )							 
		})
		$(homeNavigation).each(function(index) {
			elements = "<div id='"+ homeNavigation[index].name +"'class='homeNaviContainer' style='background-position:-"+ homeNavigation[index].x +"px -5px;' data-url='"+ homeNavigation[index].url  +"' data-hover='"+ homeNavigation[index].hx +"' data-normal='"+ homeNavigation[index].x +"'></div>";
			$('#homePagerContainer').append(elements);
			if($.browser.version == browserVersion &&  $.browser.msie) {
			
				$('.homeNaviContainer').css({
					left:255,
					position:'absolute'
				});
			} else {
					$('.homeNaviContainer').css({
					'opacity':0,
					left:255,
					position:'absolute'
				});

			}
			
			id = "#" +  homeNavigation[index].name;
			if($.browser.version == browserVersion &&  $.browser.msie) {
				$(id).animate({ left:(index*140)}, 3000)
			}else {
				$(id).animate(
				{opacity:1, left:(index*140)},
				{easing: 'easeInOutElastic', duration:5000}, 
				function(){
				  
				})	
			}
		})
		$.addHoverEffectMainNaivgation();		
	},
	
	$.addHoverEffectMainNaivgation = function(){
		$('.homeNaviContainer').hover(function(){ // Mouse Hover Effect			
			$(this).css({
				'background-position':(- $(this).attr('data-hover') + 'px -5px ')		
			})
			if($.browser.version == browserVersion &&  $.browser.msie) { 
				$(this).animate({}, 500, function(){	
					$(this).animate({}, 500)
				})
			} else {
				$(this).animate({opacity:.1}, 500, function(){	
					$(this).animate({opacity:1}, 500)
				})
			}
		}, function(){ // Mouse leave effect
			$(this).css({
				'background-position':(- $(this).attr('data-normal') + 'px -5px ')		
			})
			if($.browser.version == browserVersion &&  $.browser.msie) { 
				//$(this).animate({}, 500)		
			}else {
				$(this).animate({opacity:1}, 500)	
			}
		})
		$('.homeNaviContainer').click(function(){
			if($(this).data('url') != '#') {
				url =  location.href + $(this).data('url');
				window.location = url;
			}
			return false;
		})
	}
	
	function onHideHomePageSectors(){
		 
		$('.secContainer').click(function(){
			/*$('.connector').animate({opacity:0}, 10);
			$('#animation_container').css({
							'background-image':'none', 
							'background-repeat':'repeat-x',
							'background-position':'0 285px'
			});	
			$('.refresh').css({display:'block'});
			if(loadAnimation) {
				$.loadInnerPageNavigation();
				loadAnimation = false;
			}
			if(!$('.innerPageContainer').attr('class')) {
				var innerPageContainer = '<div style="display:block;" class="innerPageContainer"></div>';
				$('#animation_container').append(innerPageContainer)
			}
			
		
			$.animateSectors($(this).data('index'));*/
			currentScene  =  $(this).data('scene');	
			window.location = "/"+currentScene+"-comms";
		})		
		$('.refresh').click(function(){	
			if(currentSceneOnChange == 'relief') {				 
				$('#home_sreen').animate({opacity:1, left:0, top:0, position:'relative'}, 1500, function(){
						$('.connector').animate({opacity:1}, 30);															 
				});	
				$('.innerPageContainer').animate({opacity:0, left:$(document).width(), top:0 }, 1500, function(){});	
			}
			else if(currentSceneOnChange == 'government') {				 
				$('#home_sreen').animate({opacity:1, left:0, top:0, position:'relative'}, 1500, function(){
						$('.connector').animate({opacity:1}, 30);															 
				});	
				$('.innerPageContainer').animate({opacity:0, left:-$(document).width(), top:0 }, 1500, function(){});	
			}
			else if(currentSceneOnChange == 'energy' || currentSceneOnChange == 'media') {				 
				$('#home_sreen').animate({opacity:1, left:0, top:0, position:'relative'}, 1500, function(){
						$('.connector').animate({opacity:1}, 30);															 
				});	
				$('.innerPageContainer').animate({opacity:0, left:0, top:715 }, 1500, function(){});	
			}else{
				$('#home_sreen').animate({opacity:1, left:0, top:0, position:'relative'}, 1500, function(){
						$('.connector').animate({opacity:1}, 30);															 
				});	
				$('.innerPageContainer').animate({opacity:0, left:0, top:-715 }, 1500, function(){});	
			}
			
			
			if($.browser.version == browserVersion &&  $.browser.msie) {
				$('#innarPageNavContainer').animate({opacity:1, top:1500}, 500);
			}else {
				$('#innarPageNavContainer').animate({opacity:0, top:1000}, 500);
			}
			$('.subNavElement').each(function(){
                $(this).data('state', 'normal');                                  
            })
			$(this).css({display:'none'});
			currentScene = 'home';
		})
	}
	/*
		Sub Navigation Tooltip Animation
	*/
	
	$.animateToolTip = function(obj, source){
		
		var getTooltipHTML  = '';
		//var textReadMore  = '<br><a href="javascript:void(0)" class="anchor">Read More <span class="ui-icon plus"></span></a>';
		$(sectors).each(function(index){			
			 if(sectors[index].name ==  source){
				getTooltipHTML = "<span class='ui-icon "+ source+"_icon '></span>" + sectors[index].title + sectors[index].description + '<br><a href="'+ sectors[index].url +'" class="anchor">Read More <span class="ui-icon plus"></span></a>';
			}					  
		})		
		$.tooltip(obj, {
			html :getTooltipHTML,
			className:'tooltip_sector tip_' + source
		});
		$('.tooltip_sector').css({
			left:180,
			top:45,
			opacity:0
		})
		$('.tooltip_sector').animate({opacity:1, top:60, left:195}, {easing: 'easeInOutElastic', duration:500});
	}
	$.createSubPages = function(){
			
			$subPages = "<ul class='subPages' id='transist'>";
			
			$(sectors).each(function(index) {								 
					if($.browser.version == browserVersion &&  $.browser.msie) { 
				$subPages += '<li data-role="'+ sectors[index].name +'" class="innerpage-bg" style="background-image:url('+ baspath+'images/'+ sectors[index].name +'_ie.png); background-repeat:no-repeat; position:relative;" ><div class="in-secContainer  '+ sectors[index].name + '">'+ sectors[index].text +'<div class="tooltip_sector tip_' + sectors[index].name + '"> <span class="ui-icon ' + sectors[index].name + '_icon"></span>'+ sectors[index].title +'<p>' + sectors[index].description +'</p> <a href="' + sectors[index].url +'" class="anchor">Read More <span class="ui-icon plus"></span></a></div></div</li>';	
					}else {
						$subPages += '<li data-role="'+ sectors[index].name +'" class="innerpage-bg" style="background-image:url('+ baspath +'images/'+ sectors[index].name +'.png); background-repeat:no-repeat; position:relative;" ><div class="in-secContainer  '+ sectors[index].name + '">'+ sectors[index].text +'<div class="tooltip_sector tip_' + sectors[index].name + '"> <span class="ui-icon ' + sectors[index].name + '_icon"></span>'+ sectors[index].title +'<p>' + sectors[index].description +'</p> <a href="' + sectors[index].url +'" class="anchor">Read More <span class="ui-icon plus"></span></a></div></div</li>';	
					}
			})
			$subPages += "</ul>";
		
			$('.innerPageContainer').append($subPages).css({top:1000})
			
			if($.browser.version == browserVersion &&  $.browser.msie) { 		
				$('.innerPageContainer').css({
					position:'absolute',
					width:'1152px',
					height:715,
					margin:'auto',
					opacity:0,
					left:  ((parseInt($(window).width()) - parseInt(1152) ) / 2)
				})
			}else {
				$('.innerPageContainer').css({
					position:'absolute',
					width:'100%',
					height:715,
					opacity:0
				})
			}
		
	}
	function onChangeInnerPagePosition(sectorName, source){
		
		if(currentSceneOnChange == 'relief'){
			$('.innerPageContainer').css({ 
				top:0,
				left:$(document).width()
			});
			if($.browser.version == browserVersion &&  $.browser.msie) { 
					$('#home_sreen').animate({opacity:.3, left:-$(document).width(), top:0}, 2500);	
					
					$('.innerPageContainer').animate({top:0, left:0}, 2000, function(){ 				
						$('#innarPageNavContainer').css({display:'block'});	
						$('#innarPageNavContainer').css({top:800});
						$('#innarPageNavContainer').animate({top:650}, 1000);
						$.updateNavigationState(sectors[parseInt(source)].name);
					});			
				}else {
					
					$('#home_sreen').animate({opacity:.3, left:-$(document).width(), top:0}, 2500, 'swing');	
					$('.innerPageContainer').animate({opacity:1, top:0, left:0}, 2000, 'swing',  function(){ 				
						$('#innarPageNavContainer').css({display:'block'});	
						$('#innarPageNavContainer').css({top:800});
						$('#innarPageNavContainer').animate({top:650, opacity:1}, {easing: 'easeOutQuint', duration:1000});
						$.updateNavigationState(sectors[parseInt(source)].name);
					});	
			}
		}
		else if(currentSceneOnChange == 'government'){
			$('.innerPageContainer').css({ 
				top:0,
				left:-$(document).width()
			});
			if($.browser.version == browserVersion &&  $.browser.msie) { 
					$('#home_sreen').animate({opacity:.3, left:-$(document).width(), top:0},2500);	
					
					$('.innerPageContainer').animate({opacity:1, top:0, left:0}, 2500, function(){ 				
						$('#innarPageNavContainer').css({display:'block'});	
						$('#innarPageNavContainer').css({top:800});
						$('#innarPageNavContainer').animate({top:650, opacity:1}, 1000);
						$.updateNavigationState(sectors[parseInt(source)].name);
					});			
				}else {
					$('#home_sreen').animate({opacity:.3, left:$(document).width(), top:0},2500, 'swing');	
					$('.innerPageContainer').animate({opacity:1, top:0, left:0}, 2000, 'swing',  function(){ 				
						$('#innarPageNavContainer').css({display:'block'});	
						$('#innarPageNavContainer').css({top:800});
						$('#innarPageNavContainer').animate({top:650, opacity:1}, {easing: 'easeOutQuint', duration:1000});
						$.updateNavigationState(sectors[parseInt(source)].name);
					});	
			}
		}
		else if(currentSceneOnChange == 'energy' || currentSceneOnChange == 'media'){
			$('.innerPageContainer').css({ 
				top:715,
				left:0
			});
			if($.browser.version == browserVersion &&  $.browser.msie) { 
					$('#home_sreen').animate({opacity:.3, left:0, top:-715},2500);
					$('.innerPageContainer').animate({opacity:1, top:0, left:0}, 2000, function(){ 				
						$('#innarPageNavContainer').css({display:'block'});	
						$('#innarPageNavContainer').css({top:800});
						$('#innarPageNavContainer').animate({top:650, opacity:1}, 1000);
						$.updateNavigationState(sectors[parseInt(source)].name);
					});			
				}else {
					$('#home_sreen').animate({opacity:.3, left:0, top:-715},2500, 'swing');	
					$('.innerPageContainer').animate({opacity:1, top:0, left:0}, 2000, 'swing', function(){ 				
						$('#innarPageNavContainer').css({display:'block'});	
						$('#innarPageNavContainer').css({top:800});
						$('#innarPageNavContainer').animate({top:650, opacity:1}, {easing: 'easeOutQuint', duration:1000});
						$.updateNavigationState(sectors[parseInt(source)].name);
					});	
			}
		}
		else if(currentSceneOnChange == 'marine' || currentSceneOnChange == 'leisure' || currentSceneOnChange == 'enterprise'){
			$('.innerPageContainer').css({ 
				top:-715,
				left:0
			});
			if($.browser.version == browserVersion &&  $.browser.msie) { 
					$('#home_sreen').animate({opacity:.3, left:0, top:715},2500);
					$('.innerPageContainer').animate({opacity:1, top:0, left:0}, 2000, function(){ 				
						$('#innarPageNavContainer').css({display:'block'});	
						$('#innarPageNavContainer').css({top:800});
						$('#innarPageNavContainer').animate({top:650, opacity:1}, 1000);
						$.updateNavigationState(sectors[parseInt(source)].name);
					});			
				}else {
					$('#home_sreen').animate({opacity:.3, left:0, top:715},2500, 'swing');	
					$('.innerPageContainer').animate({opacity:1, top:0, left:0}, 2000, 'swing', function(){ 				
						$('#innarPageNavContainer').css({display:'block'});	
						$('#innarPageNavContainer').css({top:800});
						$('#innarPageNavContainer').animate({top:650, opacity:1}, {easing: 'easeOutQuint', duration:1000});
						$.updateNavigationState(sectors[parseInt(source)].name);
					});	
			}
		}
	}
	
	/*
		Inner pages animation
		Sectors  :-  diffence, aviation, marine, energy, relief, media
		parasm : image source, sector Name
	*/
	$.animateInnerPageContent =  function(source){
		
		if($('.subPages').attr('class') == undefined || $('.subPages').attr('class') == null ) {	
			$.createSubPages();
		}
		var backgroundImage = new Image();	
		$('#loader').css({'display':'block'	});
		
		if(currentScene ==  'home') {
			//sectors[source].name
			$(backgroundImage).load(function(){
				$('#loader').css({'display':'none'	});
				$('.subPages').animate({opacity:.2}, 200);
				$('.subPages').animate({top:-(parseInt(source) * 715), opacity:1}, 100);	
				currentSceneOnChange = sectors[source].name;
				onChangeInnerPagePosition(sectors[source].name, source);
				currentScene = sectors[parseInt(source)].name; 
			})
			backgroundImage.src = baspath + 'images/' + sectors[parseInt(source)].name + '.png';
			//backgroundImage.src = 'images/' + sectors[parseInt(source)].name + '.png';
		}else {
			if(source < 7) {
				$(backgroundImage).load(function(){
					$('#loader').css({'display':'none'	});
					$('.tooltip_sector').animate({ height:0, opacity:0, 'overflow':'hidden'}, 1000)
					if($.browser.version == browserVersion &&  $.browser.msie) { 
						$('.subPages').animate({top:-(parseInt(source) * 715), left:0, opacity:.5}, 1500, function(){
							$(this).animate({opacity:1}, 1000);
							setTimeout(function(){
								$('.tooltip_sector').animate({height:250, opacity:1},  1000);		
							 }, 100);
						});
					} else {
						$('.subPages').animate({top:-(parseInt(source) * 715), left:0, opacity:.5}, 100, function(){
							$(this).animate({opacity:1}, 1000);
							setTimeout(function(){
								$('.tooltip_sector').animate({height:250, opacity:1},  1000);		
							 }, 100);
						});
					}
				})	
				backgroundImage.src = baspath + 'images/' + sectors[parseInt(source)].name + '.png';
				
				//backgroundImage.src = 'images/' + sectors[parseInt(source)].name + '.png';
			}
		}
	}	
	/*
		Add Inner pages for secotrs
		Sectors  :-  diffence, aviation, marine, energy, relief, media
	*/
	$.animateSectors = function(state){
		$.animateInnerPageContent(state);
	}
	/*
		Create inner page navigaton
		displayling at bottom of the page. 
	*/
	$.loadInnerPageNavigation = function(){
		var navContainer  =  '<div id="innarPageNavContainer" class="innarPageContainer"></div>'	
		//animation_container
		$('#animation_container').append(navContainer);
		if($.browser.version == browserVersion &&  $.browser.msie) { 
			$('#innarPageNavContainer').css({
				display:'none',
				position:'absolute',
				opacity:1,
				top:800,
				'z-index':'100',
				'min-width':(innerPagesNavigation.length * 54)
			});
		} else {
			$('#innarPageNavContainer').css({
				display:'none',
				position:'absolute',
				opacity:0,
				top:800,
				'z-index':'100',
				'min-width':(innerPagesNavigation.length * 54)
			});

		}
		$(innerPagesNavigation).each(function(index){
			element = "<div class='subNavElement' id='"+ innerPagesNavigation[index].name +"_btn' data-ref='"+ innerPagesNavigation[index].name +"' data-index='"+ index+"' data-url='"+ innerPagesNavigation[index].url +"' data-hover='"+ innerPagesNavigation[index].x +"' data-state='normal' style='background-position:-"+ innerPagesNavigation[index].x +"px 0px;'></div>";
			$('#innarPageNavContainer').append(element);
		})
		alignContainers('#innarPageNavContainer', {top:false});	
		$('.subNavElement').bind('click', function(){
												
			if($(this).data('ref') && $(this).data('state') !== 'active'){
				currentScene = $(this).data('ref');
				//$.removeToolTip();
				$(this).nextAll().data('state', 'normal');
				$(this).prevAll().data('state', 'normal');
				$(this).data('state', 'active');
				$.updateNavigationState(currentScene);
				$.animateSectors($(this).data('index'));
				$(this).css({'background-position':(- $(this).data('hover') + 'px -50px ')});
			}										   
		})
		$('.subNavElement').click(function(){
			if($(this).data('url') != '#'){
				url =  location.href + $(this).data('url');
				window.location = url;
			}
			return false;
		})
		$('.subNavElement').bind('touchstart', function(){
												
			if($(this).data('ref') && $(this).data('state') !== 'active'){
				currentScene = $(this).data('ref');
				//$.removeToolTip();
				$(this).nextAll().data('state', 'normal');
				$(this).prevAll().data('state', 'normal');
				$(this).data('state', 'active');
				$('#mainSector').empty();
				$.updateNavigationState(currentScene);
				$.animateSectors($(this).data('ref'));
				$(this).css({'background-position':(- $(this).data('hover') + 'px -50px ')});
			}										   
		})
		// Add innerpage Hover effect
		$.innerPageNavigationHoverEffect();
	}
	/*
		Popup alignment caliculation.
	*/
	 function alignContainers(container, options){
		defaults = {
			top:false
		} 		
		var options = $.extend(defaults, options);	
		
		var winWidth  =  $(document).width();
		var winHeight = 690;
		var containerWidth =  $(container).width();
		var containerHeight = $(container).height();
		
		var leftPosition =  (winWidth - containerWidth) / 2;
		var t =  (winHeight - containerHeight) / 2;
		
		var topPosition = 'auto';
		if(options.top){ topPosition = t; }else{ topPosition = topPosition;}
		
		$(container).css({
			position:'absolute',
			left:leftPosition,
			top:topPosition
		})
	}
	/*
		Sub Navigation Tooltip Animation
	*/
	$.animateSubNavTooltip = function(){
		$('.tooltip').animate({opacity:1, top:-20}, {easing: 'swing', duration:500});
	}
	
	/*
		Inner page hover effect
	*/
	$.innerPageNavigationHoverEffect = function(){
		$('.subNavElement').hover(function(){ // Mouse Hover Effect	
			if($(this).data('state') == 'normal'){
				$.tooltip(this, {
					html :innerPagesNavigation[parseInt($(this).data('index'))].text,
					color:innerPagesNavigation[parseInt($(this).data('index'))].color,
					id:'navTooltipContainer'
				});
				$.animateSubNavTooltip();
				
				$(this).animate({'background-position-y':-50}, 400, 'swing');
				$(this).css({'background-position':(- $(this).attr('data-hover') + 'px -50px ')	})				
			}
		}, function(){ // Mouse leave effect
			$.removeToolTip('#navTooltipContainer');
			
			if($(this).data('state') !==  'active') {				
				
				$(this).animate({'background-position-y':0}, 400, 'swing' );
				
				$(this).css({
					'background-position':(- $(this).data('hover') + 'px 0px ')		
				})	
			}
		})
	}
	/*
		Create Tooltip
	*/
	$.tooltip =  function(obj, options){
		
		defaults = {
			title:'',
			html:'',
			color:'',
			className:'tooltip',
			id:'subNaviElementContainer'
		} 		
		var options = $.extend(defaults, options);	
		
		var tooltipContainer  = "<div id='"+ options.id +"' class='"+ options.className +"'></div>";
		$(obj).append(tooltipContainer);
		options.id = "#" + options.id;
		$(options.id).html(options.html);
		
		$(options.id).css({
			position:'absolute',
			left:-20,
			top:0,
			opacity:0,
			color:options.color,
			'min-width':100
		})
	}
	
	$.removeToolTip  = function(id){
		$(id).remove();
	}
	$.updateNavigationState = function(current) {
	
		var scence  = "#" + current + "_btn";	
		$('#innarPageNavContainer').children().each(function(index){
			var p = '-' +$(this).data('hover') + "px  0px";
			$(this).css({
				'background-position':p		
			})
		})
		//$('#innarPageNavContainer').children().animate({'background-position-y':0}, 0);
		$('#innarPageNavContainer').children().css({opacity:1});		
		$(scence).data('state', 'active');
		var x = '-' +$(scence).data('hover') + 'px  -50px';
		$(scence).css({'background-position':x});
	}

/** Home Page Animation Script End **/
		
          }
    }
})(jQuery);