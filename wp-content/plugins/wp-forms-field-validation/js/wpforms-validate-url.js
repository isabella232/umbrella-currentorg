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
        // Validate URL format on change
        $(input).on('input', function () {
          let val = $(input).val();
          if (val.includes('youtube')) {
            validateYouTubeUrl(val, input);
          } else if (val.includes('vimeo')) {
            validateVimeoURL(val, input);
          }
        });
      }

    });

  }

  function validateYouTubeUrl(url, el) {    

    if (url != undefined || url != '') {        
        var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/;
        var match = url.match(regExp);
        if (match && match[2].length == 11) {
          // Validity check - leave empty if no action needed
          $('#wpformsValidateError').hide();
        } else {
          // Display error on invalid URL
          validateError(url, el);
        }
    }
  }

  function validateVimeoURL(url, el) {
    var VIMEO_BASE_URL = "https://vimeo.com/api/oembed.json?url=";
    var testUrl = url;

    $.ajax({
      url: VIMEO_BASE_URL + testUrl,
      type: 'GET',
      success: function(data) {
        if (data != null && data.video_id > 0) {
          // Valid Vimeo url
          $('#wpformsValidateError').hide();
        } 
      },
      error: function(data) {
        // not a valid Vimeo url
        validateError(url, el);
      }
    });
  }

  function validateError(data, el) {

    let urlType, exampleUrl;

    if (data.includes('youtube')) {
      urlType = 'youtube';
      exampleUrl = 'https://www.youtube.com/watch?v=ABCDEFGHIJK';
    } else if (data.includes('vimeo')) {
      urlType = 'vimeo';
      exampleUrl = 'https:www.vimeo.com/12345678';
    }

    let errorMsg = '<label class="wpforms-error" id="wpformsValidateError">Please enter a valid ' + urlType + ' URL (e.g. ' + exampleUrl + ')</label>';
    $('#wpformsValidateError').remove();
    $(errorMsg).insertAfter(el);
    $(errorMsg).show();
  }

});