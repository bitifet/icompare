/*
 * iCompare.js
 *
 * This program is free software: you can redistribute it and/or modify//{{{
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.//}}}
 *
 * @author: Joan Miquel Torres <joanmi@bitifet.net>
 *
 */

(function( $ ){

	var $this; // Table element itself (while not overridden).
	var self = {}; // Plugin method's container.
	var Settings; // Plugin settings.

	var Items=new Array(); // Items to compare.
	var ItemIds={}; // Translate Item ids to its position in Items().
	var activeItemsCount;
	var Propertys=new Array(); // Property data.

	var Summary; // Summary container.

	var cmp={ // Comparsion functions:/*{{{*/
		"equals" : function(a,b){ // Case insensitive equality
			return a==b;
		},
		"iequals" : function(a,b){ // Case insensitive equality
			return a.toLowerCase()==b.toLowerCase();
		},
	};/*}}}*/

// -----------------------------------

	self.tableSetup=function(){/*{{{*/
		var t = $this;
		var rows=$this.find("tr");
		var sl;
		var ctrlAddPropertys=$(Settings.controls["AddPropertys"])
			.appendTo(Settings.ControlPanel);
		var ctrlAddItems=$(Settings.controls["AddItems"])
			.appendTo(Settings.ControlPanel);

		rows.each(function(i){
			if(! i) { // Header (first row)/*{{{*/
				activeItemsCount=(
					// Load Items:/*{{{*/
					$(this).find("th").each(function(j){
						var $this=$(this);
						var k=j+2; // Ordinal position excluding left heading.
						var iid=$this.attr("id");
						var lbl=$this.text();
						if(iid){ItemIds[iid]=j;};
						Items[j]={
							"label" : lbl,
							"active" : true,
							"candidate" : true,
							"props" : {},
							"self" : t.find("tr").find("td:nth-child("+k+"),th:nth-child("+k+")"),
							"ctrl_discard" : $(Settings.controls["DiscardItem"])
								.appendTo($this)
								.click(function(e){
									self.itemToggle(j);
									e.preventDefault();
								}),
							"ctrl_enable" : $("<option>"+lbl+"</option>")
								.appendTo(ctrlAddItems)
								.click(function(e){
									self.itemToggle(j);
									ctrlAddItems.val(0);
									e.preventDefault();
								}).hide(),
						};
					})/*}}}*/
				).length;
				Summary=$(/*{{{*/
					"<td rowspan=\""+rows.length+"\"><p><em>Summary:</em></p><ul></ul></td>"
				).appendTo(rows.first());
				sl=Summary.find("ul").first();/*}}}*/
				/*}}}*/
			} else { // Rest of the table/*{{{*/
				var row=$(this);
				var cell=row.find("th").first();
				var prop=cell.text(); // Read property name.
				// Store property values for each item:/*{{{*/
				row.find("td").each(function(j){
					Items[j].props[prop]=$(this).text();
				});/*}}}*/
				// Initialyze property status:/*{{{*/
				Propertys[prop]={
					"active" : true,
					"value" : undefined, // Stores value when there is only single distinct one.
					"fn_compare" : cmp.iequals,
					"display" : $("<li></li>").appendTo(sl).hide(),
					///"self" : row.find("td,th") // (Only for color-debugging...)
					"self" : row,
					"ctrl_discard" : $(Settings.controls["DiscardProperty"])
						.appendTo(cell)
						.click(function(e){
							self.propToggle(prop);
							e.preventDefault();
						}),
					"ctrl_enable" : $("<option>"+prop+"</option>")
						.appendTo(ctrlAddPropertys)
						.click(function(e){
							self.propToggle(prop);
							ctrlAddPropertys.val(0);
							e.preventDefault();
						}).hide(),
				};/*}}}*/
			};/*}}}*/
		});
		return Items;
	};/*}}}*/

	self.itemToggle=function(id){/*{{{*/
		var i=(typeof(id)==="number")?id:ItemIds[id]; // Let HTML ids.
		if(typeof(i)==="undefined"){$.error("itemToggle(): Item doesn't exists ("+id+")");};
		var a=Items[i].active=!Items[i].active;
		Items[i].ctrl_enable.toggle();
		// Hide discard button when only one Item left:/*{{{*/
		if(1==(activeItemsCount+=a?1:-1)){
			for (j in Items) {
				if (Items[j].active) {
					Items[j].ctrl_discard.fadeOut();
					break;
				};
			};
		}else{
			$.each(Items, function(){
				this.ctrl_discard.fadeIn();
			});
		};/*}}}*/
		self.updatePropertys();
		Items[i].self.fadeToggle();
	};/*}}}*/

	self.propToggle=function(prop){/*{{{*/
		Propertys[prop].active=!Propertys[prop].active;
		self.updatePropertys();
	}/*}}}*/

	self.updatePropertys=function(){/*{{{*/
		for (
			prop in Propertys
		) {
			var values=new Array();
			var value=undefined;
			var unique=true;
			for ( // Check for uniqueness:/*{{{*/
				var i=0;i<Items.length;i++
			) if (
				Items[i].active
			){
				var v=Items[i].props[prop];
				if (typeof(value)=="undefined") {
					value=v;
				} else if (!Propertys[prop].fn_compare(value,v)) {
					unique=false;
					break;
				};
			};/*}}}*/

			if (
				Propertys[prop].active
			){
				if (unique){
	///				Propertys[prop].value=value;
					// Hide in table:
					Propertys[prop].self.fadeOut();
					// Update and show in summary:
					Propertys[prop].display.html("<b>"+prop+":</b>&nbsp;"+value);
					Propertys[prop].display.fadeIn();
				} else {
	///				Propertys[prop].value=undefined;
					Propertys[prop].self.fadeIn(); // Show in table
					Propertys[prop].display.fadeOut(); // Hide in summary:
				};
				Propertys[prop].ctrl_enable.fadeOut(); // Hide enabling control.
			}else{ // Inactive:
	///			Propertys[prop].value=undefined;
				Propertys[prop].self.fadeOut(); // Hide data in table.
				Propertys[prop].display.fadeOut(); // Hide display in summary.
				if (unique) {
					Propertys[prop].ctrl_enable.fadeOut(); // Hide enabling control.
				}else{
					Propertys[prop].ctrl_enable.fadeIn(); // Show enabling control.
				};
			};
		};
	};/*}}}*/

// -----------------------------------

	self.init=function( options ) {/*{{{*/
		return this.each(function(){
			// Setup./*{{{*/
			$this = $(this),

			// Default options:/*{{{*/
			Settings=$.extend({
				"ControlPanel" : $this.find("tr td").first(),
				"controls" : {
					"AddPropertys" : "<select><option>+Prop</option></select>",
					"AddItems" : "<select><option>+Item</option></select>",
					"DiscardItem" : "<a href=\"#\">[x]</a>",
					"DiscardProperty" : "<a href=\"#\">[x]</a>",
				}

			}, options);/*}}}*/

			self.tableSetup();
			/*}}}*/
		});
	};/*}}}*/

	$.fn.iCompare = function( method ) {/*{{{*/
		if ( self[method] ) {
			return self[method].apply( this, Array.prototype.slice.call( arguments, 1 ));
		} else if ( typeof method === 'object' || ! method ) {
			return self.init.apply( this, arguments );
		} else {
			$.error( 'Method ' +  method + ' does not exist on jQuery.iCompare' );
		}    
	}/*}}}*/

})( jQuery );

// vim:foldmethod=marker
