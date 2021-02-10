// Validate URL fields that include video links

$ = jQuery;

$(function () {

  // Check if page contains WP Form
  if ($('.wpforms-container').length) {

    $('.wpforms-field-url').each(function () {
      
      let label = $(this).find('label');
      let el = $(this);

      label = label.text().toLowerCase();

      if ( label.includes('video')) {

        // Find input field (only if URL)
        let input = $(this).find('input[type="url"');
        let inputID = $(input).attr('id');
        let errorID = inputID + '-videoURL-error';
        
        let errorMsg = '<label class="wpforms-error" id="' + errorID + '" style="display:none;">Please enter a valid Youtube URL</label>';

        $(errorMsg).appendTo(el);

        // Validate URL format on change
        $(input).change(function () {

          validateYouTubeUrl($(input), errorID);

        });

      }

    });

  }

  function validateYouTubeUrl(val, error) {    
    var url = $(val).val();
    let error = $('#' + error);

    if (url != undefined || url != '') {        
        var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/;
        var match = url.match(regExp);
        if (match && match[2].length == 11) {
          // Validity check - leave empty if no action needed
          error.hide();
        } else {
          // Display error on invalid URL
          error.show();
        }
    }
  }

});