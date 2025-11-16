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
/* Tips 1 */
var Tips1 = new Tips($$('.Tips1'));
 
/* Tips 2 */
var Tips2 = new Tips($$('.Tips2'), {
	initialize:function(){
		this.fx = new Fx.Style(this.toolTip, 'opacity', {duration: 500, wait: false}).set(0);
	},
	onShow: function(toolTip) {
		this.fx.start(1);
	},
	onHide: function(toolTip) {
		this.fx.start(0);
	}
});
 
/* Tips 3 */
var Tips3 = new Tips($$('.Tips3'), {
	showDelay: 400,
	hideDelay: 400,
	fixed: true
});
 
/* Tips 4 */
var Tips4 = new Tips($$('.Tips4'), {
	className: 'custom'
});