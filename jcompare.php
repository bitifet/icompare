<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
<head><!--{{{-->
<!-- vim:foldmethod=marker
-->
  <title>jCompare</title>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
  <style type="text/css" media="screen">
    body>* {
      margin:auto;
    }
  </style>
</head><!--}}}-->
<body><!--{{{-->
  <table class="compare"><!--{{{-->
    <tr>
      <td></td>
      <th id="manolo">Item 1</th>
      <th id="">Item 2</th>
      <th>Item 3</th>
      <th>Item 4</th>
      <th id="Pepito">Item 5</th>
      <th>Item 6</th>
      <th>Item 7</th>
      <th>Item 8</th>
    </tr>
    <tr>
      <th>Color</th>
      <td>Red</td>
      <td>Green</td>
      <td>Blue</td>
      <td>Green</td>
      <td>Yellow</td>
      <td>Yellow</td>
      <td>Brown</td>
      <td>Yellow</td>
    </tr>
    <tr>
      <th>Height</th>
      <td>1m</td>
      <td>2m</td>
      <td>1m</td>
      <td>2m</td>
      <td>1m</td>
      <td>3m</td>
      <td>2m</td>
      <td>1m</td>
    </tr>
    <tr>
      <th>Width</th>
      <td>3m</td>
      <td>3m</td>
      <td>2m</td>
      <td>1m</td>
      <td>7m</td>
      <td>9m</td>
      <td>7m</td>
      <td>9m</td>
    </tr>
    <tr>
      <th>Wheigt</th>
      <td>8kg</td>
      <td>8kg</td>
      <td>8kg</td>
      <td>8kg</td>
      <td>8Kg</td>
      <td>5Kg</td>
      <td>8Kg</td>
      <td>8Kg</td>
    </tr>
    <tr>
      <th>Age</th>
      <td>20</td>
      <td>15</td>
      <td>32</td>
      <td>32</td>
      <td>20</td>
      <td>11</td>
      <td>32</td>
      <td>15</td>
    </tr>
    <tr>
      <th>Organization</th>
      <td>Samsung</td>
      <td>Canonical</td>
      <td>Debian</td>
      <td>Debian</td>
      <td>Bitifet</td>
      <td>Bitifet</td>
      <td>Pirate Partey</td>
      <td>Debian</td>
    </tr>
    <tr>
      <th>Price</th>
      <td>77</td>
      <td>45</td>
      <td>15</td>
      <td>15</td>
      <td>45</td>
      <td>77</td>
      <td>15</td>
      <td>77</td>
    </tr>
    <tr>
      <th>Currency</th>
      <td>$</td>
      <td>$</td>
      <td>$</td>
      <td>€</td>
      <td>€</td>
      <td>€</td>
      <td>€</td>
      <td>pts</td>
    </tr>
    <tr>
      <th>Stock</th>
      <td>Yes</td>
      <td>Yes</td>
      <td>Yes</td>
      <td>No</td>
      <td>Yes</td>
      <td>Yes</td>
      <td>Yes</td>
      <td>Yes</td>
    </tr>
  </table><!--}}}-->
</body><!--}}}-->
<script type="text/javascript" charset="utf-8"><!--{{{-->

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
		var ctrlAddPropertys=$("<select><option>+Prop</option></select>")
			.appendTo(Settings.ControlPanel);
		var ctrlAddItems=$("<select><option>+Item</option></select>")
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
							"ctrl_discard" : $("<a href=\"#\">[x]</a>")
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
					"ctrl_discard" : $("<a href=\"#\">[x]</a>")
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
			if ( ! Settings ) { // Setup./*{{{*/
				$this = $(this),

				// Default options:/*{{{*/
				Settings=$.extend({
					"bgcolor" : "#00aaaa",
					"tr-bgcolor" : null,
					"th-bgcolor" : "#99dddd",
					"td-bgcolor" : "#aaaaaa",

					"ControlPanel" : $this.find("tr td").first(),
				}, options);/*}}}*/

				// Style initialization:/*{{{*/
				$this.css("background", Settings["bgcolor"]);
				$this.find("tr").css("background", Settings["tr-bgcolor"]);
				$this.find("th").css("background", Settings["th-bgcolor"]);
				$this.find("td").css("background", Settings["td-bgcolor"]);
				/*}}}*/
				self.tableSetup();
			};/*}}}*/
		});
	};/*}}}*/

	self.destroy=function( ) {/*{{{*/
		///return this.each(function(){
		///})
	};/*}}}*/

	$.fn.contrast = function( method ) {/*{{{*/
		if ( self[method] ) {
			return self[method].apply( this, Array.prototype.slice.call( arguments, 1 ));
		} else if ( typeof method === 'object' || ! method ) {
			return self.init.apply( this, arguments );
		} else {
			$.error( 'Method ' +  method + ' does not exist on jQuery.contrast' );
		}    
	}/*}}}*/

})( jQuery );



$(function(){
	var x=$(".compare").contrast({
	///  "th-bgcolor" : "magenta"
	});

///	x.contrast("itemToggle", "Pepito");
///	x.contrast("itemToggle", "pepito"); // Error.
});




  
</script><!--}}}-->
</html>
