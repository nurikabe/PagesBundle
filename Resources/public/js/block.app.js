var blockApp = (function($) {
    return {
        init: function() {
            blockApp.editable();
        },

        editable: function() {
          $('[data-role]="editable"').each(function(index, value) {
              var el = $(value);

              el.editable(el.attr('data-url'), {
                  type: el.attr('data-type'),
                  submitdata: { block_id: el.attr('data-id') },
                  onblur: 'submit'
              });
          });
        }
    };
}(jQuery));

$(function() { blockApp.init(); });