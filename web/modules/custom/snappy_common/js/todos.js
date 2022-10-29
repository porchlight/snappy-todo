/**
 * @file
 * Snappy Common todos behavior.
 */

(function ($, Drupal, once) {
  'use strict';

  Drupal.behaviors.snappyCommonTodos = {
    attach: function (context, settings) {
      once('snappyCommonTodosBehaviour', 'html', context).forEach(function () {
        $(window).on('load ajaxComplete', function () {
          checkIfEmpty();
        })
      });
    }
  }

  function checkIfEmpty() {
    if ($('.view-id-todo_s .views-row').length) {
      $('.view-id-todo_s .clear-completed').removeClass('visually-hidden');
      $('.view-id-todo_s .todo-count').removeClass('visually-hidden');
      updateTodoCount();
    }
    else {
      $('.view-id-todo_s .clear-completed').addClass('visually-hidden');
      $('.view-id-todo_s .todo-count').addClass('visually-hidden');
    }
  }

  function updateTodoCount() {
    // Count how many left.
    var left = $('.view-id-todo_s .views-row .action-flag').length;
    if (left > 0) {
      var todosLeft = Drupal.formatPlural(left, '1 item left', '@count items left');
      $('.view-id-todo_s .todo-count').text(todosLeft);
    }
    else {
      $('.view-id-todo_s .todo-count').text('0 items left');
    }
  }

}(jQuery, Drupal, once));
