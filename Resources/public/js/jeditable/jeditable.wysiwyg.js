$.editable.addInputType('richtext', {
    element: function(settings, original) {
        var textarea = $('<textarea>').css("original", 0);

        if (settings.rows) {
            textarea.attr('rows', settings.rows);
        } else {
            textarea.height(settings.height);
        }

        if (settings.cols) {
            textarea.attr('cols', settings.cols);
        } else {
            textarea.width(settings.width);
        }

        $(this).append(textarea);

        return(textarea);
    },

    plugin: function(settings, original) {
      var self = this;

      settings.wysiwyg = $.extend({autoSave: false}, settings.wysiwyg);

      if (settings.wysiwyg) {
          $('textarea', self).wysiwyg(settings.wysiwyg);
      } else {
          $('textarea', self).wysiwyg();;
      }
    },

    submit : function(settings, original) {
        var iframe = $("iframe", this).get(0),
            inner_document = typeof(iframe.contentDocument) == 'undefined' ?  iframe.contentWindow.document.body : iframe.contentDocument.body,
            new_content = $(inner_document).html();

        $('textarea', this).val(new_content);
    }
});