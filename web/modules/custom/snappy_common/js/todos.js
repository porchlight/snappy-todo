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
            $('.view-id-todo_s .views-row').removeClass('visually-hidden');
          });

          // On click of "active" only show todos that haven't been done.
          $('.view-id-todo_s a[href*="#active"]').on('click', function () {
            $('.view-id-todo_s .views-row .action-unflag').parents('.views-row').addClass('visually-hidden');
            $('.view-id-todo_s .views-row .action-flag').parents('.views-row').removeClass('visually-hidden');
          });

          // On click of "completed" only show todos that have been done.
          $('.view-id-todo_s a[href*="#completed"]').on('click', function () {
            $('.view-id-todo_s .views-row .action-unflag').parents('.views-row').removeClass('visually-hidden');
            $('.view-id-todo_s .views-row .action-flag').parents('.views-row').addClass('visually-hidden');
          });
        });
      });
    }
  }

  function checkIfEmpty() {
    if ($('.view-id-todo_s .views-row').length) {
      var done = $('.view-id-todo_s .views-row .action-unflag').length;
      if (done > 0) {
        $('.view-id-todo_s .clear-completed').removeClass('visually-hidden');
      }
      else {
        $('.view-id-todo_s .clear-completed').addClass('visually-hidden');
      }
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
