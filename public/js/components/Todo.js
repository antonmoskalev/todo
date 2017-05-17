define(['jquery', 'underscore', 'toastr', 'components/todo/Item'], function($, _, toastr, Item) {
	var Todo = function(options, data) {
		this.options = $.extend({
			place: '#todo',
			template: $('#todo-tpl').html()
		}, options || {});
		this.data = $.extend(true, {
			todo: {
				id: null,
				name: 'Без названия'
			},
			items: [],
			filter: 'all'
		}, data || {});
		this.saved = !this.isNew();
		this.$place = $(this.options.place);
		this.$el;
		this.$name;
		this.$items;
		this.$itemAdd;
		this.$itemsCount;
		this.$filters;
		this.$clearCompleted;
		
		this.init();
	};
	
	Todo.prototype.init = function() {
		this.fetch(function() {
			//Обработка события добавления в массив элемента списка
			this.data.items._push = this.data.items.push;
			this.data.items.push = function() {
				this.data.items._push.apply(this.data.items, arguments);
				this.$itemsCount.text(this.itemsCount());
			}.bind(this);

			//Обработка события удаления из массива элемента списка
			this.data.items._splice = this.data.items.splice;
			this.data.items.splice = function() {
				this.data.items._splice.apply(this.data.items, arguments);
				this.$itemsCount.text(this.itemsCount());
			}.bind(this);
			
			this.render();
		}.bind(this));
	};
	
	/**
	 * Сгенерировать вьюху
	 */
	Todo.prototype.generateView = function() {
		this.initItems();

		var template = _.template(this.options.template);
		var view = template(this);
		
		this.$el = $(view);
		this.$name = this.$el.find('[todo-name]');
		this.$items = this.$el.find('[todo-items]');
		this.$itemAdd = this.$el.find('[todo-item-add]');
		this.$itemsCount = this.$el.find('[todo-items-count]');
		this.$filters = this.$el.find('[todo-filter]');
		this.$clearCompleted = this.$el.find('[todo-clear-completed]');
		
		this.initHandlers();
	};
	
	/**
	 * Отрисовать
	 */
	Todo.prototype.draw = function() {
		this.$place.replaceWith(this.$el);
		this.$place = this.$el;
		this.drawItems();
	};
	
	/**
	 * Рендеринг объекта - сгенерировать вьюху по текщим данным и отрисовать
	 */
	Todo.prototype.render = function() {
		this.generateView();
		this.draw();
	};
	
	/**
	 * Вешаем обработчики на события
	 */
	Todo.prototype.initHandlers = function() {
		// Изменение названия списка
		this.$name.on('input', function() {
			this.data.todo.name = this.$name.val();
			this.saved = false;
			
			setTimeout(function() {
				this.save();
			}.bind(this), 1000);
		}.bind(this));
		
		// Добавление элемента списка
		this.$itemAdd.on('keyup', function(e) {
			if (e.keyCode === 13) {
				var value = $.trim(this.$itemAdd.val());
				
				if (value !== '') {
					this.save(function() {
						var item = new Item({
							place: this.$items[0]
						}, {
							item: {
								description: value
							},
							todo: this
						});

						item.save(function() {
							this.render();
							this.data.todo.data.items.push(item);
							this.data.todo.$itemAdd.val('');
						});
					});
				}
			}
		}.bind(this));
		
		// События фильтра
		this.$filters.each(function(index, filter) {
			var $filter = $(filter);
			
			$filter.on('click', function(e) {
				e.preventDefault();

				this.data.filter = $filter.attr('todo-filter');
				this.render();
				history.pushState(null, null, this.getUrl());
			}.bind(this));
		}.bind(this));
		
		// Удаление завершенных
		this.$clearCompleted.on('click', function() {
			$.each(this.data.items, function(index, item) {
				if (item.data.item.completed) {
					item.delete();
				}
			});
		}.bind(this));
	};
	
	Todo.prototype.initItems = function() {
		$.each(this.data.items, function(index, item) {
			if (item instanceof Item) {
				item.drawed = false;
			} else {
				var newItem = new Item({}, {
					item: item,
					todo: this
				});

				this.data.items[index] = newItem;
			}
		}.bind(this));
	};
	
	Todo.prototype.drawItems = function() {
		$.each(this.data.items, function(index, item) {
			item.render();
		});
	};
	
	Todo.prototype.isNew = function() {
		return this.data.todo.id === null;
	};
	
	/**
	 * Сохранить список на сервак
	 */
	Todo.prototype.save = function(callback) {
		callback = callback || function() {};
		
		if (this.saved === false) {
			this.saved = true;
			
			$.ajax({
				type: this.isNew() ? 'post' : 'put',
				url: this.isNew() ? '/todos' : '/todos/'+this.data.todo.id,
				data: JSON.stringify(this.data.todo),
				contentType : 'application/json',
				success: function(response) {
					var changeUrl = false;
					
					if (this.isNew()) {
						changeUrl = true;
					}
					
					this.data.todo = response.todo;
					
					if (changeUrl) {
						history.pushState(null, null, this.getUrl());
					}
					
					toastr.success('Список сохранен');
					
					callback.call(this);
				}.bind(this),
				error: function() {
					toastr.error('Произошла ошибка при сохранении');
				}
			});
		} else {
			callback.call(this);
		}
	};
	
	/**
	 * Затянуть данные с сервака
	 */
	Todo.prototype.fetch = function(callback) {
		callback = callback || function() {};
		
		if (!this.isNew()) {
			$.ajax({
				type: 'get',
				url: '/todos/'+this.data.todo.id,
				success: function(response) {
					this.data.todo = response.todo;
					this.data.items = response.items;

					callback.call(this);
				}.bind(this),
				error: function() {
					toastr.error('Произошла ошибка при запросе данных');
				}
			});
		} else {
			callback.call(this);
		}
	};
	
	Todo.prototype.getUrl = function() {
		var url;
		
		if (this.isNew()) {
			url = '/todos/create';
		} else {
			url = '/todos/update/'+this.data.todo.id;
		}
		
		switch (this.data.filter) {
			case 'active':
				url += '/#/active';
				break;
			case 'completed':
				url += '/#/completed';
				break;
		}
		
		
		return url;
	};
	
	Todo.prototype.itemsCount = function() {
		var result = 0;
		
		$.each(this.data.items, function(index, item) {
			if (item.visible()) {
				result++;
			}
		});
		
		return result;
	};
	
	return Todo;
});