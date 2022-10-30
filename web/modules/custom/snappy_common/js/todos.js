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

          // Switch which "view" tab is selected.
          $('.view-id-todo_s .filters a').on('click', function() {
            $('.view-id-todo_s .filters a').removeClass('selected');
            $(this).addClass('selected');
          });

          // On click of "all" show everything.
          $('.view-id-todo_s a[href*="#all"]').on('click', function () {
            $('.view-id-todo_s tr').removeClass('visually-hidden');
          });

          // On click of "active" only show todos that haven't been done.
          $('.view-id-todo_s a[href*="#active"]').on('click', function () {
            $('.view-id-todo_s tr .action-unflag').parents('tr').addClass('visually-hidden');
            $('.view-id-todo_s tr .action-flag').parents('tr').removeClass('visually-hidden');
          });

          // On click of "completed" only show todos that have been done.
          $('.view-id-todo_s a[href*="#completed"]').on('click', function () {
            $('.view-id-todo_s tr .action-unflag').parents('tr').removeClass('visually-hidden');
            $('.view-id-todo_s tr .action-flag').parents('tr').addClass('visually-hidden');
          });
        });
      });
    }
  }

  /**
   * Check if there are any todo's left to do. If there are then show how
   * many items left in the .todo-count container. If there are completed
   * todos then show the "Clear completed" link.
   */
  function checkIfEmpty() {
    if ($('.view-id-todo_s tr').length) {
      var done = $('.view-id-todo_s tr .action-unflag').length;
      if (done > 0) {
        $('.view-id-todo_s .clear-completed').removeClass('visually-hidden');
        $('.view-id-todo_s tr .action-unflag').parents('tr').children('.views-field-title').addClass('complete');
      }
      else {
        $('.view-id-todo_s .clear-completed').addClass('visually-hidden');
        $('.view-id-todo_s tr .views-field-title').removeClass('complete');
      }
      $('.view-id-todo_s .todo-count').removeClass('visually-hidden');
      updateTodoCount();
    }
    else {
      $('.view-id-todo_s .clear-completed').addClass('visually-hidden');
      $('.view-id-todo_s .todo-count').addClass('visually-hidden');
    }
  }

  /**
   * Update the todo count text depending on how many items are left.
   */
  function updateTodoCount() {
    // Count how many left.
    var left = $('.view-id-todo_s tr .action-flag').length;
    if (left > 0) {
      var todosLeft = Drupal.formatPlural(left, '1 item left', '@count items left');
      $('.view-id-todo_s .todo-count').text(todosLeft);
    }
    else {
      $('.view-id-todo_s .todo-count').text('0 items left');
    }
  }

}(jQuery, Drupal, once));
