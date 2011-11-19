var blockApp = (function($) {
    return {
        init: function() {
            blockApp.editable();
        },

        editable: function() {
          var url = $('[data-lansole-pages-block-update]').attr('data-lansole-pages-block-update');

          $('[data-role]="editable"').each(function(index, value) {
              var el = $(value);

              el.editable(url, {
                  type: el.attr('data-type'),
                  submitdata: { block_id: el.attr('data-id') },
                  onblur: 'submit'
              });
          });
        }
    };
}(jQuery));

$(function() { blockApp.init(); });