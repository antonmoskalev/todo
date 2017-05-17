define(['jquery', 'underscore', 'toastr'], function($, _, toastr) {
	var Item = function(options, data) {
		this.options = $.extend({
			place: '#todo-items',
			template: $('#todo-item-tpl').html()
		}, options || {});
		this.data = $.extend(true, {
			todo: {},
			item: {
				id: null,
				description: '',
				completed: false
			}
		}, data || {});
		this.$place;
		this.$el;
		this.$completed;
		this.$delete;
		this.drawed = false;
		
		this.init();
	};
	
	Item.prototype.init = function() {
		this.$place = $(this.options.place);
	};
	
	/**
	 * Сгенерировать вьюху
	 */
	Item.prototype.generateView = function() {
		var template = _.template(this.options.template);
		var view = template(this);
		
		this.$el = $(view);
		this.$completed = this.$el.find('[todo-item-completed]');
		this.$delete = this.$el.find('[todo-item-delete]');
		
		this.initHandlers();
	};
	
	/**
	 * Отрисовать
	 */
	Item.prototype.draw = function() {
		if (this.drawed === false) {
			this.data.todo.$items.append(this.$el);
		} else {
			this.$place.replaceWith(this.$el);
		}
		
		this.$place = this.$el;
		this.drawed = true;
	};
	
	/**
	 * Рендеринг объекта - сгенерировать вьюху по текщим данным и отрисовать
	 */
	Item.prototype.render = function() {
		this.generateView();
		this.draw();
	};
	
	/**
	 * Вешаем обработчики на события
	 */
	Item.prototype.initHandlers = function() {
		this.$completed.on('change', function() {
			this.data.item.completed = this.$completed.is(':checked');
			this.render();
			this.save();
		}.bind(this));
		
		this.$delete.on('click', function() {
			this.delete();
		}.bind(this));
	};
	
	Item.prototype.isNew = function() {
		return this.data.item.id === null;
	};
	
	/**
	 * Сохранить на сервак
	 */
	Item.prototype.save = function(callback) {
		callback = callback || function() {};
		var data = $.extend(this.data.item, {todo_id: this.data.todo.data.todo.id});
		
		$.ajax({
			type: this.isNew() ? 'post' : 'put',
			url: this.isNew() ? '/todo-items' : '/todo-items/'+this.data.item.id,
			data: JSON.stringify(data),
			contentType : 'application/json',
			success: function(response) {
				this.data.item = response.item;

				toastr.success('Элемент списка сохранен');
				
				callback.call(this);
			}.bind(this),
			error: function() {
				toastr.error('Произошла ошибка при сохранении');
			}
		});
	};
	
	/**
	 * Удаление
	 */
	Item.prototype.delete = function(callback) {
		callback = callback || function() {};
		$.ajax({
			type: 'delete',
			url: '/todo-items/'+this.data.item.id,
			contentType : 'application/json',
			success: function() {
				var index = _.indexOf(this.data.todo.data.items, this);
				
				if (index !== -1) {
					this.data.todo.data.items.splice(index, 1);
					this.$el.remove();
				}

				toastr.success('Элемент удален из списка');
				
				callback.call(this);
			}.bind(this),
			error: function() {
				toastr.error('Произошла ошибка при сохранении');
			}
		});
	};
	
	Item.prototype.visible = function() {
		switch (this.data.todo.data.filter) {
			case 'active':
				return !this.data.item.completed;
			case 'completed':
				return this.data.item.completed;
			default:
				return true;
		}
	};
	
	return Item;
});