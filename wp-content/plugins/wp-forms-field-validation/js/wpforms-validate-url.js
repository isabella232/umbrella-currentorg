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
        
        let errorMsg = '<label class="wpforms-error" id="' + errorID + '" style="display:none;">Please enter a valid YouTube URL (e.g. https://www.youtube.com/watch?v=ABCDEFGHIJK)</label>';

        $(errorMsg).insertAfter(input);

        // Validate URL format on change
        $(input).blur(function () {
          if ($(input).val().includes('youtube')) {
            validateYouTubeUrl($(input), errorID);
          }
        });
      }

    });

  }

  function validateYouTubeUrl(val, error) {    
    var url = $(val).val();
    error = '#' + error;

    if (url != undefined || url != '') {        
        var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/;
        var match = url.match(regExp);
        if (match && match[2].length == 11) {
          // Validity check - leave empty if no action needed
          $(error).hide();
        } else {
          // Display error on invalid URL
          $(error).show();
        }
    }
  }

  function validateVimeoURL() {
    var VIMEO_BASE_URL = "https://vimeo.com/api/oembed.json?url=";
    var yourTestUrl = "https://vimeo.com/23374724";

    $.ajax({
      url: VIMEO_BASE_URL + yourTestUrl,
      type: 'GET',
      success: function(data) {
        if (data != null && data.video_id > 0) {
          // Valid Vimeo url
        } else {
          // not a valid Vimeo url
        }
      },
      error: function(data) {
        // not a valid Vimeo url
      }
    });
  }

});