var Order = {
	items: {},
	itemTmpl: "",
	
	init: function() {
		this.itemTmpl = _.template($('#item-tmpl').html());
		$('#total-group').before(this.itemTmpl({'items': this.items}));
		this.enableRemoveIcons();
	},
	
	setItems: function(items) {
		this.items = _.indexBy(items, 'id');
	},
	
	itemForFieldset: function(fieldset) {
		return this.items[fieldset.find('.item-select').val()];
	},
	
	quantityForFieldset: function(fieldset) {
		return fieldset.find('.quantity-field').val();
	},
	
	changeItem: function(select) {
		select = $(select);
		var item = this.items[select.val()];
		var parent = select.parents('fieldset');
		var price = item.price;
		var quantity = this.quantityForFieldset(parent);
		parent.find('.unit-price').text('$' + price);
		parent.find('.total-price').text('$' + price * quantity);
		
		this.updateTotal();
	},
	
	changeQuantity: function(input) {
		input = $(input);
		var parent = input.parents('fieldset');
		var item = this.itemForFieldset(parent);
		var price = item.price;
		var quantity = this.quantityForFieldset(parent);
		parent.find('.total-price').text('$' + price * quantity);
		
		this.updateTotal();
	},
	
	addItem: function(link) {
		link = $(link);
		var parent = link.parents('fieldset');
		this.insertItemAfter(parent);
		
		this.enableRemoveIcons();
	},
	
	removeItem: function(link) {
		link = $(link);
		if (link.attr('disabled')) {
			return;
		}
		
		var parent = link.parents('fieldset');
		parent.remove();
		
		this.updateTotal();
		this.enableRemoveIcons();
	},
	
	enableRemoveIcons: function() {
		var fieldsets = $('fieldset');
		if (fieldsets.length > 1) {
			// enable
			fieldsets.find('.remove[disabled]').removeAttr('disabled').removeClass('text-muted');
		}
		else {
			fieldsets.find('.remove').attr('disabled', 'disabled').addClass('text-muted');
			
		}
	},
	
	insertItemAfter: function(elm) {
		elm.after(this.itemTmpl({'items': this.items}));
	},
	
	updateTotal: function() {
		var total = 0;
		var self = this;
		
		$('fieldset').each(function (i, fieldset) {
			fieldset = $(fieldset);
			var item = self.itemForFieldset(fieldset);
			var quantity = self.quantityForFieldset(fieldset);
			
			if (item) {
				total += (item.price * quantity);
			}
		});
		
		$('#total').text('$' + total);
	}
};