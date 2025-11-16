/*****************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * <http://www.gnu.org/licenses/>
 * 
 * Copyright 2007 Matthew Weltman
 *
 *
 * options:
 * The third argument (much like many mootools plugins) are options, they are:
 *	active_tab_class - The className of the active tab.
 *	tab_margin_left - The margin to the left of the left-most tab
 *	tab_margin_right - The margin to the right of the right-most tab
 *	scroll_fx_duration - The duration of the scroll between tabs.  For no effect set to 0. Defaults to 500.
 *	-silding tabs can reposition itself to the center of a container or window (see below).
 *	to accomplish this you need to enable 3 options
 *	container_reposition - set this to true
 *	container - the container your tabs are in
 *	outer_container - the container you want the tabs to center inside of.  To center in the window, set to 'window'
 *	offset - The offset +/- where the container will be centered
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 *
 */
var sliding_tabs = new Class({
	initialize:function(tabs, bodies, options){
		this.options = {
			active_tab_class: 'active_tab',
			tab_margin_left: '10px',
			tab_margin_right: '10px',
			scroll_fx_duration:500,
			event:'click',

			//used for container repositioning
			container_reposition: false,
			container:null,
			offset:null,
			outer_container:null
		}
		$extend(this.options,options);
		this.bodies = bodies;
		this.tabs = tabs;
		this.tabs.setStyles({
			'position':'relative',
			'float':'left'
		});
	
		this.tab_overflow = new Element('div').setProperty('id','tab_overflow');
		this.tab_overflow.injectBefore(this.tabs[0]);
	
		this.tab_container = new Element('div').setProperty('id','tab_container');
		this.tab_container.injectInside(this.tab_overflow);
		
		this.tab_body_container = new Element('div').setProperty('id','tab_body_container');
		this.tab_body_container.injectBefore(this.bodies[0]);
		
		this.bodies.each(function(el,i){
			el.injectInside(this.tab_body_container);
		}.bind(this));
		
		if(this.options.container_reposition){
			if(this.options.outer_container.toLowerCase() == 'window')
				this.outer_container_height = window.getHeight();
			else
				this.outer_container_height = $(this.options.outer_container).getStyle('height').toInt();
				
			this.container_fx = new Fx.Style($(this.options.container),'top',{duration:500,wait:false});
		}
		
		this.body_fx = new Fx.Scroll(this.tab_body_container,{wait:false,duration:this.options.scroll_fx_duration});
		
		this.tab_items = [];
		this.tabs_width = 0;
		var max_height = 0;
		
		this.tabs.each(function(el,i){
			this.tabs_width += el.getStyle('width').toInt()
				+ el.getStyle('border-right-width').toInt()
				+ el.getStyle('border-left-width').toInt()
				+ el.getStyle('margin-left').toInt()
				+ el.getStyle('margin-right').toInt()
				+ el.getStyle('padding-left').toInt()
				+ el.getStyle('padding-right').toInt()
			el.injectInside(this.tab_container);
			el.setStyle('left',this.options.tab_margin_left);
			this.tab_items[i] = new tab_item(el,this.bodies[i],this);
		}.bind(this));
		
		this.tab_container.setStyle('width',(this.tabs_width+this.options.tab_margin_left.toInt()+this.options.tab_margin_right.toInt())+'px');
		
		this.tab_fx = new Fx.Scroll(this.tab_overflow,{
			duration:300,
			wait:false,
			onComplete:function(){
				this.tab_overflow.addEvent('mousemove',this.mouse_move.bind(this));
			}.bind(this)
		});
		
		this.tab_overflow.addEvent('mouseenter',function(e){
			e = new Event(e).stop();
			var position = e.client.x-this.tab_overflow.getLeft();
			position = position*(this.tab_container.getStyle('width').toInt())/this.tab_overflow.getStyle('width').toInt() - position;
			this.tab_fx.scrollTo(position);
		}.bind(this));
		
		this.tab_overflow.addEvent('mouseleave',function(){
			this.tab_overflow.removeEvents('mousemove');
		}.bind(this));
		
		this.active_item = this.tab_items[0];
		this.tabs[0].addClass(this.options.active_tab_class)
		this.tab_body_container.setStyle('height',this.tab_items[0].body_height);
	},
	mouse_move:function(e){
		e = new Event(e).stop();
		this.tab_fx.stop();
		var position = e.client.x-this.tab_overflow.getLeft()+window.getScrollLeft();
		position = position*(this.tab_container.getStyle('width').toInt())/this.tab_overflow.getStyle('width').toInt() - position;
		this.tab_overflow.scrollLeft = position;
	}
});

var tab_item = new Class({
	initialize:function(item,body,tab_obj){
		this.item = item;
		this.body = body;
		this.tab_obj = tab_obj;
		this.body_height = (
			this.body.getStyle('height').toInt()
			+ this.body.getStyle('border-bottom-width').toInt()
			+ this.body.getStyle('border-top-width').toInt()
			+ this.body.getStyle('margin-bottom').toInt()
			+ this.body.getStyle('margin-top').toInt()
			+ this.body.getStyle('padding-bottom').toInt()
			+ this.body.getStyle('padding-top').toInt()
			)+'px';
		
		this.item_fx = new Fx.Style(this.item,'opacity',{duration:300,wait:false});
		
		this.item.addEvent(this.tab_obj.options.event,this.on_event.bind(this));
		
		this.container_top = (
			this.tab_obj.outer_container_height-
			this.body_height.toInt()+
			this.tab_obj.options.offset
			)/2;
	},
	on_event:function(e){
		e = new Event(e).stop();
		$$('.'+this.tab_obj.options.active_tab_class).removeClass(this.tab_obj.options.active_tab_class)
		this.item.addClass(this.tab_obj.options.active_tab_class);
		
		if(this.tab_obj.options.container_reposition){
			this.tab_obj.container_fx.start(this.container_top+'px');
		}
		
		this.tab_obj.tab_body_container.effect('height',{
			duration:500,
			wait:false,
			onComplete:function(){
				this.tab_obj.body_fx.toElement(this.body);
				this.tab_obj.active_item = this;
			}.bind(this)
		}).start(this.body_height);
	}
});