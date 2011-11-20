var blockApp = (function($) {
    var wysiwyg = {
        initialContent: '',
        rmUnusedControls: true,
        controls: {
            bold: { visible : true },
            italic: { visible : true },
            underline: { visible : true },
            strikeThrough: { visible: true },

            justifyCenter: { visible: true },
            justifyFull: { visible: true },
            justifyRight: { visible: true },
            justifyLeft: { visible: true },

            insertOrderedList: { visible: true },
            insertUnorderedList: { visible: true },

            createLink: { visible: true },

            h1: { visible: true },
            h2: { visible: true },
            h3: { visible: true },

            html: { visible : true },
        }
    };

    return {
        init: function() {
            blockApp.editable();
        },

        editable: function() {
          var url = $('[data-lansole-pages-block-update]').attr('data-lansole-pages-block-update');

          $('[data-role]="editable"').each(function(index, value) {
              var el = $(value),
                  settings = blockApp._getEditableSettings(el);

              el.editable(url, settings);
          });
        },

        _getEditableSettings: function(el) {
            var settings = {
                type: el.attr('data-type'),
                submitdata: { block_id: el.attr('data-id') },
                onblur: 'submit'
            };

            if (el.attr('data-type') === 'richtext') {
                settings.submit = '<button class="btn primary" type="submit">Save</button>';
                settings.cancel = '<button class="btn" type="cancel">Cancel</button>';
                settings.wysiwyg = wysiwyg;
            };

            return settings;
        }
    };
}(jQuery));

$(function() { blockApp.init(); });